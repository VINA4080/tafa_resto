<?php

namespace App\Controller;

use App\Repository\FoodRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class FoodsController extends AbstractController
{
    #[Route('/foods', name: 'app_foods')]
    public function index(FoodRepository $repository): Response
    {
        $food = $repository->findAll();
        return $this->render('pages/food/index.html.twig', [
            'food' => $food
        ]);
    }
}
