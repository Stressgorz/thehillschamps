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
    <h6 class="m-0 font-weight-bold text-primary float-left">Points History</h6>


  </div>
  <div class="col-md-12">
    <div class="card">
      <div class="card-body mt-4 ml-2">
        <div class="table-responsive">
          @if(count($table_data)>0)
          <table class="table table-bordered" id="banner-dataTable" width="100%" cellspacing="0">
            <thead>
              <tr>
                <th>Previous Amount</th>
                <th>Amounts</th>
                <th>Balance</th>
                <th>Description</th>
                <th>Created Date</th>
              </tr>
            </thead>
            <tbody>

              @foreach($table_data as $data)
              @php
              @endphp
              <tr>
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
          <h6 class="text-center">No Points History found!!!</h6>
          @endif
        </div>
      </div>
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
  $('#banner-dataTable').DataTable({
    "columnDefs": [{
      "orderable": true,

    }]
  });

  // Sweet alert

  function deleteData(id) {

  }
</script>
<script>
  $(document).ready(function() {

    $("#clear_search").on('click', function(e) {
      e.preventDefault();
      window.location.href = '{{ Request::url() }}';
    });

    $.ajaxSetup({
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      }
    });
    $('.dltBtn').click(function(e) {
      var form = $(this).closest('form');
      var dataID = $(this).data('id');
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