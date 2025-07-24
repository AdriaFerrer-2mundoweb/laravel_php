<?php

namespace App\Http\Controllers;

use App\Models\Orders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Stripe\StripeClient;
use Stripe\Webhook;
use Stripe\Exception\SignatureVerificationException;
use Stripe\Exception\UnexpectedValueException;

class OrderManager extends Controller
{
    function showCheckout()
    {
        return view('checkout');
    }

    function checkoutPost(Request $request)
    {
        $request->validate([
            'address' => 'required',
            'city' => 'required',
            'zip' => 'required',
            'country' => 'required',
            'phone' => 'required',
        ]);

        $cartItems = DB::table('cart')
            ->join(
                'products',
                'cart.product_id',
                '=',
                'products.id'
            )
            ->select(
                'cart.product_id',
                'cart.quantity',
                'products.price',
                'products.title',
            )
            ->where('cart.user_id', auth()->user()->id)
            ->groupBy(
                'cart.product_id',
                'cart.quantity',
                'products.price',
                'products.title',
            )
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.show')->with('error', 'Your cart is empty');
        }

        $productIds = [];
        $quantities = [];
        $totalPrice = 0;
        $lineItems = [];

        foreach ($cartItems as $cartItem) {
            $productIds[] = $cartItem->product_id;
            $quantities[] = $cartItem->quantity;
            $totalPrice += $cartItem->price * $cartItem->quantity;
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => $cartItem->title ?? 'Product',
                    ],
                    'unit_amount' => $cartItem->price * 100,
                ],
                'quantity' => $cartItem->quantity,
            ];
        }

        // Create a single order
        $order = new Orders();
        $order->user_id = auth()->user()->id;
        $order->address = $request->address;
        $order->city = $request->city;
        $order->zip = $request->zip;
        $order->country = $request->country;
        $order->phone = $request->phone;

        $order->total_price = $totalPrice;
        $order->product_id = json_encode($productIds);
        $order->quantity = json_encode($quantities);

        if ($order->save()) {
            DB::table('cart')->where('user_id', auth()->user()->id)->delete();
            $stripe = new StripeClient(config('app.STRIPE_SECRET_KEY'));
            $checkoutSession = $stripe->checkout->sessions->create([
                'success_url' => route('payment.success', ['order_id' => $order->id]),
                'cancel_url' => route('payment.error'),
                'payment_method_types' => ['card'],
                'line_items' => $lineItems,
                'mode' => 'payment',
                'customer_email' => auth()->user()->email,
                'metadata' => [
                    'order_id' => $order->id,
                ],
            ]);

            return redirect($checkoutSession->url);
        }
        return redirect()->route('cart.show')->with('error', 'Order creation failed');
    }

    function paymentSuccess()
    {
        return redirect()->route('home')->with('success', 'Payment successful');
    }

    function paymentError()
    {
        return redirect()->route('cart.show')->with('error', 'Payment failed');
    }

    function stripeWebhook(Request $request)
    {
        $endpointSecret = config('app.STRIPE_WEBHOOK_SECRET');
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $endpointSecret);
        } catch (UnexpectedValueException $e) {
            return response()->json(['error' => 'Invalid payload'], 400);
        } catch (SignatureVerificationException $e) {
            return response()->json(['error' => 'Invalid signature'], 400);
        }

        if ($event->type == 'checkout.session.completed') {
            $session = $event->data->object;
            $orderId = $session->metadata->order_id;
            $paymentId = $session->payment_intent;

            $order = Orders::find($orderId);
            if ($order) {
                $order->payment_id = $paymentId;
                $order->payment_status = 'completed';
                $order->save();
            }
        }

        return response()->json(['status' => 'success'], 200);
    }
}
