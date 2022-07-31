@extends('layouts.layout')

@section('title', 'Order Details')
@section('content')
<br />
<br />
<br />
<div class="container-fluid text-center p-5">
    <div class="row pt-4">
        <div class="col-md-12 p-3">
            <div class="row text-dark">
                <h1 class="text-uppercase">Order#{{ $order->id }}</h1>
            </div>
            <div id="message" class="p-2 m-2 rounded"></div>
            <div class="row">
                <div class="container-fluid shadow m-2 p-3 bg-body rounded p-5">
                    <div>
                        <table class="table table-hover" id="orders">
                            <thead>
                                <tr class="table-warning text-uppercase">
                                <th scope="col">name</th>
                                <th scope="col">date</th>
                                <th scope="col">time</th>
                                <th scope="col">status</th>
                                <th scope="col">discount</th>
                                </tr>
                            </thead>
                            <tbody>                                
                                <tr>
                                    <td>{{ $order->customer->name }}</td>
                                    <td>{{ $order->date }}</td>
                                    <td>
                                        {{ $order->time }}
                                    </td>
                                    <td>
                                        {{ $order->status }}
                                    </td>
                                    <td>{{ $order->discount }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="container-fluid shadow m-2 p-3 bg-body rounded p-5">
                    <div>
                        <table class="table table-hover" id="items-ordered">
                            <thead>
                                <tr class="table-warning text-uppercase">
                                <th scope="col">item#</th>
                                <th scope="col">name</th>
                                <th scope="col">price</th>
                                </tr>
                            </thead>
                            <tbody>  
                                @php
                                    $i = 0
                                @endphp                             
                                @foreach($items as $item)
                                    <tr>
                                        <td>{{ $item->id }}</td>
                                        <td>{{ $item_details[$i]->name }}</td>
                                        <td>{{ $item_details[$i]->unit_price }}</td>
                                    </tr>
                                    @php
                                        $i++
                                    @endphp  
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection