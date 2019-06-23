<?php

namespace App\Http\Controllers;

use App\Models\Guest;
use Illuminate\Http\Request;
use Validator;

class GuestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($type)
    {
        $guests = Guest::all();

        if($type == 'backend'){
            return view('guest.backend', compact('guests'));
        }
        return view('guest.frontend');
    }

    /**
     * Return lists of guests for Vue Component
     *
     * @return Collection
     */
    public function list()
    {
        $guests = Guest::all();

        return response()->json($guests);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('guest.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $type)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'gender' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            if($type == 'backend'){
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        $guest = Guest::create($request->all());

        if($type == 'backend'){
            return redirect()->route('guests', 'backend')->with('success', "Guest Added Successfully!");
        }

        return response()->json($guest);
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
    public function edit(Guest $guest)
    {
        return view('guest.edit', compact('guest'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Guest $guest, $type)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'gender' => 'required',
            'address' => 'required',
        ]);

        if ($validator->fails()) {
            if ($type == 'backend') {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }
        }

        $guest->update($request->all());

        if ($type == 'backend') {
            return redirect()->route('guests', 'backend')->with('success', "Guest Updated Successfully!");
        }

        return response()->json("Guest Updated Successfully!", 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Guest $guest)
    {
        $guest->delete();
        return response()->json("Guest Deleted Successfully!", 200);
    }
}
