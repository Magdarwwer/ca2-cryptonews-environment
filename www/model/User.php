<?php

namespace Salle\LSCryptoNews\model;

class User
{
    private int $id;
    private string $email;
    private string $password;
    private int $coins;


    public function __construct(
        string $email,
        string $password,
        int $coins
    ) {
        $this->email = $email;
        $this->password = $password;
        $this->coins = $coins;
    }

    public function id(): int
    {
        return $this->id;
    }

    public function setId(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    public function email(): string
    {
        return $this->email;
    }

    public function password(): string
    {
        return $this->password;
    }

    public function coins(): int
    {
        return $this->coins;
    }

    public function setCoins(int $coins): self
    {
        $this->coins = $coins;
        return $this;
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function getCoins(): int
    {
        return $this->coins;
    }
}