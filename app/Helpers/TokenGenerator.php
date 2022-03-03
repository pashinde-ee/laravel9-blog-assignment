<?php

declare(strict_types=1);

namespace App\Helpers;

use Exception;
use Illuminate\Http\Request;
use Laravel\Passport\Client;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class TokenGenerator
{
    /**
     * Generates the API token with grant_type password/refresh_token.
     *
     * @param array $requestParameters
     * @return array
     * @throws Exception
     */
    public static function generateToken(array $requestParameters): array
    {
        try {
            $clientDetails = Client::where(
                [
                    ['password_client', true],
                    ['revoked', false],
                ]
            )->firstOrFail();
        } catch (ModelNotFoundException $exception) {
            Log::error('Passport password client is either revoked or not present in the database.');
            report($exception);

            return [];
        }

        return self::generateBearerToken($requestParameters, $clientDetails);
    }

    /**
     * Generates the API bearer token with grant_type password/refresh_token.
     *
     * @param array $requestParameters
     * @param Client $clientDetails
     *
     * @return array
     * @throws Exception
     */
    private static function generateBearerToken(array $requestParameters, Client $clientDetails): array
    {
        $response = app()->handle(
            Request::create(
                '/oauth/token',
                'POST',
                array_merge([
                    'grant_type' => 'password',
                    'client_id' => $clientDetails->id,
                    'client_secret' => $clientDetails->secret,
                ], $requestParameters)
            )
        );

        return json_decode($response->getContent(), true);
    }
}
