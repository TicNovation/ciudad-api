<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller {

    public function save(Request $request){

        User::firstOrCreate(['id_firebase'=>$request->id_firebase, 'city'=>$request->city, 'os'=>$request->os, 'id_unique'=>$request->id_unique, 'active'=>1]);

    }

}
