<?php

namespace Salle\LSCryptoNews\model;

interface UserRepository
{
    public function save(User $user): void;

    public function getCryptoBalance(mixed $userId);

}