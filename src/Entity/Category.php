<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\CategoryRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: CategoryRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/category/{id}',
            requirements: ['id' => '\d+'],
            normalizationContext: ['groups' => 'category:item']),
        new GetCollection(
            uriTemplate: '/category',
            normalizationContext: ['groups' => 'category:list']),
        new Post(
            uriTemplate: '/category',
            status: 301
        )
    ],
    order: ['id' => 'ASC', 'label' => 'ASC'],
    paginationEnabled: true
)]
class Category
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50, unique: true)]
    #[GROUPS(["user:books", "category:item", "category:list", "book:item", "book:list"])]
    private ?string $label = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLabel(): ?string
    {
        return $this->label;
    }

    public function setLabel(string $label): static
    {
        $this->label = $label;

        return $this;
    }
}
