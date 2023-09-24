<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use PhpParser\Node\Expr\Cast\Array_;

class UserController extends Controller
{
    public function getuser(Request $request)
    {
        $face_data = json_decode($request->data);
        $users = User::all();
        $minDist = 999;
        $currDist = 0.0; 
        $selectedUser = null;
        foreach( $users as $user){
            if($user->face_data){
                $user_data = json_decode($user->face_data);
                $currDist = $this->euclideanDistance($user_data,$face_data);
                if($currDist <= 0.5 && $currDist <= $minDist)
                {
                    $minDist = $currDist;
                    $selectedUser = $user;
                }
            }
           
        }

        return response()->json($selectedUser);
    }

    public function euclideanDistance(array $l1, array $l2) {
        $sum = 0;
        for ($i = 0; $i < count($l1); $i++) {
            $sum += pow($l1[$i] - $l2[$i], 2);
        }
    
        return sqrt($sum);
    }
    
}
