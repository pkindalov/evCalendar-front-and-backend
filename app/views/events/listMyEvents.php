<?php require_once APPROOT . '/views/inc/header.php' ?>
<!-- <pre>
    <?php //print_r($data['sortedData']); 
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

<?php foreach ($data['sortedData'] as $key => $eventsData) : ?>
    <h2 class="<?php if ($key === date('Y-m-d')) echo 'blue lighten-1' ?>"><?php echo $key; ?></h2>
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
                            <?php if ($event['checkedEvent']) : ?>
                                <p class="checkedEvent"><?php echo $event['text']; ?></p>
                            <?php else : ?>
                                <p><?php echo $event['text']; ?></p>
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

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
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
<script>
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
</script>
<?php require_once APPROOT . '/views/inc/footer.php' ?>