<?php

namespace App\Livewire\Emails;

use App\Models\Email;
use App\Models\EmailTemplate;
use Livewire\Component;
use Livewire\WithFileUploads;

class EmailCompose extends Component
{
    use WithFileUploads;

    public $to = [];
    public $cc = [];
    public $bcc = [];
    public $subject = '';
    public $body = '';
    public $template_id = '';
    public $attachments = [];

    // For adding recipients
    public $newRecipient = '';
    public $recipientType = 'to'; // to, cc, bcc

    protected $rules = [
        'to' => 'required|array|min:1',
        'to.*.email' => 'required|email',
        'subject' => 'required|string|max:255',
        'body' => 'required|string',
    ];

    /**
     * Add recipient
     */
    public function addRecipient()
    {
        if (filter_var($this->newRecipient, FILTER_VALIDATE_EMAIL)) {
            $recipient = [
                'email' => $this->newRecipient,
                'name' => '',
            ];

            if ($this->recipientType === 'to') {
                $this->to[] = $recipient;
            } elseif ($this->recipientType === 'cc') {
                $this->cc[] = $recipient;
            } else {
                $this->bcc[] = $recipient;
            }

            $this->newRecipient = '';
        } else {
            session()->flash('error', 'Invalid email address');
        }
    }

    /**
     * Remove recipient
     */
    public function removeRecipient($type, $index)
    {
        if ($type === 'to') {
            unset($this->to[$index]);
            $this->to = array_values($this->to);
        } elseif ($type === 'cc') {
            unset($this->cc[$index]);
            $this->cc = array_values($this->cc);
        } else {
            unset($this->bcc[$index]);
            $this->bcc = array_values($this->bcc);
        }
    }

    /**
     * Load template
     */
    public function loadTemplate()
    {
        if ($this->template_id) {
            $template = EmailTemplate::find($this->template_id);
            if ($template) {
                $rendered = $template->render([
                    'user_name' => auth()->user()->name,
                    'team_name' => auth()->user()->team->name,
                ]);

                $this->subject = $rendered['subject'];
                $this->body = $rendered['body'];

                $template->incrementUsage();
            }
        }
    }

    /**
     * Send email
     */
    public function send()
    {
        $this->validate();

        $email = Email::create([
            'team_id' => auth()->user()->team_id,
            'user_id' => auth()->id(),
            'type' => 'sent',
            'subject' => $this->subject,
            'body_html' => $this->body,
            'from_email' => auth()->user()->email,
            'from_name' => auth()->user()->name,
            'to' => $this->to,
            'cc' => !empty($this->cc) ? $this->cc : null,
            'bcc' => !empty($this->bcc) ? $this->bcc : null,
            'sent_at' => now(),
        ]);

        // TODO: Integrate with email provider (SMTP/API)

        session()->flash('success', 'Email sent successfully!');

        return redirect()->route('emails.index', ['folder' => 'sent']);
    }

    /**
     * Save as draft
     */
    public function saveDraft()
    {
        Email::create([
            'team_id' => auth()->user()->team_id,
            'user_id' => auth()->id(),
            'type' => 'draft',
            'subject' => $this->subject ?? 'Untitled',
            'body_html' => $this->body,
            'from_email' => auth()->user()->email,
            'from_name' => auth()->user()->name,
            'to' => $this->to,
            'cc' => !empty($this->cc) ? $this->cc : null,
            'bcc' => !empty($this->bcc) ? $this->bcc : null,
        ]);

        session()->flash('success', 'Draft saved successfully!');

        return redirect()->route('emails.index');
    }

    public function render()
    {
        $templates = EmailTemplate::where('team_id', auth()->user()->team_id)
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('livewire.emails.email-compose', [
            'templates' => $templates,
        ]);
    }
}
