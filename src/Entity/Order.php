<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\OrderRepository")
 */
class Order
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="orders")
     */
    private $client;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $serviceType;

    /**
     * @ORM\Column(type="string", length=1)
     */
    private $orderType;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $jobRequirements;

    /**
     * @ORM\Column(type="datetime")
     */
    private $enrollDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $expireDate;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Services", inversedBy="orders")
     */
    private $service;

    /**
     * @ORM\Column(type="datetime")
     */
    private $auctionDate;

    /**
     * @ORM\Column(type="datetime")
     */
    private $orderExpirationDate;

    /**
     * @ORM\Column(type="string", length=5, nullable=true)
     */
    private $typeServiceProvider;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getServiceType(): ?string
    {
        return $this->serviceType;
    }

    public function setServiceType(string $serviceType): self
    {
        $this->serviceType = $serviceType;

        return $this;
    }

    public function getOrderType(): ?string
    {
        return $this->orderType;
    }

    public function setOrderType(string $orderType): self
    {
        $this->orderType = $orderType;

        return $this;
    }

    public function getJobRequirements(): ?string
    {
        return $this->jobRequirements;
    }

    public function setJobRequirements(string $jobRequirements): self
    {
        $this->jobRequirements = $jobRequirements;

        return $this;
    }

    public function getEnrollDate(): ?\DateTimeInterface
    {
        return $this->enrollDate;
    }

    public function setEnrollDate(\DateTimeInterface $enrollDate): self
    {
        $this->enrollDate = $enrollDate;

        return $this;
    }

    public function getExpireDate(): ?\DateTimeInterface
    {
        return $this->expireDate;
    }

    public function setExpireDate(\DateTimeInterface $expireDate): self
    {
        $this->expireDate = $expireDate;

        return $this;
    }

    public function getService(): ?Services
    {
        return $this->service;
    }

    public function setService(?Services $service): self
    {
        $this->service = $service;

        return $this;
    }

    public function getAuctionDate(): ?\DateTimeInterface
    {
        return $this->auctionDate;
    }

    public function setAuctionDate(\DateTimeInterface $auctionDate): self
    {
        $this->auctionDate = $auctionDate;

        return $this;
    }

    public function getOrderExpirationDate(): ?\DateTimeInterface
    {
        return $this->orderExpirationDate;
    }

    public function setOrderExpirationDate(\DateTimeInterface $orderExpirationDate): self
    {
        $this->orderExpirationDate = $orderExpirationDate;

        return $this;
    }

    public function getTypeServiceProvider(): ?string
    {
        return $this->typeServiceProvider;
    }

    public function setTypeServiceProvider(?string $typeServiceProvider): self
    {
        $this->typeServiceProvider = $typeServiceProvider;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }
}
