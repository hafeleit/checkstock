<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;

class ExternalProductApiService
{
    protected string $baseUrl;
    protected string $username;
    protected string $licenseKey;
    protected string $password;
    protected string $apiKey;

    public function __construct()
    {
        $this->baseUrl    = config('services.external_product_api.base_url');
        $this->username   = config('services.external_product_api.username');
        $this->licenseKey = config('services.external_product_api.license_key');
        $this->password   = config('services.external_product_api.password');
        $this->apiKey     = config('services.external_product_api.api_key');
    }

    public function getToken(): string
    {
        return Cache::remember('external_product_api_token', now()->addMinutes(55), function () {
            return $this->fetchNewToken();
        });
    }

    protected function fetchNewToken(): string
    {
        $response = Http::withHeaders([
                'Accept'    => 'application/json',
                'x-api-key' => $this->apiKey,
            ])
            ->get("{$this->baseUrl}/user/login", [
                'username'   => $this->username,
                'licenseKey' => $this->licenseKey,
                'password'   => $this->password,
            ]);

        if ($response->failed()) {
            Log::error('ExternalProductApi: authentication failed', [
                'status' => $response->status(),
                'body'   => $response->body(),
            ]);
            throw new \Exception('ExternalProductApi: unable to authenticate.');
        }

        return $response->json('AuthToken');
    }

    public function getProductData(string $articleNumber): ?array
    {
        $token = $this->getToken();

        $response = Http::withHeaders([
                'Accept'        => 'application/json',
                'x-api-key'     => $this->apiKey,
                'Authorization' => $token,
            ])
            ->get("{$this->baseUrl}/productinfo/2", [
                'source'        => 'API',
                'articleNumber' => $articleNumber,
            ]);

        if ($response->notFound()) {
            return null;
        }

        if ($response->failed()) {
            Log::error('ExternalProductApi: getProductData failed', [
                'article_number' => $articleNumber,
                'status'         => $response->status(),
                'body'           => $response->body(),
            ]);
            throw new \Exception('ExternalProductApi: unable to fetch product data.');
        }

        return [
            'productInformations' => $response->json('ProductInformations'),
            'articles'            => $response->json('Articles'),
        ];
    }
}
