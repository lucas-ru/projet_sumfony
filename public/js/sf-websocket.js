/* globals wsUrl: true */

window.addEventListener("DOMContentLoaded", (event) => {
  (function () {
    'use strict';

    // let userName = prompt('Hi! I need your name for the Chat please :)');
    let _receiver = document.querySelector('#ws-content-receiver');
    let ws = new WebSocket('ws://' + wsUrl);
    let wsClosed = false;
    let botName = 'ChatBot';

    let _textInput = document.querySelector('#ws-content-to-send');
    let _textSender = document.querySelector('#ws-send-content');
    let enterKeyCode = 13;

    let sendTextInputContent = function () {
      // Get text input content
      let content = _textInput.value;

      // Send it to WS
      ws.send(JSON.stringify({
        action: 'message',
        user: userName,
        message: content,
        channel: chanAnswer
      }));

      if (userName != botName && !wsClosed) {
        $.ajax({
			    type: "POST",
			    url: "/post/sendmsg",
			    data: { content:content,authorMsg:userName,chatName:chanAnswer },
			    dataType: "json",
			    success: function(result){
            console.log(result);
			    }
  			});
      }

      // Reset input
      _textInput.value = '';
    };

    let addMessageToChannel = function(message) {
      let obj = JSON.parse(message)
      let currentdate = new Date();
      let datetime =  ('0' + currentdate.getDate()).slice(-2) + "/"
                      + ('0' + (currentdate.getMonth() + 1)).slice(-2)  + "/"
                      + currentdate.getFullYear() + " à "
                      + ('0' + currentdate.getHours()).slice(-2) + ":"
                      + ('0' + currentdate.getMinutes()).slice(-2);

      _receiver.innerHTML += '<div class="message">'+
                                '<div class="messageLeft">'+
                                  '<span class="messageAuthor">' + obj.user +' : </span>'+
                                  '<span class="messageContent"> ' + obj.message +' </span>'+
                                '</div>'+
                                '<span class="messageDate"> ' + datetime +' </span>'+
                              '</div>';

      //permet de scroll au dernier message
      let scrollHeight = Math.max(_receiver.scrollHeight, _receiver.clientHeight);
      _receiver.scrollTop = scrollHeight - _receiver.clientHeight;
    };

    let botMessageToGeneral = function (message) {
      return addMessageToChannel(JSON.stringify({
        action: 'message',
        channel: chanAnswer,
        user: botName,
        message: message
      }));
    };

    ws.onopen = function () {
      ws.send(JSON.stringify({
        action: 'subscribe',
        channel: chanAnswer,
        user: userName
      }));
    };

    ws.onmessage = function (event) {
      addMessageToChannel(event.data);
    };

    ws.onclose = function () {
      botMessageToGeneral('Connection closed');
      wsClosed = true;
    };

    ws.onerror = function () {
      botMessageToGeneral('An error occured!');
      wsClosed = true;
    };


    _textSender.onclick = sendTextInputContent;
    _textInput.onkeyup = function(e) {
      // Check for Enter key
      if (e.keyCode === enterKeyCode) {
        sendTextInputContent();
      }
    };
  })();
});
