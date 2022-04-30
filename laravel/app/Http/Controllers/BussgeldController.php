<?php

namespace App\Http\Controllers;

use App\Models\bussgeld;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BussgeldController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $fracid = Auth::user()->fraction()->first()->id;
        if($fracid !==  1 ){
            $bussgelder = bussgeld::where('fraction_id',$fracid)->get();
        }else{
            $bussgelder = bussgeld::all();
        }
        return view('bussgeld.index',['bussgelder'=>$bussgelder,'fracid'=>$fracid]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('bussgeld.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        bussgeld::create($request->all());
        return view('bussgeld.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(bussgeld $bussgeld)
    {
        $bussgeld->delete();
        return redirect()->route('bussgeld.index');
    }
}
