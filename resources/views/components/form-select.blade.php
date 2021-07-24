<label for="{{ $label }}">{{ $label }}</label>
<select name="{{ $name }}" id="{{ $id ?? $name }}" class="form-control @error($name) is-invalid @enderror">
    <option value=''></option>
    @foreach($options as $key => $text)
        <option value='{{ $key }}' @if($key == old($name, ($selected ?? null))) selected @endif>{{ $text }}</option>
        <!-- key => id , text => category->name ,,,,, { pluck('name', 'id') } -->
    @endforeach
</select>
@error($name)
    <p class="invalid-feedback">{{ $message }}</p>
@enderror
