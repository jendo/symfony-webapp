<?php

namespace App\Controller\User;

use App\User\UserCreateRequest;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class UserController extends AbstractController
{

    public function __construct(
        private readonly SerializerInterface $serializer,
        private readonly ValidatorInterface $validator
    )
    {
    }

    #[Route('/api/users', methods: ['GET'])]
    public function list(): JsonResponse
    {
        $books = [
            ['id' => 1, 'name' => 'John Doe'],
            ['id' => 2, 'name' => 'Jane Smith'],
        ];

        return $this->json($books);
    }

    #[Route('/api/users', methods: ['POST'])]
    public function create(Request $request): JsonResponse
    {
        $userRequest = $this->serializer->deserialize(
            $request->getContent(),
            UserCreateRequest::class,
            JsonEncoder::FORMAT
        );

        $violations = $this->validator->validate($userRequest);

        if (count($violations) > 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[$violation->getPropertyPath()][] = $violation->getMessage();
            }

            return $this->json(
                [
                    'status' => 'error',
                    'errors' => $errors,
                ],
                Response::HTTP_BAD_REQUEST
            );
        }

        return $this->json(
            [
                'status' => 'success',
                'data' => [
                    'firstName' => $userRequest->firstName,
                    'lastName' => $userRequest->lastName,
                    'email' => $userRequest->email,
                ],
            ],
            Response::HTTP_CREATED
        );
    }
}
