@extends('backend.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
    <form class="form-horizontal">
          <div class="form-group row">
            <div class="col-md-2 col-sm-3 col-xs-12">
                <label class="control-label">From Date</label>
                <div class='input-group date datepicker'>
                    </span>
                    <input type='date' class="form-control" name="fdate" value="{{ Request::get('fdate') }}"/>
                </div>
            </div>
            <div class="col-md-2 col-sm-3 col-xs-12">
                <label class="control-label">To Date</label>
                <div class='input-group date datepicker'>
                    </span>
                    <input type='date' class="form-control" name="tdate" value="{{ Request::get('tdate') }}"/>
                </div>
            </div>
          </div>

          <div class="form-group">
              <div class="col-md-12 col-sm-12 col-xs-12">
                  <button id="advanced_search" type="submit" class="btn btn-success">Search</button>
                  <button id="clear_search" type="submit" class="btn btn-info">Clear Search</button>
              </div>
          </div>
      </form>  
      <h6 class="m-0 font-weight-bold text-primary float-left">User Target</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($user_wallet_history)>0)
        <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Transaction Type</th>
              <th>Type</th>
              <th>Previous Amount</th>
              <th>Amount</th>
              <th>Balance</th>
              <th>Description</th>
              <th>Created At</th>
            </tr>
          </thead>
          <tbody>

            @foreach($user_wallet_history as $data)
              @php
              @endphp
                <tr>
                    <td>{{$data->transaction_type}}</td>
                    <td>{{$data->type}}</td>
                    <td>{{$data->prev_balance}}</td>
                    <td>{{$data->amount}}</td>
                    <td>{{$data->balance}}</td>
                    <td>{{$data->description}}</td>
                    <td>{{$data->created_at}}</td>
                </tr>
            @endforeach
          </tbody>
        </table>
        @else
          <h6 class="text-center">No points history found!!! Please create points</h6>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
  <style>
  </style>
@endpush

@push('scripts')

  <!-- Page level plugins -->
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>

  <!-- Page level custom scripts -->
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>

      $('#banner-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":false,
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){

        }
  </script>
  <script>
          $(document).ready(function(){

            $("#clear_search").on('click', function(e) {
                e.preventDefault();
                window.location.href = '{{ Request::url() }}';
            });
          })
  </script>
@endpush
