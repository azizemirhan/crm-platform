<?php

namespace App\Http\Controllers;

use App\Models\Email;
use App\Models\EmailTemplate;
use Illuminate\Http\Request;

class EmailController extends Controller
{
    public function index(Request $request)
    {
        $folder = $request->get('folder', 'inbox');
        
        return view('emails.index', compact('folder'));
    }

    public function show(Email $email)
    {
        $email->markAsRead();
        return view('emails.show', compact('email'));
    }

    public function compose()
    {
        $templates = EmailTemplate::where('is_active', true)->get();
        return view('emails.compose', compact('templates'));
    }

    public function send(Request $request)
    {
        $validated = $request->validate([
            'to' => 'required|array',
            'to.*.email' => 'required|email',
            'subject' => 'required|string|max:255',
            'body' => 'required|string',
            'cc' => 'nullable|array',
            'bcc' => 'nullable|array',
        ]);

        $email = Email::create([
            'team_id' => auth()->user()->team_id,
            'user_id' => auth()->id(),
            'type' => 'sent',
            'subject' => $validated['subject'],
            'body_html' => $validated['body'],
            'from_email' => auth()->user()->email,
            'from_name' => auth()->user()->name,
            'to' => $validated['to'],
            'cc' => $validated['cc'] ?? null,
            'bcc' => $validated['bcc'] ?? null,
            'sent_at' => now(),
        ]);

        // TODO: Integrate with email provider (SMTP/API)

        return redirect()->route('emails.index', ['folder' => 'sent'])
            ->with('success', 'Email sent successfully!');
    }

    public function toggleStar(Email $email)
    {
        $email->toggleStar();
        return back()->with('success', 'Email ' . ($email->is_starred ? 'starred' : 'unstarred'));
    }

    public function archive(Email $email)
    {
        $email->archive();
        return back()->with('success', 'Email archived');
    }

    public function destroy(Email $email)
    {
        $email->delete();
        return back()->with('success', 'Email deleted');
    }

    // Templates
    public function templates()
    {
        return view('emails.templates');
    }
}
