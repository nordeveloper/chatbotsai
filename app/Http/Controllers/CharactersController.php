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

        $char_code = \Str::slug($request['name']);

        $character = [
            'name' => trim($request['name']),
            'char_name' => trim($request['name']),
            'personality' => trim($request['personality']),
            'scenario' => trim($request['scenario']),
            'first_mes' => trim($request['first_mes']),
            'user_name' => trim($request['user_name']),
            'system_prompt' => trim($request['system_prompt']),
            'nswf'=>$request['nswf']
        ];
    
   
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

        $bot_code = \Str::slug($request['name']);

        $arCharacter = [
            'name' => trim($request['name']),
            'char_name' => trim($request['name']),
            'personality' => trim($request['personality']),
            'scenario' => trim($request['scenario']),
            'first_mes' => trim($request['first_mes']),
            'user_name' => trim($request['user_name']),
            'system_prompt' => trim($request['system_prompt']),
            'nswf'=>$request['nswf']
        ];   
   
        $char_image = null;
        $json = json_encode($arCharacter, JSON_UNESCAPED_UNICODE);

        $inputData['code'] = $bot_code;
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
