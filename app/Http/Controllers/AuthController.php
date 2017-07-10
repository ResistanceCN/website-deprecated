<?php

namespace App\Http\Controllers;

use App\Models\User;
use Carbon\Carbon;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class AuthController
{
    public function login(Request $request)
    {
        $googleUser = $this->getGoogleUser($request);

        $user = User::firstOrNew(['google_id' => $googleUser['sub']], [
            'email' => $googleUser['email'],
        ]);

        $userToken = $user->id ? $this->generateUserToken($user) : "";

        return response()->json([
            'user' => $user,
            'token' => $userToken,
        ]);
    }

    public function register(Request $request)
    {
        $googleUser = $this->getGoogleUser($request);

        $user = User::firstOrCreate(['google_id' => $googleUser['sub']], [
            'email' => $googleUser['email'],
            'name' => $request->input('name'),
            'faction' => $request->input('faction'),
            'created_at' => Carbon::now()
        ]);

        $userToken = $this->generateUserToken($user);

        return response()->json([
            'user' => $user,
            'token' => $userToken,
        ]);
    }

    protected function getGoogleUser(Request $request)
    {
        $googleToken = $request->input('token');

        if (is_null($googleToken)) {
            throw new AuthenticationException('Google token required.');
        }

        $client = new \Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
        $payload = $client->verifyIdToken($googleToken);

        if (! $payload) {
            throw new AuthenticationException('Invalid Google token.');
        }

        return $payload;
    }

    protected function generateUserToken(User $user)
    {
        do {
            $userToken = str_random(60);
        } while (! Cache::add($userToken, $user->id, Carbon::now()->addDays(7)));

        return $userToken;
    }
}
