//ojo cuando cambie a un servidor debo cambiar esta base url para que no vaya a fallar
var base_url='http://localhost/bot/';
/*------------------------------------------------------------------------------------------------------------------------------
----------------------
.     Modulo Jquery   Jquery           -
--------------------------
*/


$(document).ready(function(){

    
 //esta linea de codigo dice si el input de msm esta vacio no mostrar el boton y si esta dif de vacio mostrar boton
 $("#messages").on("keyup",function(){

    if($("#messages").val() ){
        $("#send").css("display","block");
        

    }else{
        $("#send").css("display","none");

    }
});
 //esto se llama delegacion de eventos el document obliga a que lera de nuevo todo el documento y como ya puede leer la nueva clase cuando den click se ejecuta la nueva tarea,para delegar el evento solo nececito esta linea document on click btnuno function luego el this donde remuevo prueno colocar "#send" el id dek boton puedo verlo en mi stack over es cuando cambiamos unaclase y le agregamos un evento par poder que la nueva clase entienda el this hace referencia al boton real ya que si solo cambiaos el cambia pero no asigna los eventos a la clase.
 $(document).on('click', ".saludo", function(e)
 {

    e.preventDefault();


    let  userMessage = $("#messages").val();
    let   appendUserMessage = '<div class="chat usersMessages">'+ userMessage +'</div>';
    let boton="1";
    $("#messageDisplaySection").append(appendUserMessage);

    $("#send").removeClass("saludo").addClass("digitaCedula");
            //hasta la linea this va la delegacion cambio  de clase y ya lo que haya de aca para abajo se ejecuta en la clse uno a penas acabe pasa a la 2
            // ajax start
            $.ajax({
                url: base_url+"saludo-citas",
                type: "POST",
                // sending data
                data: {messageValue: userMessage},

                // response text
                success: function(data){


                //$("#send").addClass("btn2");
                    // show response
                    let appendBotResponse = '<div  id="messagesContainer"><div class="chat botMessages"><img src="https://img.icons8.com/windows/32/000000/bot.png"/>'+ data+'</div></div>';
                    $("#messageDisplaySection").append(appendBotResponse);
                    
                }

            });
            

            $("#messages").val("");
            $("#send").css("display","none");
            



        });
//---------------------------------------------
$(document).on('click', ".digitaCedula", function(e)
{
    e.preventDefault();

    let  userMessage = $("#messages").val();
    let   appendUserMessage = '<div class="chat usersMessages">'+ userMessage +'</div>';
    $("#messageDisplaySection").append(appendUserMessage);
    let total_caracteres_cedula=userMessage.length;

    let tipo=isNaN(userMessage);

    if(total_caracteres_cedula >=7 && total_caracteres_cedula <=10 && tipo==false){



            //hasta la linea this va la delegacion cambio  de clase y ya lo que haya de aca para abajo se ejecuta en la clse uno a penas acabe pasa a la 2
            // ajax start
            $.ajax({
                url: base_url+'cedula-consultaws-si-tiene-citas',
                type: "POST",
                // sending data
                data: {messageValue: userMessage},
                // response text
                success: function(data){


                //$("#send").addClass("btn2");
                    // show response
                    if(data=="no"){
                        data="el usuario identificado con cc "+userMessage+" no tiene asignadas citas en el momento"; 
                        let appendBotResponse = '<div id="messagesContainer"><div class="chat botMessages"><img src="https://img.icons8.com/windows/32/000000/bot.png"/>'+ data+'</div></div>';
                        $("#messageDisplaySection").append(appendBotResponse);
                    //en dos mensajes ya aca sacamos el menu de opciones
                    let opcion1="1- Agendamiento de citas";
                    let opcion2="2- Comunicarme con un asesor";
                    

                    data="ingresa el numero de la opcion que deseas realizar:"+'<ul><li>'+opcion1+'</li><li>'+opcion2+'</li></ul>';
                    appendBotResponse = '<div id="messagesContainer"><div class="chat botMessages"><img src="https://img.icons8.com/windows/32/000000/bot.png"/>'+data+'</div></div>';
                    $("#messageDisplaySection").append(appendBotResponse);
                    //$("#send").removeClass("btndos").addClass("btntres");
                    $("#send").removeClass("digitaCedula").addClass("opcionesMenuAgendamientos");
                }else{
                    // si tiene cita   mensajes ya aca sacamos el menu de opciones
                    let opcion1="1- Actualizar tu cita";
                    let opcion2="2- Cancelar tu cita";
                    let opcion3="3- Consultar tu cita";
                    let opcion4="4- Comunicarme con un asesor";
                    

                    data="ingresa el numero de la opcion que deseas realizar:"+'<ul><li>'+opcion1+'</li><li>'+opcion2+'</li><li>'+opcion3+'</li><li>'+opcion4+'</li></ul>';
                    appendBotResponse = '<div id="messagesContainer"><div class="chat botMessages"><img src="https://img.icons8.com/windows/32/000000/bot.png"/>'+data+'</div></div>';
                    $("#messageDisplaySection").append(appendBotResponse);
                    $("#send").removeClass("digitaCedula").addClass("menuppalTieneCita");  
                }





            }


        });
            

            $("#messages").val("");
            $("#send").css("display","none");
            
        }else{
            let data="La cedula que has dijitado es errada por favor digita una valida";
            let appendBotResponse = '<div id="messagesContainer"><div class="chat botMessages"><img src="https://img.icons8.com/windows/32/000000/bot.png"/>'+data+'</div></div>';
            $("#messageDisplaySection").append(appendBotResponse);
            $("#messages").val("");
            $("#send").css("display","none");               
        }
        
        

    });
        //------------------------------


        $(document).on('click', ".opcionesMenuAgendamientos", function(e)
        {   
            e.preventDefault();
            let  userMessage = $("#messages").val();
            let   appendUserMessage = '<div class="chat usersMessages">'+ userMessage +'</div>';
            
            $("#messageDisplaySection").append(appendUserMessage);
            if(userMessage=="1"||userMessage=="2"){

              if(userMessage=="1"){
              //---------------------------------solicitud nombre
              //creamos una funcion con expresion regular para validar que sea texto
              function validarNombre(nombre){
                 const expresionRegular = /^[A-Z a-z]*$/;
                 const sonLetras = expresionRegular.test(nombre);
                 return sonLetras;
             }
             let esNombre=false;

             nombre=[];
             for(let i=0;i<100;i++){
                if(esNombre==false){
                  let nombres= prompt('Por favor escribe tu nombre');
                  esNombre=validarNombre(nombres);
              //como en el pregmach aceptamos letras y espacios si dejan eso avcio pasa el nombre entonces aca lo reversamos a false para que siga solicitando
              if(esNombre==true && nombres==""){
                 esNombre=false;
             }
             if(esNombre==true){
                nombre.push(nombres);
            }

        }
    }
    //como son 100 la primer vez que dijo true guardo el nombre real en la posicion 0 del array
    nombre=nombre[0];
    
    //----------------solicitud correo
    function validarEmail(email){
        const expresionRegular=/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        const esCorreo=expresionRegular.test(email);
        return esCorreo;
    }
     //este es el validador para que dentro del ciclo se vuelva en true
     let esCorreo=false;

     correo=[];
     for(let i=0;i<100;i++){
        if(esCorreo==false){
          let correos= prompt('Por favor escribe tu correo');
          esCorreo=validarEmail(correos);

              //como en el pregmach aceptamos letras y espacios si dejan eso avcio pasa el nombre entonces aca lo reversamos a false para que siga solicitando
              if(esCorreo==true && correos==""){
                 esCorreo=false;
             }
             if(esCorreo==true){
                correo.push(correos);
            }

        }
    }
    correo=correo[0];

  //----------------solicitud de telefono
  function validarTelefono(telefono){
     let total_caracteres_Telefono=telefono.length;

     let tipo=isNaN(telefono);

     if(total_caracteres_Telefono >=7 && total_caracteres_Telefono <=10 && tipo==false){
        esTelefono=true;
    }else{
        esTelefono=false;
    }
    return esTelefono;
}
     //este es el validador para que dentro del ciclo se vuelva en true
     let esTelefono=false;

     telefonos=[];
     for(let i=0;i<100;i++){
        if(esTelefono==false){
          let telefono= prompt('Por favor escribe el numero de tu celular');
          esTelefono=validarTelefono(telefono);
          
              //como en el pregmach aceptamos letras y espacios si dejan eso avcio pasa el nombre entonces aca lo reversamos a false para que siga solicitando
              if(esTelefono==true && telefono==""){
                 esTelefono=false;
             }
             if(esTelefono==true){
                telefonos.push(telefono);
            }

        }
    }
    celular=telefonos[0];


    $.ajax({
        url: base_url+"menuppal-agendamiento",
        type: "POST",
                // sending data
                data: {nombre:nombre,correo:correo,celular:celular},

                // response text
                success: function(data){


                    let appendBotResponse = '<div  id="messagesContainer"><div class="chat botMessages"><img src="https://img.icons8.com/windows/32/000000/bot.png"/>'+ data+'</div></div>';
                    $("#messageDisplaySection").append(appendBotResponse);
                    $("#send").removeClass("opcionesMenuAgendamientos").addClass("seleccionarCita");
                }

            });

}else{
        //aca hacemos el paso hacesor pedimos datos al cliente igual que en el agendamiento lo que cambia es la ruta
       //---------------------------------solicitud nombre
              //creamos una funcion con expresion regular para validar que sea texto
              function validarNombre(nombre){
                 const expresionRegular = /^[A-Z a-z]*$/;
                 const sonLetras = expresionRegular.test(nombre);
                 return sonLetras;
             }
             let esNombre=false;

             nombre=[];
             for(let i=0;i<100;i++){
                if(esNombre==false){
                  let nombres= prompt('Por favor escribe tu nombre');
                  esNombre=validarNombre(nombres);
              //como en el pregmach aceptamos letras y espacios si dejan eso avcio pasa el nombre entonces aca lo reversamos a false para que siga solicitando
              if(esNombre==true && nombres==""){
                 esNombre=false;
             }
             if(esNombre==true){
                nombre.push(nombres);
            }

        }
    }
    //como son 100 la primer vez que dijo true guardo el nombre real en la posicion 0 del array
    nombre=nombre[0];
    
    //----------------solicitud correo
    function validarEmail(email){
        const expresionRegular=/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        const esCorreo=expresionRegular.test(email);
        return esCorreo;
    }
     //este es el validador para que dentro del ciclo se vuelva en true
     let esCorreo=false;

     correo=[];
     for(let i=0;i<100;i++){
        if(esCorreo==false){
          let correos= prompt('Por favor escribe tu correo');
          esCorreo=validarEmail(correos);

              //como en el pregmach aceptamos letras y espacios si dejan eso avcio pasa el nombre entonces aca lo reversamos a false para que siga solicitando
              if(esCorreo==true && correos==""){
                 esCorreo=false;
             }
             if(esCorreo==true){
                correo.push(correos);
            }

        }
    }
    correo=correo[0];

  //----------------solicitud de telefono
  function validarTelefono(telefono){
     let total_caracteres_Telefono=telefono.length;

     let tipo=isNaN(telefono);

     if(total_caracteres_Telefono >=7 && total_caracteres_Telefono <=10 && tipo==false){
        esTelefono=true;
    }else{
        esTelefono=false;
    }
    return esTelefono;
}
     //este es el validador para que dentro del ciclo se vuelva en true
     let esTelefono=false;

     telefonos=[];
     for(let i=0;i<100;i++){
        if(esTelefono==false){
          let telefono= prompt('Por favor escribe el numero de tu celular');
          esTelefono=validarTelefono(telefono);
          
              //como en el pregmach aceptamos letras y espacios si dejan eso avcio pasa el nombre entonces aca lo reversamos a false para que siga solicitando
              if(esTelefono==true && telefono==""){
                 esTelefono=false;
             }
             if(esTelefono==true){
                telefonos.push(telefono);
            }

        }
    }
    celular=telefonos[0];

    $.ajax({
        url: base_url+"menuppal-asesor",
        type: "POST",
                // sending data
                data: {nombre:nombre,correo:correo,celular:celular},

                // response text
                success: function(data){


                    let appendBotResponse = '<div  id="messagesContainer"><div class="chat botMessages"><img src="https://img.icons8.com/windows/32/000000/bot.png"/>'+ data+'</div></div>';
                    $("#messageDisplaySection").append(appendBotResponse);
                    $("#send").removeClass("opcionesMenuAgendamientos").addClass("saludo");
                }

            });
}


$("#messages").val("");
$("#send").css("display","none"); 
}else{
            //hacemos dos datas y 2 apen bot con las mismas respuestas que estan en el boton 2
            let data="No entendi, por favor digita una de las opciones validas";
            let appendBotResponse = '<div id="messagesContainer"><div class="chat botMessages"><img src="https://img.icons8.com/windows/32/000000/bot.png"/>'+data+'</div></div>';
             //en dos mensajes ya aca sacamos el menu de opciones
             let opcion1="1- Agendamiento de citas";
             let opcion2="2- Comunicarme con un asesor";
             

             data="ingresa el numero de la opcion que deseas realizar:"+'<ul><li>'+opcion1+'</li><li>'+opcion2+'</li></ul>';
             $("#messageDisplaySection").append(appendBotResponse);
             appendBotResponse = '<div id="messagesContainer"><div class="chat botMessages"><img src="https://img.icons8.com/windows/32/000000/bot.png"/>'+data+'</div></div>';
             $("#messageDisplaySection").append(appendBotResponse);
             $("#messages").val("");
             $("#send").css("display","none");   
         }



     });
//-------------------------------------------------------------------


//--------------------------

$(document).on('click', ".seleccionarCita", function(e)
{
    e.preventDefault();

    let  userMessage = $("#messages").val();
    let   appendUserMessage = '<div class="chat usersMessages">'+ userMessage +'</div>';
    $("#messageDisplaySection").append(appendUserMessage);
    if(userMessage =="1" || userMessage=="2"){
        $.ajax({
            url: base_url+"cita-agendada",
            type: "POST",
                // sending data
                data: {userMessage: userMessage},

                // response text
                success: function(data){

                   let appendBotResponse = '<div id="messagesContainer"><div class="chat botMessages"><img src="https://img.icons8.com/windows/32/000000/bot.png"/>'+data+'</div></div>';
                   $("#messageDisplaySection").append(appendBotResponse);
                   $("#send").removeClass("seleccionarCita").addClass("saludo");
               }

           });


        $("#messages").val("");
        $("#send").css("display","none");

    }else{
        let data="Debes dijitar una opcion valida 1 o 2";
        let appendBotResponse = '<div id="messagesContainer"><div class="chat botMessages"><img src="https://img.icons8.com/windows/32/000000/bot.png"/>'+data+'</div></div>';
        $("#messageDisplaySection").append(appendBotResponse);
        $("#messages").val("");
        $("#send").css("display","none");               
    }



});

//----------------------------------------------------------------------------------------------------
//si posee cita aca seleccionara una de las 4 opciones
$(document).on('click', ".menuppalTieneCita", function(e)
{
    e.preventDefault();

    let  userMessage = $("#messages").val();
    let   appendUserMessage = '<div class="chat usersMessages">'+ userMessage +'</div>';
    $("#messageDisplaySection").append(appendUserMessage);
    //verificamos que opcion selecciono el cliente
    if(userMessage=="1"){
        $.ajax({
            url: base_url+"mostrar-citas-actualizar",
            type: "POST",
                // sending data
                data: {userMessage: userMessage},

                // response text
                success: function(data){

                   let appendBotResponse = '<div id="messagesContainer"><div class="chat botMessages"><img src="https://img.icons8.com/windows/32/000000/bot.png"/>'+data+'</div></div>';
                   $("#messageDisplaySection").append(appendBotResponse);
                   $("#send").removeClass("menuppalTieneCita").addClass("seleccionarCitaActualizar");
               }

           });


        $("#messages").val("");
        $("#send").css("display","none");
    }else if(userMessage=="2"){
         $.ajax({
            url: base_url+"cancelar-cita",
            type: "POST",
                // sending data
                data: {userMessage: userMessage},

                // response text
                success: function(data){

                   let appendBotResponse = '<div id="messagesContainer"><div class="chat botMessages"><img src="https://img.icons8.com/windows/32/000000/bot.png"/>'+data+'</div></div>';
                   $("#messageDisplaySection").append(appendBotResponse);
                   $("#send").removeClass("menuppalTieneCita").addClass("saludo");
               }

           });


        $("#messages").val("");
        $("#send").css("display","none");
    }else if(userMessage=="3"){
         $.ajax({
            url: base_url+"consulta-mi-cita",
            type: "POST",
                // sending data
                data: {userMessage: userMessage},

                // response text
                success: function(data){

                   let appendBotResponse = '<div id="messagesContainer"><div class="chat botMessages"><img src="https://img.icons8.com/windows/32/000000/bot.png"/>'+data+'</div></div>';
                   $("#messageDisplaySection").append(appendBotResponse);
                   $("#send").removeClass("menuppalTieneCita").addClass("saludo");
               }

           });


        $("#messages").val("");
        $("#send").css("display","none");
    }else if(userMessage=="4"){
          //aca hacemos el paso hacesor pedimos datos al cliente igual que en el agendamiento lo que cambia es la ruta
       //---------------------------------solicitud nombre
              //creamos una funcion con expresion regular para validar que sea texto
              function validarNombre(nombre){
                 const expresionRegular = /^[A-Z a-z]*$/;
                 const sonLetras = expresionRegular.test(nombre);
                 return sonLetras;
             }
             let esNombre=false;

             nombre=[];
             for(let i=0;i<100;i++){
                if(esNombre==false){
                  let nombres= prompt('Por favor escribe tu nombre');
                  esNombre=validarNombre(nombres);
              //como en el pregmach aceptamos letras y espacios si dejan eso avcio pasa el nombre entonces aca lo reversamos a false para que siga solicitando
              if(esNombre==true && nombres==""){
                 esNombre=false;
             }
             if(esNombre==true){
                nombre.push(nombres);
            }

        }
    }
    //como son 100 la primer vez que dijo true guardo el nombre real en la posicion 0 del array
    nombre=nombre[0];
    
    //----------------solicitud correo
    function validarEmail(email){
        const expresionRegular=/^(([^<>()[\]\.,;:\s@\"]+(\.[^<>()[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        const esCorreo=expresionRegular.test(email);
        return esCorreo;
    }
     //este es el validador para que dentro del ciclo se vuelva en true
     let esCorreo=false;

     correo=[];
     for(let i=0;i<100;i++){
        if(esCorreo==false){
          let correos= prompt('Por favor escribe tu correo');
          esCorreo=validarEmail(correos);

              //como en el pregmach aceptamos letras y espacios si dejan eso avcio pasa el nombre entonces aca lo reversamos a false para que siga solicitando
              if(esCorreo==true && correos==""){
                 esCorreo=false;
             }
             if(esCorreo==true){
                correo.push(correos);
            }

        }
    }
    correo=correo[0];

  //----------------solicitud de telefono
  function validarTelefono(telefono){
     let total_caracteres_Telefono=telefono.length;

     let tipo=isNaN(telefono);

     if(total_caracteres_Telefono >=7 && total_caracteres_Telefono <=10 && tipo==false){
        esTelefono=true;
    }else{
        esTelefono=false;
    }
    return esTelefono;
}
     //este es el validador para que dentro del ciclo se vuelva en true
     let esTelefono=false;

     telefonos=[];
     for(let i=0;i<100;i++){
        if(esTelefono==false){
          let telefono= prompt('Por favor escribe el numero de tu celular');
          esTelefono=validarTelefono(telefono);
          
              //como en el pregmach aceptamos letras y espacios si dejan eso avcio pasa el nombre entonces aca lo reversamos a false para que siga solicitando
              if(esTelefono==true && telefono==""){
                 esTelefono=false;
             }
             if(esTelefono==true){
                telefonos.push(telefono);
            }

        }
    }
    celular=telefonos[0];

    $.ajax({
        url: base_url+"menuppal-asesor",
        type: "POST",
                // sending data
                data: {nombre:nombre,correo:correo,celular:celular},

                // response text
                success: function(data){


                    let appendBotResponse = '<div  id="messagesContainer"><div class="chat botMessages"><img src="https://img.icons8.com/windows/32/000000/bot.png"/>'+ data+'</div></div>';
                    $("#messageDisplaySection").append(appendBotResponse);
                    $("#send").removeClass("opcionesMenuAgendamientos").addClass("saludo");
                }

            });



$("#messages").val("");
$("#send").css("display","none"); 
    }else{
        //hacemos dos datas y 2 apen bot con las mismas respuestas que estan en el boton 2
        let data="No entendi, por favor digita una de las opciones validas";
        let appendBotResponse = '<div id="messagesContainer"><div class="chat botMessages"><img src="https://img.icons8.com/windows/32/000000/bot.png"/>'+data+'</div></div>';
        let opcion1="1- Actualizar tu cita";
        let opcion2="2- Cancelar tu cita";
        let opcion3="3- Consultar tu cita";
        let opcion4="4- Comunicarme con un asesor";

        data="ingresa el numero de la opcion que deseas realizar:"+'<ul><li>'+opcion1+'</li><li>'+opcion2+'</li><li>'+opcion3+'</li><li>'+opcion4+'</li></ul>';
        $("#messageDisplaySection").append(appendBotResponse);
        appendBotResponse = '<div id="messagesContainer"><div class="chat botMessages"><img src="https://img.icons8.com/windows/32/000000/bot.png"/>'+data+'</div></div>';
        $("#messageDisplaySection").append(appendBotResponse);
        $("#messages").val("");
        $("#send").css("display","none");
    }



});
//----------------------------------------------------------------
//procedemos actualizar la cita seleccionada
$(document).on('click', ".seleccionarCitaActualizar", function(e)
{
    e.preventDefault();

    let  userMessage = $("#messages").val();
    let   appendUserMessage = '<div class="chat usersMessages">'+ userMessage +'</div>';
    $("#messageDisplaySection").append(appendUserMessage);
    //verificamos que opcion selecciono el cliente
    if(userMessage=="1" || userMessage=="2"){
      
        $.ajax({
            url: base_url+"actualizado-final-cita",
            type: "POST",
                // sending data
                data: {userMessage: userMessage},

                // response text
                success: function(data){
                  
                   let appendBotResponse = '<div id="messagesContainer"><div class="chat botMessages"><img src="https://img.icons8.com/windows/32/000000/bot.png"/>'+data+'</div></div>';
                   $("#messageDisplaySection").append(appendBotResponse);
                   $("#send").removeClass("seleccionarCitaActualizar").addClass("saludo");
               }

           });


        $("#messages").val("");
        $("#send").css("display","none");
    }else{
        //hacemos dos datas y 2 apen bot con las mismas respuestas que estan en el boton 2
        let data="No entendi, por favor digita 1 ó 2";
        let appendBotResponse = '<div id="messagesContainer"><div class="chat botMessages"><img src="https://img.icons8.com/windows/32/000000/bot.png"/>'+data+'</div></div>';
        $("#messages").val("");
        $("#send").css("display","none");
    }



});
//-----------------------------------------------------------------------------------------------

});








