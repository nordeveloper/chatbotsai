$( window ).on( "load", function() {
    getHistory();
});

$(document).ready(function() {
    $('#btn-send').click(function(){
        let msg  = $('#input-form .msg-input').val();
        let tobot = $('#char-icon').data('bot');
        let user = $('#char-icon').data('user');
        sendGroupMessage(user, tobot, msg);
        return false;   
    });    
});


async function sendGroupMessage(from, to,  msg){

    $('.chat-messages').append('<div class="loader"><div></div><div></div><div></div><div></div></div>');    
    let data = {
        bot:to,
        from_bot:from,
        msg: msg,
        _token: $('input[name="_token"]').val()
    }
    $.ajax({
        url: 'chat/send',
        method: 'POST',
        async: true,
        dataType: 'json',
        data:data

    }).done(function(resp) {

        if(resp.text){
            console.log(resp);
            $('.loader').remove();
            if(resp.text){                    
                appendMessage(to, 'left', resp.text);
                setTimeout(function(){                
                    sendGroupMessage(data.bot, data.from_bot, resp.text); 
                }, 25000);                           
            }
        }

    });
}


async function getHistory() {

    let bot = $('#char-icon').data('bot');
    let from_bot = $('#char-icon').data('user');

    let data = {bot:bot, from_bot:from_bot}

    $.ajax({
        url: 'chat/getHistory',
        method: 'GET',
        dataType: 'json',
        async: true,
        data:data

    }).done( function(resp){

        if(resp){
            resp.forEach((jsonObject) => {

                if(jsonObject.role=='user'){
                    appendMessage($('#char-icon').data('user'), 'left', jsonObject.content);
                }
                else if(jsonObject.role=='assistant'){
                    appendMessage($('#char-icon').data('botname'), 'right', jsonObject.content);
                }
                scrollToBottom();
            });
        }
    });
}