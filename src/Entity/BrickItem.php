<?php

namespace App\Entity;

use App\Repository\BrickItemRepository;
use App\Service\BrickLink;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BrickItemRepository::class)]
class BrickItem
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $no;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'string', length: 255)]
    private $type;

    #[ORM\Column(type: 'integer')]
    private $category_id;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $alternate_no;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $image_url;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $thumbnail_url;

    #[ORM\Column(type: 'float', nullable: true)]
    private $weight;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $dim_x;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $dim_y;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $dim_z;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $year_released;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $description;

    #[ORM\Column(type: 'boolean', nullable: true)]
    private $is_obsolete;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private $language_code;

    #[ORM\OneToMany(mappedBy: 'Item', targetEntity: Inventory::class)]
    private $inventories;

    public function __construct()
    {
        $this->inventories = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNo(): ?string
    {
        return $this->no;
    }

    public function setNo(string $no): self
    {
        $this->no = $no;

        return $this;
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function setCategoryId(int $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function getAlternateNo(): ?string
    {
        return $this->alternate_no;
    }

    public function setAlternateNo(string $alternate_no): self
    {
        $this->alternate_no = $alternate_no;

        return $this;
    }

    public function getImageUrl(): ?string
    {
        return $this->image_url;
    }

    public function setImageUrl(?string $image_url): self
    {
        $this->image_url = $image_url;

        return $this;
    }

    public function getThumbnailUrl(): ?string
    {
        return $this->thumbnail_url;
    }

    public function setThumbnailUrl(?string $thumbnail_url): self
    {
        $this->thumbnail_url = $thumbnail_url;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }

    public function getDimX(): ?string
    {
        return $this->dim_x;
    }

    public function setDimX(?string $dim_x): self
    {
        $this->dim_x = $dim_x;

        return $this;
    }

    public function getDimY(): ?string
    {
        return $this->dim_y;
    }

    public function setDimY(?string $dim_y): self
    {
        $this->dim_y = $dim_y;

        return $this;
    }

    public function getDimZ(): ?string
    {
        return $this->dim_z;
    }

    public function setDimZ(?string $dim_z): self
    {
        $this->dim_z = $dim_z;

        return $this;
    }

    public function getYearReleased(): ?int
    {
        return $this->year_released;
    }

    public function setYearReleased(?int $year_released): self
    {
        $this->year_released = $year_released;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function isIsObsolete(): ?bool
    {
        return $this->is_obsolete;
    }

    public function setIsObsolete(?bool $is_obsolete): self
    {
        $this->is_obsolete = $is_obsolete;

        return $this;
    }

    public function getLanguageCode(): ?string
    {
        return $this->language_code;
    }

    public function setLanguageCode(?string $language_code): self
    {
        $this->language_code = $language_code;

        return $this;
    }

    /**
     * @return Collection<int, Inventory>
     */
    public function getInventories(): Collection
    {
        return $this->inventories;
    }

    public function addInventory(Inventory $inventory): self
    {
        if (!$this->inventories->contains($inventory)) {
            $this->inventories[] = $inventory;
            $inventory->setItem($this);
        }

        return $this;
    }

    public function removeInventory(Inventory $inventory): self
    {
        if ($this->inventories->removeElement($inventory)) {
            // set the owning side to null (unless already changed)
            if ($inventory->getItem() === $this) {
                $inventory->setItem(null);
            }
        }

        return $this;
    }
    
}
