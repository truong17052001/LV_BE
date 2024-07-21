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
    public function __construct(AuthRepository $authRepo, TokenRepository $toKenRepo)
    {
        $this->authRepository = $authRepo;
        $this->toKenRepository = $toKenRepo;
    }
    public function login(Request $request)
    {
        // dd($request->all());
        try {
            $validator = Validator::make($request->all(), [
                "email" => "required|email|exists:users,email",
                "matkhau" => "required|min:7"
            ]);

            if ($validator->fails()) {
                return $this->sendResponseApi([
                    'code' => '400',
                    'error' => $validator->errors()->all()
                ]);
            }

            $user = $this->authRepository->findByColumns(['email' => $request['email']]);
            if (empty($user) || !Hash::check($request['matkhau'], $user->matkhau)) {
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

    public function changePassword($id, Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [

            ]);

            if ($validator->fails()) {
                return $this->sendResponseApi([
                    'code' => '400',
                    'error' => $validator->errors()->all()
                ]);
            }
            $user = $this->authRepository->find($id);
            $input = [
                'matkhau' => Hash::make($request->moi),
            ];
            if (empty($user) || !Hash::check($request['cu'], $user->matkhau)) {
                return $this->sendResponseApi([
                    'code' => 401,
                    'error' => 'Invalid Login'
                ]);
            } else {
                $this->authRepository->update($id, $input);
            }

            return $this->sendResponseApi([
                'code' => 200,
                'data' => [
                    'user' => $user,
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
                "matkhau" => "required|min:7"
            ]);

            if ($validator->fails()) {
                return $this->sendResponseApi([
                    'code' => 400,
                    'error' => $validator->errors()->all()
                ]);
            }

            $input['ten'] = "Chờ cập nhật";
            $input['matkhau'] = Hash::make($input['matkhau']);
            $input['ngaysinh'] = date('ymdHis');
            $input['dakichhoat'] = 0;

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

    public function index(Request $request)
    {
        $search = [];

        $auth = $this->authRepository->getAll(
            $search,
        );
        return $this->sendResponseApi([
            'code' => 200,
            'data' => $auth,
        ]);
    }
    public function detail($id)
    {
        $auth = $this->authRepository->find($id);

        return $this->sendResponseApi([
            'code' => 200,
            'data' => $auth,
        ]);
    }
    public function edit($id, Request $request)
    {
        $validator = Validator::make($request->all(), [

        ]);

        if ($validator->fails()) {
            return $this->sendResponseApi([
                'code' => '400',
                'error' => $validator->errors()->all()
            ]);
        }

        $input = [
            'ten' => $request->ten,
            'email' => $request->email,
            'sdt' => $request->sdt,
            'gioitinh' => $request->gioitinh,
            'diachi' => $request->diachi,
            'ngaysinh' => $request->ngaysinh,
            'anh' => $request->anh,
        ];

        $this->authRepository->update(
            $id,
            $input
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }
    public function delete($id)
    {
        $this->authRepository->delete(
            $id,
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }
}
