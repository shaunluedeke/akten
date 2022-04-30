<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rangs;
use Illuminate\Http\Request;

class RangController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth',['password.confirm']);
    }

    public function index()
    {
        return view('admin.rang.index', ["rangs"=>Rangs::all()]);
    }

    public function create()
    {
        return view('admin.rang.create');
    }

    public function store(Request $request)
    {
        Rangs::create($request->all());
        return redirect()->route('rang.index');
    }

    public function edit(Rangs $rang)
    {
        return view('admin.rang.edit', ["rang"=>$rang]);
    }

    public function update(Request $request, Rangs $rang)
    {
        $rang->update($request->all());
        return redirect()->route('rang.index');
    }

    public function destroy(Rangs $rang)
    {
        $rang->delete();
        return redirect()->route('rang.index');
    }
}
