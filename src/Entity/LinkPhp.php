<?php

namespace App\Entity;

use App\Repository\LinkPhpRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: LinkPhpRepository::class)]
class LinkPhp
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(
        type: Types::INTEGER,
        options: ['unsigned' => true]
    )]
    private ?int $id = null;

    #[ORM\Column(length: 150)]
    private ?string $title = null;

    #[ORM\Column(length: 500, nullable: true)]
    private ?string $Description = null;

    #[ORM\Column(length: 255)]
    private ?string $Url = null;

    /**
     * @var Collection<int, PhpFunction>
     */
    #[ORM\ManyToMany(targetEntity: PhpFunction::class, mappedBy: 'Link')]
    private Collection $phpFunctions;

    public function __construct()
    {
        $this->phpFunctions = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->Description;
    }

    public function setDescription(?string $Description): static
    {
        $this->Description = $Description;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->Url;
    }

    public function setUrl(string $Url): static
    {
        $this->Url = $Url;

        return $this;
    }

    /**
     * @return Collection<int, PhpFunction>
     */
    public function getPhpFunctions(): Collection
    {
        return $this->phpFunctions;
    }

    public function addPhpFunction(PhpFunction $phpFunction): static
    {
        if (!$this->phpFunctions->contains($phpFunction)) {
            $this->phpFunctions->add($phpFunction);
            $phpFunction->addLink($this);
        }

        return $this;
    }

    public function removePhpFunction(PhpFunction $phpFunction): static
    {
        if ($this->phpFunctions->removeElement($phpFunction)) {
            $phpFunction->removeLink($this);
        }

        return $this;
    }
}
