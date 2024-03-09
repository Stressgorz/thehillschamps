@extends('backend.layouts.master')

@section('main-content')

<div class="card">
  <div class="card-header py-3">
    <h5>Edit Kpi Answer</h5>
  </div>
  <div class="card-body">
    <form method="post" action="{{route('kpi-question.update',$kpi->id)}}" enctype="multipart/form-data">
      @csrf
      @method('PATCH')
      <div class="form-group">
        <label for="inputTitle" class="col-form-label">Number<span class="text-danger">*</span></label>
        <input id="inputTitle" type="number" name="sort" placeholder="Enter name" value="{{$kpi->sort}}" class="form-control" readonly>
      </div>

      <div class="form-group">
        <label for="inputTitle" class="col-form-label">Position<span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="position"  value="{{$position->name}}" class="form-control" readonly>
      </div>
      
      <div class="form-group">
        <label for="inputTitle" class="col-form-label">Question<span class="text-danger">*</span></label>
        <input id="inputTitle" type="text" name="name" placeholder="Enter Email" value="{{$kpi->name}}" class="form-control">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="status">Status</label>
        <select name="status" class="form-control">
            @foreach($kpi_status as $status)
                <option value='{{$status}}' {{(($kpi->status==$status) ? 'selected' : '')}}>{{Helper::$general_status[$status]}}</option>
            @endforeach
        </select>
        @error('status')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <h5>Edit Kpi Question</h5>
      <div class="x_panel" id="position-step-list-div">
        <div class="x_content">
          <table class="table table-hover table-bordered">
            <thead>
              <tr>
                <th>No</th>
                <th>Answer</th>
                <th>Points</th>
              </tr>
            </thead>
            <tbody id="kpi-table">
              @foreach($kpi_answers as $index => $answer)
              <tr class="kpi-tr">
                <td style="width: 7%;">
                  <input type="number" name="answer_sort[]" class="form-control" min="1" step="1" value="{{ $answer->sort }}" readonly>
                  @if ($errors->has('answer_sort.'.$index))
                  <span class="text-danger">{{ $errors->first('answer_sort.'.$index) }}</span>
                  @enderror
                </td>
                <td>
                  <input type="text" name="answer_name[]" class="form-control" value="{{ $answer->name }}">
                  @if ($errors->has('answer_name.'.$index))
                  <span class="text-danger">{{ $errors->first('answer_name.'.$index) }}</span>
                  @enderror
                </td>
                <td style="width: 10%;">
                  <input type="number" name="points[]" class="form-control" min="0" step="1" value="{{ $answer->points }}">
                  @if ($errors->has('points.'.$index))
                  <span class="text-danger">{{ $errors->first('points.'.$index) }}</span>
                  @enderror
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <button name="removeRow" type="button" class="btn btn-dark"> Remove a row</button>
            <button name="addRow" type="button" class="btn btn-success">Add new row</button>
          </div>
        </div>
      </div>

      <div class="form-group row justify-content-end m-3">
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

    $("[name=addRow]").click(function(e) {
      e.preventDefault();

      $(".kpi-tr").last().clone().appendTo($("#kpi-table"));

      $("input[name='answer_sort[]']").last().val($("#kpi-table > tr").length);
    });


    $("[name=removeRow]").click(function(e) {
      e.preventDefault();
      if ($("#kpi-table > tr").length != 1) {
        $(".kpi-tr").last().remove();
      }
    });
  });
</script>
@endpush