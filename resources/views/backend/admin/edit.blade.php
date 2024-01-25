@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Admin</h5>
    <div class="card-body">
      <form method="post" action="{{route('admin-setting.update',$admin->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Username <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="username" placeholder="Enter username"  value="{{$admin->username}}" class="form-control">
          @error('username')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="password" class="col-form-label">Password <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="password" placeholder="Enter password"  class="form-control">
          @error('password')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="confirm_password" class="col-form-label">Confirm Password <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="confirm_password" placeholder="Enter confirm password"  class="form-control">
          @error('confirm_password')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Name <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="name" placeholder="Enter name"  value="{{$admin->name}}" class="form-control">
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Contact <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="contact" placeholder="Enter contact"  value="{{$admin->contact}}" class="form-control">
          @error('contact')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Email <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="email" placeholder="Enter email"  value="{{$admin->email}}" class="form-control">
          @error('email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

      <div class="form-group">
          <label for="role">Role</label>
          <select name="role" class="form-control">
              @foreach($admin_role as $role)
                  <option value='{{$role}}' {{(($admin->role==$role) ? 'selected' : '')}}>{{$role}}</option>
              @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="status">Status</label>
          <select name="status" class="form-control">
              @foreach($admin_status as $status)
                  <option value='{{$status}}' {{(($admin->status==$status) ? 'selected' : '')}}>{{$status}}</option>
              @endforeach
          </select>
        </div>

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