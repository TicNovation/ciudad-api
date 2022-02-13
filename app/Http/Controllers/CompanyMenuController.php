<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanyMenu;
use App\Helpers\UtilsHelper;
use Validator;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class CompanyMenuController extends Controller {

    public function list(Request $request){

        $menu = CompanyMenu::where('id_company', $request->id_company)->orderBy('order_list')->get()->map(function($query){
            $query->image = env('AWS_URL').$query->image;
            return $query;
        });

        if(is_object($menu)){
            $code = 200;
            $data = array(
                'msg'=>'Correcto',
                'menu'=>$menu
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
