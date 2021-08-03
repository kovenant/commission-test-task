<?php

declare(strict_types=1);

namespace App\Service\CurrencyRate;

use App\Exception\CurrencyRateFetcherException;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface;

final class CurrencyRateFetcher implements CurrencyRateFetcherInterface
{
    public function __construct(
        private string $apiUrl,
        private string $apiKey,
        private ClientInterface $client,
    ) {
    }

    public function fetchRates(): array
    {
        try {
            $response = $this->client->sendRequest(new Request('GET', $this->apiUrl . $this->apiKey));
            $data = json_decode((string)$response->getBody(), true, 512, JSON_THROW_ON_ERROR);

            $rates = $data['rates'] ?? [];

            if (empty($rates)) {
                throw new CurrencyRateFetcherException('Rates array is empty');
            }
        } catch (\Throwable $e) {
            throw new CurrencyRateFetcherException('Error while fetching rates API', $e->getCode(), $e);
        }

        return $rates;
    }
}
