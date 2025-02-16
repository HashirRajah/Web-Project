<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//
use App\Models\Reservation;
use App\Models\Customer;

class ReservationController extends Controller
{
    public function __construct(){
        $this->middleware("auth");
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $reservations = Reservation::where("status", "pending")->orderBy('date')->paginate(1);
        //
        return view("reservations.index", ["reservations" => $reservations]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $customers = Customer::all();
        //
        return view("reservations.create", ["customers" => $customers]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $storeData = $request->validate([
            'customer_id' => 'required|numeric',
            'date' => 'required|date',
            'number_of_people' => 'required|numeric',
            'time_slot' => 'required|date_format:H:i',
            'status' => 'required|max:255',
        ]);
        $reservation = Reservation::create($storeData);

        return redirect('/reservations')->with('success', 'Reservation has been added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        //
        $reservation->status = "completed";
        //
        $reservation->save();
        //
        return redirect('/reservations')->with('success', 'Reservation completed!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        //
        $reservation->delete();
        //
        return redirect('/reservations')->with('success', 'Reservation removed!');
    }
}
