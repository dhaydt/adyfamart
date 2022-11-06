<?php

namespace App\Http\Controllers\api\v1;

use App\CPU\CartManager;
use App\CPU\Helpers;
use App\CPU\OrderManager;
use function App\CPU\translate;
use App\Http\Controllers\Controller;
use App\Model\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function track_order(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => Helpers::error_processor($validator)], 403);
        }

        return response()->json(OrderManager::track_order($request['order_id']), 200);
    }

    public function place_order(Request $request)
    {
        $maintenance_mode = Helpers::get_business_settings('maintenance_mode') ?? 0;

        if ($maintenance_mode) {
            return response()->json(['status' => 200, 'message' => 'Sedang Peralihan Periode!, Mohon Tunggu beberapa menit.']);
        }

        $unique_id = $request->user()->id.'-'.rand(000001, 999999).'-'.time();
        $order_ids = [];
        foreach (CartManager::get_cart_group_ids($request) as $group_id) {
            $data = [
                'payment_method' => 'cash_on_delivery',
                'order_status' => 'pending',
                'payment_status' => 'unpaid',
                'transaction_ref' => '',
                'order_group_id' => $unique_id,
                'cart_group_id' => $group_id,
                'request' => $request,
            ];
            $order_id = OrderManager::generate_order($data);
            if ($order_id == 'limited') {
                return [
                    'status' => 2,
                    'message' => translate('You_have_reached_the_purchase_limit!'),
                ];
            }
            array_push($order_ids, $order_id);
        }

        CartManager::cart_clean($request);

        return response()->json(translate('order_placed_successfully'), 200);
    }

    public function order_cancel($id)
    {
        $order = Order::where(['id' => $id])->first();
        // if ($order['payment_method'] == 'cash_on_delivery' && $order['order_status'] == 'pending') {
        OrderManager::stock_update_on_order_status_change($order, 'canceled');
        Order::where(['id' => $id])->update([
                'order_status' => 'canceled',
            ]);

        try {
            $fcm_token = $order->customer->cm_firebase_token;
            $value = 'Order anda telah dibatalkan';

            if ($value) {
                $data = [
                        'title' => translate('order'),
                        'description' => $value,
                        'order_id' => $id,
                        'image' => '',
                    ];
                Helpers::send_push_notif_to_device($fcm_token, $data);
            }
        } catch (\Exception $exception) {
        }

        return response()->json(translate('order_canceled_successfully'), 200);
        // }
        // if ($order['payment_method'] != 'cash_on_delivery' && $order['order_status'] == 'pending') {
        //     OrderManager::stock_update_on_order_status_change($order, 'canceled');
        //     Order::where(['id' => $id])->update([
        //         'order_status' => 'canceled',
        // ]);
        //     Toastr::success(translate('successfully_canceled'));

        //     return back();
        // }
        // Toastr::error(translate('status_not_changable_now'));

        // return back();
    }
}
