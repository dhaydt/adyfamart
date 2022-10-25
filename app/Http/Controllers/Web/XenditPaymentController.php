<?php

namespace App\Http\Controllers\Web;

use App\CPU\CartManager;
use App\CPU\Convert;
use App\CPU\OrderManager;
use function App\CPU\translate;
use App\Http\Controllers\Controller;
use App\Model\Order;
use Brian2694\Toastr\Facades\Toastr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Xendit\Xendit;

class XenditPaymentController extends Controller
{
    public function index()
    {
        Xendit::setApiKey(config('xendit.apikey'));

        // $createVA = \Xendit\VirtualAccounts::create($params);
        // var_dump($createVA);
        $bank = \Xendit\VirtualAccounts::getVABanks();

        return view('admin-views.business-settings.payment-method.xendit', compact('bank'));
    }

    public function getListVa()
    {
        Xendit::setApiKey(config('xendit.apikey'));

        // $createVA = \Xendit\VirtualAccounts::create($params);
        // var_dump($createVA);
        $getVABank = \Xendit\VirtualAccounts::getVABanks();

        return response()->json([
            'data' => $getVABank,
        ])->setStatusCode('200');
    }

    public function createVa(Request $request)
    {
        // dd($request);
        Xendit::setApiKey(config('xendit.apikey'));

        $params = ['external_id' => \uniqid(),
        'bank_code' => $request->bank,
        'name' => $request->name,
        'expected_amount' => (int) $request->price,
        'is_closed' => true,
        'is_single_use' => true,
        'expiration_date' => Carbon::now()->addDay(1)->toISOString(),
    ];

        $virtual = \Xendit\VirtualAccounts::create($params);
        dd($virtual);

        return view('web-views.finish-payment', compact('virtual'));

        // return view('admin-views.business-settings.payment-method.xendit-virtual-account', compact('virtual'));
    }

    // OLD INVOICE

    // public function invoice(Request $request)
    // {
    //     dd($request);
    //     $customer = auth('customer')->user();
    //     $discount = session()->has('coupon_discount') ? session('coupon_discount') : 0;
    //     $value = CartManager::cart_grand_total() - $discount;
    //     $tran = OrderManager::gen_unique_id();

    //     session()->put('transaction_ref', $tran);

    //     Xendit::setApiKey(config('xendit.apikey'));

    //     $products = [];
    //     foreach (CartManager::get_cart() as $detail) {
    //         array_push($products, [
    //             'name' => $detail->product['name'],
    //         ]);
    //     }
    //     // dd($products);

    //     $user = [
    //         'given_names' => $customer->f_name,
    //         'email' => $customer->email,
    //         'mobile_number' => $customer->phone,
    //         'address' => $customer->district.', '.$customer->city.', '.$customer->province,
    //     ];

    //     $params = [
    //         'external_id' => 'ws'.$customer->phone.$customer->id,
    //         'amount' => Convert::usdToidr($value),
    //         'payer_email' => $customer->email,
    //         'description' => 'WSHOPEDIA',
    //         'payment_methods' => [$request->type],
    //         'fixed_va' => true,
    //         'should_send_email' => true,
    //         'customer' => $user,
    //         'success_redirect_url' => env('APP_URL').'/xendit-payment/success/'.$request->type,
    //     ];

    //     $checkout_session = \Xendit\Invoice::create($params);
    //     return redirect()->away($checkout_session['invoice_url']);
    // }

    // NEW INVOICE

    public function invoice(Request $request)
    {
        $date = Carbon::now()->toTimeString();
        $limit = '21:00:00';
        if (strtotime($date) > strtotime($limit)) {
            Toastr::success(translate('The_payment_deadline_has_expired_,_please_pay_tomorrow'));

            return Redirect::back();
        }
        $duration = strtotime($limit) - strtotime($date);

        $customer = auth('customer')->user();
        $order_id = $request->order_id;
        $order = Order::find($order_id);
        $value = $order['order_amount'];
        $tran = OrderManager::gen_unique_id();

        session()->put('transaction_ref', $tran);
        Xendit::setApiKey(config('xendit.apikey'));

        $products = [];
        foreach (CartManager::get_cart() as $detail) {
            array_push($products, [
                'name' => $detail->product['name'],
            ]);
        }

        $user = [
            'given_names' => $customer->f_name,
            'email' => $customer->email,
            'mobile_number' => $customer->phone,
            'address' => $customer->district.', '.$customer->city.', '.$customer->province,
        ];

        $params = [
            'external_id' => $order_id,
            'amount' => Convert::usdToidr($value),
            'payer_email' => $customer->email,
            'description' => 'GROSA',
            'payment_methods' => [$request->type],
            'fixed_va' => true,
            'should_send_email' => true,
            'customer' => $user,
            'invoice_duration' => $duration,
            'success_redirect_url' => env('APP_URL').'/xendit-payment/success/'.$order_id,
            'failure_redirect_url' => env('APP_URL').'/xendit-payment/expired/'.$order_id,
        ];

        $checkout_session = \Xendit\Invoice::create($params);

        return redirect()->away($checkout_session['invoice_url']);
    }

    public function expire($id)
    {
        $order = Order::where(['id' => $id])->first();
        OrderManager::stock_update_on_order_status_change($order, 'canceled');
        Order::where(['id' => $id])->update([
                'order_status' => 'canceled',
        ]);

        Toastr::success(translate('order_expired_for_order_ID').': '.$id);

        return redirect()->route('account-oder');
    }

    public function success($type)
    {
        $orderId = $type;

        $order_ids = [];

        Order::where('id', $orderId)->update([
            'order_status' => 'confirmed',
            'payment_status' => 'paid',
            'transaction_ref' => session('transaction_ref'),
        ]);

        array_push($order_ids, $orderId);
        // foreach (CartManager::get_cart_group_ids() as $group_id) {
        //     $data = [
        //         'order_status' => 'confirmed',
        //         'payment_status' => 'paid',
        //         'transaction_ref' => session('transaction_ref'),
        //     ];
        //     $order_id = OrderManager::generate_order($data);
        //     array_push($order_ids, $order_id);
        // }
        session()->put('orderID', $type);
        session()->put('payment_status', 'success');
        CartManager::cart_clean();
        if (auth('customer')->check()) {
            Toastr::success('Payment success.');

            return view('web-views.checkout-complete');
        }

        return response()->json(['message' => 'Payment succeeded'], 200);
    }
}
