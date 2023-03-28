<?php

namespace App\Entity;

use App\Repository\EtatCandidatureRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: EtatCandidatureRepository::class)]
#[ApiResource]
class EtatCandidature {

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $etat = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $descriptif = null;

    #[ORM\OneToMany(mappedBy: 'etatCandidature', targetEntity: Candidature::class)]
    private Collection $candidatures;

    public function __construct() {
        $this->candidatures = new ArrayCollection();
    }

    /**
     * Récupère l'id de l'objet EtatCandidature
     * @return int|null Retourne l'id de l'objet EtatCandidature
     */
    public function getId(): ?int {
        return $this->id;
    }

    /**
     * Récupère l'état de l'objet EtatCandidature
     * @return string|null Retourne l'état de l'objet EtatCandidature
     */
    public function getEtat(): ?string {
        return $this->etat;
    }

    /**
     * Créer un état pour l'objet EtatCandidature
     * @param string $etat Le paramètre prend le nom "$etat". C'est une valeur de type string
     * @return $this Retourne la valeur de $this
     */
    public function setEtat(string $etat): self {
        $this->etat = $etat;

        return $this;
    }

    /**
     * Récupère le descriptif pour l'objet EtatCandidature
     * @return string|null Retourne le desriptif de l'objet EtatCandidature
     */
    public function getDescriptif(): ?string {
        return $this->descriptif;
    }

    /**
     * Créer un descriptif pour l'objet EtatCandidature
     * @param string|null $descriptif Le paramètre prend le nom "$descriptif". C'est une valeur de type string
     * @return $this Retourne la valeur de $this
     */
    public function setDescriptif(?string $descriptif): self {
        $this->descriptif = $descriptif;

        return $this;
    }

    /**
     * Permet de donner une valeur sous forme de string
     * @return string Retourne une valeur au format string
     */
    public function __toString(): string {
        return $this->getEtat();
    }

    /**
     * Récupère une collection de candidature pour l'objet EtatCandidature
     * @return Collection<int, Candidature> Retourne une collection de candidature pour l'objet EtatCandidature
     */
    public function getCandidatures(): Collection
    {
        return $this->candidatures;
    }

    /**
     * Ajoute une candidature pour l'objet EtatCandidature
     * @param Candidature $candidature Le paramètre prend le nom "$candidature". C'est une valeur de type Candidature
     * @return $this Retourne la valeur de $this
     */
    public function addCandidature(Candidature $candidature): self
    {
        if (!$this->candidatures->contains($candidature)) {
            $this->candidatures->add($candidature);
            $candidature->setEtatCandidature($this);
        }

        return $this;
    }

    /**
     * Supprime une candidature pour l'objet EtatCandidature
     * @param Candidature $candidature Le paramètre prend le nom "$candidature". C'est une valeur de type Candidature
     * @return $this Retourne la valeur de $this
     */
    public function removeCandidature(Candidature $candidature): self
    {
        if ($this->candidatures->removeElement($candidature)) {
            // set the owning side to null (unless already changed)
            if ($candidature->getEtatCandidature() === $this) {
                $candidature->setEtatCandidature(null);
            }
        }

        return $this;
    }

}
