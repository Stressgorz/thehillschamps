@extends('user.layouts.master')

@section('main-content')

<div class="card">
  <h5 class="card-header">View Kpi</h5>
  <div class="card-body">
    @csrf
    @method('PATCH')

    @if($kpi_question)
    @foreach($kpi_question as $question_no => $question)
    <div class="form-group">
      <label for="inputTitle" class="col-form-label">Question {{$question_no}}: </label>
      @foreach($question as $question_name => $question_type)
      <label for="inputTitle" class="col-form-label">{{$question_name}}</label>
      @foreach($question_type as $type => $kpi_answer)

        @foreach($kpi_answer as $answer_type => $answer)
        @if($type == 'selection')
          @if($answer_type == 'original')
          <div class="form-group">
            <label for="inputTitle" class="col-form-label">Answer</label>
            <input id="inputTitle" type="text" class="form-control" value="{{$answer['answer'].' ('.$answer['points'].'%)'}}" readonly>
          </div>
          @endif
          @if($answer_type == 'final')
            @if($answer['answer'])
            <div class="form-group">
              <label for="inputTitle" class="col-form-label">Edited Answer</label>
              <input id="inputTitle" type="text" class="form-control" value="{{$answer['answer'].' ('.$answer['points'].'%)'}}" readonly>
            </div>
            @else
            @endif
          @endif
        @elseif($type == 'image')
          @if($answer_type == 'original')
          <div class="form-group">
            @foreach($answer['answer'] as $image)
            <a href="#" class="img">
              <img src="{{ asset($image) }}" id="slip" alt="..." style='max-width: 250px'>
            </a>
            @endforeach
          </div>
          @endif
        @elseif($type == 'text')
          @if($answer_type == 'original')
            <div class="form-group">
              <label for="inputTitle" class="col-form-label"> Answer</label>
              <input id="inputTitle" type="text" class="form-control" value="{{$answer['answer']}}" readonly>
            </div>
          @endif
        @endif
        @endforeach

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
      <textarea class="form-control" readonly>{{$user_kpi->remarks}}</textarea>
    </div>

    <div class="form-group">
      <label for="inputTitle" class="col-form-label">Status</label>
      <input id="inputTitle" type="text" name="status" value="{{Helper::$approval_status[$user_kpi->status]}}" class="form-control" readonly>
    </div>

    <div class="form-group">
      <label for="inputTitle" class="col-form-label">Total Points</label>
      <input id="inputTitle" type="text" value="{{$total_points}}" class="form-control" readonly>
    </div>

    @else
    <h5>Hailat, something is wrong. Find Yan, is all Yan's fault</h5>
    @endif
    <hr>
  </div>
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