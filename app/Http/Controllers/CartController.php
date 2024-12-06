<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

Use App\Models\Cart;

class CartController extends Controller
{
    use AuthorizesRequests, ValidatesRequests;

    protected function cartValues() {
        $cart_items = Auth::user()->cart;
        $total = 0;

        foreach ($cart_items as $key => $item) {
            $total += $item->unit_price * $item->quantity;
        }

        return ['cart_items' => $cart_items, 'total' => $total];
    }

    public function view() {
        
        return view('cart', ["cart_items" => $this->cartValues()['cart_items'], "total" => $this->cartValues()['total']]);
    }

    public function addToCart(Request $request) {
        $this->authorize('create', Cart::class);
        
        $data = $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
            'unit_price' => 'required|decimal:0,2',
            'description' => 'required|string',
        ]);

        $cart = Cart::where('product_id', '=', $request->product_id)->where('user_id', '=', Auth::id())->first();

        if ($cart) {
            $cart->increment('quantity');
            $cart->update(['unit_price' => $request->unit_price]);

            return redirect('/cart');;
        }   

        Cart::create([
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'unit_price' => $request->unit_price,
            'description' => $request->description,
            'user_id' => Auth::id(),
        ]);

        return redirect('/cart');
    }

    public function update(Request $request) {
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer',
        ]);

        $cart = Cart::where('product_id', '=', $request->product_id)->where('user_id', '=', Auth::id())->firstOrFail();

        $this->authorize('update', $cart);

        if($request->quantity == 0 ) {
            $this->authorize('delete', $cart);
            $cart->delete();
            return redirect('/cart');
        }

        $cart->update(['quantity' => $request->quantity]);

        return redirect('/cart');
    }

    public function delete(Request $request) {
        $request->validate(['product_id' => 'required|integer']);

        $cart = Cart::where('product_id', '=', $request->product_id)->where('user_id', '=', Auth::id())->firstOrFail();

        $this->authorize('delete', $cart);
        $cart->delete();

        return redirect('/cart');
    }
}
