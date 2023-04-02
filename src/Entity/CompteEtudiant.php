<?php

namespace App\Entity;

use App\Repository\CompteEtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\PersistentCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: CompteEtudiantRepository::class)]
#[ApiResource]
class CompteEtudiant implements UserInterface, PasswordAuthenticatedUserInterface {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $login = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 1)]
    private ?string $parcours = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $derniereConnexion = null;

    #[ORM\ManyToOne(inversedBy: 'comptesEtudiant')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EtatRecherche $etatRecherche = null;

    #[ORM\OneToOne(targetEntity: Etudiant::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?Etudiant $etudiant = null;

    #[ORM\OneToMany(mappedBy: 'compteEtudiant', targetEntity: OffreConsultee::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $offreConsultees;

    #[ORM\OneToMany(mappedBy: 'compteEtudiant', targetEntity: OffreRetenue::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $offreRetenues;

    #[ORM\OneToMany(mappedBy: 'compteEtudiant', targetEntity: Candidature::class, cascade: ['persist', 'remove'], orphanRemoval: true)]
    private Collection $candidatures;

    public function __construct() {
        $this->offresConsultees = new ArrayCollection();
        $this->offresRetenues = new ArrayCollection();
        $this->candidatures = new ArrayCollection();
        $this->offreConsultees = new ArrayCollection();
        $this->offreRetenues = new ArrayCollection();
    }

    /**
     * Récupère l'id de l'objet CompteEtudiant
     * @return int|null Retourne l'id du compte étudiant, null sinon
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * Récupère le login de l'objet CompteEtudiant
     * @return string|null Retourne le login du compte étudiant, null sinon
     */
    public function getLogin(): ?string {
        return $this->login;
    }

    /**
     * Créer le login de l'objet CompteEtudiant
     * @param string $login Le paramètre prend le nom "$login". C'est une valeur de type string
     * @return $this Retourne la valeur de $this
     */
    public function setLogin(string $login): self {
        $this->login = $login;

        return $this;
    }

    /**
     * Récupère le login de l'objet CompteEtudiant et le convertie en valeur de type string
     * @see UserInterface
     * @return string Retourne le login de l'objet CompteEtudiant
     */
    public function getUserIdentifier(): string {
        return (string) $this->login;
    }

    /**
     * Récupère le login de l'objet CompteEtudiant et le convertie en valeur de type string
     * @deprecated since Symfony 5.3, use getUserIdentifier instead
     * @return string Retourne le login de l'objet CompteEtudiant
     */
    public function getUsername(): string {
        return (string) $this->login;
    }

    /**
     * Récupère les role de l'objet CompteEtudiant
     * @see UserInterface
     * @return array_unique Retourne les rôles de l'objet CompteEtudiant
     */
    public function getRoles(): array {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    /**
     * Créer une liste de role pour l'objet CompteEtudiant
     * @param array $roles Le paramètre prend le nom "$roles". C'est un array
     * @return $this Retourne la valeur de $this
     */
    public function setRoles(array $roles): self {
        $this->roles = $roles;

        return $this;
    }

    /**
     * Récupère le mot passe de l'objet CompteEtudiant
     * @see PasswordAuthenticatedUserInterface
     * @return string Retourne le mot de passe de l'objet CompteEtudiant
     */
    public function getPassword(): string {
        return $this->password;
    }

    /**
     * Créer un mot de passe pour l'objet CompteEtudiant
     * @param string $password Le paramètre prend le nom "$password". C'est une valeur de type string
     * @return $this la valeur de $this
     */
    public function setPassword(string $password): self {
        $this->password = $password;

        return $this;
    }

    /**
     * Returning a salt is only needed, if you are not using a modern
     * hashing algorithm (e.g. bcrypt or sodium) in your security.yaml.
     *
     * @see UserInterface
     */
    public function getSalt(): ?string {
        return null;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials() {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    /**
     * Récupère le parcours pour l'objet CompteEtudiant
     * @return string|null Retourne une valeur de type string, null sinon
     **/
    public function getParcours(): ?string {
        return $this->parcours;
    }

    /**
     * Créer un parcours de type string pour l'objet CompteEtudiant
     * @param string $parcours Le paramètre prend le nom "$parcours". C'est une valeur de type string
     * @return $this Retourne la valeur de $this
     **/
    public function setParcours(string $parcours): self {
        $this->parcours = $parcours;

        return $this;
    }

    /**
     * Récupère la dernière connexion pour l'objet CmpteEtudiant
     * @return \DateTimeInterface|null Retourne un objet DateTimeInterface, null sinon
     */
    public function getDerniereConnexion(): ?\DateTimeInterface {
        return $this->derniereConnexion;
    }

    /**
     * Créer la dernière connexion pour l'objet CompteEtudiant
     * @param \DateTimeInterface|null $derniereConnexion Le paramètre prend le nom "$derniereConnexion". C'est une valeur de type DateTimeInterface ou null
     * @return $this Retourne la valeur de $this
     */
    public function setDerniereConnexion(?\DateTimeInterface $derniereConnexion): self {
        $this->derniereConnexion = $derniereConnexion;

        return $this;
    }

    /**
     * Récupère l'état de recherche pour l'objet CompteEtudiant
     * @return EtatRecherche|null Retourne un objet EtatRecherche, null sinon
     */
    public function getEtatRecherche(): ?EtatRecherche {
        return $this->etatRecherche;
    }

    /**
     * Créer un état de recherche pour l'objet CompteEtudiant
     * @param EtatRecherche|null $etatRecherche Le paramètre prend le nom "$etatRecherche". C'est une valeur de type EtatRecherche ou null
     * @return $this Retoune la valeur de $this
     */
    public function setEtatRecherche(?EtatRecherche $etatRecherche): self {
        $this->etatRecherche = $etatRecherche;

        return $this;
    }

    /**
     * Récupère l'objet Etudiant pour l'objet CompteEtudiant
     * @return Etudiant|null Retourne un objet Etudiant, null sinon
     */
    public function getEtudiant(): ?Etudiant
    {
        return $this->etudiant;
    }

    /**
     * Créer un objet Etudiant pour l'objet CompteEtudiant
     * @param Etudiant $etudiant Le paramètre prend le nom "$etudiant". C'est une valeur de type Etudiant
     * @return $this Retourne la valeur de $this
     */
    public function setEtudiant(Etudiant $etudiant): self
    {
        $this->etudiant = $etudiant;

        return $this;
    }

    /**
     * Permet de donner une valeur sous forme de string
     * @return string Retourne la valeur en string
     */
    public function __toString(): string {
        return $this->getUserIdentifier() . " (" . $this->getEtudiant()->getNom() 
                . " " . $this->getEtudiant()->getPrenom() . ")";
    }

    /** Récupère l'objet OffreConsultee pour l'objet CompteEtudiant
     * @return Collection<int, OffreConsultee> Retourne dans une collection l'objet OffreConsultee
     */
    public function getOffreConsultees(): Collection
    {
        return $this->offreConsultees;
    }

    /**
     * Ajoute une offre consultée a l'objet CompteEtudiant
     * @param OffreConsultee $offreConsultee Le paramètre prend le nom "$offreConsultee". C'est une valeur de type OffreConsultee
     * @return $this Retourne la valeur de $this
     */
    public function addOffreConsultee(OffreConsultee $offreConsultee): self
    {
        if (!$this->offreConsultees->contains($offreConsultee)) {
            $this->offreConsultees->add($offreConsultee);
            $offreConsultee->setCompteEtudiant($this);
        }

        return $this;
    }

    /**
     * Supprime une offre consultée pour l'objet CompteEtudiant
     * @param OffreConsultee $offreConsultee Le paramètre prend le nom "$offreConsultee". C'est une valeur de type OffreConsultee
     * @return $this Retourne la valeur de $this
     */
    public function removeOffreConsultee(OffreConsultee $offreConsultee): self
    {
        if ($this->offreConsultees->removeElement($offreConsultee)) {
            // set the owning side to null (unless already changed)
            if ($offreConsultee->getCompteEtudiant() === $this) {
                $offreConsultee->setCompteEtudiant(null);
            }
        }

        return $this;
    }

    /**
     * Récupère l'offre retenue pour l'objet CompteEtudiant
     * @return Collection<int, OffreRetenue> Retourne une collection d'offre retenue
     */
    public function getOffreRetenues(): Collection
    {
        return $this->offreRetenues;
    }

    /**
     * Ajoute une offre retenue a l'objet CompteEtudiant
     * @param OffreRetenue $offreRetenue Le paramètre prend le nom "$offreRetenue". C'est une valeur de type OffreRetenue
     * @return $this Retourne la valeur de $this
     */
    public function addOffreRetenue(OffreRetenue $offreRetenue): self
    {
        if (!$this->offreRetenues->contains($offreRetenue)) {
            $this->offreRetenues->add($offreRetenue);
            $offreRetenue->setCompteEtudiant($this);
        }

        return $this;
    }

    /**
     * Supprime une offre retenue pour l'objet CompteEtudiant
     * @param OffreRetenue $offreRetenue Le paramètre prend le nom "$offreRetenue". C'est une valeur de type OffreRetenue
     * @return $this Retourne la valeur de $this
     */
    public function removeOffreRetenue(OffreRetenue $offreRetenue): self
    {
        if ($this->offreRetenues->removeElement($offreRetenue)) {
            // set the owning side to null (unless already changed)
            if ($offreRetenue->getCompteEtudiant() === $this) {
                $offreRetenue->setCompteEtudiant(null);
            }
        }

        return $this;
    }

    /** Récupère les candidature pour l'objet CompteEtudiant
     * @return Collection<int, Candidature> Retourne une collection de candidatures
     */
    public function getCandidatures(): Collection
    {
        return $this->candidatures;
    }

    /**
     * Ajoute une candidature pour l'objet CompteEtudiant
     * @param Candidature $candidature Le paramètre prend le nom "$candidature". C'est une valeur de type Candidature
     * @return $this Retourne la valeur de $this
     */
    public function addCandidature(Candidature $candidature): self
    {
        if (!$this->candidatures->contains($candidature)) {
            $this->candidatures->add($candidature);
            $candidature->setCompteEtudiant($this);
        }

        return $this;
    }

    /**
     * Supprime une candidature pour l'objet CompteEtudiant
     * @param Candidature $candidature Le paramètre prend le nom "$candidature". C'est une valeur de type Candidature
     * @return $this Retourne la valeur de $this
     */
    public function removeCandidature(Candidature $candidature): self
    {
        if ($this->candidatures->removeElement($candidature)) {
            // set the owning side to null (unless already changed)
            if ($candidature->getCompteEtudiant() === $this) {
                $candidature->setCompteEtudiant(null);
            }
        }

        return $this;
    }
}
