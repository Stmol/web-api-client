<?php
/**
 * Created by Yury Smidovich (Stmol)
 * Date: 17.01.14
 * Project: WebAPIClient
 * Url: http://stmol.me
 * Email: dev@stmol.me
 */

namespace WebApiClient\Client;

/**
 * Class Request
 * @package WebApiClient\lib
 * @author Yury Smidovich <dev@stmol.me>
 */
class Request implements RequestInterface
{
    const CURL_CONTIMEOUT = 30;

    /**
     * @var string
     */
    private $url;

    /**
     * @var string
     */
    private $method;

    /**
     * @var string
     */
    private $query;

    /**
     * @var string
     */
    private $userAgent = 'Mozilla/4.0 (compatible; MSIE 8.0; Windows NT 6.1)';

    /**
     * @var array
     */
    private $curlOptions = array();

    public function __construct(RequestOptionsInterface $options = null)
    {
        if (!extension_loaded('curl')) {
            throw new \Exception('You must install cURL library');
        }

        if ($options) {
            $this->url = $options->getUrl();
            $this->method = $options->getMethod();
            $this->query = $options->getQueryString();
        }
    }

    /**
     * @param string $userAgent
     * @return $this
     */
    public function setUserAgent($userAgent)
    {
        $this->userAgent = $userAgent;

        return $this;
    }

    /**
     * @return string
     */
    public function getUserAgent()
    {
        return $this->userAgent;
    }

    /**
     * @param mixed $method
     * @return $this
     */
    public function setMethod($method)
    {
        $this->method = $method;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $query
     * @return $this
     */
    public function setQuery($query)
    {
        $this->query = $query;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param mixed $url
     * @return $this
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @return array
     */
    public function send()
    {
        $request = $this->createRequest($this->getMethod());

        $result = curl_exec($request);
        $httpCode = curl_getinfo($request, CURLINFO_HTTP_CODE);

        curl_close($request);

        return array(
            'code' => $httpCode,
            'body' => $result,
        );
    }

    /**
     * Create cURL handler
     *
     * @param $method
     * @return resource
     * @throws \Exception
     */
    private function createRequest($method)
    {
        $httpMethodResolver = new HttpMethodResolver();

        if (false === $httpMethodResolver->isMethod($method)) {
            throw new \Exception(sprintf('Method %s is not supported', $method));
        }

        switch ($method) {
            case HttpMethodResolver::HTTP_GET: $this->initGetRequest(); break;
            case HttpMethodResolver::HTTP_POST: $this->initPostRequest(); break;
            default: $this->initGetRequest();
        }

        $this
            ->addCurlOption(CURLOPT_USERAGENT, $this->userAgent)
            ->addCurlOption(CURLOPT_CONNECTTIMEOUT, self::CURL_CONTIMEOUT)
            ->addCurlOption(CURLOPT_RETURNTRANSFER, true)
        ;

        $curlHandler = curl_init();
        curl_setopt_array($curlHandler, $this->curlOptions);

        return $curlHandler;
    }

    /**
     * Initialize options for GET request
     */
    private function initGetRequest()
    {
        $this
            ->addCurlOption(CURLOPT_URL, $this->getUrl().'?'.$this->getQuery())
            ->addCurlOption(CURLOPT_CUSTOMREQUEST, HttpMethodResolver::HTTP_GET)
        ;
    }

    /**
     * Initialize options for POST request
     */
    private function initPostRequest()
    {
        $this
            ->addCurlOption(CURLOPT_URL, $this->getUrl())
            ->addCurlOption(CURLOPT_CUSTOMREQUEST, HttpMethodResolver::HTTP_POST)
            ->addCurlOption(CURLOPT_POSTFIELDS, $this->getQuery())
        ;
    }

    /**
     * Add curl options
     *
     * @param $key
     * @param $value
     * @return $this
     */
    private function addCurlOption($key, $value)
    {
        $this->curlOptions[$key] = $value;

        return $this;
    }
}