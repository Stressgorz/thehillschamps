@extends('user.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Clients</h5>
    <div class="card-body">
      <form method="post" action="{{route('clients.store')}}">
        {{csrf_field()}}

        <div class="form-group">
          <label for="inputUsername" class="col-form-label">Name <span class="text-danger">*</span></label>
          <input id="inputUsername" type="text" name="name" placeholder="Enter name"  value="{{old('name')}}" class="form-control">
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
            <label for="password" class="col-form-label">Email <span class="text-danger">*</span></label>
            <input id="password" type="email" class="form-control" placeholder="Enter Email" value="{{old('email')}}" name="email">
            @error('email')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password" class="col-form-label">Contact <span class="text-danger">*</span></label>
            <input id="contact" type="text" class="form-control" placeholder="Enter Contact" value="{{old('contact')}}" name="contact">
            @error('contact')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Address<span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="address" placeholder="Enter Address" value="{{old('address')}}"  class="form-control">
          @error('address')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="country" class="col-form-label">Country<span class="text-danger">*</span></label>
          </br>
          <select class="selectpicker" data-live-search="true" name='country'>
              @foreach(Helper::$country as $country)
                  <option value='{{$country}}' {{(($country==old('country')) ? 'selected' : '')}}>{{Helper::$country_name[$country]}}</option>
              @endforeach
          </select>
          @error('country')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="state" class="col-form-label">State <span class="text-danger">*</span></label>
          <select name="state" class="form-control">
              @foreach(Helper::$state as $countries => $states)
                @foreach($states as $state)
                  <option class="{{ $countries }}" {{(($countries==old('state')) ? 'selected' : '')}}>{{$state}}</option>
                @endforeach
              @endforeach
          </select>
          @error('state')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">City<span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="city" placeholder="Enter City" value="{{old('city')}}" class="form-control">
          @error('city')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Zip Code<span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="zip" placeholder="Enter Zip Code" value="{{old('zip')}}" class="form-control">
          @error('zip')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="upline_client_id" class="col-form-label">Marketer (upline): <span class="text-danger">*</span></label>
          </br>
          <select class="selectpicker" data-live-search="true" name='upline_client_id'>
          <option value=''>None</option>
              @foreach($clients as $client)
                  <option value='{{$client->id}}'>{{$client->name}}</option>
              @endforeach
          </select>
          @error('upline_client_id')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="upline_user_id" class="col-form-label">Ib (upline): <span class="text-danger">*</span></label>
          </br>
          <select class="selectpicker" data-live-search="true" name='upline_user_id'>
          <option value=''>None</option>
              @foreach($ibs as $ib)
                  <option value='{{$ib->id}}'>{{$ib->firstname.' '.$ib->lastname}}</option>
              @endforeach
          </select>
          @error('upline_user_id')
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

  var country_state = @json(Helper::$state);

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

    $("[name=country]").on('change', function() {
        populateCountry();
    });

    populateCountry();
    function populateCountry() {
        var country = $("[name=country] :checked").val();

        haha = $("select[name='state']").find('option').prop("hidden", true);
        haha = $("select[name='state']").find('option.'+country).prop("hidden", false);
    }

</script>
@endpush