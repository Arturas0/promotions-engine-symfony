<?php

namespace App\Entity;

use App\Repository\PromotionRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromotionRepository::class)]
class Promotion
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id = 0;

    #[ORM\Column(length: 255)]
    private string $name;

    #[ORM\Column(length: 255)]
    private string $type;

    #[ORM\Column(type: 'float')]
    private ?float $adjustment = null;

    #[ORM\Column(type: 'json')]
    private array $criteria = [];

    #[ORM\OneToMany(mappedBy: 'promotion', targetEntity: ProductPromotion::class)]
    private Collection $productPromotions;

    public function __construct()
    {
        $this->productPromotions = new ArrayCollection();
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

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): self
    {
        $this->type = $type;

        return $this;
    }

    public function getAdjustment(): ?string
    {
        return $this->adjustment;
    }

    public function setAdjustment(string $adjustment): self
    {
        $this->adjustment = $adjustment;

        return $this;
    }

    public function getCriteria(): array
    {
        return $this->criteria;
    }

    public function setCriteria(array $criteria): self
    {
        $this->criteria = $criteria;

        return $this;
    }

    /**
     * @return ArrayCollection|Collection
     */
    public function getProductPromotions(): ArrayCollection|Collection
    {
        return $this->productPromotions;
    }
}
