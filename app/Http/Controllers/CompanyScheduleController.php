<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CompanySchedule;
use App\Helpers\UtilsHelper;
use Validator;

class CompanyScheduleController extends Controller
{
    
    public function find(Request $request){

        $schedule = CompanySchedule::where('id_company', $request->id_company)->get();

        if(is_object($schedule)){
            $code = 200;
            $data = array(
                'msg'=>'Correcto',
                'schedule'=>$schedule,
            );
        }else{
            $code = 401;
            $data = array(
                'msg'=>'No se encontró la información'
            );
        }

        return response()->json($data, $code);

    }

}
