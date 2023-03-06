<?php

namespace App\Entity;

use App\Repository\DirectorRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=DirectorRepository::class)
 * @UniqueEntity(fields = {"firstname", "lastname"})
 */
class Director
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"movies"})
     * @Groups({"forms"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=65)
     * @Groups({"movies"})
     * @Groups({"forms"})
     * @Assert\NotBlank
     * @Assert\Length(min = 1, max = 65)
     */
    private $firstname;

    /**
     * @ORM\Column(type="string", length=65)
     * @Groups({"movies"})
     * @Groups({"forms"})
     * @Assert\NotBlank
     * @Assert\Length(min = 1, max = 65)
     */
    private $lastname;

    /**
     * @ORM\ManyToMany(targetEntity=Movie::class, mappedBy="directors")
     */
    private $movies;

    public function __toString()
    {
        return $this->getFirstname() ." ". $this->getLastname();
    }


    public function __construct()
    {
        $this->movies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFirstname(): ?string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): ?string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * @return Collection<int, Movie>
     */
    public function getMovies(): Collection
    {
        return $this->movies;
    }

    public function addMovie(Movie $movie): self
    {
        if (!$this->movies->contains($movie)) {
            $this->movies[] = $movie;
            $movie->addDirector($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): self
    {
        if ($this->movies->removeElement($movie)) {
            $movie->removeDirector($this);
        }

        return $this;
    }
}
