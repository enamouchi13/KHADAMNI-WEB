<?php

namespace App\Entity;

use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ServiceRepository;
use Symfony\Component\Validator\Constraints as Assert;
/**
 * Service
 *
 * @ORM\Table(name="service", indexes={@ORM\Index(name="id_client", columns={"id_client"}), @ORM\Index(name="ouvrier_id", columns={"ouvrier_id"})})
* @ORM\Entity(repositoryClass=ServiceRepository::class)
 * 
 */
class Service
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
     * @var string|null
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=true, options={"default"="NULL"})
    
     */
    private $location = '';

    /**
     * @var string|null
     *
     * @ORM\Column(name="servicename", type="string", length=255, nullable=true, options={"default"="NULL"})
       
     */
    private $servicename = '';

    /**
     * @var int
     *
     * @ORM\Column(name="client_phone", type="bigint", nullable=false)
      * @Assert\Length(
     *      min = 8,
     *      max = 8,
     *      minMessage = "Numero du Telephone Non Valide",
     *      maxMessage = "Numero du Telephone Non Valide"
     * )
     */
    private $clientPhone;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_client", referencedColumnName="id")
     * })
     */
    private $idClient;

    /**
     * @var \Application
     *
     * @ORM\ManyToOne(targetEntity="Application")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="ouvrier_id", referencedColumnName="id")
     * })
     */
    private $ouvrier;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLocation(): ?string
    {
        return $this->location;
    }

    public function setLocation(?string $location): self
    {
        $this->location = $location;

        return $this;
    }

    public function getServicename(): ?string
    {
        return $this->servicename;
    }

    public function setServicename(?string $servicename): self
    {
        $this->servicename = $servicename;

        return $this;
    }

    public function getClientPhone(): ?string
    {
        return $this->clientPhone;
    }

    public function setClientPhone(string $clientPhone): self
    {
        $this->clientPhone = $clientPhone;

        return $this;
    }

    public function getIdClient(): ?User
    {
        return $this->idClient;
    }

    public function setIdClient(?User $idClient): self
    {
        $this->idClient = $idClient;

        return $this;
    }

    public function getOuvrier(): ?Application
    {
        return $this->ouvrier;
    }

    public function setOuvrier(?Application $ouvrier): self
    {
        $this->ouvrier = $ouvrier;

        return $this;
    }


}
