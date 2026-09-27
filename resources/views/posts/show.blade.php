<x-app-layout>
  <div class="max-w-4xl mx-auto md:px-6">
    <div class="px-3 md:px-0 flex justify-between">
      <button onclick="history.back()" class="btn btn-sm btn-ghost flex items-center w-max pl-2">
        <x-icons.chevron-left /> Back
      </button>

      <div class="space-x-2">
        <button onclick="edit_post.showModal()" class="btn btn-sm btn-soft">Edit</button>

        <button onclick="delete_post.showModal()" class="btn btn-sm btn-error btn-soft">Delete</button>
      </div>
    </div>

    <img src="{{ asset('storage/' . $post->image) }}" alt="{{ $post->title }}" class="w-full md:rounded-4xl mt-3">

    <div class="px-3 md:px-0">
      <h2 class="text-xl font-semibold mt-3">{{ $post->title }}</h2>

      @if ($post->content)
        <div class="whitespace-pre-wrap mt-2">{{ $post->content }}</div>
      @endif
    </div>

    <div class="flex items-center gap-3 mt-6 px-3 md:px-0">
      <a href="{{ route('profile.index') }}" class="flex items-center gap-2">
        <img
          src="https://images.unsplash.com/photo-1778110827897-6dc6b6f7c988?q=80&w=1976&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
          alt="Profile Picture" class="rounded-full aspect-square object-cover max-w-10 h-auto">
        <h4 class="font-semibold">{{ $post->user->name }}</h4>
      </a>

      <span class="text-sm text-slate-500">{{ $post->created_at->format('M. d, Y') }}</span>
    </div>

    @push('scripts')
      @vite('resources/js/post/update-post.js')
    @endpush
  </div>

  {{-- Edit Post Modal --}}
  <dialog id="edit_post" class="modal">
    <div class="modal-box">
      <h3 class="text-lg font-bold">Edit Post</h3>
      {{-- Edit Post Form --}}
      <form action="{{ route('post.update', $post->uuid) }}" method="POST" enctype="multipart/form-data"
        id="edit-post-form" class="mt-3 space-y-3">
        @csrf
        @method('PUT')

        <div class="space-y-2">
          <x-input-label for="title" value="Title" />
          <x-text-input type="text" name="title" id="title" class="validator" placeholder="Enter title"
            minlength="2" maxlength="255" value="{{ $post->title }}" autofocus required />
          <x-input-hint for="title" value="Title must be at least 2 characters long." />
        </div>

        <div class="space-y-2">
          <x-input-label for="image" value="Image" />
          <x-file-input name="image" id="image" class="validator" accept="image/jpeg,image/png" />
          <x-input-hint for="image" value="Invalid image type." />
        </div>

        <div class="space-y-2">
          <x-input-label for="content" value="Content" />
          <textarea name="content" id="content" class="textarea w-full focus:border-indigo-500 focus:outline-0" maxlength="1000"
            placeholder="Enter content... (maximum of 1,000 characters)">{{ $post->content }}</textarea>
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
          <button type="submit" form="edit-post-form" id="submit-btn" class="btn btn-primary">Update</button>
          <button class="btn">Close</button>
        </form>
      </div>
    </div>
  </dialog>

  {{-- Delete Post Modal --}}
  <dialog id="delete_post" class="modal">
    <div class="modal-box">
      <h3 class="text-lg font-bold">Confirm Deletion</h3>
      <p class="py-4">Are you sure you want to delete this post?</p>
      <div class="modal-action">
        <form method="dialog" class="space-x-2">
          <button class="btn">Cancel</button>
          <button class="btn btn-error btn-outline" form="delete-post-form">Yes, DELETE</button>
        </form>
      </div>
    </div>
  </dialog>

  <form action="{{ route('post.destroy', $post->uuid) }}" method="POST" id="delete-post-form">
    @csrf
    @method('DELETE')
  </form>
</x-app-layout>
