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

  #[Route('/get/product/{id}', name: 'show_product', methods: 'GET')]
  public function get(EntityManagerInterface $entityManager, int $id): Response
  {
    $product = $entityManager->getRepository(Products::class)->find($id);

    if (!$product) {
      throw $this->createNotFoundException(
        'No product found for id ' . $id
      );
    }

    $content = $product->toJson();
    $status = 200;
    $headers = [
        'Content-Type' => 'text/plain',
        'Access-Control-Allow-Origin' => '*', // Permette richieste da qualsiasi origine
        'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS', // Metodi HTTP permessi
        'Access-Control-Allow-Headers' => 'Content-Type, Authorization', // Intestazioni HTTP permessi
    ];

    return new Response($content, $status, $headers );
  }

  #[Route('/get/all/product', name: 'show_all_product', methods: 'GET')]
  public function getAll(EntityManagerInterface $entityManager): Response
  {
    $products = $entityManager->getRepository(Products::class)->findAll();

    if (!$products) {
      throw $this->createNotFoundException(
        'No product found for id '
      );
    }

    foreach ($products as $product) {
      $content[] = $product->toArray();
    }

    $content = json_encode($content);

    $status = 200;
    $headers = [
        'Content-Type' => 'text/plain',
        'Access-Control-Allow-Origin' => '*', // Permette richieste da qualsiasi origine
        'Access-Control-Allow-Methods' => 'GET, POST, PUT, DELETE, OPTIONS', // Metodi HTTP permessi
        'Access-Control-Allow-Headers' => 'Content-Type, Authorization', // Intestazioni HTTP permessi
    ];

    return new Response($content, $status, $headers);
  }

}
