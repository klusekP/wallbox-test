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
use OpenApi\Annotations as OA;


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
     * @OA\Get (
     *    @OA\Parameter (
     *              name="country[]",
     *              in="query",
     *              required=false,
     *              description="Diffrence between create date and activation date in days",
     *              @OA\Schema (
     *                  type="array",
     *                  format="array",
     *                  @OA\Items(
     *                      type="string"
     *                  ),
     *                  collectionFormat="multi"
     *              )
     *          ),
     *    @OA\Parameter (
     *              name="activation_length",
     *              in="query",
     *              required=false,
     *              description="Diffrence between create date and activation date in days",
     *              @OA\Schema (
     *                  type="integer",
     *                  format="int"
     *              )
     *          ),
     *     @OA\Parameter (
     *              name="sort_by",
     *              in="query",
     *              required=false,
     *              description="The column by which the data will be sorted",
     *              @OA\Schema (
     *                  type="string",
     *                  format="string"
     *              )
     *          ),
     *      @OA\Parameter (
     *              name="sort",
     *              in="query",
     *              required=false,
     *              description="By default, the data will be sorted ASC, with this parameter the data will be sorted DESC",
     *              @OA\Schema (
     *                  type="string",
     *                  format="string",
     *                  minimum="1"
     *              )
     *          ),
     *      @OA\Response(
     *          response=200,
     *          description="Returns list of all users",
     *           @OA\JsonContent(
     *              @OA\Property(property="items", type="array", format="array",
     *                       @OA\Items(
     *                           @OA\Property(property="id", type="int", example=1),
     *                           @OA\Property(property="name", type="string", example="Joe"),
     *                           @OA\Property(property="surname", type="string", example="Doe"),
     *                           @OA\Property(property="country", type="string", example="FR"),
     *                           @OA\Property(property="createAt", type="string", example="2015-12-06"),
     *                           @OA\Property(property="activateAt", type="string", example="2015-12-25"),
     *                           @OA\Property(property="chargerId", type="int", example=1),
     *                      ),
     *                  ),
     *              @OA\Property(property="allItems", type="int", format="int", example=1),
     *           ),
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="Users not found"
     *      ),
     * )
     * @param Request $request
     * @return View
     */
    public function listAction(Request $request): View
    {
            $criteria                      = [];
            $criteria['country']           = $request->get('country');
            $criteria['activation_length'] = $request->get('activation_length');
            $criteria['sort_by']           = $request->get('sort_by');
            $criteria['sort']              = $request->get('sort');
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
     * @OA\Get(
     *    @OA\Parameter (
     *              name="id",
     *              in="path",
     *              required=true,
     *              description="User ID, int value",
     *              @OA\Schema (
     *                  type="integer",
     *                  format="int",
     *                  minimum="1"
     *              )
     *          ),
     *     @OA\Response(
     *          response=200,
     *          description="Return user",
     *          @OA\JsonContent(
     *               @OA\Property(property="id", type="int", example=1),
     *               @OA\Property(property="name", type="string", example="Joe"),
     *               @OA\Property(property="surname", type="string", example="Doe"),
     *               @OA\Property(property="country", type="string", example="FR"),
     *               @OA\Property(property="createAt", type="string", example="2015-12-06"),
     *               @OA\Property(property="activateAt", type="string", example="2015-12-25"),
     *               @OA\Property(property="chargerId", type="int", example=1),
     *        )
     *      ),
     *      @OA\Response(
     *          response=404,
     *          description="User not found"
     *      )
     * )
     */
    public function getUserAction(int $id): View
    {
            $data = $this->userInterface->findOneUser($id);
            if (!$data) {
                throw new NotFoundHttpException('User Not Found');
            }
            return View::create($data, Response::HTTP_OK);
    }
}
