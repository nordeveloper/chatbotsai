<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CharactersController extends Controller
{
    public function index(Request $request){

        $dbRes = Character::orderBy('name', 'asc');
        $user = Auth::user();

        $dbRes->whereNull('nswf');

        if(!empty($user->nswf)){
            $dbRes->orWhere('nswf', '=', 1);
        }

        $items = $dbRes->get();

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

        $code = trim( strtolower( str_replace(' ', '_', $request['name']) ) );

        $arCharacter = [
            'name' => trim($request['name']),
            'char_name' => trim($request['name']),
            'code'=>$code,
            'personality' => trim($request['personality']),
            'scenario' => trim($request['scenario']),
            'first_mes' => trim($request['first_mes']),
            'system_prompt' => trim($request['system_prompt']),
            'user_name' => trim($request['user_name']),
            'nswf'=>$request['nswf']
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
