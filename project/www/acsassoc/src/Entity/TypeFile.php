<?php

namespace App\Entity;

use App\Repository\TypeFileRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TypeFileRepository::class)
 */
class TypeFile
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $name;

    /**
     * @ORM\OneToMany(targetEntity=AddFiles::class, mappedBy="type_file")
     */
    private $addFiles;

    public function __construct()
    {
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
            $addFile->setTypeFile($this);
        }

        return $this;
    }

    public function removeAddFile(AddFiles $addFile): self
    {
        if ($this->addFiles->removeElement($addFile)) {
            // set the owning side to null (unless already changed)
            if ($addFile->getTypeFile() === $this) {
                $addFile->setTypeFile(null);
            }
        }

        return $this;
    }
}
