<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Sport;
use App\Entity\EmailForm;
use App\Entity\Search;
use App\Form\EmailFormType;
use App\Form\SearchType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class SiteController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route("/", name: "home")]
    public function index(Request $request, SessionInterface $session): Response
{
    $form = $this->createForm(EmailFormType::class);
    $form->handleRequest($request);
    $sports = $this->entityManager->getRepository(Sport::class)->findAll();

    if ($form->isSubmitted() && $form->isValid()) {
        $email = $form->get('email')->getData();

        $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

        if ($user) {
            // Email exists
            $session->set('user_data', [
                'user_nom' => $user->getNom(),
                'user_prenom' => $user->getPrenom(),
                'user_departement' => $user->getDepartement(),
                'user_email' => $user->getEmail(),
            ]);

            $response = new RedirectResponse($this->generateUrl('welcome', ['preRemplir' => true]));
            $response->headers->setCookie(new Cookie('user_nom', $user->getNom()));
            $response->headers->setCookie(new Cookie('user_prenom', $user->getPrenom()));
            $response->headers->setCookie(new Cookie('user_departement', $user->getDepartement()));
            $response->headers->setCookie(new Cookie('user_email', $user->getEmail()));
            $response->send();
            return $response; 
            return $this->redirectToRoute('welcome');
        } else {
            // Email does not exist
            return $this->render('not_found.html.twig');
        }
    }

    return $this->render('index.html.twig', [
        'form' => $form->createView(),
        'sports' => $sports,
    ]);
}

   

    #[Route("/recherche", name: 'recherche')]
    public function recherche(Request $request)
    {
        $sports = $this->entityManager->getRepository(Sport::class)->findAll();
        $sportChoices = [];
        foreach ($sports as $sport) {
            $sportChoices[$sport->getNom()] = $sport->getNom();
        }
    
        $departements = $this->entityManager->getRepository(User::class)->findDistinctDepartements();
        $departementChoices = [];
        foreach ($departements as $departement) {
            $departementChoices[$departement['departement']] = $departement['departement'];
        }
    
        $form = $this->createForm(SearchType::class, null, [
            'sportChoices' => $sportChoices,
            'departementChoices' => $departementChoices,
        ]);

        $form->handleRequest($request);
        $users = [];

        if ($form->isSubmitted() && $form->isValid()) {
            // Récupérer les critères de recherche
            $searchCriteria = $form->getData();
    
            // Effectuer la recherche dans la base de données
            $users = $this->entityManager->getRepository(User::class)->findBySearchCriteria($searchCriteria);
        }

        return $this->render('recherche.html.twig', [
            'form' => $form->createView(),
            'sports' => $sports,
            'users' => $users,
            'formSubmitted' => $form->isSubmitted(),
        ]);
    }
   
    #[Route("/welcome", name: "welcome")]
    public function welcome(SessionInterface $session): Response
    {
        $user_data = $session->get('user_data') ?? null;

        return $this->render('welcome.html.twig', [
            'user' => $user_data,
        ]);
    }
}
