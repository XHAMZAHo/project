<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function index(Request $request)
    {
        // Get all clients that have messaged the admin or vice versa
        $clients = User::where('role', 'client')
            ->where(function($q) {
                $q->whereHas('sentMessages', function($q) {
                    $q->where('receiver_id', auth()->id());
                })
                ->orWhereHas('receivedMessages', function($q) {
                    $q->where('sender_id', auth()->id());
                });
            })
            ->withCount(['sentMessages as unread_count' => function($q) {
                $q->where('receiver_id', auth()->id())->where('is_read', false);
            }])
            ->get();

        $selectedClient = null;
        $messages = collect();

        if ($request->has('client_id')) {
            $selectedClient = User::findOrFail($request->client_id);
        } elseif ($clients->isNotEmpty()) {
            $selectedClient = $clients->first();
        }

        if ($selectedClient) {
            $messages = Message::where(function($q) use ($selectedClient) {
                $q->where('sender_id', auth()->id())->where('receiver_id', $selectedClient->id);
            })->orWhere(function($q) use ($selectedClient) {
                $q->where('sender_id', $selectedClient->id)->where('receiver_id', auth()->id());
            })->orderBy('created_at', 'asc')->get();

            // Mark received messages as read
            Message::where('sender_id', $selectedClient->id)
                   ->where('receiver_id', auth()->id())
                   ->where('is_read', false)
                   ->update(['is_read' => true, 'read_at' => now()]);
        }

        return view('admin.messages.index', compact('clients', 'selectedClient', 'messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:users,id',
            'body'      => 'required|string|max:2000',
        ]);

        Message::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $request->client_id,
            'body'        => $request->body,
        ]);

        return back()->with('success', app()->getLocale() === 'ar' ? 'تم الإرسال بنجاح' : 'Message sent');
    }
}
