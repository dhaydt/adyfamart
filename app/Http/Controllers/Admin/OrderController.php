<?php

namespace App\Http\Controllers\Admin;

use App\CPU\Helpers;
use App\CPU\OrderManager;
use function App\CPU\translate;
use App\Http\Controllers\Controller;
use App\Model\Order;
use App\Model\OrderTransaction;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function list(Request $request, $status)
    {
        $query_param = [];
        $search = $request['search'];
        // dd($request);
        $start = $request['start-date'];
        $end = $request['end-date'];

        $admin_type = session()->get('admin_type');

        if ($admin_type == 'reseller') {
            $id_mitra = session()->get('id_reseller');
            if (session()->has('show_inhouse_orders') && session('show_inhouse_orders') == 1) {
                $query = Order::with('mitra', 'customer')->where('id_mitra', $id_mitra)->whereHas('details', function ($query) {
                    $query->whereHas('product', function ($query) {
                        $query->where('added_by', 'admin');
                    });
                })->with(['customer']);

                if ($status != 'all') {
                    $orders = $query->where(['order_status' => $status]);
                } else {
                    $orders = $query;
                }

                if ($request->has('search')) {
                    $key = explode(' ', $request['search']);
                    $orders = $orders->where(function ($q) use ($key) {
                        foreach ($key as $value) {
                            $q->orWhere('id', 'like', "%{$value}%")
                                ->orWhere('order_status', 'like', "%{$value}%")
                                ->orWhere('id_mitra', 'like', "%{$value}%")
                                ->orWhere('transaction_ref', 'like', "%{$value}%");
                        }
                    })->orWhereHas('customer', function ($filter) use ($key) {
                        foreach ($key as $val) {
                            $filter->where('id_member', 'like', "%{$val}%")
                            ->orWhere('f_name', 'like', "%{$val}%");
                        }
                    });
                    $query_param = ['search' => $request['search']];
                }

                if ($request->has('start-date')) {
                    if ($start == $end) {
                        $orders = $orders->where('created_at', 'like', "%{$start}%");
                    } else {
                        $orders = $orders->whereBetween('created_at', [$start, $end]);
                    }
                    $query_param = ['start-date' => $start, 'end-date' => $end];
                }
            } else {
                if ($status != 'all') {
                    $orders = Order::with(['customer', 'mitra'])->where(['order_status' => $status, 'id_mitra' => $id_mitra]);
                } else {
                    $orders = Order::with(['customer', 'mitra'])->where('id_mitra', $id_mitra);
                }

                if ($request->has('search')) {
                    $key = explode(' ', $request['search']);
                    $orders = $orders->where(function ($q) use ($key) {
                        foreach ($key as $value) {
                            $q->orWhere('id', 'like', "%{$value}%")
                                ->orWhere('order_status', 'like', "%{$value}%")
                                ->orWhere('transaction_ref', 'like', "%{$value}%");
                        }
                    })->orWhereHas('customer', function ($filter) use ($key) {
                        foreach ($key as $val) {
                            $filter->where('id_member', 'like', "%{$val}%")
                            ->orWhere('f_name', 'like', "%{$val}%");
                        }
                    });
                    $query_param = ['search' => $request['search']];
                    // dd('reseller2', $query_param);
                }

                if ($request->has('start-date')) {
                    if ($start == $end) {
                        $orders = $orders->where('created_at', 'like', "%{$start}%");
                    } else {
                        $orders = $orders->whereBetween('created_at', [$start, $end]);
                    }
                    $query_param = ['start-date' => $start, 'end-date' => $end];
                }
            }
        } elseif ($admin_type == 'admin') {
            if (session()->has('show_inhouse_orders') && session('show_inhouse_orders') == 1) {
                $query = Order::with('mitra', 'customer')->whereHas('details', function ($query) {
                    $query->whereHas('product', function ($query) {
                        $query->where('added_by', 'admin');
                    });
                })->with(['customer']);

                if ($status != 'all') {
                    $orders = $query->where(['order_status' => $status]);
                } else {
                    $orders = $query;
                }

                if ($request->has('search')) {
                    $key = explode(' ', $request['search']);
                    $orders = $orders->where(function ($q) use ($key) {
                        foreach ($key as $value) {
                            $q->orWhere('id', 'like', "%{$value}%")
                                ->orWhere('order_status', 'like', "%{$value}%")
                                ->orWhere('transaction_ref', 'like', "%{$value}%");
                        }
                    })->orWhereHas('customer', function ($k) use ($key) {
                        foreach ($key as $value) {
                            $k->where('id_member', 'like', "%{$value}%")
                            ->orWhere('f_name', 'like', "%{$value}%");
                        }
                    });
                    $query_param = ['search' => $request['search']];
                }

                if ($request->has('start-date')) {
                    if ($start == $end) {
                        $orders = $orders->where('created_at', 'like', "%{$start}%");
                    } else {
                        $orders = $orders->whereBetween('created_at', [$start, $end]);
                    }
                    $query_param = ['start-date' => $start, 'end-date' => $end];
                }
            } else {
                if ($status != 'all') {
                    $orders = Order::with(['customer', 'mitra'])->where(['order_status' => $status]);
                } else {
                    $orders = Order::with(['customer', 'mitra']);
                }

                if ($request->has('search')) {
                    // dd('else', $orders->get());
                    $key = explode(' ', $request['search']);
                    $orders = $orders->where(function ($q) use ($key) {
                        foreach ($key as $value) {
                            $q->orWhere('id', 'like', "%{$value}%")
                                ->orWhere('order_status', 'like', "%{$value}%")
                                ->orWhere('transaction_ref', 'like', "%{$value}%");
                        }
                    })->orWhereHas('customer', function ($filter) use ($key) {
                        foreach ($key as $val) {
                            $filter->where('id_member', 'like', "%{$val}%")
                            ->orWhere('f_name', 'like', "%{$val}%");
                        }
                    })->orWhereHas('mitra', function ($filter) use ($key) {
                        foreach ($key as $val) {
                            $filter->where('code_admin', 'like', "%{$val}%")
                            ->orWhere('name', 'like', "%{$val}%");
                        }
                    });
                    $query_param = ['search' => $request['search']];
                }

                if ($request->has('start-date')) {
                    if ($start == $end) {
                        $orders = $orders->where('created_at', 'like', "%{$start}%");
                    } else {
                        $orders = $orders->whereBetween('created_at', [$start, $end]);
                    }
                    $query_param = ['start-date' => $start, 'end-date' => $end];
                }
            }
        }

        $orders = $orders->latest()->paginate(Helpers::pagination_limit())->appends($query_param);

        return view('admin-views.order.list', compact('orders', 'search', 'start', 'end'));
    }

    public function details($id)
    {
        $order = Order::with('details', 'shipping', 'seller', 'mitra')->where(['id' => $id])->first();
        $linked_orders = Order::where(['order_group_id' => $order['order_group_id']])
            ->whereNotIn('order_group_id', ['def-order-group'])
            ->whereNotIn('id', [$order['id']])
            ->get();

        return view('admin-views.order.order-details', compact('order', 'linked_orders'));
    }

    public function status(Request $request)
    {
        $order = Order::find($request->id);

        try {
            $fcm_token = $order->customer->cm_firebase_token;
            $value = Helpers::order_status_update_message($request->order_status);

            if ($request->order_status == 'canceled') {
                $value = 'Order anda telah dibatalkan!';
            }

            if ($value) {
                $data = [
                    'title' => translate('order'),
                    'description' => $value,
                    'order_id' => $order['id'],
                    'image' => '',
                ];
                Helpers::send_push_notif_to_device($fcm_token, $data);
            }
        } catch (\Exception $exception) {
        }

        $order->order_status = $request->order_status;
        OrderManager::stock_update_on_order_status_change($order, $request->order_status);
        $order->save();

        $transaction = OrderTransaction::where(['order_id' => $order['id']])->first();
        if (isset($transaction) && $transaction['status'] == 'disburse') {
            return response()->json($request->order_status);
        }

        if ($request->order_status == 'processing' && $order['seller_id'] != null) {
            OrderManager::wallet_manage_on_order_status_change($order, 'admin');
        }

        return response()->json($request->order_status);
    }

    public function payment_status(Request $request)
    {
        if ($request->ajax()) {
            $order = Order::find($request->id);
            $order->payment_status = $request->payment_status;
            $order->save();
            $data = $request->payment_status;

            return response()->json($data);
        }
    }

    public function generate_invoice($id)
    {
        $order = Order::with('seller', 'mitra')->with('shipping')->with('details')->where('id', $id)->first();
        $seller = [];

        $data['email'] = $order->customer['email'];
        $data['client_name'] = $order->customer['f_name'].' '.$order->customer['l_name'];
        $data['order'] = $order;

        // return view('admin-views.order.invoice')->with('order', $order)->with('seller', $seller);

        $mpdf_view = \View::make('admin-views.order.invoice')->with('order', $order)->with('seller', $seller);
        Helpers::gen_mpdf($mpdf_view, 'order_invoice_', $order->id);
    }

    public function inhouse_order_filter()
    {
        if (session()->has('show_inhouse_orders') && session('show_inhouse_orders') == 1) {
            session()->put('show_inhouse_orders', 0);
        } else {
            session()->put('show_inhouse_orders', 1);
        }

        return back();
    }
}
