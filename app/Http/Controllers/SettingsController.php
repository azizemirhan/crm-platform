<?php

namespace App\Http\Controllers;

use App\Models\Integration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class SettingsController extends Controller
{
    /**
     * Display the general settings page.
     */
    public function index()
    {
        return view('settings.index');
    }

    /**
     * Display the users management page.
     */
    public function users()
    {
        return view('settings.users');
    }

    /**
     * Display the roles management page.
     */
    public function roles()
    {
        return view('settings.roles');
    }

    /**
     * Display the custom fields management page.
     */
    public function customFields()
    {
        return view('settings.custom-fields');
    }

    /**
     * Display the integrations page.
     */
    public function integrations()
    {
        $integrations = Integration::where('team_id', auth()->user()->team_id)
            ->orderBy('provider')
            ->get();

        $availableProviders = Integration::PROVIDERS;

        return view('settings.integrations', compact('integrations', 'availableProviders'));
    }

    /**
     * Store or update an integration
     */
    public function storeIntegration(Request $request)
    {
        $validated = $request->validate([
            'provider' => 'required|string',
            'name' => 'required|string|max:255',
            'is_active' => 'boolean',
            'credentials' => 'required|array',
            'config' => 'nullable|array',
            'notes' => 'nullable|string',
        ]);

        $validated['team_id'] = auth()->user()->team_id;
        $validated['type'] = Integration::PROVIDERS[$validated['provider']]['type'] ?? 'other';

        Integration::updateOrCreate(
            [
                'team_id' => $validated['team_id'],
                'provider' => $validated['provider'],
            ],
            $validated
        );

        return Redirect::route('settings.integrations')
            ->with('success', 'Integration saved successfully!');
    }

    /**
     * Delete an integration
     */
    public function destroyIntegration(Integration $integration)
    {
        // Ensure user can only delete their team's integrations
        if ($integration->team_id !== auth()->user()->team_id) {
            abort(403);
        }

        $integration->delete();

        return Redirect::route('settings.integrations')
            ->with('success', 'Integration deleted successfully!');
    }

    /**
     * Display the webhooks management page.
     */
    public function webhooks()
    {
        return view('settings.webhooks');
    }
}
