@extends('user.layouts.master')

@section('main-content')

<div class="card shadow mb-4">
    <div class="row">
        <div class="col-md-12">
           @include('user.layouts.notification')
        </div>
    </div>
   <div class="card-header py-3">
        <h4 class=" font-weight-bold">Road Map Points</h4>
   </div>
   <div class="card-body">
        <div class="card shadow mb-4">
            <div class="card-body">
                <div class="row justify-content-center">
                    <div class='col-12 col-md-4'>
                        <div class='d-flex justify-content-between'>
                            <p>Current Points: {{$user_point}}</p>
                            <p>Next Rank points: {{$data['kpi_points']}}</p>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-warning" role="progressbar" aria-valuenow="{{$data['percentage_to_next_step']}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$data['percentage_to_next_step'].'%'}}"></div>
                        </div>
                            </br>
                        <div class='d-flex justify-content-center'>
                            <p>Remaining to {{$data['kpi_name']}}: {{$data['points_to_next_step']}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
        <div class="row justify-content-center">
            @foreach($position_step as $positionstep)
            <div class="col-md-4">
                <div class="row justify-content-center">
                    <div class="card shadow mb-4" style="width: 18rem;">
                        <img class="card-img-top" src="{{ asset('storage/'.$path.'/'.$positionstep->image) }}" style = 'height:300px'  alt="Card image cap">
                        <div class="card-body">
                            <h5 class="card-title">Step {{$positionstep->sort}}: {{$positionstep->name}}</h5>
                            <p class="card-text">Points: {{$positionstep->amount}}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        <hr>
   </div>
</div>

@endsection


@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
</script>
@endpush