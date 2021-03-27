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
    private const KEYS = ['id', 'name', 'surname', 'email', 'country', 'createAt', 'activateAt', 'chargerId'];
    /**
     * @var string
     */
    private string $wallBoxLink;
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
     * @throws \Exception
     */
    public function findAllUsers(?array $criteria = []): array
    {
        $users['items'] = [];
        $reader = Reader::createFromString(file_get_contents($this->wallBoxLink));
        $result = $reader->fetchAssoc(self::KEYS);

        if (isset($criteria['country']) && isset($criteria['activation_length'])) {
            foreach ($result as $row) {
                $createAt = new \DateTime($row['createAt']);
                $activateAt = new \DateTime($row['activateAt']);
                if (in_array($row['country'], $criteria['country']) && $createAt->diff($activateAt)->days >= intval($criteria['activation_length'])) {
                    array_push($users['items'], $row);
                }
            }
        } elseif (isset($criteria['country'])) {
            foreach ($result as $row) {
                if (in_array($row['country'],$criteria['country'])) {
                    array_push($users['items'], $row);
                }
            }
        } elseif (isset($criteria['activation_length'])) {
            foreach ($result as $row) {
                $createAt = new \DateTime($row['createAt']);
                $activateAt = new \DateTime($row['activateAt']);
                if ($createAt->diff($activateAt)->days >= intval($criteria['activation_length'])) {
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
        $result = $reader->fetchAssoc(self::KEYS);
        foreach ($result as $row) {
            if($row['id'] == $id) {
                $user = $row;
                continue;
            }
        }
        return $user;
    }
}
