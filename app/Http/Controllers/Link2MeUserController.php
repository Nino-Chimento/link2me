<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Link2meUser;
use Ap\Contact;

class Link2MeUserController extends Controller
{

    protected $validation = [
        "name" => "required|string|max:50",
        "lastname" =>  "required|string|max:50",
        "department" =>  "required|string",
     ];
     // function calcolate distance
     public static function GreatCircleDistance(
        $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
      {
        // convert from degrees to radians
        $latFrom = deg2rad($latitudeFrom);
        $lonFrom = deg2rad($longitudeFrom);
        $latTo = deg2rad($latitudeTo);
        $lonTo = deg2rad($longitudeTo);
      
        $lonDelta = $lonTo - $lonFrom;
        $a = pow(cos($latTo) * sin($lonDelta), 2) +
          pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
        $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);
      
        $angle = atan2(sqrt($a), $b);
        return $angle * $earthRadius;
      }
    // function calcolate distance
    public function encode($data) {
        return json_encode($data);
    }

    public function getUser($id){
        if(!$id) {
            return $response = [
                "message" => "status 404"
            ];
        }
        $user = Link2meUser::where("id",$id)->get();
        return  $response = [
            "message" => "status 200",
            "data" => $this->encode($user),
        ];
    }

    public function deleteUser($id) {
        if(!$id) {
            return $response = [
                "message" => "status 404 insert id"
            ];
        }

        $user = User::find($id);    
        $result = $user->delete();
        if(!$result) {
            return $response = [
                "message" => "status 404 id not found in db"
            ];
        }
        return $response = [
            "message" => "status 200",
            "data" => [
                "result" => $result,
                "user" => $this->encode($user),
            ]
        ];
    }

    public function addUser(Request $request) {
        // valido i dati 
        $request->validate(
            $this->validation
            );
        
        $data = $request->all();
        $user = new Link2meUser;
        $user->fill($data);
        $result = $user->save();

        if(!$result) {
            return $response = [
                "message" => "status 404 error connection db"
            ];
        }

        return $response = [
            "message" => "status 200",
            "data" => [
                "result" => $result,
                "user" => $this->encode($user),
            ]
        ];
    }

    public function updateUser(Request $request) {
        // valido i dati 
        $request->validate(
            $this->validation
            );
        $data = $request->all();  
        $id = $data["id"];
        $user =  $user = Link2meUser::where("id",$id)->get();
        if(!$user) {
            return $response = ["message" => "status 404 user not found"];
        };
        $result = $user->fill($data);
        if(!$result) { return $response = ["message" => "status 404 not connection db"];}
        return $response = [
            "message" => "status 200",
            "result" => $result,
            "data" => $this->encode($user)
        ];
    }

    public function addContact(Request $request, $id) {
         // valido i dati 
         $request->validate(
            $this->validation
            );
        $data = $request->all(); 
        $user = Link2meUser::where("id",$id)->get();
        if(!$user) {
            return $response = [
                "message" => "status 404 user not found", 
            ];
        }

        $contact = new Contact;
        $contact->link2meusers_id = $id;
        $result = $contact->fill($data);
        if(!$result) {
            return $response = [
                "message" => "status 404 not connection db", 
            ];
        }
        return $response = [
            "message" => "status 200",
            "result" => $result,
            "data" => $this->encode($contact)
        ];

    }

    public function removeContact(Request $request) {
        $data = $request->all(); 
        $idUser = $data["idUser"];
        $idContact = $data["idContact"];
        $result = Contact::where("id",$idContact)->where("link2meusers_id",$idUser)->get();
        if(!$result) {
            return $response = ["message" => "status 404 not connection db"];
        }
        return $response = [
            "message" => "status 200",
            "result" => $result,
        ];
    }

    public function searchcolleague(Request $request) {
        $request->validate(
            $this->validation
            );
        $data = $request->all(); 
        //formatted data
        $idUser =strtolower($data["idUser"]) ;
        $name = strtolower($data["name"]);
        $lastname = strtolower($data["lastname"]);
        $department = $data["department"];
        // formatted data
        $user =    Link2meUser::where("id",$idUser)->get();
        if(!$user) {
            return ["message" => "status 404 user not found"];
        }
        $contact = Contact::where("id",$idUser)->
            orWhere('name', $name)->
            orWhere('lastname', $lastname)->
            orwhere("department",$department)
            ->get();
        if(!$contact){
            return ["message" => "status 404 contact not found"];
        }
        return $response = [
            "message" => "status 200",
            "result" => $this->encode($contact),
        ];
        

    }

    public function searchByDepartment($department) {
        $users = Link2meUser::where("department",$department)->get();
        if(count($users) === 0) {
            return ["message" => "status 404 users not found"];
        }

        return $response = [
            "message" => "status 200",
            "result" => $this->encode($users),
        ];
    }

    public function distanceContacts($id) {
        $user = Link2meUser::where("id",$id)->get();
        $contacts = Contact::where("link2meusers_id",$id)->get();
        $lanUser = $user->latitude;
        $lonUser = $user->longitude;
        $contactsDistance = [];
        foreach ($contacts as $key => $contact) {
            $distance = $this->GreatCircleDistance(
                $lanUser, $lonUser, $contact["latitude"], $contact["longitude"], $earthRadius = 6371000);
            $contactDistance= [
                    "contact" => [
                        "name" => $contact["name"],
                        "lastname" => $contact["lastname"]
                    ],
                    "distance" => $distance
                ] ;   
            array_push($contactsDistance, $contactDistance);    
        }
        if(cunt($contactsDistance) === 0) {
            return ["message" => "status 404 contacts not found"];
        }
        return $response = [
            "message" => "status 200",
            "result" => $this->encode($contactsDistance),
        ];
        
    }
}
