@extends('layouts.layout')

@section('title', 'Reservations')
@section('content')
<br />
<br />
<br />
<div class="container-fluid text-center p-5">
    <div class="row pt-4">
        <div class="col-md-12 p-3">
            <div class="row text-dark">
                <h1 class="text-uppercase">Reservations</h1>
            </div>
            @if(session()->get('success'))
                <div id="message" class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            <div id="" class="p-2 m-2"><a href="{{ route('reservations.create') }}" class="btn btn-success" >Add</a></div>
            <div class="row">
                <div class="container-fluid shadow m-2 p-3 bg-body rounded p-5">
                    <div>
                        <table class="table table-hover" id="orders">
                            <thead>
                                <tr class="table-warning text-uppercase">
                                <th scope="col">reserv#</th>
                                <th scope="col">name</th>
                                <th scope="col">date</th>
                                <th scope="col">time_slot</th>
                                <th scope="col">#people</th>
                                <th scope="col">status</th>
                                <th scope="col">complete</th>
                                <th scope="col">delete</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($reservations as $reservation)
                                    <tr>
                                        <td>{{ $reservation->id }}</td>
                                        <td>{{ $reservation->customer->name }}</td>
                                        <td>
                                            {{ $reservation->date }}
                                        </td>
                                        <td>
                                            {{ $reservation->time_slot }}
                                        </td>
                                        <td>
                                            {{ $reservation->number_of_people }}
                                        </td>
                                        <td>{{ $reservation->status }}</td>
                                        <td>
                                            <form action="/reservations/{{ $reservation->id }}" method="POST" >
                                                @csrf
                                                @method('PATCH')
                                                <input type="submit" class="btn btn-outline-success" name="complete-reservation" id="complete-reservation" value="complete">
                                            </form>
                                        </td>
                                        <td>
                                            <form action="/reservations/{{ $reservation->id }}" method="POST" >
                                                @csrf
                                                @method('DELETE')
                                                <input type="submit" class="btn btn-outline-danger" name="delete-reservation" id="delete-reservation" value="delete">
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {!! $reservations->links() !!}
                    </div>
                    @if(count($reservations) < 0)
                        <div class="bg-info" >No Orders</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection