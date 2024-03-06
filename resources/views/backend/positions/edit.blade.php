@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <div class="card-header py-3">
    <h5>Edit Position</h5>
    @if($position_steps->isEmpty())
    <a href="{{route('add-position-steps', $position->id)}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="edit Profile"> Add Steps </a>
    @endif
    </div>
    <div class="card-body">
      <form method="post" action="{{route('positions.update',$position->id)}}" enctype="multipart/form-data">
        @csrf 
        @method('PATCH')
        <div class="x_panel" id="position-step-list-div">
          <div class="x_content">
              <table class="table table-hover table-bordered">
                  <thead>
                      <tr>
                      <th>Step</th>
                      <th>Kpi Amount</th>
                      <th>Name </th>
                      <th>Image File</th>
                      <th>Image</th>
                      </tr>
                  </thead>
                  <tbody id="steps-table">
                      @foreach($position_steps as $index => $steps)
                          <tr class="steps-tr">
                              <td style="width: 7%;">
                                <input type="number" name="sort[]" class="form-control" min="1" step="1" value="{{ $steps->sort }}" readonly>
                                @if ($errors->has('sort.'.$index))
                                <span class="text-danger">{{ $errors->first('sort.'.$index) }}</span>
                                @enderror
                              </td>
                              <td style="width: 10%;">
                                <input type="number" name="amount[]" class="form-control" min="1" step="1" value="{{ $steps->amount }}">
                                @if ($errors->has('amount.'.$index))
                                <span class="text-danger">{{ $errors->first('amount.'.$index) }}</span>
                                @enderror
                              </td>
                              <td>
                                <input type="text" name="name[]" class="form-control" value="{{ $steps->name }}">
                                @if ($errors->has('name.'.$index))
                                <span class="text-danger">{{ $errors->first('name.'.$index) }}</span>
                                @enderror
                              </td>
                              <td>
                                <input type="file" name="image[]" class="form-control" value = "{{$steps->image}}">
                                @if ($errors->has('image.'.$index))
                                <span class="text-danger">{{ $errors->first('image.'.$index) }}</span>
                                @enderror
                              </td>
                              <td style="width: 30%;">
                                @if($steps->image)
                                  <img src="{{ asset('storage/'.$path.'/'.$steps->image) }}" alt="..." style='max-width: 150px'>
                                @endif
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

      $("[name=addRow]").click(function(e){
        e.preventDefault();

        $(".steps-tr").last().clone().appendTo($("#steps-table"));

        $("input[name='sort[]']").last().val($("#steps-table > tr").length);
      });


      $("[name=removeRow]").click(function(e){
        e.preventDefault();
        if($("#steps-table > tr").length != 1){
            $(".steps-tr").last().remove();
        }
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