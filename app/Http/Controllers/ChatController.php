<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\Character;
use Illuminate\Http\Request;
use App\Http\Requests\AiRequest;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{

    const ROLE = "role";
    const CONTENT = "content";
    const USER = "user";
    const SYS = "system";
    const ASSISTANT = "assistant";

    public $temperature = 0.8;
    public $max_tokens = 200;
    public $frequency_penalty = 0.8;
    public $presence_penalty = 0.8;

    public $two_bot = null;
    public $apiKey = null;
    public $logDir = '';


    public function index(Request $request){

        $bot = $request->bot;
        return view('chat', compact('bot'));
    }


    public function send(Request $request){

        try{
            $preparedData = $this->prepareData($request);
            
            $chatParams = $preparedData['params'];
            $arHistory = $preparedData['history'];
            $character = $preparedData['character'];

            // dump($arHistory);
    
            $opts = [
               'model' => $chatParams['model'],
               'messages' => $arHistory,
               'temperature' => (float) $chatParams['temperature'],
               'max_tokens' => (int) $chatParams['max_tokens'],
               'frequency_penalty' => (float) $chatParams['frequency_penalty'],
               'presence_penalty' => (float) $chatParams['presence_penalty'],
               'top_p'=>0.9
            ];
            
            // file_put_contents(storage_path('app/public/chat.log'), print_r($arHistory, true), FILE_APPEND);
           
            $arData['bot_name'] = $character['name'];
            $arData['user_name'] = $chatParams['user_name'];

            $airequest = new AiRequest(config('app.aiApiKey'));

            $aiRespJson = $airequest->chat($opts);

            //dump($aiRespJson);

            if( !empty($aiRespJson) && is_array(json_decode($aiRespJson, 1)) ){

                $arAIResp = json_decode($aiRespJson, 1);

                    //$arAIResp["choices"][0]['message']['content'] openai, opemrouter
                    //$arAIResp['output']['choices'][0]['text'] together.ai

                if( !empty($arAIResp['choices'][0]) ){
                    
                    $aiMsg = htmlspecialchars($arAIResp["choices"][0]['message']['content']);
                    $this->MessageToDB(Auth::id(), $character['code'], null, $aiMsg);
    
                    $arData['text'] = $aiMsg;
                    
                    return json_encode($arData);

                }else{    
                    file_put_contents( storage_path('app/public/chat_error.log'), $aiRespJson."\n", FILE_APPEND);
                    return json_encode(['text'=>'ERROR AI Resposnse: '.$aiRespJson]);
                }

            }else{
                return json_encode(['text'=>'ERROR AI Resposnse: '.$aiRespJson]);
            }

        }catch(Exception $e){
            file_put_contents( storage_path('app/public/chat_error.log'), print_r($e->getMessage(), 1), FILE_APPEND);
            return json_encode(['text'=>'ERROR, '. $e->getMessage()]);
        }
    }


    protected function prepareData(Request $request){

        $chatParams = null;
        $arHistory = null;
        $character = null;

        $character = $this->getCharacter($request->bot);
        
        if( !empty($character) ){
            $this->MessageToDB(Auth::id(), $character['code'], $request->msg);
            
            $history = [];
            if( !empty($character['prompt']) ){
                $history[] = [self::ROLE => self::SYS, self::CONTENT => $character['prompt']];
            }
    
            $oldHistory = $this->getHistory($request);
    
            $history = array_merge($history, $oldHistory);
    
            $history_count = count($history);
            if( $history_count >15 ){
                $minus = $history_count-($history_count-15);
                $hewHistory = array_reverse($history);
                $newHistory = array_reverse(array_slice($hewHistory, 0, $minus));
                $newHistory[0] = $history[0];
                $arHistory = $newHistory;
            }else{
                $arHistory = $history;
            }       
    
            $chatParams = $this->load_params();            
        }

        return ['params'=>$chatParams, 'history'=>$arHistory, 'character'=>$character];
    }
   

    public function getHistory(Request $request){

        $arFilter = ['user_id'=>Auth::id(), 'bot'=>trim($request->bot)];

        $dbRes = Message::where($arFilter);

        if( !empty($request->two_bot) ){
            $dbRes->orWhere('two_bot', strtolower($request->two_bot));
        }

        $result = $dbRes->get();

        $history = [];

        if( !empty($result) ){

            foreach ($result as $row ) {
                if( !empty($row['user_message']) ){
                    $history[] = [self::ROLE => self::USER, self::CONTENT => $row['user_message'] ];
                }
                if( !empty($row['bot_message']) ){
                    $history[] = [self::ROLE => self::ASSISTANT, self::CONTENT => $row['bot_message'] ];
                }    
            }            
        }

        return $history;                  
    }


    public function removeHistory(Request $request){
        Message::where(['user_id'=>Auth::id(), 'bot'=>trim($request->bot)])->delete();
        Message::where(['user_id'=>Auth::id(), 'two_bot'=>trim($request->bot)])->delete();
        return redirect()->route('chat', 'bot='.$request->bot);
    }

    
    protected function MessageToDB($user_id, $bot, $userMsg=null, $aiMsg=null) {

        if( !empty($userMsg) ){
            $arData = [
                'user_id'=>$user_id,
                'bot'=>$bot,
                'user_message'=>trim($userMsg),
                'bot_message'=>''
            ];

            if(!empty($this->two_bot)){
                $arData['two_bot'] = strtolower($this->two_bot);
            }
            Message::create($arData);
        }

        if(!empty($aiMsg)){ 
            $arData = [
                'user_id'=>$user_id,
                'bot'=>$bot,
                'bot_message'=>trim($aiMsg),
                'user_message'=>''
            ];
            if(!empty($this->two_bot)){
                $arData['two_bot'] = strtolower($this->two_bot);
            }
            Message::create($arData);
        }        
    }



    protected function getCharacter($char_code){

        $character = Character::where('code', $char_code)->first();   

        if( !empty($character['prompt']) && json_decode($character['prompt'], true) ) {

            $systemPrompt = "";

            $charPrompt = json_decode($character['prompt'], true);
            
            if( !empty($charPrompt['system_prompt']) ){
                $systemPrompt = $charPrompt['system_prompt']."\n";
            }     
  
            if( !empty($charPrompt['description']) ){
                $systemPrompt.= "Description: ". $charPrompt['description']."\n";
            }

            if( !empty($charPrompt['personality']) ){
                $systemPrompt.= "Personality: ". $charPrompt['personality']."\n";
            }

            if( !empty($charPrompt['scenario']) ){
                $systemPrompt.= "Scenario: ". $charPrompt['scenario']."\n";
            }

            if( !empty($charPrompt['first_mes']) ){
                $systemPrompt.= "\n"."First message: ".$charPrompt['first_mes'];
            }

            if( !empty($systemPrompt) ){
                $systemPrompt = str_replace('{{char}}', $character['name'], $systemPrompt);
                $systemPrompt = str_replace('{{user}}', $charPrompt['user_name'], $systemPrompt);
                
                $character['prompt'] = $systemPrompt;
            }else{
                $character['prompt'] = '';
            }

            return $character;
        }
    }


    protected function load_params()
    {   
        $defParams['temperature'] = $this->temperature;
        $defParams['max_tokens'] = $this->max_tokens;
        $defParams['frequency_penalty'] = $this->frequency_penalty;
        $defParams['presence_penalty'] = $this->presence_penalty;

        $chatParamsFile = storage_path('app/public/chat_settings.json');

        try{
            $chatParamsJson = file_get_contents($chatParamsFile);
            $chatParams = json_decode($chatParamsJson, true);
            
            if( !empty($chatParamsJson) && is_array($chatParams) ){
                return $chatParams;
            }
            
        }catch(Exception $e){
                
        }
        
        return $defParams;
    }
}
