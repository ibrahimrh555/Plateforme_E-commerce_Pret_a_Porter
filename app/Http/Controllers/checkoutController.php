<?php

namespace App\Http\Controllers;
//composer require srmklive/paypal:~3.0*****php artisan vendor:publish --provider "Srmklive\PayPal\Providers\PayPalServiceProvider"


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Request as GlobalRequest;
use Srmklive\PayPal\Facades\PayPal;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Commande;
use App\Models\CommandeArticle;


class checkoutController extends Controller
{
    public function checkout(Request $request,$idComm)
    {
        $commande = Commande::with('articles')->findOrFail($idComm);

        return view('checkout.checkout', compact('commande'));
    }
    public function Paypal(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();
        // $provider->setAccessToken($paypalToken);

        $response = $provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.success'),
                "cancel_url" => route('paypal.cancel')
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => ($request->amount)/10
                    ]
                ]
            ]
        ]);
        // dd($response);
        if (isset($response['id']) && $response['id'] != null) {
            foreach ($response['links'] as $link) {
                if ($link['rel'] === 'approve') {
                    return redirect()->away($link['href']);
                }
            }
        } else {
            return redirect()->route('paypal.cancel');
        }
        // return redirect($order['links'][1]['href']);
    }
    public function PaypalSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $paypalToken = $provider->getAccessToken();

        $response = $provider->capturePaymentOrder($request->token);
        // dd($response);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            //insert in database

            return redirect()->route('accueil')->with('success', 'Payment completed successfully!');
        } else {
            return redirect()->route('paypal.cancel');
        }
        // return response()->json($result);
    }
    public function PaypalCancel()
    {
        return redirect()->route('accueil')->with('error', 'paiment est annulé.');
    }
    public function Stripe(Request $request)
    {
        $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));

        $response = $stripe->checkout->sessions->create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'mad',
                    'product_data' => [
                        'name' => 'Test Product',
                    ],
                    'unit_amount' => $request->amount * 100,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('stripe.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('stripe.cancel'),
        ]);

        // dd($response);
        if (isset($response->id) && $response->id != '') {
            return redirect($response->url);
        } else {
            return redirect()->route('stripe.cancel');
        }
    }

    public function StripeSuccess(Request $request)
    {
        if (isset($request->session_id)) {
            $stripe = new \Stripe\StripeClient(config('stripe.stripe_sk'));
            $response = $stripe->checkout->sessions->retrieve($request->session_id);

            return "payment successful";
        } else {
            return redirect()->route('stripe.cancel');
        }
    }

    public function StripeCancel()
    {
        return "payment not successful";
    }
}
