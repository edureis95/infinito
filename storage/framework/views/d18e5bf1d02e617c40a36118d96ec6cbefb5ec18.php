<style>
   .chat-app {
   margin: 50px;
   padding-top: 10px;
   }
   .chat-app .message:first-child {
   margin-top: 15px;
   }
   
   .chat-messages-test {
   overflow-wrap: break-word;
   }
   .bubble {
   display: inline-block;
   position: relative;
   background: #F1F0F0;
   border: 1px solid #F1F0F0;
   max-width:250px;
   padding:4px;
   font-family:arial;
   margin:0 auto;
   font-size:14px;
   border-radius: 50% / 10%;
   margin-left: 2%;
   }
   .bubble:before {
   border-radius: 5% / 50%;
   }
   
   .avatar img{
   width: 40px;
   height: 40px;
   padding: 4px;
   float: left;
   }

   .chat-Panel {
    font-size: 10px;
   }


    .usersSelect:hover, .lastMessage:hover {
      background-color: #EEEEEE !important;
      cursor: pointer; 
      cursor: hand;
    }

    #searchUser {
      background-image: url('/images/search-grey-icon.png');
      background-repeat: no-repeat;
      background-size: 9%;
      width: 100%;
    }


</style>
<script>
   // Ensure CSRF token is sent with AJAX requests
   $.ajaxSetup({
       headers: {
           'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
       }
   });
   
   // Added Pusher logging
   Pusher.log = function(msg) {
       console.log(msg);
   };
</script>
<!-- Modal -->
<div id="chat" class="modal fade" tabindex="-1" role="dialog">
   <div class="modal-admin" style="width: 80%; margin: 0 auto; margin-top: 5%;">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-body">
            <!-- /.panel -->
            <div class="chat-panel panel panel-default">
              
              <b id="chatTitle" style="margin-left: 50%; font-size: 16px;"> </b>
              
               <div class="messages panel-body">
                  <div class="row">
                  <div class="col-xs-3" style="overflow-y: scroll; height: 100%;">
                  <input type="text" id="searchUser" onkeyup="searchUserByName()" class="form-control" style="margin-bottom: 3%; height: 6%;" placeholder="    Pesquisa por um utilizador">
                  <div id="usersChoice" class="hidden">
                  <?php $__currentLoopData = $usersList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($user->chat == 'chatNull'): ?>
                  <div class="row usersSelect chatNull" id="userSelected<?php echo e($user->id); ?>">
                  <?php else: ?>
                  <div class="row usersSelect" id="selectUser<?php echo e($user->chat->id); ?>">
                  <?php endif; ?>
                    <div class ="col-xs-12">
                      <img class="img-circle" style="vertical-align: middle; width: 15%;" src="/uploads/avatars/<?php echo e($user->avatar); ?>">
                      <strong class="username"><?php echo e($user->name); ?></strong>
                    </div>
                    <div>
                    </div>
                  </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                  </div>
                  <div id="lastMessages" class="">
                    <?php $__currentLoopData = $generalChats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($chat->lastMessage != ''): ?>
                    <div class="row">
                      <div class="col-xs-12 lastMessage" id="lastMessage<?php echo e($chat->id); ?>" style="padding-top: 5%; padding-bottom: 5%;">
                        
                        <div class="col-xs-3">
                          <span class="chat-img pull-left"/>
                          <img class="img-circle img-responsive" src="/images/logo.png">
                        </div>
                        <div>
                          <strong>Elemento Finito</strong>
                          <br>
                          <span class="messageText" style="color:Grey;">
                          <?php if($chat->lastMessage->user == Auth::user()->id): ?>
                          Tu:
                          <?php endif; ?>
                          <?php echo e($chat->lastMessage->text); ?>

                          </span>
                        </div>
                      </div>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                    <?php $__currentLoopData = $chats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php if($chat->lastMessage != ''): ?>
                    <div class="row">
                      <div class="col-xs-12 lastMessage" id="lastMessage<?php echo e($chat->id); ?>" style="padding-top: 5%; padding-bottom: 5%;">
                        
                        <div class="col-xs-3">
                          <span class="chat-img pull-left"/>
                          <img class="img-circle img-responsive" src="/uploads/avatars/<?php echo e($chat->user->avatar); ?>">
                        </div>
                        <strong><?php echo e($chat->user->name); ?></strong>
                        <br>
                        <span class="messageText" style="color:Grey;">
                        <?php if($chat->lastMessage->user == Auth::user()->id): ?>
                        Tu:
                        <?php endif; ?>
                        <?php echo e($chat->lastMessage->text); ?>

                        </span>
                      </div>
                    </div>
                    <?php endif; ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                  </div>

                  <div class="col-xs-9 clearfix" style="border-left: solid;  border-width: thin">
                    <div class="row">
                      <div class="col-xs-12" style="height: 100%; overflow-y: auto" id="messages-scroller">
                        <ul class="chat chat-messages-test">
                        </ul>
                      </div>
                    </div>
                  </div>
                  </div>
               </div>
               <div class="panel-footer">
                  <div class="input-group">
                   <input id="btn-input" type="text" class="form-control input-sm message-input" placeholder="Type your message here..." />
                   <span class="input-group-btn">
                   <button class="btn btn-warning btn-sm send-message-button" id="btn-chat">
                   Send
                   </button>
                   </span>
                </div>
               </div>
            
            
            </div>
            <!-- /.panel .chat-panel -->
         </div>
            
      </div>
   </div>
