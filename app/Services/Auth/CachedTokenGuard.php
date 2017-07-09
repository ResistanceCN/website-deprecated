<?php

namespace App\Services\Auth;

use Illuminate\Auth\TokenGuard as BaseGuard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class CachedTokenGuard extends BaseGuard
{
    public function user()
    {
        // If we've already retrieved the user for the current request we can just
        // return it back immediately. We do not want to fetch the user data on
        // every call to this method because that would be tremendously slow.
        if (! is_null($this->user)) {
            return $this->user;
        }

        $user = null;

        $token = $this->getTokenForRequest();

        if (! empty($token)) {
            $user = $this->provider->retrieveByCredentials(
                ['id' => $this->getIdForToken($token)]
            );
        }

        return $this->user = $user;
    }

    public function validate(array $credentials = [])
    {
        if (empty($credentials[$this->inputKey])) {
            return false;
        }

        $token = $credentials[$this->inputKey];

        $credentials = ['id' => $this->getIdForToken($token)];

        if ($this->provider->retrieveByCredentials($credentials)) {
            return true;
        }

        return false;
    }

    public function getIdForToken($token)
    {
        return Cache::get($token, null);
    }
}
