<?php


namespace core\social;
use core\lib\Request;

/**
 * Class AbstractAdapter
 * @package core\lib\social
 */
abstract class AbstractAdapter
{
    /**
     * Social Client ID
     *
     * @var string null
     */
    protected $appId = null;

    /**
     * Social Client Secret
     *
     * @var string null
     */
    protected $appSecret = null;

    /**
     * Social Redirect Uri
     *
     * @var string null
     */
    protected $redirectUri = null;

    /**
     * Get authentication url
     *
     * @return string
     */
    public function getAuthUrl()
    {
        $config = $this->prepareAuthParams();

        return $result = $config['auth_url'] . '?' . urldecode(http_build_query($config['auth_params']));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    abstract public function authSocial(Request $request);

    /**
     * Make get request and return result
     *
     * @param $url
     * @param $params
     * @return mixed
     */
    protected function get($url, $params)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url . '?' . urldecode(http_build_query($params)));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);
        curl_close($curl);

        return json_decode($result, true);
    }

    /**
     * Make post request and return result
     *
     * @param $url
     * @param $params
     * @return mixed
     */

    protected function post($url, $params)
    {
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_POST, 1);
        curl_setopt($curl, CURLOPT_POSTFIELDS, urldecode(http_build_query($params)));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
        $result = curl_exec($curl);
        curl_close($curl);

        return $result = json_decode($result, true);
    }
}