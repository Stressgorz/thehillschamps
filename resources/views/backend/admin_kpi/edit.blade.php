@extends('backend.layouts.master')

@section('main-content')

<div class="card">
  <h5 class="card-header">View Kpi</h5>
  <div class="card-body">
    <form method="post" action="{{route('admin-kpi.update',$user_kpi->id)}}">
      @csrf
      @method('PATCH')

      <div class="form-group">
        <label for="inputTitle" class="col-form-label">Ib Name</label>
        <input id="inputTitle" type="text" value="{{$username}}" class="form-control" readonly>
      </div>

      <div class="form-group">
        <label for="inputTitle" class="col-form-label">Ib Email</label>
        <input id="inputTitle" type="text" value="{{$user->email}}" class="form-control" readonly>
      </div>

      <div class="form-group">
        <label for="inputTitle" class="col-form-label">Position</label>
        <input id="inputTitle" type="text"  value="{{$user->position->name}}" class="form-control" readonly>
      </div>

      @if($kpi_question)
      @foreach($kpi_question as $question_no => $question)
      <div class="form-group">
        <label for="inputTitle" class="col-form-label">Question {{$question_no}}: </label>
        @foreach($question as $question_name => $kpi_answer)
        <label for="inputTitle" class="col-form-label">{{$question_name}}</label>
        @foreach($kpi_answer as $answer_type => $answer)
        @if($answer_type == 'original')
        @foreach($answer as $data)
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Answer</label>
          <input id="inputTitle" type="text" class="form-control" value="{{$data['answer'].' ('.$data['points'].'%)'}}" readonly>
        </div>
        @endforeach
        @endif
        @if($answer_type == 'final')
        @foreach($answer as $data)
        <div class="form-group">
          <label for="status">Edited Answer</label>
          <select name="kpi_answer.{{$question_no}}" class="form-control">
            @foreach($kpi_answer['all_answer'] as $edit_kpi_answer)
            <option value='{{$edit_kpi_answer->sort}}' {{(($edit_kpi_answer->sort==$data['sort']) ? 'selected' : '')}}>{{$edit_kpi_answer->name .' ('.$edit_kpi_answer->points.'%)' }}</option>
            @endforeach
          </select>
        </div>
        @endforeach
        @endif
        @endforeach
        @endforeach
      </div>
      @endforeach

      <div class="form-group">
        <label for="inputTitle" class="col-form-label">Comment</label>
        <textarea class="form-control" readonly>{{$user_kpi->comment}}</textarea>
      </div>  

      <div class="form-group">
        <label for="inputTitle" class="col-form-label">Remarks</label>
        <textarea id="inputUsername" type="text" name="remarks" placeholder="Enter remarks"  value="{{$user_kpi->remarks}}" class="form-control" style='min-height:200px'></textarea>
        @error('remarks')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="status">Status</label>
        <select name="status" class="form-control">
          @foreach($kpi_status as $status)
          <option value='{{$status}}' {{(($user_kpi->status==$status) ? 'selected' : '')}}>{{Helper::$approval_status[$status]}}</option>
          @endforeach
        </select>
      </div>

      <div class="form-group">
        <label for="inputTitle" class="col-form-label">Total Points</label>
        <input id="inputTitle" type="text" value="{{$total_points}}" class="form-control" readonly>
      </div>

      <div class="form-group">
        <label for="inputTitle" class="col-form-label">Attachment</label>
      </div>
      <div class="form-group">
        @foreach($kpi_image as $image)
        <a href="#" class="img">
          <img src="{{ asset($image) }}" id="slip" alt="..." style='max-width: 250px'>
        </a>
        @endforeach
      </div>
      @else
      <h5>Hailat, something is wrong. Find Yan, is all Yan's fault</h5>
      @endif
      <hr>
      <div class="form-group mb-3">
        <button class="btn btn-success" type="submit">Update</button>
      </div>
  </div>
  </form>
</div>

<div class="modal in" id="viewImg" tabindex="-1" role="dialog" style="display: none;">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
      </div>
      <div class="modal-body">
        <div id="imgViewer" style="overflow-y: scroll;">
        </div>
      </div>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<style>
    textarea {
        border: none;
        outline: none;
        width: 100%;
        height: 100%;
    }
</style>
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


    $('img').on('click', function(e) {

      $('#imgViewer').html('').append($(e.currentTarget).clone().removeClass('img-responsive').removeClass('img-thumbnail').removeAttr('style'))
      $('#viewImg').modal('show')
    })
  });
</script>

@endpush