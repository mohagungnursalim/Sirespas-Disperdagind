<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('Kata sandi dapat diperbarui', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/profile')
        ->put('/password', [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    $response
        ->assertSessionHasNoErrors()
        ->assertRedirect('/dashboard/profile');

    $this->assertTrue(Hash::check('new-password', $user->refresh()->password));
});


test('Kata sandi yang benar harus diberikan untuk memperbarui kata sandi', function () {
    $user = User::factory()->create();

    $response = $this
        ->actingAs($user)
        ->from('/dashboard/profile')
        ->put('/password', [
            'current_password' => 'wrong-password', // Provide incorrect current password
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ]);

    // Assert for any errors in the updatePassword key (adjust if validation stores errors differently)
    $response->assertSessionHasErrors('current_password'); 

    // Assertion for redirect can remain the same
    $response->assertRedirect('/dashboard/profile');
});
