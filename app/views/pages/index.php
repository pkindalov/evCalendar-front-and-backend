<?php require_once APPROOT . '/views/inc/header.php' ?>
<?php if (isset($_SESSION['user_id'])) : ?>
    <div class="row blueBorder">
        <div class="col l6 m6 s6">
            <div id="simpleCalendarContainer"></div>
        </div>
        <div id="eventsSection" class="col l12 m12 s12"></div>
        <div id="eventsContainer" class="nonVisible">
            <div class="row">
                <div class="col l12 m12 s12">
                    <div id="mainDateLabel" class="col s6 offset-s3 dateLabel"></div>
                    <div id="closeWindowBtnCont" class="col l2 m2 s2"></div>
                </div>
            </div>
            <div class="row">
                <div class="col l12 m12 s12">
                    <div id="nameOfMonth" class="monthLabel"></div>
                    <div id="yearField" class="yearLabel"></div>
                    <div id="dayName"></div>
                </div>
            </div>
            <div class="row">
                <div class="col l12 m12 s12">
                    <div id="eventsDashboard" class="center-align">
                        <!-- <p class="flow-text">No events planned for today</p> -->
                        <div id="addEventCont"></div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
    <!-- <script>
            document.addEventListener('DOMContentLoaded', function() {
            var elems = document.querySelectorAll('.sidenav');
            var instances = M.Sidenav.init(elems);
        });
    </script>  -->

    <script src="<?php echo URLROOT ?>/js/EventCalendar.js"></script>
    <script src="<?php echo URLROOT ?>/js/LoadingEventCalendar.js"></script>
    

<?php else : ?>

            <!-- <h2 class="header"><?php echo $data['title']; ?></h2> -->
            <div class="card horizontal">
                <div class="card-image">
                    <img src="images/logo.png">
                </div>
                <div class="card-stacked">
                    <div class="card-content">        
                        <p><?php echo $data['description'] ?></p>
                    </div>
                    <!-- <div class="card-action">
                        <a href="#">This is a link</a>
                    </div> -->
                </div>
            </div>
        </div>
    </div>

    <!-- <div class="jumbotron jumbotron-fluid text-center">
        <div class="container">
            <h1 class="display-3"><?php //echo $data['title']; ?></h1>
            <p class="lead"><?php //echo $data['description'] ?></p>
        </div>
    </div> -->

<?php endif; ?>


<?php require_once APPROOT . '/views/inc/footer.php' ?>