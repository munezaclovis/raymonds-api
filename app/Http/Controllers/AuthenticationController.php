<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthenticationController extends Controller
{
    protected const INVALID_CREDENTIALS = [
        'message' =>  'The user credentials were incorrect.'
    ];

    public function login(LoginRequest $request){
        
        if (!Auth::attempt(['email' => $request->input('email'), 'password' => $request->input('password')])) {
            return response()->json(static::INVALID_CREDENTIALS, 422);
        }

        return $this->AuthData(Auth::user());
    }

    public function register(RegisterRequest $request){

        $user = (new User)->fill([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);

        if($user->save()){
            $user->themeSettings()->create([
                'themeColor' => $request->input('themeColor'),
                'fontStyle' => $request->input('fontStyle'),
                'lightVersion' => $request->input('lightVersion'),
            ]);

            return $this->AuthData($user);
        }

        return response()->json(static::INVALID_CREDENTIALS, 422);
    }

    public function logout(Request $request){
        return $request->user()->token()->revoke();
    }

    /**
     * Generate access token
     *
     * @param User $user
     * @return JsonResource
     */
    protected function AuthData(User $user): JsonResource{
        $tokeData = $user->createToken('Api Access Token')->accessToken;

        return new JsonResource([
            'access_token' => $tokeData,
            'user' => ($user),
            'themeSettings' => ($user->themeSettings),
        ]);
    }
}
