<?php

namespace Issei\Spike;

use Issei\Spike\Exception\RequestException;
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
     * @param  Charge  $startingAfter
     * @param  Charge  $endingBefore
     * @return Charge[]
     *
     * @throws RequestException
     */
    public function getCharges($limit = 10, Charge $startingAfter = null, Charge $endingBefore = null)
    {
        $endpointUrl = '/charges?limit=' . $limit;

        if ($startingAfter instanceof Charge) {
            $endpointUrl .= '&starting_after=' . $startingAfter->getId();
        }
        if ($endingBefore instanceof Charge) {
            $endpointUrl .= '&ending_before=' . $endingBefore->getId();
        }

        $result = $this->request('GET', $endpointUrl);

        return array_map([$this->chargeFactory, 'create'], $result['data']);
    }

    /**
     * Returns the charge by id.
     *
     * @param  string $id
     * @return Charge
     *
     * @throws RequestException
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
     * @throws RequestException
     */
    public function charge(ChargeRequest $request)
    {
        $result = $this->request('POST', '/charges', [
            'card'     => $request->getCard(),
            'amount'   => $request->getAmount() ? $request->getAmount()->getAmount() : null,
            'currency' => $request->getAmount() ? $request->getAmount()->getCurrency() : null,
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
     * @throws RequestException
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
            throw new RequestException($response->getStatusCode(), $result);
        }

        return $result;
    }
}
