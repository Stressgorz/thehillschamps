@extends('user.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">View Ads</h5>
    <div class="card-body">
        @csrf 
        @method('PATCH')

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Ib Name</label>
          <input id="inputTitle" type="text"  value="{{$user->firstname .' '.$user->lastname ?? ''}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Name</label>
          <input id="inputTitle" type="text" value="{{$ads->name}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Email</label>
          <input id="inputTitle" type="text" value="{{$ads->email}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Contact</label>
          <input id="inputTitle" type="text" value="{{$ads->contact}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Bank Name</label>
          <input id="inputTitle" type="text"  value="{{$ads->bank_acc}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Bank Account Number</label>
          <input id="inputTitle" type="text"  value="{{$ads->bank_num}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Status</label>
          <input id="inputTitle" type="text" value="{{Helper::$approval_status[$ads->status]}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Date</label>
          <input id="inputTitle" type="date" value="{{$ads->date}}" class="form-control" readonly>
        </div>
      
        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">File</label>
          <input id="inputTitle" type="text" value="{{$ads->file}}" class="form-control" readonly>
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
    });
</script>

@endpush