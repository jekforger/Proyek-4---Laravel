<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\DetailAchievement;
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

    public function createAchievement(Request $request)
    {
        try {
            $request->validate([
                'exercise_id' => 'required',
            ]);

            $user = User::where("id", Auth::id())->first();
            $day = date("Y-m-d");
            $achievement = Achievement::where("user_id", $user->id)
                ->where("created_at", "like", "%$day%")
                ->first();

            // if ($achievement) {
            //     return APIFormatter::createAPI(200, "Success", $achievement);
            // } else {
            //     return APIFormatter::createAPI(400, 'Failed');
            // }

            if ($achievement) {
                $createDetailAchievement = DetailAchievement::create([
                    "status" => true,
                    "achievement_id" => $achievement->id,
                    "exercise_id" => $request->exercise_id,
                ]);

                $detailAchievement = DetailAchievement::where("id", $createDetailAchievement->id)
                    ->with("achievement")->first();

                if ($detailAchievement) {
                    return APIFormatter::createAPI(200, "Success", $detailAchievement);
                } else {
                    return APIFormatter::createAPI(400, 'Failed');
                }
            } else {
                $newAchievement = Achievement::create([
                    "user_id" => $user->id,
                ]);

                $createDetailAchievement = DetailAchievement::create([
                    "status" => true,
                    "achievement_id" => $newAchievement->id,
                    "exercise_id" => $request->exercise_id,
                ]);

                $detailAchievement = DetailAchievement::where("id", $createDetailAchievement->id)
                    ->with("achievement")->first();

                if ($detailAchievement) {
                    return APIFormatter::createAPI(200, "Success", $detailAchievement);
                } else {
                    return APIFormatter::createAPI(400, 'Failed');
                }
            }
        } catch (Exception $e) {
            return APIFormatter::createAPI(500, 'Failed', $e);
        }
    }

    public function achievement(Request $request)
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

            $countExercises = Exercise::where("body_mass_standard_id", $body_mass_standard_id)
                ->count();

            $day = date("Y-m-d");

            $achievement = Achievement::where("user_id", $user->id)
                ->where("created_at", "like", "%$day%")
                ->first();

            $countDetailAchievement = DetailAchievement::where("achievement_id", $achievement->id)->count();

            if ($user) {
                $progress = ($countDetailAchievement / $countExercises) * 100;
                return APIFormatter::createAPI(200, "Success", $progress);
            } else {
                return APIFormatter::createAPI(400, 'Failed');
            }
        } catch (Exception $e) {
            return APIFormatter::createAPI(500, 'Failed', $e);
        }
    }

    public function detailAchievement(Request $request)
    {
        try {
            $user = User::where("id", Auth::id())->first();
            $day = date("Y-m-d");
            $achievement = Achievement::where("user_id", $user->id)
                ->where("created_at", "like", "%$day%")
                ->first();
            $detailAchievement = DetailAchievement::where("achievement_id", $achievement->id)
                ->get();

            if ($detailAchievement) {
                return APIFormatter::createAPI(200, "Success", $detailAchievement);
            } else {
                return APIFormatter::createAPI(400, 'Failed');
            }
        } catch (Exception $e) {
            return APIFormatter::createAPI(500, 'Failed', $e);
        }
    }
}
