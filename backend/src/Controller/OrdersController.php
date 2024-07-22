<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Products;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\Proxy;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

class OrdersController extends AbstractController
{
  #[Route('/add_update/order', name: 'add_update_order', methods: 'PUT')]
  public function create(EntityManagerInterface $entityManager, Request $request): Response
  {
    $body = $request->getContent();
    if (!$body) {
      return new Response(FALSE);
    }
    $body = json_decode($body, TRUE);
    $name = $body['name'];
    $description = $body['description'];
    $date = $body['date'];

    $id = array_key_exists('order_id', $body) ? $body['order_id'] : NULL;

    if ($id) {
      $order = $entityManager->getRepository(Order::class)->find($id);
    } else {
      $order = new Order();
    }
    $order->setName($name);
    $order->setDescription($description);

    $date = date_create_from_format('Y-m-d', $date);
    $order->setDate($date);

    $entityManager->persist($order);
    $entityManager->flush();

    $id = $order->getId();

    if (!$id) {
      return new Response(FALSE);
    }
    return new Response(TRUE);
  }

  #[Route('/get/order/{id}', name: 'show_order', methods: 'GET')]
  public function get(EntityManagerInterface $entityManager, int $id): Response
  {
    $order = $entityManager->getRepository(Order::class)->find($id);

    if (!$order) {
      throw $this->createNotFoundException(
        'No order found for id ' . $id
      );
    }

    return new Response($order->toJson());
  }

  #[Route('/get/all/orders', name: 'show_all_order', methods: 'GET')]
  public function getAll(EntityManagerInterface $entityManager): Response
  {
    $orders = $entityManager->getRepository(Order::class)->findAll();

    if (!$orders) {
      throw $this->createNotFoundException(
        'No order found for id '
      );
    }

    foreach ($orders as $order) {
      $content[] = $order->toArray();
    }

    $content = json_encode($content);

    return new Response($content);
  }

  #[Route('/delete/order/{id}', name: 'delete_order', methods: 'DELETE')]
  public function delete(EntityManagerInterface $entityManager, int $id): Response
  {
    $order = $entityManager->getRepository(Order::class)->find($id);

    if (!$order) {
      throw $this->createNotFoundException(
        'No order found for id ' . $id
      );
    }
    $entityManager->remove($order);
    $entityManager->flush();
    return new Response(TRUE);
  }

  #[Route('/get/products/by/order/{id}', name: 'get_products_by_order', methods: 'GET')]
  public function getProductsByOrder(EntityManagerInterface $entityManager, int $id): Response
  {
    $order = $entityManager->getRepository(Order::class)->find($id);

    if (!$order) {
      throw $this->createNotFoundException(
        'No order found for id ' . $id
      );
    }

    $products = $order->getProducts();

    $productsResponce = [];

    foreach ($products as $product) {
      $productsResponce[] = $product->toArray();
    }

    $productsResponce = json_encode($productsResponce);

    return new Response($productsResponce);
  }

  #[Route('/add/product/to/order/{id}', name: 'add_product_to_order', methods: 'PUT')]
  public function addProductToOrder(EntityManagerInterface $entityManager,  Request $request, int $id): Response
  {
    $order = $entityManager->getRepository(Order::class)->find($id);

    if (!$order) {
      throw $this->createNotFoundException(
        'No order found for id ' . $id
      );
    }

    $body = $request->getContent();
    if (!$body) {
      return new Response(FALSE);
    }
    $body = json_decode($body, TRUE);
    $idProduct = $body['id_product'];

    $product = $entityManager->getRepository(Products::class)->find($idProduct);

    if (!$product) {
      throw $this->createNotFoundException(
        'No product found for id ' . $idProduct
      );
    }

    $order->addProduct($product);
    $entityManager->persist($order);
    $entityManager->flush();

    return new Response(TRUE);
  }

  #[Route('/delete/product/to/order/{id}', name: 'delete_product_to_order', methods: 'POST')]
  public function deleteProductToOrder(EntityManagerInterface $entityManager,  Request $request, int $id): Response
  {
    $order = $entityManager->getRepository(Order::class)->find($id);

    if (!$order) {
      throw $this->createNotFoundException(
        'No order found for id ' . $id
      );
    }

    $body = $request->getContent();
    if (!$body) {
      return new Response(FALSE);
    }
    $body = json_decode($body, TRUE);
    $idProduct = $body['id_product'];

    $product = $entityManager->getRepository(Products::class)->find($idProduct);

    if (!$product) {
      throw $this->createNotFoundException(
        'No product found for id ' . $idProduct
      );
    }

    $order->removeProduct($product);
    $entityManager->persist($order);
    $entityManager->flush();

    return new Response(TRUE);
  }
}
