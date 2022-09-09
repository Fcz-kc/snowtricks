<?php

namespace App\Entity;

use App\Repository\TrickRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TrickRepository::class)]
class Trick
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $createdAt = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $updateAt = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\OneToMany(mappedBy: 'trick', targetEntity: Comment::class)]
    private Collection $comments;

    #[ORM\ManyToOne(inversedBy: 'tricks')]
    private ?TrickGroup $tripGroup = null;

    #[ORM\OneToMany(mappedBy: 'trick', targetEntity: TrickMedia::class)]
    private Collection $trickMedia;

    public function __construct()
    {
        $this->comments = new ArrayCollection();
        $this->trickMedia = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

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

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): self
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setTrick($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): self
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getTrick() === $this) {
                $comment->setTrick(null);
            }
        }

        return $this;
    }

    public function getTripGroup(): ?TrickGroup
    {
        return $this->tripGroup;
    }

    public function setTripGroup(?TrickGroup $tripGroup): self
    {
        $this->tripGroup = $tripGroup;

        return $this;
    }

    /**
     * @return Collection<int, TrickMedia>
     */
    public function getTrickMedia(): Collection
    {
        return $this->trickMedia;
    }

    public function addTrickMedium(TrickMedia $trickMedium): self
    {
        if (!$this->trickMedia->contains($trickMedium)) {
            $this->trickMedia->add($trickMedium);
            $trickMedium->setTrick($this);
        }

        return $this;
    }

    public function removeTrickMedium(TrickMedia $trickMedium): self
    {
        if ($this->trickMedia->removeElement($trickMedium)) {
            // set the owning side to null (unless already changed)
            if ($trickMedium->getTrick() === $this) {
                $trickMedium->setTrick(null);
            }
        }

        return $this;
    }
}