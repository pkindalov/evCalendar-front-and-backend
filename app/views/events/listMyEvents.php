<?php require_once APPROOT . '/views/inc/header.php' ?>
<!-- <pre>
    <?php //print_r($data['googleData']); 
    ?>
</pre> -->
<!-- <?php //print_r($data); 
        ?> -->
<!-- <?php //echo date('Y-m-d'); 
        ?> -->

<div class="row center-align">
    <div class="col l12">
        <div class="input-field col s12">
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
    <div class="col l12">
        <div class="input-field col s12">
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
    <div class="col l12">
        <a class="btn teal lighten-1" href="#" id="evAddBtn">
            <i class="material-icons">add</i></a>
    </div>
</div>

<!-- Google chart here -->
<div class="row">
    <div class="col l12">
        <div id="chart_div"></div>
    </div>
</div>

<?php foreach ($data['sortedData'] as $key => $eventsData) : ?>
    <div id="<?php echo $key; ?>">
        <h2 id="<?php echo $key; ?>" class="<?php if ($key === date('Y-m-d')) echo 'blue lighten-1' ?>"><?php echo $key; ?></h2>




        <button onclick="showMailForm('<?php echo $key; ?>')" class="btn">Mail</button>

        <div>
            <input class="col-md-6 mailField" type="email" id="input<?php echo $key; ?>" /><br />
            <span id="invalidMailSpan<?php echo $key; ?>" class="mailField validateMsg"></span>
            <button id="sendMailBtn<?php echo $key; ?>" onclick="sendMailTo('<?php echo $key; ?>')" class="btn mailField">Send</button>

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
                                <div id="checkedDay<?php echo $event['date']; ?>Num<?php echo $key; ?>" class="leftAligned mailField">
                                    <label>
                                        <input type="checkbox" />
                                        <span>Choose to send</span>
                                    </label>
                                </div>
                                <?php if ($event['checkedEvent']) : ?>
                                    <p class="checkedEvent">
                                        <?php echo $event['text']; ?>
                                    </p>
                                <?php else : ?>
                                    <p>
                                        <?php echo $event['text']; ?>
                                    </p>
                                <?php endif; ?>
                                <p>Begin: <?php echo $event['begin']; ?></p>
                                <p>Finish: <?php echo $event['finish']; ?></p>
                                <p>Date: <?php echo $event['date']; ?></p>
                                <!-- <p>Checked: <?php //echo $event['checkedEvent']; 
                                                    ?> </p> -->
                                <p>Notification Turned <?php echo $event['showNotification'] == 1 ? "ON" : "OFF"; ?></p>
                            </div>
                            <div class="card-action">
                                <a class="btn blue lighten-2" href="<?php echo URLROOT; ?>/events/loadEventEdit/<?php echo $event['id']; ?>">Edit</a>
                                <?php if ($event['checkedEvent'] == 1) : ?>
                                    <a class="btn red lighten-1" href="<?php echo URLROOT; ?>/events/checkUncheckEvent/?eventId=<?php echo $event['id']; ?>&author=<?php echo $event['user_id']; ?>&checked=false">Uncheck</a>

                                <?php else : ?>
                                    <?php echo $event['checkedEvent']; ?>
                                    <a class="btn cyan accent-3" href="<?php echo URLROOT; ?>/events/checkUncheckEvent/?eventId=<?php echo $event['id']; ?>&author=<?php echo $event['user_id']; ?>&checked=1">Check</a>
                                <?php endif; ?>
                                <?php if ($event['showNotification'] == 1) : ?>
                                    <a class="btn red lighten-1" href="<?php echo URLROOT; ?>/events/turnOffNotif/<?php echo $event['id']; ?>">Notification Turn OFF</a>
                                <?php else : ?>
                                    <a class="btn cyan accent-3" href="<?php echo URLROOT; ?>/events/turnOnNotif/<?php echo $event['id']; ?>">Notification Turn ON</a>
                                <?php endif; ?>






                                <!-- Modal Trigger -->
                                <button data-target="<?php echo $event['id']; ?>" class="btn modal-trigger red accent-4">Delete</button>

                                <!-- Modal Structure -->
                                <div id="<?php echo $event['id']; ?>" class="modal">
                                    <div class="modal-content">
                                        <h4>Are you sure to delete <?php echo $event['date']; ?></h4>
                                        <p><?php echo $event['text']; ?></p>
                                    </div>
                                    <div class="modal-footer">
                                        <a href="#!" class="modal-close waves-effect waves-green btn-flat">CANCEL</a>
                                        <!-- /evCalendar/events/deleteEvent/?eventId=${event.id}&author=${event.user_id} -->
                                        <a class="btn red accent-4" href="<?php echo URLROOT; ?>/events/deleteEvent/?eventId=<?php echo $event['id']; ?>&author=<?php echo $event['user_id']; ?>">Delete</a>
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
    <div class="col-md-12">
        <?php if ($data['hasPrevPage']) : ?>
            <a href="<?php echo URLROOT; ?>/events/listMyEvents?year=<?php echo $data['year']; ?>&month=<?php echo $data['month']; ?>&page=<?php echo $data['prevPage']; ?>" class="btn btn-primary pull-left">
                <i class="fa fa-backward"></i> Prev
            </a>
        <?php endif; ?>

        <?php if ($data['hasNextPage']) : ?>
            <a href="<?php echo URLROOT; ?>/events/listMyEvents?year=<?php echo $data['year']; ?>&month=<?php echo $data['month']; ?>&page=<?php echo $data['nextPage']; ?>" class="btn btn-primary pull-right">
                <i class="fa fa-forward"></i> Next
            </a>
        <?php endif; ?>
    </div>
