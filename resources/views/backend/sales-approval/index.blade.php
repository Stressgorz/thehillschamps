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
      <h6 class="m-0 font-weight-bold text-primary float-left">Sales Approval Lists</h6>
    </div>
    <div class="card-header py-3">   
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
                    <a href="{{route('sales-approval.show',$data->id)}}" class="btn btn-primary btn-sm float-left m-1" data-toggle="tooltip" title="view" data-placement="bottom">Show</a>
                    <form method="POST" action="{{route('sales.approve',[$data->id])}}">
                      @csrf
                          <button class="btn btn-success btn-sm appBtn m-1" data-id={{$data->id}}  data-toggle="tooltip" data-placement="bottom" title="Approve">Approve</button>
                      </form>
                    <form method="POST" action="{{route('sales-approval.destroy',[$data->id])}}">
                      @csrf
                      @method('delete')
                          <button class="btn btn-danger btn-sm dltBtn m-1" data-id={{$data->id}} data-toggle="tooltip" data-placement="bottom" title="Delete">Reject</button>
                    </form>
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
          $('.appBtn').click(function(e){
            var form=$(this).closest('form');
              var dataID=$(this).data('id');
              // alert(dataID);
              e.preventDefault();
              swal({
                    title: "Are you sure?",
                    text: "Once Approved, you can change at the edit menu!",
                    icon: "success",
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
