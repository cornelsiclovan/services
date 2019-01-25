<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ServiceProviderRepository")
 */
class ServiceProvider
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", cascade={"persist", "remove"})
     */
    private $user;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Service", cascade={"persist", "remove"})
     */
    private $service;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\SubService", mappedBy="serviceProvider")
     */
    private $subService;

    public function __construct()
    {
        $this->subService = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getService(): ?Service
    {
        return $this->service;
    }

    public function setService(?Service $service): self
    {
        $this->service = $service;

        return $this;
    }

    /**
     * @return Collection|SubService[]
     */
    public function getSubService(): Collection
    {
        return $this->subService;
    }

    public function addSubService(SubService $subService): self
    {
        if (!$this->subService->contains($subService)) {
            $this->subService[] = $subService;
            $subService->setServiceProvider($this);
        }

        return $this;
    }

    public function removeSubService(SubService $subService): self
    {
        if ($this->subService->contains($subService)) {
            $this->subService->removeElement($subService);
            // set the owning side to null (unless already changed)
            if ($subService->getServiceProvider() === $this) {
                $subService->setServiceProvider(null);
            }
        }

        return $this;
    }
}
