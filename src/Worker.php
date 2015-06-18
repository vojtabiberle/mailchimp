<?php

namespace Mailchimp;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\TransferException;
use Mailchimp\Common\HttpVerbs;
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
     * @return MessageInterface
     */
    public function load(MessageInterface $object, $params = null)
    {
        if (!in_array(HttpVerbs::GET, $object->getAllowedHttpVerbs(), false))
        {
            throw new RuntimeException('Operation '.HttpVerbs::GET.' is not allowed with object '.get_class($object).'.');
        }

        $endpoint = $object->getEndpoint();

        if (null !== $params) {
            foreach ($params as $key => $value) {
                $endpoint = str_replace('{'.$key.'}', $value, $endpoint);
            }
        }

        if (preg_match('/.*{.*}.*/', $endpoint))
        {
            throw new Exception('Not all endpoint parameters was replaced: '.$endpoint);
        }

        try {
            $response = $this->client->get($this->apiUri . $endpoint, ['auth' => [$this->clientName, $this->apiKey]]);
        } catch (TransferException $e) {

            $exceptionMessage = 'Connection error.';
            if ($e->hasResponse()) {
                $response = $e->getResponse();
                $exceptionMessage .= ' Code: '.$response->getStatusCode(). ' - '.$response->getReasonPhrase();
            }

            throw new RuntimeException($exceptionMessage);
        }

        //TODO: check for errors right here!

        $hydrator = new JsonHydrator($object);

        return $hydrator->hydrate((string)$response->getBody());
    }

    public function extractEndpoint($uri)
    {
        return str_replace($this->apiUri, '', $uri);
    }

}