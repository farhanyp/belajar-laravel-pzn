<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InputController extends Controller
{
    public function hello(Request $request): string{
        
        $name = $request->input('name');
        return "Hello {$name}";
    }

    public function helloFirst(Request $request): string{
        
        $name = $request->input('name.first');
        return "Hello {$name}";
    }

    public function helloInput(Request $request): string{
        
        $input = $request->input();
        return json_encode($input) ;
    }

    public function arrayInput(Request $request): string{
        
        $name = $request->input('products.*.name');
        return json_encode($name) ;
    }

    public function inputType(Request $request){
        
        $name = $request->input('name');
        $married = $request->boolean('married');
        $birthDate = $request->date('birth_date', 'Y-m-d');

        return json_encode([
            "name" => $name,
            "married" => $married,
            "birth_date" => $birthDate,
        ]) ;
    }

    public function filterOnly(Request $request){
        
        // Hanya mengambil input name.first dan name.last
        $input = $request->only(["name.first", "name.last"]);

        return json_encode($input) ;
    }

    public function filterExcept(Request $request){
        
        // Hanya mengambil input selain name.first dan name.last
        $input = $request->except(["name.first", "name.last"]);

        return json_encode($input) ;
    }

    public function filterMerge(Request $request){
        
        // Jika ada input yang sama maka akan ditetapkan dengan yang di sediakan
        // contoh jika mendapatkan admin maka akan diberikan false
        $input = $request->merge(["admin"=> false]);

        return json_encode($input) ;
    }
}
