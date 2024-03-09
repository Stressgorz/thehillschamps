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
      <h6 class="m-0 font-weight-bold text-primary float-left">User Kpi Lists</h6>
  
      
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
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($table_data)>0)
        <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Status</th>
              <th>Date</th>
              <th>Remarks</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>

            @foreach($table_data as $data)
              @php
              @endphp
                <tr>
                    <td>{{Helper::$approval_status[$data->status]}}</td>
                    <td>{{$data->created_at}}</td>
                    <td>{{$data->remarks}}</td>
                    <td>
                    <a href="{{route('user-kpi.show',$data->id)}}" class="btn btn-primary btn-sm float-left m-1" data-toggle="tooltip" title="view" data-placement="bottom">Show</a>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
        @else
          <h6 class="text-center">No KPI found!!! Please create KPI</h6>
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
