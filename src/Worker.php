<?php

namespace Mailchimp;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Request;
use Mailchimp\Common\HttpVerbs;
use Mailchimp\Common\Json;
use Mailchimp\Common\JsonHydrator;
use Mailchimp\Exception\Exception;
use Mailchimp\Exception\RuntimeException;
use Mailchimp\Message\MessageInterface;

class Worker
{
    private $clientName = 'MailChimp 0.x';

    private $apiKey;

    private $apiUri = 'https://{DC}.api.mailchimp.com/3.0';

    private $client;

    private $guzzleAllowRedirects = true;

    public function __construct($apikey)
    {
        @list(, $dc) = explode('-', $apikey);
        if (!isset($dc)) {
            throw new RuntimeException('Cannot find DC in apikey: '.$apikey);
        }

        $this->apiUri = rtrim(str_replace('{DC}', $dc, $this->apiUri), '/');

        $this->apiKey = $apikey;

        $clientName = $this->clientName;

        /*$stack = new HandlerStack();
        $stack->setHandler(new CurlHandler());
        $stack->push(Middleware::mapRequest(function(RequestInterface $r) use ($clientName, $apikey){
            return $r->withHeader('Authorization', base64_encode($clientName.':'.$apikey));
        }), 'BasicAuthHeader');*/

        /*$handler = new CurlHandler();
        $stack = HandlerStack::create($handler);
        $stack->push(Middleware::mapRequest(function(RequestInterface $r) use ($clientName, $apikey){
            return $r->withHeader('Authorization', base64_encode($clientName.':'.$apikey));
        }), 'BasicAuthHeader');*/

        $this->client = new GuzzleClient(['base_uri' => $this->apiUri]);
    }

    /**
     * @param MessageInterface $object
     *
     * @param null $params
     * @return MessageInterface
     * @throws Exception
     */
    public function load(MessageInterface $object, $params = null)
    {
        $endpoint = $this->prepareEndpoint($object->getEndpoint(), $params, $object->createRequestParams());
        $request = new Request(HttpVerbs::GET, $endpoint);
        $response = $this->send($request);
        $hydrator = new JsonHydrator($object);
        return $hydrator->hydrate((string)$response->getBody());
    }

    public function create(MessageInterface $object, $params = null)
    {
        $endpoint = $this->prepareEndpoint($object->getEndpoint(), $params, $object->createRequestParams());
        $request = new Request(HttpVerbs::POST, $endpoint);
        $request = $request->withBody(\GuzzleHttp\Psr7\stream_for(Json::encode($object)));
        $response = $this->send($request);
        $hydrator = new JsonHydrator($object);
        return $hydrator->hydrate((string)$response->getBody());
    }

    public function update(MessageInterface $object, $params = null)
    {
        $endpoint = $this->prepareEndpoint($object->getEndpoint(), $params, $object->createRequestParams());
        $request = new Request(HttpVerbs::PATCH, $endpoint);
        $request = $request->withBody(\GuzzleHttp\Psr7\stream_for(Json::encode($object)));
        $response = $this->send($request);
        $hydrator = new JsonHydrator($object);
        return $hydrator->hydrate((string)$response->getBody());
    }

    public function delete(MessageInterface $object, $params = null)
    {
        $endpoint = $this->prepareEndpoint($object->getEndpoint(), $params, $object->createRequestParams());
        $request = new Request(HttpVerbs::DELETE, $endpoint);
        $response = $this->send($request);
        $hydrator = new JsonHydrator($object);
        return $hydrator->hydrate((string)$response->getBody());
    }

    private function send(Request $request)
    {
        try {
            $response = $this->client->send($request, ['auth' => [$this->clientName, $this->apiKey]]);
        } catch (TransferException $e) {

            $exceptionMessage = '';
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $exceptionMessage .= ' Code: '.$response->getStatusCode(). ' - '.$response->getReasonPhrase();
                $exceptionMessage .= ' Body: '.$response->getBody();
            }

            throw new RuntimeException($exceptionMessage);
        }

        return $response;
    }

    private function prepareEndpoint($endpoint, $params, $defaultParams)
    {
        if (substr($endpoint, 0, 4) !== 'http') {
            $endpoint = $this->apiUri.$endpoint;
        }

        $finalParams = !is_null($params) ? $params : $defaultParams;

        if (null !== $finalParams) {
            foreach ($finalParams as $key => $value) {
                $endpoint = str_replace('{'.$key.'}', $value, $endpoint);
            }
        }

        if (preg_match('/.*{.*}.*/', $endpoint))
        {
            throw new Exception('Not all endpoint parameters was replaced: '.$endpoint);
        }

        return $endpoint;
    }
}