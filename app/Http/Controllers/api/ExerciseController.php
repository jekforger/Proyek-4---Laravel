<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Helpers\APIFormatter;
use Illuminate\Support\Facades\DB;
use App\Models\Exercise;
use Illuminate\Support\Facades\Hash;

class ExerciseController extends Controller
{
    public function exercises(Request $request) {
        try {
            $exercises = Exercise::where("body_mass_standard_id", $request->body_mass_standard_id)
            ->with("setType")
            ->with("bodyMassStandard")
            ->get();

            if($exercises) {
                return APIFormatter::createAPI(200, "Success", $exercises);
            } else {
                return APIFormatter::createAPI(400, 'Failed');
            }
        } catch (Exception $e) {
            return APIFormatter::createAPI(500, 'Failed', $e);
        }
    }
}
