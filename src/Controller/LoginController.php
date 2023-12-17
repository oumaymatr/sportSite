<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Sport;
use App\Entity\users;
use App\Form\UserType;
use App\Form\InscriptionType;
use Doctrine\ORM\EntityManager;
use App\Repository\SportRepository;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class LoginController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }
    #[Route('/inscription', name: 'inscription')]
    public function inscription(Request $request, EntityManagerInterface $manager, SportRepository $sportRepository): Response
    {
        $sports = $this->entityManager->getRepository(Sport::class)->findAll();
        $sportChoices = [];
        foreach ($sports as $sport) {
            $sportChoices[$sport->getNom()] = $sport->getNom();
        }
    
        $user = new User();
        $form = $this->createForm(UserType::class, $user, ['sportChoices' => $sportChoices]);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer le nouveau sport saisi par l'utilisateur
            $nouveauSport = $form->get('sportPratiqueCustom')->getData();
    
            // Ajouter le nouveau sport à la liste des sports existants
            if (!empty($nouveauSport)) {
                // Vérifier si le sport existe déjà pour éviter les doublons
                $existingSport = $sportRepository->findOneBy(['nom' => $nouveauSport]);
                if (!$existingSport) {
                    $sport = new Sport();
                    $sport->setNom($nouveauSport);
                    $manager->persist($sport);
                    $manager->flush();
                    // Utiliser RedirectResponse pour rediriger vers la page d'inscription mise à jour
                    $route = $this->generateUrl('inscription');
                    $response = new RedirectResponse($route);
                    return $response;
                }
    
                // Enregistrer l'utilisateur avec le nouveau sport
                $user->setSportPratique($nouveauSport);
            }
    
            $niveauSelectionne = $form->get('niveau')->getData();
            if ($niveauSelectionne !== null) {
                // Enregistrer l'utilisateur avec la valeur de niveau
                $user->setNiveau($niveauSelectionne);
    
                // Enregistrer l'utilisateur
                $manager->persist($user);
                $manager->flush();
                 // Rediriger vers la page recherche.html.twig
                return $this->redirectToRoute('recherche');
            }         
        }
    
        return $this->render('inscription.html.twig', [
            'formHome' => $form->createView(),
        ]);
    }    
}
