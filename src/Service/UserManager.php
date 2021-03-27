<?php

declare(strict_types=1);

namespace App\Service;

use App\Interfaces\UserInterface;
use League\Csv\Reader;

/**
 * Class UsersService
 * @package App\Service
 */
class UserManager implements UserInterface
{
    /**
     * @var string
     */
    private string $wallBoxLink;
    /**
     * @var array|string[]
     */
    private array $keys = ['id', 'name', 'surname', 'email', 'country', 'createAt', 'activateAt', 'chargerId'];
    /**
     * UsersService constructor.
     * @param string $wallBoxLink
     */
    public function __construct(string $wallBoxLink)
    {
        $this->wallBoxLink = $wallBoxLink;
    }

    /**
     * @param array|null $criteria
     * @return array
     */
    public function findAllUsers(?array $criteria = []): array
    {
        $users['items'] = [];
        $reader = Reader::createFromString(file_get_contents($this->wallBoxLink));
        $result = $reader->fetchAssoc($this->keys);

        if (isset($criteria['country'])) {
            $country = $criteria['country'];
            foreach ($result as $row) {
                if (in_array($row['country'],$country)) {
                    array_push($users['items'], $row);
                }
            }
        } else {
            $users['items'] = $result;
        }
        return $users;
    }

    /**
     * @param int $id
     * @return array
     */
    public function findOneUser(int $id): array
    {
        $user = [];
        $reader = Reader::createFromString(file_get_contents($this->wallBoxLink));
        $result = $reader->fetchAssoc($this->keys);
        foreach ($result as $row) {
            if($row['id'] == $id) {
                $user = $row;
                continue;
            }
        }
        return $user;
    }
}
