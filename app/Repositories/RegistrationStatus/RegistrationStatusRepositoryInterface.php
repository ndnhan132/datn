<?php

namespace App\Repositories\RegistrationStatus;

interface RegistrationStatusRepositoryInterface
{
    public function findByName($name);
}
