<?php

namespace App\Repository;

interface UserRepositoryInterface extends RepositoryInterface
{
    public function updatePasswordByEmail($email, $password);
}
