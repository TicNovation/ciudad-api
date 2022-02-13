<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Info;
use App\Helpers\UtilsHelper;
use Validator;

class InfoController extends Controller {

    public function find(Request $request){

        $info = Info::where('active', 1)->where('city', $request->city)->first();
   
        if(is_object($info)){
            $code = 200;
            $data = array(
                'msg'=>'Correcto',
                'info'=>$info
            );
        }else{
            $code = 400;
            $data = array(
                'msg'=>'No existe la información',
            );
        }

        return response()->json($data, $code);

    }

}
