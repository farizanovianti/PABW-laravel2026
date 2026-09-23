@props(['name', 'label', 'type' => 'text'])

<div class="form-group">
    <label for="{{ $name }}">{{ $label }}</label>
    <input type="{{ $type }}" id="{{ $name }}" name="{{ $name }}"
           value="{{ old($name) }}" {{ $attributes }}>
    @error($name)
        <small class="error">{{ $message }}</small>
    @enderror
</div>