@extends('backend.layouts.master')

@section('main-content')
 <div class="card shadow mb-4">
     <div class="row">
         <div class="col-md-12">
            @include('backend.layouts.notification')
         </div>
     </div>
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary float-left">Roadmap Lists</h6>
      <a href="{{route('roadmap.create')}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="Add Roadmap"><i class="fas fa-plus"></i> Add Roadmap</a>
    </div>
    <div class="card-header py-3">
      <form class="form-horizontal">
        <div class="form-group row">
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label class="control-label">Rank</label>
                <div class="form-group">
                  <select name="position_id" class="form-control">
                  <option value=''>Select Rank</option>
                      @foreach($positions as $position)
                          <option value='{{$position->id}}' {{(($position->id==Request::get('position_id')) ? 'selected' : '')}}>{{$position->name}}</option>
                      @endforeach
                  </select>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label class="control-label">From Date</label>
                <div class='input-group date datepicker'>
                    <input type='date' class="form-control" name="fdate" value="{{ Request::get('fdate') }}"/>
                </div>
            </div>
            <div class="col-md-3 col-sm-3 col-xs-12">
                <label class="control-label">To Date</label>
                <div class='input-group date datepicker'>
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
              <th>Rank</th>
              <th>Amount</th>
              <th>Date</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
            @foreach($table_data as $data)
                <tr>
                    <td>{{$data->position_name}}</td>
                    <td>{{$data->usd_amount}}</td>
                    <td>{{$data->date}}</td>
                    <td>
                    <a href="{{route('roadmap.show',$data->id)}}" class="btn btn-primary btn-sm float-left m-1" data-toggle="tooltip" title="view" data-placement="bottom">Show</a>
                    <a href="{{route('roadmap.edit',$data->id)}}" class="btn btn-primary btn-sm float-left m-1" data-toggle="tooltip" title="edit" data-placement="bottom">Edit</a>
                    <form method="POST" action="{{route('roadmap.destroy',[$data->id])}}">
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
          <h6 class="text-center">No Roadmap found!!! Please create Roadmap</h6>
        @endif
      </div>
    </div>
</div>
@endsection

@push('styles')
  <link href="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.css')}}" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css" />
@endpush

@push('scripts')
  <script src="{{asset('backend/vendor/datatables/jquery.dataTables.min.js')}}"></script>
  <script src="{{asset('backend/vendor/datatables/dataTables.bootstrap4.min.js')}}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/2.1.2/sweetalert.min.js"></script>
  <script src="{{asset('backend/js/demo/datatables-demo.js')}}"></script>
  <script>
      $('#banner-dataTable').DataTable( {
            "columnDefs":[
                {
                    "orderable":true,

                }
            ]
        } );
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
