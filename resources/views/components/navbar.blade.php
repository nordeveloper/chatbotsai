<div class="navbar-top container container-lg">

  <button class="navbar-toggler" type="button">
    <span class="navbar-toggler-icon"></span> 
  </button>

  <nav class="navbar">
      <ul class="navbar-nav mr-auto">      
        <li class="nav-item">
          <a class="nav-link" href="{{route('characters.index')}}">Characters</a>
        </li>
  
        <li class="nav-item">
          <a class="nav-link" href="{{route('settings')}}">Settings</a>
        </li>
        
        @if(!empty(Auth::user()->id))
        <li class="nav-item">
          <a class="nav-link" href="{{route('user.profile')}}">Profile</a>
        </li>
  
        <li class="nav-item">
          <a class="nav-link" href="{{route('logout')}}">Logout</a>
        </li>
        @else
        <li class="nav-item">
          <a class="nav-link" href="{{route('login')}}">Login</a>
        </li>
  
        <li class="nav-item">
         <a class="nav-link" href="{{route('register')}}">Register</a>
        </li> 
        @endif
    </ul>
  </nav>


@if(Auth::check() && !empty($bot) )
<div class="char-icon" id="char-icon" data-bot="{{$bot['code']}}" data-botname={{$bot['name']}} data-user="{{Auth::user()->name}}" data-userid="{{Auth::user()->id}}">
  <div class="char-name">
    <a class="remove-history" href="{{ route('chat.removeHistory', ['bot'=>$bot['code']]) }}">New Chat</a><br>
    <span>{{$bot['name']}}</span>
  </div>
    <?php
    $charbgimg = 'background-image:url(img/bot.png)';
    if( !empty($bot['image']) ){
      $charbgimg = 'background-image:url('.$bot['image'].')';
    }
    ?> 
  <a href="{{route('characters.edit', $bot['id'])}}" class="chat-iamge" title="{{$bot['name']}}" style="<?php echo $charbgimg?>"></a> 
</div>
@endif

</div>