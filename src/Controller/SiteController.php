<?php

namespace App\Controller;

use App\Entity\User;
use App\Entity\Sport;
use App\Entity\EmailForm;
use App\Form\EmailFormType;
use Doctrine\Persistence\ObjectManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SiteController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route("/", name: "home")]
    public function index(Request $request): Response
    {
        $form = $this->createForm(EmailFormType::class);
        $form->handleRequest($request);
        $sports = $this->entityManager->getRepository(Sport::class)->findAll();
        if ($form->isSubmitted() && $form->isValid()) {
            $email = $form->get('email')->getData();
    
            $user = $this->entityManager->getRepository(User::class)->findOneBy(['email' => $email]);

            if ($user) {
                // Email exists
                return $this->render('welcome.html.twig', [
                    'user' => $user,
                ]);
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
    public function recherche()
    {
        return $this->render('recherche.html.twig');
    }
   
}