</div>


<!-- Modal -->
<div id="addUserChat" class="modal fade" role="dialog">
   <div class="modal-admin">
      <!-- Modal content-->
      <div class="modal-content">
         <div class="modal-body">
            <!-- /.panel -->
            <div class="chat-panel panel panel-default">
               <div class="panel-heading">
                  <p class="text-center">Clica num utilizador para começares a falar com ele!</p>
               </div>
               <!-- /.panel-heading -->
               <div class="messages panel-body">
                  <?php $__currentLoopData = $usersList; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $user): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <?php if($user->id == Auth::user()->id): ?>
                  <div class="col-xs-3 hidden">
                  <?php else: ?> 
                  <div class="col-xs-3">
                  <?php endif; ?>
                    <img class="img img-responsive img-thumbnail" id="user<?php echo e($user->id); ?>" src="/uploads/avatars/<?php echo e($user->avatar); ?>">
                    <p class="text-center"><?php echo e($user->name); ?></p>
                  </div>
                  <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
               </div>
               <!-- /.panel-body -->
               <div class="panel-footer">
                  
               </div>
               <!-- /.panel-footer -->
            </div>
            <!-- /.panel .chat-panel -->
         </div>
         <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
         </div>
      </div>
   </div>
</div>
<script id="chat_message_template" type="text/template">
   <div class="message">
       <div class="avatar">
           <img src="">
       </div>
       <div class="text-display">
           <div class="message-data">
               <!--<span class="author"></span>-->
               <span class="timestamp"></span>
               <span class="seen"></span>
           </div>
           <div class="bubble">
            <p class="message-body"></p>
           </div>
       </div>
   </div>
</script>
<!--<div class="col-xs-1 fixed" style="padding: 0%; width: 6%;" id="sidebar">
   <img src="/images/logo.png" data-toggle="modal" data-target="#chat" style="width:50px; height:50px;margin-left: auto; margin-right: auto; display: block;">
   <?php $__currentLoopData = $chats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
   <img src="/uploads/avatars/<?php echo e($chat->user->avatar); ?>" data-toggle="modal" data-target="#chat" style="width:50px; height:50px;margin-left: auto; margin-right: auto; display: block; margin-top: 10px;">
   <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   </div>-->
<audio id="messageSound" src="/sounds/message.wav" autostart="false" ></audio>
<p class="hidden" id="userEmailElement"><?php echo e(Auth::user()->email); ?></p>
<div id="chatsList" content="<?php echo e($chats); ?>" > </div>
<div id="generalChatsList" content="<?php echo e($generalChats); ?>"> </div>
<div id="usersList" content="<?php echo e($usersList); ?>"> </div>
<div class="col-xs-1 sidebar-right">
    <ul class="nav nav-sidebar2 chatsSidebar">
      <?php $__currentLoopData = $generalChats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $generalChat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <li class="chat-users">
         <div class="image chatModal" contentTitle="<?php echo e($generalChat->name); ?>" id="chat<?php echo e($generalChat->id); ?>" data-toggle="modal" data-target="#chat">
            <img src="/images/logo.png" title="Elemento Finito" class="img img-responsive img-thumbnail" width="75%" style="max-width: 40px; max-height: 40px;"/>
            <img src="/images/messageIcon.png"/ width="40%" class="chatModalBackImage hidden" id="chat<?php echo e($generalChat->id); ?>BackImage">
         </div>
      </li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      <?php $__currentLoopData = $chats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $chat): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <li class="chat-users">
         <div class="image chatModal" contentTitle="<?php echo e($chat->name); ?>" id="chat<?php echo e($chat->id); ?>" data-toggle="modal" data-target="#chat">
            <img src="/uploads/avatars/<?php echo e($chat->user->avatar); ?>" title="<?php echo e($chat->user->name); ?>" class="img img-responsive img-thumbnail" width="75%"/ style="max-width: 40px; max-height: 40px;">
            <img src="/images/messageIcon.png"/ width="40%" class="chatModalBackImage hidden" id="chat<?php echo e($chat->id); ?>BackImage">
         </div>
      </li>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
   </ul>
