<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class Demo extends Controller
{
    public function Hello(){
        return "hello new user";
    }

    public function InsertData(Request $request){
        $feedback =new Feedback();
        $feedback->name=$request->name; 
        $feedback->email=$request->email; 
        $feedback->rating=$request->rating; 
        $feedback->comment=$request->comment; 

        if($feedback->save()){
            return "saved";
        }
        else{
            return $feedback;
        }
       
    }

    public function UpdateData(Request $request){
        $feedback = Feedback::find($request->id);
        $feedback->name=$request->name; 
        $feedback->email=$request->email; 
        $feedback->rating=$request->rating; 
        $feedback->comment=$request->comment; 
        
        // dd($feedback);
        if($feedback->save()){
            return $feedback;
        }
        else{
            return $feedback;
        } 
    }

    public function DeleteData($id) {
        // return $id;
        $feedback = Feedback ::destroy($id);
        if($feedback){
            return "ho gyaaaaaaa";
        }
        else{
            return "Kuch to gadbad hai daya";
        }
    }
}
