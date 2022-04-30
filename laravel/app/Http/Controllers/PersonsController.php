<?php

namespace App\Http\Controllers;

use App\Models\persons;
use Illuminate\Http\Request;

class PersonsController extends Controller
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
        return view('persons.index',["persons" =>persons::all()]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('persons.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = ["number" => $request->input('number',"555"),
            "address" => $request->input('address',""),
            "fraction" => $request->input('fraction',""),
            "license" => $request->input('license',""),
            "notizen" => $request->input('notizen',""),
            "wanted" => ""];

        try{
            $person = persons::create([
                'name' => $request->input('name',""),
                'data' => json_encode($data, JSON_THROW_ON_ERROR),
                'birthday' => $request->input('birthday',""),
                'isalive' => true,
                'iswanted' => false
            ]);
            return redirect()->route('persons.show',$person->id)->with('success','Person added successfully');
        }catch (\JsonException $e){
            return redirect()->route('persons.create')->with('error', 'Fehler beim Speichern');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(persons $person)
    {
        return view('persons.show',["person" => $person]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(persons $person)
    {
        return view('persons.edit',["person" => $person]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, persons $person)
    {
        $data = ["number" => $request->input('number',"555"),
            "address" => $request->input('address',""),
            "fraction" => $request->input('fraction',""),
            "license" => $request->input('license',""),
            "notizen" => $request->input('notizen',""),
            "wanted" => $request->input('wanted',"")];

        $person->name = $request->input('name',"");
        try {$person->data = json_encode($data, JSON_THROW_ON_ERROR);} catch (\JsonException $e) {}
        $person->birthday = $request->input('birthday',"");
        $person->isalive = $request->input('isalive',false);
        $person->iswanted = $request->input('iswanted',false);
        $person->update();
        return redirect()->route('persons.show',$person->id);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(persons $person)
    {
        $person->delete();
        return redirect()->route('persons.index');
    }
}
