<nav>
  <div class="nav-wrapper">
    <a href="<?php echo URLROOT; ?>" class="brand-logo"><?php echo SITENAME; ?></a>
    <a href="#" data-target="mobile-demo" class="sidenav-trigger"><i class="material-icons">menu</i></a>
    <ul class="right hide-on-med-and-down">
      <!-- <li><a href="<?php echo URLROOT; ?>/pages/about"">About</a></li> -->
      <?php if (isset($_SESSION['user_id'])) : ?>
        <li>
          <div class="center row">
            <div class="col s12 ">
              <div class="row">
                <div class="input-field col s8 white-text">
                  <i class="white-text material-icons prefix">search</i>
                  <input type="text" placeholder="search" id="autocomplete-input" class="autocomplete white-text">
                </div>

                <a class="red accent-4" id="searchBtn">Go!</a>
                <!-- <input type="button" class="btn red accent-4" id="searchBtn" value="GO!" /> -->


              </div>
            </div>
        </li>



        <li><a href="<?php echo URLROOT; ?>/calendarConfigs/userSettings">Cal.Settings</a></li>
        <li><a href="<?php echo URLROOT; ?>/events/listMyEvents?year=<?php echo date('Y'); ?>&month=<?php echo date('m'); ?>&page=1">My Events</a></li>
        <li><a href="<?php echo URLROOT; ?>/users/settings">Settings</a></li>
        <li><a href="<?php echo URLROOT; ?>/users/logout">Logout</a></li>
        <?php else : ?>
          <li><a href="<?php echo URLROOT; ?>/users/register">Register</a></li>
          <li><a href="<?php echo URLROOT; ?>/users/login">Login</a></li>
          <li><a href="<?php echo URLROOT; ?>/users/settings">Settings</a></li>
        <li>
          <div>
            <a>
            <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
            </fb:login-button>
            </a>
          </div>
        </li>
      <?php endif ?>
    </ul>
  </div>
</nav>

<ul class="sidenav" id="mobile-demo">
  <!-- <li><a href="<?php echo URLROOT; ?>/pages/about"">About</a></li> -->
  <?php if (isset($_SESSION['user_id'])) : ?>
    <li>
      <div class="center row">
        <div class="col s12 ">
          <div class="row">
            <div class="input-field col s8 red-text">
              <i class="red-text material-icons prefix">search</i>
              <input type="text" placeholder="search" id="autocomplete-input-nav" class="autocomplete red-text">
              <a class="btn red accent-4" href="#" id="searchBtnNav">Go!</a>
            </div>
          </div>
        </div>
      </div>
    </li>
    <li><a href="<?php echo URLROOT; ?>/calendarConfigs/userSettings">Cal.Settings</a></li>
    <li><a href="<?php echo URLROOT; ?>/events/listMyEvents?year=<?php echo date('Y'); ?>&month=<?php echo date('m'); ?>&page=1">My Events</a></li>
    <li><a href="<?php echo URLROOT; ?>/users/settings">Settings</a></li>
    <li><a href="<?php echo URLROOT; ?>/users/logout">Logout</a></li>
    <?php else : ?>
      <li><a href="<?php echo URLROOT; ?>/users/register">Register</a></li>
      <li><a href="<?php echo URLROOT; ?>/users/login">Login</a></li>
      <li><a href="<?php echo URLROOT; ?>/users/settings">Settings</a></li>
    <li>
      <div class="moveLeft">
        <a>
          <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
          </fb:login-button>
        </a>
      </div>
    </li>
  <?php endif ?>
</ul>



<!-- <nav class=" navbar navbar-expand-lg navbar-dark bg-dark mb-3">
        <div class="container">
          <a class="navbar-brand" href="<?php //echo URLROOT; 
                                        ?>"><?php //echo SITENAME; 
                                            ?></a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="navbarsExampleDefault">
            <ul class="navbar-nav mr-auto">
              <li class="nav-item">
                <a class="nav-link" href="<?php //echo URLROOT; 
                                          ?>">Home</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php //echo URLROOT; 
                                          ?>/pages/about">About</a>
              </li>
            </ul>

            <ul class="navbar-nav ml-auto">
              <?php //if (isset($_SESSION['user_id'])) : 
              ?>
              <li class="nav-item">
                <a class="nav-link" href="<?php //echo URLROOT; 
                                          ?>/users/logout">Logout</a>
              </li>
              <?php //else : 
              ?>
              <li class="nav-item">
                <a class="nav-link" href="<?php //echo URLROOT; 
                                          ?>/users/register">Register</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="<?php //echo URLROOT; 
                                          ?>/users/login">Login</a>
              </li>
              <?php //endif 
              ?>
            </ul>
          </div>
        </div>
</nav> -->