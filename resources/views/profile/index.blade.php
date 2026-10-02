<x-app-layout>
  <div class="max-w-7xl mx-auto md:px-6">
    {{-- Info --}}
    <div class="text-center">
      {{-- Profile Picture --}}
      <img
        src="https://images.unsplash.com/photo-1778110827897-6dc6b6f7c988?q=80&w=1976&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
        alt="Profile Picture" class="aspect-square object-cover rounded-full max-w-50 mx-auto">

      {{-- Name & Username --}}
      <div class="mt-3">
        <h1 class="text-3xl">{{ $user->name }}</h1>
        <p>{{ '@' . $user->username }}</p>
      </div>

      @auth
        @if (auth()->id() === $user->id)
          {{-- Action Buttons --}}
          <div class="mt-6 space-x-3">
            <a class="btn">Edit Profile</a>

            <a href="{{ route('post.trashed') }}" class="btn">View Trash</a>
          </div>
        @endif
      @endauth
    </div>

    {{-- Posts --}}
    @if ($posts->count())
      <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-x-10 gap-y-6 mt-6">
        @foreach ($posts as $post)
          <a href="{{ route('post.show', $post->uuid) }}" class="flex flex-col">
            <figure class="flex-1" title="{{ $post->title }}">
              <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}"
                class="md:rounded-4xl aspect-4/3 object-cover w-full h-full" loading="lazy" />
            </figure>

            <div class="p-3 md:px-0 flex justify-between gap-3 text-lg">
              <h2 class="font-medium flex-1 line-clamp-1" title="Post Title">{{ $post->title }}</h2>

              <span>{{ $post->created_at->format('M Y') }}</span>
            </div>
          </a>
        @endforeach
      </div>
    @else
      <div class="grid place-items-center mt-5 pt-15">
        <p class="">Nothing here yet. Start creating one.</p>
      </div>
    @endif
  </div>

  @auth
    @if (auth()->id() === $user->id)
      {{-- Create Post Button --}}
      <button class="btn btn-circle w-15 h-15 fixed bottom-5 right-5" onclick="create_post.showModal()">
        <x-icons.pen-line />
      </button>


      {{-- Create Post Modal --}}
      <dialog id="create_post" class="modal">
        <div class="modal-box">
          <h3 class="text-lg font-bold">Create Post</h3>
          {{-- Create Post Form --}}
          <form action="{{ route('post.create') }}" method="POST" enctype="multipart/form-data" id="create-post-form"
            class="mt-3 space-y-3">
            @csrf

            <div class="space-y-2">
              <x-input-label for="title" value="Title" />
              <x-text-input type="text" name="title" id="title" class="validator" placeholder="Enter title"
                minlength="2" maxlength="255" autofocus required />
              <x-input-hint for="title" value="Title must be at least 2 characters long." />
            </div>

            <div class="space-y-2">
              <x-input-label for="image" value="Image" />
              <x-file-input name="image" id="image" class="validator" accept="image/jpeg,image/png" required />
              <x-input-hint for="image" value="Image is required." />
            </div>

            <div class="space-y-2">
              <x-input-label for="content" value="Content" />
              <textarea name="content" id="content" class="textarea w-full focus:border-indigo-500 focus:outline-0" maxlength="1000"
                placeholder="Enter content... (maximum of 1,000 characters)"></textarea>
            </div>
          </form>

          <div role="alert" id="server-message" class="alert alert-soft mt-5 hidden">
            <ul id="error-list" class="list-disc list-inside hidden">
            </ul>

            <x-icons.circle-check class="success-message hidden" />
            <span id="success-server-message" class="success-message hidden"></span>
          </div>

          {{-- Modal Action Buttons --}}
          <div class="modal-action">
            <form method="dialog" class="space-x-2">
              <button type="submit" form="create-post-form" id="submit-btn" class="btn btn-primary">Create</button>
              <button class="btn">Close</button>
            </form>
          </div>
        </div>
      </dialog>

      @push('scripts')
        @vite('resources/js/post/create-post.js')
      @endpush
    @endif
  @endauth
</x-app-layout>
