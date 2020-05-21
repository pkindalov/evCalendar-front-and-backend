<?php require APPROOT . '/views/inc/header.php'; ?>
<?php if (isset($_SESSION['user_id'])) : ?>
    <div class="row">
        <div class="col l12 m12 s12">
            <h5>Change Password</h5>
            <div>
                <span id="validationMessage">
                    <?php if (isset($data['errpr'])) : ?>
                        echo $data['error'];
                    <? endif; ?>
                </span>
            </div>

            <form id="changePasswordForm" method="post" action="<?php echo URLROOT; ?>/users/changePassword">
                <label for="oldPassword">Old Password</label>
                <input type="password" name="oldPassword" id="oldPassword" />
                <label for="newPassword">Enter new password</label>
                <input type="password" name="newPassword" id="newPassword" />
                <label for="confirmNewPassword">Confirm new password</label>
                <input type="password" name="confirmNewPassword" id="confirmNewPassword" /><br />
                <input type="submit" class="btn btn-success" value="Change" />
            </form>
        </div>
    </div>
    <hr />
<?php endif; ?>

<div class="row">
    <div class="col l12 m12 s12">
    <span id="successResetPass" class="successNotif"></span>
        <h5>Reset Password</h5>
        <label for="email">Enter your email:</label>
        <input type="email" name="email" id="email" />
        <!-- Modal Trigger -->
        <a class="waves-effect waves-light amber darken-3 btn modal-trigger" href="#reset">Reset</a>
        <span id="validMessage" class="validateMsg"></span>

        <!-- Modal Structure -->
        <div id="reset" class="modal">
            <div class="modal-content">
                <h4>Warning! This will reset password.</h4>
                <p>Your password will be reset and the new one will be sent to your email.
                    <span class="warning">This action cannot be reversed back?</span> Are you sure?
                </p>
            </div>
            <div class="modal-footer">
                <a href="#!" id="closeBtn" class="modal-close waves-effect waves-green btn-flat">Cancel</a>
                <a class="btn" id="resetBtn" href="#">Continue</a>
            </div>
        </div>
    </div>
</div>

<div id="spinnerRow" class="row">
    <div class="col l12">
    <div class="preloader-wrapper big active">
      <div class="spinner-layer spinner-blue">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div><div class="gap-patch">
          <div class="circle"></div>
        </div><div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>

      <div class="spinner-layer spinner-red">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div><div class="gap-patch">
          <div class="circle"></div>
        </div><div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>

      <div class="spinner-layer spinner-yellow">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div><div class="gap-patch">
          <div class="circle"></div>
        </div><div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>

      <div class="spinner-layer spinner-green">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div><div class="gap-patch">
          <div class="circle"></div>
        </div><div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>
    </div>                     


    </div>
</div>
<script>
    let spinner = document.getElementById('spinnerRow');
    document.addEventListener('DOMContentLoaded', function(){
        spinner.style.display = 'none';
    });

    const changePasswordForm = document.getElementById('changePasswordForm');
    if (changePasswordForm) {
        changePasswordForm.onsubmit = function() {
            return isValidForm();
        }
    }

    function isValidForm() {
        let oldPass = document.getElementById('oldPassword').value;
        let newPassword = document.getElementById('newPassword').value;
        let confirmNewPassword = document.getElementById('confirmNewPassword').value;
        let validationMessage = document.getElementById('validMessage');
        if (newPassword.length < 4) {
            validationMessage.innerText = 'New password is too short.';
            return false;
        }
        if (confirmNewPassword !== newPassword) {
            validationMessage.innerText = 'Both passwords don\'t mach';
            return false;
        }
        return true;
    }

    //<?php //echo URLROOT; 
        ?>/users/resetPassword
    const resetBtn = document.getElementById('resetBtn');
    resetBtn.addEventListener('click', function() {
        let closeBtn = document.getElementById('closeBtn');
        closeBtn.click();
        let email = document.getElementById('email').value;
        if (!email || email.length < 3 || email.indexOf('@') < 0) {
            let validMessage = document.getElementById('validMessage');
            validMessage.innerText = 'Email is not valid';
            return false;
        }

        let successSpan = document.getElementById('successResetPass');
        let formData = new FormData();
        formData.append('email', email);
        let request = new XMLHttpRequest();
        spinner.style.display = 'block';
        request.open('POST', "<?php echo URLROOT; ?>/users/resetPassword");
        request.send(formData);
        request.onreadystatechange = function(){
            if(request.readyState == XMLHttpRequest.DONE){
                const serverResp = JSON.parse(request.responseText);
                if(serverResp.success){
                    spinner.style.display = 'none';
                    successSpan.innerText = 'The password was reset successful. Email sent to ' + email;
                    // window.location = '<?php //echo URLROOT; ?>/users/login';
                    // return;
                }

                
            }
        }

    });
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>