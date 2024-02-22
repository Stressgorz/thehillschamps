@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">View Sales</h5>
    <div class="card-body">
        @csrf 
        @method('PATCH')

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Broker</label>
          <input id="inputTitle" type="text" value="{{$sales->broker_type}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Amount</label>
          <input id="inputTitle" type="number" value="{{$sales->amount}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Client Name</label>
          <input id="inputTitle" type="text" value="{{$sales->client_name}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Client Email</label>
          <input id="inputTitle" type="text"  value="{{$sales->client_email}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Client Contact</label>
          <input id="inputTitle" type="text"  value="{{$sales->client_contact}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Client Address</label>
          <input id="inputTitle" type="text"  value="{{$sales->client_address}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">MT4 ID</label>
          <input id="inputTitle" type="text" value="{{$sales->mt4_id}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">MT4 Password</label>
          <input id="inputTitle" type="text" value="{{$sales->mt4_pass}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Ib Name</label>
          <input id="inputTitle" type="text"  value="{{$sales->user_firstname .' '.$sales->user_lastname}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Ib</label>
          <input id="inputTitle" type="text"  value="{{$user_upline->firstname .' '.$user_upline->lastname ?? ''}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Marketers</label>
          <input id="inputTitle" type="text"  value="{{$client_upline->name ?? ''}}" class="form-control" readonly>
        </div>
        
        @if($sales->sales_status == 'rejected')
          <div class="form-group col-6">
            <label for="inputTitle" class="col-form-label">Reject Reason</label>
            <input id="inputTitle" type="text" value="{{$sales->reason}}" class="form-control" readonly>
          </div>
        @endif
        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Remark</label>
          <input id="inputTitle" type="text" value="{{$sales->remark}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Status</label>
          <input id="inputTitle" type="text"  value="{{$sales->sales_status}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">  
          <label for="inputTitle" class="col-form-label">Sales Date</label>
          <input id="inputTitle" type="date" value="{{$sales->date}}" class="form-control" readonly>
        </div>
        <div class="form-group col-6">  
          <label for="inputTitle" class="col-form-label">Slip</label>
        </div>
        <div class="form-group col-6">  
          @foreach($slip_image as $image)
            <a href="#" class="img">
              <img src="{{ asset($image) }}" id="slip" alt="..." style='max-width: 250px'>
            </a>
          @endforeach
        </div>
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
      $('img').on('click', function(e) {
      $('#imgViewer').html('').append( $(e.currentTarget).clone().removeClass('img-responsive').removeClass('img-thumbnail').removeAttr('style'))
      $('#viewImg').modal('show')
      })
    });

    
</script>

@endpush