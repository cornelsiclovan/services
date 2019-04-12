<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiResource;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ApiResource(
 *     itemOperations={
 *          "get"={
                "access_control"="is_granted('IS_AUTHENTICATED_FULLY')"
 *          }
 *      },
 *     collectionOperations={
 *          "post"
 *     }
 * )
 */
class User implements UserInterface
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $name;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $firstName;

    /**
     * @ORM\Column(type="string", length=100)
     */
    private $email;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $telephone;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $country;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $city;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $street;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $number;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $building;

    /**
     * @ORM\Column(type="string", length=50, nullable=true)
     */
    private $staircase;

    /**
     * @ORM\Column(type="string", length=10, nullable=true)
     */
    private $apartment;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $password;

    private $plainPassword;

    /**
     * @ORM\Column(type="json_array")
     */
    private $roles;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\UserSubService", mappedBy="user")
     */
    private $userSubServices;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isServiceProvider;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isClient;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\ClientSubService", mappedBy="user")
     */
    private $clientSubServices;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commment", mappedBy="author")
     */
    private $commments;

    public function __construct()
    {
        $this->userSubServices = new ArrayCollection();
        $this->clientSubServices = new ArrayCollection();
        $this->commments = new ArrayCollection();
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

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(?string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    public function getTelephone(): ?string
    {
        return $this->telephone;
    }

    public function setTelephone(string $telephone): self
    {
        $this->telephone = $telephone;

        return $this;
    }

    public function getCountry(): ?string
    {
        return $this->country;
    }

    public function setCountry(string $country): self
    {
        $this->country = $country;

        return $this;
    }

    public function getCity(): ?string
    {
        return $this->city;
    }

    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    public function getStreet(): ?string
    {
        return $this->street;
    }

    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(?string $number): self
    {
        $this->number = $number;

        return $this;
    }

    public function getBuilding(): ?string
    {
        return $this->building;
    }

    public function setBuilding(?string $building): self
    {
        $this->building = $building;

        return $this;
    }

    public function getStaircase(): ?string
    {
        return $this->staircase;
    }

    public function setStaircase(?string $staircase): self
    {
        $this->staircase = $staircase;

        return $this;
    }

    public function getApartment(): ?string
    {
        return $this->apartment;
    }

    public function setApartment(?string $apartment): self
    {
        $this->apartment = $apartment;

        return $this;
    }

    /**
     * Returns the roles granted to the user.
     *
     *     public function getRoles()
     *     {
     *         return array('ROLE_USER');
     *     }
     *
     * Alternatively, the roles might be stored on a ``roles`` property,
     * and populated in any number of different ways when the user object
     * is created.
     *
     * @return (Role|string)[] The user roles
     */
    public function getRoles()
    {
        $roles = $this->roles;
        if(!in_array('ROLE_USER', $roles)){
            $roles[] = 'ROLE_USER';
        }

        return $roles;
    }

    /**
     * Returns the password used to authenticate the user.
     *
     * This should be the encoded password. On authentication, a plain-text
     * password will be salted, encoded, and then compared to this value.
     *
     * @return string The password
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Returns the salt that was originally used to encode the password.
     *
     * This can return null if the password was not encoded using a salt.
     *
     * @return string|null The salt
     */
    public function getSalt()
    {
    }

    /**
     * Returns the username used to authenticate the user.
     *
     * @return string The username
     */
    public function getUsername()
    {
        return $this->email;
    }

    /**
     * Removes sensitive data from the user.
     *
     * This is important if, at any given point, sensitive information like
     * the plain-text password is stored on this object.
     */
    public function eraseCredentials()
    {
        $this->plainPassword = null;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;

        return $this;
    }

    public function setRoles($roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPlainPassword(){
        return $this->plainPassword;
    }

    public function setPlainPassword($plainPassword){
        $this->plainPassword = $plainPassword;
        $this->password = null;
    }


    /**
     * @return Collection|UserSubService[]
     */
    public function getUserSubServices(): Collection
    {
        return $this->userSubServices;
    }

    public function addUserSubService(UserSubService $userSubService): self
    {
        if (!$this->userSubServices->contains($userSubService)) {
            $this->userSubServices[] = $userSubService;
            $userSubService->setUser($this);
        }

        return $this;
    }

    public function removeUserSubService(UserSubService $userSubService): self
    {
        if ($this->userSubServices->contains($userSubService)) {
            $this->userSubServices->removeElement($userSubService);
            // set the owning side to null (unless already changed)
            if ($userSubService->getUser() === $this) {
                $userSubService->setUser(null);
            }
        }

        return $this;
    }

    public function getIsServiceProvider(): ?bool
    {
        return $this->isServiceProvider;
    }

    public function setIsServiceProvider(bool $isServiceProvider): self
    {
        $this->isServiceProvider = $isServiceProvider;

        return $this;
    }

    public function getIsClient(): ?bool
    {
        return $this->isClient;
    }

    public function setIsClient(bool $isClient): self
    {
        $this->isClient = $isClient;

        return $this;
    }

    /**
     * @return Collection|ClientSubService[]
     */
    public function getClientSubServices(): Collection
    {
        return $this->clientSubServices;
    }

    public function addClientSubService(ClientSubService $clientSubService): self
    {
        if (!$this->clientSubServices->contains($clientSubService)) {
            $this->clientSubServices[] = $clientSubService;
            $clientSubService->setUser($this);
        }

        return $this;
    }

    public function removeClientSubService(ClientSubService $clientSubService): self
    {
        if ($this->clientSubServices->contains($clientSubService)) {
            $this->clientSubServices->removeElement($clientSubService);
            // set the owning side to null (unless already changed)
            if ($clientSubService->getUser() === $this) {
                $clientSubService->setUser(null);
            }
        }

        return $this;
    }


    public function __toString()
    {
       return $this->getFirstName().' '.$this->getName();
    }

    /**
     * @return Collection|Commment[]
     */
    public function getCommments(): Collection
    {
        return $this->commments;
    }

    public function addCommment(Commment $commment): self
    {
        if (!$this->commments->contains($commment)) {
            $this->commments[] = $commment;
            $commment->setAuthor($this);
        }

        return $this;
    }

    public function removeCommment(Commment $commment): self
    {
        if ($this->commments->contains($commment)) {
            $this->commments->removeElement($commment);
            // set the owning side to null (unless already changed)
            if ($commment->getAuthor() === $this) {
                $commment->setAuthor(null);
            }
        }

        return $this;
    }
}
