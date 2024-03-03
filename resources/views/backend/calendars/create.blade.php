@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Calendar</h5>
    <div class="card-body">
      <form method="post" action="{{route('calendars.store')}}">
        {{csrf_field()}}

        <div class="form-group">
          <label for="inputUsername" class="col-form-label"> Title <span class="text-danger">*</span></label>
          <input id="inputUsername" type="text" name="title" placeholder="Enter title"  value="{{old('title')}}" class="form-control">
          @error('title')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputUsername" class="col-form-label"> Date <span class="text-danger">*</span></label>
          <input id="inputUsername" type="date" name="start_time" placeholder="Enter Date"  value="{{old('start_time')}}" class="form-control">
          @error('start_time')
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