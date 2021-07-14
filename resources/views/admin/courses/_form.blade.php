@if($errors->any())
<div class="alert alert-danger">
    Errror!
    <ul>
        @foreach($errors->all() as $message)
        <li>{{ $message }}</li>
        @endforeach
    </ul>
</div>


@endif

<div class="form-group mb-3">
    <label for="">Name:</label>
    <input type="text" name="name" value="{{ old ('name', $course->name) }}" class="form-control @error('name') is-invlaid @enderror">
    @error('name')
    <p class="invalid-feedback d-block">{{ $message }}</p>
    @enderror
</div>

<div class="form-group mb-3">
    <label for="">Category:</label>
    <select name="category_id" class="form-control @error('category_id') is-invlaid @enderror">
        <option value="">Select Category</option>
        @foreach ($categories as $category)
        <option value="{{ $category->id }}" @if($category->id==old('category_id',$course->category_id)) selected @endif>{{ $category->name }}</option>
        @endforeach
    </select>
    @error('category_id')
    <p class="invalid-feedback d-block">{{ $message }}</p>
    @enderror
</div>

<div class="form-group mb-3">
    <label for="">Description</label>
    <textarea name="description" class="form-control @error('description') is-invlaid @enderror">{{ old('description',$course->description) }}</textarea>
    @error('description')
    <p class="invalid-feedback d-block">{{ $message }}</p>
    @enderror
</div>

<div class="form-group mb-3">
    <label for="">Image:</label>
    <div class="mb-2">
       <img src=" {{ $course->image_url }} " height="200" alt="">
     </div>
    <input type="file" name="image" class="form-control @error('image') is-invlaid @enderror">
    @error('image')
    <p class="invalid-feedback d-block">{{ $message }}</p>
    @enderror
</div>

<div class="form-group mb-3">
    <div class="row">
    @foreach($course->images as $image)
    <div class="col-md-2">
    <img src=" {{ $image->image_url }} " height="80" width="80" class="img-fit m-1 border p-1">
    </div>
    @endforeach
    </div>
   
</div>

<div class="form-group mb-3">
    <label for="">Added date:</label>
    <input type="date" name="date_of_add" value="{{ old ('date_of_add',$course->date_of_add) }}" class="form-control @error('date_of_add') is-invlaid @enderror">
    @error('date_of_add')
    <p class="invalid-feedback d-block">{{ $message }}</p>
    @enderror
</div>

<div class="form-group mb-3">
    <label for="">Course hours:</label>
    <input type="number" name="duration" value="{{ old ('duration',$course->duration) }}" class="form-control @error('duration') is-invlaid @enderror">
    @error('duration')
    <p class="invalid-feedback d-block">{{ $message }}</p>
    @enderror
</div>


<div class="form-group mb-3">
    <label>Status</label>
</div>
<div class="form-group mb-3">
    <label>
        <input type="radio" name="status" value="active" @if(old( 'status' , $course->status) == 'active' ) checked @endif >Active
    </label>
    <label>
    <input type="radio" name="status" value="active" @if(old( 'status' , $course->status) == 'inactive' ) checked @endif >Inactive
    </label>
    
</div>
@error('status')
<p class="invalid-feedback d-block d-block">{{ $message }}</p>
@enderror
<div class="form-group">
    <button type="submit" class="btn btn-primary">{{ $button_label ?? 'Save' }}</button>
</div>


