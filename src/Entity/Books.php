<?php

namespace App\Entity;

use App\Repository\BooksRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BooksRepository::class)]
class Books
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $releaseYear = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $imagePath = null;

    #[ORM\ManyToMany(targetEntity: Writer::class, inversedBy: 'books')]
    private Collection $writer;


    #[ORM\ManyToOne(inversedBy: 'books')]
    private ?User $users = null;

    

  
  

    public function __construct()
    {
        $this->writer = new ArrayCollection();
        $this->user = new ArrayCollection();
       
        
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

    public function getReleaseYear(): ?int
    {
        return $this->releaseYear;
    }

    public function setReleaseYear(int $releaseYear): static
    {
        $this->releaseYear = $releaseYear;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function getImagePath(): ?string
    {
        return $this->imagePath;
    }

    public function setImagePath(string $imagePath): static
    {
        $this->imagePath = $imagePath;

        return $this;
    }

    /**
     * @return Collection<int, Writer>
     */
    public function getWriter(): Collection
    {
        return $this->writer;
    }

    public function addWriter(Writer $writer): self
    {
        if (!$this->writer->contains($writer)) {
            $this->writer[] = $writer;
        }

        return $this;
    }

    public function removeWriter(Writer $writer): self
    {
        $this->writer->removeElement($writer);

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUser(): Collection
    {
        return $this->users;
    }
    public function setUsers(?User $users): static
{
    $this->users= $users;

    return $this;
}

    public function addUser(User $users): static
    {
        if (!$this->users->contains($users)) {
            $this->users->add($users);
        }

        return $this;
    }

    public function removeUser(User $users): static
    {
        $this->users->removeElement($users);

        return $this;
    }

 

   

   

  
}
