<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Omnipay\Omnipay;

class PaymentController extends Controller
{
    protected $gateway;

    public function __construct()
    {
        // Configuration de la passerelle PayPal via Omnipay
        $this->gateway = Omnipay::create('PayPal_Rest');
        $this->gateway->setClientId(env('PAYPAL_CLIENT_ID'));
        $this->gateway->setSecret(env('PAYPAL_CLIENT_SECRET'));
        $this->gateway->setTestMode('true'); // Définir sur `true` pour le mode sandbox
    }

    public function pay(Request $request)
    {
        try {
            // Créer la demande de paiement
            $purchaseData = [
                'amount' => $request->amount, // Montant à payer
                'currency' => 'USD', // Devise
                'returnUrl' => route('payment.success'),
                'cancelUrl' => route('payment.cancel'),
            ];

            // Initiation de la transaction
            $response = $this->gateway->purchase($purchaseData)->send();

            // Vérification de la réponse
            if ($response->isRedirect()) {
                // Redirige l'utilisateur vers PayPal
                return $response->redirect();
            } else {
                // Gérer l'erreur
                return $response->getMessage();
            }
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()]);
        }
    }

    public function success(Request $request)
    {
        // Logique après un paiement réussi
        return response()->json(['message' => 'Paiement réussi.']);
    }

    public function cancel(Request $request)
    {
        // Logique lorsque le paiement est annulé
        return response()->json(['message' => 'Paiement annulé.']);
    }
}
