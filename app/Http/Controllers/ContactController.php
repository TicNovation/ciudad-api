<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Helpers\UtilsHelper;
use Validator;

class ContactController extends Controller {

    public function list(Request $request){
        try {
            $contacts = Contact::where('city', $request->city)->where('active', 1)->get()->map(function($query){
                $query->image = env('AWS_URL').$query->image;
                return $query;
            });
            
            if(is_object($contacts)){
                $code = 200;
                $data = array(
                    'msg'=>'Correcto',
                    'contacts'=>$contacts
                );
            }else{
                $code = 400;
                $data = array(
                    'msg'=>'No existen contactos',
                );
            }        
        } catch (\Throwable $th) {
            $code = 400;
            $data = array(
                'msg'=>$th,
            );
        }

        return response()->json($data, $code);

    }

}
