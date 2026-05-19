<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;

class ClientMessageController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Get admin to chat with
        $admin = User::where('is_admin', true)->orWhere('role', 'admin')->first();

        $messages = $admin
            ? Message::thread($user->id, $admin->id)->with(['sender', 'receiver'])->get()
            : collect();

        // Mark all received as read
        Message::where('receiver_id', $user->id)->where('is_read', false)->update([
            'is_read' => true, 'read_at' => now()
        ]);

        return view('client.messages.index', compact('messages', 'admin'));
    }

    public function store(Request $request)
    {
        $request->validate(['body' => 'required|string|max:2000']);

        $admin = User::where('is_admin', true)->orWhere('role', 'admin')->first();

        if (!$admin) {
            return back()->with('error', 'No admin available.');
        }

        Message::create([
            'sender_id'   => auth()->id(),
            'receiver_id' => $admin->id,
            'body'        => $request->body,
            'project_id'  => $request->project_id,
        ]);

        return back()->with('success', 'Message sent.');
    }
}
