<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PayPal\Api\Amount;
use PayPal\Api\Payment;
use PayPal\Api\PaymentExecution;
use PayPal\Api\Payer;
use PayPal\Api\Transaction;
use PayPal\Api\RedirectUrls;
use PayPal\Rest\ApiContext;
use PayPal\Auth\OAuthTokenCredential;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class PaymentController extends Controller
{
    private $_apiContext;

    public function __construct()
    {
        $paypalConfig = config('paypal');
        $this->_apiContext = new ApiContext(
            new OAuthTokenCredential(
                $paypalConfig['client_id'],
                $paypalConfig['secret']
            )
        );
        $this->_apiContext->setConfig($paypalConfig['settings']);
    }

    public function payWithPaypal()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống.');
        }

        // Tính tổng tiền và chuyển đổi sang USD (giả sử 1 USD = 23000 VND)
        $total = $cartItems->sum(fn($item) => $item->product->price * $item->quantity);
        $totalUSD = number_format($total / 23000, 2, '.', '');

        try {
            $payer = new Payer();
            $payer->setPaymentMethod('paypal');

            $amount = new Amount();
            $amount->setCurrency('USD')
                ->setTotal($totalUSD);

            $transaction = new Transaction();
            $transaction->setAmount($amount)
                ->setDescription('Thanh toán đơn hàng từ ' . Auth::user()->name)
                ->setInvoiceNumber(uniqid());

            $redirectUrls = new RedirectUrls();
            $redirectUrls->setReturnUrl(route('payment.success'))
                ->setCancelUrl(route('payment.cancel'));

            $payment = new Payment();
            $payment->setIntent('sale')
                ->setPayer($payer)
                ->setTransactions(array($transaction))
                ->setRedirectUrls($redirectUrls);

            $payment->create($this->_apiContext);

            // Lưu payment ID và cart items vào session
            Session::put('paypal_payment_id', $payment->getId());
            Session::put('cart_items', $cartItems);

            return Redirect::away($payment->getApprovalLink());
        } catch (\Exception $ex) {
            Log::error('PayPal Payment Error: ' . $ex->getMessage());
            return redirect()->route('cart.index')
                ->with('error', 'Có lỗi xảy ra khi xử lý thanh toán: ' . $ex->getMessage());
        }
    }

    public function success(Request $request)
    {
        // Kiểm tra tham số bắt buộc
        if (!$request->has('PayerID') || !$request->has('token')) {
            Log::error('PayPal Success: Missing PayerID or token');
            return redirect()->route('cart.index')->with('error', 'Thiếu thông tin thanh toán.');
        }

        $paymentId = Session::get('paypal_payment_id');
        $payerId = $request->input('PayerID');

        if (empty($paymentId)) {
            Log::error('PayPal Success: Payment ID not found in session');
            return redirect()->route('cart.index')->with('error', 'Không tìm thấy thông tin thanh toán.');
        }

        try {
            // Lấy thông tin thanh toán từ PayPal
            $payment = Payment::get($paymentId, $this->_apiContext);
            $execution = new PaymentExecution();
            $execution->setPayerId($payerId);

            // Thực hiện thanh toán
            $result = $payment->execute($execution, $this->_apiContext);

            if ($result->getState() === 'approved') {
                // Lấy sản phẩm từ session
                $cartItems = Session::get('cart_items');
                if (!$cartItems || $cartItems->isEmpty()) {
                    return redirect()->route('cart.index')->with('error', 'Giỏ hàng trống hoặc thông tin không hợp lệ.');
                }

                // Tạo bản ghi đơn hàng
                $order = new Order();
                $order->user_id = Auth::id();
                $order->status = 'completed';
                $order->total = $result->getTransactions()[0]->getAmount()->getTotal(); // Lưu tổng tiền từ PayPal
                $order->save();

                // Thêm chi tiết sản phẩm vào đơn hàng
                foreach ($cartItems as $cartItem) {
                    $product = $cartItem->product;

                    if ($product->stock >= $cartItem->quantity) {
                        // Cập nhật số lượng tồn kho
                        $product->stock -= $cartItem->quantity;
                        $product->save();

                        // Lưu thông tin sản phẩm trong OrderItem
                        $order->items()->create([
                            'product_id' => $product->id,
                            'quantity' => $cartItem->quantity,
                            'price' => $product->price,
                        ]);
                    } else {
                        Log::error("Sản phẩm {$product->name} không đủ hàng trong kho.");
                    }
                }

                // Xóa giỏ hàng và session
                Cart::where('user_id', Auth::id())->delete();
                Session::forget(['paypal_payment_id', 'cart_items']);

                return view('users.success', [
                    'paymentDetails' => $result,
                    'transactionId' => $result->getTransactions()[0]->getInvoiceNumber()
                ]);
            }

            throw new \Exception('Thanh toán chưa được phê duyệt.');
        } catch (\Exception $ex) {
            Log::error('PayPal Success Error: ' . $ex->getMessage());
            return redirect()->route('cart.index')->with('error', 'Có lỗi xảy ra khi xử lý thanh toán: ' . $ex->getMessage());
        }
    }

    public function cancel()
    {
        Session::forget(['paypal_payment_id', 'cart_items']);
        return view('users.cancel', ['message' => 'Bạn đã hủy thanh toán.']);
    }
}
