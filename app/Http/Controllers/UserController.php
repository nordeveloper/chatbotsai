<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(){
        $user = \Auth::user();
        return view('user_edit', compact('user'));
    }

    public function update(Request $request){

        $this->validate($request, [
            'name' => 'required|max:50',
            'password' => 'nullable|confirmed|min:6'
        ]);

        $user = \Auth::user();

        $userData = $request->input();

        if($userData['password'] !== null){
            $this->validate($request, [
                'password' => 'required|confirmed|min:6'
            ]);

            $userData['password'] = bcrypt($userData['password']);
        }else{
            unset($userData['password']);
        }

        $user->update($userData);

        return redirect()->route('user.profile');
    }
}
