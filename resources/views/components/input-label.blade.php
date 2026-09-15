@props(['value'])

<label {{ $attributes->merge(['class' => 'label block font-medium text-sm text-gray-700']) }}>
  {{ $value }}
</label>
