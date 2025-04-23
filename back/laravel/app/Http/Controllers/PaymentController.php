<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Charge;
use Exception;
use App\Models\Cliente;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Stripe\PaymentIntent;
use Stripe\Exception\ApiErrorException;

use Stripe\Checkout\Session;

class PaymentController extends Controller
{
    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(config('cashier.secret'));

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'product_data' => [
                        'name' => 'Producto de Prueba',
                    ],
                    'unit_amount' => 1000, // 10.00 EUR
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel'),
        ]);

        return response()->json(['id' => $session->id]);
    }

    public function processPayment(Request $request)
    {
        $request->validate([
            'payment_method_id' => 'required|string',
            'amount' => 'required|numeric|min:50', // Mínimo 50 centavos
            'currency' => 'required|string|size:3'
        ]);

        Stripe::setApiKey(config('cashier.secret'));

        try {
            // Crear un PaymentIntent
            $paymentIntent = PaymentIntent::create([
                'amount' => (int)$request->amount,
                'currency' => $request->currency,
                'payment_method' => $request->payment_method_id,
                'confirmation_method' => 'manual',
                'confirm' => true,
                // Evitar redireccionamientos
                'return_url' => route('payment.success'),
                'use_stripe_sdk' => false,
                'off_session' => true
            ]);

            // Verificar el estado del pago
            if ($paymentIntent->status === 'succeeded') {
                // Pago exitoso
                return response()->json([
                    'success' => true,
                    'payment_intent' => $paymentIntent->id
                ]);
            } elseif ($paymentIntent->status === 'requires_action') {
                // Esto no debería ocurrir con off_session y use_stripe_sdk en false
                return response()->json([
                    'success' => false,
                    'message' => 'Se requiere autenticación adicional'
                ], 400);
            } else {
                // Otro estado
                return response()->json([
                    'success' => false,
                    'message' => 'El pago no pudo ser procesado'
                ], 400);
            }
        } catch (ApiErrorException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    public function success(Request $request)
    {
        return view('payment.success');
    }

    public function cancel()
    {
        return view('payment.cancel');
    }

    public function createSetupIntent()
    {
        $user = Auth::user();
        if (!$user) {
            return response()->json(['error' => 'User not found'], 404);
        }

        Log::info('User: ' . $user);

        // Si el usuario no tiene un Stripe ID, lo crea
        if (!$user->hasStripeId()) {
            $user->createAsStripeCustomer();
        }

        // Creación del SetupIntent
        $intent = $user->createSetupIntent();

        // Devolver el client_secret del SetupIntent
        return response()->json([
            'client_secret' => $intent->client_secret
        ]);
    }

    public function addPaymentMethod(Request $request)
    {
        try {
            $user = Auth::user();

            if (!$user->hasStripeId()) {
                $user->createAsStripeCustomer();
            }

            $existingPaymentMethodsCount = $user->paymentMethods()->count();

            $user->addPaymentMethod($request->paymentMethod);

            $paymentMethods = $user->paymentMethods();

            if ($existingPaymentMethodsCount === 1 && $paymentMethods->isNotEmpty()) {
                $user->updateDefaultPaymentMethod($paymentMethods->first()->id);
            }

            $defaultPaymentMethod = $user->defaultPaymentMethod();

            return response()->json([
                'status' => 'success',
                'message' => 'Payment Method added successfully!',
                'user' => $user,
                'paymentMethods' => $paymentMethods,
                'defaultPaymentMethod' => $defaultPaymentMethod
            ]);

        } catch (\Exception $e) {
            \Log::error('Error adding payment method: ' . $e->getMessage());

            return response()->json(['status' => 'error', 'message' => 'Failed to add payment method'], 500);
        }
    }

    public function retrievePaymentMethod()
    {
        $user = Auth::user();

        $paymentMethods = $user->paymentMethods();
        $defaultPaymentMethod = $user->defaultPaymentMethod();

        return response()->json([
            'status' => 'success',
            'message' => 'Payment Method retrieved successfully!',
            'paymentMethods' => $paymentMethods,
            'defaultPaymentMethod' => $defaultPaymentMethod]);
    }

    public function setDefaultPaymentMethod(Request $request)
    {
        try {
            $user = Auth::user();

            $user->updateDefaultPaymentMethod($request->payment_method_id);

            $paymentMethods = $user->paymentMethods();
            $defaultPaymentMethod = $user->defaultPaymentMethod();


            return response()->json([
                'status' => 'success',
                'message' => 'Default payment method updated successfully',
                'paymentMethods' => $paymentMethods,
                'defaultPaymentMethod' => $defaultPaymentMethod
            ]);

        } catch (\Exception $e) {
            \Log::error('Error setting default payment method: ' . $e->getMessage());
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to set default payment method'
            ], 500);
        }

    }

    public function purchase(Request $request)
    {
        $data = $request->validate([
            'paymentMethod' => 'required',
            'price'=>'required',
            'products' => 'required',
            'shippingAddress' => 'required',
            'billingAddress' => 'required'
        ],
        [
            'paymentMethod.required'=>'Payment Method is required.',
            'price.required'=>'Price is required.',
            'products.required'=>'Products is required.',
            'shippingAddress.required'=>'Shipping Address is required.',
            'billingAddress.required'=>'Billing Address is required.'
        ]);

        $user = Auth::user();

        $priceInCents = (int) round($request->input('price') * 100);
        $paymentMethod = $request->input('paymentMethod');

        try {
            $charge = $user->charge($priceInCents, $paymentMethod['id'], [
                'return_url' => route('home'),
            ]);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => $e->getMessage()], 500);
        }
//        return $data['products'];
        $order = new Comanda();
        $order->idUser = $user->id;
        $order->idBillingAddress = $data['billingAddress']['id'];
        $order->idShippingAddress = $data['shippingAddress']['id'];
        $order->status = "pending";
        $order->price = $data['price'];
        $order->save();

        foreach ($data['products'] as $productInCart){
            $orderProducts = new ArticuloComanda();
            $orderProducts->idOrder = $order->id;
            $orderProducts->idProduct = $productInCart['id'];
            $orderProducts->num_product = $productInCart['num_product'];
            $orderProducts->save();

            $product = Producte::findOrFail($productInCart['id']);
            $product->stock = $product->stock - $productInCart['num_product'];
            $product->save();
        }

        $invoice = new Invoice();
        $invoice->idOrder = $order->id;
        $invoice->idUser = $user->id;
        $invoice->price = $data['price'];
        $invoice->save();


        Mail::to($user->email)->send(new FinishBuyMailMailer($user, route('invoice.index', ['order_id'=>$order->id])));

        return response()->json([
            'status' => 'success',
            'message' => 'Payment Method purchased successfully!',
            'charge' => $charge
        ]);

    }

    public function delete(Request $request)
    {
        $data = $request->validate([
            'paymentMethod' => 'required',
        ],
        [
            'paymentMethod.required'=>'Payment Method is required.',
        ]);

        $user = Auth::user();

        $paymentMethod = $user->findPaymentMethod($data['paymentMethod']['id']);
        $paymentMethod->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Payment Method deleted successfully!'
        ]);
    }
}
