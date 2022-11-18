<?php

namespace App\Controller;

use App\Entity\Food;
use App\Entity\Command;
use App\Form\CommandType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

class CommandController extends AbstractController
{
    #[Route('/command', name: 'app_command')]
    public function index(): Response
    {
        return $this->render('command/index.html.twig', [
            'controller_name' => 'CommandController',
        ]);
    }

    #[Route('/food/{id}', name: 'app_command_show', methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_USER')]
    public function show(Request $request, Food $food, EntityManagerInterface $manager): Response
    {
       $command = new  Command();

        $form = $this->createForm(CommandType::class, $command);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $command->setUser($this->getUser());

            $command->setFood($food);

            $food->setQuantity($food->getQuantity() - $command->getQuantity());

            $command->setPrice($command->getQuantity() * $food->getPrice());

            $manager->persist($command);
            $manager->persist($food);

            $manager->flush();

            $this->redirectToRoute('app_foods');
        }

        return $this->render('command/index.html.twig', [
            'form' => $form->createView(),
            'food' => $food
            
        ]);
    }
}
