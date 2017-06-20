<?php

namespace Liqster\HomePageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Product
 *
 * @ORM\Table(name="product")
 * @ORM\Entity(repositoryClass="Liqster\HomePageBundle\Repository\ProductRepository")
 */
class Product
{
    /**
     * @var \Ramsey\Uuid\Uuid
     *
     * @ORM\Id
     * @ORM\Column(type="uuid")
     * @ORM\GeneratedValue(strategy="CUSTOM")
     * @ORM\CustomIdGenerator(class="Ramsey\Uuid\Doctrine\UuidGenerator")
     */
    private $id;

    /**
     * @ORM\OneToMany(targetEntity="Liqster\HomePageBundle\Entity\Purchase", mappedBy="purchase")
     */
    private $purchase;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_created", type="datetime", unique=false, nullable=true)
     */
    private $create;

    /**
     * @var \DateTime
     * @ORM\Column(name="date_modification", type="datetime", unique=false, nullable=true)
     */
    private $modification;

    /**
     * @var integer
     * @ORM\Column(name="period", type="integer", unique=false, nullable=true)
     */
    private $period;

    /**
     * @var string
     * @ORM\Column(name="type", type="string", unique=false, nullable=true)
     */
    private $type;

    /**
     * @return \Ramsey\Uuid\Uuid
     */
    public function getId(): \Ramsey\Uuid\Uuid
    {
        return $this->id;
    }

    /**
     * @param \Ramsey\Uuid\Uuid $id
     * @return Product
     */
    public function setId(\Ramsey\Uuid\Uuid $id): Product
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getPurchase()
    {
        return $this->purchase;
    }

    /**
     * @param mixed $purchase
     * @return Product
     */
    public function setPurchase($purchase)
    {
        $this->purchase = $purchase;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getCreate(): \DateTime
    {
        return $this->create;
    }

    /**
     * @param \DateTime $create
     * @return Product
     */
    public function setCreate(\DateTime $create): Product
    {
        $this->create = $create;
        return $this;
    }

    /**
     * @return \DateTime
     */
    public function getModification(): \DateTime
    {
        return $this->modification;
    }

    /**
     * @param \DateTime $modification
     * @return Product
     */
    public function setModification(\DateTime $modification): Product
    {
        $this->modification = $modification;
        return $this;
    }

    /**
     * @return int
     */
    public function getPeriod(): int
    {
        return $this->period;
    }

    /**
     * @param int $period
     * @return Product
     */
    public function setPeriod(int $period): Product
    {
        $this->period = $period;
        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     * @return Product
     */
    public function setType(string $type): Product
    {
        $this->type = $type;
        return $this;
    }
}
