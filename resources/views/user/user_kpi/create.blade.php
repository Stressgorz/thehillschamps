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
            <input id="inputTitle" type="radio" name="kpi_answer[]" class="form-check-input" id="{{$answer_no}}">
            <label class="form-check-label" for="{{$answer_no}}">
              {{$answer['answer']}} ({{$answer['points']}} %)
            </label>
          </div>
          @error('mt4_id')
          <span class="text-danger">{{$message}}</span>
          @enderror
          @endforeach
          @endforeach
        </div>
        @endforeach
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