<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\FileController;
use App\Models\fractions;
use Illuminate\Http\Request;

class FraktionController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',['password.confirm']);
    }

    public function index()
    {
        return view('admin.fraktion.index', ['fraktionen' => fractions::all()]);
    }

    public function create()
    {
        return view('admin.fraktion.create');
    }

    public function store(Request $request)
    {
        $frac = fractions::create($request->all());
        new FileController($frac->id);
        return redirect()->route('fraktion.show', $frac->id);
    }

    public function show(fractions $fraktion)
    {
        return view('admin.fraktion.show', ['fraktion' => $fraktion]);
    }

    public function edit(fractions $fraktion)
    {
        return view('admin.fraktion.edit', ['fraktion' => $fraktion]);
    }

    public function update(Request $request, fractions $fraktion)
    {
        foreach ($request->all() as $key => $value) {
            if (str_contains($key, 'file')) {
                $fraktion->file()->writekey($key, $value);
            }
        }
        $fraktion->name = $request->input('name', $fraktion->name);
        $fraktion->update();
        return redirect()->route('fraktion.show', $fraktion->id);
    }

    public function destroy(fractions $fraktion)
    {
        $fraktion->delete();
        return redirect()->route('admin.fraktion.index');
    }
}
