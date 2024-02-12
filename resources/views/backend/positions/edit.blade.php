@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Position</h5>
    <div class="card-body">
      <form method="post" action="{{route('positions.update',$position->id)}}" enctype="multipart/form-data">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">1st Step Points<span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="step1" placeholder="Enter name"  value="{{$position->step1}}" class="form-control">
          @error('step1')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">2nd Step Points<span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="step2" placeholder="Enter name"  value="{{$position->step2}}" class="form-control">
          @error('step2')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">3rd Step Points<span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="step3" placeholder="Enter name"  value="{{$position->step3}}" class="form-control">
          @error('step3')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">4th Step Points<span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="step4" placeholder="Enter name"  value="{{$position->step4}}" class="form-control">
          @error('step4')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">5th Step Points<span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="step5" placeholder="Enter name"  value="{{$position->step5}}" class="form-control">
          @error('step5')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Next Rank Points<span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="kpi" placeholder="Enter name"  value="{{$position->kpi}}" class="form-control">
          @error('kpi')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class ='row'>
          <div class='col-md-6 col-12'>
            <div class="form-group">
              <label for="inputPhoto" class="col-form-label">Step1 Image</label>
              <div class="input-group">
                <input type="file" name="step1_img" class="form-control" value = "{{$position->step1_img}}">
              </div>
              <div class="input-group mt-3">
                <img src="{{ asset('storage/'.$path.'/'.$position->step1_img) }}" alt="..." style='max-width: 250px'>
              </div>
              @error('step1_img')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
          </div>
          <div class='col-md-6 col-12'>
            <div class="form-group">
              <label for="inputTitle" class="col-form-label">Step 1 Name<span class="text-danger">*</span></label>
              <input id="inputTitle" type="text" name="step1_name" placeholder="Enter name"  value="{{$position->step1_name}}" class="form-control">
              @error('step1_name')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
          </div>
        </div>

        <div class ='row'>
          <div class='col-md-6 col-12'>
            <div class="form-group">
              <label for="inputPhoto" class="col-form-label">Step2 Image</label>
              <div class="input-group">
                <input type="file" name="step2_img" class="form-control" value = "{{$position->step2_img}}">
              </div>
              <div class="input-group mt-3">
                <img src="{{ asset('storage/'.$path.'/'.$position->step2_img) }}" alt="..." style='max-width: 250px'>
              </div>
              @error('step2_img')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
          </div>
          <div class='col-md-6 col-12'>
            <div class="form-group">
              <label for="inputTitle" class="col-form-label">Step 2 Name<span class="text-danger">*</span></label>
              <input id="inputTitle" type="text" name="step2_name" placeholder="Enter name"  value="{{$position->step2_name}}" class="form-control">
              @error('step2_name')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
          </div>
        </div>

        <div class ='row'>
          <div class='col-md-6 col-12'>
            <div class="form-group">
              <label for="inputPhoto" class="col-form-label">Step3 Image</label>
              <div class="input-group">
                <input type="file" name="step3_img" class="form-control" value = "{{$position->step3_img}}">
              </div>
              <div class="input-group mt-3">
                <img src="{{ asset('storage/'.$path.'/'.$position->step3_img) }}" alt="..." style='max-width: 250px'>
              </div>
              @error('step3_img')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
          </div>
          <div class='col-md-6 col-12'>
            <div class="form-group">
              <label for="inputTitle" class="col-form-label">Step 3 Name<span class="text-danger">*</span></label>
              <input id="inputTitle" type="text" name="step3_name" placeholder="Enter name"  value="{{$position->step3_name}}" class="form-control">
              @error('step3_name')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
          </div>
        </div>

        <div class ='row'>
          <div class='col-md-6 col-12'>
            <div class="form-group">
              <label for="inputPhoto" class="col-form-label">Step4 Image</label>
              <div class="input-group">
                <input type="file" name="step4_img" class="form-control" value = "{{$position->step4_img}}">
              </div>
              <div class="input-group mt-3">
                <img src="{{ asset('storage/'.$path.'/'.$position->step4_img) }}" alt="..." style='max-width: 250px'>
              </div>
              @error('step4_img')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
          </div>
          <div class='col-md-6 col-12'>
            <div class="form-group">
              <label for="inputTitle" class="col-form-label">Step 4 Name<span class="text-danger">*</span></label>
              <input id="inputTitle" type="text" name="step4_name" placeholder="Enter name"  value="{{$position->step4_name}}" class="form-control">
              @error('step4_name')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
          </div>
        </div>

        <div class ='row'>
          <div class='col-md-6 col-12'>
            <div class="form-group">
              <label for="inputPhoto" class="col-form-label">Step5 Image</label>
              <div class="input-group">
                <input type="file" name="step5_img" class="form-control" value = "{{$position->step5_img}}">
              </div>
              <div class="input-group mt-3">
                <img src="{{ asset('storage/'.$path.'/'.$position->step5_img) }}" alt="..." style='max-width: 250px'>
              </div>
              @error('step5_img')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
          </div>
          <div class='col-md-6 col-12'>
            <div class="form-group">
              <label for="inputTitle" class="col-form-label">Step 5 Name<span class="text-danger">*</span></label>
              <input id="inputTitle" type="text" name="step5_name" placeholder="Enter name"  value="{{$position->step5_name}}" class="form-control">
              @error('step5_name')
              <span class="text-danger">{{$message}}</span>
              @enderror
            </div>
          </div>
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