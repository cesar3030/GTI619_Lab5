<?php namespace App;

use Illuminate\Database\Eloquent\Model;

class CardGrid extends Model {


 public function getKey(){

        $test=[
            "A1"=>"58%yu","A2"=>"uy*ty","A3"=>"IHS45","A4"=>"ygu?","A5"=>"iuh$",
            "B1"=>"58%yu","B2"=>"uy*ty","B3"=>"IHS45","B4"=>"ygu?","B5"=>"iuh$",
            "C1"=>"58%yu","C2"=>"uy*ty","C3"=>"IHS45","C4"=>"ygu?","C5"=>"iuh$",
            "D1"=>"58%yu","D2"=>"uy*ty","D3"=>"IHS45","D4"=>"ygu?","D5"=>"iuh$"];

        $letters = array("A","B","C","D");

        $letter = $letters[round(rand(0, (sizeof($letters)-1)))];

        //return $test[$letter.round(rand(1,5))];
        return $letter.round(rand(1,5));
 }


    /**
     * @param $key
     * @param $value
     * @return string
     */
    public function validateValue($key, $value){

        $test=[
            "A1"=>"58%yu","A2"=>"uy*ty","A3"=>"IHS45","A4"=>"ygu?","A5"=>"iuh$",
            "B1"=>"58%yu","B2"=>"uy*ty","B3"=>"IHS45","B4"=>"ygu?","B5"=>"iuh$",
            "C1"=>"58%yu","C2"=>"uy*ty","C3"=>"IHS45","C4"=>"ygu?","C5"=>"iuh$",
            "D1"=>"58%yu","D2"=>"uy*ty","D3"=>"IHS45","D4"=>"ygu?","D5"=>"iuh$"];

       if($test[$key]==$value){
           return true;
       }
            return false;
    }



}
