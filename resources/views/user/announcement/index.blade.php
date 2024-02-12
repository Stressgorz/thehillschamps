@extends('user.layouts.master')

@section('main-content')

<div class="card shadow mb-4">
    <div class="row">
        <div class="col-md-12">
            @include('user.layouts.notification')
        </div>
    </div>
    <div class="card-header py-3">
        <h4 class=" font-weight-bold">Announcements</h4>
    </div>
    <div class="row justify-content-between">
        <div class='col-12 col-md-6'>
            <div class="card-body">
                @foreach($data as $date => $details)
                <div class="card shadow mb-4">
                    <div class="card-body">
                        <h5>{{$date}}</h5>
                        @foreach($details as $detail)
                        <div class='d-none'>{{$newtime = strtotime($detail->date)}}</div>
                        <p>{{date('h:m',$newtime)}}
                        </p>
                        <div class="card shadow mb-4">
                            <div class="card-body">
                                <p>{{$detail->title}}</p>
                                <p>{{$detail->description}}</p>
                                <textarea readonly>{{$detail->content}}</textarea>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <div class='col-12 col-md-6'>
            <div class="card-body">
                <div id="calendar"></div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('styles')
<style>
    textarea {
        border: none;
        outline: none;
        width: 100%;
        height: 100%;
    }
</style>
@endpush
@push('scripts')
<script src="/vendor/laravel-filemanager/js/stand-alone-button.js"></script>
<script>
    $('#lfm').filemanager('image');
    $(function() {
        $('textarea').each(function() {
            $(this).height($(this).prop('scrollHeight'));
        });
    });
</script>
<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js'></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        var calendarEl = document.getElementById('calendar');
        var calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: @json($events),
            eventClick: function(info) {
                alert('Title: ' + info.event.title);
                // change the border color just for fun
                info.el.style.borderColor = 'red';
            }
        });
        calendar.render();
    });
</script>
@endpush