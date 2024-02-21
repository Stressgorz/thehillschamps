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
      <h6 class="m-0 font-weight-bold text-primary float-left">Announcements Lists</h6>
      <a href="{{route('announcements.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add Team"><i class="fas fa-plus"></i> Add Announcements</a>
    </div>
    <div class="card-header py-3">
      <form class="form-horizontal">
        <div class="form-group row">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label class="control-label">Status</label>
                <div class="form-group">
                  <select name="status" class="form-control">
                  <option value=''>Select Status</option>
                      @foreach($announcements_status as $status)
                          <option value='{{$status}}' {{(($status==Request::get('status')) ? 'selected' : '')}}>{{Helper::$general_status[$status]}}</option>
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
              <th>Title</th>
              <th>Description</th>
              <th>Date</th>
              <th>Status</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>

            @foreach($table_data as $data)
              @php
              @endphp
                <tr>
                    <td>{{$data->title}}</td>
                    <td>{{$data->description}}</td>
                    <td>{{$data->date}}</td>
                    <td>{{Helper::$general_status[$data->status]}}</td>
                    <td>
                    <a href="{{route('announcements.edit',$data->id)}}" class="btn btn-primary btn-sm float-left m-1" data-toggle="tooltip" title="edit" data-placement="bottom">Edit</a>
                    <form method="POST" action="{{route('announcements.destroy',[$data->id])}}">
                      @csrf
                      @method('delete')
                          <button class="btn btn-danger btn-sm dltBtn m-1" data-id={{$data->id}} data-toggle="tooltip" data-placement="bottom" title="Delete">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
        @else
          <h6 class="text-center">No Annoucement found!!! Please create Annoucement</h6>
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
