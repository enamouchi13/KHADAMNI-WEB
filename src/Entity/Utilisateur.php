<?php

namespace App\Entity;
use Symfony\Component\Security\Core\User\UserInterface;
use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Email; 
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Core\Encoder\EncoderInterface;





#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]

class Utilisateur implements UserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    /**
 *  @Assert\NotBlank(message="Le champ cin est obligatoire")
 *  @Assert\Regex(
 *     pattern="/^\d{8}$/",
 *     message="Le champ cin doit contenir 8 chiffres."
 * )
 */
    private ?int $cin = null;
    

    #[ORM\Column(length: 60)]
    /** 
    *
     * @Assert\Type("string",message="The value {{ value }} is not a valid {{ type }}.")
     *    @Assert\NotBlank(message="Nom taille entre [3..20]")
     *  @Assert\Length(
     *      min = 3,
     *      max = 20,
     *      minMessage = "le nom doit etre superieur a  3  characters ",
     *      maxMessage = "le nom doit etre inferieur a  20  characters"
     * )
     *  @Assert\Regex(
     *     pattern="/^[a-zA-Z]+$/",
     *     message="Ce champ ne doit contenir que des caractères alphabétiques."
     * )
     *  
    */
    private ?string $nom = null;

    #[ORM\Column(length: 80)]
    /** 
    *
     * @Assert\Type("string",message="The value {{ value }} is not a valid {{ type }}.")
     *    @Assert\NotBlank(message="Nom taille entre [3..20]")
     *  @Assert\Length(
     *      min = 3,
     *      max = 20,
     *      minMessage = "le nom doit etre superieur a  3  characters ",
     *      maxMessage = "le nom doit etre inferieur a  20  characters"
     * )
     *  @Assert\Regex(
     *     pattern="/^[a-zA-Z]+$/",
     *     message="Ce champ ne doit contenir que des caractères alphabétiques."
     * )
     *  
    */
    private ?string $prenom = null;

    #[ORM\Column(length: 200)]
    #j'ai utilisé une expression reguliére 
   /**
 * @Assert\Regex(
 *     pattern="/^[a-zA-Z0-9._%+-]+@(gmail\.com|gmail\.fr|esprit\.tn)$/",
 *     message="Veuillez entrer une adresse email valide de Gmail ou Esprit"
 * )
 */
    private ?string $mail = null;

    
    #[ORM\Column(length: 220)]
     /**
     * @Assert\NotBlank(message="Le champ password est obligatoire")
     * @Assert\Length(
     *      min = 8,
     *      minMessage = "Le mot de passe doit comporter au moins {{ limit }} caractères"
     * )
     */
    private ?string $password = null;

    #[ORM\Column(length: 210)]
      /**
 *  @Assert\NotBlank(message="Le champ role est obligatoire")
 * )
 */
    private ?string $role = null;

    #[ORM\Column]
     /**
    * @Assert\Regex(
     *     pattern="/^\d{8}$/",
     *     message="Le numéro de téléphone doit contenir exactement 8 chiffres"
     * )
     */
 
    private ?int $tel = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Avis::class, cascade: ['remove'])]
    private Collection $avis;

   
    ##[ORM\Column(length: 240)]
   
    #private ?string $rest_token = null;
    

    /*public function getRestToken(): ?int
    {
       return $this->rest_token;
    }*/

    public function setRestToken(string $rest_token): self
    {
        $this->rest_token = $rest_token;
        return $this;
    }
    

    public function __construct()
    {
        $this->avis = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCin(): ?int
    {
        return $this->cin;
    }

    public function setCin(int $cin): self
    {
        $this->cin = $cin;

        return $this;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

   /* public function setPassword(string $password): self
    {
        $this->password = $password;
        return $this;
    }*/
//raj3haaaaaaaaaaaaaaaaaaaaaaaaaaaaaa baed
    /*private $encoder;

    public function setEncoder(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }
    
    public function setPassword(string $password): self
    {
        $this->password = $this->encoder->encodePassword($this, $password);
    
        return $this;
    }*/
    

    /*public function setEncoder(EncoderInterface $encoder): void
    {
        $this->encoder = $encoder;
    }

    public function setPassword(string $password): self
    {
        $this->password = $this->encoder->encodePassword($this, $password);

        return $this;
    }*/

    
    
    public function setPassword(string $password): self
    {
        $this->password = $password;

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

    public function getTel(): ?int
    {
        return $this->tel;
    }

    public function setTel(int $tel): self
    {
        $this->tel = $tel;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    


    

    public function getSalt(): ?string
    {
        // you *may* need a real salt depending on your encoder
        // see section on salt below
        return null;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }
    public function eraseCredentials(): void
    {
        // Cette méthode est appelée après l'authentification pour effacer les informations sensibles
        // telles que le mot de passe en clair. Cette méthode peut être laissée vide si vous ne voulez pas
        // effacer les informations sensibles.
    }

    /**
     * @return Collection<int, Avis>
     */
    public function getAvis(): Collection
    {
        return $this->avis;
    }

    public function addAvi(Avis $avi): self
    {
        if (!$this->avis->contains($avi)) {
            $this->avis->add($avi);
            $avi->setUser($this);
        }

        return $this;
    }

    public function removeAvi(Avis $avi): self
    {
        if ($this->avis->removeElement($avi)) {
            // set the owning side to null (unless already changed)
            if ($avi->getUser() === $this) {
                $avi->setUser(null);
            }
        }

        return $this;
    }
}
