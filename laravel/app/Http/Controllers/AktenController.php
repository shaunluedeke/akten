<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Akten;
use Illuminate\Support\Facades\Auth;

class AktenController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $fracid = Auth::user()->fraction()->first()->id;
        if($fracid !== 1 ){
            $akten = Akten::where('fraction_id',$fracid)->get();
        }else{
            $akten = Akten::all();
        }
        return view('akten.index',compact('akten'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('akten.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = [
            "gb" => $request->input('birthsday',date('Y-m-d')),
            "number" => $request->input('number','555'),
            "date" => $request->input('date',''),
            "straftat" => $request->input('straftat',''),
            "aufklaerung" => $request->input('aufklaerung',''),
            "urteil" => $request->input('urteil','')
        ];
        try {
            $akte = akten::create([
                "name" => $request->input('name'),
                "fraction_id" => Auth::user()->fraction()->first()->id,
                "user_id" => Auth::user()->id,
                "data" => json_encode($data, JSON_THROW_ON_ERROR)]);

            return redirect()->route('akten.show',$akte->id);
        } catch (\JsonException $e) {
        }
        return redirect()->route('akten.create');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(akten $akten)
    {
        return view('akten.show',compact('akten'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(akten $akten)
    {
        return view('akten.edit',compact('akten'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, akten $akten)
    {
        $data = [
            "gb" => $request->input('birthsday',date('Y-m-d')),
            "number" => $request->input('number','555'),
            "date" => $request->input('date',''),
            "straftat" => $request->input('straftat',''),
            "aufklaerung" => $request->input('aufklaerung',''),
            "urteil" => $request->input('urteil','')
        ];
        try {

            $akten->name = $request->input('name');
            $akten->data = json_encode($data, JSON_THROW_ON_ERROR);
            $akten->user_id = Auth::user()->id;
            $akten->fraction_id = Auth::user()->fraction()->first()->id;

            $akten->update();

            return redirect()->route('akten.show',$akten->id);
        } catch (\JsonException $e) {
        }
        return redirect()->route('akten.edit',$akten->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(akten $akte)
    {
        $akte->delete();
        return redirect()->route('akten.index');
    }
}
