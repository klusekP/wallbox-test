<?php

namespace App\Controller;

use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;
use Fos\RestBundle\View\View;

/**
 * Class UsersController
 * @package App\Controller
 */
class UsersController extends AbstractFOSRestController
{

    /**
     * @Rest\Get("users", name="get_all_users")
     * @param Request $request
     * @return View
     */
    public function getAllUserAction(Request $request)
    {
            return $this->view(['test' => false]);
    }
}
