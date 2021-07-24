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
    <label for="">Product Name</label>
    <input type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name', $product->name) }}">
    @error('name')
        <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <x-form-select name="category_id" label="Category" :options="$categories" :selected="$product->category_id" />
</div>

<div class="form-group">
    <label for="">Description</label>
    <textarea name="description" class="form-control @error('description') is-invalid @enderror">{{ old('description', $product->description) }}</textarea>
    @error('description')
        <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <label for="">Image</label>
    <input type="file" name='image' class="form-control @error('image') is-invalid @enderror">
    @error('image')
        <p class="invalid-feedback">{{ $message }}</p>
    @enderror
</div>

<div class="form-group">
    <x-form-input type="text" label="Sku" name="sku" :value="$product->sku" />
</div>

<div class="form-group">
    <x-form-input type="number" label="Price" name="price" :value="$product->price" />
</div>

<div class="form-group">
    <x-form-input type="number" label="Sale Price" name="sale_price" :value="$product->sale_price" />
</div>

<div class="form-group">
    <x-form-input type="number" label="Quantity" name="quantity" :value="$product->quantity" />
</div>

<div class="form-group">
    <x-form-input type="number" label="Weight" name="weight" :value="$product->weight" />
</div>
<div class="form-group">
    <x-form-input type="number" label="Width" name="width" :value="$product->width" />
</div>

<div class="form-group">
    <x-form-input type="number" label="Height" name="height" :value="$product->height" />
</div>

<div class="form-group">
    <x-form-input type="number" label="Length" name="length" :value="$product->length" />
</div>

<div class="form-group">
    <label for="status">Status</label>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="status" id="status-active" value="active" @if(old('status', $product->status) == 'active') checked @endif>
        <label class="form-check-label" for="status-active">
            active
        </label>
    </div>
    <div class="form-check">
        <input class="form-check-input" type="radio" name="status" id="status-draft" value="draft" @if(old('status', $product->status) == 'draft') checked @endif>
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