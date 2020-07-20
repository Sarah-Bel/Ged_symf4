<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\DocumentRepository;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=DocumentRepository::class)
 * @Vich\Uploadable
 * @UniqueEntity("numdocument")
 */
class Document
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=150)
     * @Assert\NotBlank
     */
    private $numdocument;

    /**
     * @ORM\ManyToOne(targetEntity=TypeDocument::class, inversedBy="documents")
     * @Assert\NotBlank
     */
    private $nomdocument;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     */
    
    private $information;

    /**
     * @ORM\Column(type="text")
     * @Assert\NotBlank
     */
    private $commentaire;

     /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(groups={"new"} ,message="Merci de mettre une image !")
     */
    private $ImageFile;

    /**
     * @ORM\Column(type="datetime")
     */
    private $CreatedAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $UpdatedAt;

    public function __construct()
    {
     
        $this->setCreatedAt(new \DateTime());
        $this->setUpdatedAt(new \DateTime());
        
    }
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumdocument(): ?string
    {
        return $this->numdocument;
    }

    public function setNumdocument(string $numdocument): self
    {
        $this->numdocument = $numdocument;

        return $this;
    }

    public function getInformation(): ?string
    {
        return $this->information;
    }

    public function setInformation(string $information): self
    {
        $this->information = $information;

        return $this;
    }

    public function getCommentaire(): ?string
    {
        return $this->commentaire;
    }

    public function setCommentaire(string $commentaire): self
    {
        $this->commentaire = $commentaire;

        return $this;
    }

    public function getNomdocument(): ?typedocument
    {
        return $this->nomdocument;
    }

    public function setNomdocument(?typedocument $nomdocument): self
    {
        $this->nomdocument = $nomdocument;

        return $this;
    }

 

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->CreatedAt;
    }

    public function setCreatedAt(\DateTimeInterface $CreatedAt): self
    {
        $this->CreatedAt = $CreatedAt;

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

    public function getImageFile(): ?string
    {
        return $this->ImageFile;
    }

    public function setImageFile(string $ImageFile): self
    {
        $this->ImageFile = $ImageFile;

        return $this;
    }

   

}