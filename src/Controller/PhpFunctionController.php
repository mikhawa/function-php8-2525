<?php

namespace App\Controller;

use App\Entity\PhpFunction;
use App\Form\PhpFunction1Type;
use App\Repository\PhpFunctionRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/php/function')]
final class PhpFunctionController extends AbstractController
{
    #[Route(name: 'app_php_function_index', methods: ['GET'])]
    public function index(PhpFunctionRepository $phpFunctionRepository): Response
    {
        return $this->render('php_function/index.html.twig', [
            'php_functions' => $phpFunctionRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_php_function_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $phpFunction = new PhpFunction();
        $form = $this->createForm(PhpFunction1Type::class, $phpFunction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($phpFunction);
            $entityManager->flush();

            return $this->redirectToRoute('app_php_function_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('php_function/new.html.twig', [
            'php_function' => $phpFunction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_php_function_show', methods: ['GET'])]
    public function show(PhpFunction $phpFunction): Response
    {
        return $this->render('php_function/show.html.twig', [
            'php_function' => $phpFunction,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_php_function_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PhpFunction $phpFunction, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PhpFunction1Type::class, $phpFunction);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_php_function_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('php_function/edit.html.twig', [
            'php_function' => $phpFunction,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_php_function_delete', methods: ['POST'])]
    public function delete(Request $request, PhpFunction $phpFunction, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$phpFunction->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($phpFunction);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_php_function_index', [], Response::HTTP_SEE_OTHER);
    }
}
