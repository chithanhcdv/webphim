<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PaymentController extends Controller
{
    public function paypalPayment(Request $request)
    {
        try {
            $provider = new PayPalClient();
            $provider->setApiCredentials(config('services.paypal'));
            $provider->setAccessToken();

            // Continue with creating the order
            $response = $provider->createOrder([
                'intent' => 'CAPTURE',
                'purchase_units' => [[
                    'amount' => [
                        'currency_code' => 'USD',
                        'value' => '10.00',  // Replace with the service price
                    ],
                ]],
            ]);

            if (isset($response['id']) && $response['status'] == 'CREATED') {
                return redirect($response['links'][1]['href']);
            }

            return redirect()->back()->with('status', 'PayPal payment could not be created.');

        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'Error: ' . $e->getMessage());
        }
    }


    public function paypalCapture(Request $request)
    {
        $provider = new PayPalClient();
        $provider->setApiCredentials(config('services.paypal'));
        $provider->setAccessToken();

        $result = $provider->capturePaymentOrder($request->query('token'));

        if ($result['status'] == 'COMPLETED') {
            return redirect()->route('user.service')->with('status', 'PayPal payment completed successfully!');
        }

        return redirect()->route('user.service')->with('status', 'PayPal payment failed.');
    }

    public function momoPayment(Request $request)
    {
        $endpoint = "https://test-payment.momo.vn/v2/gateway/api/create";
        $partnerCode = "MOMOBKUN20180529"; // Thay bằng mã đối tác của bạn
        $accessKey = "klm05TvNBzhg7h7j"; // Thay bằng accessKey của bạn
        $secretKey = "at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa"; // Thay bằng secretKey của bạn
        $orderInfo = "Thanh toán dịch vụ";
        $amount = intval($request->price);
        $orderId = time(); // Mã đơn hàng (unique)
        $redirectUrl = route('momo.return') . '?service_id=' . $request->service_id;
        $ipnUrl = route('momo.return'); // URL thông báo kết quả (không bắt buộc)
        $extraData = ""; // Thêm thông tin nếu cần
        $requestType = "payWithATM";

        // Dữ liệu gửi tới MoMo
        $requestData = [
            'partnerCode' => $partnerCode,
            'accessKey' => $accessKey,
            'requestId' => time(),
            'amount' => $amount,
            'orderId' => $orderId,
            'orderInfo' => $orderInfo,
            'redirectUrl' => $redirectUrl,
            'ipnUrl' => $ipnUrl,
            'extraData' => $extraData,
            'requestType' => $requestType,
        ];

        // Tạo chữ ký
        $rawHash = "accessKey=" . $accessKey .
            "&amount=" . $amount .
            "&extraData=" . $extraData .
            "&ipnUrl=" . $ipnUrl .
            "&orderId=" . $orderId .
            "&orderInfo=" . $orderInfo .
            "&partnerCode=" . $partnerCode .
            "&redirectUrl=" . $redirectUrl .
            "&requestId=" . $requestData['requestId'] .
            "&requestType=" . $requestData['requestType'];

        $requestData['signature'] = hash_hmac("sha256", $rawHash, $secretKey);

        // Gửi yêu cầu tới MoMo
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $endpoint);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($requestData));
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
        $response = curl_exec($ch);
        curl_close($ch);

        $result = json_decode($response, true);

        if (isset($result['payUrl'])) {
            return redirect($result['payUrl']); // Chuyển hướng người dùng tới cổng thanh toán
        }

        return redirect()->back()->with('status', 'Không thể kết nối đến cổng thanh toán MoMo.');
    }

    public function momoReturn(Request $request)
    {
        $secretKey = "at67qH6mk8w5Y1nAyMoYKMWACiEi2bsa";
        $requestData = $request->all();

        // Tạo chữ ký hash để kiểm tra tính hợp lệ
        $rawHash = "amount=" . $requestData['amount'] .
            "&extraData=" . $requestData['extraData'] .
            "&message=" . $requestData['message'] .
            "&orderId=" . $requestData['orderId'] .
            "&orderInfo=" . $requestData['orderInfo'] .
            "&orderType=" . $requestData['orderType'] .
            "&partnerCode=" . $requestData['partnerCode'] .
            "&payType=" . $requestData['payType'] .
            "&requestId=" . $requestData['requestId'] .
            "&responseTime=" . $requestData['responseTime'] .
            "&resultCode=" . $requestData['resultCode'] .
            "&transId=" . $requestData['transId'];

        $signature = hash_hmac("sha256", $rawHash, $secretKey);


        // Kiểm tra chữ ký và kết quả giao dịch
        if ($requestData['resultCode'] == '0') {
            // Thanh toán thành công
            $user = Auth::user();
            $serviceId = $request->input('service_id');

            $service = DB::table('services')->where('id', $serviceId)->first();
            
            if (!$service) {
                return view('user.payment.fail', ['status' => 'Gói dịch vụ không tồn tại.']);
            }

            DB::table('services_orders')->insert([
                'user_id' => $user->id,
                'service_id' => $service->id,
                'order_code' => $requestData['orderId'],
                'payment_method' => 'MoMo',
                'service_start_at' => now(),
                'service_end_at' => now()->addDays($service->duration),
                'status' => 'đang sử dụng',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            return view('user.payment.success', ['status' => 'Thanh toán MoMo thành công!']);
        }

        // Thanh toán thất bại
        return view('user.payment.fail', ['status' => 'Giao dịch thất bại.']);
    }


    public function vnpayPayment(Request $request)
    {
        $vnp_TmnCode = "SVVX46MJ"; // Mã website tại VNPAY
        $vnp_HashSecret = "08VVLUZ2WKPH566SKYMUAUWS9GFZKKIU"; // Chuỗi bí mật
        $vnp_Url = "https://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
        $vnp_Returnurl = route('vnpay.return') . '?service_id=' . $request->service_id;
        $vnp_Returnurl = route('vnpay.return') . '?service_id=' . $request->service_id . 
        '&payment_method=' . $request->payment_method;
        $vnp_TxnRef = rand(); // Mã đơn hàng
        $vnp_OrderInfo = "Thanh toán dịch vụ";
        $vnp_OrderType = 'billpayment';
        $vnp_Amount = $request->price * 100; // Số tiền (VNĐ)
        $vnp_Locale = 'vn'; // Ngôn ngữ
        $vnp_BankCode = 'NCB'; // Mã ngân hàng
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];

        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );

        if (isset($vnp_BankCode) && $vnp_BankCode != "") {
        $inputData['vnp_BankCode'] = $vnp_BankCode;
        }
        if (isset($vnp_Bill_State) && $vnp_Bill_State != "") {
            $inputData['vnp_Bill_State'] = $vnp_Bill_State;
        }

        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }

        $vnp_Url = $vnp_Url . "?" . $query;
        if (isset($vnp_HashSecret)) {
            $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
            $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
        }

        return redirect($vnp_Url);
    }

    public function vnpayReturn(Request $request)
    {
        $vnp_HashSecret = env('VNP_HASH_SECRET'); // Chuỗi bí mật
        $inputData = array();
        foreach ($request->all() as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }

        $vnp_SecureHash = $inputData['vnp_SecureHash'];
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= $key . "=" . $value . '&';
        }
        $hashData = rtrim($hashData, '&');

        $vnp_Hash = hash_hmac('sha512', $hashData, $vnp_HashSecret);
        
        // Xử lý thành công, hiển thị kết quả giao dịch
        if ($inputData['vnp_ResponseCode'] == '00') {
            $user = Auth::user();
            $service_id = $request->input('service_id');
            $payment_method = $request->input('payment_method');
            $service = DB::table('services')->where('id', $service_id)->first();

            if (!$service) {
                return view('user.payment.success', ['status' => 'Gói dịch vụ không tồn tại']);
            }

            DB::table('services_orders')->insert([
                'user_id' => $user->id,
                'service_id' => $service_id,
                'order_code' => $inputData['vnp_TxnRef'],
                'payment_method' => $payment_method, 
                'service_start_at' => now(),
                'service_end_at' => now()->addDays($service->duration),
                'status' => 'đang sử dụng',
                'created_at' => now(),
                'updated_at' => now(),
            ]);      

            return view('user.payment.success');
        } else {
            return view('user.payment.fail', ['status' => 'Giao dịch không thành công']);
        }
    }

    public function paymentSuccess()
    {
        return view('user.payment.success');
    }

    public function paymentFail()
    {
        return view('user.payment.fail');
    }

}
