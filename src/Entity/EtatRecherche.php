<?php

namespace App\Entity;

use App\Repository\EtatRechercheRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: EtatRechercheRepository::class)]
#[ApiResource]
class EtatRecherche {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptif = null;

    #[ORM\OneToMany(mappedBy: 'etatRecherche', targetEntity: CompteEtudiant::class)]
    private Collection $comptesEtudiant;

    public function __construct() {
        $this->comptesEtudiant = new ArrayCollection();
    }

    /**
     * Récupère l'id de l'objet EtatRecherche
     * @return int|null Retourne l'id de l'objet EtatRecherche
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * Récupère l'état de l'objet EtatRecherche
     * @return string|null Retourne l'état de l'objet EtatRecherche, null sinon
     */
    public function getEtat(): ?string {
        return $this->etat;
    }

    /**
     * Créer un état pour l'objet EtatRecherche
     * @param string $etat Le paramètre prend le nom "$etat". C'est une valeur de type string
     * @return $this Retourne la valeur de $this
     */
    public function setEtat(string $etat): self {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Récupère le descriptif pour l'objet EtatRecherche
     * @return string|null Retourne le desriptif de l'objet EtatRecherche
     */
    public function getDescriptif(): ?string {
        return $this->descriptif;
    }

    /**
     * Créer un descriptif pour l'objet EtatRecherche
     * @param string|null $descriptif Le paramètre prend le nom "$descriptif". C'est une valeur de type string
     * @return $this Retourne la valeur de $this
     */
    public function setDescriptif(?string $descriptif): self {
        $this->descriptif = $descriptif;

        return $this;
    }

    /** Récupère une collection de compte étudiant pour l'objet EtatRecherche
     * @return Collection<int, CompteEtudiant> Retourne une collection de compte étudiant pour l'objet EtatRecherche
     */
    public function getComptesEtudiant(): Collection {
        return $this->comptesEtudiant;
    }


    /**
     * Ajoute un compte etudiant pour l'objet EtatOffre
     * @param CompteEtudiant $comptesEtudiant Le paramètre prend le nom "$offre". C'est une valeur de type CompteEtudiant
     * @return $this Retourne la valeur de $this
     */
    public function addComptesEtudiant(CompteEtudiant $comptesEtudiant): self {
        if (!$this->comptesEtudiant->contains($comptesEtudiant)) {
            $this->comptesEtudiant->add($comptesEtudiant);
            $comptesEtudiant->setEtatRecherche($this);
        }

        return $this;
    }

    /**
     * Supprime un compte etudiant pour l'objet EtatOffre
     * @param CompteEtudiant $comptesEtudiant Le paramètre prend le nom "$offre". C'est une valeur de type CompteEtudiant
     * @return $this Retourne la valeur de $this
     */
    public function removeComptesEtudiant(CompteEtudiant $comptesEtudiant): self {
        if ($this->comptesEtudiant->removeElement($comptesEtudiant)) {
            // set the owning side to null (unless already changed)
            if ($comptesEtudiant->getEtatRecherche() === $this) {
                $comptesEtudiant->setEtatRecherche(null);
            }
        }

        return $this;
    }

    /**
     * Permet de donner une valeur sous forme de string
     * @return string Retourne une valeur au format string
     */
    public function __toString(): string {
        return $this->getEtat();
    }

}
