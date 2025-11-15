<?php

namespace Tests\Feature;

use App\Models\Contact;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_view_own_contacts(): void
    {
        $team = Team::factory()->create();
        $user = User::factory()->create(['team_id' => $team->id]);
        $user->assignRole('sales_rep');
        
        $contact = Contact::factory()->create([
            'team_id' => $team->id,
            'owner_id' => $user->id,
        ]);

        $response = $this->actingAs($user)->get(route('contacts.index'));

        $response->assertStatus(200);
        $response->assertSee($contact->full_name);
    }

    public function test_user_cannot_view_other_team_contacts(): void
    {
        $team1 = Team::factory()->create();
        $team2 = Team::factory()->create();
        
        $user = User::factory()->create(['team_id' => $team1->id]);
        $user->assignRole('sales_rep');
        
        $otherContact = Contact::factory()->create(['team_id' => $team2->id]);

        $response = $this->actingAs($user)->get(route('contacts.show', $otherContact));

        $response->assertStatus(403);
    }
}