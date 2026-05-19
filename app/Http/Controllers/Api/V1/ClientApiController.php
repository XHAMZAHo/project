<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Invoice;
use App\Models\Project;
use Illuminate\Http\Request;

class ClientApiController extends Controller
{
    public function me(Request $request)
    {
        return response()->json([
            'user' => $request->user()->loadCount(['projects', 'invoices', 'receivedMessages as unread_messages_count' => fn($q) => $q->unread()]),
        ]);
    }

    public function projects(Request $request)
    {
        $projects = Project::where('user_id', $request->user()->id)
            ->with('technologies')
            ->latest()
            ->paginate(15);
            
        return response()->json($projects);
    }

    public function invoices(Request $request)
    {
        $invoices = Invoice::where('user_id', $request->user()->id)
            ->with('items')
            ->latest()
            ->paginate(15);
            
        return response()->json($invoices);
    }
}
