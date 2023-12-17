<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\UserRepository;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[NotBlank(message: "Please enter your name.")]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    #[Assert\Email()]
    private ?string $email = null;

    #[ORM\Column(length: 255)]
    private ?string $departement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sportPratique = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $sportPratiqueCustom = null;

    #[ORM\Column(length: 255)]
    private ?string $niveau = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): static
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    public function setDepartement(string $departement): static
    {
        $this->departement = $departement;

        return $this;
    }

    public function getSportPratique(): ?string
    {
        return $this->sportPratique;
    }

    public function setSportPratique(?string $sportPratique): static
    {
        $this->sportPratique = $sportPratique;

        return $this;
    }

    public function getSportPratiqueCustom(): ?string
    {
        return $this->sportPratiqueCustom;
    }

    public function setSportPratiqueCustom(?string $sportPratiqueCustom): static
    {
        $this->sportPratiqueCustom = $sportPratiqueCustom;

        return $this;
    }

    public function getNiveau(): ?string
    {
        return $this->niveau;
    }

    public function setNiveau(string $niveau): static
    {
        $this->niveau = $niveau;

        return $this;
    }
}
