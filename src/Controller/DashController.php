<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


class DashController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function red(): Response
    {
        return $this->redirectToRoute('app_dash');
    }
    #[Route('/user', name: 'app_dash')]
    public function index(): Response
    {
        return $this->render('dash/index.html.twig', [
            'controller_name' => 'DashController',
        ]);
    }
}
