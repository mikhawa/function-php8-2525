<?php

namespace App\Controller;

use App\Entity\PhpFunction;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Doctrine\ORM\EntityManagerInterface;

final class HomepageController extends AbstractController{
    #[Route('/', name: 'homepage')]
    public function index(EntityManagerInterface $em): Response
    {

        $listephps = $em->getRepository(PhpFunction::class)
                     ->findBy([],['title'=>"ASC"]);

        return $this->render('homepage/index.html.twig', [
            'liste' => $listephps,
        ]);
    }

}