</div>
<script>
    function searchUserByName() {
      var input = $('#searchUser').val();
      var filter = input.toUpperCase();
      $('#usersChoice .username').each(function() {
        if($(this).text().toUpperCase().indexOf(filter) == -1) {
          $(this).parent().css('display', 'none');
        }
        else {
          $(this).parent().css('display', 'inline-block');
        }
      });
      
    }

    $('#searchUser').click(function() {
      $(this).css('background-image', 'none');
      $('#lastMessages').addClass('hidden');
      $('#usersChoice').removeClass('hidden');
    });

    $('#searchUser').focusout(function() {
      $(this).css('background-image', "url('/images/search-grey-icon.png')");
      $('#usersChoice').addClass('hidden');
      $('#lastMessages').removeClass('hidden');
    });

   function init() {
   // send button click handling
   $('.send-message-button').click(sendMessage);
   $('.message-input').keypress(checkSend);
   }
   
   // Send on enter/return key
   function checkSend(e) {
   if (e.keyCode === 13) {
       return sendMessage();
   }
   }
   
   // Handle the send button being clicked
   function sendMessage() {
   var messageText = $('.message-input').val();
   if(messageText.length < 1) {
       return false;
   }
   
   // Build POST data and make AJAX request
   var data = {chat_text: messageText};
   $.ajax({
       type: "POST",
       url: '/chat/message/' + openedChatBox,
       data: data,
       success: sendMessageSuccess
   });
   
   // Ensure the normal browser event doesn't take place
   return false;
   }
   
   // Handle the success callback
   function sendMessageSuccess() {
   $('.message-input').val('')
   console.log('message sent successfully');
   }
   
   // Build the UI for a new message and add to the DOM
   function addMessage(data) {
   if(data.email != $('#userEmailElement').text()) {
       $('#messageSound')[0].play();
   }

   var chatID = data.chat.substr(4);
   if(data.email == $('#userEmailElement').text()) {
      $('#lastMessage' + chatID).find('.messageText').text('Tu: ' + data.text);
   } else {
      $('#lastMessage' + chatID).find('.messageText').text(data.text);
   }

   if(openedChatBox === data.chat) {
       var dt = new Date();   
       var time = ("0" + dt.getHours()).slice(-2) + ":" + ("0" + dt.getMinutes()).slice(-2);
       $('.time').empty().append(time);
   
       var teste = '<li class="left clearfix">'+
       '<div class="col-xs-1">'+
       '<span class="chat-img pull-left">'+
       '<img src="/uploads/avatars/'+ data.avatar +' " alt="User Avatar" class="img-circle img-responsive"/>'+
       '</span>'+
       '</div>'+
       '<div class="chat-body clearfix">'+
       '<div class="email hidden">' + data.email + '</div>' +
       '<div class="header">'+
       '<strong class="primary-font username">'+ data.username +'</strong>'+
       '<small class="pull-right text-muted timestamp">'+
       '<i class="fa fa-clock-o fa-fw"></i>' + time +
       '</small>'+
       '</div>'+
       '<p>'+
       data.text +
       '</p>'+
       '</div>'+
       '</li>';
       
       // Utility to build nicely formatted time
       //el.find('.timestamp').text(strftime('%H:%M:%S %P', new Date(data.timestamp)));
       
   
       var teste2 = $('.chat-messages-test');

       var lastMsgAuthor = $('.chat-messages-test li').last().find('.email').text();
   
       var timeHtml = '<small class="pull-right text-muted timestamp">'+
       '<i class="fa fa-clock-o fa-fw"></i>' + time +
       '</small>';
   
       if(lastMsgAuthor != data.email)
           teste2.append(teste);
       else {
           teste2.find('.chat-body p').last().append('<p>' + data.text + '</p>');
           teste2.find('.header .timestamp').last().replaceWith(timeHtml);
       }
       
       // Make sure the incoming message is shown
       $('#messages-scroller').scrollTop($('#messages-scroller')[0].scrollHeight);
   }
   else {
       $('#' + data.chat + 'BackImage').removeClass('hidden');
   }
   }
   
   // Creates an activity element from the template
   function createMessageEl() {
   var text = $('#chat_message_template').text();
   var el = $(text);
   return el;
   }
   
   $(init);
   
   /***********************************************/
   var openedChatBox = null;
   
   $('#chat').on('hidden.bs.modal', function (e) {
   openedChatBox = null;
   })
   
   
   $(window).scroll(function(){
   if($(window).scrollTop() < $("#main-nav").height())
       $(".sidebar-right").css({"margin-top": - ($(window).scrollTop()) + "px"});
   else
       $(".sidebar-right").css({"margin-top": - $("#main-nav").height() + "px"});
   });
   
   var chatsList = JSON.parse($('#chatsList').attr("content"));
   
   for(var i = 0; i < chatsList.length; i++) {
   var chat = chatsList[i];
   var channel = pusher.subscribe('chat' + chat.id);
   channel.bind('new-message', addMessage);
   }
   
   var generalChatsList = JSON.parse($('#generalChatsList').attr('content'));
   
   for(var i = 0; i < generalChatsList.length; i++) {
       var chat = generalChatsList[i];
       var channel = pusher.subscribe('chat' + chat.id);
       channel.bind('new-message', addMessage);
   }
   
   $('.chatModal').click(function(event) {
     $('.lastMessage').css('background-color', 'white');
     $('.chat-messages-test li').remove();
     openedChatBox = $(this).attr('id');
     $('#chatTitle').text($(this).attr('contentTitle'));
     var id = openedChatBox.substr(4);
     $('#lastMessage' + id).css('background-color', 'AliceBlue');
     $('#' + openedChatBox + 'BackImage').addClass('hidden');
     loadMessages(openedChatBox);
   });

   $('.lastMessage').click(function(event) {
      $('.lastMessage').css('background-color', 'white');
      $('.chat-messages-test li').remove();
      $(this).css('background-color', 'AliceBlue');
      openedChatBox = $(this).attr('id');
      openedChatBox = openedChatBox.substr(11);
      openedChatBox = 'chat' + openedChatBox;
      $('#' + openedChatBox + 'BackImage').addClass('hidden');
      loadMessages(openedChatBox);
   });

   $('.usersSelect').on('mousedown', function() {
      openedChatBox = $(this).attr('id');
      openedChatBox = openedChatBox.substr(10);
      openedChatBox = 'chat' + openedChatBox;
      $('#' + openedChatBox + 'BackImage').addClass('hidden');
      loadMessages(openedChatBox);
   });

   $('.chatNull').on('mousedown', function() {
      userID = $(this).attr('id');
      userID = userID.substr(12);
      $.ajax({
        type: "GET",
         url: '/createChat/' + userID,
         beforeSend: function() {
             $('.chat-messages-test').html('<img src="/images/ajax-loader.gif" align="middle" >');
         },
         success: function(response) {
             openedChatBox = 'chat' + response;
             var channel = pusher.subscribe(openedChatBox);
             channel.bind('new-message', addMessage);
         }
       });
   });
   
   function loadMessages(chat) {
   var messages;
   $.ajax({
       type: "GET",
       url: '/chat/message/' + openedChatBox,
       beforeSend: function() {
           $('.chat-messages-test').html('<img src="/images/ajax-loader.gif" align="middle" >');
       },
       success: function(response) {
           $('.chat-messages-test img').remove();
           messages = JSON.parse(response);
           writeMessages(messages);
           $('#messages-scroller').scrollTop($('#messages-scroller')[0].scrollHeight);
       }
   });
   }
   
   function writeMessages(messages) {
   
   for(var i = 0; i < messages.length; i++) {
       var userEmail = messages[i].userObject.email;
       var userAvatar = messages[i].userObject.avatar;
       var userName = messages[i].userObject.name;
       var messageText = messages[i].text;
       var dt = new Date(messages[i].created_at);   
       var time = ("0" + dt.getHours()).slice(-2) + ":" + ("0" + dt.getMinutes()).slice(-2);
       $('.time').empty().append(time);
   
       var teste = '<li class="left clearfix">'+
       '<div class="col-xs-1">'+
       '<span class="chat-img pull-left">'+
       '<img src="/uploads/avatars/'+ userAvatar +' " alt="User Avatar" class="img-circle img-responsive"/>'+
       '</span>'+
       '</div>'+
       '<div class="chat-body clearfix">'+
       '<div class="email hidden">' + userEmail + '</div>' +
       '<div class="header">'+
       '<strong class="primary-font username">'+ userName +'</strong>'+
       '<small class="pull-right text-muted timestamp">'+
       '<i class="fa fa-clock-o fa-fw"></i>' + time +
       '</small>'+
       '</div>'+
       '<p>'+
       messageText +
       '</p>'+
       '</div>'+
       '</li>';
       
       // Utility to build nicely formatted time
       //el.find('.timestamp').text(strftime('%H:%M:%S %P', new Date(data.timestamp)));
       
       var teste2 = $('.chat-messages-test');
   
       var lastMsgAuthor = $('.chat-messages-test li').last().find('.email').text();
   
       var timeHtml = '<small class="pull-right text-muted timestamp">'+
       '<i class="fa fa-clock-o fa-fw"></i>' + time +
       '</small>';
   
       if(lastMsgAuthor != userEmail) {
           teste2.append(teste);
       } else {
           teste2.find('.chat-body p').last().append('<p>' + messageText + '</p>');
           teste2.find('.header .timestamp').last().replaceWith(timeHtml);
       }
   }
   }
</script>