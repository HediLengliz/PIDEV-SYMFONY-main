<?php
namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Psr\Log\LoggerInterface;
class DrugService
{
    private $httpClient;
    private $apiKey;
    private $logger;

    public function __construct(HttpClientInterface $httpClient, string $apiKey, LoggerInterface $logger)
    {
        $this->httpClient = $httpClient;
        $this->apiKey = $apiKey;
        $this->logger = $logger;
    }

    public function searchDrug(string $drugName): ?array
    {
        try {
            $response = $this->httpClient->request('GET', 'https://api.fda.gov/drug/label.json', [
                'query' => [
                    'search' => 'openfda.brand_name:"' . $drugName . '"',
                    'limit' => 1,
                    'api_key' => $this->apiKey,
                ]
            ]);

            if (200 !== $response->getStatusCode()) {
                // Log non-200 responses and return null
                $this->logger->error(sprintf('Failed to fetch drug information for "%s". HTTP Status Code: %d', $drugName, $response->getStatusCode()));
                return null;
            }
            $data = $response->toArray();

            // Assuming the response contains the information in a specific format
            // You might need to adjust this based on the actual structure of the API response
            if (!empty($data['results'])) {
                return $data['results'][0]; // Return the first result as the drug details
            }
            $this->logger->info(sprintf('No results found for drug "%s".', $drugName));
        } catch (\Exception $e) {
            // Handle any errors, such as network issues or invalid responses
            // For simplicity, returning null on error
            return null;
        }

        return null; // Return null if there were no results or an error occurred
    }
}