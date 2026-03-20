@extends('backend.layouts.master')

@section('main-content')

<!-- resources/views/backend/wtt/create.blade.php -->

<div class="card">
    <h5 class="card-header">Add wtt</h5>
    <div class="card-body">
        <form method="post" action="{{ route('wtt.store') }}">
            {{ csrf_field() }}

            <!-- User Selection -->
            <div class="form-group">
                <label for="user_id" class="col-form-label">User <span class="text-danger">*</span></label>
                <select id="user_id" name="user_id" class="form-control">
                    <option value="">-- Select User --</option>
                    @foreach ($users as $user)
                        <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                            {{ $user->firstname }} {{ $user->lastname }}
                        </option>
                    @endforeach
                </select>
                @error('user_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- wtt Value -->
            <div class="form-group">
                <label for="wtt" class="col-form-label">wtt Value <span class="text-danger">*</span></label>
                <input id="wtt" type="number" step="0.01" name="wtt" placeholder="Enter wtt value" value="{{ old('wtt') }}" class="form-control">
                @error('wtt')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- wtt Date -->
            <div class="form-group">
                <label for="wtt_date" class="col-form-label">wtt Date <span class="text-danger">*</span></label>
                <input id="wtt_date" type="date" name="wtt_date" value="{{ old('wtt_date') }}" class="form-control">
                @error('wtt_date')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Form Buttons -->
            <div class="form-group mb-3">
                <button type="reset" class="btn btn-warning">Reset</button>
                <button type="submit" class="btn btn-success">Submit</button>
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