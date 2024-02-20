@extends('user.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Client</h5>
    <div class="card-body">
      <form method="post" action="{{route('clients.update',$client->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Name<span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="name" placeholder="Enter name"  value="{{$client->name}}" class="form-control">
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Email<span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="email" placeholder="Enter Email"  value="{{$client->email}}" class="form-control">
          @error('email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Contact <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="contact" placeholder="Enter contact"  value="{{$client->contact}}" class="form-control">
          @error('contact')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Address <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="address" placeholder="Enter Address"  value="{{$client->address}}" class="form-control">
          @error('address')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="country" class="col-form-label">Country <span class="text-danger">*</span></label>
          <select name="country" class="form-control">
              @foreach(Helper::$country as $country)
                  <option value='{{$country}}' {{(($client->country==$country) ? 'selected' : '')}}>{{Helper::$country_name[$country]}}</option>
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
                  <option class="{{ $countries }}" {{(($client->state==$state) ? 'selected' : '')}}>{{$state}}</option>
                @endforeach
              @endforeach
          </select>
          @error('state')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">City<span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="city" placeholder="Enter City" value = '{{$client->city}}' class="form-control">
          @error('city')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Zip Code<span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="zip" placeholder="Enter Zip Code" value = '{{$client->zip}}'  class="form-control">
          @error('zip')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">IB Email <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="user_email" placeholder="Enter IB Email"  value="{{$client->user_email}}" class="form-control">
          @error('user_email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">IB Name</label>
          <input id="inputTitle" type="text" value="{{$client->user_firstname.' '.$client->user_lastname}}" class="form-control" Readonly>
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Upline (IB) Email <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="upline_user_email" placeholder="Enter Upline (IB) Email "  value="{{$client->upline_user_email}}" class="form-control">
          @error('upline_user_email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Upline (IB) Name</label>
          <input id="inputTitle" type="text" value="{{$client->upline_user_firstname.' '.$client->upline_user_lastname}}" class="form-control" Readonly>
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Upline (Client) Email  <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="upline_client_email" placeholder="Enter Upline (Client) Email "  value="{{$client->upline_client_email}}" class="form-control">
          @error('upline_client_email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Upline (Client) Name</label>
          <input id="inputTitle" type="text" value="{{$client->upline_client_name}}" class="form-control" Readonly>
        </div>

        <div class="form-group">
          <label for="status">Status</label>
          <select name="status" class="form-control">
              @foreach($client_status as $status)
                  <option value='{{$status}}' {{(($client->status==$status) ? 'selected' : '')}}>{{Helper::$client_status[$status]}}</option>
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

var country_state = @json(Helper::$state);
    $('#lfm').filemanager('image');

    $(document).ready(function() {
    $('#summary').summernote({
      placeholder: "Write short description.....",
        tabsize: 2,
        height: 150
    });
    });

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