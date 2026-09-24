@props(['class' => ''])

<input type="file"
  {{ $attributes->merge(['class' => 'file-input w-full shadow focus:border-indigo-500 focus:outline-0 ' . $class]) }}>
