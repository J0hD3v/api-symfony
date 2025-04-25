<?php

namespace App\Entity;

use ApiPlatform\Metadata\ApiResource;
use App\Repository\AuthorRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\GetCollection;
use ApiPlatform\Metadata\Post;
use Symfony\Component\Serializer\Annotation\Groups;

#[ORM\Entity(repositoryClass: AuthorRepository::class)]
#[ApiResource(
    operations: [
        new Get(
            uriTemplate: '/author/{id}',
            requirements: ['id' => '\d+'],
            normalizationContext: ['groups' => 'author:item']),
        new GetCollection(
            uriTemplate: '/author',
            normalizationContext: ['groups' => 'author:list']),
        new Post(
            uriTemplate: '/author',
            status: 301
        )
    ],
    order: ['id' => 'ASC', 'lastname' => 'ASC'],
    paginationEnabled: true
)]
class Author
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[GROUPS(["user:books", "author:item", "author:list", "book:item", "book:list"])]
    private ?string $firstname = null;

    #[ORM\Column(length: 50)]
    #[GROUPS(["user:books", "author:item", "author:list", "book:item", "book:list"])]
    private ?string $lastname = null;

    #[ORM\Column(length: 50, nullable: true)]
    private ?string $pseudo = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): static
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): static
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getPseudo(): ?string
    {
        return $this->pseudo;
    }

    public function setPseudo(?string $pseudo): static
    {
        $this->pseudo = $pseudo;

        return $this;
    }
}
