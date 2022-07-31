@extends('layouts.layout')

@section('title', 'Add Customer')
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
    Add Customer
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
      <form method="post" action="{{ route('customers.store') }}">
          <div class="form-group p-2">
          <label for="renter_email">Name</label>
              <input type="text" class="form-control" name="date" value="{{ old('date') }}"/>
          </div>
          <div class="form-group p-2">
              <label for="renter_email">Username</label>
              <input type="text" class="form-control" name="date" value="{{ old('date') }}"/>
          </div>
          <div class="form-group p-2">
              <label for="renter_phone">Email</label>
              <input type="tel" class="form-control" name="Time_slot" value="{{ old('time_slot') }}"/>
          </div>
          <div class="form-group p-2">
              <label for="username">Phone Number</label>
              <input type="number" class="form-control" name="number" value="{{ old('number') }}"/>
          </div>
          <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-block btn-danger m-3 p-2">Create Customer</button>
        </div>
      </form>
  </div>
</div>
@endsection