<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Http\Request;
use App\Helpers\APIFormatter;
use Illuminate\Support\Facades\Auth;
use App\Models\Exercise;
use App\Models\User;

class ExerciseController extends Controller
{
    public function exercises(Request $request)
    {
        try {
            $user = User::where("id", Auth::id())->first();
            $body_mass_standard_id = 0;

            if ($user->bmi < 18.5) {
                $body_mass_standard_id = 1;
            } else if ($user->bmi > 18.5 && $user->bmi < 24.9) {
                $body_mass_standard_id = 2;
            } else if ($user->bmi > 255 && $user->bmi < 29.9) {
                $body_mass_standard_id = 3;
            } else if ($user->bmi > 30) {
                $body_mass_standard_id = 4;
            }

            $exercises = Exercise::where("body_mass_standard_id", $body_mass_standard_id)
                ->with("setType")
                ->with("bodyMassStandard")
                ->get();

            if ($exercises) {
                return APIFormatter::createAPI(200, "Success", $exercises);
            } else {
                return APIFormatter::createAPI(400, 'Failed');
            }
        } catch (Exception $e) {
            return APIFormatter::createAPI(500, 'Failed', $e);
        }
    }
}
