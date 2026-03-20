@extends('backend.layouts.master')

@section('main-content')

<div class="card">
    <h5 class="card-header">Add Roadmap</h5>
    <div class="card-body">
      <form method="post" action="{{route('roadmap.store')}}">
        {{csrf_field()}}

        <div class="form-group">
          <label for="position_id" class="col-form-label">Rank <span class="text-danger">*</span></label>
          <select name="position_id" class="form-control">
              <option value=''>Select Rank</option>
              @foreach($positions as $position)
                  <option value='{{$position->id}}' {{ old('position_id') == $position->id ? 'selected' : '' }}>{{$position->name}}</option>
              @endforeach
          </select>
          @error('position_id')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="usd_amount" class="col-form-label">Amount <span class="text-danger">*</span></label>
          <input id="usd_amount" type="text" name="usd_amount" placeholder="Enter amount"  value="{{old('usd_amount')}}" class="form-control">
          @error('usd_amount')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group">
          <label for="date" class="col-form-label">Date <span class="text-danger">*</span></label>
          <input id="date" type="date" name="date" placeholder="Enter date"  value="{{old('date')}}" class="form-control">
          @error('date')
          <span class="text-danger">{{$message}}</span>
          @enderror
        </div>

        <div class="form-group mb-3">
          <button type="reset" class="btn btn-warning">Reset</button>
           <button class="btn btn-success" type="submit">Submit</button>
        </div>
      </form>
    </div>
</div>

@endsection
