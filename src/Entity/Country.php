<?php

namespace App\Entity;

use App\Repository\CountryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass=CountryRepository::class)
 * @UniqueEntity(fields = {"name"})
 */
class Country
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
     * 
     * 
     */
    private $name;

    /**
     * @ORM\ManyToMany(targetEntity=Movie::class, mappedBy="countries")
     * 
     */
    private $movies;

    public function __toString()
    {
        return $this->getName();
    }

    public function __construct()
    {
        $this->movies = new ArrayCollection();
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
            $movie->addCountry($this);
        }

        return $this;
    }

    public function removeMovie(Movie $movie): self
    {
        if ($this->movies->removeElement($movie)) {
            $movie->removeCountry($this);
        }

        return $this;
    }
}
