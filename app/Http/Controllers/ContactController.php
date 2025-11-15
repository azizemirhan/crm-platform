<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class ContactController extends Controller
{
    /**
     * Display a listing of contacts.
     */
    public function index()
    {
        return view('contacts.index');
    }

    /**
     * Show the form for creating a new contact.
     */
    public function create()
    {
        return view('contacts.create');
    }

    /**
     * Display the specified contact.
     */
    public function show(Contact $contact)
    {
        return view('contacts.show', [
            'contact' => $contact
        ]);
    }

    /**
     * Show the form for editing the specified contact.
     */
    public function edit(Contact $contact)
    {
        return view('contacts.edit', [
            'contact' => $contact
        ]);
    }

    /**
     * Remove the specified contact from storage.
     */
    public function destroy(Contact $contact)
    {
        $contact->delete();

        return Redirect::route('contacts.index')
            ->with('success', 'Kişi başarıyla silindi.');
    }

    /**
     * Add a note to the contact.
     */
    public function addNote(Request $request, Contact $contact)
    {
        // Will be implemented in activity/notes feature
        return Redirect::back()
            ->with('success', 'Not eklendi.');
    }

    /**
     * Add an activity to the contact.
     */
    public function addActivity(Request $request, Contact $contact)
    {
        // Will be implemented in activity feature
        return Redirect::back()
            ->with('success', 'Aktivite eklendi.');
    }

    /**
     * Attach a tag to the contact.
     */
    public function attachTag(Request $request, Contact $contact)
    {
        // Will be implemented in tags feature
        return Redirect::back()
            ->with('success', 'Etiket eklendi.');
    }

    /**
     * Detach a tag from the contact.
     */
    public function detachTag(Contact $contact, $tag)
    {
        // Will be implemented in tags feature
        return Redirect::back()
            ->with('success', 'Etiket kaldırıldı.');
    }
}
