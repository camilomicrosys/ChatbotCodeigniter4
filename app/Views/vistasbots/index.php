<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Online Chating Bot</title>
    <link rel="stylesheet" href="<?php echo base_url('/public/css/bot.css') ?>">
    <script type="text/javascript" src="<?php echo base_url('/public/libreriajquery/jquery.js'); ?>"></script>
<script src="<?php echo base_url('public/ajax/ajax.js') ?>"></script>
</head>
<body id="contenidos">
    <div id="container">
        <div id="dot1"></div>
        <div id="dot2"></div>
        <div id="screen">
            <div id="header">ONLINE CHATBOT</div>
            <div id="messageDisplaySection">
                <!-- bot messages -->
                <!-- <div class="chat botMessages">Hello there, how can I help you?</div> -->

                <!-- usersMessages -->
                <!-- <div id="messagesContainer">
                <div class="chat usersMessages">I need your help to build a website.</div>
            </div> -->
        </div>
        <!-- messages input field -->
        <form id="userInput" method="POST">
           <input type="text" name="messages" id="messages" autocomplete="OFF" placeholder="Escribe tu mensaje" >

           <button class="saludo"   id="send" name="send">Enviar</button> 

       </form>

   </div>
</div>

   


</body>
</html>