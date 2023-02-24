<?php

namespace App\Entity;

use App\Repository\MovieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass=MovieRepository::class)
 */
class Movie
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     * @Groups({"movies"})
     * @Groups({"games"})
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=65)
     * @Groups({"movies"})
     * @Groups({"games"})
     * @Assert\Length(min = 1, max = 65)
     * @Assert\NotBlank
     */
    private $title;

    /**
     * @ORM\Column(type="text", nullable=true)
     * @Groups({"movies"})
     * @Assert\Length(min = 50, max = 2000)
     * @Assert\NotBlank
     */
    private $synopsis;

    /**
     * @ORM\Column(type="datetime")
     * @Groups({"movies"})
     * @Assert\NotBlank
     */
    private $releaseDate;

    /**
     * @ORM\Column(type="string", length=155)
     * @Groups({"movies"})
     * @Assert\Url
     */
    private $poster;

    /**
     * @ORM\Column(type="integer")
     * @Groups({"movies"})
     * @Assert\NotBlank
     * @Assert\Range(min = 0, max = 1)
     */
    private $status;

    /**
     * @ORM\ManyToMany(targetEntity=Genre::class, inversedBy="movies")
     * @Groups({"movies"})
     */
    private $genres;

    /**
     * @ORM\ManyToMany(targetEntity=Actor::class, inversedBy="movies")
     * @Groups({"movies"})
     */
    private $actors;

    /**
     * @ORM\ManyToMany(targetEntity=ProductionStudio::class, inversedBy="movies")
     * @Groups({"movies"})
     */
    private $productionStudios;

    /**
     * @ORM\ManyToMany(targetEntity=Director::class, inversedBy="movies")
     * @Groups({"movies"})
     */
    private $directors;

    /**
     * @ORM\ManyToMany(targetEntity=Country::class, inversedBy="movies")
     * @Groups({"movies"})
     */
    private $countries;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="movies")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id", onDelete="SET NULL")
     * @Groups({"movies"})
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=Game::class, inversedBy="movies")
     * 
     */
    private $games;

    public function __construct()
    {
        $this->genres = new ArrayCollection();
        $this->actors = new ArrayCollection();
        $this->productionStudios = new ArrayCollection();
        $this->directors = new ArrayCollection();
        $this->countries = new ArrayCollection();
        $this->games = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getSynopsis(): ?string
    {
        return $this->synopsis;
    }

    public function setSynopsis(?string $synopsis): self
    {
        $this->synopsis = $synopsis;

        return $this;
    }

    public function getReleaseDate(): ?\DateTimeInterface
    {
        return $this->releaseDate;
    }

    public function setReleaseDate(\DateTimeInterface $releaseDate): self
    {
        $this->releaseDate = $releaseDate;

        return $this;
    }

    public function getPoster(): ?string
    {
        return $this->poster;
    }

    public function setPoster(string $poster): self
    {
        $this->poster = $poster;

        return $this;
    }

    public function getStatus(): ?int
    {
        return $this->status;
    }

    public function setStatus(int $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return Collection<int, Genre>
     */
    public function getGenres(): Collection
    {
        return $this->genres;
    }

    public function addGenre(Genre $genre): self
    {
        if (!$this->genres->contains($genre)) {
            $this->genres[] = $genre;
        }

        return $this;
    }

    public function removeGenre(Genre $genre): self
    {
        $this->genres->removeElement($genre);

        return $this;
    }

    /**
     * @return Collection<int, Actor>
     */
    public function getActors(): Collection
    {
        return $this->actors;
    }

    public function addActor(Actor $actor): self
    {
        if (!$this->actors->contains($actor)) {
            $this->actors[] = $actor;
        }

        return $this;
    }

    public function removeActor(Actor $actor): self
    {
        $this->actors->removeElement($actor);

        return $this;
    }

    /**
     * @return Collection<int, productionStudio>
     */
    public function getProductionStudios(): Collection
    {
        return $this->productionStudios;
    }

    public function addProductionStudio(ProductionStudio $productionStudio): self
    {
        if (!$this->productionStudios->contains($productionStudio)) {
            $this->productionStudios[] = $productionStudio;
        }

        return $this;
    }

    public function removeProductionStudio(ProductionStudio $productionStudio): self
    {
        $this->productionStudios->removeElement($productionStudio);

        return $this;
    }

    /**
     * @return Collection<int, Director>
     */
    public function getDirectors(): Collection
    {
        return $this->directors;
    }

    public function addDirector(Director $director): self
    {
        if (!$this->directors->contains($director)) {
            $this->directors[] = $director;
        }

        return $this;
    }

    public function removeDirector(Director $director): self
    {
        $this->directors->removeElement($director);

        return $this;
    }

    /**
     * @return Collection<int, Country>
     */
    public function getCountries(): Collection
    {
        return $this->countries;
    }

    public function addCountry(Country $country): self
    {
        if (!$this->countries->contains($country)) {
            $this->countries[] = $country;
        }

        return $this;
    }

    public function removeCountry(Country $country): self
    {
        $this->countries->removeElement($country);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Game>
     */
    public function getGames(): Collection
    {
        return $this->games;
    }

    public function addGame(Game $game): self
    {
        if (!$this->games->contains($game)) {
            $this->games[] = $game;
        }

        return $this;
    }

    public function removeGame(Game $game): self
    {
        $this->games->removeElement($game);

        return $this;
    }
}
