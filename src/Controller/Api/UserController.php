<?php


namespace App\Controller\Api;


use App\Entity\User;
use App\Repository\Api\RequestRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;

/**
 * Class UserController
 * @Route("/users")
 * @package App\Controller\Api
 */
class UserController extends AbstractApi
{

    private UserRepository $userRepository;

    public function __construct(
        RequestStack $requestStack,
        RequestRepository $requestRepository,
        SessionInterface $session,
        EntityManagerInterface $entityManager,
        UserRepository $userRepository
    ) {
        $this->userRepository = $userRepository;
        parent::__construct($requestStack, $requestRepository, $session, $entityManager);
    }

    /**
     * @Route("/authorize", methods={"GET"})
     */
    public function login(UserPasswordEncoderInterface $encoder): JsonResponse
    {
        try {
            if ($this->isGranted('IS_AUTHENTICATED_FULLY')) {
                throw new \Exception('Вы уже авторизованы', Response::HTTP_NOT_FOUND);
            }

            if (!$username = $this->request->get('username')) {
                throw new \Exception('Не задано имя пользователя', Response::HTTP_UNPROCESSABLE_ENTITY);
            } elseif (!$plainPassword = $this->request->get('password')) {
                throw new \Exception('Не задан пароль', Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $user = $this->userRepository->findOneBy(['username' => $username]);

            if (is_null($user) || !$encoder->isPasswordValid($user, $plainPassword)) {
                throw new \Exception('Неверное имя пользователя или пароль', Response::HTTP_NOT_FOUND);
            }

            $token = new UsernamePasswordToken($user, $user->getPassword(), 'dev', $user->getRoles());
            $this->get('security.token_storage')->setToken($token);

            return new JsonResponse(
                [
                    'data' =>
                        [
                            'username' => $username
                        ]
                ], Response::HTTP_OK
            );
        } catch (\Exception $exception) {
            return new JsonResponse(['error' => $exception->getMessage()], $exception->getCode());
        }
    }
}