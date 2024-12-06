<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Gate;

use Illuminate\Routing\Controller;

use App\Models\Order;
use App\Models\OrderProduct;
use App\Models\Cart;

class OrderController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    protected function cartValues(string $filterby = null, bool $admin = false) {

        if ($admin ==false) {
            if ($filterby){
                $orders = Order::where('user_id', '=', Auth::id())->orderBy($filterby)->paginate(20);
            } else {
                $orders = Order::where('user_id', '=', Auth::id())->paginate(20);
            }
        } else {
            if ($filterby){
                $orders = Order::orderBy($filterby, 'desc')->paginate(20);
            } else {
                $orders = Order::paginate(20);
            }
        }
        //$orders = Auth::user()->order->paginate(20);

        $cart_items = Auth::user()->cart;
        $total = 0;

        foreach ($cart_items as $key => $item) {
            $total += $item->unit_price * $item->quantity;
        }

        return ['orders' => $orders, 'cart_items' => $cart_items, 'total' => $total];
    }

    public function view(Request $request) {
        if ($request->filterby) {
            return view('orders.user', ["orders" => $this->cartValues($request->filterby)['orders']]);    
        }

        return view('orders.user', ["orders" => $this->cartValues()['orders']]);
    }

    public function adminView(Request $request) {
        if ($request->filterby) {
            return view('orders.admin', ["orders" => $this->cartValues($request->filterby, true)['orders']]);    
        }

        return view('orders.admin', ["orders" => $this->cartValues(null, true)['orders']]);
    }

    public function create(Request $request){
        $this->authorize('create', Order::class);

        $order = Order::create([
            'total' => $this->cartValues()['total'],
            'status' => 1,
            'user_id' => Auth::id()
        ]);

        foreach ($this->cartValues()['cart_items'] as $key => $item) {
            $validator = Validator::make([
                "product_id" => $item->product_id,
                "description" => $item->description,
                "unit_price" => $item->unit_price,
                "quantity" => $item->quantity
            ],[
                'product_id' => 'required|integer',
                'description' => 'required|string',
                'unit_price' => 'required|decimal:0,2',
                'quantity' => 'required|integer',
            ]);

            if ($validator->fails()) {
                return redirect('/cart');
            };

            OrderProduct::create([
                "order_id" => $order->id,
                "product_id" => $item->product_id,
                "description" => $item->description,
                "unit_price" => $item->unit_price,
                "quantity" => $item->quantity
            ]);

            Cart::where('user_id', '=', Auth::id())->where('product_id', '=', $item->product_id)->delete();
        }

        return redirect('/cart');
    }
    
    public function update(Request $request) {
        $request->validate([
            'status' => 'required|integer',
            'order_id' => 'required|integer'
        ]);

        
        //dump($order);
        if (!Gate::authorize('isAdmin')){
            $order = Order::where('user_id', '=', Auth::id())->where('id', '=', $request->order_id)->firstOrFail();
            $this->authorize('update', $order);
            
            $order->update(['status' => $request->status]);
            return redirect('/orders');
        } else {
            $order = Order::where('id', '=', $request->order_id)->firstOrFail();

            $order->update(['status' => $request->status]);
            return redirect('/orders/all');
        }
    }
}
