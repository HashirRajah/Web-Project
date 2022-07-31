@extends('layouts.layout')

@section('title', 'Payments')
@section('content')
<br />
<br />
<br />
<div class="container-fluid text-center p-5">
    <div class="row pt-4">
        <div class="col-md-12 p-3">
            <div class="row text-dark">
                <h1 class="text-uppercase">Payments</h1>
            </div>
            <div id="message" class="p-2 m-2 rounded"></div>
            <div class="row">
                <div class="container-fluid shadow m-2 p-3 bg-body rounded p-5">
                    <div>
                        <table class="table table-hover" id="orders">
                            <thead>
                                <tr class="table-warning text-uppercase">
                                <th scope="col">payment#</th>
                                <th scope="col">order#</th>
                                <th scope="col">amount</th>
                                <th scope="col">status</th>
                                <th scope="col">date/time</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($payments as $payment)
                                    <tr>
                                        <td>{{ $payment->id }}</td>
                                        <td>{{ $payment->order->id }}</td>
                                        <td>
                                            {{ $payment->total_amount }}
                                        </td>
                                        <td>
                                            {{ $payment->status }}
                                        </td>
                                        <td>{{ $payment->payment_date_time }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!-- <div class="d-flex justify-content-center">
                    </div> -->
                    @if(count($payments) < 0)
                        <div class="bg-info" >No Payments</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection