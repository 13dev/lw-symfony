<?php

namespace App\Application\Controller;

use App\Infra\Adapter\SpreadsheetAdapter;
use App\Infra\Iterator\SpreadsheetIterator;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/')]
class HomeController extends AbstractController
{
    public function __construct(SpreadsheetAdapter $phpSpreadsheetAdapter)
    {
        dd($phpSpreadsheetAdapter);
    }

    #[Route]
    public function index(): Response
    {
        return new Response('working');
    }
}
