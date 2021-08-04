<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
Use Validator;
use App\User;
use Response;
use Hash;

class AuthController extends Controller
{
    public function getLogin()
    {
        if(Auth::check()){
            return redirect()->route('dashboard');
        }
        
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        $rules = [
            'email'                 => 'required|email',
            'password'              => 'required'
        ];

        $messages = [
            'email.required'        => 'Email wajib diisi',
            'password.required'     => 'Password wajib diisi',
            'email.email'           => 'Email tidak valid'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if($validator->fails()){
            return redirect()->back()->withErrors($validator)->withInput($request->all);
        }

        $data = [
            'email'     => $request->input('email'),
            'password'  => $request->input('password'),
        ];

        Auth::attempt($data);

        if (Auth::check()) { // true sekalian session field di users nanti bisa dipanggil via Auth
            //Login Success
            return redirect('dashboard');

        } else { // false
            return redirect('login')->with('error', 'Username/Password tidak cocok!');
        }
    }

    public function getRegister()
    {
        return view('auth.register');
    }

    public function postRegister(Request $request)
    {
        $this->validate($request, [
            'username' => 'required|min:4',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        User::create([
            'name' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        return redirect('login')->with('sukses', 'Register berhasil, silahkan login');
    }

    public function editProfile(Request $request)
    {
        $id = auth()->user()->id;
        $user = User::where('id', $id)
                ->update(['name' => $request->username]);
        
        $output = [
            'message' => 'Username Berhasil diperbaharui'
        ];

        return Response::json($output);
    }

    public function changePassword(Request $request)
    {
        $id = auth()->user()->id;
        $user = User::find($id);
        $new_password = bcrypt($request->newpass);

        if (Hash::check($request->oldpass, $user->password)) {
            User::where('id', $id)
            ->update(['password' => $new_password]);
            Auth::logout();
        
            return Response::json(
                'Password berhasil diperbarui, silahkan login kembali'
            );
        } else {
            return Response::json(
                'Password lama tidak cocok!'
            , 500);
        }

    }

    public function logout()
    {
        Auth::logout();
        return redirect('login');
    }
}
