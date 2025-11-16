<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('settings.integrations');
    }

    /**
     * Display the webhooks management page.
     */
    public function webhooks()
    {
        return view('settings.webhooks');
    }
}
