@extends('backend.layouts.master')

@section('main-content')


<div class="card">
    <h5 class="card-header">Add Roadmap</h5>
    <div class="card-body">
        <form method="post" action="{{ route('roadmap.store') }}">
            {{ csrf_field() }}

            <!-- Position -->
            <div class="form-group">
                <label for="position_id" class="col-form-label">Rank <span class="text-danger">*</span></label>
                <select id="position_id" name="position_id" class="form-control">
                    <option value="">-- Select Rank --</option>
                        <option value="1">
                            IB
                        </option>
                        <option value="2">
                            Senior
                        </option>
                </select>
                @error('position_id')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>
            
            <!-- USD -->
            <div class="form-group">
                <label for="usd_amount" class="col-form-label">USD Amount <span class="text-danger">*</span></label>
                <input id="usd_amount" type="number" step="0.01" name="usd_amount" placeholder="Enter USD Amount" value="{{ old('usd_amount') }}" class="form-control">
                @error('usd_amount')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <!-- Roadmap Date -->
            <div class="form-group">
                <label for="roadmap_date" class="col-form-label">Roadmap Date <span class="text-danger">*</span></label>
                <input id="roadmap_date" type="date" name="date" value="{{ old('roadmap_date') }}" class="form-control">
                @error('roadmap_date')
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