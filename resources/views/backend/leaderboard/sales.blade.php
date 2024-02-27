@extends('backend.layouts.master')

@section('main-content')
<section id="content" class="container pt-0">
        <div class="card one">
            <div class="header d-flex justify-content-between">
                <h3 class="title text-center">LEADERBOARD (SALES)</h3>
                @if($data_type == 'team')
                <a href="{{route('admin-get-leaderboard-sale', 'user')}}" class="btn btn-leader">USER</a>
                @elseif($data_type == 'user')
                <a href="{{route('admin-get-leaderboard-sale', 'team')}}" class="btn btn-leader">TEAM</a>
                @endif
            </div>
            <div class="sort">
                <ul class="nav nav-tabs " role="tablist">
                    <li class="nav-item" role="presentation">
                    <a class="btn btn-leaderboard" href="{{route('admin-get-leaderboard-sale', $data_type.'?type=month')}}">Monthly</a>
                    </li>
                    <li class="nav-item" role="presentation">
                    <a class="btn btn-leaderboard" href="{{route('admin-get-leaderboard-sale', $data_type.'?type=year')}}">Yearly</a>
                    </li>
                </ul>
            </div>
            @if($type == 'month')
            <div class="sort">
                <ul class="nav nav-tabs " role="tablist">
                    @foreach(Helper::$month as $month)
                    <li class="nav-item" role="presentation">
                    <a class="btn btn-leaderboard" href="{{route('admin-get-leaderboard-sale', $data_type.'?type=month&month='.$month)}}">{{$month}}</a>    
                    </li>
                    @endforeach
                </ul>
            </div>
            @elseif($type == 'year')
            <div class="sort">
                <ul class="nav nav-tabs " role="tablist">
                    @foreach(Helper::$year as $year)
                    <li class="nav-item" role="presentation">
                    <a class="btn btn-leaderboard" href="{{route('admin-get-leaderboard-sale', $data_type.'?type=year&year='.$year,)}}">{{$year}}</a>    
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
            <div class="tab-content text-center" id="learn-tab">
                <div class="tab-pane fade show active">
                    <div class="profile">
                            <div class="person second">
                                <div class="num">2</div>
                                <i class="fa fa-caret-square-o-up"></i>
                                @if(isset($leaderboard['second']->photo))
                                <img src="{{asset($photo.$leaderboard['second']->photo)}}" alt="" class="photo">
                                @else
                                <img src="{{asset('storage/avatar/avatar.png')}}" alt="" class="photo">
                                @endif
                                <p class="link">{{$leaderboard['second']->name ?? ''}} {{$leaderboard['second']->lastname ?? ''}}</p>
                                <p class="points">{{$leaderboard['second']->total_amount ?? ''}}</p>
                                <p class="link">{{$leaderboard['second']->position_name ?? ''}}</p>
                            </div>

                            <div class="person first">
                                <div class="num">1</div>
                                <i class="fas fa-crown"></i>
                                @if(isset($leaderboard['first']->photo))
                                <img src="{{asset($photo.$leaderboard['first']->photo)}}" alt="" class="photo">
                                @else
                                <img src="{{asset('storage/avatar/avatar.png')}}" alt="" class="photo">
                                @endif
                                <p class="link">{{$leaderboard['first']->name ?? ''}} {{$leaderboard['first']->lastname ?? ''}}</p>
                                <p class="points">{{$leaderboard['first']->total_amount ?? ''}}</p>
                                <p class="link">{{$leaderboard['first']->position_name ?? ''}}</p>
                            </div>

                            <div class="person third">
                                <div class="num">3</div>
                                <i class="fa fa-caret-square-o-up"></i>
                                @if(isset($leaderboard['third']->photo))
                                <img src="{{asset($photo.$leaderboard['third']->photo)}}" alt="" class="photo">
                                @else
                                <img src="{{asset('storage/avatar/avatar.png')}}" alt="" class="photo">
                                @endif
                                <p class="link">{{$leaderboard['third']->name ?? ''}} {{$leaderboard['third']->lastname ?? ''}}</p>
                                <p class="points">{{$leaderboard['third']->total_amount ?? ''}}</p>
                                <p class="link">{{$leaderboard['third']->position_name ?? ''}}</p>
                            </div>
                    </div>
                </div>
            </div>
            @php
            $count = 4
            @endphp
            @foreach($leaderboard['rest'] as $rest)
                <div class="rest">
                    <div class="others flex">
                        <div class="rank">
                            <p class="num">{{$count ++}}</p>
                        </div>
                        <div class="info flex">
                                @if(isset($rest->photo))
                                <img src="{{asset($photo.$rest->photo)}}" alt="" class="p_img" style='height:50px;width:50px'>
                                @else
                                <img src="{{asset('storage/avatar/avatar.png')}}" alt="" class="p_img" style='height:50px;width:50px'>
                                @endif
                            <p class="link">{{$rest->name ?? ''}} {{$rest->lastname ?? ''}}</p>
                            <p class="points">{{$rest->total_amount ?? ''}}</p>
                            <p class="link">{{$rest->position_name ?? ''}}</p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@push('styles')
<link rel="stylesheet" href="{{asset('frontend/css/leaderboard.css')}}">
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
@endpush
