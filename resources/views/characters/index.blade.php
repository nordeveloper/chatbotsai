@extends('main') 

@section('content')

<div class="row top-bar">
    <div class="col-lg-2">
        <a class="btn btn-success btn-add" href="{{route('characters.create')}}">
            Add Character
        </a>
    </div>
</div>

<div class="row">
    @foreach ($items as $character)
    <div class="col-lg-2 col-md-3 col-sm-6 col-6 char-item-wrapp">
        <?php //dump($character) ?>
        <div class="char-item">
        <a class="chat-link" href="chat?bot={{$character['code']}}">
        @if($character['char_img'])
            <div class="char-img">&nbsp;</div>
        @else
            <div class="char-img">{{$character['name']}}</div>
        @endif
        
        <div>{{$character['name']}}</div>
        </a>
        
        <a class="char-edit-link" href="{{route('characters.edit', $character['id'])}}">Edit</a>
        </div>
    </div>
    @endforeach
</div>

@endsection