<?php


namespace App\Controller\Api;


use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation as Nelmio;


/**
 * @Rest\Route("/api")
 * @Nelmio\Areas({"internal"})
 */
class UserController extends AbstractFOSRestController
{


    private $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }



    /**
    * @Rest\Get(path="/users")
    * @Rest\View(serializerGroups={"user"}, serializerEnableMaxDepthChecks=true)
    */
    public function getUsers()
    {
        $users = $this->userService->getAllUsers();
        return $this->json($users, Response::HTTP_OK, [], ['groups' => ['user']]);
    }


    /**
    * @Rest\Get(path="/users/{id}", requirements={"id"="\d+"}) 
    * @Rest\View(serializerGroups={"user"}, serializerEnableMaxDepthChecks=true)
    */
    public function getUserById(int $id)
    {
        $user = $this->userService->getUserById($id);

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }
    
        return $this->json($user, Response::HTTP_OK, [], ['groups' => ['user']]);
    }


    /** 
    * @Rest\Post(path="/users")
    * @Rest\View(serializerGroups={"user"}, serializerEnableMaxDepthChecks=true)
    */
    public function postUser(Request $request)
    {
        return $this->userService->createUser($request);
    }


    /**
     * @Rest\Put(path="/users/{id}", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"user"}, serializerEnableMaxDepthChecks=true)
     */
    public function putUser( Request $request, int $id)
   {
        return $this->userService->updateUser($request, $id);
    }


    /**
     * @Rest\Patch(path="/users/{id}", requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"user"}, serializerEnableMaxDepthChecks=true)
     */
    public function patchUser(int $id, Request $request)
   {
        return $this->userService->patchUser($request, $id); 
    }


    /**
     * @Rest\Delete(path="/users/{id}" , requirements={"id"="\d+"})
     * @Rest\View(serializerGroups={"user"}, serializerEnableMaxDepthChecks=true)
     */
    public function deleteUser(int $id)
    {
        return $this->userService->deleteUser($id);
    }



}

