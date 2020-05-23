<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge" />
    <meta name="google-signin-client_id" content="384157696038-vk57pjjst7cqcofe2vi3juo240epqkfe.apps.googleusercontent.com">
    <!-- <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous"> -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <!--Import materialize.css-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo URLROOT ?>/css/eventCalendar.css" />
    <link rel="stylesheet" href="<?php echo URLROOT ?>/css/styles.css" />


    <?php if ((isset($data['todayEvents']) and $data['todayEvents'] > 0) ||
        (isset($data['upcomingEventsInHour']) and count($data['upcomingEventsInHour']) > 0)
    ) : ?>
        <title><?php echo SITENAME ?>
            -<?php echo $data['todayEvents'] == 0 ? count($data['upcomingEventsInHour']) : $data['todayEvents']; ?></title>

    <?php else : ?>
        <title><?php echo SITENAME ?></title>
    <?php endif; ?>

</head>

<body>

    <script>

        //function statusChangeCallback(response) { // Called with the results from FB.getLoginStatus().
        //    if (response.status === 'connected') { // Logged into your webpage and Facebook.
        //        fbLogin();
        //    } else { // Not logged into your webpage or we are unable to tell.
        //        window.location = '<?php //echo URLROOT; 
                                        ?>///evCalendar/users/fbLoginProblem';
        //    }
        //}
        //
        //function checkLoginState() {
        //    FB.getLoginStatus(function (response) {
        //        statusChangeCallback(response);
        //    });
        //}
        //
        //
        //function fbLogin() { // Testing Graph API after login.  See statusChangeCallback() for when this call is made.
        //    FB.api('/me', {
        //        fields: 'name, email'
        //    }, function (response) {
        //
        //        let formData = new FormData();
        //        formData.append('email', response.email);
        //
        //        let request = new XMLHttpRequest();
        //        request.open("POST", "<?php //echo URLROOT; 
                                        ?>///users/fbLogin");
        //        request.send(formData);
        //        request.onreadystatechange = function () {
        //            if (request.readyState == XMLHttpRequest.DONE) {
        //                const serverResp = JSON.parse(request.responseText);
        //                if (serverResp.success) {
        //                    window.location = '<?php //echo URLROOT; 
                                                    ?>///';
        //                    return;
        //                }
        //                //if mail is not found on my db
        //
        //                if (response.name) {
        //                    let userFormData = new FormData();
        //                    userFormData.append('name', response.name);
        //                    userFormData.append('email', response.email);
        //                    let regRequest = new XMLHttpRequest();
        //                    regRequest.open("POST", "<?php //echo URLROOT; 
                                                        ?>///users/fbLoginRegUser");
        //                    regRequest.send(userFormData);
        //                    regRequest.onreadystatechange = function () {
        //                        if (regRequest.readyState == XMLHttpRequest.DONE) {
        //                            const serverResp = JSON.parse(regRequest.responseText);
        //                            if (serverResp.success) {
        //                                window.location = '<?php //echo URLROOT; 
                                                                ?>///users/login';
        //                                return;
        //                            }
        //                        }
        //                    }
        //                }
        //                // window.location = '<?php ////echo URLROOT;
                                                ?>///users/fbLoginProblem';
        //            }
        //        }
        //
        //    });
        //}
        //
        //window.fbAsyncInit = function () {
        //    FB.init({
        //        appId: '257837845620450',
        //        autoLogAppEvents: true,
        //        xfbml: true,
        //        version: 'v6.0'
        //    });
        //};
    </script>
    <script src="<?php echo URLROOT ?>/js/FacebookLogin.js"></script>
    <script src="<?php echo URLROOT ?>/js/GoogleLogin.js"></script>
    <script async defer src="https://connect.facebook.net/en_US/sdk.js"></script>
    <script src="https://apis.google.com/js/platform.js" async defer></script>



    <?php require APPROOT . '/views/inc/navbar.php'; ?>

    <div class="container startSplash">