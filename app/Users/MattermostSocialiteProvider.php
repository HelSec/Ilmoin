<?php

namespace App\Users;

use Laravel\Socialite\Two\AbstractProvider;
use Laravel\Socialite\Two\ProviderInterface;

class MattermostSocialiteProvider extends AbstractProvider implements ProviderInterface
{
    /**
     * @inheritDoc
     */
    protected function getAuthUrl($state)
    {
        $url = env('MATTERMOST_BASE_URL', 'https://mm.io.fi') . '/oauth/authorize';
        return $this->buildAuthUrlFromBase($url, $state);
    }

    /**
     * @inheritDoc
     */
    protected function getTokenUrl()
    {
        return env('MATTERMOST_BASE_URL', 'https://mm.io.fi') . '/oauth/access_token';
    }

    /**
     * @inheritDoc
     */
    protected function getUserByToken($token)
    {
        $url = env('MATTERMOST_BASE_URL', 'https://mm.io.fi') . '/api/v4/users/me';
        $response = $this->getHttpClient()->get($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $token,
            ],
        ]);

        return json_decode($response->getBody(), true);
    }

    /**
     * @inheritDoc
     */
    protected function mapUserToObject(array $user)
    {
        //$user = [
        //    'mattermost_user_id' => $user['id'],
        //    'email' => $user['email'],
        //    'name' => $user['nickname'],
        //    'real_name' => in_array('first_name', $user) ? ($user['first_name'] . ' ' . $user['last_name']) : null,
        //];

        return (new \Laravel\Socialite\Two\User)->setRaw($user)->map([
            'id' => $user['id'],
            'email' => $user['email'],
            'name' => $user['nickname'],
            'real_name' => in_array('first_name', $user) ? ($user['first_name'] . ' ' . $user['last_name']) : null,
        ]);
    }

    protected function getTokenFields($code)
    {
        return array_merge(
            parent::getTokenFields($code),
            ['grant_type' => 'authorization_code']
        );
    }
}
