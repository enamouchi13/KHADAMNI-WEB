<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Categorie
 *
 * @ORM\Table(name="categorie")
 * @ORM\Entity
 */
class Categorie
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="fournisseur", type="string", length=255, nullable=false)
     */
    private $fournisseur;

    /**
     * @var string
     *
     * @ORM\Column(name="nomc", type="string", length=255, nullable=false)
     */
    private $nomc;

    /**
     * @var string
     *
     * @ORM\Column(name="usagepro", type="string", length=255, nullable=false)
     */
    private $usagepro;

    /**
     * @var string
     *
     * @ORM\Column(name="qualite", type="string", length=255, nullable=false)
     */
    private $qualite;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFournisseur(): ?string
    {
        return $this->fournisseur;
    }

    public function setFournisseur(string $fournisseur): self
    {
        $this->fournisseur = $fournisseur;

        return $this;
    }

    public function getNomc(): ?string
    {
        return $this->nomc;
    }

    public function setNomc(string $nomc): self
    {
        $this->nomc = $nomc;

        return $this;
    }

    public function getUsagepro(): ?string
    {
        return $this->usagepro;
    }

    public function setUsagepro(string $usagepro): self
    {
        $this->usagepro = $usagepro;

        return $this;
    }

    public function getQualite(): ?string
    {
        return $this->qualite;
    }

    public function setQualite(string $qualite): self
    {
        $this->qualite = $qualite;

        return $this;
    }


}
