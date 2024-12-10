<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromotionRepository::class)]
class Promotion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 55)]
    private ?string $annee = null;

    #[ORM\Column]
    private ?int $nb_etudiant = null;

    #[ORM\ManyToOne]
    #[ORM\JoinColumn(nullable: false)]
    private ?Departement $department = null;

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

    public function getAnnee(): ?string
    {
        return $this->annee;
    }

    public function setAnnee(string $annee): static
    {
        $this->annee = $annee;

        return $this;
    }

    public function getNbEtudiant(): ?int
    {
        return $this->nb_etudiant;
    }

    public function setNbEtudiant(int $nb_etudiant): static
    {
        $this->nb_etudiant = $nb_etudiant;

        return $this;
    }

    public function getDepartment(): ?Departement
    {
        return $this->department;
    }

    public function setDepartment(?Departement $department): static
    {
        $this->department = $department;

        return $this;
    }
}
