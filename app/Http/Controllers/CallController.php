<?php

namespace App\Http\Controllers;

use App\Models\Call;
use Illuminate\Http\Request;
use Twilio\Rest\Client;

class CallController extends Controller
{
    public function index()
    {
        return view('calls.index');
    }

    public function show(Call $call)
    {
        return view('calls.show', compact('call'));
    }

    public function initiate(Request $request)
    {
        $validated = $request->validate([
            'to_number' => 'required|string',
            'related_to_type' => 'nullable|string',
            'related_to_id' => 'nullable|integer',
        ]);

        $call = Call::create([
            'team_id' => auth()->user()->team_id,
            'user_id' => auth()->id(),
            'direction' => 'outbound',
            'from_number' => config('services.twilio.phone_number'),
            'to_number' => $validated['to_number'],
            'related_to_type' => $validated['related_to_type'] ?? null,
            'related_to_id' => $validated['related_to_id'] ?? null,
            'status' => 'queued',
        ]);

        // Initiate Twilio call
        try {
            $twilio = new Client(
                config('services.twilio.sid'),
                config('services.twilio.token')
            );

            $twilioCall = $twilio->calls->create(
                $validated['to_number'],
                config('services.twilio.phone_number'),
                [
                    'record' => true,
                    'statusCallback' => route('calls.webhook.status', $call),
                    'statusCallbackEvent' => ['initiated', 'ringing', 'answered', 'completed']
                ]
            );

            $call->update([
                'call_sid' => $twilioCall->sid,
                'status' => $twilioCall->status,
            ]);

            return response()->json([
                'success' => true,
                'call_id' => $call->id,
                'message' => 'Call initiated'
            ]);
        } catch (\Exception $e) {
            $call->update(['status' => 'failed']);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to initiate call: ' . $e->getMessage()
            ], 500);
        }
    }

    public function statusWebhook(Request $request, Call $call)
    {
        $call->update([
            'status' => $request->CallStatus,
            'duration' => $request->CallDuration ?? 0,
            'twilio_data' => $request->all(),
        ]);

        if ($request->CallStatus === 'completed') {
            $call->update([
                'ended_at' => now(),
                'disposition' => 'answered',
            ]);
        }

        return response('OK', 200);
    }

    public function update(Request $request, Call $call)
    {
        $validated = $request->validate([
            'notes' => 'nullable|string',
            'summary' => 'nullable|string',
            'disposition' => 'nullable|in:answered,busy,no-answer,failed,voicemail',
        ]);

        $call->update($validated);

        return back()->with('success', 'Call updated');
    }
}
