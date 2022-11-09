<?php

namespace App\Entity;

use App\Repository\CollectioncndRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Cocur\Slugify\Slugify;

#[ORM\Entity(repositoryClass: CollectioncndRepository::class)]
#[Vich\Uploadable]
class Collectioncnd
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $titre;

    #[ORM\Column(type: 'text', nullable: true)]
    private $presentation;

    #[ORM\OneToMany(mappedBy: 'collectioncnd', targetEntity: Souscollectioncnd::class)]
    private $souscollectioncnds;

    /**
     * NOTE: This is not a mapped field of entity metadata, just a simple property.
     */
    #[Vich\UploadableField(mapping: 'collection_image', fileNameProperty: 'imageName', size: 'imageSize')]
    private ?File $imageFile = null;

    #[ORM\Column(type: 'string', length: 255)]
    private ?string $imageName = null;

    #[ORM\Column(type: 'integer')]
    private ?int $imageSize = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $updatedAt = null;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $published;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $folderFront;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $soustitre;

    #[ORM\Column(type: 'integer')]
    private $type;

    public function __construct()
    {
        $this->souscollectioncnds = new ArrayCollection();
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

    public function getPresentation(): ?string
    {
        return $this->presentation;
    }

    public function setPresentation(?string $presentation): self
    {
        $this->presentation = $presentation;

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
            $souscollectioncnd->setCollectioncnd($this);
        }

        return $this;
    }

    public function removeSouscollectioncnd(Souscollectioncnd $souscollectioncnd): self
    {
        if ($this->souscollectioncnds->removeElement($souscollectioncnd)) {
            // set the owning side to null (unless already changed)
            if ($souscollectioncnd->getCollectioncnd() === $this) {
                $souscollectioncnd->setCollectioncnd(null);
            }
        }

        return $this;
    }

    /**
     * If manually uploading a file (i.e. not using Symfony Form) ensure an instance
     * of 'UploadedFile' is injected into this setter to trigger the update. If this
     * bundle's configuration parameter 'inject_on_load' is set to 'true' this setter
     * must be able to accept an instance of 'File' as the bundle will inject one here
     * during Doctrine hydration.
     *
     * @param File|\Symfony\Component\HttpFoundation\File\UploadedFile|null $imageFile
     */
    public function setImageFile(?File $imageFile = null): void
    {
        $this->imageFile = $imageFile;

        if (null !== $imageFile) {
            // It is required that at least one field changes if you are using doctrine
            // otherwise the event listeners won't be called and the file is lost
            $this->updatedAt = new \DateTimeImmutable();
        }
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
    }

    public function setImageName(?string $imageName): void
    {
        $this->imageName = $imageName;
    }

    public function getImageName(): ?string
    {
        return $this->imageName;
    }
    
    public function setImageSize(?int $imageSize): void
    {
        $this->imageSize = $imageSize;
    }

    public function getImageSize(): ?int
    {
        return $this->imageSize;
    }

    public function getPublished(): ?bool
    {
        return $this->published;
    }

    public function setPublished(?bool $published): self
    {
        $this->published = $published;

        return $this;
    }

    public function getFolderFront(): ?bool
    {
        return $this->folderFront;
    }

    public function setFolderFront(?bool $folderFront): self
    {
        $this->folderFront = $folderFront;

        return $this;
    }

    public function getSoustitre(): ?string
    {
        return $this->soustitre;
    }

    public function setSoustitre(?string $soustitre): self
    {
        $this->soustitre = $soustitre;

        return $this;
    }

    public function getType(): ?int
    {
        return $this->type;
    }

    public function setType(int $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getSlug(): string
    {
        return (new Slugify())->slugify($this->titre); 
    }
}
