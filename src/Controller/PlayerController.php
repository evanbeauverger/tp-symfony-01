<?php

namespace App\Controller;

use App\Entity\Player;
use App\Repository\PlayerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use App\Form\PlayerType;

class PlayerController extends AbstractController
{
    private PlayerRepository $playerRepository;
    private EntityManagerInterface $entityManager;
    private FormFactoryInterface $formFactory;

    public function __construct(PlayerRepository $playerRepository, EntityManagerInterface $entityManager, FormFactoryInterface $formFactory)
    {
        $this->playerRepository = $playerRepository;
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
    }

    #[Route('player/delete/{id}', name: 'delete_player')]
    public function delete(int $id): Response
    {   
        $player = $this->playerRepository->find($id);
        if ($player) {
            $this->entityManager->remove($player);
            $this->entityManager->flush();
            return new Response('Player with id ' .$id. ' deleted');
        } else {
            return new Response('Player with id ' .$id. ' not found', 404);
        }
    }

    #[Route('/player/', name: 'app_player')]
    public function index(): Response
    {
        $players = $this->playerRepository->findAll();

        return $this->render('player/index.html.twig', [
            'players' => $players,
        ]);
    }

    #[Route('/player/create', name: 'create_player')]
    public function create(Request $request): Response
    {
        $player = new Player();
        $form = $this->formFactory->create(PlayerType::class, $player);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $this->entityManager->persist($player, true);

            return $this->redirectToRoute('game');
        }

        return $this->render('game/create.html.twig', ['form' => $form->createView()]);
    }

}