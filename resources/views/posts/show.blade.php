<x-app-layout>
  <div class="max-w-4xl mx-auto md:px-6">
    <div class="px-3 md:px-0 flex justify-between">
      <button onclick="history.back()" class="btn btn-sm btn-ghost flex items-center w-max pl-2">
        <x-icons.chevron-left /> Back
      </button>

      <div class="space-x-2">
        <button class="btn btn-sm btn-soft">Edit</button>

        <button class="btn btn-sm btn-error btn-soft">Delete</button>
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
  </div>
</x-app-layout>
