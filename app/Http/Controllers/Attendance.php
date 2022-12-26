<?php

namespace App\Http\Controllers;

use App\Models\attendance as ModelsAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class Attendance extends Controller
{

    public function timeIn(Request $request, $email)
    {
        $currentTime = Carbon::now()->format('H:i:s');

        ModelsAttendance::create([
            "user_email" => $email,
            "time_in" => $currentTime,
            "day" => Carbon::now()->format('Y-m-d')

        ]);
        return response()->json(["status" => 200, "message" => "Agent has been Signed In "]);
    }
    /* Check for Time Out */
    public function timeOut($email)
    {
        ModelsAttendance::whereNull('time_out')
            ->where('user_email', $email)
            ->update([
                'time_out' => Carbon::now()->format('H:i:s'),
            ]);
        $time_in = ModelsAttendance::where('user_email', $email)->get();
        foreach ($time_in as $In) {
            $time_in = $In->time_in;
            $time_out = $In->time_out;
            $day = (string) $time_out - $time_in;
            ModelsAttendance::where('user_email', $email)
                ->update([
                    'day' => $day
                ]);
        }


        return response()->json(["status" => 200, "message" => "Agent has been Signed Out "]);
    }
}
