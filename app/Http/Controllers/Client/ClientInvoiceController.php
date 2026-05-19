<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClientInvoiceController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $query = Invoice::with('items');

        if ($user->isClient()) {
            $query->where('user_id', $user->id);
        }

        $invoices = $query->latest()->paginate(10);

        return view('client.invoices.index', compact('invoices'));
    }

    public function show(Invoice $invoice)
    {
        $this->authorizeClientAccess($invoice);

        $invoice->load('items');

        return view('client.invoices.show', compact('invoice'));
    }

    public function download(Invoice $invoice)
    {
        $this->authorizeClientAccess($invoice);
        // Redirect to admin PDF route (reuse existing PDF generation)
        return redirect()->route('admin.invoices.pdf', $invoice);
    }

    public function pay(Invoice $invoice)
    {
        $this->authorizeClientAccess($invoice);

        if ($invoice->status === 'paid') {
            return redirect()->route('client.invoices.show', $invoice)
                ->with('info', 'This invoice is already paid.');
        }

        // Generate a pay token for public payment link
        if (!$invoice->pay_token) {
            $invoice->update(['pay_token' => Str::random(64)]);
        }

        return view('client.invoices.pay', compact('invoice'));
    }

    private function authorizeClientAccess(Invoice $invoice): void
    {
        $user = auth()->user();
        if ($user->isClient() && $invoice->user_id !== $user->id) {
            abort(403);
        }
    }
}
