<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Helpers\UtilsHelper;
use Validator;

class JobController extends Controller {
    
    public function list(Request $request){

        $jobs = Job::where('city', $request->city)->where('active', 1)->paginate(20);
        $jobs->getCollection()->transform(function($item, $key)
        {   $item->image = env('AWS_URL').$item->image;
            return $item;
        });
        
        $jobsA = $jobs->toArray();

        unset($jobsA['from'], $jobsA['last_page'], $jobsA['links'], $jobsA['first_page_url'], $jobsA['last_page_url'], $jobsA['next_page_url'], $jobsA['path'], $jobsA['per_page'], $jobsA['prev_page_url']);

        if(is_object($jobs)){
            $code = 200;
            $data = array(
                'msg'=>'Correcto',
                'data'=>$jobsA
            );
        }else{
            $code = 400;
            $data = array(
                'msg'=>'No se encontraron las jobcias',
            );
        }

        return response()->json($data, $code);

    }

    public function search(Request $request){

        $jobs = Job::where('city', $request->city)->where('active', 1)->word($request->word)->take(20)->get()->map(function($query){
            $query->image = env('AWS_URL').$query->image;
            return $query;
        });

        return response()->json(['jobs' => $jobs], 200);

    }

}
