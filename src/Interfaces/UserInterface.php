<?php

declare(strict_types=1);

namespace App\Interfaces;

/**
 * Interface UserInterface
 * @package App\Interfaces
 */
interface UserInterface
{
    /**
     * @param array|null $criteria
     * @return array
     */
    public function findAllUsers(?array $criteria): array;

    /**
     * @param int $id
     * @return array
     */
    public function findOneUser(int $id): array;
}
