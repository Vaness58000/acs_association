<?php

namespace App\Entity;

use App\Repository\ProduitsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProduitsRepository::class)
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
     * @ORM\Column(type="string", length=255)
     */
    private $slug;

    /**
     * @ORM\Column(type="datetime")
     */
    private $achat_at;

    /**
     * @ORM\Column(type="datetime")
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
     * @ORM\ManyToOne(targetEntity=Categories::class, inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categories;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="produits")
     * @ORM\JoinColumn(nullable=false)
     */
    private $users;

    /**
     * @ORM\ManyToMany(targetEntity=AddFiles::class, mappedBy="produits")
     */
    private $addFiles;

    /**
     * @ORM\ManyToMany(targetEntity=Images::class, mappedBy="produits")
     */
    private $images;

    public function __construct()
    {
        $this->addFiles = new ArrayCollection();
        $this->images = new ArrayCollection();
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

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
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
            $addFile->addProduit($this);
        }

        return $this;
    }

    public function removeAddFile(AddFiles $addFile): self
    {
        if ($this->addFiles->removeElement($addFile)) {
            $addFile->removeProduit($this);
        }

        return $this;
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
            $image->addProduit($this);
        }

        return $this;
    }

    public function removeImage(Images $image): self
    {
        if ($this->images->removeElement($image)) {
            $image->removeProduit($this);
        }

        return $this;
    }
}
