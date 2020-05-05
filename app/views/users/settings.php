<?php require APPROOT . '/views/inc/header.php'; ?>
    <div class="row">
        <div class="col l12">
          <h5>Change Password</h5>
          <div>
              <span id="validationMessage">
                  <?php if(isset($data['errpr'])) : ?>
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
    <script>
        const changePasswordForm = document.getElementById('changePasswordForm');
        changePasswordForm.onsubmit = function(){
            return isValidForm();
        }
        function isValidForm(){
            let oldPass = document.getElementById('oldPassword').value;
            let newPassword = document.getElementById('newPassword').value;
            let confirmNewPassword = document.getElementById('confirmNewPassword').value;
            let validationMessage = document.getElementById('validationMessage');
            if(newPassword.length < 4){
                validationMessage.innerText = 'New password is too short.';
                return false;
            }
            if(confirmNewPassword !== newPassword){
                validationMessage.innerText = 'Both passwords don\'t mach';
                return false;
            }
            return true;
        }
    </script>     
<?php require APPROOT . '/views/inc/footer.php'; ?>