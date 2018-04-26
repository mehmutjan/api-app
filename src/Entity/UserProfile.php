<?php

namespace App\Entity;

use ApiPlatform\Core\Annotation\ApiSubresource;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Core\Annotation\ApiResource;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserProfileRepository")
 * @ApiResource()
 */
class UserProfile
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=64, nullable=true)
     */
    private $truename;

    /**
     * @ORM\Column(type="integer", length=11, nullable=true)
     */
    private $mobile;

    /**
     * @ORM\OneToOne(targetEntity="User", inversedBy="userProfile")
     * @ORM\JoinColumn(referencedColumnName="id", unique=true)
     * @ApiSubresource()
     */
    private $user;

    public function getUser()
    {
        return $this->user;
    }

    public function setUser($user)
    {
        $this->user = $user;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * @return mixed
     */
    public function getTruename()
    {
        return $this->truename;
    }

    /**
     * @param mixed $truename
     */
    public function setTruename($truename): void
    {
        $this->truename = $truename;
    }

    /**
     * @return mixed
     */
    public function getMobile()
    {
        return $this->mobile;
    }

    /**
     * @param mixed $mobile
     */
    public function setMobile($mobile): void
    {
        $this->mobile = $mobile;
    }
}
