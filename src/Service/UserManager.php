<?php

namespace App\Service;

use App\Model\UserModel;
use League\Csv\Reader;

/**
 * Class UsersService
 * @package App\Service
 */
class UserManager
{

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
     * @return \Iterator|\League\Csv\Modifier\MapIterator
     */
    public function getAllUsers()
    {

        $keys = ['id', 'name', 'surname', 'email', 'country', 'createAt', 'activateAt', 'chargerId'];
        $reader = Reader::createFromString(file_get_contents($this->wallBoxLink));
        $r = $reader->stripBom(true)
            ->addFilter(UserManager::filterByEmail($value))
            ->fetchAssoc($keys, function ($value) {
                return array_map('strtoupper', $value);
            });

        return $r;
    }

}
