@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Team</h5>
    <div class="card-body">
      <form method="post" action="{{route('announcements.update',$data->id)}}">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label"> Title <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="title" placeholder="Enter title"  value="{{$data->title}}" class="form-control">
          @error('name')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label"> Description <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="description" placeholder="Enter description"  value="{{$data->description}}" class="form-control">
          @error('description')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label"> Content <span class="text-danger">*</span></label>
          <textarea id="inputTitle" type="text" name="content" placeholder="Enter content"  value="{{$data->content}}" class="form-control" style='min-height:200px'>{{$data->content}}</textarea>
          @error('content')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label"> Date <span class="text-danger">*</span></label>
          <input id="inputTitle" type="datetime-local" name="date" placeholder="Enter date"  value="{{$data->date}}" class="form-control" value = '{{$data->date}}'>
          @error('date')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="status">Status</label>
          <select name="status" class="form-control">
              @foreach($data_status as $status)
                  <option value='{{$status}}' {{(($data->status==$status) ? 'selected' : '')}}>{{Helper::$general_status[$status]}}</option>
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