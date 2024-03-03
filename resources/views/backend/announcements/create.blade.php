@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Announcements</h5>
    <div class="card-body">
      <form method="post" action="{{route('announcements.store')}}">
        {{csrf_field()}}

        <div class="form-group">
          <label for="inputUsername" class="col-form-label"> Title <span class="text-danger">*</span></label>
          <input id="inputUsername" type="text" name="title" placeholder="Enter title"  value="{{old('title')}}" class="form-control">
          @error('title')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputUsername" class="col-form-label"> Description <span class="text-danger">*</span></label>
          <input id="inputUsername" type="text" name="description" placeholder="Enter description"  value="{{old('description')}}" class="form-control">
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputUsername" class="col-form-label"> Content <span class="text-danger">*</span></label>
          <textarea id="inputUsername" type="text" name="content" placeholder="Enter content"  value="{{old('content')}}" class="form-control" style='min-height:200px'></textarea>
          @error('content')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputUsername" class="col-form-label"> Date <span class="text-danger">*</span></label>
          <input id="inputUsername" type="datetime-local" name="date" placeholder="Enter Date"  value="{{old('date')}}" class="form-control">
          @error('date')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
 
        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
              @foreach($announcements_status as $status)
                  <option value='{{$status}}'>{{Helper::$general_status[$status]}}</option>
              @endforeach
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
           <button class="btn btn-success" type="submit">Submit</button>
        </div>
      </form>
    </div>
</div>

@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script src="{{asset('backend/summernote/summernote.min.js')}}"></script>
<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
      $('#summary').summernote({
        placeholder: "Write short description.....",
          tabsize: 2,
          height: 120
      });
    });
</script>
@endpush