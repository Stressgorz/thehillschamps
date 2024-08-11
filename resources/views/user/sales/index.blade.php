@extends('user.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Sales Lists</h6>
  
      
    </div>
    <div class="card-header py-3">
      <form class="form-horizontal">
        <div class="form-group row">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label class="control-label">Status</label>
                <div class="form-group">
                  <select name="sales_status" class="form-control">
                  <option value=''>Select Status</option>
                      @foreach($sales_status as $status)
                          <option value='{{$status}}' {{(($status==Request::get('sales_status')) ? 'selected' : '')}}>{{$status}}</option>
                      @endforeach
                  </select>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label class="control-label">Broker</label>
                <div class="form-group">
                  <select name="broker_type" class="form-control">
                  <option value=''>Select Broker</option>
                      @foreach($brokers as $broker)
                          <option value='{{$broker}}' {{(($broker==Request::get('broker_type')) ? 'selected' : '')}}>{{$broker}}</option>
                      @endforeach
                  </select>
                </div>
            </div>

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
        <div class="form-group row">
          <div class="col-md-3 col-sm-3 col-xs-12">
                <label class="control-label">Client Name</label>
                <div class="form-group">
                    <input type='text' class="form-control" name="client_name" value="{{ Request::get('client_name') }}"/>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label class="control-label">Client Email</label>
                <div class="form-group">
                    <input type='text' class="form-control" name="client_email" value="{{ Request::get('client_email') }}"/>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label class="control-label">IB Email</label>
                <div class="form-group">
                    <input type='text' class="form-control" name="user_email" value="{{ Request::get('user_email') }}"/>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label class="control-label">Sales Type</label>
                <div class="form-group">
                  <select name="sales_type" class="form-control">
                  <option value=''>Select Type</option>
                      @foreach($sales_type as $type)
                          <option value='{{$type}}' {{(($type==Request::get('sales_type')) ? 'selected' : '')}}>{{$type}}</option>
                      @endforeach
                  </select>
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
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($table_data)>0)
        <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Sales Status</th>
              <th>Broker</th>
              <th>Amounts</th>
              <th>Client Name</th>
              <th>Phone</th>
              <th>Client Email</th>
              <th>MT4 ID</th>
              <th>IB</th>
              <th>Sales Date</th>
              <th>Submission Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th></th>
              <th>Total Amount</th>
              <th>{{$total_amount}}</th>
              <th></th>
              </tr>
          </tfoot>
          <tbody>

            @foreach($table_data as $data)
              @php
              @endphp
                <tr>
                    <td>{{$data->sales_status}}</td>
                    <td>{{$data->broker_type}}</td>
                    <td>{{$data->amount}}</td>
                    <td>{{$data->client_name}}</td>
                    <td>{{$data->client_contact}}</td>
                    <td>{{$data->client_email}}</td>
                    <td>{{$data->mt4_id}}</td>
                    <td>{{$data->user_firstname .' '.$data->user_lastname}}</td>
                    <td>{{$data->date}}</td>
                    <td>{{$data->updated_at}}</td>
                    <td>
                    <a href="{{route('sales.show',$data->id)}}" class="btn btn-primary btn-sm float-left m-1" data-toggle="tooltip" title="view" data-placement="bottom">Show</a>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
        @else
          <h6 class="text-center">No Sales found!!! Please create Sales</h6>
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
                    "orderable":true,

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

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
          $('.dltBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
              e.preventDefault();
              swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this data!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                       form.submit();
                    } else {
                        swal("Your data is safe!");
                    }
                });
          })
      })
  </script>
@endpush
