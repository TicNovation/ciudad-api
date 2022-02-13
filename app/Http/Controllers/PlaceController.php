<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Place;
use App\Helpers\UtilsHelper;
use Validator;

class PlaceController extends Controller
{
    
    public function list(Request $request){

        $places = Place::where('city', $request->city)->where('active', 1)->paginate(20);
        $places->getCollection()->transform(function($item, $key)
        {   $item->image = env('AWS_URL').$item->image;
            return $item;
        });
        
        $placesA = $places->toArray();

        unset($placesA['from'], $placesA['last_page'], $placesA['links'], $placesA['first_page_url'], $placesA['last_page_url'], $placesA['next_page_url'], $placesA['path'], $placesA['per_page'], $placesA['prev_page_url']);

        if(is_object($places)){
            $code = 200;
            $data = array(
                'msg'=>'Correcto',
                'data'=>$placesA
            );
        }else{
            $code = 400;
            $data = array(
                'msg'=>'No se encontraron los lugares',
            );
        }

        return response()->json($data, $code);

    }

    public function search(Request $request){

        $places = Place::where('city', $request->city)->where('active', 1)->word($request->word)->take(20)->get()->map(function($query){
            $query->image = env('AWS_URL').$query->image;
            return $query;
        });

        return response()->json(['places' => $places], 200);

    }

}
