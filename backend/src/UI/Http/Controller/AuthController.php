<?php

namespace App\UI\Http\Controller;

use App\Infrastructure\UserManagement\Jwt\RefreshToken;
use Doctrine\ORM\EntityManagerInterface;
use Lexik\Bundle\JWTAuthenticationBundle\Services\JWTTokenManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

/**
 * Auth controller.
 *
 * @author Tomasz Zymni <tomasz.zymni@gmail.com>
 */
final class AuthController extends AbstractController
{
    /**
     * Because the gesdinet/jwt-refresh-token-bundle is not compatible with Lexik v3 I created an own refreshToken functionality.
     *
     * @param Request $request
     * @param EntityManagerInterface $em
     * @param JWTTokenManagerInterface $jwtManager
     * @return JsonResponse
     */
    #[Route('/token/refresh', name: 'token_refresh', methods: ['POST'])]
    public function refreshToken(Request $request, EntityManagerInterface $em, JWTTokenManagerInterface $jwtManager): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $refreshTokenString = $data['refresh_token'] ?? null;

        if (!$refreshTokenString) {
            return new JsonResponse(['error' => 'No refresh token provided'], 400);
        }

        $refreshToken = $em->getRepository(RefreshToken::class)->find($refreshTokenString);
        if (!$refreshToken || $refreshToken->getExpiresAt() < new \DateTime()) {
            return new JsonResponse(['error' => 'Invalid or expired refresh token'], 401);
        }

        $user = $refreshToken->getUser();
        $jwt = $jwtManager->createFromPayload($user, ['username' => $refreshToken->getUser()]);
        return new JsonResponse(['token' => $jwt]);
    }
}
