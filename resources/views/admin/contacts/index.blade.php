@extends('layouts.admin')

@section('title', 'Contact Messages')
@section('page_title', 'Contact Messages')

@section('content')
<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="p-6 border-b border-gray-100 flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-800">All Messages <span class="bg-blue-100 text-blue-600 px-2 py-0.5 rounded-full text-xs ml-2">{{ $unreadCount }} Unread</span></h2>
    </div>
    
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 text-gray-500 text-sm">
                    <th class="py-3 px-6 font-medium">Name</th>
                    <th class="py-3 px-6 font-medium">Subject</th>
                    <th class="py-3 px-6 font-medium">Date</th>
                    <th class="py-3 px-6 font-medium">Status</th>
                    <th class="py-3 px-6 font-medium text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($contacts as $contact)
                    <tr class="hover:bg-gray-50 {{ !$contact->is_read ? 'bg-blue-50/30' : '' }}">
                        <td class="py-4 px-6">
                            <div class="font-medium text-gray-800">{{ $contact->name }}</div>
                            <div class="text-sm text-gray-500">{{ $contact->email }}</div>
                        </td>
                        <td class="py-4 px-6 text-gray-600">{{ $contact->subject }}</td>
                        <td class="py-4 px-6 text-sm text-gray-500">{{ $contact->created_at->format('M d, Y h:i A') }}</td>
                        <td class="py-4 px-6">
                            @if($contact->is_read)
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-600">Read</span>
                            @else
                                <span class="px-2.5 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-600">Unread</span>
                            @endif
                        </td>
                        <td class="py-4 px-6 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.contacts.show', $contact) }}" class="text-blue-500 hover:bg-blue-50 p-2 rounded transition" title="View Message">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.contacts.destroy', $contact) }}" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to delete this message?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:bg-red-50 p-2 rounded transition" title="Delete Message">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-8 text-center text-gray-500">No contact messages found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div class="p-4 border-t border-gray-100">
        {{ $contacts->links() }}
    </div>
</div>
@endsection
