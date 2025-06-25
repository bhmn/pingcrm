<?php

use App\Models\Account;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;
use Illuminate\Foundation\Testing\RefreshDatabase;



// beforeAll(fn() => var_dump('Before all'));

// beforeEach(fn() => var_dump(config('app.name')));

// afterEach(fn() => var_dump('afterEach '));

// afterAll(fn() => var_dump('afterAll '));


//uses(RefreshDatabase::class);

beforeEach(function () {
    $this->user = User::factory()->create([
        'account_id' => Account::create(['name' => 'Acme Corporation'])->id,
        'first_name' => 'John',
        'last_name' => 'Doe',
        'email' => 'johndoe@example.com',
        'owner' => true,
    ]);

    $organization = $this->user->account->organizations()->create(['name' => 'Example Organization Inc.']);

    $this->user->account->contacts()->createMany([
        [
            'organization_id' => $organization->id,
            'first_name' => 'Martin',
            'last_name' => 'Abbott',
            'email' => 'martin.abbott@example.com',
            'phone' => '555-111-2222',
            'address' => '330 Glenda Shore',
            'city' => 'Murphyland',
            'region' => 'Tennessee',
            'country' => 'US',
            'postal_code' => '57851',
        ],
        [
            'organization_id' => $organization->id,
            'first_name' => 'Lynn',
            'last_name' => 'Kub',
            'email' => 'lynn.kub@example.com',
            'phone' => '555-333-4444',
            'address' => '199 Connelly Turnpike',
            'city' => 'Woodstock',
            'region' => 'Colorado',
            'country' => 'US',
            'postal_code' => '11623',
        ],
    ]);
});

//pest version
test('can view contacts', function () {
    $this->actingAs($this->user)
        ->get('/contacts')
        ->assertInertia(
            fn(Assert $assert) => $assert
                ->component('Contacts/Index')
                ->has('contacts.data', 2)
                ->has(
                    'contacts.data.0',
                    fn(Assert $assert) => $assert
                        ->has('id')
                        ->where('name', 'Martin Abbott')
                        ->where('phone', '555-111-2222')
                        ->where('city', 'Murphyland')
                        ->where('deleted_at', null)
                        ->has(
                            'organization',
                            fn(Assert $assert) => $assert
                                ->where('name', 'Example Organization Inc.')
                        )
                )
                ->has(
                    'contacts.data.1',
                    fn(Assert $assert) => $assert
                        ->has('id')
                        ->where('name', 'Lynn Kub')
                        ->where('phone', '555-333-4444')
                        ->where('city', 'Woodstock')
                        ->where('deleted_at', null)
                        ->has(
                            'organization',
                            fn(Assert $assert) => $assert
                                ->where('name', 'Example Organization Inc.')
                        )
                )
        );
});
