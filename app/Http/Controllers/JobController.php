<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Job;
use App\Models\JobNotification;
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

        $notification;

        if($request->is_first == 1){
            $notification = JobNotification::where('id_firebase', $request->id_firebase)->first();
        }

        if(is_object($jobs)){
            $code = 200;
            $data = array(
                'msg'=>'Correcto',
                'data'=>$jobsA,
                'notification'=>$notification
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

    public function find(Request $request){

        $job = Job::find($request->id);

        if(is_object($job)){
            $code = 200;
            $data = array(
                'msg'=>'Correcto',
                'job'=>$job
            );
        }else{
            $code = 400;
            $data = array(
                'msg'=>'No se encontró la oferta de empleo'
            );
        }

        return response()->json($data, $code);

    }

    public function enable(Request $request){

        try {
            JobNotification::insert(
                array(
                    'id_firebase'=>$request->id_firebase,
                    'city'=>$request->city,
                )
            );
            $code = 200;
            $data = array(
                'msg'=>'Correcto',
            );

        } catch (\Throwable $th) {
            $code = 400;
            $data = array(
                'msg'=>$th
            );
        }

        return response()->json($data, $code);

    }

    public function disable(Request $request){
        try {
            JobNotification::where('id_firebase', $request->id_firebase)->delete();

            $code = 200;
            $data = array(
                'msg'=>'Correcto',
            );

        } catch (\Throwable $th) {
            $code = 400;
            $data = array(
                'msg'=>$th
            );
        }

        return response()->json($data, $code);
    }

}
