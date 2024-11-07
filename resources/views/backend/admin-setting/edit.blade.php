@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Admin Setting</h5>
    <div class="card-body">
      <form method="POST" action="{{route('admin-setting.edit',$admin_setting->id)}}" enctype="multipart/form-data">
        @csrf 
        @method('POST')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Name<span class="text-danger" >*</span></label>
          <input id="inputTitle" type="text" name="name" placeholder="Enter name"  value="{{$admin_setting->name}}" class="form-control" readonly> 
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="input-group input-group-lg">
          <div class="input-group-prepend">
            <span class="input-group-text" id="inputGroup-sizing-lg">Switch</span>
          </div>
          <input type="checkbox" class="form-control" aria-label="Sizing example input" aria-describedby="inputGroup-sizing-lg" name="switch" value='{{$admin_setting->switch}}' {{(($admin_setting->switch) ? 'checked' : '')}}>
        </div>
        </br>

        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Update</button>
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
        height: 150
    });
    });
</script>

@endpush