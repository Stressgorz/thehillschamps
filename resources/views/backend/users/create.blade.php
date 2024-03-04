@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add User</h5>
    <div class="card-body">
      <form method="post" action="{{route('users.store')}}">
        {{csrf_field()}}

        <div class="form-group">
          <label for="inputUsername" class="col-form-label">Email <span class="text-danger">*</span></label>
          <input id="inputUsername" type="text" name="email" placeholder="Enter EMail"  value="{{old('email')}}" class="form-control">
          @error('email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

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
          <label for="inputTitle" class="col-form-label">User Name <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="username" placeholder="Enter username"  value="{{old('username')}}" class="form-control">
          @error('username')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">First Name <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="firstname" placeholder="Enter First Name"  value="{{old('firstname')}}" class="form-control">
          @error('firstname')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Last Name <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="lastname" placeholder="Enter Last Name"  value="{{old('lastname')}}" class="form-control">
          @error('lastname')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Code <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="code" placeholder="Enter code"  value="{{old('code')}}" class="form-control">
          @error('code')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">IB Code <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="ib_code" placeholder="Enter Ib Code"  value="{{old('ib_code')}}" class="form-control">
          @error('ib_code')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Phone <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="phone" placeholder="Enter contact"  value="{{old('phone')}}" class="form-control">
          @error('phone')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">DOB<span class="text-danger">*</span></label>
          <input id="inputTitle" type="date" name="dob" placeholder="Enter DOB"  value="{{old('dob')}}" class="form-control">
          @error('dob')
          <span class="text-danger">{{$message}}</span>
          @enderror 
        </div>

        
        <div class="form-group">
          <label for="team_id" class="col-form-label">Team <span class="text-danger">*</span></label>
          <select name="team_id" class="form-control">
              @foreach($teams as $team)
                  <option value='{{$team->id}}'>{{$team->name}}</option>
              @endforeach
          </select>
          @error('team_id')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="position_id" class="col-form-label">Position <span class="text-danger">*</span></label>
          <select name="position_id" class="form-control">
              @foreach($positions as $position)
                  <option value='{{$position->id}}'>{{$position->name}}</option>
              @endforeach
          </select>
          @error('position_id')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="upline_id" class="col-form-label">Upline <span class="text-danger">*</span></label>
          </br>
          <select class="selectpicker" data-live-search="true" name='upline_id'>
          <option value=''>None</option>
              @foreach($users as $user)
                  <option value='{{$user->id}}'>{{$user->firstname.' '.$user->lastname}}</option>
              @endforeach
          </select>
          @error('upline_id')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        
        <div class="form-group">
          <label for="status" class="col-form-label">Status <span class="text-danger">*</span></label>
          <select name="status" class="form-control">
              @foreach($user_status as $status)
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
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.5/css/bootstrap-select.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.5/js/bootstrap-select.js"></script>

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