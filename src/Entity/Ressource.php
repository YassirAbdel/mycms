<?php

namespace App\Entity;

use App\Repository\RessourceRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RessourceRepository::class)]
class Ressource
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $langue;

    #[ORM\Column(type: 'text', nullable: true)]
    private $commentaire;

    #[ORM\Column(type: 'text', nullable: true)]
    private $personne;

    #[ORM\Column(type: 'text', nullable: true)]
    private $oeuvre;

    #[ORM\Column(type: 'text', nullable: true)]
    private $organisme;

    #[ORM\Column(type: 'text', nullable: true)]
    private $lieu;

    #[ORM\Column(type: 'text', nullable: true)]
    private $descripteur;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $analyse;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $droits;

    #[ORM\Column(type: 'datetime')]
    private $created_at;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $auteur;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $responsable;

    #[ORM\Column(type: 'text', nullable: true)]
    private $editeur;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $lieuedition;

    #[ORM\Column(type: 'string', length: 25, nullable: true)]
    private $annee_edition;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $isbn;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $pagination;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $collection;

    #[ORM\Column(type: 'text', nullable: true)]
    private $auteur_secondaire;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $anneeStat;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $perHisto;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $origDoc;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $copyRight;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $support;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $couleur;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $format;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $formatFile;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $duree;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $nbFiles;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $cote;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $supNum;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $locaSupnum;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $coteNum;

    #[ORM\Column(type: 'text', nullable: true)]
    private $urlImag;

    #[ORM\Column(type: 'text', nullable: true)]
    private $urlPdf;

    #[ORM\Column(type: 'text', nullable: true)]
    private $urlAudio;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $numVideo;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $urlDoc;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $resEdit;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $lecteur;

    #[ORM\ManyToMany(targetEntity: Texte::class, mappedBy: 'ressources')]
    private $textes;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $referenceCadic;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $auteurMoral;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $responsableEdition;

    #[ORM\ManyToMany(targetEntity: Souscollectioncnd::class, mappedBy: 'ressources')]
    private $souscollectioncnds;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $folderFront;

    public function __construct()
    {
        $this->textes = new ArrayCollection();
        $this->created_at = new \DateTime();
        $this->souscollectioncnds = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->getTitre();
    }
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
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

    public function getLangue(): ?string
    {
        return $this->langue;
    }

    public function setLangue(?string $langue): self
    {
        $this->langue = $langue;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(?string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getPersonne(): ?string
    {
        return $this->personne;
    }

    public function setPersonne(?string $personne): self
    {
        $this->personne = $personne;

        return $this;
    }

    public function getOeuvre(): ?string
    {
        return $this->oeuvre;
    }

    public function setOeuvre(?string $oeuvre): self
    {
        $this->oeuvre = $oeuvre;

        return $this;
    }

    public function getOrganisme(): ?string
    {
        return $this->organisme;
    }

    public function setOrganisme(?string $organisme): self
    {
        $this->organisme = $organisme;

        return $this;
    }

    public function getLieu(): ?string
    {
        return $this->lieu;
    }

    public function setLieu(?string $lieu): self
    {
        $this->lieu = $lieu;

        return $this;
    }

    public function getDescripteur(): ?string
    {
        return $this->descripteur;
    }

    public function setDescripteur(?string $descripteur): self
    {
        $this->descripteur = $descripteur;

        return $this;
    }

    public function getAnalyse(): ?bool
    {
        return $this->analyse;
    }

    public function setAnalyse(?bool $analyse): self
    {
        $this->analyse = $analyse;

        return $this;
    }

    public function getDroits(): ?bool
    {
        return $this->droits;
    }

    public function setDroits(?bool $droits): self
    {
        $this->droits = $droits;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getAuteur(): ?string
    {
        return $this->auteur;
    }

    public function setAuteur(?string $auteur): self
    {
        $this->auteur = $auteur;

        return $this;
    }

    public function getResponsable(): ?string
    {
        return $this->responsable;
    }

    public function setResponsable(string $responsable): self
    {
        $this->responsable = $responsable;

        return $this;
    }

    public function getEditeur(): ?string
    {
        return $this->editeur;
    }

    public function setEditeur(string $editeur): self
    {
        $this->editeur = $editeur;

        return $this;
    }

    public function getLieuedition(): ?string
    {
        return $this->lieuedition;
    }

    public function setLieuedition(string $lieuedition): self
    {
        $this->lieuedition = $lieuedition;

        return $this;
    }

    public function getAnneeEdition(): ?string
    {
        return $this->annee_edition;
    }

    public function setAnneeEdition(string $annee_edition): self
    {
        $this->annee_edition = $annee_edition;

        return $this;
    }

    public function getIsbn(): ?string
    {
        return $this->isbn;
    }

    public function setIsbn(string $isbn): self
    {
        $this->isbn = $isbn;

        return $this;
    }

    public function getPagination(): ?string
    {
        return $this->pagination;
    }

    public function setPagination(string $pagination): self
    {
        $this->pagination = $pagination;

        return $this;
    }

    public function getCollection(): ?string
    {
        return $this->collection;
    }

    public function setCollection(string $collection): self
    {
        $this->collection = $collection;

        return $this;
    }

    public function getAuteurSecondaire(): ?string
    {
        return $this->auteur_secondaire;
    }

    public function setAuteurSecondaire(string $auteur_secondaire): self
    {
        $this->auteur_secondaire = $auteur_secondaire;

        return $this;
    }

    public function getAnneeStat(): ?int
    {
        return $this->anneeStat;
    }

    public function setAnneeStat(int $anneeStat): self
    {
        $this->anneeStat = $anneeStat;

        return $this;
    }

    public function getPerHisto(): ?string
    {
        return $this->perHisto;
    }

    public function setPerHisto(string $perHisto): self
    {
        $this->perHisto = $perHisto;

        return $this;
    }

    public function getOrigDoc(): ?string
    {
        return $this->origDoc;
    }

    public function setOrigDoc(string $origDoc): self
    {
        $this->origDoc = $origDoc;

        return $this;
    }

    public function getCopyRight(): ?string
    {
        return $this->copyRight;
    }

    public function setCopyRight(string $copyRight): self
    {
        $this->copyRight = $copyRight;

        return $this;
    }

    public function getSupport(): ?string
    {
        return $this->support;
    }

    public function setSupport(string $support): self
    {
        $this->support = $support;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getFormat(): ?string
    {
        return $this->format;
    }

    public function setFormat(string $format): self
    {
        $this->format = $format;

        return $this;
    }

    public function getFormatFile(): ?string
    {
        return $this->formatFile;
    }

    public function setFormatFile(string $formatFile): self
    {
        $this->formatFile = $formatFile;

        return $this;
    }

    public function getDuree(): ?string
    {
        return $this->duree;
    }

    public function setDuree(string $duree): self
    {
        $this->duree = $duree;

        return $this;
    }

    public function getNbFiles(): ?string
    {
        return $this->nbFiles;
    }

    public function setNbFiles(string $nbFiles): self
    {
        $this->nbFiles = $nbFiles;

        return $this;
    }

    public function getCote(): ?string
    {
        return $this->cote;
    }

    public function setCote(string $cote): self
    {
        $this->cote = $cote;

        return $this;
    }

    public function getSupNum(): ?string
    {
        return $this->supNum;
    }

    public function setSupNum(string $supNum): self
    {
        $this->supNum = $supNum;

        return $this;
    }

    public function getLocaSupnum(): ?string
    {
        return $this->locaSupnum;
    }

    public function setLocaSupnum(string $locaSupnum): self
    {
        $this->locaSupnum = $locaSupnum;

        return $this;
    }

    public function getCoteNum(): ?string
    {
        return $this->coteNum;
    }

    public function setCoteNum(string $coteNum): self
    {
        $this->coteNum = $coteNum;

        return $this;
    }

    public function getUrlImag(): ?string
    {
        return $this->urlImag;
    }

    public function setUrlImag(string $urlImag): self
    {
        $this->urlImag = $urlImag;

        return $this;
    }

    public function getUrlPdf(): ?string
    {
        return $this->urlPdf;
    }

    public function setUrlPdf(string $urlPdf): self
    {
        $this->urlPdf = $urlPdf;

        return $this;
    }

    public function getUrlAudio(): ?string
    {
        return $this->urlAudio;
    }

    public function setUrlAudio(string $urlAudio): self
    {
        $this->urlAudio = $urlAudio;

        return $this;
    }

    public function getNumVideo(): ?string
    {
        return $this->numVideo;
    }

    public function setNumVideo(string $numVideo): self
    {
        $this->numVideo = $numVideo;

        return $this;
    }

    public function getUrlDoc(): ?string
    {
        return $this->urlDoc;
    }

    public function setUrlDoc(string $urlDoc): self
    {
        $this->urlDoc = $urlDoc;

        return $this;
    }

    public function getResEdit(): ?string
    {
        return $this->resEdit;
    }

    public function setResEdit(string $resEdit): self
    {
        $this->resEdit = $resEdit;

        return $this;
    }

    public function getLecteur(): ?int
    {
        return $this->lecteur;
    }

    public function setLecteur(int $lecteur): self
    {
        $this->lecteur = $lecteur;

        return $this;
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
            $texte->addRessource($this);
        }

        return $this;
    }

    public function removeTexte(Texte $texte): self
    {
        if ($this->textes->removeElement($texte)) {
            $texte->removeRessource($this);
        }

        return $this;
    }

    public function getReferenceCadic(): ?string
    {
        return $this->referenceCadic;
    }

    public function setReferenceCadic(?string $referenceCadic): self
    {
        $this->referenceCadic = $referenceCadic;

        return $this;
    }

    public function getAuteurMoral(): ?string
    {
        return $this->auteurMoral;
    }

    public function setAuteurMoral(?string $auteurMoral): self
    {
        $this->auteurMoral = $auteurMoral;

        return $this;
    }

    public function getResponsableEdition(): ?string
    {
        return $this->responsableEdition;
    }

    public function setResponsableEdition(?string $responsableEdition): self
    {
        $this->responsableEdition = $responsableEdition;

        return $this;
    }

    /**
     * @return Collection<int, Souscollectioncnd>
     */
    public function getSouscollectioncnds(): Collection
    {
        return $this->souscollectioncnds;
    }

    public function addSouscollectioncnd(Souscollectioncnd $souscollectioncnd): self
    {
        if (!$this->souscollectioncnds->contains($souscollectioncnd)) {
            $this->souscollectioncnds[] = $souscollectioncnd;
            $souscollectioncnd->addRessource($this);
        }

        return $this;
    }

    public function removeSouscollectioncnd(Souscollectioncnd $souscollectioncnd): self
    {
        if ($this->souscollectioncnds->removeElement($souscollectioncnd)) {
            $souscollectioncnd->removeRessource($this);
        }

        return $this;
    }

    public function getFolderFront(): ?bool
    {
        return $this->folderFront;
    }

    public function setFolderFront(bool $folderFront): self
    {
        $this->folderFront = $folderFront;

        return $this;
    }

}
