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
      <h6 class="m-0 font-weight-bold text-primary float-left">User Target</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        @if(count($targets)>0)
        <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Status</th>
              <th>Target</th>
              <th>Created At</th>
            </tr>
          </thead>
          <tbody>

            @foreach($targets as $data)
              @php
              @endphp
                <tr>
                    <td>{{Helper::$general_status[$data->status]}}</td>
                    <td>{{$data->target}}</td>
                    <td>{{$data->created_at}}</td>
                </tr>
            @endforeach
          </tbody>
        </table>
        @else
          <h6 class="text-center">No Target found!!! Please create Target</h6>
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
@endpush
