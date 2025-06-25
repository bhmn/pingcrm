<?php

use App\Models\Contact;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;

use function Pest\Faker\fake;

//uses(WithFaker::class);


it('can store a contact1', function () {
    login()->post(
        '/contacts',
        [...[
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'email' => fake()->email,
            'phone' => fake()->e164PhoneNumber,
            'address' => "Birjand ",
            'city' => 'Birjand',
            'region' => 'Kho',
            'country' => fake()->randomElement(['us', 'ca']),
            'postal_code' => fake()->postcode,
        ]]
    )->assertRedirect('/contacts')->assertSessionHas('success', 'Contact created.');



    /*
    $contact = Contact::latest()->first();

    expect($contact->first_name)->toBeString()->not->toBeEmpty();
    expect($contact->last_name)->toBeString()->not->toBeEmpty();
    expect($contact->email)->toBeString()->toContain('@');
    //expect($contact->phone)->toBeString()->toStartWith('+');
    expect($contact->phone)->toBePhoneNumber();

    expect($contact->city)->toBe('Birjand');
    expect($contact->region)->toBe('Kho');
    expect($contact->country)->toBeIn(['us', 'ca']);
*/


    expect(Contact::latest()->first())
        ->first_name->toBeString()->not->toBeEmpty()
        ->last_name->toBeString()->not->toBeEmpty()
        ->email->toBeString()->toContain('@')
        ->phone->toBeString()->toStartWith('+')
        ->city->toBe('Birjand')
        ->region->toBe('Kho')
        ->country->toBeIn(['us', 'ca']);
})->with('valid emails')->group('laracasts');



it('can store a contact2', function (array $data) {
    login()->post(
        '/contacts',
        [...[
            'first_name' => fake()->firstName,
            'last_name' => fake()->lastName,
            'email' => fake()->email,
            'phone' => fake()->e164PhoneNumber,
            'address' => "Birjand ",
            'city' => 'Birjand',
            'region' => 'Kho',
            'country' => fake()->randomElement(['us', 'ca']),
            'postal_code' => fake()->postcode,
        ], ...$data]
    )->assertRedirect('/contacts')->assertSessionHas('success', 'Contact created.');


    /*
    $contact = Contact::latest()->first();

    expect($contact->first_name)->toBeString()->not->toBeEmpty();
    expect($contact->last_name)->toBeString()->not->toBeEmpty();
    expect($contact->email)->toBeString()->toContain('@');
    //expect($contact->phone)->toBeString()->toStartWith('+');
    expect($contact->phone)->toBePhoneNumber();

    expect($contact->city)->toBe('Birjand');
    expect($contact->region)->toBe('Kho');
    expect($contact->country)->toBeIn(['us', 'ca']);
*/


    expect(Contact::latest()->first())
        ->first_name->toBeString()->not->toBeEmpty()
        ->last_name->toBeString()->not->toBeEmpty()
        ->email->toBeString()->toContain('@')
        ->phone->toBeString()->toStartWith('+')
        ->city->toBe('Birjand')
        ->region->toBe('Kho')
        ->country->toBeIn(['us', 'ca']);
})->with([
    "generic" => [[]],
    "email with spaces" => [['email' => '"lucky"@lucky.com']],
    [['email' => '"bahman"@lucky.com',  'first_name' => 'sharon']],
    [['postal_code' => str_repeat('a', 25)]],

]);

// it('can store a contact using a previously invalid email addres s', function ($email) {
//     login()->post('/contacts', [
//         'first_name' => fake()->firstName,
//         'last_name' =>  fake()->lastName,
//         'email' => $email,
//         'phone' => fake()->e164PhoneNumber,
//         'address' => "Birjand ",
//         'city' => 'Birjand',
//         'region' => 'Kho',
//         'country' => fake()->randomElement(['us', 'ca']),
//         'postal_code' => fake()->postcode,
//     ])->assertRedirect('/contacts')->assertSessionHas('success', 'Contact created.');

//     expect(Contact::latest()->first())
//         ->first_name->toBeString()->not->toBeEmpty()
//         ->last_name->toBeString()->not->toBeEmpty()
//         ->email->toBeString()->toContain('@')
//         ->phone->toBeString()->toStartWith('+')
//         ->city->toBe('Birjand')
//         ->region->toBe('Kho')
//         ->country->toBeIn(['us', 'ca']);
// })->with([
//     fake()->email,
//     '"lucky"@gmail.com"',
// ]);
