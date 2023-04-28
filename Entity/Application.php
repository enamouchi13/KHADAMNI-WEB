<?php

namespace App\Entity;

use Symfony\Component\HttpFoundation\File\File;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ApplicationRepository;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * Application
 *
 * @ORM\Table(name="application", indexes={@ORM\Index(name="id_user", columns={"id_user"})})
 * @ORM\Entity(repositoryClass=ApplicationRepository::class)
 */
class Application
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
     * @var int
     *
     * @ORM\Column(name="num", type="bigint", nullable=false)
     * @Assert\NotBlank(message="You need to fill this")
     * @Assert\Length(
     *      min = 8,
     *      max = 8,
     *      minMessage = "Numero du Telephone Non Valide",
     *      maxMessage = "TNumero du Telephone Non Valide"
     * )
     */
    private $num;

    /**
     * @var string
     * 
     * @ORM\Column(name="role", type="string", length=255, nullable=false)
     * @Assert\NotBlank(message="You need to fill this")
     */
    private $role;

    /**
     * @var string|null
     *
     * @ORM\Column(name="location", type="string", length=255, nullable=true, options={"default"="NULL"})
     */
    private $location = 'NULL';

    /**
     * @var \Symfony\Component\HttpFoundation\File\File|null
     * 
     * @ORM\Column(name="document", type="blob", nullable=false)
     */
    private $document;

    /**
     * @var \User
     *
     * @ORM\ManyToOne(targetEntity="User")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="id_user", referencedColumnName="id")
     * })
     */
    private $idUser;

    /**
     * Set document
     *
     * @param \Symfony\Component\HttpFoundation\File\File|null $document
     * @return self
     */
    protected $captchaCode;
    public function setDocument(?File $document): self
     {
     $this->document = $document ? file_get_contents($document->getPathname()) : null;
     return $this;
     }

    /**
     * Get document
     *
     * @return \Symfony\Component\HttpFoundation\File\File|null
     */
    public function getDocument(): ?File
     {
     if ($this->document) {
        $file = tempnam(sys_get_temp_dir(), 'doc');
        file_put_contents($file, $this->document);
        return new File($file);
     }
       return null;
     }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNum(): ?string
    {
        return $this->num;
    }

    public function setNum(string $num): self
    {
        $this->num = $num;

        return $this;
    }

    public function getRole(): ?string
    {
        return $this->role;
    }

    public function setRole(string $role): self
    {
        $this->role = $role;

        return $this;
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

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): self
    {
        $this->idUser = $idUser;
        return $this;
    }
    public function getCaptchaCode()
    {
      return $this->captchaCode;
    }

    public function setCaptchaCode($captchaCode)
    {
      $this->captchaCode = $captchaCode;
    }}