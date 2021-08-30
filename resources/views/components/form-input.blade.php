@if(isset($label))
    <label for="{{ $id ?? $name }}">{{ __($label) }}</label>
@endif
    <input type="{{ $type ?? 'text' }}" 
            class="form-control @error($name) is-invalid @enderror" 
            id="{{ $id ?? $name }}"
            name="{{ $name }}" 
            value="{{ old($name, $value ?? null) }}">
    @error($name)
        <p class="invalid-feedback">{{ $message }}</p>
    @enderror
