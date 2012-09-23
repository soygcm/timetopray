
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