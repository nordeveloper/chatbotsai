<?php

namespace App\Http\Controllers;

use App\Models\Character;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
class SettingsController extends Controller
{
    public function index(Request $request){

        $chatParams = $this->load_settings();

        // $ai_models = [
        //     'gryphe/mythomax-l2-13b',
        //     'undi95/toppy-m-7b',
        //     'gryphe/mythomist-7b',
        //     'openchat/openchat-7b',
        //     '01-ai/yi-34b-chat',
        //     'nousresearch/nous-capybara-7b',
        //     'nousresearch/nous-hermes-llama2-13b',
        //     'open-orca/mistral-7b-openorca',
        //     'teknium/openhermes-2-mistral-7b',
        //     'teknium/openhermes-2.5-mistral-7b',
        //     'huggingfaceh4/zephyr-7b-beta',
        //     'perplexity/pplx-7b-online',
        //     'perplexity/pplx-7b-chat',
        //     'lizpreciatior/lzlv-70b-fp16-hf',
        //     'mistralai/mistral-7b-instruct',
        //     'jondurbin/airoboros-l2-70b',
        //     'nousresearch/nous-hermes-llama2-70b',
        //     'pygmalionai/mythalion-13b',
        //     'meta-llama/codellama-34b-instruct',
        //     'openai/gpt-3.5-turbo'
        // ];

        $aiModels = Http::get('https://openrouter.ai/api/v1/models');

        if(!empty($aiModels->collect()['data'])){
            $ai_models = $aiModels->collect()['data'];
            //dd($ai_models);
        }

        return view('settings', compact('ai_models', 'chatParams'));
    }


    public function save(Request $request){

        $chat_settings['temperature'] = $request['temperature'];
        $chat_settings['max_tokens'] = $request['max_tokens']?: '';
        $chat_settings['frequency_penalty'] = $request['frequency_penalty'] ?:'';
        $chat_settings['presence_penalty'] = $request['presence_penalty'] ?: '';  
        $chat_settings['user_name'] = $request['user_name'] ?: '';   
        $chat_settings['nswf'] = $request['nswf'] ?: '';  
        $chat_settings['model'] = $request['model'] ?: '';
        
        $json = json_encode($chat_settings);    
        
        file_put_contents(storage_path('app/public/chat_settings.json'), $json);

        return redirect()->route('settings')->with('success', 'Settings successfully saved');
    }



    protected function getCharacterPrompt($char_name){

        $charParams = Character::where('name', $char_name)->first()->toArray();

        if( !empty($charParams['prompt']) && json_decode($charParams['prompt'], true) ) {

            $prompt = "";

            $systemPrompt = json_decode($charParams['prompt'], true);
            
            if( !empty($systemPrompt['system_prompt']) ){
                $prompt = $systemPrompt['system_prompt'];
            }     
  
            if( !empty($systemPrompt['description']) ){
                $prompt.= "\n"."Description:". $systemPrompt['description'];
            }

            if( !empty($systemPrompt['personality']) ){
                $prompt.= "\n"."Personality:". $systemPrompt['personality'];
            }

            if( !empty($systemPrompt['scenario']) ){
                $prompt.= "\n"."Scenario:". $systemPrompt['scenario'];
            }

            if( !empty($systemPrompt['first_mes']) ){
                $prompt.= "\n"."First message: ".$systemPrompt['first_mes'];
            }

            if( !empty($prompt) ){
                $prompt = str_replace('{{char}}', $systemPrompt['char_name'], $prompt);
                $prompt = str_replace('{{user}}', $systemPrompt['user_name'], $prompt);
            }

            return $prompt;
        }
    }


    protected function load_settings()
    {       
        $defParams = [];
        $chatParamsFile = storage_path('app/public/chat_settings.json');

        if ( file_exists($chatParamsFile) ) {

            $chatParamsJson = file_get_contents($chatParamsFile);
            $chatParams = json_decode($chatParamsJson, true);
            return $chatParams;
        }
        
        return $defParams;
    }

}
