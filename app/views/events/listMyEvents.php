<?php require_once APPROOT . '/views/inc/header.php' ?>
<!--     <pre>-->
<!--        --><?php //print_r($data['sortedData']); 
                ?>
<!--    </pre>-->
<!--     --><?php //print_r($data['chartJsData']); 
            ?>
<!-- <?php //echo date('Y-m-d');
        ?> -->


<div class="row center-align">
    <div class="col l12 m12 s12">
        <div class="input-field">
            <select name="selectedYear">
                <?php
                $year = intval($data['year']);
                $upLimit = $year + 20;
                $downLimit = $year - 40;
                for ($i = $upLimit; $i >= $downLimit; $i--) {
                    if ($i === intval($data['year'])) {
                        echo '<option value="' . ($i) . '" disabled selected>' . ($i) . '</option>';
                    } else {
                        echo '<option value="' . ($i) . '">' . ($i) . '</option>';
                    }
                    //  echo $i . "<br />";
                }


                // $counter = 0;
                // $year = isset($data['year']) ? intval($data['year']) : intval(date('Y'));

                // while ($counter < 40) {
                //     echo '<option value="' . ($year) . '">' . ($year) . '</option>';
                //     $year--;
                //     $counter++;
                // }
                ?>
            </select>
            <label>Year</label>
        </div>
    </div>
</div>
<div class="row">
    <div class="col l12 m12 s12">
        <div class="input-field">
            <select name="selectedMonth" class="icons">
                <?php
                $counter = 1;
                $month = isset($data['month']) ? intval($data['month']) : intval(date('m'));
                $month = $month < 10 ? '0' . $month : '' . $month;
                $monthStr = $month < 10 ? '0' . $month : '' . $month;
                $monthNames = [
                    '01' => 'January',
                    '02' => 'February',
                    '03' => 'March',
                    '04' => 'April',
                    '05' => 'May',
                    '06' => 'June',
                    '07' => 'July',
                    '08' => 'August',
                    '09' => 'September',
                    '10' => 'October',
                    '11' => 'November',
                    '12' => 'December',
                ];
                echo '<option value="' . $data['month'] . '" disabled selected>' . $monthNames[$data['month']] . '</option>';

                while ($counter <= 12) {
                    $monthStr = $counter < 10 ? '0' . $counter : '' . $counter;
                    echo $month;
                    if ($monthStr !== $month) {
                        echo '<option data-icon="images/sample-1.jpg" value="' . ($monthStr) . '">' . $monthNames[$monthStr] . '</option>';
                    }
                    $counter++;
                }
                ?>
                <!-- <option value="" data-icon="images/sample-1.jpg">example 1</option>
                        <option value="" data-icon="images/office.jpg">example 2</option>
                        <option value="" data-icon="images/yuna.jpg">example 3</option> -->
            </select>
            <label>Months</label>
        </div>
    </div>
</div>

<div class="row">
    <div class="col l12 m12 s12">
        <a href="#" id="evAddBtn">
            <i class="material-icons alignVertically">add</i>
            <span>Add Event</span>
        </a>

        <!-- <a href="#" id="evAddFileBtn">
            <i class="material-icons alignVertically">description</i>
            <span>Add Events From File</span>
        </a>
        <div id="addEventForm" class="mailField">
            <form method="post" action="<?php echo URLROOT; ?>/events/uploadEvents" method="post" enctype="multipart/form-data">
                <h2>Upload File</h2>
                <label for="fileSelect">Filename:</label>
                <input type="file" name="eventsFile" id="fileSelect">
                <input type="submit" name="submit" value="Upload">
                <p><strong>Note:</strong> Only .doc formats allowed to a max size of 5 MB.</p>
            </form>
        </div> -->

    </div>
</div>

<!-- Google chart here -->
<!--    <div class="row">-->
<!--        <div class="col l12">-->
<!--            <div id="chart_div"></div>-->
<!--        </div>-->
<!--    </div>-->

<div class="row center-align">
    <div class="col l12 m12 s12">
        <canvas id="eventsChart"></canvas>
    </div>
</div>

