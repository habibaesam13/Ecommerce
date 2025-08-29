<?php
namespace App\Services;

use App\Models\Order;
use Stripe\StripeClient;

class PaymentService
{
    private StripeClient $stripe;

    public function __construct()
    {
        $this->stripe = new StripeClient(config('services.stripe.secret'));
    }

    /**
     * Create a PaymentIntent for an Order.
     * Returns the Stripe PaymentIntent object.
     */
    public function createPaymentIntentForOrder(Order $order)
    {
        // amount already stored in minor units (piasters)
        $amount = (int)$order->amount;
        $currency = strtolower($order->currency ?? config('services.stripe.currency', 'EGP'));

        $pi = $this->stripe->paymentIntents->create([
            'amount'   => $amount,
            'currency' => $currency,
            'metadata' => [
                'order_id'  => (string)$order->id,
                'reference' => (string)$order->reference,
                'user_id'   => (string)$order->user_id,
            ],
            'automatic_payment_methods' => ['enabled' => true], // helps with local cards and SCA
        ], [
            'idempotency_key' => 'create_pi_' . $order->reference,
        ]);

        return $pi;
    }

    public function retrievePaymentIntent(string $id)
    {
        return $this->stripe->paymentIntents->retrieve($id);
    }
}
