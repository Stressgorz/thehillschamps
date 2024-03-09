@extends('user.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Edit Sales</h5>
    <div class="card-body">
      <form method="post" action="{{route('sales.update',$sales->id)}}" enctype="multipart/form-data">
        @csrf 
        @method('PATCH')
        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Amount<span class="text-danger">*</span></label>
          <input id="inputTitle" type="number" name="amount" placeholder="Enter amount"  value="{{$sales->amount}}" class="form-control">
          @error('amount')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">MT4 ID<span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="mt4_id" placeholder="Enter MT4 ID"  value="{{$sales->mt4_id}}" class="form-control">
          @error('mt4_id')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">MT4 Password <span class="text-danger">*</span></label>
          <input id="inputTitle" type="text" name="mt4_pass" placeholder="Enter MT4 Password"  value="{{$sales->mt4_pass}}" class="form-control">
          @error('mt4_pass')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="status">Broker</label>
          <select name="broker_type" class="form-control">
              @foreach($sales_broker as $broker)
                  <option value='{{$broker}}' {{(($sales->broker==$broker) ? 'selected' : '')}}>{{$broker}}</option>
              @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="status">Status</label>
          <select name="sales_status" class="form-control">
              @foreach($sales_status as $status)
                  <option value='{{$status}}' {{(($sales->sales_status==$status) ? 'selected' : '')}}>{{$status}}</option>
              @endforeach
          </select>
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Reject Reason</label>
          <input id="inputTitle" type="text" name="reason" placeholder="Enter reject reason"  value="{{$sales->reason}}" class="form-control">
          @error('reason')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Remark</label>
          <input id="inputTitle" type="text" name="remark" placeholder="Enter remark"  value="{{$sales->remark}}" class="form-control">
          @error('remark')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Date<span class="text-danger">*</span></label>
          <input id="inputTitle" type="date" name="date" placeholder="Enter date"  value="{{$sales->date}}" class="form-control">
          @error('date')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
        <label for="inputPhoto" class="col-form-label">Slip</label>
        <div class="input-group">
          <input type="file" name="slip[]" class="form-control" value = "{{$sales->slip}}" multiple>
        </div>
          @error('slip[]')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

  
        @foreach($slip_image as $image)
        <a href="#" class="img">
            <img src="{{ asset($image) }}" id="slip" alt="..." style='max-width: 250px'>
          </a>
        @endforeach
        
        <div class="form-group mb-3">
           <button class="btn btn-success" type="submit">Update</button>
        </div>
      </form>
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

    $('img').on('click', function(e) {

      $('#imgViewer').html('').append( $(e.currentTarget).clone().removeClass('img-responsive').removeClass('img-thumbnail').removeAttr('style'))
      $('#viewImg').modal('show')
    })
</script>

@endpush