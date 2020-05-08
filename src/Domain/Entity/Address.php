<?php

namespace App\Domain\Entity;

use App\Core\Traits\TimeRecordsTrait;
use Doctrine\ORM\Mapping AS ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="address")
 */
class Address
{
    use TimeRecordsTrait;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer", unique=true)
     */
    private $id;
    
    /**
     * @ORM\Column(type="string", nullable=true, length=35)
     */
    protected $firstName;

    /**
     * @ORM\Column(type="string", nullable=true, length=35)
     */
    protected $lastName;

    /**
     * @ORM\Column(type="string", unique=true, length=75)
     */
    protected $email;

    /**
     * @ORM\Column(name="birthday", type="date", nullable=true)
     */
    private $birthday;
    
    /**
     * @ORM\Column(type="string", unique=true, length=75)
     */
    protected $street_address;
    
    /**
     * @ORM\Column(type="string", unique=true, length=7)
     */
    protected $zip;
    
    /**
     * @ORM\Column(type="string", unique=true, length=75)
     */
    protected $city;
    
    /**
 * @ORM\Column(type="string", unique=true, length=75)
 */
    protected $country;
    
    /**
    * @ORM\Column(type="string", unique=true, length=35)
    */
    protected $phone;
    
    /**
     * @ORM\Column(type="string", unique=true, length=75)
     */
    protected $picture;
    
    /**
     *
     * Populate entity with data
     *
     * @param array $array
     * @return Address|null
     */
    public function populate(array $array): ?self
    {
        if (!empty($array['id']) ) {
            $this->setId($array['id']);
        }

        if (!empty($array['firstName']) ) {
            $this->setFirstName($array['firstName']);
        }

        if (!empty($array['lastName'])) {
            $this->setLastName($array['lastName']);
        }

        if (!empty($array['email'])) {
            $this->setEmail($array['email']);
        }

        if (!empty($array['birthday'])) {
            $this->setBirthday($array['birthday']);
        }
    
        if (!empty($array['street_address'])) {
            $this->setCity($array['street_address']);
        }
        
        if (!empty($array['city'])) {
            $this->setCity($array['city']);
        }
    
        if (!empty($array['zip'])) {
            $this->setCity($array['zip']);
        }
    
        if (!empty($array['phone'])) {
            $this->setCity($array['phone']);
        }
    
        if (!empty($array['country'])) {
            $this->setCity($array['country']);
        }
    
        if (!empty($array['picture'])) {
            $this->setCity($array['picture']);
        }
        
        return $this;
    }

    /**
     * Account constructor.
     * @param array $data
     */
    public function __construct(array $data = [])
    {
        return $this->populate($data);
    }
    
    /**
     * @return mixed
     */
    public function getId(): ?string
    {
        return $this->id;
    }

    /**
     * @param $id
     * @return Address
     */
    public function setId($id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @param $firstName
     * @return Address
     */
    public function setFirstName($firstName): self
    {
        $this->firstName = $firstName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    /**
     * @param $lastName
     * @return Address
     */
    public function setLastName($lastName): self
    {
        $this->lastName = $lastName;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param $email
     * @return Address
     */
    public function setEmail($email): self
    {
        $this->email = $email;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getBirthday(): ?\DateTime
    {
        return $this->birthday;
    }

    /**
     * @param \DateTime|null $birthday
     * @return Address|null
     */
    public function setBirthday(\DateTime $birthday = null): ?self
    {
        $this->birthday = $birthday ? clone $birthday : null;
        return $this;
    }
    
    /**
     * @return null|string
     */
    public function getStreetAddress(): ?string
    {
        return $this->street_address;
    }
    
    /**
     * @param string $street_address
     * @return Address
     */
    public function setStreetAddress(string $street_address): self
    {
        $this->street_address = $street_address;
        return $this;
    }
    
    /**
     * @return null|string
     */
    public function getCity(): ?string
    {
        return $this->city;
    }
    
    /**
     * @param $city
     * @return Address
     */
    public function setCity($city): self
    {
        $this->city = $city;
        return $this;
    }
    
    /**
     * @return null|string
     */
    public function getZip(): ?string
    {
        return $this->zip;
    }
    
    /**
     * @param $zip
     * @return Address
     */
    public function setZip($zip): self
    {
        $this->zip = $zip;
        return $this;
    }
    
    /**
     * @return null|string
     */
    public function getCountry(): ?string
    {
        return $this->country;
    }
    
    /**
     * @param $country
     * @return Address
     */
    public function setCountry($country): self
    {
        $this->country = $country;
        return $this;
    }
    
    /**
     * @return mixed
     */
    public function getPhone(): ?string
    {
        return $this->phone;
    }
    
    /**
     * @param $phone
     * @return Address
     */
    public function setPhone($phone): self
    {
        $this->phone = $phone;
        return $this;
    }
    
    /**
     * @return null|string
     */
    public function getPicture(): ?string
    {
        return $this->picture;
    }
    
    /**
     * @param $picture
     * @return Address
     */
    public function setPicture($picture): self
    {
        $this->picture = $picture;
        return $this;
    }

    
    /**
     * @return array
     */
    public function toArray(): array
    {
        $array = [
            'id'        => $this->getId(),
            'firstName' => $this->getFirstName(),
            'lastName'  => $this->getLastName(),
            'streetAddress'  => $this->getStreetAddress(),
            'zip'  => $this->getZip(),
            'city'  => $this->getCity(),
            'country'  => $this->getCountry(),
            'phone'  => $this->getPhone(),
            'email'     => $this->getEmail(),
            'picture'      => $this->getPicture(),
            'createdAt'    => $this->getCreatedAt()
        ];

        if (empty($this->getId())) {
            unset($array['id']);
        }

        return $array;
    }
}
