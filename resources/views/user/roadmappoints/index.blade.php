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
            <div class="col-md-3">
                <div class="card shadow mb-4" style="width: 18rem;">
                <img class="card-img-top" src="{{ asset('storage/'.$path.'/'.$positions->step1_img) }}" style = 'height:300px'  alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Step 1: {{$positions->step1_name}}</h5>
                    <p class="card-text">Points: {{$positions->step1}}</p>
                </div>
                </div>
            </div>
            <div class="col-md-3">
            <div class="card shadow mb-4" style="width: 18rem;">
                <img class="card-img-top" src="{{ asset('storage/'.$path.'/'.$positions->step2_img) }}" style = 'height:300px'  alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Step 2: {{$positions->step2_name}}</h5>
                    <p class="card-text">Points: {{$positions->step2}}</p>
                </div>
                </div>
            </div>
            <div class="col-md-3">
            <div class="card shadow mb-4" style="width: 18rem;">
                <img class="card-img-top" src="{{ asset('storage/'.$path.'/'.$positions->step3_img) }}"  style = 'height:300px' alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Step 3: {{$positions->step3_name}}</h5>
                    <p class="card-text">Points: {{$positions->step3}}</p>
                </div>
                </div>
            </div>
        </div>
        <div class="row justify-content-center">
            <div class="col-md-3">
            <div class="card shadow mb-4" style="width: 18rem;">
                <img class="card-img-top" src="{{ asset('storage/'.$path.'/'.$positions->step4_img) }}" style = 'height:300px'  alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Step 4: {{$positions->step4_name}}</h5>
                    <p class="card-text">Points: {{$positions->step4}}</p>
                </div>
                </div>
            </div>
            <div class="col-md-3">
            <div class="card shadow mb-4" style="width: 18rem;">
                <img class="card-img-top" src="{{ asset('storage/'.$path.'/'.$positions->step5_img) }}"  style = 'height:300px' alt="Card image cap">
                <div class="card-body">
                    <h5 class="card-title">Step 5: {{$positions->step5_name}}</h5>
                    <p class="card-text">Points: {{$positions->step5}}</p>
                </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="card">
            <div class="card-body">
                <div class="row justify-content-center">
                    <h5>Current Rank: {{$data['current_rank']}}</h5>
                </div>
                <div class="row justify-content-center">
                    <div class='col-12 col-md-4'>
                        <div class='d-flex justify-content-between'>
                            <p>Current Points: {{$user_point}}</p>
                            <p>Next Rank points: {{$data['rank_next_points']}}</p>
                        </div>
                        <div class="progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated bg-danger" role="progressbar" aria-valuenow="{{$data['percentage_to_next_rank']}}" aria-valuemin="0" aria-valuemax="100" style="width: {{$data['percentage_to_next_rank'].'%'}}"></div>
                        </div>
                            </br>
                        <div class='d-flex justify-content-center'>
                            <p>Remaining to next rank: {{$data['points_to_next_rank']}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>  
   </div>
</div>

@endsection

<style>
    .breadcrumbs{
        list-style: none;
    }
    .breadcrumbs li{
        float:left;
        margin-right:10px;
    }
    .breadcrumbs li a:hover{
        text-decoration: none;
    }
    .breadcrumbs li .active{
        color:red;
    }
    .breadcrumbs li+li:before{
      content:"/\00a0";
    }
    .image{
        background:url('{{asset('backend/img/background.jpg')}}');
        height:150px;
        background-position:center;
        background-attachment:cover;
        position: relative;
    }
    .image img{
        position: absolute;
        top:55%;
        left:35%;
        margin-top:30%;
    }
    i{
        font-size: 14px;
        padding-right:8px;
    }
  </style> 

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
</script>
@endpush