<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Models\Contact;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request)
    {
        Contact::create($request->validated());

        return back()->with('success', 'Thank you! Your message has been sent successfully. We will get back to you soon.');
    }

    // Admin methods
    public function index()
    {
        $contacts = Contact::latest()->paginate(15);
        $unreadCount = Contact::unread()->count();

        return view('admin.contacts.index', compact('contacts', 'unreadCount'));
    }

    public function show(Contact $contact)
    {
        $contact->markAsRead();

        return view('admin.contacts.show', compact('contact'));
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();

        return redirect()->route('admin.contacts.index')
            ->with('success', 'Contact message deleted successfully.');
    }
}
