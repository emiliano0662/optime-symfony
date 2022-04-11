<?php

namespace App\Entity;

use App\Repository\ProductRepository;
use Doctrine\ORM\Mapping as ORM;

use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=ProductRepository::class)
 * @UniqueEntity(
 *     fields={"code"},
 *     message="Este valor ya está en uso."
 * )
 * @UniqueEntity(
 *     fields={"name"},
 *     message="Este valor ya está en uso."
 * )
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(name="code", type="string", length=255, unique=true)
     * @Assert\NotBlank(
     *      message = "Este valor no debe estar en blanco.",
     * )
     * @Assert\Length(
     *      min = 4,
     *      max = 10,
     *      minMessage = "Este valor es demasiado corto. Debe tener {{ limit }} caracteres o más.",
     *      maxMessage = "Este valor es demasiado largo. Debe tener {{ limit }} caracteres o menos."
     * )
     * @Assert\Regex(
     *      pattern= "/^[A-Za-z0-9]*[\s]*$/u",
     *      match = true,
     *      message = "Este valor no es válido."
     * )
     */
    private $code;

    /**
     * @ORM\Column(name="name", type="string", length=255, unique=true)
     * @Assert\NotBlank(
     *      message = "Este valor no debe estar en blanco.",
     * )
     * @Assert\Length(
     *      min = 4,
     *      minMessage = "Este valor es demasiado corto. Debe tener {{ limit }} caracteres o más.",
     * )
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank(
     *      message = "Este valor no debe estar en blanco.",
     * )
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(
     *      message = "Este valor no debe estar en blanco.",
     * )
     */
    private $brand;

    /**
     * @ORM\ManyToOne(targetEntity=Category::class, inversedBy="products")
     * @Assert\NotBlank(
     *      message = "Este valor no debe estar en blanco.",
     * )
     */
    private $category;

    /**
     * @ORM\Column(type="float")
     * @Assert\NotBlank(
     *      message = "Este valor no debe estar en blanco.",
     * )
     * @Assert\Regex(
     *      pattern= "/^[\s]*\d{1,11}(\.\d{1,3})?$/",
     *      match = true,
     *      message = "Este valor no es válido."
     * )
     */
    private $price;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime_immutable")
     */
    private $updatedAt;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(string $code): self
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getBrand(): ?string
    {
        return $this->brand;
    }

    public function setBrand(string $brand): self
    {
        $this->brand = $brand;

        return $this;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(?Category $category): self
    {
        $this->category = $category;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(string $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(\DateTimeImmutable $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }
}
