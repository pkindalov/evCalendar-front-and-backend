<?php require_once APPROOT . '/views/inc/header.php' ?>
<?php if (isset($_SESSION['user_id'])) : ?>
    <div class="row">
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
    <script src="<?php echo URLROOT ?>/js/EventCalendar.js"></script>
    <script>
        // let dataEvents = [{
        //         id: 1,
        //         date: '2020-02-16',
        //         from: '00:00:00',
        //         to: '18:00:00',
        //         text: 'Mother\'s birthday',
        //         checked: false
        //     },
        //     {
        //         id: 2,
        //         date: '2020-02-16',
        //         from: '00:00:00',
        //         to: '18:00:00',
        //         text: 'Father\'s birthday',
        //         checked: false
        //     },
        // ];

        (async function() {
            let url = '/evCalendar/events/getUserEventsCurrYear';
            let response = await fetch(url);
            let data = await response.json(); // read response body and parse as JSON
            let evCalendar = new eventCalendar({
                calendarContainer: 'simpleCalendarContainer',
                usingThemes: true,
                language: 'bg',
                calendarEventsData: data
                // calendarEventsData: dataEvents
            });
            // evCalendar.setContainer('simpleCalendarContainer');
            // evCalendar.setUseOfThemes(false);
            // evCalendar.setData(dataEvents);
            evCalendar.createCalendar();
        })();




        // let data = '<?php //echo $data['events'] ?>';
        // console.log( JSON.parse(data));
        // let evCalendar = new eventCalendar({
        //     calendarContainer: 'simpleCalendarContainer',
        //     usingThemes: true,
        //     language: 'bg',
        //     calendarEventsData: JSON.parse(data)
        //     // calendarEventsData: dataEvents
        // });
        // // evCalendar.setContainer('simpleCalendarContainer');
        // // evCalendar.setUseOfThemes(false);
        // // evCalendar.setData(dataEvents);
        // evCalendar.createCalendar();


        // let todayNum = evCalendar.getTodayNum();

        // let dateLabel = document.getElementById('mainDateLabel');
        // dateLabel.innerText = todayNum;
    </script>

<?php else : ?>

    <div class="jumbotron jumbotron-fluid text-center">
        <div class="container">
            <h1 class="display-3"><?php echo $data['title']; ?></h1>
            <p class="lead"><?php echo $data['description'] ?></p>
        </div>
    </div>

<?php endif; ?>


<?php require_once APPROOT . '/views/inc/footer.php' ?>