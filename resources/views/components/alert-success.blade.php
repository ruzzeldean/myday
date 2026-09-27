@if (session('success'))
  <div class="w-full fixed bottom-0 p-2 md:w-auto md:static md:bottom-auto md:p-0">
    <div role="alert" class="toast alert alert-success alert-soft md:fixed md:bottom-3 md:right-3">
      <x-icons.circle-check /> <span>{{ session('success') }}</span>
    </div>
  </div>
@endif
