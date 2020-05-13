<nav>
  <div class="nav-wrapper">
    <a href="<?php echo URLROOT; ?>" class="brand-logo">
      <span class="material-icons">
        calendar_today
      </span>
      <?php echo SITENAME; ?>
    </a>
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

                <a class="red accent-4" id="searchBtn">
                  <!-- <span class="material-icons">
                    find_in_page
                  </span> -->
                  GO!!
                </a>
                <!-- <input type="button" class="btn red accent-4" id="searchBtn" value="GO!" /> -->


              </div>
            </div>
        </li>

        <!-- <li><a href="<?php echo URLROOT; ?>/users/profile">
            <span class="material-icons">
              account_circle
            </span>
            <?php echo $_SESSION['user_name']; ?>
          </a></li> -->

        <!-- <li><a href="<?php echo URLROOT; ?>/users/settings">
            <span class="material-icons">
              pie_chart
            </span>
            Events Stats
          </a></li> -->
        <!-- Dropdown Trigger -->
        <li>
          <a class='dropdown-trigger' href='#' data-target='dropdownCharts'>
            <span class="material-icons">
              pie_chart
            </span>
            Events Stats
          </a>

          <!-- Dropdown Structure -->
          <ul id='dropdownCharts' class='dropdown-content'>
            <li><a href="<?php echo URLROOT; ?>/events/allWeeksStats">
                <span class="material-icons">
                  pie_chart
                </span>
                All Weeks
              </a></li>
            <li class="divider" tabindex="-1"></li>
            <li><a href="<?php echo URLROOT; ?>/events/allMonthStats">
                <span class="material-icons">
                  pie_chart
                </span>
                All Months
              </a></li>
            <li class="divider" tabindex="-1"></li>
          </ul>

        </li>


        <li><a href="<?php echo URLROOT; ?>/calendarConfigs/userSettings">
            <span class="material-icons">
              date_range
            </span>
            Cal.Settings
          </a></li>

        <li>
          <a class='dropdown-trigger' href='#' data-target='dropdownEvents'>
            <span class="material-icons">
              calendar_today
            </span>
            <?php if ((isset($data['todayEvents']) and $data['todayEvents'] > 0) ||
              (isset($data['upcomingEventsInHour']) and count($data['upcomingEventsInHour']) > 0)
            ) : ?>
              Events<span class="new badge blue">
                <?php echo $data['todayEvents'] == 0 ? count($data['upcomingEventsInHour']) : $data['todayEvents']; ?></span>
            <?php else : ?>
              Events
            <?php endif; ?>
          </a>

          <!-- Dropdown Structure -->
          <ul id='dropdownEvents' class='dropdown-content'>
            <li><a href="<?php echo URLROOT; ?>/events/listMyEvents?year=<?php echo date('Y'); ?>&month=<?php echo date('m'); ?>&page=1">
                <span class="material-icons">
                  calendar_today
                </span>
                My Events
              </a></li>
            <li class="divider" tabindex="-1"></li>
            <li>
              <a href="<?php echo URLROOT; ?>/events/onThisDay">
                <span class="material-icons">
                  calendar_today
                </span>
                On this day
              </a>
            </li>
            <li class="divider" tabindex="-1"></li>
            <li>
              <a href="<?php echo URLROOT; ?>/events/myTodayEvents?page=1">
                <span class="material-icons">
                  calendar_today
                </span>
                <?php if (isset($data['todayEvents']) and $data['todayEvents'] > 0) : ?>
                  Today Tasks<span class="new badge"><?php echo $data['todayEvents']; ?></span>
                <?php else : ?>
                  Today Tasks
                <?php endif; ?>
              </a>
            </li>
            <?php if (count($data['upcomingEventsInHour']) > 0) : ?>
              <li>
                <a href="<?php echo URLROOT; ?>/events/upcomingInHour?page=1">
                  <span class="material-icons">
                    calendar_today
                  </span>
                  Upcoming... soon<span class="new badge"><?php echo count($data['upcomingEventsInHour']); ?></span>
                </a>
              </li>
            <?php endif; ?>
          </ul>
        </li>

        <li><a href="<?php echo URLROOT; ?>/users/settings">
            <span class="material-icons">
              settings
            </span>
            Settings
          </a></li>
        <li>
          <a href="<?php echo URLROOT; ?>/users/logout">
            <span class="material-icons">
              exit_to_app
            </span>
            Logout
          </a>
        </li>
      <?php else : ?>
        <li><a href="<?php echo URLROOT; ?>/users/settings">
            <span class="material-icons">
              settings
            </span>
            Settings
          </a></li>
        <li>

          <!-- Dropdown Trigger -->
          <a class='dropdown-trigger' href='#' data-target='dropdown1'>
            <span class="material-icons">
              compare_arrows
            </span>
            Log In/Register</a>

          <!-- Dropdown Structure -->
          <ul id='dropdown1' class='dropdown-content'>
            <li><a href="<?php echo URLROOT; ?>/users/login">
                <span class="material-icons">
                  exit_to_app
                </span>
                Login
              </a></li>
            <li>
              <a>
                <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
                </fb:login-button>
              </a></li>
            <li class="divider" tabindex="-1"></li>
            <li><a href="<?php echo URLROOT; ?>/users/register">
                <span class="material-icons">
                  create
                </span>
                Register
              </a></li>
            <li><a href="<?php echo URLROOT; ?>/users/recommend">
                <span class="material-icons">
                  create
                </span>
                Recommend
              </a></li>
            <li class="divider" tabindex="-1"></li>
            <li><a href="<?php echo URLROOT; ?>/pages/about">
                <span class="material-icons">
                  info
                </span>
                About
              </a></li>
            <!-- <li><a href="#!">three</a></li>
              <li><a href="#!"><i class="material-icons">view_module</i>four</a></li>
              <li><a href="#!"><i class="material-icons">cloud</i>five</a></li> -->
          </ul>

        </li>
        <!-- <li>
          <div>
            <a>
              <fb:login-button scope="public_profile,email" onlogin="checkLoginState();">
              </fb:login-button>
            </a>
          </div>
        </li> -->
      <?php endif ?>
    </ul>
  </div>