</div>
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        
        if (document.getElementById('<?php echo $data['today']; ?>')) {
            window.location.hash = "<?php echo $data['today']; ?>";
        }

        let myGoogleData = <?php echo $data['googleData']; ?>;
           

            google.charts.load('current', {
                packages: ['corechart', 'bar']
            });
            google.charts.setOnLoadCallback(drawStacked);

            function drawStacked() {
                var data = google.visualization.arrayToDataTable(myGoogleData);

                var options = {
                    title: 'Count of events per day',
                    chartArea: {
                        width: '50%'
                    },
                    isStacked: true,
                    hAxis: {
                        title: 'Total Count Of Events',
                        minValue: 0,
                    },
                    vAxis: {
                        title: 'Dates'
                    }
                };
                var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
                chart.draw(data, options);
            }
    });

    let selYearSelect = document.getElementsByName('selectedYear')[0];
    let selMontSelect = document.getElementsByName('selectedMonth')[0];
    selYearSelect.addEventListener('change', function(event) {
        let year = selYearSelect.value;
        let month = selMontSelect.value;
        window.location = `/evCalendar/events/listMyEvents?year=${year}&month=${month}&page=1`;
    });
    selMontSelect.addEventListener('change', function(event) {
        let year = selYearSelect.value;
        let month = selMontSelect.value;
        window.location = `/evCalendar/events/listMyEvents?year=${year}&month=${month}&page=1`;
    });

    const evAddBtn = document.getElementById("evAddBtn");
    evAddBtn.addEventListener('click', function() {
        window.location = '<?php echo URLROOT; ?>/events/addNewEvent';
    });

    let mailFormShown = false;

    function showCheckBoxes(count, date) {
        for (let i = 0; i < count; i++) {
            let checkBoxId = `checkedDay${date}Num${i}`;
            let checkBox = document.getElementById(checkBoxId);
            checkBox.style.display = 'block';
        }
    }

    function hideCheckBoxes(count, date) {
        for (let i = 0; i < count; i++) {
            let checkBoxId = `checkedDay${date}Num${i}`;
            let checkBox = document.getElementById(checkBoxId);
            checkBox.style.display = 'none';
        }
    }

    function showMailForm(date) {
        let mainContainer = document.getElementById(date);
        let mailField = document.getElementById(`input${date}`);
        let sendMailBtn = document.getElementById(`sendMailBtn${date}`);
        let validateSpan = document.getElementById(`invalidMailSpan${date}`);
        const importantDivStarPos = 3;
        const checkBoxNum = mainContainer.children.length - importantDivStarPos;
        // console.log(checkBoxNum);
        // console.log(mainContainer.children);
        // console.log(mainContainer.children.length);

        mailFormShown = !mailFormShown;
        if (mailFormShown) {
            mailField.style.display = 'block';
            sendMailBtn.style.display = 'block';
            validateSpan.style.display = 'block';
            //enable visility of checkboxes
            showCheckBoxes(checkBoxNum, date);


        } else {
            mailField.style.display = 'none';
            sendMailBtn.style.display = 'none';
            validateSpan.style.display = 'none';
            hideCheckBoxes(checkBoxNum, date);
        }
    }

    function sendMailTo(date) {
        let mainContainer = document.getElementById(date);
        let mail = document.getElementById(`input${date}`).value;
        let invalidMsgSpan = document.getElementById(`invalidMailSpan${date}`);
        let progressBar = document.getElementById(`progress${date}`);
        let dayEventsToSend = document.getElementById(date).innerHTML;


        let divsArr = [{
            'date': date,
            'textContent': []
        }];

        //iterate divs and search checked ones. Begin from index 3 because from there is the div with checkbox;
        for (let i = 3; i < mainContainer.children.length; i++) {
            let currentDiv = mainContainer.children[i];
            let divContent = currentDiv.children[0].children[0].children[1].children[0];
            let checkbox = currentDiv.children[0].children[0].children[1].children[0].children[0].children[0].children[0].checked;
            // console.log(divContent);
            //these are the <p> content of the main div. - date, begin, finish etc...
            if (checkbox) {
                divsArr[0].textContent.push(divContent.children[1].textContent);
                divsArr[0].textContent.push(divContent.children[2].textContent);
                divsArr[0].textContent.push(divContent.children[3].textContent);
                divsArr[0].textContent.push(divContent.children[4].textContent);
            }
        }

        if (divsArr[0].textContent.length < 1) {
            invalidMsgSpan.innerText = 'You must choose at least one event';
            return;
        }

        // console.log(divsArr);

        //still developping
        // return;    


        const regex = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
        const result = regex.test(String(mail).toLowerCase());
        if (!result) {
            invalidMsgSpan.innerText = 'Invalid mail';
            return false;
        }
        invalidMsgSpan.style.display = 'none';
        progressBar.style.display = 'block';



        
        let formData = new FormData();
        formData.append('receiver', mail);
        formData.append('dayEvents', JSON.stringify(divsArr));
        // formData.append('dayEvents', dayEventsToSend);


        let request = new XMLHttpRequest();
        request.open('POST', "<?php echo URLROOT; ?>/events/sendToMail");
        request.send(formData);
        request.onreadystatechange = function() {
            if (request.readyState == XMLHttpRequest.DONE) {
                const serverResp = JSON.parse(request.responseText);
                if (serverResp.success) {
                    invalidMsgSpan.style.color = 'green';
                    invalidMsgSpan.innerText = 'Mail sent successfull';
                    invalidMsgSpan.style.display = 'block';
                    progressBar.style.display = 'none';

                    return;
                } else {
                    invalidMsgSpan.display = 'block';
                    invalidMsgSpan.innerText = 'There is some problem sending mail';
                    return;
                }
            }
        }
    }
</script>
<?php require_once APPROOT . '/views/inc/footer.php' ?>