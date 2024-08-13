<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Repositories\Client\PaymentRepository;
use App\Repositories\Client\BookingRepository;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    private PaymentRepository $paymentRepository;
    private BookingRepository $bookingRepository;


    public function __construct(PaymentRepository $paymentRepo, BookingRepository $bookingRepo)
    {
        $this->paymentRepository = $paymentRepo;
        $this->bookingRepository = $bookingRepo;
    }

    public function index(Request $request)
    {
        $search = [];

        $payments = $this->paymentRepository->getAll(
            $search,

        );
        return $this->sendResponseApi([
            'code' => 200,
            'data' => $payments,
        ]);
    }

    public function detail($id)
    {

        $payment = $this->paymentRepository->findAllByColumns(['mabooking' => $id]);

        return $this->sendResponseApi([
            'code' => 200,
            'data' => $payment,
        ]);
    }

    public function execPostRequest($url, $data)
    {
        $ch = curl_init($url);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt(
            $ch,
            CURLOPT_HTTPHEADER,
            array(
                'Content-Type: application/json',
                'Content-Length: ' . strlen($data)
            )
        );
        curl_setopt($ch, CURLOPT_TIMEOUT, 100);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 100);

        // Tắt xác thực SSL
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);

        // Execute post
        $result = curl_exec($ch);
        $error = curl_error($ch);
        // Close connection
        curl_close($ch);

        if ($result === false) {
            throw new \Exception('cURL Error: ' . $error);
        }

        return $result;
    }


    public function momo_payment(Request $request)
    {
        $payment = $this->paymentRepository->create([
            'giatri' => $request->giatri,
            'pttt' => $request->pttt,
            'trangthai' => 'Chưa thanh toán',
            'mabooking' => $request->mabooking,
            'makh' => $request->makh,
        ]);

        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";

        $partnerCode = 'MOMOBKUN20180529';
        $accessKey = 'klm05TvNBzhg7h7j';
        $secretKey = 'at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa';
        $orderInfo = "Thanh toán qua MoMo";
        $amount = $request->giatri;
        $orderId = time() . "";
        $redirectUrl = "http://localhost:5173/";
        $ipnUrl = "http://localhost:5173/";
        $extraData = $payment->id;

        $requestId = time();
        $requestType = "payWithATM";
        // $requestType = "captureWallet";

        $rawHash = "accessKey=" . $accessKey . "&amount=" . $amount . "&extraData=" . $extraData . "&ipnUrl=" . $ipnUrl . "&orderId=" . $orderId . "&orderInfo=" . $orderInfo . "&partnerCode=" . $partnerCode . "&redirectUrl=" . $redirectUrl . "&requestId=" . $requestId . "&requestType=" . $requestType;
        $signature = hash_hmac("sha256", $rawHash, $secretKey);

        $data = [
            'partnerCode' => $partnerCode,
            'partnerName' => "Test",
            'storeId' => "MomoTestStore",
            'requestId' => $requestId,
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'lang' => 'vi',
            'extraData' => $extraData,
            'requestType' => $requestType,
            'signature' => $signature,
        ];
        try {
            $result = $this->execPostRequest($endpoint, json_encode($data));
            $jsonResult = json_decode($result, true);
            if (isset($jsonResult['payUrl'])) {
                return $jsonResult['payUrl'];
            } else {
                return $this->sendResponseApi([
                    'code' => 500,
                    'error' => 'Không thể tạo thanh toán với MoMo',
                    'details' => $jsonResult
                ]);
            }
        } catch (\Exception $e) {
            return $this->sendResponseApi([
                'code' => 500,
                'error' => 'Đã có lỗi xảy ra: ' . $e->getMessage(),
            ]);
        }
    }


    public function momoCallback(Request $request)
    {
        $data = $request->all();
        $resultCode = $data['resultCode'] ?? '';
        $extraData = $data['extraData'] ?? '';

        $paymentId = (int) $extraData;
        $payment = $this->paymentRepository->find($paymentId);

        if (!$payment) {
            return $this->sendResponseApi([
                'code' => 404,
                'message' => 'Giao dịch không tồn tại',
            ]);
        }

        if ($resultCode == '0') {
            $this->paymentRepository->update($paymentId, ['trangthai' => "Đã thanh toán"]);
            $this->bookingRepository->update($payment->mabooking, ['trangthai' => "Chờ xác nhận"]);
        } else {
            $this->paymentRepository->update($paymentId, ['trangthai' => "Thanh toán thất bại"]);
            $this->bookingRepository->update($payment->mabooking, ['trangthai' => "Đã hủy"]);
        }

        return response()->json([
            'code' => 200,
            'message' => $resultCode == '0' ? 'Thanh toán thành công' : 'Thanh toán thất bại',
            'data' => $data,
        ]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'giatri' => 'required|numeric',
            'pttt' => 'required|string',
            'trangthai' => 'string',
            'mabooking' => 'required',
            'makh' => 'required',
        ], [
            'giatri.required' => 'Giá trị là bắt buộc.',
            'giatri.numeric' => 'Giá trị phải là số.',
            'pttt.required' => 'Phương thức thanh toán là bắt buộc.',
            'pttt.string' => 'Phương thức thanh toán phải là chuỗi.',
            'trangthai.required' => 'Trạng thái là bắt buộc.',
            'trangthai.string' => 'Trạng thái phải là chuỗi.',
            'makh.required' => 'Mã khách hàng là bắt buộc.',
        ]);

        if ($validator->fails()) {
            return $this->sendResponseApi([
                'code' => '400',
                'error' => $validator->errors()->all()
            ]);
        }
        $input = [
            'giatri' => $request->giatri,
            'pttt' => $request->pttt,
            'trangthai' => "Chưa thanh toán",
            'mabooking' => $request->mabooking,
            'makh' => $request->makh,
        ];

        $this->paymentRepository->create(
            $input
        );

        return $this->sendResponseApi([
            'code' => 200,
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
            'tien' => $request->tien,
            'pttt' => $request->pttt,
            'trangthai' => $request->trangthai,
            'mabooking' => $request->mabooking,
            'makh' => $request->makh,
        ];

        $this->paymentRepository->update(
            $id,
            $input
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }

    public function paid($id, Request $request)
    {
        $payment = $this->paymentRepository->update(
            $id,
            ['trangthai' => "Đã thanh toán"]
        );
        $this->bookingRepository->update($payment->mabooking, ['trangthai' => "Chờ xác nhận"]);

        return $this->sendResponseApi([
            'code' => 200,
            'data' => $payment
        ]);
    }

    public function delete($id)
    {
        $this->paymentRepository->delete(
            $id,
        );

        return $this->sendResponseApi([
            'code' => 200,
        ]);
    }
}