@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Ads</h5>
    <div class="card-body">
      <form method="post" action="{{route('ads.update',$ads->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Name<span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="name" placeholder="Enter name"  value="{{$ads->name}}" class="form-control">
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Email<span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="email" placeholder="Enter Email"  value="{{$ads->email}}" class="form-control">
          @error('email')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Contact <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="contact" placeholder="Enter contact"  value="{{$ads->contact}}" class="form-control">
          @error('contact')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Bank Name <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="bank_acc" placeholder="Enter Bank Name"  value="{{$ads->bank_acc}}" class="form-control">
          @error('bank_acc')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Bank Account Number <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="bank_num" placeholder="Enter Bank Account Number"  value="{{$ads->bank_num}}" class="form-control">
          @error('bank_num')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="status">Status</label>
          <select name="status" class="form-control">
              @foreach($ads_status as $status)
                  <option value='{{$status}}' {{(($ads->status==$status) ? 'selected' : '')}}>{{Helper::$approval_status[$status]}}</option>
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

@endpush