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
        try {
            $validator = Validator::make($request->all(), [
                "email" => "required|email|exists:users,email",
                "matkhau" => "required|min:7"
            ], [
                'email.required' => 'Email là bắt buộc.',
                'email.email' => 'Email không hợp lệ.',
                'email.exists' => 'Email không tồn tại.',
                'matkhau.required' => 'Mật khẩu là bắt buộc',
                'matkhau.min' => 'Mật khẩu phải có ít nhất 7 kí tự',
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
                    'error' => 'Sai mật khẩu vui lòng nhập lại'
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
                "moi" => "required|min:7",
                "cu" => "required|min:7",
            ], [
                'moi.required' => 'Mật khẩu mới là bắt buộc.',
                'moi.min' => 'Mật khẩu mới phải có ít nhất 7 ký tự.',
                'cu.required' => 'Mật khẩu cũ là bắt buộc.',
                'cu.min' => 'Mật khẩu cũ phải có ít nhất 7 ký tự.',
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
                    'error' => 'Mật khẩu cũ không chính xác'
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
            ], [
                'email.required' => 'Email là bắt buộc.',
                'email.email' => 'Email không hợp lệ.',
                'email.unique' => 'Email đã tồn tại.',
                'matkhau.required' => 'Mật khẩu là bắt buộc',
                'matkhau.min' => 'Mật khẩu phải có ít nhất 7 kí tự',
            ]);

            if ($validator->fails()) {
                return $this->sendResponseApi([
                    'code' => 400,
                    'error' => $validator->errors()->all()
                ]);
            }

            $input['matkhau'] = Hash::make($input['matkhau']);
            $input['ngaysinh'] = date('ymdHis');
            $input['quyen'] = "Khách hàng";
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

    public function booking($id)
    {
        $auth = $this->authRepository->getOrdered($id);

        return $this->sendResponseApi([
            'code' => 200,
            'data' => $auth,
        ]);
    }

    public function edit($id, Request $request)
    {
        $validator = Validator::make($request->all(), [
            'ten' => 'required|string|max:255',
            'email' => 'required|email',
            'sdt' => 'required|digits:10|regex:/^[0-9]+$/',
            'gioitinh' => 'required|string',
            'diachi' => 'required|string|max:255',
            'ngaysinh' => 'required|date',
            'anh' => 'nullable',
        ], [
            'ten.required' => 'Tên là bắt buộc.',
            'ten.string' => 'Tên phải là chuỗi.',
            'ten.max' => 'Tên không được vượt quá 255 ký tự.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'sdt.required' => 'Số điện thoại là bắt buộc.',
            'sdt.digits' => 'Số điện thoại phải có đúng 10 chữ số.',
            'sdt.regex' => 'Số điện thoại chỉ được chứa các chữ số.',
            'gioitinh.required' => 'Giới tính là bắt buộc.',
            'gioitinh.string' => 'Giới tính phải là chuỗi.',
            'diachi.required' => 'Địa chỉ là bắt buộc.',
            'diachi.string' => 'Địa chỉ phải là chuỗi.',
            'diachi.max' => 'Địa chỉ không được vượt quá 255 ký tự.',
            'ngaysinh.required' => 'Ngày sinh là bắt buộc.',
            'ngaysinh.date' => 'Ngày sinh không hợp lệ.',
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
            'quyen' => $request->quyen
        ];

        $user = $this->authRepository->update(
            $id,
            $input
        );

        return $this->sendResponseApi([
            'code' => 200,
            'data' => $user
        ]);
    }
    public function delete($id)
    {
        $id_temp = $this->authRepository->find($id)->bookings;
        if (count($id_temp) <= 0) {
            $this->authRepository->delete(
                $id,
            );
            return $this->sendResponseApi([
                'code' => 200,
            ]);
        } else {
            return $this->sendResponseApi([
                'code' => 400,
                'error' => ["Không thể xóa vì dữ liệu còn tồn tại ở bảng khác!"]
            ]);
        }
    }
}
