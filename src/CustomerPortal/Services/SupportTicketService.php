<?php

/**
 * @copyright Copyright (C) Ibexa AS. All rights reserved.
 * @license For full copyright and license information view LICENSE file distributed with this source code.
 */
declare(strict_types=1);

namespace App\CustomerPortal\Services;

use App\Contracts\Services\SupportTicketServiceInterface;
use App\Model\SupportTicket;
use Ibexa\Contracts\Core\SiteAccess\ConfigResolverInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PropertyInfo\Extractor\PhpDocExtractor;
use Symfony\Component\PropertyInfo\Extractor\ReflectionExtractor;
use Symfony\Component\PropertyInfo\PropertyInfoExtractor;
use Symfony\Component\Serializer\Encoder\JsonEncoder;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\GetSetMethodNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Serializer;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;

class SupportTicketService implements SupportTicketServiceInterface
{
    private ConfigResolverInterface $configResolver;

    private HttpClientInterface $client;

    private string $webhookUrl;

    private Serializer $serializer;

    public function __construct(
        ConfigResolverInterface $configResolver,
        HttpClientInterface $client
    ) {
        $this->configResolver = $configResolver;
        $this->client = $client;
        $this->webhookUrl = $this->configResolver->getParameter('customer_portal_support_api_endpoint');
        $this->initializeSerializer();
    }

    private function initializeSerializer()
    {
        $encoders = [new JsonEncoder()];
        $extractor = new PropertyInfoExtractor([], [new PhpDocExtractor(), new ReflectionExtractor()]);
        $normalizers = [new DateTimeNormalizer(), new ObjectNormalizer(null, null, null, $extractor), new ArrayDenormalizer(), new GetSetMethodNormalizer()];
        $this->serializer = new Serializer($normalizers, $encoders);
    }

    public function getTickets($offset = 0, $limit = self::DEFAULT_LIMIT): array
    {
        $options = [
            'headers' => [
                'Content-Type' => 'application/json',
                'Accept' => ' application/api.SupportTicketList+json',
            ],
        ];

        $response = $this->handleApiRequest(Request::METHOD_GET, $options);
        $tickets = $this->serializer->deserialize(
            $response->getContent(),
            SupportTicket::class . '[]',
            JsonEncoder::FORMAT
        );

        return $tickets;
    }

    /** Freshdesk API does not support count */
    public function getTicketCount(): int
    {
        return self::DEFAULT_LIMIT;
    }

    private function handleApiRequest(string $method, array $options): ResponseInterface
    {
        $response = $this->client->request(
            $method,
            $this->webhookUrl,
            $options
        );

        if ($response->getStatusCode() == Response::HTTP_OK && $response->getContent() == 'Accepted') {
            throw new \Exception('Scenario seems not to be active, please activate in Ibexa Connect');
        } elseif ($response->getStatusCode() == Response::HTTP_INTERNAL_SERVER_ERROR || $response->getStatusCode() == Response::HTTP_BAD_REQUEST) {
            throw new \Exception('Error within Ibexa Connect, please check logs');
        }

        return $response;
    }
}
