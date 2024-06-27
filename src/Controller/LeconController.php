<?php

namespace App\Controller;

use App\Repository\LeconRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;

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
}
