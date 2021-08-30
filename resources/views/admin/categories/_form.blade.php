@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $message)
                <li>{{$message}}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="form-group">
    <x-form-input label="Category Name" name="name" :value="$category->name" />
</div>

<div class="form-group">
    <label for="">{{ __('Parent') }}</label>
    <select name="parent_id" id="parent_id" class="form-control @error('parent_id') is-invalid @enderror">
        <!-- <option selected value='{{ $category->name }}'>{{ $category->name }}</option> -->
        <option value=''>No Parent</option>
        @foreach($parents as $parent)
        <option value="{{ $parent->id }}" @if($parent->id == old('parent_id', $category->parent_id)) selected @endif >{{ $parent->name }}</option>
        @endforeach
    </select>
    @error('parent_id')
        <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <label for="">{{ __('Description') }}</label>
    <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $category->description) }}</textarea>
    @error('description')
        <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <label for="">{{ __('Image') }}</label>
    <input type="file" name='image' class="form-control @error('image') is-invalid @enderror">
    @error('image')
        <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <label for="status">{{ __('Status') }}</label>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="status" id="status-active" value="active" @if(old('status', $category->status) == 'active') checked @endif>
        <label class="form-check-label" for="status-active">
            active
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="status" id="status-draft" value="draft" @if(old('status', $category->status) == 'draft') checked @endif>
        <label class="form-check-label" for="status-draft">
            draft
        </label>
    </div>
    @error('status')
        <p class="text-danger">{{ $message }}</p>
    @enderror
</div>

<div class="form-group mt-3">
    <button type="submit" class="btn btn-primary">{{ $button }}</button>
</div>