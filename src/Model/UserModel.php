<?php


namespace App\Model;

use DateTime;

/**
 * Class UserModel
 * @package App\Model
 */
class UserModel
{
    /**
     * @var int
     */
    private int $id;
    /**
     * @var string
     */
    private string $name;
    /**
     * @var string
     */
    private string $surname;
    /**
     * @var string
     */
    private string $email;
    /**
     * @var string
     */
    private string $country;
    /**
     * @var DateTime
     */
    private DateTime $createAt;
    /**
     * @var DateTime
     */
    private DateTime $activateAt;
    /**
     * @var int
     */
    private int $chargerId;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getSurname(): string
    {
        return $this->surname;
    }

    /**
     * @param string $surname
     */
    public function setSurname(string $surname): void
    {
        $this->surname = $surname;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getCountry(): string
    {
        return $this->country;
    }

    /**
     * @param string $country
     */
    public function setCountry(string $country): void
    {
        $this->country = $country;
    }

    /**
     * @return DateTime
     */
    public function getCreateAt(): DateTime
    {
        return $this->createAt;
    }

    /**
     * @param DateTime $createAt
     */
    public function setCreateAt(DateTime $createAt): void
    {
        $this->createAt = $createAt;
    }

    /**
     * @return DateTime
     */
    public function getActivateAt(): DateTime
    {
        return $this->activateAt;
    }

    /**
     * @param DateTime $activateAt
     */
    public function setActivateAt(DateTime $activateAt): void
    {
        $this->activateAt = $activateAt;
    }

    /**
     * @return int
     */
    public function getChargerId(): int
    {
        return $this->chargerId;
    }

    /**
     * @param int $chargerId
     */
    public function setChargerId(int $chargerId): void
    {
        $this->chargerId = $chargerId;
    }


}
