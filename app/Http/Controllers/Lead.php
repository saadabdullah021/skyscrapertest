<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Lead as ModelsLead;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class Lead extends Controller
{
    /* Adding Leads Function calls*/
    public function addLead(Request $request)
    {
        $request->validate([
            "FullName" => "bail |required |max:25",
            "email" => " bail | required  |max:30 ",
            "phone_number" => "bail | required ",
            "user_email" => "required"
        ]);
        $email = $request['user_email'];
        $user_exists =  Client::where('email', $email)->count();

        if ($user_exists) {
            ModelsLead::create([
                "FullName" => $request['FullName'],
                "email" => $request["email"],
                "phone_number" => $request["phone_number"],
                "user_email" => $request["user_email"]
            ]);
            return response()->json(["status" => 200, "message" => "Leads Added Successfully."]);
        } else {

            return response()->json(["status" => 401, "message" => "Email not Registered . Please Register yourself first"]);
        }
    }

    /* View all leads function */

    public function viewLead()
    {

        $leads =  ModelsLead::all();
        return response()->json(["status" => 200, "message" =>  "All Leads Data:", $leads]);
    }


    /* View all Agents function */

    public function viewAgent($type)
    {
        $agents  = CLient::where("type", $type)->get();
        return response()->json(["status" => 200, "message" => "All Agents Data:", $agents]);
    }

    /* Changes Status of the of Leads */

    public function changeStatus(Request $request, $email)
    {
        $status = ModelsLead::where("email", $email)->where("assigned_to", $email)->update([
            "status" => $request['status']
        ]);
        if ($status) {
            return response()->json(["status" => 200,  "message" =>  "Status Changed Successfully."]);
        } else {
            return response()->json(["status" => 204, "message" =>  "You don't have permission. "]);
        }
    }

    /* Assign Leads to Agents */
    public function assignLeads($fromemail, $toemail)
    {

        $req = ModelsLead::where("email", $fromemail)->update([
            "assigned_to" => $toemail
        ]);
        if ($req) {
            return response()->json(["status" => 200,  "message" =>  "Lead Assigned Successfully."]);
        } else {
            return response()->json(["status" => 204, "message" =>  "Something went wrong"]);
        }
    }
}
