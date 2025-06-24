<?php

namespace App\Infrastructure\UserManagement\Security;

use App\Infrastructure\UserManagement\Jwt\RefreshToken;
use DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\TokenInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Http\Authentication\AuthenticationSuccessHandlerInterface;

/**
 * @see https://symfony.com/doc/current/security/custom_authenticator.html
 */
class AuthenticationSuccessHandler implements AuthenticationSuccessHandlerInterface
{

    public function __construct(
        private JWTTokenManagerInterface $jwtManager,
        private EntityManagerInterface $em,
        private int $refreshTokenTTL = 2592000 // 30 dni w sekundach
    ) {}

    public function onAuthenticationSuccess(Request $request, TokenInterface $token): JsonResponse
    {
        $user = $token->getUser();

        if (!$user instanceof UserInterface) {
            throw new \RuntimeException('Authenticated user not found.');
        }

        $jwt = $this->jwtManager->create($user);

        $refreshTokenString = bin2hex(random_bytes(32));

        $expiresAt = (new DateTime())->modify("+{$this->refreshTokenTTL} seconds");

        $refreshToken = new RefreshToken($refreshTokenString, $user, $expiresAt);
        $this->em->persist($refreshToken);
        $this->em->flush();

        return new JsonResponse([
            'token' => $jwt,
            'refresh_token' => $refreshTokenString,
        ]);
    }
}
