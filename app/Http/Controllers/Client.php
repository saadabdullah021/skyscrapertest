<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use App\Models\Client as ModelsClient;
use Illuminate\Support\Facades\Session;

class Client extends Controller
{

    /* Registering Client   */
    public function register(Request $request)
    {
        $request->validate([
            "name" => "bail |required |max:25",
            "email" => " bail | required  |max:30 ",
            "password" => "bail | required ",
            "type" => "required"

        ]);
        ModelsClient::create([
            "name" => $request['name'],
            "email" => $request["email"],
            "password" => Crypt::encryptString($request['password']),
            "type" => $request['type']
        ]);
        if ($request['type'] === "user") {
            return response()->json(["status" => 200, "message" => "User has been added successfully."]);
        }
        if ($request['type'] === "superadmin") {
            return response()->json(["status" => 200, "message" => "Super Admin has been added successfully."]);
        }
    }


    public function login(Request $request)
    {
        $request->validate([
            "email" => "required",
            "password" => "required",
            "type" => "required"
        ]);


        $user =  ModelsClient::where(
            "email",
            $request["email"]
        )->where("type", $request["type"])->get(["password", "id"]);
        foreach ($user as $u) {
            $pass = Crypt::decryptString($u['password']);
            if ($pass ===  $request['password'] && $request['type'] === "user") {

                return response()->json(["status" => 200, "message" => "User Logged In Successfully"]);
            } else if ($pass ===  $request['password'] && $request['type'] === "superadmin") {


                return response()->json(["status" => 200, "message" => "Super Admin Logged In Successfully"]);
            } else {
                return response()->json(["status" => 201, "message" => "You are registered on system . "]);
            }
        }
    }


    public function addAgent(Request $request)
    {
        $request->validate([
            "name" => "bail |required |max:25",
            "email" => " bail | required  |max:30 ",
            "password" => "bail | required ",

            "user_type" => "required"

        ]);
        if ($request['user_type'] == "superadmin") {
            ModelsClient::create([
                "name" => $request['name'],
                "email" => $request["email"],
                "password" => Crypt::encryptString($request['password']),
                "type" => "user"
            ]);
            return response()->json(["status" => 200, "message" => "Agent has been added successfully."]);
        } else {
            return response()->json(["status" => 201, "message" => "You don't have any permission to Add Agent."]);
        }
    }
    public function editAgent(Request $request, $email)
    {
        $editDone = ModelsClient::where("email", $email)->update([
            "name" => $request['name'],
            "email" => $request["email"],
            "password" => Crypt::encryptString($request['password']),
            "type" => "user"
        ]);

        if ($editDone) {
            return response()->json(["status" => 200, "message" => "Agent has been Updated successfully."]);
        } else {
            return response()->json(["status" => 200, "message" => "Some info is wrong"]);
        }
    }


    public function deleteAgent($email)
    {
        $email =  ModelsClient::where('email', $email)->first();
        if ($email != null) {
            $email->delete();
            return response()->json(["status" => 200, "message" => "Agent has been deleted successfully."]);
        } else {
            return response()->json(["status" => 403, "message" => "Something Went Wrong"]);
        }
    }


    /*  Add Super Admin Function */
    public function addSuperAdmin(Request $request)
    {
        $request->validate([
            "name" => "bail |required |max:25",
            "email" => " bail | required  |max:30 ",
            "password" => "bail | required ",
            "user_type" => "required"

        ]);
        if ($request['user_type'] == "superadmin") {
            ModelsClient::create([
                "name" => $request['name'],
                "email" => $request["email"],
                "password" => Crypt::encryptString($request['password']),
                "type" => "superadmin"
            ]);
            return response()->json(["status" => 200, "message" => "Super Admin has been added successfully."]);
        } else {
            return response()->json(["status" => 201, "message" => "You don't have any permission to Add Super Admin."]);
        }
    }
}
