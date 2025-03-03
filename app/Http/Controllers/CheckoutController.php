<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function index()
    {
        // Lấy danh sách sản phẩm trong giỏ hàng
        $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();

        // Tính tổng giá trị giỏ hàng
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

        // Trả về view checkout với thông tin cần thiết
        return view('users.checkout', compact('cartItems', 'total'));
    }

    // Nếu bạn muốn thêm phương thức thanh toán khác ngoài PayPal, có thể giữ lại hàm này
    public function processCheckout(Request $request)
    {
        $request->validate([
            'address' => 'required|string|max:255',
        ]);

        DB::beginTransaction();
        try {
            $cartItems = Cart::with('product')->where('user_id', Auth::id())->get();
            $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);

            if ($total <= 0) {
                return redirect()->back()->with('error', 'Giỏ hàng trống hoặc không hợp lệ.');
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'total' => $total,
                'status' => 'pending',
                'address' => $request->address,
            ]);

            foreach ($cartItems as $item) {
                if ($item->product->stock < $item->quantity) {
                    throw new \Exception("Sản phẩm '{$item->product->name}' không đủ hàng trong kho.");
                }

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $item->product_id,
                    'quantity' => $item->quantity,
                    'price' => $item->product->price,
                ]);

                $item->product->decrement('stock', $item->quantity);
            }

            Cart::where('user_id', Auth::id())->delete();
            DB::commit();

            return redirect()->route('cart.index')->with('success', 'Đơn hàng của bạn đã được tạo thành công!');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
