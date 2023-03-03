<?php

namespace App\Entity;

use App\Repository\CandidatureRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: CandidatureRepository::class)]
#[UniqueEntity(
    fields: ['compteEtudiant', 'offre'],
    errorPath: 'offre',
    message: 'Cet·te étudiant·e a déjà candidaté sur cette offre.',
)]
#[ApiResource]
class Candidature
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'candidatures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?CompteEtudiant $compteEtudiant = null;

    #[ORM\ManyToOne(inversedBy: 'candidatures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Offre $offre = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $typeAction = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateAction = null;

    #[ORM\ManyToOne(inversedBy: 'candidatures')]
    #[ORM\JoinColumn(nullable: false)]
    private ?EtatCandidature $etatCandidature = null;

    /**
     * Récupère l'id de l'objet Candidature
     * @return int|null Retourn l'id de la candidature, null sinon
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Récupère l'objet CompteEtudiant de l'objet Candidature
     * @return CompteEtudiant|null Retourne l'objet CompteEtudiant, sinon null
     */
    public function getCompteEtudiant(): ?CompteEtudiant
    {
        return $this->compteEtudiant;
    }

    /**
     * Créer un objet de CompteEtudiant pour l'objet Candidature
     * @param CompteEtudiant|null $compteEtudiant Le paramètre prend le nom "$compteEtudiant". Il est soit un objet CompteEtudiant ou null
     * @return $this Retourne la valeur de $this
     */
    public function setCompteEtudiant(?CompteEtudiant $compteEtudiant): self
    {
        $this->compteEtudiant = $compteEtudiant;

        return $this;
    }

    /**
     * Récupère l'objet Offre de l'objet Candidature
     * @return Offre|null Retourne la valeur de l'objet Offre, sinon null
     */
    public function getOffre(): ?Offre
    {
        return $this->offre;
    }

    /**
     * Créer l'objet Offre pour l'objet Candidature
     * @param Offre|null $offre Le paramètre prend le nom "$offre". Il est soit un objet Offre ou null
     * @return $this Retourne la valeur de $this
     */
    public function setOffre(?Offre $offre): self
    {
        $this->offre = $offre;

        return $this;
    }

    /**
     * Récupère un type d'action de l'objet Candidature
     * @return string|null Retourne un valeur string, ou null
     */
    public function getTypeAction(): ?string
    {
        return $this->typeAction;
    }

    /**
     * Créer une valeur string pour l'objet Candidature
     * @param string|null $typeAction Le paramètre prend le nom "$typeAction". Il est soit une valeur de type string ou null
     * @return $this Retourne la valeur de $this
     */
    public function setTypeAction(?string $typeAction): self
    {
        $this->typeAction = $typeAction;

        return $this;
    }

    /**
     * Récupère l'objet DateTimeInterface de l'objet Candidature
     * @return \DateTimeInterface|null Retourne la valeur d'un objet DateTimeInterface, null sinon
     */
    public function getDateAction(): ?\DateTimeInterface
    {
        return $this->dateAction;
    }

    /**
     * Créer un objet de DateTimeInterface pour l'objet Candidature
     * @param \DateTimeInterface $dateAction Le paramètre prend le nom "$dateAction". Il est soit un objet DateTimeInterface ou null
     * @return $this Retourne la valeur de $this
     */
    public function setDateAction(\DateTimeInterface $dateAction): self
    {
        $this->dateAction = $dateAction;

        return $this;
    }

    /**
     * Récupère la valeur de l'objet EtatCandidature de l'objet Candidature
     * @return EtatCandidature|null Retourne un objet EtatCandidature, null sinon
     */
    public function getEtatCandidature(): ?EtatCandidature
    {
        return $this->etatCandidature;
    }

    /**
     * Créer un objet de EtatCandidature pour l'objet Candidature
     * @param EtatCandidature|null $etatCandidature Le paramètre prend le nom "$etatCandidature". Il est soit un objet EtatCandidature ou null
     * @return $this Retourne la valeur de $this
     */
    public function setEtatCandidature(?EtatCandidature $etatCandidature): self
    {
        $this->etatCandidature = $etatCandidature;

        return $this;
    }
}
