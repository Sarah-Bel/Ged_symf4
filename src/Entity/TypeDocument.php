<?php

namespace App\Entity;

use App\Repository\TypeDocumentRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="TypeDocument")
 * @ORM\Entity(repositoryClass="App\Repository\TypeDocumentRepository")
 */
class TypeDocument
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $description;

    /**
     * @ORM\ManyToOne(targetEntity=Departement::class, inversedBy="typeDocuments")
     */
    private $service;

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

    public function getService(): ?Departement
    {
        return $this->service;
    }

    public function setService(?Departement $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function __toString()
    {
        return $this->description;
        return $this->service;
    }

 
}
