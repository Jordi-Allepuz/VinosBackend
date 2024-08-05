<?php


namespace App\Controller\Api;


use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\AbstractFOSRestController;
use App\Service\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Nelmio\ApiDocBundle\Annotation as Nelmio;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use App\Entity\User;
use App\Form\Type\UserFormType;
use Doctrine\ORM\EntityManagerInterface;

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



    // /** 
    // * @Rest\Post(path="/users")
    // * @Rest\View(serializerGroups={"user"}, serializerEnableMaxDepthChecks=true)
    // */
    // public function register(Request $request, UserPasswordEncoderInterface $encoder, EntityManagerInterface $em)
    // {
	// 	$user = new User();
	// 	$form = $this->createForm(UserFormType::class, $user);
	// 	$form->handleRequest($request);
		
	// 	if (!$form->isSubmitted()) {
    //         return new Response('Bad request', Response::HTTP_BAD_REQUEST);
    //     }
    //     if ($form->isValid()) {
	// 		$user->setRole('ROLE_USER');
	// 		$encoded = $encoder->encodePassword($user, $user->getPassword());
	// 		$user->setPassword($encoded);
			
	// 		$em->persist($user);
	// 		$em->flush();
			
	// 		return $user;
	// 	}
		
    //     return $form;
    // }
	
	// public function login(AuthenticationUtils $autenticationUtils){
	// 	$error = $autenticationUtils->getLastAuthenticationError();
		
	// 	$lastUsername = $autenticationUtils->getLastUsername();
		
	// 	return $this->render('user/login.html.twig', array(
	// 		'error' => $error,
	// 		'last_username' => $lastUsername
	// 	));
	// }



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

