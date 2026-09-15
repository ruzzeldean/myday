<x-app-layout>
  <div class="max-w-md mx-auto mt-10 p-6 sm:bg-white sm:rounded-lg sm:shadow-md">
    <div>
      <img src="{{ asset('images/brand/myday-logo.png') }}" alt="Logo" class="mx-auto h-16 w-auto">
    </div>

    <h1 class="text-2xl font-bold text-center mt-3">Sign up</h1>

    <div id="signup-message" role="alert" class="alert alert-soft mt-4 hidden">
      <ul id="error-list" class="list-disc list-inside hidden">
      </ul>

      <x-icons.circle-check class="success-message hidden" /> <span class="success-message hidden">Success.
        Redirecting...</span>
    </div>

    <form method="POST" action="{{ route('signup') }}" novalidate id="signup-form" class="mt-6 space-y-3">
      @csrf

      <div class="space-y-1">
        <x-input-label for="name" value="Name" />
        <x-text-input id="name" name="name" type="text" class="validator" placeholder="Enter your name"
          minlength="2" maxlength="100" autofocus required />
        <x-input-hint for="name" value="Name must be at least 2 characters long." />
      </div>

      <div class="space-y-1">
        <x-input-label for="username" value="Username" />
        <x-text-input id="username" name="username" class="validator" type="text" required
          placeholder="Enter your username" minlength="2" maxlength="50" />
        <x-input-hint for="username" value="Username must be at least 2 characters long." />
      </div>

      <div class="space-y-1">
        <x-input-label for="email" value="Email" />
        <x-text-input id="email" name="email" class="validator" type="email" required
          placeholder="Enter your email" maxlength="255" />
        <x-input-hint for="email" value="Please enter a valid email address." />
      </div>

      <div class="space-y-1">
        <x-input-label for="password" value="Password" />
        <x-text-input id="password" name="password" class="validator" type="password" required
          placeholder="Enter your password" minlength="8" maxlength="255" />
        <x-input-hint for="password" value="Password must be at least 8 characters long." />
      </div>

      <div class="space-y-1">
        <x-input-label for="password_confirmation" value="Confirm Password" />
        <x-text-input id="password_confirmation" name="password_confirmation" class="validator" type="password" required
          placeholder="Confirm your password" minlength="8" maxlength="255" />
        <x-input-hint for="password_confirmation" value="Passwords do not match." />
      </div>

      <div class="mt-6">
        <button type="submit" id="submit-btn" class="btn btn-primary w-full">Sign up</button>
      </div>
    </form>

    <div class="mt-4 text-center">
      <a href="{{ route('signin') }}" class="text-indigo-600 hover:text-indigo-800">Already have an account?
        Sign in</a>
    </div>
  </div>

  @push('scripts')
    @vite('resources/js/auth/signup.js')
  @endpush
</x-app-layout>
