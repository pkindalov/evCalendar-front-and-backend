<?php require_once APPROOT . '/views/inc/header.php' ?>
<?php if (isset($_SESSION['user_id'])) : ?>
    <div class="row blueBorder">
        <div class="col s6">
            <div id="simpleCalendarContainer"></div>
        </div>
        <div id="eventsSection" class="col s6"></div>
        <div id="eventsContainer" class="nonVisible">
            <div class="row">
                <div class="col s12">
                    <div id="mainDateLabel" class="col s6 offset-s3 dateLabel"></div>
                    <div id="closeWindowBtnCont" class="col s2"></div>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
                    <div id="nameOfMonth" class="monthLabel"></div>
                    <div id="yearField" class="yearLabel"></div>
                    <div id="dayName"></div>
                </div>
            </div>
            <div class="row">
                <div class="col s12">
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
    <script>
        (async function() {
            let url = '/evCalendar/events/getUserEventsCurrYear';
            let userEventsData = await fetch(url);
            let data = await userEventsData.json(); // read response body and parse as JSON
            
            url = '/evCalendar/events/getUserCalendarSettings';
            let userCalendarSettings = await fetch(url);
            let calendarSettingsData = await userCalendarSettings.json();
            // console.log(calendarSettingsData);

            let evCalendar = new eventCalendar({
                calendarContainer: 'simpleCalendarContainer',
                usingThemes: calendarSettingsData['usingThemes'],
                language: calendarSettingsData['language'],
                calendarEventsData: data,
                notifications: calendarSettingsData['notifications']
                // calendarEventsData: dataEvents
            });
            // evCalendar.setContainer('simpleCalendarContainer');
            // evCalendar.setUseOfThemes(false);
            // evCalendar.setData(dataEvents);
            evCalendar.createCalendar();
        })();
    </script>

<?php else : ?>

    <div class="col s12 m7 startSplash">
        <h2 class="header"><?php echo $data['title']; ?></h2>
        <div class="card horizontal">
            <div class="card-image">
                <img src="images/blueFractal1.png">
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

    <!-- <div class="jumbotron jumbotron-fluid text-center">
        <div class="container">
            <h1 class="display-3"><?php //echo $data['title']; ?></h1>
            <p class="lead"><?php //echo $data['description'] ?></p>
        </div>
    </div> -->

<?php endif; ?>


<?php require_once APPROOT . '/views/inc/footer.php' ?>