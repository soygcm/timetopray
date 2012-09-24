// var access_token = '';
jQuery(document).ready(function() {
    
    $('#'+fbLoginButtonId).click(function(){
        console.log('click facebook login button');
        var access_token;

        FB.login(function(response) {
            if(response.authResponse) {
                access_token =   FB.getAuthResponse()['accessToken'];
                console.log('Access Token = '+ access_token);
                FB.api('/me', function(user) {

                    $.ajax({
                        type : 'get',
                        url  : facebookLoginUrl,
                        data : ( { 
                            name     :   user.first_name, 
                            surname  :   user.last_name,
                            username :   user.username,
                            id       :   user.id,
                            link     :   user.link,
                            email    :   user.email,
                            session  :   userSession,
                            access_token:access_token
                        } ),
                        dataType : 'json',
                        success : function( data ){
                            //console.log(data);
                            if( data.error == 0){
                                window.location.href = data.redirect;
                                console.log(data.redirect);
                            }else{
                                console.log( data.error );
                                // console.log(data.message);
                                FB.logout();
                            }
                        },
                        error : function(jqXHR, textStatus, errorThrown){
                            console.log(errorThrown);
                        }
                    });
                });    
            }else {
                console.log('User cancelled login or did not fully authorize.');
            }
        }, {scope: facebookPermissions}); 


    })

    $('form').submit(function(){
        console.log('form submited');
        user_id_dest = $('#userid').val();
        console.log(user_id_dest);
        console.log(accessToken);

        FB.ui({
            method: 'send',
            to: user_id_dest, 
            name: 'Encontre un momento para que oremos',
            link: 'http://google.com/',
        },
        function(response) {
            if (response) {
                console.log('Correcto envio');
            } else {
                console.log('Envio incorrecto');
        }
        });


        /*$.ajax({
            type : 'post',
            url  : 'https://graph.facebook.com/'+user_id_dest+'/notifications',
            data : ( { 
                access_token    :   accessToken, 
                href            :   'http://localhost:8888/yii/bazz/locales/13',
                template        :   '{'+userId+'} Tiene en comun un orario contigo para orar!',
            } ),
            dataType : 'json',
            success : function( data ){
                console.log(data);
            },
            error : function(jqXHR, textStatus, errorThrown){
                console.log(errorThrown);
                console.log(textStatus);
            }
        });*/

        return false;
    });


});


    


/*

window.fbAsyncInit = function() {
    FB.init({
                appId: appId, 
                status: status, 
                cookie: cookie,
                xfbml: xfbml,
                oauth: oauth
    });

function updateButton(response) {

    var b = document.getElementById(fbLoginButtonId);
   
        b.onclick = function(){

            FB.login(function(response) {
                if(response.authResponse) {

                    var access_token =   FB.getAuthResponse()['accessToken'];
                    console.log('Access Token = '+ access_token);


                    FB.api('/me', function(user) {

                        //$("#nombre").append(user.username);

                        $.ajax({
                            type : 'get',
                            url  : facebookLoginUrl,
                            data : ( { 
                                name     :   user.first_name, 
                                surname  :   user.last_name,
                                username :   user.username,
                                id       :   user.id,
                                link     :   user.link,
                                email    :   user.email,
                                session  :   userSession,
                                access_token:access_token
                            } ),
                            dataType : 'json',
                            success : function( data ){
                                //console.log(data);
                                if( data.error == 0){
                                    // window.location.href = data.redirect;
                                    console.log(data.redirect);
                                }else{
                                    console.log( data.error );
                                    // console.log(data.message);
                                    FB.logout();
                                }
                            },
                            error : function(jqXHR, textStatus, errorThrown){
                                console.log(errorThrown);
                            }
                        });
                    });    
                }else {
                    console.log('User cancelled login or did not fully authorize.');
                }
            }, {scope: facebookPermissions});   
        }
        
    }
                
    FB.getLoginStatus(updateButton);
    FB.Event.subscribe('auth.statusChange', updateButton);  

    var c = document.getElementById(logoutButtonId);
    if(c){
        c.onclick = function(){
            FB.logout();
        }
    }
};


(function(d){var e,id = "fb-root";if( d.getElementById(id) == null ){e = d.createElement("div");e.id=id;d.body.appendChild(e);}}(document));
(function(d){var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];if (d.getElementById(id)) {return;} js = d.createElement('script'); js.id = id; js.async = true; js.src = "//connect.facebook.net/en_US/all.js"; ref.parentNode.insertBefore(js, ref); }(document));
*/