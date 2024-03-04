@extends('frontend.layouts.master')
@section('title','THE HILLS CHAMPS || HOME PAGE')
@section('main-content')


<!-- start top carousel --> 
<section class="small-banner section">  
    <div class="site-section site-blocks-2">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-12 text-center text-md-left">
                    @if($type == 'success')
                    <h1 class="mb-2">Thank you!</h1>
                    <div class="intro-text text-center text-md-left">
                        <p class="mb-4">Your client account on The Hills Champ has been successfully activated.</p>
                        <p class="mb-4">You may inform your introducer now.</p>
                    </div>
                    @else
                    <h1 class="mb-2">Oh no, Something is Wrong!!!</h1>
                    <div class="intro-text text-center text-md-left">
                        <p class="mb-4">Please Contact your IB for support. Thanks</p>
                    </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
</section>
<!-- end top carousel --> 

<!-- Modal end -->
@endsection
