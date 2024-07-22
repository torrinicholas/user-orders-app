<?php

namespace App\Controller;

use App\Entity\Order;
use Doctrine\ORM\EntityManagerInterface;
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
}
