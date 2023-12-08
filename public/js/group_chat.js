$( window ).on( "load", function() {
    let user = $('#char-icon').data('user');
    getChatHistory(user);
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

    setTimeout(function(){
        $('.chat-messages').append('<div class="loader"><div></div><div></div><div></div><div></div></div>');    
        let data = {
            bot:to,
            from_bot:from,
            msg: msg
        }
        $.ajax({
            url: 'api.php',
            method: 'POST',
            async: true,
            dataType: 'json',
            data:data
    
        }).done(function(resp) {
    
            $('.loader').remove();
            if(resp.text){                    
                appendMessage(to, 'left', resp.text);
                sendGroupMessage(data.bot, data.from_bot, resp.text);            
            }        
        });
    }, 30000);

}