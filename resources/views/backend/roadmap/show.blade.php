@extends('backend.layouts.master')

@section('main-content')
<div class="card">
    <h5 class="card-header">Roadmap Detail</h5>
    <div class="card-body">
        <table class="table table-bordered">
            <tr>
                <th>Rank</th>
                <td>{{$roadmap->position->name ?? ''}}</td>
            </tr>
            <tr>
                <th>Amount</th>
                <td>{{$roadmap->usd_amount}}</td>
            </tr>
            <tr>
                <th>Date</th>
                <td>{{$roadmap->date}}</td>
            </tr>
            <tr>
                <th>Created At</th>
                <td>{{$roadmap->created_at}}</td>
            </tr>
            <tr>
                <th>Updated At</th>
                <td>{{$roadmap->updated_at}}</td>
            </tr>
        </table>
        <a href="{{route('roadmap.index')}}" class="btn btn-primary">Back</a>
    </div>
</div>
@endsection
