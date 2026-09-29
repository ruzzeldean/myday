<x-app-layout>
  <div class="max-w-7xl mx-auto md:px-6 lg:px-8">
    @if ($posts->count())
      <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-x-10 gap-y-6 mt-3">
        @foreach ($posts as $post)
          <a href="{{ route('post.show', $post->uuid) }}" class="flex flex-col">
            <figure class="flex-1" title="{{ $post->title }}">
              <img src="{{ asset('storage/'.$post->image) }}" alt="{{ $post->title }}"
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
      {{-- Placeholder when there's no post yet --}}
      <div class="grid place-items-center h-[calc(100vh-11rem)]">
        <p>Nothing here yet. Start creating one.</p>
      </div>
    @endif
  </div>
</x-app-layout>
