<?php

namespace App\Entity;

use App\Repository\EtatOffreRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: EtatOffreRepository::class)]
#[ApiResource]
class EtatOffre {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptif = null;

    #[ORM\OneToMany(mappedBy: 'etatOffre', targetEntity: Offre::class)]
    private Collection $offres;

    public function __construct() {
        $this->offres = new ArrayCollection();
    }

    /**
     * Récupère l'id de l'objet EtatOffre
     * @return int|null Retourne l'id de l'objet EtatOffre
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * Récupère l'état de l'objet EtatOffre
     * @return string|null Retourne l'état de l'objet EtatOffre, null sinon
     */
    public function getEtat(): ?string {
        return $this->etat;
    }

    /**
     * Créer un état pour l'objet EtatOffre
     * @param string $etat Le paramètre prend le nom "$etat". C'est une valeur de type string
     * @return $this Retourne la valeur de $this
     */
    public function setEtat(string $etat): self {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Récupère le descriptif pour l'objet EtatOffre
     * @return string|null Retourne le desriptif de l'objet EtatOffre
     */
    public function getDescriptif(): ?string {
        return $this->descriptif;
    }

    /**
     * Créer un descriptif pour l'objet EtatOffre
     * @param string|null $descriptif Le paramètre prend le nom "$descriptif". C'est une valeur de type string
     * @return $this Retourne la valeur de $this
     */
    public function setDescriptif(?string $descriptif): self {
        $this->descriptif = $descriptif;

        return $this;
    }

    /**
     * Récupère une collection d'offre pour l'objet EtatOffre
     * @return Collection<int, Offre> Retourne une collection d'offre pour l'objet EtatOffre
     */
    public function getOffres(): Collection {
        return $this->offres;
    }

    /**
     * Ajoute une offre pour l'objet EtatOffre
     * @param Offre $offre Le paramètre prend le nom "$offre". C'est une valeur de type Offre
     * @return $this Retourne la valeur de $this
     */
    public function addOffre(Offre $offre): self {
        if (!$this->offres->contains($offre)) {
            $this->offres->add($offre);
            $offre->setEtatOffre($this);
        }

        return $this;
    }

    /**
     * Supprime une offre pour l'objet EtatOffre
     * @param Offre $offre Le paramètre prend le nom "$offre". C'est une valeur de type Offre
     * @return $this Retourne la valeur de $this
     */
    public function removeOffre(Offre $offre): self {
        if ($this->offres->removeElement($offre)) {
            // set the owning side to null (unless already changed)
            if ($offre->getEtatOffre() === $this) {
                $offre->setEtatOffre(null);
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
