<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserSubServiceRepository")
 * @ApiResource(
 *     itemOperations={
 *          "get"={
                 "access_control"="is_granted('ROLE_SERVICE_PROVIDER') and object.getUser() == user",
 *               "access_control_message"="You do not have permissions for this resource"
 *          },
 *          "put"={
 *               "access_control"="is_granted('edit_for_provider', object) and object.getUser() == user",
 *               "access_control_message"="You do not have permissions for this resource or you are trying to insert wrong values",
 *               "denormalization_context"={
 *                  "groups"={"put"}
 *              }
 *           }
 *     },
 *     collectionOperations={
 *          "post"={
 *              "access_control"="is_granted('create_for_provider', object)",
 *              "access_control_message"="You do not have permissions for this resource or you are trying to insert wrong values"
 *          }
 *     }
 * )
 * @UniqueEntity(
 *     fields={"user", "service"},
 *     message="Service is already registered for this user. Please register a different service or modify this one."
 * )
 */
class UserSubService implements AuthoredEntityInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\User", inversedBy="userSubServices")
     */
    private $user;


    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Service", inversedBy="userSubServices")
     * @Assert\NotBlank()
     * @Groups({"put"})
     */
    private $service;

    /**
     * @ORM\ManyToMany(targetEntity="App\Entity\SubService", inversedBy="userSubServices")
     * @Groups({"put"})
     */
    private $subServices;

    private $subService;

    public function __construct()
    {
        $this->subServices = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?UserInterface $user): AuthoredEntityInterface
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
    public function getSubServices(): Collection
    {
        return $this->subServices;
    }

    public function addSubService(SubService $subService): self
    {
        if (!$this->subServices->contains($subService)) {
            $this->subServices[] = $subService;
        }

        return $this;
    }

    public function removeSubService(SubService $subService): self
    {
        if ($this->subServices->contains($subService)) {
            $this->subServices->removeElement($subService);
        }

        return $this;
    }

    public function getSubService(){
        return $this->subServices;
    }

    public function setSubService(Collection $subServices){
        $this->subServices = $subServices;
    }

    public function __toString()
    {
        return $this->getUser()->getName();
    }
}
