<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth', ['password.confirm']);
    }

    public function index()
    {
        if (Auth::user()->fraction()->first()->id !== 1) {
            $users = User::where('fraction_id', Auth::user()->fraction()->first()->id)->get();
        } else {
            $users = User::all();
        }
        return view('admin.user.index', ['users' => $users]);
    }


    public function create()
    {
        return view('admin.user.create', ["pw" => $this->generateRandomString(12)]);
    }


    public function store(Request $request)
    {
        $this->validator($request->all())->validate();
        User::create([
            'name' => $request->input("name", "root"),
            'email' => $request->input("email", "root@gmail.com"),
            'password' => Hash::make($request->input("password", $this->generateRandomString(12))),
            'fraction_id' => $request->input("fraction_id", 1),
            'rang_id' => $request->input("rang_id", 1),
        ]);
        return redirect()->route('user.index');
    }


    public function edit(User $user)
    {
        return view('admin.user.edit', ['user' => $user]);
    }

    public function update(Request $request, User $user)
    {
        $this->validator($request->all())->validate();
        $user->name = $request->input("name", "root");
        $user->email = $request->input("email", "root@gmail.com");
        $user->fraction_id = $request->input("fraction_id", 1);
        $user->rang_id = $request->input("rang_id", 1);

        $user->update();
        return redirect()->route('user.index');
    }

    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('user.index');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);
    }

    private function generateRandomString(int $length = 10): string
    {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            try {
                $randomString .= $characters[random_int(0, $charactersLength - 1)];
            } catch (\Exception $e) {
            }
        }
        return $randomString;
    }
}
