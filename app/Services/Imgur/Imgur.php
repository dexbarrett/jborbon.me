<?php
namespace DexBarrett\Services\Imgur;

use DexBarrett\User;
use Imgur\Client as ImgurClient;

class Imgur
{
    protected $imgurClient;

    public function __construct(ImgurClient $imgurClient)
    {
        $this->imgurClient = $imgurClient;
    }

    public function getUserToken()
    {
        return auth()->user()->imgur_token;
    }

    public function authenticate($token)
    {
        $this->imgurClient->setAccessToken($token);

        if ($this->imgurClient->checkAccessTokenExpired()) {
            $this->imgurClient->refreshToken();
        }
    }

    public function requestAccessToken($code)
    {
        $this->imgurClient->requestAccessToken($code);
        $token = $this->imgurClient->getAccessToken();
        $this->saveUserToken($token);
        $this->authenticate($token);
    }

    public function getAuthenticationUrl()
    {
        return $this->imgurClient->getAuthenticationUrl();
    }

    protected function saveUserToken($token)
    {
        $user = auth()->user();
        $user->imgur_token = $token;
        $user->save();
    }

    public function getBlogImages()
    {
        return $this->imgurClient
                ->api('album')
                ->albumImages(config('imgur.album_id'));
    }

    public function uploadImageFromData($imageData)
    {
        return $this->imgurClient
                ->api('image')
                ->upload([
                    'album' => config('imgur.album_id'),
                    'image' => $imageData,
                    'type' => 'base64'
                ]);
    }
}