@extends('backend.layouts.master')

@section('main-content')

<div class="card">
<form class="form-horizontal">
    <div class="card-header py-3">
      <h5>View User</h5>
      <div class="form-group row">
            <div class="col-md-2 col-sm-3 col-xs-12">
                <label class="control-label">From Date</label>
                <div class='input-group date datepicker'>
                    </span>
                    <input type='date' class="form-control" name="fdate" value="{{ Request::get('fdate') }}"/>
                </div>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-12">
                <label class="control-label">To Date</label>
                <div class='input-group date datepicker'>
                    </span>
                    <input type='date' class="form-control" name="tdate" value="{{ Request::get('tdate') }}"/>
                </div>
            </div>
          </div>
          <div class="form-group">
              <div class="col-md-12 col-sm-12 col-xs-12">
                  <button id="advanced_search" type="submit" class="btn btn-success">Search</button>
                  <button id="clear_search" type="submit" class="btn btn-info">Clear Search</button>
              </div>
          </div>
      <a href="{{route('get-users-target', $user->id)}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="edit Profile"> User Target </a>
    </div>
    </form>
    <div class="card-body">
        @csrf 
        @method('PATCH')
      <div class='row'>
      <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Team Sales</label>
          <input id="inputTitle" type="text"  value="{{$direct_ib_sales}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Group Sales</label>
          <input id="inputTitle" type="text"  value="{{$all_downline_sales}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Email</label>
          <input id="inputTitle" type="text" value="{{$user->email}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Username</label>
          <input id="inputTitle" type="number" value="{{$user->username}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">First Name</label>
          <input id="inputTitle" type="text" value="{{$user->firstname}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Last Name</label>
          <input id="inputTitle" type="text"  value="{{$user->lastname}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Code</label>
          <input id="inputTitle" type="text"  value="{{$user->code}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">IB Code</label>
          <input id="inputTitle" type="text"  value="{{$user->ib_code}}" class="form-control" readonly>
        </div>
      </div>
      <div class='row'>
        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Phone</label>
          <input id="inputTitle" type="text"  value="{{$user->phone}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">DOB</label>
          <input id="inputTitle" type="text" value="{{$user->dob}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Team</label>
          <input id="inputTitle" type="text" value="{{$user->team->name}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Position</label>
          <input id="inputTitle" type="text"  value="{{$user->position->name}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Upline</label>
          @if($user->upline)
          <input id="inputTitle" type="text"  value="{{$user->upline->firstname.' '.$user->upline->firstname}}" class="form-control" readonly>
          @else
          <input id="inputTitle" type="text"  value="" class="form-control" readonly>
          @endif
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Status</label>
          <input id="inputTitle" type="text"  value="{{Helper::$general_status[$user->status]}}" class="form-control" readonly>
        </div>

      </div>
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

    $("#clear_search").on('click', function(e) {
            e.preventDefault();
            window.location.href = '{{ Request::url() }}';
        });
        
    });
</script>

@endpush