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
        //     {
        //         id: 3,
        //         date: '2020-02-16',
        //         from: '00:00:00',
        //         to: '18:00:00',
        //         text: 'My brother wife\'s birthday',
        //         checked: false
        //     },
        //     {
        //         id: 4,
        //         date: '2020-02-16',
        //         from: '00:00:00',
        //         to: '18:00:00',
        //         text: 'My brother  birthday',
        //         checked: false
        //     },
        //     {
        //         id: 5,
        //         date: '2020-02-16',
        //         from: '00:00:00',
        //         to: '18:00:00',
        //         text: 'Work meeting',
        //         checked: true
        //     },
        //     {
        //         id: 6,
        //         date: '2020-02-16',
        //         from: '00:00:00',
        //         to: '18:00:00',
        //         text: 'Work meeting',
        //         checked: false
        //     },
        //     {
        //         id: 7,
        //         date: '2020-02-16',
        //         from: '00:00:00',
        //         to: '18:00:00',
        //         text: 'Work meeting',
        //         checked: false
        //     },
        //     {
        //         id: 8,
        //         date: '2020-02-16',
        //         from: '00:00:00',
        //         to: '18:00:00',
        //         text: 'Work meeting',
        //         checked: true
        //     },
        //     {
        //         id: 9,
        //         date: '2020-02-16',
        //         from: '00:00:00',
        //         to: '18:00:00',
        //         text: 'Work meeting',
        //         checked: true
        //     },
        //     {
        //         id: 10,
        //         date: '2020-02-16',
        //         from: '00:00:00',
        //         to: '18:00:00',
        //         text: 'Work meeting',
        //         checked: true
        //     },
        //     {
        //         id: 11,
        //         date: '2020-02-16',
        //         from: '00:00:00',
        //         to: '18:00:00',
        //         text: 'Work meeting',
        //         checked: false
        //     },
        //     {
        //         id: 12,
        //         date: '2020-01-15',
        //         from: '00:00:00',
        //         to: '18:00:00',
        //         text: 'Имам рожден ден :) ',
        //         checked: false
        //     },
        //     {
        //         id: 13,
        //         date: '2020-03-03',
        //         from: '00:00:00',
        //         to: '18:00:00',
        //         text: 'Национален празник по случай освобождението на България',
        //         checked: false
        //     },
        //     {
        //         id: 14,
        //         date: '2020-03-11',
        //         from: '00:00:00',
        //         to: '18:00:00',
        //         text: 'next week test',
        //         checked: true
        //     },
        // ];
        let evCalendar = new eventCalendar({
            calendarContainer: 'simpleCalendarContainer',
            usingThemes: true,
            language: 'bg',
            // calendarEventsData: dataEvents
        });
        // evCalendar.setContainer('simpleCalendarContainer');
        // evCalendar.setUseOfThemes(false);
        // evCalendar.setData(dataEvents);
        evCalendar.createCalendar();


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