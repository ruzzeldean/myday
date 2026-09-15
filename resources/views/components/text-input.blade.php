@props(['disabled' => false])

<input @disabled($disabled)
  {{ $attributes->merge(['class' => 'input block w-full shadow focus:border-indigo-500']) }}>
