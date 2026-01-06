<?php

namespace App\Entity;

use App\Repository\ClientRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ClientRepository::class)]
class Client
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Assert\NotBlank(message: "Le nom est obligatoire.")]
    #[Assert\Length(
        min: 5,
        max: 20,
        minMessage: "Le nom doit contenir au moins {{ limit }} caractères.",
        maxMessage: "Le nom ne doit pas dépasser {{ limit }} caractères."
    )]
    #[Assert\Regex(
        message: "Le nom doit être une chaîne de caractères.",
        pattern: '/^[a-z]+$/i',
        htmlPattern: '^[a-zA-Z]+$'
    )]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $NAME = null;

    #[ORM\Column(length: 100)]
    #[Assert\NotBlank(message: "L'email est obligatoire.")]
    #[Assert\Email(message: "L'adresse email '{{ value }}' n'est pas valide.")]
    #[Assert\Length(
        max: 100,
        maxMessage: "L'email ne doit pas dépasser {{ limit }} caractères."
    )]
    private ?string $mail = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNAME(): ?string
    {
        return $this->NAME;
    }

    public function setNAME(string $NAME): static
    {
        $this->NAME = $NAME;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): static
    {
        $this->mail = $mail;

        return $this;
    }
}
