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
   </div>
   <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <form class="border px-4 pt-2 pb-3" method="POST" action="{{route('user-profile-update',$profile->id)}}">
                    @csrf
                    <div class="form-group">
                        <label for="inputTitle" class="col-form-label">Birth Date</label>
                      <input id="inputTitle" type="date" name="dob" placeholder="Enter Birth Date"  value="{{$profile->dob}}" class="form-control">
                      @error('dob')
                      <span class="text-danger">{{$message}}</span>
                      @enderror
                      </div>
              
                      <div class="form-group">
                          <label for="inputEmail" class="col-form-label">Code</label>
                        <input id="inputEmail" name="code" placeholder="Enter code"  value="{{$profile->code}}" class="form-control">
                        @error('code')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>

                      <div class="form-group">
                          <label for="inputEmail" class="col-form-label">First Name</label>
                        <input id="inputEmail" name="firstname" placeholder="Enter firstname"  value="{{$profile->firstname}}" class="form-control">
                        @error('firstname')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>

                      <div class="form-group">
                          <label for="inputEmail" class="col-form-label">Last Name</label>
                        <input id="inputEmail" name="lastname" placeholder="Enter lastname"  value="{{$profile->lastname}}" class="form-control">
                        @error('lastname')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>

                      <div class="form-group">
                          <label for="inputEmail" class="col-form-label">Phone</label>
                        <input id="inputEmail" name="phone" placeholder="Enter phone"  value="{{$profile->phone}}" class="form-control">
                        @error('phone')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>

                      <div class="form-group">
                          <label for="inputEmail" class="col-form-label">Upline</label>
                        <input id="inputEmail" name="upline_email" placeholder="Enter upline_email"  value="{{$upline_email ?? ''}}" class="form-control">
                        @error('upline_email')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>
              
                      <div class="form-group">
                      <label for="inputPhoto" class="col-form-label">Photo</label>  
                      <div class="input-group">
                        <input type="file" name="photo" class="form-control" value = "{{$profile->photo}}">
                      </div>
                        @error('photo')
                        <span class="text-danger">{{$message}}</span>
                        @enderror
                      </div>
                        <button type="submit" class="btn btn-success btn-sm">Update</button>
                </form>
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
