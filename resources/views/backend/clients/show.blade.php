@extends('backend.layouts.master')

@section('main-content')

<div class="card">
  <div class="card-header">
    <div class = "row justify-content-between">
    <h5>View Client</h5>
    @if($is_pending == 'true')
      <form method="POST" action="{{route('admin-send-client-approval',[$client->id])}}">
        @csrf
            <button class="btn btn-primary btn-sm sendBtn m-1" data-id={{$client->id}}  data-toggle="tooltip" data-placement="bottom" title="Delete">Send Approval Email</button>
      </form>
    @endif
    </div>
  </div>
    <div class="card-body">
        @csrf 
        @method('PATCH')
      <div class='row'>
        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Email</label>
          <input id="inputTitle" type="text" value="{{$client->email}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Name</label>
          <input id="inputTitle" type="text" value="{{$client->name}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Contact</label>
          <input id="inputTitle" type="text" value="{{$client->contact}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Address</label>
          <input id="inputTitle" type="text"  value="{{$client->address}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Country</label>
          <input id="inputTitle" type="text"  value="{{$client->country}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">State</label>
          <input id="inputTitle" type="text"  value="{{$client->state}}" class="form-control" readonly>
        </div>
      </div>
      <div class='row'>
        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">City</label>
          <input id="inputTitle" type="text"  value="{{$client->city}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Zip</label>
          <input id="inputTitle" type="text" value="{{$client->zip}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Ib</label>
          <input id="inputTitle" type="text" value="{{$client->IB->firstname.' '.$client->IB->lastname}}" class="form-control" readonly>
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Upline (IB)</label>
          @if($client->uplineIb)
          <input id="inputTitle" type="text"  value="{{$client->uplineIb->firstname.' '.$client->uplineIb->lastname}}" class="form-control" readonly>
          @else
          <input id="inputTitle" type="text"  value="" class="form-control" readonly>
          @endif
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Upline (client)</label>
          @if($client->uplineClient)
          <input id="inputTitle" type="text"  value="{{$client->uplineClient->name}}" class="form-control" readonly>
          @else
          <input id="inputTitle" type="text"  value="" class="form-control" readonly>
          @endif
        </div>

        <div class="form-group col-6">
          <label for="inputTitle" class="col-form-label">Status</label>
          <input id="inputTitle" type="text"  value="{{Helper::$general_status[$client->status]}}" class="form-control" readonly>
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
<script>
    $('#lfm').filemanager('image');

    $(document).ready(function() {
      $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.sendBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
              e.preventDefault();
              swal({
                    title: "Are you sure?",
                    text: "Once send, client will receive the email immediately!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("You did not send!");
                    }
                });
          })
    });
</script>

@endpush