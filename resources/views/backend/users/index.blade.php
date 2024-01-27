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
      <h6 class="m-0 font-weight-bold text-primary float-left">User Lists</h6>
      <a href="{{route('users.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add User"><i class="fas fa-plus"></i> Add User</a>
    </div>
    <div class="card-header py-3">
      <form class="form-horizontal">
          <div class="form-group row">
              <div class="col-md-3 col-sm-3 col-xs-12">
                  <label class="control-label">Username</label>
                  <div class="form-group">
                      <input type='text' class="form-control" name="name" value="{{ Request::get('name') }}"/>
                  </div>
              </div>
              <div class="col-md-3 col-sm-3 col-xs-12">
                  <label class="control-label">Position</label>
                  <div class="form-group">
                  <select name="position" class="form-control">
                    <option value=''>Select Position</option>
                      @foreach($positions as $position)
                          <option value='{{$position->name}}' {{(($position->name==Request::get('position')) ? 'selected' : '')}}>{{$position->name}}</option>
                      @endforeach
                  </select>
                  </div>
              </div>
              <div class="col-md-3 col-sm-3 col-xs-12">
                  <label class="control-label">Team</label>
                  <div class="form-group">
                    <select name="team" class="form-control">
                    <option value=''>Select Team</option>
                        @foreach($teams as $team)
                            <option value='{{$team->name}}' {{(($team->name==Request::get('team')) ? 'selected' : '')}}>{{$team->name}}</option>
                        @endforeach
                    </select>
                  </div>
              </div>
              <div class="col-md-3 col-sm-3 col-xs-12">
                  <label class="control-label">Upline</label>
                  <div class="form-group">
                      <input type='text' class="form-control" name="upline" value="{{ Request::get('upline') }}"/>
                  </div>
              </div>
          </div>
          <div class="form-group">
              <div class="col-md-12 col-sm-12 col-xs-12">
                  <button id="advanced_search" type="submit" class="btn btn-success">Search</button>
                  <button id="clear_search" type="submit" class="btn btn-info">Clear Search</button>
                  <button id="exportBtn" type="submit" class="btn btn-primary pull-right">Export</button>
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
              <th>Ib Code</th>
              <th>Name</th>
              <th>Phone</th>
              <th>Position</th>
              <th>Team</th>
              <th>Points</th>
              <th>DOB</th>
              <th>Email</th>
              <th>Created date</th>
              <th>upline</th>
              <th>Downline</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>

            @foreach($table_data as $data)
              @php
              @endphp
                <tr>
                    <td>{{$data->status}}</td>
                    <td>{{$data->ib_code}}</td>
                    <td>
                        {{$data->username}}
                    </td>
                    <td>{{$data->phone}}</td>
                    <td>{{$data->position_name}}</td>
                    <td>{{$data->team_name}}</td>
                    <td>{{$data->email}}</td>
                    <td>{{$data->created_at}}</td>
                    <td>{{$data->email}}</td>
                    <td>{{$data->created_at}}</td>
                    <td>{{$data->upline_firstname}}</td>
                    <td>{{$data->created_at}}</td>
                    <td>
                    <a href="{{route('users.edit',$data->id)}}" class="btn btn-primary btn-sm float-left mr-1" style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" title="edit" data-placement="bottom"><i class="fas fa-edit"></i></a>
                    <form method="POST" action="{{route('users.destroy',[$data->id])}}">
                      @csrf
                      @method('delete')
                          <button class="btn btn-danger btn-sm dltBtn" data-id={{$data->id}} style="height:30px; width:30px;border-radius:50%" data-toggle="tooltip" data-placement="bottom" title="Delete"><i class="fas fa-trash-alt"></i></button>
                        </form>
                    </td>
                </tr>
            @endforeach
          </tbody>
        </table>
        @else
          <h6 class="text-center">No IB found!!! Please create IB</h6>
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
                    "targets":[3,4,5]
                }
            ]
        } );

        // Sweet alert

        function deleteData(id){

        }
  </script>
  <script>
      $(document).ready(function(){

        $("#exportBtn").on('click', function(e) {
            e.preventDefault();
            window.open('{!! "users/export/".$query_string !!}', '_blank');
        });

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
