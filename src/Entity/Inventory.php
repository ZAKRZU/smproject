<?php

namespace App\Entity;

use App\Repository\InventoryRepository;
use Doctrine\ORM\Mapping as ORM;

use function PHPUnit\Framework\matches;

#[ORM\Entity(repositoryClass: InventoryRepository::class)]
class Inventory
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $colorId;

    #[ORM\Column(type: 'string', length: 50)]
    private $colorName;

    #[ORM\Column(type: 'integer')]
    private $quantity;

    #[ORM\Column(type: 'string', length: 1)]
    private $newOrUsed;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 4)]
    private $unitPrice;

    #[ORM\Column(type: 'integer')]
    private $bindId;

    #[ORM\Column(type: 'string', length: 255)]
    private $description;

    #[ORM\Column(type: 'string', length: 255)]
    private $remarks;

    #[ORM\Column(type: 'integer')]
    private $bulk;

    #[ORM\Column(type: 'boolean')]
    private $isRetain;

    #[ORM\Column(type: 'boolean')]
    private $isStockRoom;

    #[ORM\Column(type: 'datetime')]
    private $dateCreated;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 4)]
    private $myCost;

    #[ORM\Column(type: 'integer')]
    private $saleRate;

    #[ORM\Column(type: 'integer')]
    private $tierQuantity1;

    #[ORM\Column(type: 'integer')]
    private $tierQuantity2;

    #[ORM\Column(type: 'integer')]
    private $tierQuantity3;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 4)]
    private $tierPrice1;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 4)]
    private $tierPrice2;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 4)]
    private $tierPrice3;

    #[ORM\Column(type: 'decimal', precision: 10, scale: 4)]
    private $myWeight;

    #[ORM\Column(type: 'string', length: 1, nullable: true)]
    private $completeness;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $stockRoomId;

    #[ORM\ManyToOne(targetEntity: BrickItem::class, inversedBy: 'inventories')]
    #[ORM\JoinColumn(nullable: false)]
    private $Item;

    #[ORM\Column(type: 'integer')]
    private $inventoryId;

    public function __construct($json = null)
    {
        if ($json == null)
            return;
        $data = json_decode($json);
        $this->setId($data->inventory_id);
        $this->setItem($data->item);
        $this->setColorId($data->color_id);
        $this->setColorName($data->color_name);
        $this->setQuantity($data->quantity);
        $this->setNewOrUsed($data->new_or_used);
        $this->setUnitPrice($data->unit_price);
        $this->setBindId($data->bind_id);
        $this->setDescription($data->description);
        $this->setRemarks($data->remarks);
        $this->setBulk($data->bulk);
        $this->setIsRetain($data->is_retain);
        $this->setIsStockRoom($data->is_stock_room);

        $tmpDate = new \DateTime();
        $tmpDate->createFromFormat(\DateTimeInterface::ATOM ,$data->date_created);
        $this->setDateCreated($tmpDate);
        $this->setMyCost($data->my_cost);
        $this->setSaleRate($data->sale_rate);
        $this->setTierQuantity1($data->tier_quantity1);
        $this->setTierQuantity2($data->tier_quantity2);
        $this->setTierQuantity3($data->tier_quantity3);
        $this->setTierPrice1($data->tier_price1);
        $this->setTierPrice2($data->tier_price2);
        $this->setTierPrice3($data->tier_price3);
        $this->setMyWeight($data->my_weight);
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;

        return $this;
    }

    public function getColorId(): ?int
    {
        return $this->colorId;
    }

    public function setColorId(int $colorId): self
    {
        $this->colorId = $colorId;

        return $this;
    }

    public function getColorName(): ?string
    {
        return $this->colorName;
    }

    public function setColorName(string $colorName): self
    {
        $this->colorName = $colorName;

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getNewOrUsed(): ?string
    {
        return $this->newOrUsed;
    }

    public function setNewOrUsed(string $newOrUsed): self
    {
        $this->newOrUsed = $newOrUsed;

        return $this;
    }

    public function getUnitPrice(): ?string
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(string $unitPrice): self
    {
        $this->unitPrice = $unitPrice;

        return $this;
    }

    public function getBindId(): ?int
    {
        return $this->bindId;
    }

    public function setBindId(int $bindId): self
    {
        $this->bindId = $bindId;

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

    public function getRemarks(): ?string
    {
        return $this->remarks;
    }

    public function setRemarks(string $remarks): self
    {
        $this->remarks = $remarks;

        return $this;
    }

    public function getBulk(): ?int
    {
        return $this->bulk;
    }

    public function setBulk(int $bulk): self
    {
        $this->bulk = $bulk;

        return $this;
    }

    public function isIsRetain(): ?bool
    {
        return $this->isRetain;
    }

    public function setIsRetain(bool $isRetain): self
    {
        $this->isRetain = $isRetain;

        return $this;
    }

    public function isIsStockRoom(): ?bool
    {
        return $this->isStockRoom;
    }

    public function setIsStockRoom(bool $isStockRoom): self
    {
        $this->isStockRoom = $isStockRoom;

        return $this;
    }

    public function getDateCreated(): ?\DateTimeInterface
    {
        return $this->dateCreated;
    }

    public function setDateCreated(\DateTimeInterface $dateCreated): self
    {
        $this->dateCreated = $dateCreated;

        return $this;
    }

    public function getMyCost(): ?string
    {
        return $this->myCost;
    }

    public function setMyCost(string $myCost): self
    {
        $this->myCost = $myCost;

        return $this;
    }

    public function getSaleRate(): ?int
    {
        return $this->saleRate;
    }

    public function setSaleRate(int $saleRate): self
    {
        $this->saleRate = $saleRate;

        return $this;
    }

    public function getTierQuantity1(): ?int
    {
        return $this->tierQuantity1;
    }

    public function setTierQuantity1(int $tierQuantity1): self
    {
        $this->tierQuantity1 = $tierQuantity1;

        return $this;
    }

    public function getTierQuantity2(): ?int
    {
        return $this->tierQuantity2;
    }

    public function setTierQuantity2(int $tierQuantity2): self
    {
        $this->tierQuantity2 = $tierQuantity2;

        return $this;
    }

    public function getTierQuantity3(): ?int
    {
        return $this->tierQuantity3;
    }

    public function setTierQuantity3(int $tierQuantity3): self
    {
        $this->tierQuantity3 = $tierQuantity3;

        return $this;
    }

    public function getTierPrice1(): ?string
    {
        return $this->tierPrice1;
    }

    public function setTierPrice1(string $tierPrice1): self
    {
        $this->tierPrice1 = $tierPrice1;

        return $this;
    }

    public function getTierPrice2(): ?string
    {
        return $this->tierPrice2;
    }

    public function setTierPrice2(string $tierPrice2): self
    {
        $this->tierPrice2 = $tierPrice2;

        return $this;
    }

    public function getTierPrice3(): ?string
    {
        return $this->tierPrice3;
    }

    public function setTierPrice3(string $tierPrice3): self
    {
        $this->tierPrice3 = $tierPrice3;

        return $this;
    }

    public function getMyWeight(): ?string
    {
        return $this->myWeight;
    }

    public function setMyWeight(string $myWeight): self
    {
        $this->myWeight = $myWeight;

        return $this;
    }

    public function getCompleteness(): ?string
    {
        return $this->completeness;
    }

    public function setCompleteness(?string $completeness): self
    {
        $this->completeness = $completeness;

        return $this;
    }

    public function getStockRoomId(): ?int
    {
        return $this->stockRoomId;
    }

    public function setStockRoomId(?int $stockRoomId): self
    {
        $this->stockRoomId = $stockRoomId;

        return $this;
    }

    public function getItem(): ?BrickItem
    {
        return $this->Item;
    }

    public function setItem(?BrickItem $Item): self
    {
        $this->Item = $Item;

        return $this;
    }

    public function getInventoryId(): ?int
    {
        return $this->inventoryId;
    }

    public function setInventoryId(int $inventoryId): self
    {
        $this->inventoryId = $inventoryId;

        return $this;
    }

    public function __get($property)
    {
        if (property_exists($this, $property))
        {
            return $this->$property;
        }
    }

    public function __set($property, $value)
    {
        if (property_exists($this, $property))
        {
            $this->$property = $value;
        }

        return $this;
    }

    public function update(Inventory $inventory): array
    {
        $hasBeenUpdate = false;
        $logs = [];
        foreach (get_object_vars($this) as $key => $value)
        {
            if ($key === 'id')
                continue;
            if ($key === 'dateCreated')
            {
                if (!($inventory->__get($key) == $this->$key))
                {
                    array_push($logs,
                                'Changed inventory id: '.$this->getInventoryId()
                                .' property '.$key
                                .' from '.$this->$key.' to '.$inventory->__get($key));
                    $this->$key = $inventory->__get($key);
                    $ret = true;
                }
                continue;
            }
            else
            if (!($inventory->__get($key) === $this->$key))
            {
                array_push($logs,
                'Changed inventory id: '.$this->getInventoryId()
                .' property '.$key
                .' from '.$this->$key.' to '.$inventory->__get($key));
                $this->$key = $inventory->__get($key);
                $ret = true;
            }
        }
        return $logs;
    }

    public function getThumbnailUrl(): string{
        $firstLetterOfType = str_split($this->getItem()->getType())[0];
        $itemNo = $this->getItem()->getNo();
        $colorId = $this->getColorId();

        if(preg_match('/I|M|S|B|G|C|U|O/', $firstLetterOfType)){
            return '//img.bricklink.com/'.$firstLetterOfType.'/'.$itemNo.'.jpg';    
        }

        return '//img.bricklink.com/'.$firstLetterOfType.'/'.$colorId.'/'.$itemNo.'.jpg';
    }

    public function getImageUrl(): string{
        $firstLetterOfType = str_split($this->getItem()->getType())[0];
        $itemNo = $this->getItem()->getNo();
        $colorId = $this->getColorId();

        if(preg_match('(Not Applicable)', $colorId)){
            return '//img.bricklink.com/ItemImage/'.$firstLetterOfType.'N/0/'.$itemNo.'.png';    
        }

        return '//img.bricklink.com/ItemImage/'.$firstLetterOfType.'N/'.$colorId.'/'.$itemNo.'.png';
    }

}
