<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;
use App\Models\Order;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sigHeader = $request->header('Stripe-Signature');
        $secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent($payload, $sigHeader, $secret);
        } catch (\Throwable $e) {
            Log::warning('Stripe webhook failed verification: '.$e->getMessage());
            return response('Invalid signature', 400);
        }

        switch ($event->type) {
            case 'payment_intent.succeeded':
                $pi = $event->data->object;
                $this->markOrderPaidByPaymentIntent($pi);
                break;

            case 'payment_intent.payment_failed':
                $pi = $event->data->object;
                $this->markOrderFailedByPaymentIntent($pi);
                break;
        }

        return response('ok');
    }

    protected function markOrderPaidByPaymentIntent($pi)
    {
        $orderId = $pi->metadata->order_id ?? null;
        if (! $orderId) return;

        $order = Order::find($orderId);
        if (! $order) return;

        $order->update(['status' => 'paid']);

        // TODO: dispatch jobs for email/fulfillment
    }

    protected function markOrderFailedByPaymentIntent($pi)
    {
        $orderId = $pi->metadata->order_id ?? null;
        if (! $orderId) return;

        $order = Order::find($orderId);
        if (! $order) return;

        $order->update(['status' => 'failed']);
    }
}
