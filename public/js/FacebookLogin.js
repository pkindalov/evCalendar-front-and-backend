const URLROOT = 'https://192.168.0.125/evCalendar';

function statusChangeCallback(response) { // Called with the results from FB.getLoginStatus().
    if (response.status === 'connected') { // Logged into your webpage and Facebook.
        fbLogin();
    } else { // Not logged into your webpage or we are unable to tell.
        window.location = URLROOT + '/users/fbLoginProblem';
    }
}

function checkLoginState() {
    FB.getLoginStatus(function (response) {
        statusChangeCallback(response);
    });
}


function fbLogin() { // Testing Graph API after login.  See statusChangeCallback() for when this call is made.
    FB.api('/me', {
        fields: 'name, email'
    }, function (response) {

        let formData = new FormData();
        formData.append('email', response.email);

        let request = new XMLHttpRequest();
        request.open("POST", URLROOT + "/users/fbLogin");
        request.send(formData);
        request.onreadystatechange = function () {
            if (request.readyState == XMLHttpRequest.DONE) {
                const serverResp = JSON.parse(request.responseText);
                if (serverResp.success) {
                    window.location = URLROOT + '/';
                    return;
                }
                //if mail is not found on my db

                if (response.name) {
                    let userFormData = new FormData();
                    userFormData.append('name', response.name);
                    userFormData.append('email', response.email);
                    let regRequest = new XMLHttpRequest();
                    regRequest.open("POST", URLROOT + "/users/fbLoginRegUser");
                    regRequest.send(userFormData);
                    regRequest.onreadystatechange = function () {
                        if (regRequest.readyState == XMLHttpRequest.DONE) {
                            const serverResp = JSON.parse(regRequest.responseText);
                            if (serverResp.success) {
                                window.location = URLROOT + '/users/login';
                                return;
                            }
                        }
                    }
                }
                // window.location = '<?php //echo URLROOT;?>/users/fbLoginProblem';
            }
        }

    });
}

window.fbAsyncInit = function () {
    FB.init({
        appId: '257837845620450',
        autoLogAppEvents: true,
        xfbml: true,
        version: 'v6.0'
    });
};