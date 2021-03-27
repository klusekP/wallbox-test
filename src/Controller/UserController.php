<?php

namespace App\Controller;

use App\Service\UserManager;
use Fos\RestBundle\View\View;
use FOS\RestBundle\Controller\Annotations as Rest;
use Symfony\Component\HttpFoundation\Request;


/**
 * Class UsersController
 * @package App\Controller
 */
class UserController extends AbstractController
{
    /** @var UserManager */
    private UserManager $userManager;

    /**
     * UserController constructor.
     * @param UserManager $userManager
     */
    public function __construct(UserManager $userManager)
    {
        $this->userManager = $userManager;
    }


    /**
     * @Rest\Get("users", name="get_all_users")
     * @param Request $request
     * @return View
     */
    public function listAction(Request $request): View
    {
            $data = $this->userManager->getAllUsers();
            return $this->view($data);
    }
}
