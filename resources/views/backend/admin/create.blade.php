@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Admin</h5>
    <div class="card-body">
      <form method="post" action="{{route('admin-setting.store')}}">
        {{csrf_field()}}

        <div class="form-group">
            <label for="password" class="col-form-label">Password <span class="text-danger">*</span></label>
            <input id="password" type="password" class="form-control" name="password" autocomplete="current-password">
            @error('password')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password" class="col-form-label">Confirm Password <span class="text-danger">*</span></label>
            <input id="confirm_password" type="password" class="form-control" name="confirm_password" autocomplete="current-password">
            @error('confirm_password')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Full Name <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="name" placeholder="Enter Name"  value="{{old('name')}}" class="form-control">
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Contact Number <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="contact" placeholder="Enter contact"  value="{{old('contact')}}" class="form-control">
          @error('contact')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Email Address <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="email" placeholder="Enter Email"  value="{{old('email')}}" class="form-control">
          @error('email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        
        <div class="form-group">
          <label for="role" class="col-form-label">Role <span class="text-danger">*</span></label>
          <select name="role" class="form-control">
              @foreach($admin_role as $role)
                  <option value='{{$role}}'>{{$role}}</option>
              @endforeach
          </select>
          @error('role')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        
        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
              @foreach($admin_status as $status)
                  <option value='{{$status}}'>{{$status}}</option>
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

<script>
  $('#is_parent').change(function(){
    var is_checked=$('#is_parent').prop('checked');
    // alert(is_checked);
    if(is_checked){
      $('#parent_cat_div').addClass('d-none');
      $('#parent_cat_div').val('');
    }
    else{
      $('#parent_cat_div').removeClass('d-none');
    }
  })
</script>
@endpush