@extends('main') 

@section('content')
<div class="card">
    <div class="card-header">
        <p class="h5">Character</p>
    </div>
    <div class="card-body">
        <form action="{{$action_url}}" class="character-form" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}

        <div class="row">
            <div class="col-6">
                <div class="form-group">
                    <label>Char Name</label>
                    <input type="text" name="name" class="form-control" value="<?php echo $character->name?>">
                </div>

                <div class="form-group">
                    <label>Your Name:</label>
                    <input type="text" name="user_name" class="form-control" value="{{ (!empty($character['prompt']['user_name'])? $character['prompt']['user_name'] : '') }}">
                </div>  

                <div class="form-group">
                    <label> NSWF Character:          
                    <input type="hidden" value="">
                    <input type="checkbox" name="nswf" <?php if(!empty($character['nswf'])){ echo 'checked';} ?> value="1">            
                    </label>
                </div>
            </div>

            <div class="col-6">
                <div class="form-group">
                    <label>Char Image</label>
                    <?php if(!empty($character['image'])): ?>
                    <div>
                        <img style="width: 150px;" src="<?php $character['image'] ?>">
                    </div>
                    <?php endif?>
                    <input type="file" name="char_image" class="form-control">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-12">

            <div class="form-group">
                <label>Personality: <span>{char} well be replaced with Char Name</span></label>
                <textarea type="text" name="personality" rows="9" class="form-control">{{ (!empty($character['prompt']['personality']) ? $character['prompt']['personality'] : '') }}</textarea>
            </div>

            <div class="form-group">
                <label>Scenario: <span>{char} well be replaced with Char Name</span></label>
                <textarea type="text" name="scenario" rows="6" class="form-control">{{ (!empty($character['prompt']['scenario']) ? $character['prompt']['scenario'] : '') }}</textarea>
            </div>

            <div class="form-group">
                <label>First message: <span>{char} well be replaced with Char Name</span></label>
                <textarea type="text" name="first_mes" rows="4" class="form-control">{{ (!empty($character['prompt']['first_mes']) ? $character['prompt']['first_mes'] : '') }}</textarea>
            </div>

            <div class="form-group">
                <label>
                    AI System Prompt instruction: <span>{char} well be replaced with Char Name</span>
                </label>
                <textarea type="text" name="system_prompt" rows="10" class="form-control">{{ (!empty($character['prompt']['system_prompt']) ? $character['prompt']['system_prompt'] : '') }}</textarea>
            </div>

            <div class="form-group">
                @if($character->id)
                @method('PATCH')
                @endif

                <button type="submit" name="save" value="Y" class="btn btn-success">Save</button>
            </div>

            </div>
        </div>          

        </form>

        <?php if( !empty($character['name']) ): ?>        
        <form class="action-delete" action="{{ route('characters.destroy', $character['id'])}}" method="post">
            <button class="btn btn-danger pull-right">Remove</button>
            @csrf
            @method('DELETE')
        </form>
        <?php endif ?>

    </div>
</div>

@endsection




