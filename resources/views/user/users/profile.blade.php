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
                    <div class="row mt-5">
                        @if($profile->photo)
                        <img class="card-img-top img-fluid roundend-circle" style="border-radius:10%;height:150px;width:150px;margin:auto;" src="{{asset('storage/'.$path.$profile->photo)}}" alt="profile picture">
                        @else
                        <img class="card-img-top img-fluid roundend-circle" style="border-radius:10%;height:150px;width:150px;margin:auto;" src="{{asset('backend/img/avatar.png')}}" alt="profile picture">
                        @endif
                    </div>
                    <div class="card-body mt-4 ml-2">
                        <h5 class="card-title text-left"><small>Full Name: {{$profile->firstname.' '.$profile->lastname}}</small></h5>
                        <h5 class="card-title text-left"><small>IB Code: {{$profile->code}}</small></h5>
                        <h5 class="card-title text-left"><small>Email: {{$profile->email}}</small></h5>
                        <h5 class="card-title text-left"><small>Tel No: {{$profile->phone}}</small></h5>
                        <h5 class="card-title text-left"><small>DOB: {{$profile->dob}}</small></h5>
                        <h5 class="card-title text-left"><small>Points : {{$user_points}}</small></h5>
                        <h5 class="card-title text-left"><small>Team: {{$profile->team->name}}</small></h5>
                        <h5 class="card-title text-left"><small>Position: {{$profile->position->name}}</small></h5>
                        <h5 class="card-title text-left"><small>No of Client: {{$total_clients}}</small></h5>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header py-3">
                        <div class="row">
                            <div class='col-6'>
                                <h2>IB Sales</h2>
                            </div>
                        </div>
                        <form class="form-horizontal">
                            <div class="form-group row">
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <label class="control-label">From When</label>
                                    <div class='input-group date datepicker'>
                                        </span>
                                        <input type='date' class="form-control" name="fdate" value="{{ Request::get('fdate') }}" />
                                    </div>
                                </div>
                                <div class="col-md-3 col-sm-3 col-xs-12">
                                    <label class="control-label">To When</label>
                                    <div class='input-group date datepicker'>
                                        </span>
                                        <input type='date' class="form-control" name="tdate" value="{{ Request::get('tdate') }}" />
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
                    <div class="card-body mt-4 ml-2">
                        <div class="table-responsive">
                            <table class="table table-bordered" width="100%" cellspacing="0">
                                <thead>
                                    <tr>
                                        <th>Type of Sales</th>
                                        <th>Total Amount</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Personal Sales</td>
                                        <td>{{$all_personal_sales ?? 0}} USD</td>
                                    </tr>
                                    <tr>
                                        <td>Team Sales</td>
                                        <td>{{$direct_ib_sales ?? 0}} USD</td>
                                    </tr>
                                    <tr>
                                        <td>Group Sales</td>
                                        <td>{{$all_downline_sales ?? 0}} USD</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

<style>
    .breadcrumbs {
        list-style: none;
    }

    .breadcrumbs li {
        float: left;
        margin-right: 10px;
    }

    .breadcrumbs li a:hover {
        text-decoration: none;
    }

    .breadcrumbs li .active {
        color: red;
    }

    .breadcrumbs li+li:before {
        content: "/\00a0";
    }

    .image {
        background:url('{{asset(' backend/img/background.jpg')}}');
        height: 150px;
        background-position: center;
        background-attachment: cover;
        position: relative;
    }

    .image img {
        position: absolute;
        top: 55%;
        left: 35%;
        margin-top: 30%;
    }

    i {
        font-size: 14px;
        padding-right: 8px;
    }
</style>

@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $(document).ready(function() {

        $("#clear_search").on('click', function(e) {
            e.preventDefault();
            window.location.href = '{{ Request::url() }}';
        });

    })
    $('#lfm').filemanager('image');
</script>
@endpush