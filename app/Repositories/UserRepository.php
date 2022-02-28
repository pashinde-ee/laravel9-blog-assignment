<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Models\User;

class UserRepository extends Contracts\Repository
{
    /**
     * UserRepository constructor.
     *
     * @param User $user
     */
    public function __construct(User $user)
    {
        $this->model = $user;
    }
}
