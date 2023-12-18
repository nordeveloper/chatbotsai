
@extends('main')

@section('scripts')
@if( !empty(request()->type) )
<script type="text/javascript" src="{{asset('js/group_chat.js')}}"></script>
@else
<script type="text/javascript" src="{{asset('js/chat.js')}}"></script>
@endif

@endsection

@section('content')

<div class="chat-page background">
    <div id="messages-box" class="chat-messages">
    
    </div>
    
    <form id="input-form" class="input-message" method="post">
       <textarea class="msg-input" name="msg" placeholder="Type your message"></textarea>
       {{ csrf_field() }}
       <button type="button" id="btn-send" type="button"></button>
    </form>   
</div>

@endsection