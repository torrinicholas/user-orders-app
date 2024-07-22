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
  #[Route('/add_update/product', name: 'add_update_product', methods: 'PUT')]
  public function create(EntityManagerInterface $entityManager, Request $request): Response
  {
    $body = $request->getContent();
    if (!$body) {
      return new Response(FALSE);
    }
    $body = json_decode($body, TRUE);
    $name = $body['name'];
    $price = $body['price'];


    $id = array_key_exists('product_id', $body) ? $body['product_id'] : NULL;

    if ($id) {
      $product = $entityManager->getRepository(Products::class)->find($id);
    } else {
      $product = new Products();
    }
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

    return new Response($product->toJson());
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

    return new Response($content);
  }

  #[Route('/delete/product/{id}', name: 'delete_product', methods: 'DELETE')]
  public function delete(EntityManagerInterface $entityManager, int $id): Response
  {
    $product = $entityManager->getRepository(Products::class)->find($id);

    if (!$product) {
      throw $this->createNotFoundException(
        'No product found for id ' . $id
      );
    }
    $entityManager->remove($product);
    $entityManager->flush();
    return new Response(TRUE);
  }
}
