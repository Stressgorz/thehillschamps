@extends('user.layouts.master')

@section('title','Admin Profile')

@section('main-content')

<div class="card shadow mb-4">
    <div class="row">
        <div class="col-md-12">
           @include('user.layouts.notification')
        </div>
    </div>
   <div class="card-header py-3">
     <h4 class=" font-weight-bold">Profile</h4>
     <a href="{{route('user-profile-update-page', $profile->id)}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="edit Profile"><i class="fas fa-plus"></i> Edit Profile</a>
   </div>
   <div class="card-body">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="image">
                        @if($profile->photo)    
                        <img class="card-img-top img-fluid roundend-circle" style="border-radius:50%;height:100px;width:100px;margin:auto;" src="{{asset('storage/'.$path.$profile->photo)}}" alt="profile picture">
                        @else 
                        <img class="card-img-top img-fluid roundend-circle" style="border-radius:50%;height:100px;width:100px;margin:auto;" src="{{asset('backend/img/avatar.png')}}" alt="profile picture">
                        @endif
                    </div>
                    <div class="card-body mt-4 ml-2">
                      <h5 class="card-title text-left"><small>Full Name: {{$profile->firstname.' '.$profile->lastname}}</small></h5>
                      <h5 class="card-title text-left"><small>IB Code: {{$profile->code}}</small></h5>
                      <h5 class="card-title text-left"><small>Email: {{$profile->email}}</small></h5>
                      <h5 class="card-title text-left"><small>Tel No: {{$profile->phone}}</small></h5>
                      <h5 class="card-title text-left"><small>DOB: {{$profile->dob}}</small></h5>
                      <h5 class="card-title text-left"><small>Team: {{$profile->team->name}}</small></h5>
                      <h5 class="card-title text-left"><small>Position: {{$profile->position->name}}</small></h5>
                      <h5 class="card-title text-left"><small>No of Client: {{$total_clients}}</small></h5>
                      <h5 class="card-title text-left"><small>Remaining to reach Next Rank  : {{$profile->code}}</small></h5>
                    </div>
                  </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header py-3">
                        <div class="row">
                            <div class='col-6'>
                            <h2>Personal Target</h2>
                            </div>
                            <div class='col-6'>
                            <a href="{{route('targets.create', $profile->id)}}" class="btn btn-primary btn-sm float-right" data-toggle="tooltip" data-placement="bottom" title="edit Profile"><i class="fas fa-plus"></i> Add Target</a>
                                </div>
                        </div>
                    </div>

                    <div class="card-body mt-4 ml-2">
                        @php 
                            $no = 0;
                        @endphp
                        @foreach($user_target as $target)
                            <div class="row justify-content-center">
                                @php 
                                    $no++;
                                @endphp
                                <h2>{{$no.': '.$target->target}}</h2>
                            </div>
                        @endforeach
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