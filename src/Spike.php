<?php

namespace Issei\Spike;

use Issei\Spike\Exception\ApiErrorException;
use Issei\Spike\Model\Charge;
use Issei\Spike\Model\Factory\ChargeFactory;
use Issei\Spike\Model\Factory\RefundFactory;
use Issei\Spike\Http\Client\CurlClient;
use Issei\Spike\Http\ClientInterface;

/**
 * The entry point.
 *
 * @author Issei Murasawa <issei.m7@gmail.com>
 */
class Spike
{
    const ENDPOINT_PREFIX = 'https://api.spike.cc/v1';

    /**
     * @var string
     */
    private $secret;

    /**
     * @var ClientInterface
     */
    private $httpClient;

    /**
     * @var ChargeFactory
     */
    private $chargeFactory;

    public function __construct($secret, ClientInterface $httpClient = null, ChargeFactory $chargeFactory = null)
    {
        $this->secret        = $secret;
        $this->chargeFactory = $chargeFactory ?: new ChargeFactory(new RefundFactory());
        $this->httpClient    = $httpClient ?: new CurlClient();
    }

    /**
     * Returns the charges.
     *
     * @param  integer $limit
     * @return Charge[]
     *
     * @throws ApiErrorException
     */
    public function getCharges($limit = 10)
    {
        $result = $this->request('GET', '/charges?limit=' . $limit);

        return array_map(function ($chargeJson) {
            return $this->chargeFactory->create($chargeJson);
        }, $result['data']);
    }

    /**
     * Returns the charge by id.
     *
     * @param  string $id
     * @return Charge
     *
     * @throws ApiErrorException
     */
    public function getCharge($id)
    {
        $result = $this->request('GET', '/charges/' . $id);

        return $this->chargeFactory->create($result);
    }

    /**
     * Creates a new charge.
     *
     * @param  ChargeRequest $request
     * @return Charge
     *
     * @throws ApiErrorException
     */
    public function charge(ChargeRequest $request)
    {
        $result = $this->request('POST', '/charges', [
            'card'     => $request->getCard(),
            'currency' => $request->getCurrency(),
            'amount'   => $request->getAmount(),
            'products' => json_encode($request->getProducts()),
        ]);

        return $this->chargeFactory->create($result);
    }

    /**
     * Refunds the charge.
     *
     * @param  Charge $charge
     * @return Charge
     *
     * @throws ApiErrorException
     */
    public function refund(Charge $charge)
    {
        $result = $this->request('POST', '/charges/' . $charge->getId() . '/refund');

        return $this->chargeFactory->create($result);
    }

    private function request($method, $endpoint, array $params = [])
    {
        $response = $this->httpClient->request($method, self::ENDPOINT_PREFIX . $endpoint, $this->secret, $params);

        $result = json_decode($response->getBody(), true);

        if (400 <= $response->getStatusCode()) {
            throw new ApiErrorException($response->getStatusCode(), $result['error']['type'], $result['error']['message']);
        }

        return $result;
    }
}