</nav>

<ul class="sidenav" id="mobile-demo">
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
    <!-- <li><a href="<?php //echo URLROOT; 
                      ?>/users/profile">
        <span class="material-icons">
          account_circle
        </span>
        <?php //echo $_SESSION['user_name']; 
        ?>
      </a></li> -->
    <li>
      <a class='dropdown-trigger' href='#' data-target='dropdownChartsMobile'>
        <span class="material-icons">
          pie_chart
        </span>
        Events Stats
      </a>

      <!-- Dropdown Structure -->
      <ul id='dropdownChartsMobile' class='dropdown-content'>
        <li><a href="<?php echo URLROOT; ?>/events/allWeeksStats">
            <span class="material-icons">
              pie_chart
            </span>
            All Weeks
          </a></li>
        <li class="divider" tabindex="-1"></li>
        <li><a href="<?php echo URLROOT; ?>/events/allMonthStats">
            <span class="material-icons">
              pie_chart
            </span>
            All Months
          </a></li>
      </ul>
    </li>
    <li><a href="<?php echo URLROOT; ?>/calendarConfigs/userSettings">
        <span class="material-icons">
          date_range
        </span>
        Cal.Settings
      </a></li>
    <li>
      <a class='dropdown-trigger' href='#' data-target='dropdownEventsMobile'>
        <span class="material-icons">
          calendar_today
        </span>
        <?php if ((isset($data['todayEvents']) and $data['todayEvents'] > 0) ||
          (isset($data['upcomingEventsInHour']) and count($data['upcomingEventsInHour']) > 0)
        ) : ?>
          Events<span class="new badge blue">
            <?php echo $data['todayEvents'] == 0 ? count($data['upcomingEventsInHour']) : $data['todayEvents']; ?></span>
        <?php else : ?>
          Events
        <?php endif; ?>
      </a>

      <!-- Dropdown Structure -->
      <ul id='dropdownEventsMobile' class='dropdown-content'>
        <li><a href="<?php echo URLROOT; ?>/events/listMyEvents?year=<?php echo date('Y'); ?>&month=<?php echo date('m'); ?>&page=1">
            <span class="material-icons">
              calendar_today
            </span>
            My Events
          </a></li>
        <li class="divider" tabindex="-1"></li>
        <li>
          <a href="<?php echo URLROOT; ?>/events/onThisDay">
            <span class="material-icons">
              calendar_today
            </span>
            On this day
          </a>
        </li>
        <li class="divider" tabindex="-1"></li>
        <li>
          <a href="<?php echo URLROOT; ?>/events/myTodayEvents?page=1">
            <span class="material-icons">
              calendar_today
            </span>
            <?php if (isset($data['todayEvents']) and $data['todayEvents'] > 0) : ?>
              Today Tasks<span class="new badge"><?php echo $data['todayEvents']; ?></span>
            <?php else : ?>
              Today Tasks
            <?php endif; ?>
          </a>
        </li>
        <?php if (count($data['upcomingEventsInHour']) > 0) : ?>
          <li>
            <a href="<?php echo URLROOT; ?>/events/upcomingInHour?page=1">
              <span class="material-icons">
                calendar_today
              </span>
              Upcoming... soon<span class="new badge"><?php echo count($data['upcomingEventsInHour']); ?></span>
            </a>
          </li>
        <?php endif; ?>
      </ul>
    </li>
    <!-- <li><a href="<?php echo URLROOT; ?>/events/listMyEvents?year=<?php echo date('Y'); ?>&month=<?php echo date('m'); ?>&page=1">
        <span class="material-icons">
          calendar_today
        </span>
        My Events
      </a></li> -->
    <li><a href="<?php echo URLROOT; ?>/users/settings">
        <span class="material-icons">
          settings
        </span>
        Settings
      </a></li>
    <li><a href="<?php echo URLROOT; ?>/users/logout">
        <span class="material-icons">
          exit_to_app
        </span>
        Logout
      </a></li>
  <?php else : ?>
    <li><a href="<?php echo URLROOT; ?>/users/register">
        <span class="material-icons">
          create
        </span>
        Register
      </a></li>
    <li><a href="<?php echo URLROOT; ?>/users/login">
        <span class="material-icons">
          exit_to_app
        </span>
        Login
      </a></li>

    <li><a href="<?php echo URLROOT;
                  ?>/users/settings">
        <span class="material-icons">
          settings
        </span>
        Settings
      </a></li>
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