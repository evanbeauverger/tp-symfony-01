<?php

namespace App\Controller;

use App\Entity\Categorie;
use App\Form\CategoryType;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

final class CategoryController extends AbstractController
{
    private CategorieRepository $categoryRepository;
    private EntityManagerInterface $entityManager;
    private FormFactoryInterface $formFactory;

    public function __construct(CategorieRepository $categoryRepository, EntityManagerInterface $entityManager, FormFactoryInterface $formFactory)
    {
        $this->categoryRepository = $categoryRepository;
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
    }

    #[Route('/category/', name: 'app_category')]
    public function index(): Response
    {
        $categorys = $this->categoryRepository->findAll();

        return $this->render('category/index.html.twig', [
            'categorys' => $categorys,
        ]);
    }

    #[Route('/category/create', name: 'create_category')]
    public function create(Request $request): Response
    {
        $category = new Categorie();
        $form = $this->formFactory->create(CategoryType::class, $category);

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            dump($category);
            $this->entityManager->persist($category, true);
            $this->entityManager->flush();

            return $this->redirectToRoute('app_category');
        }

        return $this->render('game/create.html.twig', ['form' => $form->createView()]);
    }

    #[Route('category/edit/{id}', name: 'edit_category')]
    public function edit(Request $request, int $id): Response
    {   
        $category = $this->categoryRepository->find($id);
        if ($category) {
            $form = $this->formFactory->create(CategoryType::class, $category);

            $form->handleRequest($request);
            if ($form->isSubmitted() && $form->isValid()) {
                $this->entityManager->persist($category, true);
                $this->entityManager->flush();

                return $this->redirectToRoute('app_category');
            }

            return $this->render('category/edit.html.twig', ['form' => $form->createView()]);
        }
    }

    #[Route('category/delete/{id}', name: 'delete_category')]
    public function delete(int $id): Response
    {   
        $category = $this->categoryRepository->find($id);
        if ($category) {
            $this->entityManager->remove($category);
            $this->entityManager->flush();
            return $this->render('category/delete.html.twig');
        }
    }
}
