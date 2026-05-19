<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Message;
use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClientServiceController extends Controller
{
    private $servicePricing = [
        'web-development' => [
            'name' => 'Web Development',
            'price' => 1200.00,
            'description' => 'Complete website development service.'
        ],
        'ui-ux-design' => [
            'name' => 'UI/UX Design',
            'price' => 800.00,
            'description' => 'Professional user interface and experience design.'
        ],
        'system-development' => [
            'name' => 'System Development',
            'price' => 2500.00,
            'description' => 'Custom software and system architecture development.'
        ]
    ];

    public function order(string $service)
    {
        if (!array_key_exists($service, $this->servicePricing)) {
            abort(404);
        }

        $user = auth()->user();
        $serviceData = $this->servicePricing[$service];

        // 1. Create a Project
        $project = Project::create([
            'title' => $serviceData['name'] . ' for ' . $user->name,
            'description' => 'Automated order for ' . $serviceData['name'] . '.',
            'status' => 'pending',
            'user_id' => $user->id,
        ]);

        // 2. Create an Invoice
        $invoice = Invoice::create([
            'invoice_number' => 'INV-' . strtoupper(Str::random(6)),
            'user_id' => $user->id,
            'client_name' => $user->name,
            'client_email' => $user->email,
            'client_phone' => $user->phone ?? 'N/A',
            'issue_date' => now(),
            'due_date' => now()->addDays(7),
            'status' => 'pending',
            'subtotal' => $serviceData['price'],
            'tax_rate' => 0, // Assume 0 tax for now
            'tax_amount' => 0,
            'total' => $serviceData['price'],
            'currency' => 'USD',
            'currency_symbol' => '$',
            'notes' => 'Generated automatically for service order.',
            'pay_token' => Str::random(64),
        ]);

        InvoiceItem::create([
            'invoice_id' => $invoice->id,
            'description' => $serviceData['description'],
            'quantity' => 1,
            'unit_price' => $serviceData['price'],
            'subtotal' => $serviceData['price'],
        ]);

        // 3. Create Automated Message
        $admin = User::where('is_admin', true)->orWhere('role', 'admin')->first();
        
        if ($admin) {
            Message::create([
                'sender_id' => $admin->id,
                'receiver_id' => $user->id,
                'project_id' => $project->id,
                'body' => "مرحباً بك! طلبك لخدمة ({$serviceData['name']}) قيد الانتظار. يرجى إتمام عملية الدفع للفاتورة رقم {$invoice->invoice_number} للبدء في التنفيذ.",
                'is_read' => false,
            ]);
        }

        // 4. Redirect to Payment (which will then go to messages or dashboard)
        return redirect()->route('client.invoices.pay', $invoice)
            ->with('success', 'Order created successfully. Please complete the payment to start.');
    }
}
