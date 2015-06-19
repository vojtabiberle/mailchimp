<?php

namespace Mailchimp;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\Exception\TransferException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Uri;
use Mailchimp\Common\HttpVerbs;
use Mailchimp\Common\Json;
use Mailchimp\Common\JsonHydrator;
use Mailchimp\Exception\Exception;
use Mailchimp\Exception\RuntimeException;
use Mailchimp\Message\MessageInterface;
use Psr\Http\Message\UriInterface;

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
    public function load(MessageInterface $object, $options = [])
    {
        $uri = $this->prepareEndpointUri($object, $options);
        $request = $this->prepareRequest($uri, HttpVerbs::GET);
        $response = $this->send($request);
        $hydrator = new JsonHydrator($object);
        return $hydrator->hydrate((string)$response->getBody());
    }

    public function create(MessageInterface $object, $options = [])
    {
        $uri = $this->prepareEndpointUri($object, $options);
        $request = $this->prepareRequest($uri, HttpVerbs::POST, $object);
        $response = $this->send($request);
        $hydrator = new JsonHydrator($object);
        return $hydrator->hydrate((string)$response->getBody());
    }

    public function update(MessageInterface $object, $options = [])
    {
        $uri = $this->prepareEndpointUri($object, $options);
        $request = $this->prepareRequest($uri, HttpVerbs::PATCH, $object);
        $response = $this->send($request);
        $hydrator = new JsonHydrator($object);
        return $hydrator->hydrate((string)$response->getBody());
    }

    public function delete(MessageInterface $object, $options = [])
    {
        $uri = $this->prepareEndpointUri($object, $options);
        $request = $this->prepareRequest($uri, HttpVerbs::DELETE);
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

    private function prepareRequest(UriInterface $uri, $httpMethod, MessageInterface $body = null)
    {
        $request = new Request($httpMethod, $uri);
        if (!is_null($body)) {
            $request = $request->withBody(\GuzzleHttp\Psr7\stream_for(Json::encode($body)));
        }
        return $request;
    }

    /**
     * @param $object
     * @param $options
     * @return Uri
     * @throws Exception
     */
    private function prepareEndpointUri(MessageInterface $object, array $options)
    {
        $endpoint = $object->getEndpoint();
        $defaultParams = $object->getDefaultParams();
        $params = array_key_exists('params', $options) ? $options['params'] : [];

        if (substr($endpoint, 0, 4) !== 'http') {
            $endpoint = $this->apiUri.$endpoint;
        }

        $params = array_merge($params, $defaultParams);

        foreach ($params as $key => $value) {
            $endpoint = str_replace('{'.$key.'}', $value, $endpoint);
        }

        if (preg_match('/.*{.*}.*/', $endpoint))
        {
            throw new Exception('Not all endpoint parameters was replaced: '.$endpoint);
        }

        $uri = new Uri($endpoint);

        if (array_key_exists('paging', $options['paging'])) {
            $paging = $options['paging'];
            if (array_key_exists('offset', $paging)) {
                if (!is_numeric($paging['offset']) || $paging['offset'] < 0) {
                    throw new RuntimeException('Paging offset cam be only positive number and 0.');
                }
                $uri = Uri::withQueryValue($uri, 'offset', $paging['offset']);
            }
            if(array_key_exists('count', $paging)) {
                if (!is_numeric($paging['count']) || $paging['count'] < 1) {
                    throw new RuntimeException('Paging count cam be only positive number.');
                }
                $uri = Uri::withQueryValue($uri, 'count', $paging['count']);
            }
        }

        if (array_key_exists('fields', $options)) {
            if (is_array($options['fields'])) {
                $fields = implode(',', $options['fields']);
            } else {
                $fields = $options['fields'];
            }
            $uri = Uri::withQueryValue($uri, 'fields', $fields);
        }

        if (array_key_exists('exclude_fields', $options))
        {
            if (array_key_exists('fields', $options)) {
                throw new RuntimeException('You can not use "fields" and "exclude_fields" in one API query.');
            }

            if (is_array($options['exclude_fields'])) {
                $exclude_fields = implode(',', $options['exclude_fields']);
            } else {
                $exclude_fields = $options['exclude_fields'];
            }
            $uri = Uri::withQueryValue($uri, 'exclude_fields', $exclude_fields);
        }

        return $uri;
    }
}