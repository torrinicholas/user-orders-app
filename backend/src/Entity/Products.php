<?php

namespace App\Entity;

use App\Repository\ProductsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductsRepository::class)]
class Products
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  private ?string $name = null;

  #[ORM\Column(type: Types::DECIMAL, precision: 10, scale: 2)]
  private ?string $price = null;

  /**
   * @var Collection<int, Order>
   */
  #[ORM\ManyToMany(targetEntity: Order::class, mappedBy: 'products')]
  private Collection $orders;

  public function __construct()
  {
    $this->orders = new ArrayCollection();
  }

  public function getId(): ?int
  {
    return $this->id;
  }

  public function getName(): ?string
  {
    return $this->name;
  }

  public function setName(string $name): static
  {
    $this->name = $name;

    return $this;
  }

  public function getPrice(): ?string
  {
    return $this->price;
  }

  public function setPrice(string $price): static
  {
    $this->price = $price;

    return $this;
  }

  /**
   * @return Collection<int, Order>
   */
  public function getOrders(): Collection
  {
    return $this->orders;
  }

  public function addOrder(Order $order): static
  {
    if (!$this->orders->contains($order)) {
      $this->orders->add($order);
      $order->addProduct($this);
    }

    return $this;
  }

  public function removeOrder(Order $order): static
  {
    if ($this->orders->removeElement($order)) {
      $order->removeProduct($this);
    }

    return $this;
  }

  public function toJson(): string
  {
    $productMap = [
      'id'    => $this->getId() ?? '',
      'name' => $this->getName() ?? '',
      'price' => $this->getPrice() ?? ''
    ];
    return json_encode($productMap);
  }
}
