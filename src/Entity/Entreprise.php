<?php

namespace App\Entity;

use App\Repository\EntrepriseRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: EntrepriseRepository::class)]
#[ApiResource]
class Entreprise
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $raisonSociale = null;

    #[ORM\Column(length: 255)]
    private ?string $ville = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pays = null;

    #[ORM\OneToMany(mappedBy: 'entreprise', targetEntity: Offre::class, cascade: ['persist'], orphanRemoval: true)]
    private Collection $offres;

    public function __construct()
    {
        $this->offres = new ArrayCollection();
    }

    /** Récupère l'id de l'objet Entreprise
     * @return int|null Retourne l'id de l'objet Entrprise, null sinon
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /** Récuprère la raison Sociale pour l'objet Entreprise
     * @return string|null Retourne une raison sociale pour l'objet Entreprise, null sinon
     */
    public function getRaisonSociale(): ?string
    {
        return $this->raisonSociale;
    }

    /**
     * Créer une raison sociale pour l'objet Entreprise
     * @param string $raisonSociale Le paramètre prend le nom "$raisonSociale". C'est une valeur de type string
     * @return $this Retourne la valeur de $this
     */
    public function setRaisonSociale(string $raisonSociale): self
    {
        $this->raisonSociale = $raisonSociale;

        return $this;
    }

    /**
     * Récupère la ville de l'objet Entrprise
     * @return string|null Retourne la ville de l'objet Entreprise
     */
    public function getVille(): ?string
    {
        return $this->ville;
    }

    /**
     * @param string $ville Le paramètre prend le nom "$ville". C'est une valeur de type string
     * @return $this Retourne la valeur de $this
     */
    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    /**
     * Récupère le pays pour l'objet Entreprise
     * @return string|null Retourne le pays de l'objet Entreprise
     */
    public function getPays(): ?string
    {
        return $this->pays;
    }

    /**
     * Créer un pays pour l'objet Entreprise
     * @param string|null $pays Le paramètre prend le nom "$pays". C'est une valeur de type string
     * @return $this Retourne la valeur de $this
     */
    public function setPays(?string $pays): self
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * Récupère les offres pour l'objet Entreprise
     * @return Collection<int, Offre> Retourne une collections d'offre pour l'objet Entreprise
     */
    public function getOffres(): Collection
    {
        return $this->offres;
    }

    /**
     * Ajoute une offre pour l'objet Entreprise
     * @param Offre $offre Le paramètre prend le nom "$offre". C'est une valeur de type Offre
     * @return $this Récupère la valeur de $this
     */
    public function addOffre(Offre $offre): self
    {
        if (!$this->offres->contains($offre)) {
            $this->offres->add($offre);
            $offre->setEntreprise($this);
        }

        return $this;
    }

    /**
     * Supprime une offre pour l'objet Entreprise
     * @param Offre $offre Le paramètre prend le nom "$offre". C'est une valeur de type Offre
     * @return $this Récupère la valeur de $this
     */
    public function removeOffre(Offre $offre): self
    {
        if ($this->offres->removeElement($offre)) {
            // set the owning side to null (unless already changed)
            if ($offre->getEntreprise() === $this) {
                $offre->setEntreprise(null);
            }
        }

        return $this;
    }

    /**
     * Permet de donner une valeur sous forme de string
     * @return string|null Retourne une valeur au format string
     */
    public function __toString() {
        return $this->getRaisonSociale();
    }
}
