<?php

namespace App\Http\Controllers\Admin;

use App\Exports\OrderExport;
use App\Http\Controllers\Controller;
use App\Model\Order;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportController extends Controller
{
    public function export(Request $request)
    {
        $start = $request['start-date'];
        $end = $request['end-date'];

        if ($start == $end) {
            $orders = Order::where('created_at', 'like', "%{$start}%")->whereHas('details', function ($query) {
                $query->whereHas('product', function ($query) {
                    $query->where('added_by', 'admin');
                });
            })->with(['customer'])->with(['details'])->get();
        } else {
            $orders = Order::whereBetween('created_at', [$start, $end])->whereHas('details', function ($query) {
                $query->whereHas('product', function ($query) {
                    $query->where('added_by', 'admin');
                });
            })->with(['customer'])->with(['details'])->get();
        }

        // dd($orders);
        // $export = $orders->map(function ($order, $i) {
        //     $shipping = $order->shipping_address_data;
        //     $arr = json_decode($shipping);
        //     $detail = $order->details->first();
        //     $products = json_decode(($detail->product_details));

        $export = $orders->map(function ($order, $i) {
            $shipping = $order->shipping_address_data;
            $arr = json_decode($shipping);
            $detail = $order->details;

            $prod = $detail->map(function ($det) {
                $p = json_decode($det->product_details);

                return $p->name;
            });

            $var = $detail->map(function ($det) {
                return $det->variation;
            });

            $qty = $detail->map(function ($det) {
                return $det->qty;
            });

            $siku = ['[', ']', '"'];
            $rep = ['', '', ' '];
            $exProd = str_replace($siku, $rep, $prod);

            $siku2 = ['[]', '[', ']', '"'];
            $rep2 = ['-', '', '', ' '];
            $exVar = str_replace($siku2, $rep2, $var);

            $siku3 = ['[', ']'];
            $rep3 = ['', ''];
            $exQty = str_replace($siku3, $rep3, $qty);

            return [
            'order_date' => date('d F Y, h:i:s A', strtotime($order->created_at)),
            'delivery_date' => date('d F Y', strtotime($order->delivery_date)),
            'customer_name' => $arr->contact_person_name,
            'product_name' => $prod->toArray(),
            'variation' => $var->toArray(),
            'qty' => $qty->toArray(),
            'price' => $order->order_amount,
            'order_no' => $detail[0]['order_id'],
            'payment' => $order->payment_method,
        ];
        });
        $data = [];
        $export->map(function ($ex, $i) use (&$data) {
            $prod = count($ex['product_name']);

            for ($in = 0; $in < $prod; ++$in) {
                $product = $ex['product_name'];
                $var = $ex['variation'];
                $qty = $ex['qty'];
                $item = [
                    'order_date' => $ex['order_date'],
                    'delivery_date' => $ex['delivery_date'],
                    'customer_name' => $ex['customer_name'],
                    'product_name' => $product[$in],
                    'variation' => $var[$in],
                    'qty' => $qty[$in],
                    'price' => $ex['price'],
                    'order_no' => $ex['order_no'],
                    'payment' => $ex['payment'],
                ];
                array_push($data, $item);
            }
        });

        // dd($data);

        return Excel::download(new OrderExport($data), 'Grosa | '.$start.' -- '.$end.'.xlsx');
    }
}
