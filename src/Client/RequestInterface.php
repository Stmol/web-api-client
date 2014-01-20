<?php
/**
 * Created by Yury Smidovich (Stmol)
 * Date: 17.01.14
 * Project: WebAPIClient
 * Url: http://stmol.me
 * Email: dev@stmol.me
 */

namespace WebApiClient\Client;


interface RequestInterface
{
    public function getUserAgent();

    public function getMethod();

    public function getQuery();

    public function getUrl();

    public function send();
}