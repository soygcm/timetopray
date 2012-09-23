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

/*FB.login(function(response) {
   if (response.authResponse) {
     var access_token =   FB.getAuthResponse()['accessToken'];
     console.log('Access Token = '+ access_token);
     FB.api('/me', function(response) {
     console.log('Good to see you, ' + response.name + '.');
     });
   } else {
     console.log('User cancelled login or did not fully authorize.');
   }
 }, {scope: ''});
*/

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
