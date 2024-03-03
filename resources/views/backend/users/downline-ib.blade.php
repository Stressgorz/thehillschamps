@extends('backend.layouts.master')
<style>
    /*----------------genealogy-scroll----------*/

    .genealogy-scroll::-webkit-scrollbar {
        width: 5px;
        height: 8px;
    }

    .genealogy-scroll::-webkit-scrollbar-track {
        border-radius: 10px;
        background-color: #e4e4e4;
    }

    .genealogy-scroll::-webkit-scrollbar-thumb {
        background: #212121;
        border-radius: 10px;
        transition: 0.5s;
    }

    .genealogy-scroll::-webkit-scrollbar-thumb:hover {
        background: #d5b14c;
        transition: 0.5s;
    }

    /*----------------genealogy-tree----------*/
    .genealogy-body {
        white-space: nowrap;
        overflow-y: hidden;
        min-height: 500px;
        padding-top: 10px;
        text-align: center;
    }

    .genealogy-tree {
        display: inline-block;
    }

    .genealogy-tree ul {
        padding-top: 20px;
        position: relative;
        padding-left: 0px;
        display: flex;
        justify-content: center;
    }

    .genealogy-tree li {
        float: left;
        text-align: center;
        list-style-type: none;
        position: relative;
        padding: 20px 20px 0 20px;
    }

    .genealogy-tree li::before,
    .genealogy-tree li::after {
        content: "";
        position: absolute;
        top: 0;
        right: 50%;
        border-top: 2px solid #ccc;
        width: 50%;
        height: 18px;
    }

    .genealogy-tree li::after {
        right: auto;
        left: 50%;
        border-left: 2px solid #ccc;
    }

    .genealogy-tree li:only-child::after,
    .genealogy-tree li:only-child::before {
        display: none;
    }

    .genealogy-tree li:only-child {
        padding-top: 0;
    }

    .genealogy-tree li:first-child::before,
    .genealogy-tree li:last-child::after {
        border: 0 none;
    }

    .genealogy-tree li:last-child::before {
        border-right: 2px solid #ccc;
        border-radius: 0 5px 0 0;
        -webkit-border-radius: 0 5px 0 0;
        -moz-border-radius: 0 5px 0 0;
    }

    .genealogy-tree li:first-child::after {
        border-radius: 5px 0 0 0;
        -webkit-border-radius: 5px 0 0 0;
        -moz-border-radius: 5px 0 0 0;
    }

    .genealogy-tree ul ul::before {
        content: "";
        position: absolute;
        top: 0;
        left: 50%;
        border-left: 2px solid #ccc;
        width: 0;
        height: 20px;
    }

    .genealogy-tree li a {
        text-decoration: none;
        color: #1dd5ea;
        font-family: arial, verdana, tahoma;
        font-size: 11px;
        display: inline-block;
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
    }

    .genealogy-tree li div {
        text-decoration: none;
        font-family: arial, verdana, tahoma;
        font-size: 11px;
        display: inline-block;
        border-radius: 5px;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
    }


    .genealogy-tree li a:hover+ul li::after,
    .genealogy-tree li a:hover+ul li::before,
    .genealogy-tree li a:hover+ul::before,
    .genealogy-tree li a:hover+ul ul::before {
        border-color: #fbba00;
    }

    /*--------------memeber-card-design----------*/
    .member-view-box {
        padding: 0px 20px;
        text-align: center;
        border-radius: 4px;
        position: relative;
    }

    .member-image {
        position: relative;
    }

    .member-image img {
        width: 60px;
        height: 60px;
        border-radius: 6px;
        background-color: #000;
        z-index: 1;
    }
</style>
@section('main-content')
    <div class="">
        <div class="page-title">
            <div class="title_left">
                <h3>{{ __('Downline IB') }}</h3>
            </div>
        </div>
        <div class="clearfix"></div>

        <div class="row">
            <div class="body genealogy-body genealogy-scroll">
                <div class="genealogy-tree">
                    <ul>
                        <li>
                            <a href="javascript:void(0);">
                                <div class="member-view-box">
                                    <div class="member-image">
                                        <div class="member-details">
                                            <h3>{{ $user->firstname.' '.$user->lastname }}</h3>
                                        </div>
                                    </div>
                                </div>
                            </a>
                            <ul class="active">
                                @foreach ($data as $item)
                                    <li>
                                        @if (!empty($item['downline']))
                                            <a href="javascript:void(0);">
                                                <div class="member-view-box">
                                                    <div class="member-image">
                                                        <div class="member-details">
                                                        <a href="{{route('users.show',$item['id'])}}" ><h5> {{ $item['user'] }}</h5></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                            <ul class="active">
                                                @include('backend.users.downline-ib-table', ['downline' => $item['downline']])
                                            </ul>
                                        @else
                                            <div href="javascript:void(0);">
                                                <div class="member-view-box">
                                                    <div class="member-image">
                                                        <div class="member-details">
                                                            <a href="{{route('users.show',$item['id'])}}" ><h5> {{ $item['user'] }}</h5></a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- modals -->
@endsection

@push('body')
@endpush
