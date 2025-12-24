<?php

namespace App\Entity;

use App\Repository\FormationRepository;
use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: FormationRepository::class)]
class Formation
{

    /**
     * Début de chemin vers les images
     */
    private const CHEMINIMAGE = "https://i.ytimg.com/vi/";
      
    /**
     * 
     * @var int|null
     */
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    /**
     * 
     * @var DateTimeInterface|null
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    #[Assert\NotBlank(message: 'La date de publication est obligatoire.')]
    #[Assert\LessThanOrEqual('today')]
    private ?DateTimeInterface $publishedAt = null;

    /**
     * 
     * @var string|null
     */
    #[ORM\Column(length: 100, nullable: false)]
    #[Assert\NotBlank(message: 'Le titre est obligatoire.')]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    /**
     * 
     * @var string|null
     */
    #[ORM\Column(length: 20, nullable: false)]
    #[Assert\NotBlank(message: 'L’identifiant vidéo est obligatoire.')]
    private ?string $videoId = null;

    /**
     * 
     * @var Playlist|null
     */
    #[ORM\ManyToOne(inversedBy: 'formations')]
    #[Assert\NotBlank(message: 'choisissez un playlist.')]
    private ?Playlist $playlist = null;

    /**
     * @var Collection<int, Categorie>
     */
    #[ORM\ManyToMany(targetEntity: Categorie::class, inversedBy: 'formations')]
    private Collection $categories;

    /**
     * 
     */
    public function __construct()
    {
        $this->categories = new ArrayCollection();
    }

    /**
     * 
     * @return int|null
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * 
     * @return DateTimeInterface|null
     */
    public function getPublishedAt(): ?DateTimeInterface
    {
        return $this->publishedAt;
    }

    /**
     * 
     * @param DateTimeInterface|null $publishedAt
     * @return static
     */
    public function setPublishedAt(?DateTimeInterface $publishedAt): static
    {
        $this->publishedAt = $publishedAt;

        return $this;
    }

    /**
     * 
     * @return string
     */
    public function getPublishedAtString(): string {
        if($this->publishedAt == null){
            return "";
        }
        return $this->publishedAt->format('d/m/Y');     
    }      
    
    /**
     * 
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->title;
    }

    /**
     * 
     * @param string|null $title
     * @return static
     */
    public function setTitle(?string $title): static
    {
        $this->title = $title;

        return $this;
    }

    /**
     * 
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->description;
    }

    /**
     * 
     * @param string|null $description
     * @return static
     */
    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    /**
     * 
     * @return string|null
     */
    public function getVideoId(): ?string
    {
        return $this->videoId;
    }

    /**
     * 
     * @param string|null $videoId
     * @return static
     */
    public function setVideoId(?string $videoId): static
    {
        $this->videoId = $videoId;

        return $this;
    }

    /**
     * 
     * @return string|null
     */
    public function getMiniature(): ?string
    {
        return self::CHEMINIMAGE.$this->videoId."/default.jpg";
    }

    /**
     * 
     * @return string|null
     */
    public function getPicture(): ?string
    {
        return self::CHEMINIMAGE.$this->videoId."/hqdefault.jpg";
    }
    
    /**
     * 
     * @return playlist|null
     */
    public function getPlaylist(): ?playlist
    {
        return $this->playlist;
    }

    /**
     * 
     * @param Playlist|null $playlist
     * @return static
     */
    public function setPlaylist(?Playlist $playlist): static
    {
        $this->playlist = $playlist;

        return $this;
    }

    /**
     * @return Collection<int, Categorie>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    /**
     * 
     * @param Categorie $category
     * @return static
     */
    public function addCategory(Categorie $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    /**
     * 
     * @param Categorie $category
     * @return static
     */
    public function removeCategory(Categorie $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }
}
