<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;

class CharactersController extends Controller
{
    public function index(Request $request){

        $items = Character::get();
        return view('characters.index', compact('items'));
    }


    public function create(){
        $character = new Character();
        $action_url = route('characters.store');
        return view('characters.form', compact('character', 'action_url'));
    }


    public function edit($id){
        $character = Character::find($id);
        
        if( $character->user_id==\Auth::id() ){
            $character['prompt'] = json_decode($character->prompt, true); 
    
            $action_url = route('characters.update', $character->id);
            return view('characters.form', compact('character', 'action_url'));            
        }else{
            abort('404');
        }

    }


    public function store(Request $request){

        $inputData = $request->input();

        $user_id = \Auth::id();

        $char_code = trim(strtolower(str_replace(' ', '_', $request['name'])));

        $character = [
            'personality' => trim($request['personality']),
            'scenario' => trim($request['scenario']),
            'first_mes' => trim($request['first_mes']),
            'system_prompt' => trim($request['system_prompt']),
            'user_name' => trim($request['user_name'])
        ];
    
        if (!empty($arData['description'])) {
            $character['personality'] = $character['personality']. "Description: " . trim($arData['description']) . "\n";
        }
    
   
        $char_image = null;
        $promptJson = json_encode($character, JSON_UNESCAPED_UNICODE);
        
        $inputData['code'] = $char_code;
        $inputData['user_id'] = $user_id;
        $inputData['prompt'] = $promptJson;

        $res = Character::create($inputData);

        return redirect()->route('characters.index');
    }


    public function update(Request $request, $id){

        $character = Character::find($id);

        $inputData = $request->input();

        $code = trim( strtolower( str_replace(' ', '_', $request['char_name']) ) );

        $arCharacter = [
            'name' => trim($request['char_name']),
            'char_name' => $code,
            'code'=>$code,
            'personality' => trim($request['personality']),
            'scenario' => trim($request['scenario']),
            'first_mes' => trim($request['first_mes']),
            'system_prompt' => trim($request['system_prompt']),
            'user_name' => trim($request['user_name'])
        ];
    
        if (!empty($arCharacter['description'])) {
            $arCharacter['personality'] = $arCharacter['personality']. "Description: " . trim($arCharacter['description']) . "\n";
        }
    
   
        $char_image = null;
        $json = json_encode($arCharacter, JSON_UNESCAPED_UNICODE);

        
        $inputData['prompt'] = $json;
        $character->update($inputData);

        return redirect()->route('characters.index');
    }


    public function destroy($id){
                
        $character = Character::find($id);
        if($character->user_id==\Auth::id()){
            $character->delete();
            return redirect()->route('characters.index');
        }else{
            abort(404);
        }
    }

}
