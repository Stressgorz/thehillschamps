@extends('user.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Team</h5>
    <div class="card-body">
      <form method="post" action="{{route('sales.store')}}" enctype="multipart/form-data">
        {{csrf_field()}}

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Clients Email</label>
        <input id="inputTitle" type="email" name="clients_email" placeholder="Enter email"  value="{{old('clients_email')}}" class="form-control">
        @error('clients_email')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Amount</label>
        <input id="inputTitle" type="number" name="amount" placeholder="Enter amount"  value="{{old('amount')}}" class="form-control">
        @error('amount')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Sales Date</label>
        <input id="inputTitle" type="date" name="date" placeholder="Enter date"  value="{{old('date')}}" class="form-control">
        @error('date')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">MT4 ID</label>
        <input id="inputTitle" type="text" name="mt4_id" placeholder="Enter mt4 id"  value="{{old('mt4_id')}}" class="form-control">
        @error('mt4_id')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>  

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">MT4 Read Only Password</label>
        <input id="inputTitle" type="text" name="mt4_pass" placeholder="Enter mt4 password"  value="{{old('mt4_pass')}}" class="form-control">
        @error('mt4_pass')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>  

        <div class="form-group">
          <label for="status">Broker</label>
          <select name="broker_type" class="form-control">
              @foreach($sales_broker as $broker)
                  <option value='{{$broker}}'>{{$broker}}</option>
              @endforeach
          </select>
        @error('broker')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>

        <div class="form-group">
          <label for="inputTitle" class="col-form-label">Remark</label>
        <input id="inputTitle" type="text" name="remark" placeholder="Enter remark"  value="{{old('remark')}}" class="form-control">
        @error('remark')
        <span class="text-danger">{{$message}}</span>
        @enderror
        </div>  

        <div class="form-group">
        <label for="inputPhoto" class="col-form-label">Slip</label>
        <div class="input-group">
          <input type="file" name="slip[]" class="form-control" multiple>
        </div>
          @error('slip[]')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>
        
        <div class="form-group mb-3">
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

<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
</script>
@endpush