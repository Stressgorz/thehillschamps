@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Update IB Points</h5>
    <div class="card-body">
      <form method="post" action="{{route('add-users-points', $user_id)}}">
        {{csrf_field()}}

        <div class="form-group">
          <label for="inputUsername" class="col-form-label">Amount <span class="text-danger">*</span></label>
          <input id="inputUsername" type="text" name="amount" placeholder="Enter amount"  value="{{old('amount')}}" class="form-control">
          @error('amount')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        <div class="form-group">
          <label for="type" class="col-form-label">Type <span class="text-danger">*</span></label>
          <select name="type" class="form-control">
              @foreach($transaction_type as $type)
                  <option value='{{$type}}'>{{$type}}</option>
              @endforeach
          </select>
          @error('type')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputUsername" class="col-form-label">Description <span class="text-danger">*</span></label>
          <input id="inputUsername" type="text" name="description" placeholder="Enter description"  value="{{old('description')}}" class="form-control">
          @error('description')
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