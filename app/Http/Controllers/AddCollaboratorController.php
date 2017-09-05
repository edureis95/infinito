<?php

namespace App\Http\Controllers;
use Input;
use App\User;

class AddCollaboratorController extends Controller
{

	public function addCollaborator() {
		$email = Input::get('email');
		User::create([
	        'name' => 'Colaborador',
	        'email' => $email,
	        'password' => bcrypt('default'),
	        'type' => 0,
	    ]);
	    return redirect('/settings');
	}
}

?>