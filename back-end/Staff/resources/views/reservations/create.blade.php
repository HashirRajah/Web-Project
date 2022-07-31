@extends('layouts.layout')

@section('title', 'Add Reservation')
@section('content')

<style>
    .container {
      max-width: 450px;
    }
    .push-top {
      margin-top: 100px;
    }
</style>

<div class="card push-top mx-5">
  <div class="card-header">
    Add Reservation
  </div>

  <div class="card-body">
    @if ($errors->any())
      <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
        </ul>
      </div><br />
    @endif
      <form method="post" action="{{ route('reservations.store') }}">
        @csrf
          <div class="form-group p-2">
              <label for="customer">Customer</label>
              <a class="btn btn-outline-success" href="/customers/create">Add</a>
              <select class="form-select form-select-lg mt-2" aria-label=".form-select-lg example" name="customer_id" id="customer">
                @foreach($customers as $customer)
                  <option value="{{ $customer->id }}">{{ $customer->id }} - {{ $customer->name }}</option>
                @endforeach
              </select>
          </div>
          <div class="form-group p-2">
              <label for="renter_email">Date</label>
              <input type="date" class="form-control" name="date" value="{{ old('date') }}"/>
          </div>
          <div class="form-group p-2">
              <label for="renter_phone">Time_slot</label>
              <input type="tel" class="form-control" name="time_slot" value="{{ old('time_slot') }}"/>
          </div>
          <div class="form-group p-2">
              <label for="username">Number of people</label>
              <input type="number" class="form-control" name="number_of_people" value="{{ old('number_of_people') }}"/>
              <input type="hidden" class="form-control" name="status" value="pending"/>
          </div>
          <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-block btn-danger m-3 p-2">Create Reservation</button>
        </div>
      </form>
  </div>
</div>
@endsection