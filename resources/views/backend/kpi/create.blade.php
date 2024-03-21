@extends('backend.layouts.master')

@section('main-content')

<div class="card">
  <h5 class="card-header">Add Kpi Question</h5>
  <div class="card-body">
    <form method="post" action="{{route('kpi-question.store')}}">
      {{csrf_field()}}

      <div class="form-group">
        <label for="inputUsername" class="col-form-label"> Number <span class="text-danger">*</span></label>
        <input id="inputUsername" type="number" name="sort" placeholder="Enter Question Number" value="{{old('sort')}}" class="form-control">
        @error('sort')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="inputUsername" class="col-form-label"> Question <span class="text-danger">*</span></label>
        <input id="inputUsername" type="text" name="name" placeholder="Enter Question Name" value="{{old('name')}}" class="form-control">
        @error('name')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="status" class="col-form-label">Position <span class="text-danger">*</span></label>
        <select name="position_id" class="form-control">
          @foreach($positions as $position)
          <option value='{{$position->id}}'>{{$position->name}}</option>
          @endforeach
        </select>
        @error('position_id')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <div class="form-group">
        <label for="status" class="col-form-label">Question Type <span class="text-danger">*</span></label>
        <select name="type" class="form-control">
          @foreach($kpi_type as $type)
          <option value='{{$type}}'>{{$type}}</option>
          @endforeach
        </select>
        @error('type')
        <span class="text-danger">{{$message}}</span>
        @enderror
      </div>

      <h5 class="card-header">Add Answer</h5>
      <div class="x_panel" id="kpi-list-div">
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
              @if (old('answer_sort'))
              @foreach (old('answer_sort') as $index => $data)
              <tr class="kpi-tr">
                <td style="width: 7%;">
                  <input type="number" name="answer_sort[]" class="form-control" min="1" step="1" value="{{ old('answer_sort.'.$index) }}" readonly>
                  @if ($errors->has('answer_sort.'.$index))
                  <span class="text-danger">{{ $errors->first('answer_sort.'.$index) }}</span>
                  @enderror
                </td>
                <td>
                  <input type="text" name="answer_name[]" class="form-control" value="{{ old('answer_name.'.$index) }}">
                  @if ($errors->has('answer_name.'.$index))
                  <span class="text-danger">{{ $errors->first('answer_name.'.$index) }}</span>
                  @enderror
                </td>
                <td style="width: 10%;">
                  <input type="number" name="points[]" class="form-control" min="1" step="1" value="{{ old('points.'.$index) }}">
                  @if ($errors->has('points.'.$index))
                  <span class="text-danger">{{ $errors->first('points.'.$index) }}</span>
                  @enderror
                </td>
              </tr>
              @endforeach
              @else
              <tr class="kpi-tr">
                <td style="width: 7%;">
                  <input type="number" name="answer_sort[]" class="form-control" value="{{ 1 }}" step="1" readonly>
                </td>
                <td>
                  <input type="text" name="answer_name[]" class="form-control">
                </td>
                <td style="width: 10%;">
                  <input type="number" name="points[]" class="form-control" value="{{ 1 }}" step="1">
                </td>
              </tr>
              @endif
            </tbody>
          </table>
          <div class="col-md-6 col-sm-6 col-xs-12">
            <button name="removeRow" type="button" class="btn btn-dark"> Remove a row</button>
            <button name="addRow" type="button" class="btn btn-success">Add new row</button>
          </div>
        </div>
      </div>

      <div class="form-group row justify-content-end m-3">
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
    $(document).ready(function() {
      $('#summary').summernote({
        placeholder: "Write short description.....",
          tabsize: 2,
          height: 150
      });

      $("[name=addRow]").click(function(e){
        e.preventDefault();

        $(".kpi-tr").last().clone().appendTo($("#kpi-table"));

        $("input[name='answer_sort[]']").last().val($("#kpi-table > tr").length);
      });


      $("[name=removeRow]").click(function(e){
        e.preventDefault();
        if($("#kpi-table > tr").length != 1){
            $(".kpi-tr").last().remove();
        }
      });
    });
</script>
@endpush