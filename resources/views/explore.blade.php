<x-app-layout>
  <div class="max-w-7xl mx-auto md:px-6 lg:px-8">
    <div class="grid md:grid-cols-2 lg:grid-cols-2 gap-x-10 gap-y-6 mt-3">
      <a class="flex flex-col">
        <figure class="flex-1" title="Post Title">
          <img src="https://placehold.co/600x400" alt="Post Title"
            class="md:rounded-2xl aspect-4/3 object-cover w-full h-full" loading="lazy" />
        </figure>

        <div class="p-3 md:px-0 flex justify-between gap-3 text-lg">
          <h2 class="font-medium flex-1 line-clamp-1" title="Post Title">Post Title</h2>

          <span>Aug 2026</span>
        </div>
      </a>
    </div>

    {{-- Placeholder when there's no post yet --}}
    {{-- <div class="grid place-items-center h-[calc(100vh-11rem)]">
      <p class="">Nothing here yet. Start creating one.</p>
    </div> --}}
  </div>
</x-app-layout>
