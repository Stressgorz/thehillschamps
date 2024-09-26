@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit IB</h5>
    <div class="card-body">
      <form method="post" action="{{route('users.update',$user->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Email <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="email" placeholder="Enter email"  value="{{$user->email}}" class="form-control">
          @error('email')
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
          <label for="inputTitle" class="col-form-label">Username <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="username" placeholder="Enter username"  value="{{$user->username}}" class="form-control" readonly>
          @error('username')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">First name <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="firstname" placeholder="Enter firstname"  value="{{$user->firstname}}" class="form-control">
          @error('firstname')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Last Name <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="lastname" placeholder="Enter lastname"  value="{{$user->lastname}}" class="form-control">
          @error('lastname')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Code<span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="code" placeholder="Enter code"  value="{{$user->code}}" class="form-control">
          @error('code')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">IB Code <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="ib_code" placeholder="Enter Ib Code"  value="{{$user->ib_code}}" class="form-control">
          @error('ib_code')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Phone <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="phone" placeholder="Enter phone"  value="{{$user->phone}}" class="form-control">
          @error('phone')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">DOB <span class="text-danger">*</span></label>
          <input id="inputTitle" type="date" name="dob" placeholder="Enter DOB"  value="{{$user->dob}}" class="form-control">
          @error('dob')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        
        <div class="form-group">
          <label for="role">Team</label>
          <select name="gender" class="form-control">
              @foreach(Helper::$genders as $gender_key => $gender)
                  <option value='{{$gender_key}}' {{(($user->gender==$gender_key) ? 'selected' : '')}}>{{$gender}}</option>
              @endforeach
          </select>
          @error('gender')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>


      <div class="form-group">
          <label for="role">Team</label>
          <select name="team_id" class="form-control">
              @foreach($teams as $team)
                  <option value='{{$team->id}}' {{(($user->team_id==$team->id) ? 'selected' : '')}}>{{$team->name}}</option>
              @endforeach
          </select>
          @error('team_id')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="role">Positions</label>
          <select name="position_id" class="form-control">
              @foreach($positions as $position)
                  <option value='{{$position->id}}' {{(($user->position_id==$position->id) ? 'selected' : '')}}>{{$position->name}}</option>
              @endforeach
          </select>
          @error('position_id')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="role">Upline</label>
          <select class="selectpicker" data-live-search="true" name='upline_id'>
          <option value=''>None</option>
              @foreach($users as $upline)
                  <option value='{{$upline->id}}' {{(($user->upline_id==$upline->id) ? 'selected' : '')}}>{{$upline->firstname .' '. $upline->lastname}}</option>
              @endforeach
          </select>
          @error('upline_id')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="status">Status</label>
          <select name="status" class="form-control">
              @foreach($user_status as $status)
                  <option value='{{$status}}' {{(($user->status==$status) ? 'selected' : '')}}>{{Helper::$general_status[$status]}}</option>
              @endforeach
          </select>
          @error('status')
          <span class="text-danger">{{$message}}</span>
          @enderror
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