<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Company;
use App\Models\Category;
use App\Models\CompanySchedule;
use App\Helpers\UtilsHelper;
use App\Models\SubCategory;
use Validator;

class CompanyController extends Controller {

    public function list(Request $request){

        try {
            $companies = Company::where('city', $request->city)->where('id_category', $request->id_category)->where('active', 1)->with('addresses')->with('open')->with(['category' => function($query){
                $query->select('id', 'name');
            }])->with(['subcategory' => function($query){
                $query->select('id', 'name');
            }])->paginate(15);
            $companies->getCollection()->transform(function($item, $key)
            {   $item->image = env('AWS_URL').$item->image;
                $item->is_open = $item->open == null ? 0 : 1;
                unset($item["open"]);
                return $item;
            });
            
            $compA = $companies->toArray();
    
            unset($compA['from'], $compA['last_page'], $compA['links'], $compA['first_page_url'], $compA['last_page_url'], $compA['next_page_url'], $compA['path'], $compA['per_page'], $compA['prev_page_url']);
            
            $subcategories = null;

            if($request->is_first == 1){
                $subcategories = SubCategory::where('id_category', $request->id_category)->where('active', 1)->get();
            }
    
            if(is_object($companies)){
                $code = 200;
                $data = array(
                    'msg'=>'Correcto',
                    'data'=>$compA,
                    'subcategories'=>$subcategories
                );
            }else{
                $code = 400;
                $data = array(
                    'msg'=>'No se encontraron las noticias',
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

    public function search(Request $request){

        $companies = Company::where('city', $request->city)->where('active', 1)->word($request->word)->with('addresses')->with('open')->with(['category' => function($query){
            $query->select('id', 'name');
        }])->with(['subcategory' => function($query){
            $query->select('id', 'name');
        }])->take(20)->get()->map(function($query){
            $query->image = env('AWS_URL').$query->image;
            $query->is_open = $query->open == null ? 0 : 1;
            unset($query["open"]);
            return $query;
        });

        return response()->json(['companies' => $companies], 200);

    }

    public function fullsearch(Request $request){

        $companies = Company::where('city', $request->city)->where('active', 1)->word($request->word)->with('addresses')->with('open')->with(['category' => function($query){
            $query->select('id', 'name');
        }])->with(['subcategory' => function($query){
            $query->select('id', 'name');
        }])->get()->map(function($query){
            $query->image = env('AWS_URL').$query->image;
            $query->is_open = $query->open == null ? 0 : 1;
            unset($query["open"]);
            return $query;
        });

        return response()->json(['companies' => $companies], 200);

    }

    public function filter(Request $request){

        if(count($request->categories) > 0){

            $companies = Company::where('city', $request->city)->where('active', 1)->whereIn('id_subcategory' , $request->categories)->with('addresses')->with('open')->with(['category' => function($query){
                $query->select('id', 'name');
            }])->with(['subcategory' => function($query){
                $query->select('id', 'name');
            }])->get()->map(function($query){
                $query->image = env('AWS_URL').$query->image;
                $query->is_open = $query->open == null ? 0 : 1;
                unset($query["open"]);
                return $query;
            });

            $code = 200;
            $data = array(
                'msg'=>'Correcto',
                'companies'=>$companies
            );
        }else{
            $code = 400;
            $data = array(
                'msg'=>'Ingrese las categorías a buscar'
            );
        }

        return response()->json($data, $code);

    }
 
}
