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
     * @var File
     * @Vich\UploadableField(mapping="product_image", fileNameProperty="filename")
     * @Assert\NotBlank
     * @Assert\File(
     *  mimeTypes = {"application/pdf", "application/x-pdf"}
     * )
     * 
     */
    private $imageFile;

    /**
     * @var string
     * @ORM\Column(type="string" , length=255)
     * 
     * 
     */
    private $filename;

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

  public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(?string $filename): Document
    {
        $this->filename = $filename;
        return $this;
    }

    public function setImageFile(?File $imageFile): Document
    {
        $this->imageFile = $imageFile;
        if ($this->imageFile instanceof UploadedFile) {
            $this->updatedAt = new \DateTime('now');
        }
        return $this;
       
    }

    public function getImageFile(): ?File
    {
        return $this->imageFile;
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

   

}