<?php foreach ($data['sortedData'] as $key => $eventsData) : ?>
<div class="center-align" id="<?php echo $key; ?>">
    <h2 id="<?php echo $key; ?>" class="<?php if ($key === date('Y-m-d')) echo 'blue lighten-1' ?>"><?php echo $key; ?>
    </h2>


    <button onclick="showMailForm('<?php echo $key; ?>')" class="btn">
        <span class="material-icons alignVertically">
            email
        </span>
        Mail
    </button>

    <!-- <?php //echo gettype(json_decode($data['sortedDataJSON'])); 
                ?> -->

    <button onclick="genWordFileAndDownload('<?php echo $key; ?>');" class="btn">
        <span class="material-icons alignVertically">
            description
        </span>
        Word
    </button>

    <div>
        <input class="col-md-6 mailField" type="email" id="input<?php echo $key; ?>" /><br />
        <span id="invalidMailSpan<?php echo $key; ?>" class="mailField validateMsg"></span>
        <button id="sendMailBtn<?php echo $key; ?>" onclick="sendMailTo('<?php echo $key; ?>')"
            class="btn marginCenter mailField">
            <span class="material-icons alignVertically">
                send
            </span>
            <span>Send</span>
        </button>

        <div id="progress<?php echo $key; ?>" class="progress mailField">
            <div class="indeterminate"></div>
        </div>

    </div>


    <?php foreach ($eventsData as $key => $event) : ?>
    <div>
        <div class="col s12 m7 <?php if ($event['date'] === date('Y-m-d')) echo 'blue lighten-1' ?> center-align">
            <!-- <h2 class="header"><?php //echo $event['date']; 
                                            ?></h2> -->
            <div class="card horizontal">
                <div class="card-image">
                </div>
                <div class="card-stacked">
                    <div class="card-content">
                        <div id="checkedDay<?php echo $event['date']; ?>Num<?php echo $key; ?>"
                            class="leftAligned mailField">
                            <label>
                                <input type="checkbox" />
                                <span>Choose to send</span>
                            </label>
                        </div>
                        <?php if ($event['checkedEvent']) : ?>
                        <h6 class="checkedEvent">
                            <?php echo $event['text']; ?>
                        </h6>
                        <hr />
                        <?php else : ?>
                        <h6>
                            <?php echo $event['text']; ?>
                        </h6>
                        <hr />
                        <?php endif; ?>
                        <div class="left-align">
                            <p>Begin: <?php echo $event['begin']; ?></p>
                            <p>Finish: <?php echo $event['finish']; ?></p>
                            <p>Date: <?php echo $event['date']; ?></p>
                            <!-- <p>Checked: <?php //echo $event['checkedEvent']; 
                                                        ?> </p> -->
                            <p>Notification
                                Turned <?php echo $event['showNotification'] == 1 ? "ON" : "OFF"; ?></p>
                        </div>
                        <hr />
                        <div class="left-align">
                            <?php if (isset($event['isMonthly']) && $event['isMonthly'] == 1) : ?>
                            <label>
                                <input type="checkbox" disabled="disabled" checked="checked" />
                                <span>Montly</span>
                            </label>
                            <br />
                            <?php else : ?>
                            <label>
                                <input type="checkbox" disabled="disabled" />
                                <span>Not Monthly Currently</span>
                            </label>
                            <br />
                            <?php endif; ?>

                            <?php if (isset($event['isYearly']) && $event['isYearly'] == 1) : ?>
                            <label>
                                <input type="checkbox" disabled="disabled" checked="checked" />
                                <span>Yearly</span>
                            </label>
                            <br />
                            <?php else : ?>
                            <label>
                                <input type="checkbox" disabled="disabled" />
                                <span>Not Yearly Currently</span>
                            </label>
                            <br />
                            <?php endif; ?>

                            <?php if (isset($event['isWeekly']) && $event['isWeekly'] == 1) : ?>
                            <label>
                                <input type="checkbox" disabled="disabled" checked="checked" />
                                <span>Weekly</span>
                            </label>
                            <br />
                            <?php else : ?>
                            <label>
                                <input type="checkbox" disabled="disabled" />
                                <span>Not Weekly Currently</span>
                            </label>
                            <br />
                            <?php endif; ?>


                            <?php if (isset($event['isDaily']) && $event['isDaily'] == 1) : ?>
                            <label>
                                <input type="checkbox" disabled="disabled" checked="checked" />
                                <span>Daily</span>
                            </label>
                            <br />
                            <?php else : ?>
                            <label>
                                <input type="checkbox" disabled="disabled" />
                                <span>Not Daily Currently</span>
                            </label>
                            <br />
                            <?php endif; ?>
                        </div>
                    </div>
                    <div class="card-action">
                        <a href="<?php echo URLROOT; ?>/events/loadEventEdit/<?php echo $event['id']; ?>">
                            <span class="material-icons alignVertically">
                                edit
                            </span>
                            <span>Edit</span>
                        </a>
                        <?php if ($event['checkedEvent'] == 1) : ?>
                        <a
                            href="<?php echo URLROOT; ?>/events/checkUncheckEvent/?eventId=<?php echo $event['id']; ?>&author=<?php echo $event['user_id']; ?>&checked=false">
                            <span class="material-icons alignVertically">
                                check_circle_outline
                            </span>
                            <span>Uncheck</span>
                        </a>

                        <?php else : ?>
                        <?php echo $event['checkedEvent']; ?>
                        <a
                            href="<?php echo URLROOT; ?>/events/checkUncheckEvent/?eventId=<?php echo $event['id']; ?>&author=<?php echo $event['user_id']; ?>&checked=1">
                            <span class="material-icons alignVertically">
                                check_circle
                            </span>
                            <span>Check</span>
                        </a>
                        <?php endif; ?>
                        <?php if ($event['showNotification'] == 1) : ?>
                        <a href="<?php echo URLROOT; ?>/events/turnOffNotif/<?php echo $event['id']; ?>">
                            <span class="material-icons alignVertically">
                                alarm_off
                            </span>
                            Notification Turn OFF</a>
                        <?php else : ?>
                        <a href="<?php echo URLROOT; ?>/events/turnOnNotif/<?php echo $event['id']; ?>">
                            <span class="material-icons alignVertically">
                                alarm_on
                            </span>
                            Notification Turn ON</a>
                        <?php endif; ?>
                        <a href="#btnMoveEv<?php echo $event['id']; ?>"
                            onclick="showHideMoveEventForm(<?php echo $event['id']; ?>)">
                            <span class="material-icons">
                                rowing
                            </span>
                            <span>Move</span>
                        </a>
                        <div class="mailField" id="moveEventForm<?php echo $event['id']; ?>">
                            <label for="moveToNewDate<?php echo $event['id']; ?>">Choose Date To Move
                                Event</label>
                            <input type="text" name="moveToNewDate" id="moveToNewDate<?php echo $event['id']; ?>"
                                class="datepicker" />
                            <a class="btn" onclick="moveEvent(<?php echo $event['id']; ?>)">
                                <span class="material-icons alignVertically">
                                    rowing
                                </span>
                                <span>Confirm Move</span>
                            </a>
                            <span id="moveToNewDateSpanWarn<?php echo $event['id']; ?>" class="validateMsg"></span>
                        </div>


                        <!--                                --><?php
                                                                        //                                    echo $event['date'] . ' - ' . date('Y-m-d') . '<br />';
                                                                        //                                    echo $event['date'] < date('Y-m-d');
                                                                        //
                                                                        //
                                                                        ?>

                        <!-- <?php //if(($event['date'] < date('Y-m-d') == 1)) : 
                                        ?> -->

                        <?php if (isset($event['isMonthly']) && $event['isMonthly'] == 1) : ?>
                        <a href="<?php echo URLROOT; ?>/events/makeNotMonthly/<?php echo $event['id']; ?>">
                            <span class="material-icons alignVertically">
                                calendar_today
                            </span>
                            <span>Not Monthly</span>
                        </a>
                        <?php else : ?>
                        <a href="<?php echo URLROOT; ?>/events/makeMonthly/<?php echo $event['id']; ?>">
                            <span class="material-icons alignVertically">
                                calendar_today
                            </span>
                            <span>Monthly</span>
                        </a>
                        <?php endif; ?>
                        <!-- <?php //endif; 
                                        ?> -->

                        <?php if (isset($event['isYearly']) && $event['isYearly'] == 1) : ?>
                        <a href="<?php echo URLROOT; ?>/events/makeNotYearly/<?php echo $event['id']; ?>">
                            <span class="material-icons alignVertically">
                                date_range
                            </span>
                            Not Yearly</a>
                        <?php else : ?>
                        <a href="<?php echo URLROOT; ?>/events/makeYearly/<?php echo $event['id']; ?>">
                            <span class="material-icons alignVertically">
                                date_range
                            </span>
                            Yearly</a>
                        <?php endif; ?>

                        <?php if (isset($event['isWeekly']) && $event['isWeekly'] == 1) : ?>
                        <a href="<?php echo URLROOT; ?>/events/makeNotWeekly/<?php echo $event['id']; ?>">
                            <span class="material-icons alignVertically">
                                event
                            </span>
                            Not Weekly</a>
                        <?php else : ?>
                        <a href="<?php echo URLROOT; ?>/events/makeWeekly/<?php echo $event['id']; ?>">
                            <span class="material-icons alignVertically">
                                event
                            </span>
                            Weekly</a>
                        <?php endif; ?>

                        <?php if (isset($event['isDaily']) && $event['isDaily'] == 1) : ?>
                        <a href="<?php echo URLROOT; ?>/events/makeNotDaily/<?php echo $event['id']; ?>">
                            <span class="material-icons alignVertically">
                                view_day
                            </span>
                            Not Daily</a>
                        <?php else : ?>
                        <a href="<?php echo URLROOT; ?>/events/makeDaily/<?php echo $event['id']; ?>">
                            <span class="material-icons alignVertically">
                                view_day
                            </span>
                            Daily</a>
                        <?php endif; ?>


                        <!-- Modal Trigger -->
                        <button data-target="<?php echo $event['id']; ?>" class="btn modal-trigger red accent-4">
                            <span class="material-icons alignVertically">
                                delete_forever
                            </span>
                            <span>Delete</span>
                        </button>

                        <!-- Modal Structure -->
                        <div id="<?php echo $event['id']; ?>" class="modal">
                            <div class="modal-content">
                                <h4>Are you sure to delete <?php echo $event['date']; ?></h4>
                                <p><?php echo $event['text']; ?></p>
                            </div>
                            <div class="modal-footer">
                                <a href="#!" class="modal-close waves-effect waves-green btn-flat">CANCEL</a>
                                <!-- /evCalendar/events/deleteEvent/?eventId=${event.id}&author=${event.user_id} -->
                                <a class="btn red accent-4"
                                    href="<?php echo URLROOT; ?>/events/deleteEvent/?eventId=<?php echo $event['id']; ?>&author=<?php echo $event['user_id']; ?>">Delete</a>
                            </div>
                        </div>


                        <!-- <hr /> -->
                        <!-- <div class="fb-share-button" data-href="https://192.168.0.125/evCalendar/" data-layout="button_count" data-size="large"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=https%3A%2F%2F192.168.0.125%2FevCalendar%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Споделяне</a></div> -->


                        <!-- <button onclick="showMailForm('<?php //echo $event['date'];
                                                                    ?>')" class="btn">Mail</button> -->
                        <!-- <div>
                                    <input class="col-md-6 mailField" type="email" id="input<?php //echo $event['date']; 
                                                                                            ?>" /><br />
                                    <span id="invalidMailSpan<?php //echo $event['date']; 
                                                                ?>" class="mailField validateMsg"></span>
                                    <button id="sendMailBtn<?php //echo $event['date']; 
                                                            ?>" onclick="sendMailTo('<?php //echo $event['date'];
                                                                                        ?>')" class="btn mailField">Send</button>

                                    <div id="progress<?php //echo $event['date']; 
                                                        ?>" class="progress mailField">
                                        <div class="indeterminate"></div>
                                    </div>

                                </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php endforeach; ?>
</div>
<?php endforeach; ?>
<div class="row">
    <div class="col l12 m12 s12">
        <?php if ($data['hasPrevPage']) : ?>
        <a href="<?php echo URLROOT; ?>/events/listMyEvents?year=<?php echo $data['year']; ?>&month=<?php echo $data['month']; ?>&page=<?php echo $data['prevPage']; ?>"
            class="btn btn-primary pull-left">
            <span class="material-icons alignVertically">
                navigate_before
            </span>
            Prev
        </a>
        <?php endif; ?>

        <?php if ($data['hasNextPage']) : ?>
        <a href="<?php echo URLROOT; ?>/events/listMyEvents?year=<?php echo $data['year']; ?>&month=<?php echo $data['month']; ?>&page=<?php echo $data['nextPage']; ?>"
            class="btn btn-primary pull-right">
            <span class="material-icons alignVertically">
                navigate_next
            </span>
            Next
        </a>
        <?php endif; ?>
    </div>
</div>
<!--    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>-->
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
<script src="<?php echo URLROOT ?>/js/drawChartJs.js"></script>
<script src="<?php echo URLROOT ?>/js/SendMyEventsByMail.js"></script>
<script src="<?php echo URLROOT ?>/js/MoveEventToDate.js"></script>
<script src="<?php echo URLROOT ?>/js/GenWordFileAndDownload.js"></script>
<script>
    const data = < ? php echo $data['sortedDataJSON']; ? > ;

    document.addEventListener('DOMContentLoaded', function () {
        if (document.getElementById('<?php echo $data['
                today ']; ?>')) {
            window.location.hash = "<?php echo $data['today']; ?>";
        }
        const dataObj = < ? php echo $data['chartJsData']; ? > ;
        const options = {
            ctx: 'eventsChart',
            labels: dataObj.labels,
            data: dataObj.values,
            type: 'bar',
            backgroundColor: [],
            label: '# of events last few days',
            borderWidth: 1,
            beginAtZero: true
        }
        drawChartJS(options);
        let selYearSelect = document.getElementsByName('selectedYear')[0];
        let selMontSelect = document.getElementsByName('selectedMonth')[0];
        selYearSelect.addEventListener('change', function (event) {
            let year = selYearSelect.value;
            let month = selMontSelect.value;
            window.location = `/evCalendar/events/listMyEvents?year=${year}&month=${month}&page=1`;
        });
        selMontSelect.addEventListener('change', function (event) {
            let year = selYearSelect.value;
            let month = selMontSelect.value;
            window.location = `/evCalendar/events/listMyEvents?year=${year}&month=${month}&page=1`;
        });
        const evAddBtn = document.getElementById("evAddBtn");
        evAddBtn.addEventListener('click', function () {
            window.location = '<?php echo URLROOT; ?>/events/addNewEvent';
        });

    });
</script>

// <script>
//     let fileUploadFormShown = false;
//     let fileUploadBtn = document.getElementById('evAddFileBtn');
//     let fileForm = document.getElementById('addEventForm');

//     fileUploadBtn.addEventListener('click', function () {
//         fileUploadFormShown = !fileUploadFormShown;
//         if (fileUploadFormShown) {
//             fileForm.style.display = 'block';
//             return;
//         }
//         fileForm.style.display = 'none';
//     });
// </script>

// <!-- <script>
//     const data = <?php //echo $data['sortedDataJSON']; 
//                     ?>;
//     function genWordFileAndDownload(date) {
//         let formData = new FormData();
//         formData.append('dayEvents', JSON.stringify(data[date]));
//         let request = new XMLHttpRequest();
//         request.open('POST', URLROOT + "/events/genWordFileEvents");
//         request.send(formData);
//         request.responseType = 'blob';
//         request.onreadystatechange = function() {
//             if (request.readyState == XMLHttpRequest.DONE) {
//                 let download = URL.createObjectURL(request.response);
//                 let a = document.createElement("a");
//                 a.href = download;
//                 a.download = "file-" + new Date().getTime() + '.doc';
//                 document.body.appendChild(a);
//                 a.click();
//             }
//         }
//     }
// </script> -->
<?php require_once APPROOT . '/views/inc/footer.php' ?>