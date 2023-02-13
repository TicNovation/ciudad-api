<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Banner;
use App\Models\Company;
use App\Helpers\UtilsHelper;
use Validator;

class CategoryController extends Controller {

    public function list(Request $request){

        $categories = Category::where('active', 1)->where('city', $request->city)->get()->map(function($query){
            $query->image = env('AWS_URL').$query->image;
            return $query;
        });

        $banner = Banner::where('city', $request->city)->get()->map(function($query){
            $query->image = env('AWS_URL').$query->image;
            return $query;
        });

        $companies = Company::where('city', $request->city)->where('active', 1)->with('addresses')->with('open')->with(['category' => function($query){
            $query->select('id', 'name');
        }])->with(['subcategory' => function($query){
            $query->select('id', 'name');
        }])->inRandomOrder()->limit(8)->get()->map(function($query){
            $query->image = env('AWS_URL').$query->image;
            $query->is_open = $query->open == null ? 0 : 1;
            unset($query["open"]);
            return $query;
        });

        if(is_object($categories)){
            $code = 200;
            $data = array(
                'msg'=>'Correcto',
                'categories'=>$categories,
                'banner'=>$banner,
                'companies'=>$companies
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
