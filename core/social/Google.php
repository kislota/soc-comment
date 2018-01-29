<?php

namespace core\social;

use core\lib\Request;

class Google extends AbstractAdapter
{
    public function __construct($param)
    {
        $this->appId = $param['app-id'];
        $this->appSecret = $param['app-secret'];
        $this->redirectUri = $param['redirect-uri'];
    }

    /**
     * Authenticate and return bool result of authentication
     *
     * @return bool|array
     */
    public function authSocial(Request $request)
    {
        if (isset($request->code)) {
            $params = [
                'code' => $request->code,
                'client_id' => $this->appId,
                'client_secret' => $this->appSecret,
                'redirect_uri' => $this->redirectUri,
                'grant_type' => 'authorization_code'
            ];

            $token = $this->post('https://www.googleapis.com/oauth2/v4/token', $params);
            if (count($token['access_token']) > 0 && isset($token['access_token'])) {
                $params['access_token'] = $token['access_token'];
                $userInfo = $this->get('https://www.googleapis.com/oauth2/v1/userinfo', $params);
                if (isset($userInfo['id'])) {
                    foreach ($userInfo as $key => $data) {
                        $this->$key = $data;
                    }
                    $this->avatar = $this->picture;
                    return $this;
                }
            }
        }
        return false;
    }

    /**
     * Prepare params for authentication url
     *
     * @return array
     */
    public function prepareAuthParams()
    {
        return [
            'auth_url' => 'https://accounts.google.com/o/oauth2/v2/auth',
            'auth_params' => [
                'client_id' => $this->appId,
                'redirect_uri' => $this->redirectUri,
                'response_type' => 'code',
                'scope' => 'https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/userinfo.profile'
            ]
        ];
    }
}