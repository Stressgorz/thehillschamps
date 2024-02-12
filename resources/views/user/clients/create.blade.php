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
            <input id="password" type="email" class="form-control" placeholder="Enter Email" name="email">
            @error('email')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <div class="form-group">
            <label for="password" class="col-form-label">Contact <span class="text-danger">*</span></label>
            <input id="contact" type="text" class="form-control" placeholder="Enter Contact"  name="contact">
            @error('contact')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Address<span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="address" placeholder="Enter Address"  class="form-control">
          @error('address')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="country" class="col-form-label">Country <span class="text-danger">*</span></label>
          <select name="country" class="form-control">
              @foreach(Helper::$country as $country)
                  <option value='{{$country}}'>{{Helper::$country_name[$country]}}</option>
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
                  <option class="{{ $countries }}">{{$state}}</option>
                @endforeach
              @endforeach
          </select>
          @error('state')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">City<span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="city" placeholder="Enter City"  class="form-control">
          @error('city')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Zip Code<span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="zip" placeholder="Enter Zip Code"  class="form-control">
          @error('zip')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Marketer Email <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="upline_client_email" placeholder="Enter Marketer Email"  class="form-control">
          @error('upline_client_email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">IB Email <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="upline_user_email" placeholder="Enter IB Email " class="form-control">
          @error('upline_user_email')
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