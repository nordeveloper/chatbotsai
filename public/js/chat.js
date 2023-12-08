
$( window ).on( "load", function() { 
    getChatHistory();
});

$(document).ready(function() {

    $('#btn-send').click(function(){
        sendMessage();
        return false;   
    });
   
    // $('#input-form .msg-input').keypress(function(event) {
    //     if (event.keyCode === 13) {
    //       event.preventDefault();
    //       sendMessage();
    //       return false;
    //     }
    // });
});


async function sendMessage(){

    let userInput = $('#input-form .msg-input');   
    $('.chat-messages').append(showLoader());

    appendMessage($('#char-icon').data('user'), 'left', userInput.val());

    $.ajax({
        url: 'chat/send',
        method: 'POST',
        async: true,
        dataType: 'json',
        data: {
            msg: userInput.val(),
            bot: $('#char-icon').data('bot'),
            _token: $('input[name="_token"]').val()
        }

    }).done(function(resp) {        

        $('.loader').remove();

        if(resp.text){
            appendMessage($('#char-icon').data('botname'), 'right', resp.text);
            userInput.val('');
            scrollToBottom();           
        }else if(resp.error){
            appendMessage($('#char-icon').data('botname'), 'right', resp.error.message);
            scrollToBottom();
        }
    });
}
