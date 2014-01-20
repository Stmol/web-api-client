<?php
/**
 * Created by Yury Smidovich (Stmol)
 * Date: 19.01.14
 * Project: WebAPIClient
 * Url: http://stmol.me
 * Email: dev@stmol.me
 */

namespace WebApiClient\Client;

interface RequestOptionsInterface
{
    public function getMethod();

    public function getParams();

    public function getUrl();

    public function getQueryString();
}