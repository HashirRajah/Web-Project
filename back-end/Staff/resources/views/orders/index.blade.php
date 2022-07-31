@extends('layouts.layout')

@section('title', 'Orders')
@section('content')
<br />
<br />
<br />
<div class="container-fluid text-center p-5">
    <div class="row pt-4">
        <div class="col-md-12 p-3">
            <div class="row text-dark">
                <h1 class="text-uppercase">Orders</h1>
            </div>
            @if(session()->get('success'))
                <div id="message" class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            <div class="row">
                <div class="container-fluid shadow m-2 p-3 bg-body rounded p-5">
                    <div>
                        <table class="table table-hover" id="orders">
                            <thead>
                                <tr class="table-warning text-uppercase">
                                <th scope="col">order#</th>
                                <th scope="col">name</th>
                                <th scope="col">date</th>
                                <th scope="col">time</th>
                                <th scope="col">discount</th>
                                <th scope="col">status</th>
                                <th scope="col">order-details</th>
                                <th scope="col">payment-details</th>
                                <th class="" scope="col">complete-order</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr>
                                        <td>{{ $order->id }}</td>
                                        <td>{{ $order->customer->name }}</td>
                                        <td>
                                            {{ $order->date }}
                                        </td>
                                        <td>
                                            {{ $order->time }}
                                        </td>
                                        <td>{{ $order->discount }}</td>
                                        <td>{{ $order->status }}</td>
                                        <td>
                                            <a href="/order-details/{{ $order->id }}"><img src="/images/plus.png" alt="+"></a>
                                        </td>
                                        <td>
                                            <a href="/payments/{{ $order->id }}"><img src="/images/plus.png" alt="+"></a>
                                        </td>
                                        <td>
                                            <form action="/orders/{{ $order->id }}" method="POST" >
                                                @csrf
                                                @method('PATCH')
                                                <input type="submit" class="btn btn-outline-success" value="complete">
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {!! $orders->links() !!}
                    </div>
                    @if(count($orders) < 0)
                        <div class="bg-info" >No Orders</div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection