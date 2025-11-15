<?php

namespace App\Providers;

use App\Models\Account;
use App\Models\Contact;
use App\Models\Lead;
use App\Models\Opportunity;
use App\Policies\AccountPolicy;
use App\Policies\ContactPolicy;
use App\Policies\LeadPolicy;
use App\Policies\OpportunityPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Contact::class => ContactPolicy::class,
        Account::class => AccountPolicy::class,
        Lead::class => LeadPolicy::class,
        Opportunity::class => OpportunityPolicy::class,
    ];

    public function boot(): void
    {
        //
    }
}