<nav class="navbar bg-base-100">
  {{-- Mobile menu --}}
  <div class="mr-auto">
    <div class="dropdown">
      <div tabindex="0" role="button" class="btn btn-ghost lg:hidden">
        <svg aria-label="Menu" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
          stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h8m-8 6h16" />
        </svg>
      </div>
      <ul tabindex="-1" class="menu menu-sm dropdown-content bg-base-100 rounded-box z-1 mt-3 w-52 p-2 shadow">
        <li><a href="{{ route('explore') }}">Explore</a></li>
        @auth
          <li><a href="{{ route('profile.index') }}">Profile</a></li>
          <li><a>Settings</a></li>
          <li>
            <form method="POST" action="{{ route('logout') }}">
              @csrf
              <button type="submit">Logout</button>
            </form>
          </li>
        @endauth
      </ul>
    </div>
    <a class="btn btn-ghost text-xl">MyDay</a>
  </div>

  {{-- Desktop menu --}}
  <div class="hidden lg:flex">
    <ul class="menu menu-horizontal px-1">
      <li><a href="{{ route('explore') }}">Explore</a></li>
      @auth
        <li><a href="{{ route('profile.index') }}">Profile</a></li>
        <li><a>Settings</a></li>
        <li>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit">Logout</button>
          </form>
        </li>
      @endauth
    </ul>
  </div>

  @guest
    <div>
      <a href="{{ route('signin') }}" class="btn">SIGN IN</a>
    </div>
  @endguest
</nav>
