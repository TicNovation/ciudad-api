<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\SubCategory;
use App\Models\Category;
use Validator;

class SubCategoryController extends Controller {

    public function list(Request $request){

        $subcategories = SubCategory::where('id_category', $request->id_category)->where('active', 1)->get();

        if(is_object($subcategories)){
            $code = 200;
            $data = array(
                'msg'=>'Correcto',
                'subcategories'=>$subcategories
            );
        }else{
            $code = 400;
            $data = array(
                'msg'=>'No existe la categoría',
            );
        }

        return response()->json($data, $code);

    }
 
    public function search(Request $request){

        $subcategories = SubCategory::where('active', 1)->where('active', 1)->where('id_category', $request->id_category)->get();
        
        if(is_object($subcategories)){
            $code = 200;
            $data = array(
                'msg'=>'Correcto',
                'subcategories'=>$subcategories
            );
        }else{
            $code = 400;
            $data = array(
                'msg'=>'No existe la categoría',
            );
        }

        return response()->json($data, $code);

    }

}
