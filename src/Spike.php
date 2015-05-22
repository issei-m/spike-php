<?php

namespace Issei\Spike;

use Issei\Spike\Converter\ObjectConverterInterface;
use Issei\Spike\Converter\RecursiveObjectFactoryConverterBuilder;
use Issei\Spike\Exception\RequestException;
use Issei\Spike\Http\Client\CurlClient;
use Issei\Spike\Http\ClientInterface;
use Issei\Spike\Model\Charge;
use Issei\Spike\Model\Token;

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
     * @var ObjectConverterInterface
     */
    private $objectConverter;

    public function __construct($secret, ClientInterface $httpClient = null, ObjectConverterInterface $objectConverter = null)
    {
        $this->secret          = $secret;
        $this->httpClient      = $httpClient ?: new CurlClient();
        $this->objectConverter = $objectConverter ?: static::getDefaultObjectConverterBuilder()->getBuilder();
    }

    /**
     * Returns a new token.
     *
     * @param  TokenRequest $request
     * @return Token
     *
     * @throws RequestException
     */
    public function requestToken(TokenRequest $request)
    {
        $result = $this->request('POST', '/tokens', [
            'card[number]' => $request->getCardNumber(),
            'card[exp_month]' => $request->getExpirationMonth(),
            'card[exp_year]' => $request->getExpirationYear(),
            'card[cvc]' => $request->getSecurityCode(),
            'card[name]' => $request->getHolderName(),
            'currency' => $request->getCurrency(),
            'email' => $request->getEmail(),
        ]);

        return $this->objectConverter->convert($result);
    }

    /**
     * Returns the token by id.
     *
     * @param  string $id
     * @return Token
     *
     * @throws RequestException
     */
    public function getToken($id)
    {
        $result = $this->request('GET', '/tokens/' . $id);

        return $this->objectConverter->convert($result);
    }

    /**
     * Returns the charges.
     *
     * @param  integer $limit
     * @param  Charge|string $startingAfter
     * @param  Charge|string $endingBefore
     * @return Charge[]
     *
     * @throws RequestException
     */
    public function getCharges($limit = 10, $startingAfter = null, $endingBefore = null)
    {
        $endpointUrl = '/charges?limit=' . $limit;

        if ($startingAfter) {
            $endpointUrl .= '&starting_after=' . $startingAfter;
        }
        if ($endingBefore) {
            $endpointUrl .= '&ending_before=' . $endingBefore;
        }

        $result = $this->request('GET', $endpointUrl);

        return $this->objectConverter->convert($result);
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

        return $this->objectConverter->convert($result);
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
            'card' => $request->getToken(),
            'amount'   => $request->getAmount() ? $request->getAmount()->getAmount() : null,
            'currency' => $request->getAmount() ? $request->getAmount()->getCurrency() : null,
            'capture'  => $request->isCapture(),
            'products' => json_encode($request->getProducts()),
        ]);

        return $this->objectConverter->convert($result);
    }

    /**
     * Captures the charge.
     *
     * @param  Charge|string $charge
     * @return Charge
     *
     * @throws RequestException
     */
    public function capture($charge)
    {
        $result = $this->request('POST', '/charges/' . $charge . '/capture');

        return $this->objectConverter->convert($result);
    }

    /**
     * Refunds the charge.
     *
     * @param  Charge|string $charge
     * @return Charge
     *
     * @throws RequestException
     */
    public function refund($charge)
    {
        $result = $this->request('POST', '/charges/' . $charge . '/refund');

        return $this->objectConverter->convert($result);
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

    /**
     * Returns the default object converter builder.
     *
     * @return RecursiveObjectFactoryConverterBuilder
     */
    public static function getDefaultObjectConverterBuilder()
    {
        return new RecursiveObjectFactoryConverterBuilder();
    }
}
