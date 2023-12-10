@extends('main')

@section('content')

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <div class="card settings-box">
        <div class="card-body">
            <h4>Chat Settings</h4>
            <form method="POST" class="row justify-content-center pb-3" action="{{route('settings.save')}}">
                
                <div class="form-group col-lg-6">
                    <label>Temperature</label>
                    <input type="text" name="temperature" class="form-control" value="{{ ( !empty($chatParams['temperature']) ? $chatParams['temperature'] : 0.7 ) }}">
                </div>
        
                <div class="form-group col-lg-6">
                    <label>
                        Max tokens
                    </label>
                    <input type="text" type="number" name="max_tokens" class="form-control" value="{{ ( !empty($chatParams['max_tokens']) ? $chatParams['max_tokens'] : 200 ) }}">
                </div>
        
                <div class="form-group col-lg-6">
                    <label>
                    Frequency penalty
                    </label>
                    <input type="number" name="frequency_penalty" step="0.1" class="form-control" value="{{ ( !empty($chatParams['frequency_penalty']) ? $chatParams['frequency_penalty'] : 1 )}}">
                </div>
        
                <div class="form-group col-lg-6">
                    <label>
                    Presence penalty
                    </label>
                    <input type="number" name="presence_penalty" step="0.1" class="form-control" value="{{ ( !empty($chatParams['presence_penalty']) ? $chatParams['presence_penalty'] : 1 )}}">
                </div>
        
                <div class="form-group col-lg-6">
                    <label>
                    Your name           
                    </label>
                    <input type="text" name="user_name" class="form-control" value="{{ ( !empty($chatParams['user_name']) ? $chatParams['user_name'] : '') }}">
                </div>
        
                <div class="form-group col-lg-6">
                    <label>AI Model</label>
                    <select class="form-control" name="model">
                    <option value="">Select Model</option>
                    @if( !empty($ai_models) )
                        @foreach($ai_models as $model)            
                        <option value="{{$model}}"  @if( !empty($chatParams['model']) && $chatParams['model']==$model) selected @endif>{{$model}}</option>
                        @endforeach
                    @endif
                    </select>
                </div>
        
                <div class="form-group col-lg-6">
                    <label>
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-success">Save</button>
                    </label>
                </div>
            </form>  
        </div>
    </div>

@endsection