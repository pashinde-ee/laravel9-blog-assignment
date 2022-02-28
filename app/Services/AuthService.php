<?php

declare(strict_types=1);

namespace App\Services;

use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Hash;
use Laravel\Passport\RefreshTokenRepository;
use Laravel\Passport\TokenRepository;

class AuthService
{
    /**
     * UserService constructor.
     *
     * @param UserRepository $userRepository
     * @param TokenRepository $tokenRepository
     * @param RefreshTokenRepository $refreshTokenRepository
     */
    public function __construct(
        private UserRepository $userRepository,
        private TokenRepository $tokenRepository,
        private RefreshTokenRepository $refreshTokenRepository,
    )
    {
    }

    /**
     * Register a new user.
     *
     * @param array $requestParameters
     * @return void
     */
    public function register(array $requestParameters): void
    {
        $this->userRepository->create(
            [
                'name' => $requestParameters['name'],
                'email' => $requestParameters['email'],
                'password' => Hash::make($requestParameters['password']),
            ]
        );
    }

    /**
     * Revoke the access and refresh token.
     *
     * @param string $tokenId
     * @return void
     */
    public function revokeToken(string $tokenId): void
    {
        $this->tokenRepository->revokeAccessToken($tokenId);
        $this->refreshTokenRepository->revokeRefreshTokensByAccessTokenId($tokenId);
    }
}
