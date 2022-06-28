<?php

namespace App\Entity;

use App\Repository\AddFilesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AddFilesRepository::class)
 */
class AddFiles
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
    private $src;

    /**
     * @ORM\ManyToMany(targetEntity=Produits::class, inversedBy="addFiles")
     */
    private $produits;

    /**
     * @ORM\ManyToOne(targetEntity=TypeFile::class, inversedBy="addFiles")
     */
    private $type_file;

    public function __construct()
    {
        $this->produits = new ArrayCollection();
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

    public function getSrc(): ?string
    {
        return $this->src;
    }

    public function setSrc(string $src): self
    {
        $this->src = $src;

        return $this;
    }

    /**
     * @return Collection<int, Produits>
     */
    public function getProduits(): Collection
    {
        return $this->produits;
    }

    public function addProduit(produits $produit): self
    {
        if (!$this->produits->contains($produit)) {
            $this->produits[] = $produit;
        }

        return $this;
    }

    public function removeProduit(Produits $produit): self
    {
        $this->produits->removeElement($produit);

        return $this;
    }

    public function getTypeFile(): ?TypeFile
    {
        return $this->type_file;
    }

    public function setTypeFile(?TypeFile $type_file): self
    {
        $this->type_file = $type_file;

        return $this;
    }
}
