@extends('user.layouts.master')

@section('main-content')
<div class="row justify-content-center">
  <div class="card col-md-6 col-12">
    <h5 class="card-header">Add Kpi</h5>
    <div class="card-body">
      <form method="post" action="{{route('user-kpi.store')}}" enctype="multipart/form-data">
        {{csrf_field()}}

        @if($kpi_question)
        @foreach($kpi_question as $question_no => $question)
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Question {{$question_no}}: </label>
          @foreach($question as $question_name => $kpi_answer)
          <label for="inputTitle" class="col-form-label">{{$question_name}}</label>

          @foreach($kpi_answer as $answer_no => $answer)
          <div class="form-check">
            <input id="inputTitle" type="radio" name="kpi_answer.{{$question_no}}[]" class="form-check-input ml-4" id="{{$answer_no}}" value="{{$answer_no}}" {{ in_array($answer_no, is_array(old('kpi_answer_'.$question_no)) ? old('kpi_answer_'.$question_no) : []) ? 'checked' : '' }}>
            <label class="form-check-label ml-5" for="{{$answer_no}}">
              {{$answer['answer']}} ({{$answer['points']}} %)
            </label>
          </div>
          @endforeach
          @error('kpi_answer_'.$question_no)
          <span class="text-danger">{{$message}}</span>
          @enderror
          @endforeach
        </div>
        @endforeach
        <hr>

        <div class="form-group">
          <label for="inputUsername" class="col-form-label"> Comment <span class="text-danger">*</span></label>
          <textarea id="inputUsername" type="text" name="comment" placeholder="Enter comment"  value="{{old('comment')}}" class="form-control" style='min-height:200px'></textarea>
          @error('comment')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputPhoto" class="col-form-label">Attachment<span class="text-danger">*</span></label>
          <div class="input-group">
            <input type="file" name="attachment[]" class="form-control" multiple>
          </div>
            @error('attachment')
            <span class="text-danger">{{$message}}</span>
            @enderror
        </div>
        <hr>
        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
          <button class="btn btn-success" type="submit">Submit</button>
        </div>
        @else
        <h5>There is no KPI, please contact admin</h5>
        @endif  
      </form>
    </div>
  </div>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('backend/summernote/summernote.min.css')}}">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.5/css/bootstrap-select.css" />
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.0/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.5/js/bootstrap-select.js"></script>
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
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
  $('#lfm').filemanager('image');
</script>
@endpush