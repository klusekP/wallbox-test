<?php

declare(strict_types=1);

namespace App\Service;

use App\Interfaces\UserInterface;

/**
 * Class UsersService
 * @package App\Service
 */
class UserManager implements UserInterface
{
    private const KEYS = ['id', 'name', 'surname', 'email', 'country', 'createAt', 'activateAt', 'chargerId'];
    private const DESC = 'desc';
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
        $result = $this->importCsvToArray();
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

        if (isset($criteria['sort_by']) && in_array($criteria['sort_by'], self::KEYS)) {
            $criteriaValue = $criteria['sort_by'];
            if (isset($criteria['sort']) && $criteria['sort'] == self::DESC) {
                uasort($users['items'], function ($a, $b) use ($criteriaValue) {
                    return $b[$criteriaValue] <=> $a[$criteriaValue];
                });
            } else {
                uasort($users['items'], function ($a, $b) use ($criteriaValue) {
                    return $a[$criteriaValue] <=> $b[$criteriaValue];
                });
            }
        }

        $users['allItems'] = count($users['items']);
        return $users;
    }

    /**
     * @param int $id
     * @return array
     */
    public function findOneUser(int $id): array
    {
        $user = [];
        $result = $this->importCsvToArray();
        foreach ($result as $row) {
            if($row['id'] == $id) {
                $user = $row;
                continue;
            }
        }
        return $user;
    }

    /**
     * @return array
     */
    private function importCsvToArray(): array
    {
        $result = [];
        if (($fp = fopen($this->wallBoxLink, 'r')) !== FALSE) {
            while (($row = fgetcsv($fp, 1000, ',')) !== FALSE) {
                $item = [
                    'id'         => intval($row[0]),
                    'name'       => $row[1],
                    'surname'    => $row[2],
                    'email'      => $row[3],
                    'country'    => $row[4],
                    'createAt'   => $row[5],
                    'activateAt' => $row[6],
                    'chargerId'  => intval($row[7])
                ];
                array_push( $result, $item);
            }
            fclose($fp);
        }
        return $result;
    }
}
