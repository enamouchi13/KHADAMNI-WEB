<?php

namespace App\Entity;

use App\Repository\MaterielRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: MaterielRepository::class)]
class Materiel
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message:'le champ Nom ne doit pas etre  vide')]
    #[Assert\Length(
        min: 2,
        max: 255,
        minMessage: 'le champ Nom doit être au moins  {{ limit }} characteres ',
        maxMessage: 'le champ Nom ne doit pas depasser {{ limit }} characteres',
    )]
    private ?string $nomm = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:'le champ Prix ne doit pas etre  vide')]
    #[Assert\Positive( message : 'Prix doit etre positive')]

    private ?float $prix = null;

    #[ORM\Column]
    #[Assert\NotBlank(message:'le champ Quantité ne doit pas etre  vide')]
    #[Assert\Positive( message : 'Quantité doit etre positive')]
    private ?int $quantite = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $valabilite = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\ManyToOne(inversedBy: 'materiels')]
    private ?Categorie $categorie = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomm(): ?string
    {
        return $this->nomm;
    }

    public function setNomm(string $nomm): self
    {
        $this->nomm = $nomm;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getQuantite(): ?int
    {
        return $this->quantite;
    }

    public function setQuantite(int $quantite): self
    {
        $this->quantite = $quantite;

        return $this;
    }

    public function getValabilite(): ?\DateTimeInterface
    {
        return $this->valabilite;
    }

    public function setValabilite(\DateTimeInterface $valabilite): self
    {
        $this->valabilite = $valabilite;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }
}
