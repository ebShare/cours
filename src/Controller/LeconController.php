<?php

namespace App\Controller;

use App\Repository\LeconRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Lecon;
use App\Form\LeconType;
use Doctrine\ORM\EntityManagerInterface;

class LeconController extends AbstractController
{
    #[Route('/lecon', name: 'app_lecon')]
    public function index(
        LeconRepository $repository,
        PaginatorInterface $paginator,
        Request $request
    ): Response {
        $lecons = $paginator->paginate(
            $repository->findAll(),
            $request->query->getInt('page', 1, 10)
        );
        return $this->render('pages/lecon/index.html.twig', [
            'lecons' => $lecons,
        ]);
    }
    #[Route('/lecon/nouveau', 'lecon_new', methods: ['GET', 'POST'])]
    public function new(
        Request $request,
        EntityManagerInterface $manager
    ): Response {
        $lecon = new Lecon();
        $form = $this->createForm(LeconType::class, $lecon);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $lecon = $form->getData();
            $manager->persist($lecon);
            $manager->flush();

            return $this->redirectToRoute('app_lecon');
        }

        return $this->render('pages/lecon/new.html.twig', ['form' => $form,]);
    }
    #[Route('/lecon/edit/{id}', 'lecon_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        EntityManagerInterface $manager,
        Lecon $lecon
    ): Response {
        $form = $this->createForm(LeconType::class, $lecon);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $ingredient = $form->getData();

            //$manager-> persist($ingredient);
            $manager->flush();
            $this->addFlash(
                'success',
                'Vos changements ont été enregistrés'
            );

            return $this->redirectToRoute('app_lecon');
        }
        return $this->render('pages/lecon/edit.html.twig', ['form' => $form,]);
    }
}
