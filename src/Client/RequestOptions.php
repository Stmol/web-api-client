<?php
/**
 * Created by Yury Smidovich (Stmol)
 * Date: 19.01.14
 * Project: WebAPIClient
 * Url: http://stmol.me
 * Email: dev@stmol.me
 */

namespace WebApiClient\Client;

/**
 * Class RequestOptions
 * @package WebApiClient\Client
 * @author Yury Smidovich <dev@stmol.me>
 */
class RequestOptions implements RequestOptionsInterface
{
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
    private $params;

    /**
     * @param mixed $method
     * @return $this
     */
    public function setMethod($method)
    {
        $this->method = $method;

        if (is_int($method)) {
            $methodsList = HttpMethodResolver::getMethodsList();
            $this->method = $methodsList[$method];
        }

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
     * @param mixed $params
     * @return $this
     */
    public function setParams($params)
    {
        $this->params = $params;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getParams()
    {
        return $this->params;
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
     * Get query string for url
     *
     * @return string
     */
    public function getQueryString()
    {
        if (empty($this->params)) {
            return '';
        }

        $result = array();

        foreach ($this->params as $param) {
            if ($param['name'] and $param['value']) {
                $result[$param['name']] = $param['value'];
            }
        }

        return http_build_query($result);
    }
}