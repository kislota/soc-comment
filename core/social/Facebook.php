<?php

namespace core\social;

use core\lib\Request;

class Facebook extends AbstractAdapter
{

    public function __construct($param)
    {
        $this->appId = $param['app-id'];
        $this->appSecret = $param['app-secret'];
        $this->redirectUri = $param['redirect-uri'];
    }

    /**
     * Get url of user's avatar or null if it is not set
     *
     * @return string|null
     */
    public function getAvatar()
    {
        if (isset($this->id)) {
            return 'http://graph.facebook.com/' . $this->id . '/picture?type=large';
        }
        return false;
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
                'client_id' => $this->appId,
                'redirect_uri' => $this->redirectUri,
                'client_secret' => $this->appSecret,
                'code' => $request->code
            ];
            $token = $this->get('https://graph.facebook.com/oauth/access_token', $params);
            if (count($token['access_token']) > 0 && isset($token['access_token'])) {
                $params['access_token'] = $token['access_token'];
                $params['fields'] = 'id,name,email';
                $userInfo = $this->get('https://graph.facebook.com/v2.11/me', $params);
                if (isset($userInfo['id'])) {
                    foreach ($userInfo as $key => $data) {
                        $this->$key = $data;
                    }
                    $this->avatar = $this->getAvatar();
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
            'auth_url' => 'https://www.facebook.com/dialog/oauth',
            'auth_params' => [
                'client_id' => $this->appId,
                'redirect_uri' => $this->redirectUri,
                'response_type' => 'code',
                'scope' => 'email'
            ]
        ];
    }

}