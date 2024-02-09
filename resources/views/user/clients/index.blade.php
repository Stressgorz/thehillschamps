@extends('user.layouts.master')

@section('main-content')
 <!-- DataTales Example -->
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('user.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Client Lists</h6>
      <a href="{{route('clients.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add Client</a>
    </div>
    <div class="card-header py-3">
      <form class="form-horizontal">
        <div class="form-group row">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label class="control-label">Status</label>
                <div class="form-group">
                  <select name="status" class="form-control">
                  <option value=''>Select Status</option>
                      @foreach($client_status as $status)
                          <option value='{{$status}}' {{(($status==Request::get('status')) ? 'selected' : '')}}>{{Helper::$approval_status[$status]}}</option>
                      @endforeach
                  </select>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label class="control-label">Team</label>
                <div class="form-group">
                  <select name="team_name" class="form-control">
                  <option value=''>Select Team</option>
                      @foreach($teams as $team)
                          <option value='{{$team->name}}' {{(($team->name==Request::get('team_name')) ? 'selected' : '')}}>{{$team->name}}</option>
                      @endforeach
                  </select>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label class="control-label">Client Name</label>
                <div class="form-group">
                    <input type='text' class="form-control" name="name" value="{{ Request::get('name') }}"/>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label class="control-label">Client Upline Name</label>
                <div class="form-group">
                    <input type='text' class="form-control" name="upline_client_name" value="{{ Request::get('upline_client_name') }}"/>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label class="control-label">IB Email</label>
                <div class="form-group">
                    <input type='text' class="form-control" name="user_email" value="{{ Request::get('user_email') }}"/>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label class="control-label">IB Upline Email</label>
                <div class="form-group">
                    <input type='text' class="form-control" name="upline_user_email" value="{{ Request::get('upline_user_email') }}"/>
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
              <th>Name</th>
              <th>IB</th>
              <th>Upline (IB)</th>
              <th>Upline (Client)</th>
              <th>Email</th>
              <th>Contact</th>
              <th>Address</th>
              <th>Team Of IB</th>
              <th>Created At</th>
              <th>Downline</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>

            @foreach($table_data as $data)
              @php
              @endphp
                <tr>
                    <td>{{$data->name}}</td>
                    <td>{{$data->user_firstname .' '.$data->user_lastname}}</td>
                    <td>{{$data->upline_user_firstname .' '.$data->upline_user_lastname}}</td>
                    <td>{{$data->upline_client_name}}</td>
                    <td>{{$data->email}}</td>
                    <td>{{$data->contact}}</td>
                    <td>{{$data->address}}</td>
                    <td>{{$data->team_name}}</td>
                    <td>{{$data->created_at}}</td>
                    <td></td>
                    <td>
                    <a href="{{route('clients.edit',$data->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{route('clients.destroy',[$data->id])}}">
                      @csrf
                      @method('delete')
                          <button class="btn btn-danger btn-sm dltBtn" data-id={{$data->id}} style="height:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
        @else
          <h6 class="text-center">No Clients found!!! Please create Clients</h6>
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
