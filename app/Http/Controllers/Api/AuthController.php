<?php

declare(strict_types=1);

namespace App\Http\Controllers\Api;

use Exception;
use App\Services\AuthService;
use App\Helpers\TokenGenerator;
use App\Http\Controllers\Controller;
use Illuminate\Http\{JsonResponse, Request, Response};
use App\Http\Requests\{LoginRequest, RegisterRequest};

class AuthController extends Controller
{
    public function __construct(private AuthService $authService)
    {
    }

    /**
     * Registers new user.
     *
     * @param RegisterRequest $request
     * @param AuthService $authService
     * @return JsonResponse
     * @throws Exception
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $requestParameters = $request->validated();
        $this->authService->register($requestParameters);
        $requestParameters['username'] = $requestParameters['email'];

        return response()->json(TokenGenerator::generateToken($requestParameters), Response::HTTP_CREATED);
    }

    /**
     * Handles login requests.
     *
     * @param LoginRequest $request
     * @return JsonResponse
     * @throws Exception
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $credentials = $request->validated();
        if (auth()->attempt($credentials)) {
            $credentials['username'] = $credentials['email'];

            return response()->json(TokenGenerator::generateToken($credentials), Response::HTTP_CREATED);
        }

        return response()->json(['error' => 'UnAuthorised'], Response::HTTP_UNAUTHORIZED);
    }

    /**
     * Revoke access and refresh token.
     *
     * @param Request $request
     * @return void
     */
    public function logout(Request $request): void
    {
        $this->authService->revokeToken($request->user()->token()->id);
    }

    /**
     * Get new access token using refresh token.
     *
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function refreshToken(Request $request): JsonResponse
    {
        $refreshToken = TokenGenerator::generateToken($request->all());

        return !empty($refreshToken['error'])
            ? response()->json($refreshToken['error_description'], 498)
            : response()->json($refreshToken);
    }
}
