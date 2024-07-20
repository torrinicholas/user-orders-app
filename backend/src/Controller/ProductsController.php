<?php

namespace App\Controller;

use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class ProductsController extends AbstractController
{
  #[Route('/add/product', name: 'add_product', methods: 'POST')]
  public function create(EntityManagerInterface $entityManager, Request $request): Response
  {

    $name = $request->query->get('name');
    $price = $request->query->get('price');

    $product = new Products();
    $product->setName($name);
    $product->setPrice($price);

    $entityManager->persist($product);

    $entityManager->flush();

    $id = $product->getId();

    if (!$id) {
      return new Response(FALSE);
    }
    return new Response(TRUE);
  }

  #[Route('/get/product/{id}', name: 'show_product', methods: 'POST')]
  public function get(EntityManagerInterface $entityManager, int $id): Response
  {
    $product = $entityManager->getRepository(Products::class)->find($id);

    if (!$product) {
      throw $this->createNotFoundException(
        'No product found for id ' . $id
      );
    }

    return new Response($product->toJson());
  }

}
