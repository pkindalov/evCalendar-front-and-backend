<?php require APPROOT . '/views/inc/header.php'; ?>
<div class="row">
  <div class="col l12 m12 s12">
    <div class="card card-body bg-light center">
      <?php flash('register_success'); ?>
      <h2>Login</h2>
      <p>Please fill in your credentials to log in</p>
      <form action="<?php echo URLROOT; ?>/users/login" method="post">
        <div class="form-group">
          <label for="email">Email: <sup>*</sup></label>
          <input type="email" name="email" class="form-control form-control-lg <?php echo (!empty($data['email_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['email']; ?>">
          <span class="invalid-feedback"><?php echo $data['email_err']; ?></span>
          <label for="password">Password: <sup>*</sup></label>
          <input type="password" name="password" class="form-control form-control-lg <?php echo (!empty($data['password_err'])) ? 'is-invalid' : ''; ?>" value="<?php echo $data['password']; ?>">
          <span class="invalid-feedback"><?php echo $data['password_err']; ?></span>
          <!-- <input type="submit" value="Login" class="btn btn-success" /> -->
          <button type="submit" class="btn btn-success">
            <span class="material-icons alignVertically">
              input
            </span>
            Login
          </button>
          <a href="<?php echo URLROOT; ?>/users/register" class="btn btn-success">
            <span class="material-icons alignVertically">
              assignment_ind
            </span>
            No account? Register
          </a>
        </div>
      </form>
    </div>
  </div>
</div>
<?php require APPROOT . '/views/inc/footer.php'; ?>