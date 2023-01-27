<?php

namespace App\Application\Controller;

use App\Infra\Repository\ServerRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class HomeController extends AbstractController
{
    public function __construct(ServerRepository $serverRepository)
    {
        dd($serverRepository->getAll());
    }

    #[Route]
    public function index(): Response
    {
        return new Response('working');
    }
}
