<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Input;
use Auth;
use Illuminate\Support\Facades\Validator;


class ChangeDefaultPasswordController extends Controller
{
    public function changePassword(Request $r) {
    	$this->validate($r, [
            'password' => 'required|min:6',
            'confirmPassword' => 'required|same:password'
        ]);

       	$user = \App\User::find(Auth::user()->id);
       	$user->password = bcrypt($r['password']);
       	$user->type = 1;
       	$user->save();

       	return redirect('/home');

    }

    public function resetPassword(Request $r) {
      $this->validate($r, [
            'password' => 'required|min:6',
            'confirmPassword' => 'required|same:password'
        ]);

        $user = \App\User::find($r['userID']);
        $user->password = bcrypt($r['password']);
        $user->save();

        return redirect('/settings');

    }

    public function getChangePasswordForm() {
      return view('forms.change_default_password');
    }
}
