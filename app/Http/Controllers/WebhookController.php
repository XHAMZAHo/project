<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Stripe\Webhook;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        $payload = $request->getContent();
        $sig_header = $request->header('Stripe-Signature');
        $endpoint_secret = config('services.stripe.webhook_secret');

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            return response('Invalid payload', 400);
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            return response('Invalid signature', 400);
        }

        if ($event->type == 'checkout.session.completed') {
            $session = $event->data->object;
            
            if (isset($session->metadata->invoice_id)) {
                $invoice = Invoice::find($session->metadata->invoice_id);
                if ($invoice) {
                    $invoice->update([
                        'status' => 'paid',
                        'paid_at' => now(),
                        'stripe_payment_intent_id' => $session->payment_intent,
                        'payment_method' => 'card'
                    ]);
                    
                    // Dispatch PaymentReceived automated message
                    $admin = \App\Models\User::where('is_admin', true)->orWhere('role', 'admin')->first();
                    if ($admin) {
                        \App\Models\Message::create([
                            'sender_id' => $admin->id,
                            'receiver_id' => $invoice->user_id,
                            'body' => "شكراً لك! تم استلام الدفعة بنجاح للفاتورة رقم {$invoice->invoice_number}. سيتم البدء في طلبك قريباً.",
                            'is_read' => false,
                        ]);
                    }

                    Log::info("Invoice {$invoice->id} marked as paid via Stripe webhook.");
                }
            }
        }

        return response('Webhook handled', 200);
    }
}
