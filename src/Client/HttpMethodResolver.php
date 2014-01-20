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
 * Class HttpMethodResolver
 * @package WebApiClient\Client
 * @author Yury Smidovich <dev@stmol.me>
 */
class HttpMethodResolver
{
    /**
     * @var string Http GET
     */
    const HTTP_GET = 'GET';

    /**
     * @var string Http POST
     */
    const HTTP_POST = 'POST';

    /**
     * Get all available methods
     *
     * @return array
     */
    public static function getMethodsList()
    {
        return array(
            self::HTTP_GET,
            self::HTTP_POST,
        );
    }

    /**
     * Checks for the existence of the method in the list
     *
     * @param $method
     * @return bool
     */
    public function isMethod($method)
    {
        return in_array($method, self::getMethodsList());
    }
}