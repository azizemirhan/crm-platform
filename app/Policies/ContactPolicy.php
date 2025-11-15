<?php

namespace App\Policies;

use App\Models\Contact;
use App\Models\User;

class ContactPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->can('contacts.view') || $user->can('contacts.view_all');
    }

    public function view(User $user, Contact $contact): bool
    {
        // Admin ve Manager herşeyi görebilir
        if ($user->can('contacts.view_all')) {
            return true;
        }

        // Sadece kendi kayıtlarını görebilir
        return $user->can('contacts.view') && $contact->owner_id === $user->id;
    }

    public function create(User $user): bool
    {
        return $user->can('contacts.create');
    }

    public function update(User $user, Contact $contact): bool
    {
        if ($user->can('contacts.view_all')) {
            return $user->can('contacts.edit');
        }

        return $user->can('contacts.edit') && $contact->owner_id === $user->id;
    }

    public function delete(User $user, Contact $contact): bool
    {
        if ($user->can('contacts.view_all')) {
            return $user->can('contacts.delete');
        }

        return $user->can('contacts.delete') && $contact->owner_id === $user->id;
    }
}