<?php

namespace App\Entity;

use App\Repository\ProduitsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;
use App\Entity\Produits;

/**
 * @ORM\Entity(repositoryClass=ProduitsRepository::class)
 * @ORM\Table(name="produits", indexes={@ORM\Index(columns={"name", "content"}, flags={"fulltext"})})
 */
class Produits
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @Gedmo\Slug(fields={"name"})
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(name="achat_at", type="datetime", nullable=true)
     */
    private $achat_at;

    /**
     * @ORM\Column(name="guarantee_at", type="datetime", nullable=true)
     */
    private $guarantee_at;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\Column(type="text")
     */
    private $content;

    /**
     * @ORM\Column(type="boolean")
     */
    private $active;

    /**
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="Produits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categories;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="Produits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $users;

    /**
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\OneToMany(targetEntity=Images::class, mappedBy="produits", orphanRemoval=true, cascade={"persist"})
     */
    private $images;

    /**
     * @ORM\OneToMany(targetEntity=AddFiles::class, mappedBy="produits")
     */
    private $addFiles;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $manuel_src;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ticket_src;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lieu_achat;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->addFiles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function getAchatAt(): ?\DateTimeInterface
    {
        return $this->achat_at;
    }

    public function setAchatAt(\DateTimeInterface $achat_at): self
    {
        $this->achat_at = $achat_at;

        return $this;
    }

    public function getGuaranteeAt(): ?\DateTimeInterface
    {
        return $this->guarantee_at;
    }

    public function setGuaranteeAt(\DateTimeInterface $guarantee_at): self
    {
        $this->guarantee_at = $guarantee_at;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function isActive(): ?bool
    {
        return $this->active;
    }

    public function setActive(bool $active): self
    {
        $this->active = $active;

        return $this;
    }

    public function getCategories(): ?categories
    {
        return $this->categories;
    }

    public function setCategories(?categories $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    public function getUsers(): ?users
    {
        return $this->users;
    }

    public function setUsers(?users $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    /**
     * @return Collection<int, Images>
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    public function addImage(Images $image): self
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
            $image->setProduits($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            // set the owning side to null (unless already changed)
            if ($image->getProduits() === $this) {
                $image->setProduits(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, AddFiles>
     */
    public function getAddFiles(): Collection
    {
        return $this->addFiles;
    }

    public function addAddFile(AddFiles $addFile): self
    {
        if (!$this->addFiles->contains($addFile)) {
            $this->addFiles[] = $addFile;
            $addFile->setProduits($this);
        }

        return $this;
    }

    public function removeAddFile(AddFiles $addFile): self
    {
        if ($this->addFiles->removeElement($addFile)) {
            // set the owning side to null (unless already changed)
            if ($addFile->getProduits() === $this) {
                $addFile->setProduits(null);
            }
        }

        return $this;
    }

    public function getManuelSrc(): ?string
    {
        return $this->manuel_src;
    }

    public function setManuelSrc(string $manuel_src): self
    {
        $this->manuel_src = $manuel_src;

        return $this;
    }

    public function getTicketSrc(): ?string
    {
        return $this->ticket_src;
    }

    public function setTicketSrc(string $ticket_src): self
    {
        $this->ticket_src = $ticket_src;

        return $this;
    }

    public function getLieuAchat(): ?string
    {
        return $this->lieu_achat;
    }

    public function setLieuAchat(string $lieu_achat): self
    {
        $this->lieu_achat = $lieu_achat;

        return $this;
    }
    
}
