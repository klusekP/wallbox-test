<?php

declare(strict_types=1);

namespace App\Controller;

use App\Interfaces\UserInterface;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\View\View;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class UsersController
 * @package App\Controller
 */
class UserController extends AbstractFOSRestController
{
    /** @var UserInterface */
    private UserInterface $userInterface;
    /**
     * UserController constructor.
     * @param UserInterface $userInterface
     */
    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }
    /**
     * @Rest\Get("/users", name="get_all_users")
     * @param Request $request
     * @return View
     */
    public function listAction(Request $request): View
    {
            $criteria = json_decode($request->getContent(), true);
            $data = $this->userInterface->findAllUsers($criteria);
            if (!$data) {
                throw new NotFoundHttpException('Users not found');
            }
            return View::create($data, Response::HTTP_OK);
    }

    /**
     * @Rest\Get("/users/{id}", name="get_single_user")
     * @param int $id
     * @return View
     */
    public function getUserAction(int $id): View
    {
        $data = $this->userInterface->findOneUser($id);
        if (!$data) {
            throw new NotFoundHttpException('User Not Found');
        }
        return View::create($data,Response::HTTP_OK);
    }
}
