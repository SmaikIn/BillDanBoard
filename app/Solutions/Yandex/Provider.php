<?php

namespace App\Solutions\Yandex;

use GuzzleHttp\RequestOptions;
use Illuminate\Support\Arr;
use SocialiteProviders\Manager\OAuth2\AbstractProvider;
use SocialiteProviders\Manager\OAuth2\User;

class Provider extends AbstractProvider
{
    public const IDENTIFIER = 'YANDEX';

    /**
     * {@inheritdoc}
     */
    protected $scopeSeparator = ' ';

    /**
     * {@inheritdoc}
     */
    protected function getAuthUrl($state)
    {
        return $this->buildAuthUrlFromBase(
            'https://oauth.yandex.ru/authorize',
            $state
        );
    }

    /**
     * {@inheritdoc}
     */
    protected function getTokenUrl()
    {
        return 'https://oauth.yandex.ru/token';
    }

    /**
     * {@inheritdoc}
     */
    protected function getUserByToken($token)
    {
        $response = $this->getHttpClient()->get('https://login.yandex.ru/info', [
            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer '.$token,
            ],
            RequestOptions::QUERY => [
                'format' => 'json',
            ],
        ]);

        return json_decode((string)$response->getBody(), true);
    }

    /**
     * {@inheritdoc}
     */
    protected function mapUserToObject(array $user)
    {
        $userObject = new User();
        $userObject->setRaw($user);

        $userObject->id = Arr::get($user, 'id');
        $userObject->firstName = Arr::get($user, 'first_name');
        $userObject->lastName = Arr::get($user, 'last_name');
        $userObject->email = Arr::get($user, 'default_email');

        $phoneData = Arr::get($user, 'default_phone', []);
        $userObject->phone = Arr::get($phoneData, 'number');

        $userObject->avatarUrl = 'https://avatars.yandex.net/get-yapic/'.Arr::get($user,
                'default_avatar_id').'/islands-200';

        return $userObject;
    }
}