$(document).ready(function() {
    $('.navbar-top .navbar-toggler').click(function(){
        $('.navbar-top .navbar').toggleClass('active');
    });
});


async function appendMessage(name, side, text) {
    
    const chat_messages = $(".chat-messages");
   
    // text = htmlspecialchars(text);
    text = replaceNewlines(text);
    text = replacePattern(text);

    let modifiedText = replaceCodeWraps(text);

    const msgHTML = `<div class="message-wrap message-${side}">
        <div class="user-name">${name}</div>
        <div class="message">        
        ${modifiedText}
        </div>
    </div>`;
    chat_messages.append(msgHTML);    
    // hljs.highlightAll();
    scrollToBottom();
}

async function getChatHistory(from_bot=null) {

    let bot = $('#char-icon').data('bot');

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

function replaceCodeWraps(text) {
    let regex = /```([^`]+)```/g;
    let replacedText = text.replace(regex, '<pre><code class="language-javascript hljs">$1</code></pre>');
    return replacedText;
}  

function htmlspecialchars(str) {
    const entities = {
      '&': '&amp;',
      '<': '&lt;',
      '>': '&gt;',
      '"': '&quot;',
      "'": '&#039;',
      '*': '<i>',
    };
    return str.replace(/[&<>"']/g, chr => entities[chr] || chr);
}

function replaceToImg(text){
    let inputString = '[image]'+text+'[image]';
    return inputString.replace(/\[image\](.*?)\[image\]/g, '<img src="$1">');
}

function replacePattern(input) {
    const pattern = /\*(.*?)\*/g;
    let output = input.replace(pattern, '<i>$1</i>');
    return output;
}

function replaceNewlines(input) {
  let output = input.replace(/\n/g, "<br>");
  return output;
}

function confirm_remove() {
   return confirm('Are you sure you want to delete');
}

function scrollToBottom() {
    let chatContent = $('#messages-box');
    chatContent.scrollTop(chatContent.prop('scrollHeight'));
}


function showLoader(){
    return'<div class="loader"><div></div><div></div><div></div><div></div></div>';
}