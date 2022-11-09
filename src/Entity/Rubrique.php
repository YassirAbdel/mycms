<?php

namespace App\Entity;

use App\Repository\RubriqueRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Cocur\Slugify\Slugify;

#[ORM\Entity(repositoryClass: RubriqueRepository::class)]
class Rubrique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'text', nullable: true)]
    private $resume;

    #[ORM\OneToMany(mappedBy: 'rubrique', targetEntity: Sousrubrique::class)]
    private $sousrubriques;

    #[ORM\ManyToOne(targetEntity: Dossier::class, inversedBy: 'rubriques')]
    private $dossier;

    #[ORM\OneToMany(mappedBy: 'rubrique', targetEntity: Texte::class)]
    private $textes;

    public function __construct()
    {
        $this->sousrubriques = new ArrayCollection();
        $this->textes = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getTitre();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitre(): ?string
    {
        return $this->titre;
    }

    public function setTitre(string $titre): self
    {
        $this->titre = $titre;

        return $this;
    }

    public function getResume(): ?string
    {
        return $this->resume;
    }

    public function setResume(?string $resume): self
    {
        $this->resume = $resume;

        return $this;
    }

    /**
     * @return Collection<int, Sousrubrique>
     */
    public function getSousrubriques(): Collection
    {
        return $this->sousrubriques;
    }

    public function addSousrubrique(Sousrubrique $sousrubrique): self
    {
        if (!$this->sousrubriques->contains($sousrubrique)) {
            $this->sousrubriques[] = $sousrubrique;
            $sousrubrique->setRubrique($this);
        }

        return $this;
    }

    public function removeSousrubrique(Sousrubrique $sousrubrique): self
    {
        if ($this->sousrubriques->removeElement($sousrubrique)) {
            // set the owning side to null (unless already changed)
            if ($sousrubrique->getRubrique() === $this) {
                $sousrubrique->setRubrique(null);
            }
        }

        return $this;
    }

    public function getDossier(): ?Dossier
    {
        return $this->dossier;
    }

    public function setDossier(?Dossier $dossier): self
    {
        $this->dossier = $dossier;

        return $this;
    }

    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->titre); 
    }

    /**
     * @return Collection<int, Texte>
     */
    public function getTextes(): Collection
    {
        return $this->textes;
    }

    public function addTexte(Texte $texte): self
    {
        if (!$this->textes->contains($texte)) {
            $this->textes[] = $texte;
            $texte->setRubrique($this);
        }

        return $this;
    }

    public function removeTexte(Texte $texte): self
    {
        if ($this->textes->removeElement($texte)) {
            // set the owning side to null (unless already changed)
            if ($texte->getRubrique() === $this) {
                $texte->setRubrique(null);
            }
        }

        return $this;
    }
}
