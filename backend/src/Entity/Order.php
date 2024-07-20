<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
  #[ORM\Id]
  #[ORM\GeneratedValue]
  #[ORM\Column]
  private ?int $id = null;

  #[ORM\Column(length: 255)]
  private ?string $name = null;

  #[ORM\Column(type: Types::TEXT, nullable: true)]
  private ?string $description = null;

  #[ORM\Column(type: Types::DATETIME_MUTABLE)]
  private ?\DateTimeInterface $date = null;

  /**
   * @var Collection<int, Products>
   */
  #[ORM\ManyToMany(targetEntity: Products::class, inversedBy: 'orders')]
  private Collection $products;

  public function __construct()
  {
    $this->products = new ArrayCollection();
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

  public function getDescription(): ?string
  {
    return $this->description;
  }

  public function setDescription(?string $description): static
  {
    $this->description = $description;

    return $this;
  }

  public function getDate(): ?\DateTimeInterface
  {
    return $this->date;
  }

  public function setDate(\DateTimeInterface $date): static
  {
    $this->date = $date;

    return $this;
  }

  /**
   * @return Collection<int, Products>
   */
  public function getProducts(): Collection
  {
    return $this->products;
  }

  public function addProduct(Products $product): static
  {
    if (!$this->products->contains($product)) {
      $this->products->add($product);
    }

    return $this;
  }

  public function removeProduct(Products $product): static
  {
    $this->products->removeElement($product);

    return $this;
  }
}
