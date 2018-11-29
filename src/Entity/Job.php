<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\JobRepository")
 */
class Job
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="jobs")
     */
    private $client;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Order", cascade={"persist", "remove"})
     */
    private $ord;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\ServiceProvider", inversedBy="jobs")
     */
    private $serviceProvider;

    /**
     * @ORM\Column(type="datetime")
     */
    private $executionDate;


    /**
     * @ORM\Column(type="datetime")
     */
    private $endTime;

    /**
     * @ORM\Column(type="float")
     */
    private $clientRating;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ratingDescription;

    /**
     * @ORM\Column(type="float")
     */
    private $serviceProviderRating;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $serviceProviderRatingDescription;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Materials", mappedBy="job")
     */
    private $materials;

    public function __construct()
    {
        $this->materials = new ArrayCollection();
    }

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

    public function getOrd(): ?Order
    {
        return $this->ord;
    }

    public function setOrd(?Order $ord): self
    {
        $this->ord = $ord;

        return $this;
    }

    public function getServiceProvider(): ?ServiceProvider
    {
        return $this->serviceProvider;
    }

    public function setServiceProvider(?ServiceProvider $serviceProvider): self
    {
        $this->serviceProvider = $serviceProvider;

        return $this;
    }

    public function getExecutionDate(): ?\DateTimeInterface
    {
        return $this->executionDate;
    }

    public function setExecutionDate(\DateTimeInterface $executionDate): self
    {
        $this->executionDate = $executionDate;

        return $this;
    }


    public function getEndTime(): ?\DateTimeInterface
    {
        return $this->endTime;
    }

    public function setEndTime(\DateTimeInterface $endTime): self
    {
        $this->endTime = $endTime;

        return $this;
    }

    public function getClientRating(): ?float
    {
        return $this->clientRating;
    }

    public function setClientRating(float $clientRating): self
    {
        $this->clientRating = $clientRating;

        return $this;
    }

    public function getRatingDescription(): ?string
    {
        return $this->ratingDescription;
    }

    public function setRatingDescription(string $ratingDescription): self
    {
        $this->ratingDescription = $ratingDescription;

        return $this;
    }

    public function getServiceProviderRating(): ?float
    {
        return $this->serviceProviderRating;
    }

    public function setServiceProviderRating(float $serviceProviderRating): self
    {
        $this->serviceProviderRating = $serviceProviderRating;

        return $this;
    }

    public function getServiceProviderRatingDescription(): ?string
    {
        return $this->serviceProviderRatingDescription;
    }

    public function setServiceProviderRatingDescription(string $serviceProviderRatingDescription): self
    {
        $this->serviceProviderRatingDescription = $serviceProviderRatingDescription;

        return $this;
    }

    /**
     * @return Collection|Materials[]
     */
    public function getMaterials(): Collection
    {
        return $this->materials;
    }

    public function addMaterial(Materials $material): self
    {
        if (!$this->materials->contains($material)) {
            $this->materials[] = $material;
            $material->setJob($this);
        }

        return $this;
    }

    public function removeMaterial(Materials $material): self
    {
        if ($this->materials->contains($material)) {
            $this->materials->removeElement($material);
            // set the owning side to null (unless already changed)
            if ($material->getJob() === $this) {
                $material->setJob(null);
            }
        }

        return $this;
    }
}
