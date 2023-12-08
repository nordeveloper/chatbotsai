
@extends('main')

@section('scripts')
<script type="text/javascript" src="{{asset('js/chat.js')}}"></script>
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