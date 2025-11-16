<?php

namespace App\Http\Controllers;

use App\Models\Opportunity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class OpportunityController extends Controller
{
    /**
     * Display a listing of opportunities.
     */
    public function index()
    {
        return view('opportunities.index');
    }

    /**
     * Show the form for creating a new opportunity.
     */
    public function create()
    {
        return view('opportunities.create');
    }

    /**
     * Display the specified opportunity.
     */
    public function show(Opportunity $opportunity)
    {
        return view('opportunities.show', [
            'opportunity' => $opportunity
        ]);
    }

    /**
     * Show the form for editing the specified opportunity.
     */
    public function edit(Opportunity $opportunity)
    {
        return view('opportunities.edit', [
            'opportunity' => $opportunity
        ]);
    }

    /**
     * Remove the specified opportunity from storage.
     */
    public function destroy(Opportunity $opportunity)
    {
        $opportunity->delete();

        return Redirect::route('opportunities.index')
            ->with('success', 'Opportunity deleted successfully.');
    }

    /**
     * Update the stage of the specified opportunity.
     */
    public function updateStage(Request $request, Opportunity $opportunity)
    {
        $validated = $request->validate([
            'stage' => 'required|in:' . implode(',', array_keys(Opportunity::$stages)),
        ]);

        $opportunity->update(['stage' => $validated['stage']]);

        return response()->json([
            'success' => true,
            'message' => 'Stage updated successfully.'
        ]);
    }

    /**
     * Mark the opportunity as won.
     */
    public function markAsWon(Opportunity $opportunity)
    {
        $opportunity->update([
            'stage' => 'closed_won',
            'actual_close_date' => now(),
        ]);

        return Redirect::back()
            ->with('success', 'Opportunity marked as won!');
    }

    /**
     * Mark the opportunity as lost.
     */
    public function markAsLost(Request $request, Opportunity $opportunity)
    {
        $validated = $request->validate([
            'loss_reason' => 'nullable|string|max:500',
        ]);

        $opportunity->update([
            'stage' => 'closed_lost',
            'actual_close_date' => now(),
            'loss_reason' => $validated['loss_reason'] ?? null,
        ]);

        return Redirect::back()
            ->with('success', 'Opportunity marked as lost.');
    }
}
