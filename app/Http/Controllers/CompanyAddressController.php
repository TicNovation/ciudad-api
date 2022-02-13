<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyAddress;
use App\Helpers\UtilsHelper;
use Validator;

class CompanyAddressController extends Controller
{
    
    public function list(Request $request){

        $addresses = CompanyAddress::where('id_company', $request->id_company)->get();

        if(is_object($addresses)){
            $code = 200;
            $data = array(
                'msg'=>'Correcto',
                'addresses'=>$addresses
            );
        }else{
            $code = 400;
            $data = array(
                'msg'=>'No se encontraron los lugares',
            );
        }

        return response()->json($data, $code);

    }


}
