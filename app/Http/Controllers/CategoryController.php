<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Helpers\UtilsHelper;
use Validator;

class CategoryController extends Controller {

    public function list(Request $request){

        $categories = Category::where('active', 1)->get()->map(function($query){
            $query->image = env('AWS_URL').$query->image;
            return $query;
        });

        if(is_object($categories)){
            $code = 200;
            $data = array(
                'msg'=>'Correcto',
                'categories'=>$categories
            );
        }else{
            $code = 400;
            $data = array(
                'msg'=>'No existe las categorías',
            );
        }

        return response()->json($data, $code);

    }

}