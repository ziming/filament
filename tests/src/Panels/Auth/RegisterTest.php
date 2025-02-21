<?php

use Filament\Events\Auth\Registered;
use Filament\Facades\Filament;
use Filament\Notifications\Auth\VerifyEmail;
use Filament\Pages\Auth\Register;
use Filament\Tests\Models\User;
use Filament\Tests\TestCase;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;

use function Filament\Tests\livewire;

uses(TestCase::class);

it('can render page', function () {
    expect(Filament::getRegistrationUrl())->toEndWith('/register');

    $this->get(Filament::getRegistrationUrl())
        ->assertSuccessful();
});

it('can render page with a custom slug', function () {
    Filament::setCurrentPanel(Filament::getPanel('slugs'));

    expect(Filament::getRegistrationUrl())->toEndWith('/register-test');

    $this->get(Filament::getRegistrationUrl())
        ->assertSuccessful();
});

it('can register', function () {
    Notification::fake();
    Event::fake();

    $this->assertGuest();

    Filament::getCurrentPanel()->requiresEmailVerification(false);

    $userToRegister = User::factory()->make();

    livewire(Register::class)
        ->fillForm([
            'name' => $userToRegister->name,
            'email' => $userToRegister->email,
            'password' => 'password',
            'passwordConfirmation' => 'password',
        ])
        ->call('register')
        ->assertRedirect(Filament::getUrl());

    Notification::assertSentTimes(VerifyEmail::class, expectedCount: 1);
    Event::assertDispatched(Registered::class);

    $this->assertAuthenticated();

    $this->assertCredentials([
        'email' => $userToRegister->email,
        'password' => 'password',
    ]);
});

it('can register and redirect user to their intended URL', function () {
    Notification::fake();
    Event::fake();

    session()->put('url.intended', $intendedUrl = Str::random());

    Filament::getCurrentPanel()->requiresEmailVerification(false);

    $userToRegister = User::factory()->make();

    livewire(Register::class)
        ->fillForm([
            'name' => $userToRegister->name,
            'email' => $userToRegister->email,
            'password' => 'password',
            'passwordConfirmation' => 'password',
        ])
        ->call('register')
        ->assertRedirect($intendedUrl);
});

it('can throttle registration attempts', function () {
    Notification::fake();
    Event::fake();

    $this->assertGuest();

    foreach (range(1, 2) as $i) {
        $userToRegister = User::factory()->make();

        livewire(Register::class)
            ->fillForm([
                'name' => $userToRegister->name,
                'email' => $userToRegister->email,
                'password' => 'password',
                'passwordConfirmation' => 'password',
            ])
            ->call('register')
            ->assertRedirect(Filament::getUrl());

        $this->assertAuthenticated();

        auth()->logout();
    }

    Notification::assertSentTimes(VerifyEmail::class, expectedCount: 2);
    Event::assertDispatchedTimes(Registered::class, times: 2);

    livewire(Register::class)
        ->fillForm([
            'name' => $userToRegister->name,
            'email' => $userToRegister->email,
            'password' => 'password',
            'passwordConfirmation' => 'password',
        ])
        ->call('register')
        ->assertNotified()
        ->assertNoRedirect();

    Notification::assertSentTimes(VerifyEmail::class, expectedCount: 2);
    Event::assertDispatchedTimes(Registered::class, times: 2);

    $this->assertGuest();
});

it('can validate `name` is required', function () {
    livewire(Register::class)
        ->fillForm(['name' => ''])
        ->call('register')
        ->assertHasFormErrors(['name' => ['required']]);
});

it('can validate `name` is max 255 characters', function () {
    livewire(Register::class)
        ->fillForm(['name' => Str::random(256)])
        ->call('register')
        ->assertHasFormErrors(['name' => ['max']]);
});

it('can validate `email` is required', function () {
    livewire(Register::class)
        ->fillForm(['email' => ''])
        ->call('register')
        ->assertHasFormErrors(['email' => ['required']]);
});

it('can validate `email` is valid email', function () {
    livewire(Register::class)
        ->fillForm(['email' => 'invalid-email'])
        ->call('register')
        ->assertHasFormErrors(['email' => ['email']]);
});

it('can validate `email` is max 255 characters', function () {
    livewire(Register::class)
        ->fillForm(['email' => Str::random(256)])
        ->call('register')
        ->assertHasFormErrors(['email' => ['max']]);
});

it('can validate `email` is unique', function () {
    $existingEmail = User::factory()->create()->email;

    livewire(Register::class)
        ->fillForm(['email' => $existingEmail])
        ->call('register')
        ->assertHasFormErrors(['email' => ['unique']]);
});

it('can validate `password` is required', function () {
    livewire(Register::class)
        ->fillForm(['password' => ''])
        ->call('register')
        ->assertHasFormErrors(['password' => ['required']]);
});

it('can validate `password` is confirmed', function () {
    livewire(Register::class)
        ->fillForm([
            'password' => Str::random(),
            'passwordConfirmation' => Str::random(),
        ])
        ->call('register')
        ->assertHasFormErrors(['password' => ['same']]);
});

it('can validate `passwordConfirmation` is required', function () {
    livewire(Register::class)
        ->fillForm(['passwordConfirmation' => ''])
        ->call('register')
        ->assertHasFormErrors(['passwordConfirmation' => ['required']]);
});
