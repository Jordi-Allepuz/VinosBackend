<?php

namespace App\Service;

use App\Entity\User;
use App\Form\Model\UserDto;
use App\Repository\UserRepository;
use App\Form\Type\UserFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Serializer\SerializerInterface;


class UserService
{
    private $em;
    private $userRepository;
    private $formFactory;
    private $serializer;

    public function __construct(EntityManagerInterface $em, UserRepository $userRepository, FormFactoryInterface $formFactory, SerializerInterface $serializer)
    {
        $this->em = $em;
        $this->userRepository = $userRepository;
        $this->formFactory = $formFactory;
        $this->serializer = $serializer;
    }

    public function getAllUsers(): array
    {
        return $this->userRepository->findAllOrderedByName();
    }


    public function getUserById(int $id): ?User
    {
        return $this->userRepository->find($id);
    }


    public function createUser(Request $request)
    {
        $userDto = new UserDto();
        $form = $this->formFactory->create(UserFormType::class, $userDto);
        $form->handleRequest($request);

        if (!$form->isSubmitted()) {
            return new Response('Bad request', Response::HTTP_BAD_REQUEST);
        }
        if ($form->isValid()) {
            $user = new User();
            $user->setName($userDto->name);
            $user->setLastnames($userDto->lastnames);
            $user->setEmail($userDto->email);
            $user->setPassword($userDto->password);
            $this->em->persist($user);
            $this->em->flush();
            return $user;
        }
        return $form;
    }


    public function updateUser(Request $request, int $id)
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            return new Response('User not found', Response::HTTP_NOT_FOUND);
        }
        $content = json_decode($request->getContent(), true);
        $userDto = new UserDto();
        $userDto->name = $user->getName();
        $userDto->lastnames = $user->getLastnames();
        $userDto->email = $user->getEmail();
        $userDto->password = $user->getPassword();

        $form = $this->formFactory->create(UserFormType::class, $userDto);
        $form->submit($content, false);

        if (!$form->isSubmitted()) {
            return new Response('Bad request', Response::HTTP_BAD_REQUEST);
        }
        if ($form->isValid()) {
            $user->setName($userDto->name);
            $user->setLastnames($userDto->lastnames);
            $user->setEmail($userDto->email);
            $user->setPassword($userDto->password);

            $this->em->persist($user);
            $this->em->flush();
            return $user;
        }
        return $form;
    }



    public function patchUser(Request $request, int $id)
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            return new Response('User not found', Response::HTTP_NOT_FOUND);
        }

        $content = json_decode($request->getContent(), true);
        $user->patch($content);

        $this->em->persist($user);
        $this->em->flush();
        return $user;
    }



    public function deleteUser(int $id)
    {
        $user = $this->userRepository->find($id);
        if (!$user) {
            return new Response('User not found', Response::HTTP_NOT_FOUND);
        }
        $this->em->remove($user);
        $this->em->flush();
        return new Response('User deleted', Response::HTTP_OK);
    }


}