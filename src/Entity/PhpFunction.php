<?php
# src/Entity/PhpFunction.php

namespace App\Entity;

use App\Repository\PhpFunctionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
# Timestamp
use DateTimeInterface;


#[ORM\Entity(repositoryClass: PhpFunctionRepository::class)]
class PhpFunction
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(
        type: Types::INTEGER,
        options: ['unsigned' => true]
    )]
    private ?int $id = null;

    #[ORM\Column(length: 120)]
    private ?string $title = null;

    #[ORM\Column(length: 125)]
    private ?string $slug = null;

    #[ORM\Column(length: 255)]
    private ?string $description = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $text = null;

    #[ORM\Column(
        type: Types::BOOLEAN,
        options: ['default' => true]
    )]
    private ?bool $visibility = null;

    #[ORM\Column(
        type: Types::DATETIME_MUTABLE,
        options: [
            'default' => 'CURRENT_TIMESTAMP',
            'insertable' => false
        ]
    )]
    private ?DateTimeInterface $createdAt = null;

    #[ORM\Column(
        type: Types::DATETIME_MUTABLE,
        nullable: true,
        options: [
            'insertable' => false,
            'updateable' => true,
        ],
    )]
    private ?DateTimeInterface $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'phpFunctions')]
    private ?User $idUser = null;

    /**
     * @var Collection<int, LinkPhp>
     */
    #[ORM\ManyToMany(targetEntity: LinkPhp::class, inversedBy: 'phpFunctions')]
    private Collection $Link;

    public function __construct()
    {
        $this->Link = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): static
    {
        $this->slug = $slug;

        return $this;
    }
    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getText(): ?string
    {
        return $this->text;
    }

    public function setText(string $text): static
    {
        $this->text = $text;

        return $this;
    }


    public function isVisibility(): ?bool
    {
        return $this->visibility;
    }

    public function setVisibility(bool $visibility): static
    {
        $this->visibility = $visibility;

        return $this;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(?DateTimeInterface $createdAt): static
    {
        if($createdAt === null){
            $createdAt = new \DateTime();
        }
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updateAt): static
    {

        $this->updatedAt = $updateAt;

        return $this;
    }

    public function getIdUser(): ?User
    {
        return $this->idUser;
    }

    public function setIdUser(?User $idUser): static
    {
        $this->idUser = $idUser;

        return $this;
    }

    /**
     * @return Collection<int, LinkPhp>
     */
    public function getLink(): Collection
    {
        return $this->Link;
    }

    public function addLink(LinkPhp $link): static
    {
        if (!$this->Link->contains($link)) {
            $this->Link->add($link);
        }

        return $this;
    }

    public function removeLink(LinkPhp $link): static
    {
        $this->Link->removeElement($link);

        return $this;
    }
}
