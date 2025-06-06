<?php

namespace App\Controller;

use App\Dto\User\UserRegistrationDto;
use App\Entity\User;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;


#[Route('/api/user')]
final class ApiUserController extends AbstractController
{
  #[Route('/', name: 'api_user')]
  public function index(UserRepository $userRepository, SerializerInterface $serializer): Response
  {
		
		$users = $userRepository->findAll();
		$data = $serializer->serialize($users, 'json');
	
    return $this->json(["users" => json_decode($data)], Response::HTTP_OK);
  }
	
	#[Route('/register', name: 'api_user_register', methods: ['POST'])]
	public function register(
			#[MapRequestPayload] UserRegistrationDto $dto,
			UserRepository $userRepository,
			ValidatorInterface $validator,
			UserPasswordHasherInterface $passwordHasher
	): Response
	{
		
		$user = new User();
		
//		$errors = $validator->validate($dto);
//		if (count($errors) > 0) {
//			$errorMessages = [];
//			foreach ($errors as $error) {
//				$errorMessages[] = $error->getPropertyPath() . ': ' . $error->getMessage();
//			}
//			return $this->json(['errors' => $errorMessages], 400);
//		}
		
		$user->setEmail($dto->email);
		
		$hashedPassword = $passwordHasher->hashPassword($user, $dto->password);
		$user->setPassword($hashedPassword);
		
		$userRepository->add($user);
		
		return $this->json(["user" => $user, "message" => "usuario creado"], Response::HTTP_CREATED);
	}
	
	#[Route('/login', name: 'api_user_login')]
	public function login(UserRepository $userRepository, SerializerInterface $serializer): Response
	{
		
		$users = $userRepository->findAll();
		$json = $serializer->serialize($users, 'json');
		
		return $this->json($json, Response::HTTP_OK, [], true);
	}
	
	
	#[Route('/{id}', name: 'api_user_delete', methods: ['DELETE'])]
	public function delete(UserRepository $userRepository, User $user):Response
	{
		
		$userRepository->remove($user);
		
		return $this->json(["message" => "usuario eliminado"], Response::HTTP_OK);
	}
}
