<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use Mccarlosen\LaravelMpdf\Facades\LaravelMpdf as PDF;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Invoice::with('items')->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('client_name', 'like', '%' . $request->search . '%')
                  ->orWhere('invoice_number', 'like', '%' . $request->search . '%')
                  ->orWhere('client_email', 'like', '%' . $request->search . '%');
            });
        }

        $invoices = $query->paginate(15);

        $stats = [
            'total'   => Invoice::count(),
            'paid'    => Invoice::where('status', 'paid')->count(),
            'pending' => Invoice::where('status', 'pending')->count(),
            'revenue' => Invoice::where('status', 'paid')->sum('total'),
        ];

        return view('admin.invoices.index', compact('invoices', 'stats'));
    }

    public function create(Request $request)
    {
        $clients   = User::where('is_admin', false)->get();
        $prefilled = $request->only(['client_name', 'client_email']);
        $number    = Invoice::nextNumber();
        return view('admin.invoices.create', compact('clients', 'prefilled', 'number'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_name'      => 'required|string|max:255',
            'client_email'     => 'nullable|email',
            'client_phone'     => 'nullable|string|max:30',
            'currency'         => 'required|in:SAR,USD,EUR,AED',
            'tax_rate'         => 'required|numeric|min:0|max:100',
            'due_date'         => 'nullable|date',
            'notes'            => 'nullable|string',
            'items'            => 'required|array|min:1',
            'items.*.description' => 'required|string',
            'items.*.quantity'    => 'required|integer|min:1',
            'items.*.unit_price'  => 'required|numeric|min:0',
        ]);

        $invoice = Invoice::create([
            'invoice_number' => Invoice::nextNumber(),
            'client_name'    => $request->client_name,
            'client_email'   => $request->client_email,
            'client_phone'   => $request->client_phone,
            'currency'       => $request->currency,
            'tax_rate'       => $request->tax_rate,
            'due_date'       => $request->due_date,
            'notes'          => $request->notes,
            'status'         => 'pending',
            'subtotal'       => 0,
            'tax_amount'     => 0,
            'total'          => 0,
        ]);

        foreach ($request->items as $item) {
            $invoice->items()->create([
                'description' => $item['description'],
                'quantity'    => $item['quantity'],
                'unit_price'  => $item['unit_price'],
                'subtotal'    => $item['quantity'] * $item['unit_price'],
            ]);
        }

        $invoice->recalculate();

        return redirect()->route('admin.invoices.index')
            ->with('success', 'Invoice ' . $invoice->invoice_number . ' created successfully.');
    }

    public function show(Invoice $invoice)
    {
        $invoice->load('items');
        return view('admin.invoices.show', compact('invoice'));
    }

    public function updateStatus(Request $request, Invoice $invoice)
    {
        $request->validate(['status' => 'required|in:pending,paid,overdue,cancelled']);
        
        $data = ['status' => $request->status];
        if ($request->status === 'paid' && !$invoice->paid_at) {
            $data['paid_at'] = now();
        } elseif ($request->status !== 'paid') {
            $data['paid_at'] = null;
        }

        $invoice->update($data);
        return back()->with('success', 'Invoice status updated.');
    }

    public function destroy(Invoice $invoice)
    {
        $invoice->items()->delete();
        $invoice->delete();
        return redirect()->route('admin.invoices.index')
            ->with('success', 'Invoice deleted.');
    }

    public function pdf(Invoice $invoice)
    {
        $invoice->load('items');
        $pdf = PDF::loadView('admin.invoices.pdf', compact('invoice'), [], [
            'mode'             => 'utf-8',
            'format'           => 'A4',
            'directionality'   => 'rtl',
        ]);
        return $pdf->stream($invoice->invoice_number . '.pdf');
    }
}
