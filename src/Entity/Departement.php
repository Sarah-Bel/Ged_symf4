<?php

namespace App\Entity;

use App\Repository\DepartementRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use App\Entity\User;


/**
 * @ORM\Table(name="Departement")
 * @ORM\Entity(repositoryClass="App\Repository\DepartementRepository")
 * @UniqueEntity("description")
 */
class Departement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous ne pouvez pas le laisser vide")
     *
     */
    private $description;

    /**
     * @ORM\OneToMany(targetEntity=TypeDocument::class, mappedBy="service")
     */
    private $typeDocuments;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $UpdatedAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="depcreatedby")
     */
    private $Createdby;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="departements")
     */
    private $Editby;

    public function __construct()
    {
        $this->typeDocuments = new ArrayCollection();
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
        
    }

 


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return Collection|TypeDocument[]
     */
    public function getTypeDocuments(): Collection
    {
        return $this->typeDocuments;
    }

    public function addTypeDocument(TypeDocument $typeDocument): self
    {
        if (!$this->typeDocuments->contains($typeDocument)) {
            $this->typeDocuments[] = $typeDocument;
            $typeDocument->setService($this);
        }

        return $this;
    }

    public function removeTypeDocument(TypeDocument $typeDocument): self
    {
        if ($this->typeDocuments->contains($typeDocument)) {
            $this->typeDocuments->removeElement($typeDocument);
            // set the owning side to null (unless already changed)
            if ($typeDocument->getService() === $this) {
                $typeDocument->setService(null);
            }
        }

        return $this;
    }


    public function __toString()
    {
        return $this->description;
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

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->UpdatedAt;
    }

    public function setUpdatedAt(\DateTimeInterface $UpdatedAt): self
    {
        $this->UpdatedAt = $UpdatedAt;

        return $this;
    }

    public function getCreatedby(): ?User
    {
        return $this->Createdby;
    }

    public function setCreatedby(?User $Createdby): self
    {
        $this->Createdby = $Createdby;

        return $this;
    }

    public function getEditby(): ?User
    {
        return $this->Editby;
    }

    public function setEditby(?User $Editby): self
    {
        $this->Editby = $Editby;

        return $this;
    }
  
}
