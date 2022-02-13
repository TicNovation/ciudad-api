<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Noti;
use App\Helpers\UtilsHelper;
use Validator;

class NotiController extends Controller {

    public function list(Request $request){
        try {

            $notis = Noti::where('city', $request->city)->where('active', 1)->paginate(20);
            $notis->getCollection()->transform(function($item, $key)
            {   $item->image = env('AWS_URL').$item->image;
                return $item;
            });
            
            $notisA = $notis->toArray();

            unset($notisA['from'], $notisA['last_page'], $notisA['links'], $notisA['first_page_url'], $notisA['last_page_url'], $notisA['next_page_url'], $notisA['path'], $notisA['per_page'], $notisA['prev_page_url']);


            if(is_object($notis)){
                $code = 200;
                $data = array(
                    'msg'=>'Correcto',
                    'data'=>$notisA
                );
            }else{
                $code = 400;
                $data = array(
                    'msg'=>'No se encontraron las noticias',
                );
            }        
        } catch (\Throwable $th) {
            echo $th;
            $code = 400;
            $data = array(
                'msg'=>'Algo salió mal',
            );        
        }

        return response()->json($data, $code);

    }

    public function search(Request $request){

        $notis = Noti::where('city', $request->city)->where('active', 1)->word($request->word)->take(20)->get()->map(function($query){
            $query->image = env('AWS_URL').$query->image;
            return $query;
        });

        return response()->json(['notis' => $notis], 200);

    }

}
