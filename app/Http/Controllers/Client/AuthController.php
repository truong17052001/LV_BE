<?php

namespace App\Http\Controllers\Client;

use App\Events\RegisterEvent;
use App\Http\Controllers\Controller;
use App\Repositories\Client\TokenRepository;
use Illuminate\Http\Request;
use App\Repositories\Client\AuthRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //
    private AuthRepository $authRepository;
    private TokenRepository $toKenRepository;
    //
    public function __construct(AuthRepository $authRepo,TokenRepository $toKenRepo)
    {
        $this->authRepository = $authRepo;
        $this->toKenRepository = $toKenRepo;
    }
    public function login(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                "email" => "required|email|exists:users,email",
                "password" => "required|min:7"
            ]);

            if ($validator->fails()) {
                return $this->sendResponseApi([
                    'code' => '400',
                    'error' => $validator->errors()->all()
                ]);
            }

            $user = $this->authRepository->findByColumns(['email' => $request['email']]);

            if (empty($user) || !Hash::check($request['password'], $user->password)) {
                return $this->sendResponseApi([
                    'code' => 401,
                    'error' => 'Invalid Login'
                ]);
            } else {
                $token = $user->createToken($request->email)->plainTextToken;
            }

            return $this->sendResponseApi([
                'code' => 200,
                'data' => [
                    'user' => $user,
                    'token' => $token,
                    'tokenType' => 'Bearer'
                ]
            ]);

        } catch (\Throwable $ex) {
            return $this->sendResponseApi([
                'code' => 500,
                'error' => $ex->getMessage(),
            ]);
        }
    }

    public function register(Request $request)
    {
        $input = $request->all();

        try {
            $validator = Validator::make($request->all(), [
                "email" => "required|email|unique:users",
                "password" => "required|min:7"
            ]);

            if ($validator->fails()) {
                return $this->sendResponseApi([
                    'code' => 400,
                    'error' => $validator->errors()->all()
                ]);
            }

            $input['password'] = Hash::make($input['password']);
            $input['is_active'] = 0;

            $user = $this->authRepository->create($input);

            event(new RegisterEvent($user));

            return $this->sendResponseApi([
                'code' => 200,
                'data' => $user,
            ]);

        } catch (\Throwable $ex) {
            return $this->sendResponseApi([
                'code' => 500,
                'error' => $ex->getMessage(),
            ]);
        }
    }
    public function active(Request $request)
    {
        $input = $request->all();

        try {
            $validator = Validator::make($request->all(), [
                "otp" => "required|numeric|digits:6",
            ]);

            if ($validator->fails()) {
                return $this->sendResponseApi([
                    'code' => 400,
                    'error' => $validator->errors()->all()
                ]);
            }

            $token = $this->toKenRepository->findByColumns(
                [
                    "otp" => $input["otp"],
                ]
            );

            if (empty($token)) {
                return $this->sendResponseApi([
                    "code" => 400,
                    "error" => "Invalid Token check your input and try again"
                ]);
            }

            if ($token->expired_at > Carbon::now()->format("Y-m-d H:i:s")) {
                return $this->sendResponseApi([
                    "code" => 400,
                    "error" => "Token has expired"
                ]);
            }

            $user = $this->authRepository->find($token->user_id);
            $this->authRepository->update($token->user_id, [
                "is_active" => 1,
            ]);
            return $this->sendResponseApi([
                "code" => 200,
            ]);
        } catch (\Throwable $ex) {
            return $this->sendResponseApi([
                'code' => 500,
                'error' => $ex->getMessage(),
            ]);
        }
    }
}
