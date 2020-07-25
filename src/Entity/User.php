<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=UserRepository::class)
 *
 */
class User implements UserInterface
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
     */
    private $username;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank(message="Vous ne pouvez pas le laisser vide")
     */
    private $password;

     /**
     * @ORM\Column(type="json")
     * @Assert\NotBlank(message="Vous ne pouvez pas le laisser vide")
     */
    private $roles = [];

    /**
     * @ORM\Column(type="datetime")
     */
    private $CreatedAt;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="Createdby")
     */
    private $documents;

    /**
     * @ORM\OneToMany(targetEntity=Document::class, mappedBy="Editby")
     */
    private $EditDoc;

    /**
     * @ORM\OneToMany(targetEntity=Departement::class, mappedBy="Createdby")
     */
    private $depcreatedby;

    /**
     * @ORM\OneToMany(targetEntity=Departement::class, mappedBy="Editby")
     */
    private $departements;

    /**
     * @ORM\OneToMany(targetEntity=TypeDocument::class, mappedBy="Createdby")
     */
    private $typeDocuments;
    
    /**
     * @ORM\OneToMany(targetEntity=TypeDocument::class, mappedBy="Editby")
     */
    private $typeDocEditby;
    
    
    public function __construct()
    {
     
        $this->setCreatedAt(new \DateTime());
        $this->documents = new ArrayCollection();
        $this->EditDoc = new ArrayCollection();
        $this->departements = new ArrayCollection();
        $this->depcreatedby = new ArrayCollection();
        $this->typeDocuments = new ArrayCollection();
        $this->typeDocEditby = new ArrayCollection();
       
        
        
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    
    public function getRoles()
    {
        $roles = $this->roles;
    // garantit que chaque utilisateur possède le rôle ROLE_USER
    // équvalent à array_push() qui ajoute un élément au tabeau
          $roles[] = ''; 
    //array_unique élémine des doublons      
        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function eraseCredentials() {}
    public function getSalt() {}

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

        return $this;
    }

    /**
     * @return Collection|Document[]
     */
    public function getDocuments(): Collection
    {
        return $this->documents;
    }

    public function addDocument(Document $document): self
    {
        if (!$this->documents->contains($document)) {
            $this->documents[] = $document;
            $document->setCreatedby($this);
        }

        return $this;
    }

    public function removeDocument(Document $document): self
    {
        if ($this->documents->contains($document)) {
            $this->documents->removeElement($document);
            // set the owning side to null (unless already changed)
            if ($document->getCreatedby() === $this) {
                $document->setCreatedby(null);
            }
        }

        return $this;
    }
     public function __toString()
    {
        return $this->username;
    }

     /**
      * @return Collection|Document[]
      */
     public function getEditDoc(): Collection
     {
         return $this->EditDoc;
     }

     public function addEditDoc(Document $editDoc): self
     {
         if (!$this->EditDoc->contains($editDoc)) {
             $this->EditDoc[] = $editDoc;
             $editDoc->setEditby($this);
         }

         return $this;
     }

     public function removeEditDoc(Document $editDoc): self
     {
         if ($this->EditDoc->contains($editDoc)) {
             $this->EditDoc->removeElement($editDoc);
             // set the owning side to null (unless already changed)
             if ($editDoc->getEditby() === $this) {
                 $editDoc->setEditby(null);
             }
         }

         return $this;
     }

     /**
      * @return Collection|Departement[]
      */
     public function getDepcreatedby(): Collection
     {
         return $this->depcreatedby;
     }

     public function addDepcreatedby(Departement $depcreatedby): self
     {
         if (!$this->depcreatedby->contains($depcreatedby)) {
             $this->depcreatedby[] = $depcreatedby;
             $depcreatedby->setCreatedby($this);
         }

         return $this;
     }

     public function removeDepcreatedby(Departement $depcreatedby): self
     {
         if ($this->depcreatedby->contains($depcreatedby)) {
             $this->depcreatedby->removeElement($depcreatedby);
             // set the owning side to null (unless already changed)
             if ($depcreatedby->getCreatedby() === $this) {
                 $depcreatedby->setCreatedby(null);
             }
         }

         return $this;
     }

     /**
      * @return Collection|Departement[]
      */
     public function getDepartements(): Collection
     {
         return $this->departements;
     }

     public function addDepartement(Departement $departement): self
     {
         if (!$this->departements->contains($departement)) {
             $this->departements[] = $departement;
             $departement->setEditby($this);
         }

         return $this;
     }

     public function removeDepartement(Departement $departement): self
     {
         if ($this->departements->contains($departement)) {
             $this->departements->removeElement($departement);
             // set the owning side to null (unless already changed)
             if ($departement->getEditby() === $this) {
                 $departement->setEditby(null);
             }
         }

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
             $typeDocument->setCreatedby($this);
         }

         return $this;
     }

     public function removeTypeDocument(TypeDocument $typeDocument): self
     {
         if ($this->typeDocuments->contains($typeDocument)) {
             $this->typeDocuments->removeElement($typeDocument);
             // set the owning side to null (unless already changed)
             if ($typeDocument->getCreatedby() === $this) {
                 $typeDocument->setCreatedby(null);
             }
         }

         return $this;
     }

     /**
      * @return Collection|TypeDocument[]
      */
     public function getTypeDocEditby(): Collection
     {
         return $this->typeDocEditby;
     }

     public function addTypeDocEditby(TypeDocument $typeDocEditby): self
     {
         if (!$this->typeDocEditby->contains($typeDocEditby)) {
             $this->typeDocEditby[] = $typeDocEditby;
             $typeDocEditby->setCreatedby($this);
         }

         return $this;
     }

     public function removeTypeDocEditby(TypeDocument $typeDocEditby): self
     {
         if ($this->typeDocEditby->contains($typeDocEditby)) {
             $this->typeDocEditby->removeElement($typeDocEditby);
             // set the owning side to null (unless already changed)
             if ($typeDocEditby->getCreatedby() === $this) {
                 $typeDocEditby->setCreatedby(null);
             }
         }

         return $this;
     }

}
