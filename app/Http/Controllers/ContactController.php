<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function index()
    {
        $contacts = Contact::with(['socialLinks', 'additionalContacts'])->get();
        return view('contact.index', compact('contacts'));
    }

    public function create()
    {
        return view('contact.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'organization_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'social_links' => 'nullable|array',
            'social_links.*.platform' => 'nullable|string|max:50',
            'social_links.*.url' => 'nullable|url|max:255',
            'additional_contacts' => 'nullable|array',
            'additional_contacts.*.type' => 'nullable|string|max:50',
            'additional_contacts.*.detail' => 'nullable|string|max:255',
        ]);

        $contact = Contact::create([
            'organization_name' => $data['organization_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'] ?? null,
        ]);

        if (!empty($data['social_links'])) {
            $contact->socialLinks()->createMany(array_filter($data['social_links'], fn($link) => !empty($link['platform']) || !empty($link['url'])));
        }

        if (!empty($data['additional_contacts'])) {
            $contact->additionalContacts()->createMany(array_filter($data['additional_contacts'], fn($contact) => !empty($contact['type']) || !empty($contact['detail'])));
        }

        return redirect()->route('contact.index')->with('success', 'Contact information added successfully.');
    }

    public function edit(Contact $contact)
    {
        $contact->load(['socialLinks', 'additionalContacts']);
        return view('contact.edit', compact('contact'));
    }

    public function update(Request $request, Contact $contact)
    {
        $data = $request->validate([
            'organization_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'nullable|string|max:255',
            'social_links' => 'nullable|array',
            'social_links.*.platform' => 'nullable|string|max:50',
            'social_links.*.url' => 'nullable|url|max:255',
            'additional_contacts' => 'nullable|array',
            'additional_contacts.*.type' => 'nullable|string|max:50',
            'additional_contacts.*.detail' => 'nullable|string|max:255',
        ]);

        $contact->update([
            'organization_name' => $data['organization_name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'address' => $data['address'] ?? null,
        ]);

        if (!empty($data['social_links'])) {
            $contact->socialLinks()->delete();
            $contact->socialLinks()->createMany(array_filter($data['social_links'], fn($link) => !empty($link['platform']) || !empty($link['url'])));
        }

        if (!empty($data['additional_contacts'])) {
            $contact->additionalContacts()->delete();
            $contact->additionalContacts()->createMany(array_filter($data['additional_contacts'], fn($contact) => !empty($contact['type']) || !empty($contact['detail'])));
        }

        return redirect()->route('contact.index')->with('success', 'Contact information updated successfully.');
    }

    public function destroy(Contact $contact)
    {
        $contact->socialLinks()->delete();
        $contact->additionalContacts()->delete();
        $contact->delete();

        return redirect()->route('contact.index')->with('danger', 'Contact information deleted successfully.');
    }

    public function display()
    {
        $contacts = Contact::with(['socialLinks', 'additionalContacts'])->get();
        return view('contact.display', compact('contacts'));
    }
}
