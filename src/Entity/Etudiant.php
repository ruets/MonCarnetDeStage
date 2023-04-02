<?php

namespace App\Entity;

use App\Repository\EtudiantRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: EtudiantRepository::class)]
#[ApiResource]
class Etudiant {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 11)]
    private ?string $numeroINE = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255)]
    private ?string $email = null;

    public function __construct() {
    }

    /**
     * Récupère l'id de l'objet Etudiant
     * @return int|null Retourne l'id de l'objet Etudiant
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * Récupère un numéro INE pour l'ojet Etudiant
     * @return string|null Retourne un numéro INE, null sinon
     */
    public function getNumeroINE(): ?string {
        return $this->numeroINE;
    }

    /**
     * Créer un numéro INE pour l'objet Etudiant
     * @param string $numeroINE Le paramètre prend le nom "$numeroINE". C'est une valeur de type string
     * @return $this Retourne la valeur de $this
     */
    public function setNumeroINE(string $numeroINE): self {
        $this->numeroINE = $numeroINE;

        return $this;
    }

    /**
     * Récupère le nom pour l'objet Etudiant
     * @return string|null Retourne le nom de l'objet Etudiant, null sinon
     */
    public function getNom(): ?string {
        return $this->nom;
    }

    /**
     * Créer le nom pour l'objet Etudidant
     * @param string $nom Le paramètre prend le nom "$nom". C'est une valeur de type string
     * @return $this Retourne la valeur de $this
     */
    public function setNom(string $nom): self {
        $this->nom = $nom;

        return $this;
    }

    /**
     * Récupère le prénom pour l'objet Etudiant
     * @return string|null Retourne le prénom de l'objet Etudiant, null sinon
     */
    public function getPrenom(): ?string {
        return $this->prenom;
    }

    /**
     * Créer le prénom pour l'objet Etudidant
     * @param string $prenom Le paramètre prend le nom "$prenom". C'est une valeur de type string
     * @return $this Retourne la valeur de $this
     */
    public function setPrenom(string $prenom): self {
        $this->prenom = $prenom;

        return $this;
    }

    /**
     * Récupère l'email pour l'objet Etudiant
     * @return string|null Retourne l'email de l'objet Etudiant
     */
    public function getEmail(): ?string {
        return $this->email;
    }

    /**
     * Créer l'email pour l'objet Etudidant
     * @param string $email Le paramètre prend le nom "$email". C'est une valeur de type string
     * @return $this Retourne la valeur de $this
     */
    public function setEmail(string $email): self {
        $this->email = $email;

        return $this;
    }

    /**
     * Permet de donner une valeur sous forme de string
     * @return string Retourne une valeur au format string
     */
    public function __toString(): string {
        return $this->getNom() . ' ' . $this->getPrenom() . " (INE : " .
                $this->getNumeroINE() . ")";
    }

}
