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
        </div>
        <div class="gap-patch">
          <div class="circle"></div>
        </div>
        <div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>

      <div class="spinner-layer spinner-red">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div>
        <div class="gap-patch">
          <div class="circle"></div>
        </div>
        <div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>

      <div class="spinner-layer spinner-yellow">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div>
        <div class="gap-patch">
          <div class="circle"></div>
        </div>
        <div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>

      <div class="spinner-layer spinner-green">
        <div class="circle-clipper left">
          <div class="circle"></div>
        </div>
        <div class="gap-patch">
          <div class="circle"></div>
        </div>
        <div class="circle-clipper right">
          <div class="circle"></div>
        </div>
      </div>
    </div>


  </div>
</div>
<script src="<?php echo URLROOT ?>/js/ChangeReset.js"></script>
<?php require APPROOT . '/views/inc/footer.php'; ?>