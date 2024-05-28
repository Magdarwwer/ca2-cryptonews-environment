<?php

namespace Salle\LSCryptoNews\model\repository;

use PDO;
use Salle\LSCryptoNews\model\User;
use Salle\LSCryptoNews\model\UserRepository;

final class MySqlUserRepository implements UserRepository
{
    private PDO $database;

    public function __construct(PDO $database)
    {
        $this->database = $database;
    }

    public function save(User $user): void
    {
        $query = <<<'QUERY'
        INSERT INTO user(email, password, coins)
        VALUES(:email, :password, :coins)
        QUERY;

        $statement = $this->database->prepare($query);

        $email = $user->email();
        $password = $user->password();
        $coins = $user->coins();

        $statement->bindParam(':email', $email, PDO::PARAM_STR);
        $statement->bindParam(':password', $password, PDO::PARAM_STR);
        $statement->bindParam(':coins', $coins, PDO::PARAM_INT);

        $statement->execute();
    }
}