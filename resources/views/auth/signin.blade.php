<x-app-layout>
  <div class="max-w-md mx-auto mt-10 p-6 sm:bg-white sm:rounded-lg sm:shadow-md">
    <div>
      <img src="{{ asset('images/brand/myday-logo.png') }}" alt="Logo" class="mx-auto h-16 w-auto">
    </div>

    <h1 class="text-2xl font-bold text-center mt-3">Sign in</h1>

    <div id="signin-message" role="alert" class="alert alert-soft mt-4 hidden">
      <ul id="error-list" class="list-disc list-inside hidden">
      </ul>

      <x-icons.circle-check class="success-message hidden" /> <span class="success-message hidden">Success.
        Redirecting...</span>
    </div>

    <form method="POST" action="{{ route('signin') }}" novalidate id="signin-form" class="mt-6 space-y-3">
      @csrf

      <div class="space-y-1">
        <x-input-label for="email" value="Email" />
        <x-text-input id="email" name="email" class="validator" type="email" autofocus required
          placeholder="Enter your email" maxlength="255" />
        <x-input-hint for="email" value="Please enter a valid email address." />
      </div>

      <div class="space-y-1">
        <x-input-label for="password" value="Password" />
        <x-text-input id="password" name="password" class="validator" type="password" required
          placeholder="Enter your password" minlength="8" maxlength="255" />
        <x-input-hint for="password" value="Password must be at least 8 characters long." />
      </div>

      <div class="mt-6">
        <button type="submit" id="submit-btn" class="btn btn-primary w-full">Sign in</button>
      </div>
    </form>

    <div class="mt-4 text-center">
      <a href="{{ route('signup') }}" class="text-indigo-600 hover:text-indigo-800">
        Don't have an account? Sign up
      </a>
    </div>
  </div>

  @push('scripts')
    @vite('resources/js/auth/signin.js')
  @endpush
</x-app-layout>
