<?php require_once APPROOT . '/views/inc/header.php' ?>
<!-- <pre>
        <?php //print_r($data['events']); 
        ?>
    </pre> -->

<?php if (count($data['events']) == 0) : ?>
    <h2>You have no task for today.</h2>
<?php endif; ?>

<h2 class="header"><?php echo $data['todayDate']; ?></h2>
<?php foreach ($data['events'] as $key => $event) : ?>
    <div class="col s12 m7">
        <div class="card horizontal">
            <div class="card-image"></div>
            <div class="card-stacked">
                <div class="card-content">
                    <div id="checkedDay<?php echo $event->date; ?>Num<?php echo $key; ?>" class="leftAligned mailField">
                        <label>
                            <input type="checkbox" />
                            <span>Choose to send</span>
                        </label>
                    </div>
                    <?php if ($event->checkedEvent) : ?>
                        <p class="checkedEvent">
                            <?php echo $event->text; ?>
                        </p>
                    <?php else : ?>
                        <p>
                            <?php echo $event->text; ?>
                        </p>
                    <?php endif; ?>
                    <p>Begin: <?php echo $event->begin; ?></p>
                    <p>Finish: <?php echo $event->finish; ?></p>
                    <p>Date: <?php echo $event->date; ?></p>
                    <!-- <p>Checked: <?php //echo $event['checkedEvent']; 
                                        ?> </p> -->
                    <p>Notification Turned <?php echo $event->showNotification == 1 ? "ON" : "OFF"; ?></p>
                </div>
                <div class="card-action">
                    <?php if ($event->readed == 1) : ?>
                        <a class="btn  blue darken-4" href="<?php echo URLROOT; ?>/events/markAsUnread/<?php echo $event->id; ?>">Unread</a>

                    <?php else : ?>
                        <a class="btn blue lighten-2" href="<?php echo URLROOT; ?>/events/markAsReaded/<?php echo $event->id; ?>">Mark As Read</a>
                    <? endif; ?>

                    <!-- <a class="btn blue lighten-2" href="<?php echo URLROOT; ?>/events/loadEventEdit/<?php echo $event->id; ?>">Not Read</a> -->


                    <!-- <a class="btn blue lighten-2" href="<?php echo URLROOT; ?>/events/loadEventEdit/<?php echo $event->id; ?>">Edit</a> -->

                    <!-- <?php if ($event->checkedEvent == 1) : ?>
                            <a class="btn red lighten-1" href="<?php echo URLROOT; ?>/events/checkUncheckEvent/?eventId=<?php echo $event->id; ?>&author=<?php echo $event->user_id; ?>&checked=false">Uncheck</a>

                        <?php else : ?>
                            <?php echo $event->checkedEvent; ?>
                            <a class="btn cyan accent-3" href="<?php echo URLROOT; ?>/events/checkUncheckEvent/?eventId=<?php echo $event->id; ?>&author=<?php echo $event->user_id; ?>&checked=1">Check</a>
                        <?php endif; ?>
                        <?php if ($event->showNotification == 1) : ?>
                            <a class="btn red lighten-1" href="<?php echo URLROOT; ?>/events/turnOffNotif/<?php echo $event->id; ?>">Notification Turn OFF</a>
                        <?php else : ?>
                            <a class="btn cyan accent-3" href="<?php echo URLROOT; ?>/events/turnOnNotif/<?php echo $event->id; ?>">Notification Turn ON</a>
                        <?php endif; ?> -->

                    <!-- Modal Trigger -->
                    <!-- <button data-target="<?php echo $event->id; ?>" class="btn modal-trigger red accent-4">Delete</button> -->

                    <!-- Modal Structure -->
                    <!-- <div id="<?php echo $event->id; ?>" class="modal">
                            <div class="modal-content">
                                <h4>Are you sure to delete <?php echo $event->date; ?></h4>
                                <p><?php echo $event->text; ?></p>
                            </div>
                            <div class="modal-footer">
                                <a href="#!" class="modal-close waves-effect waves-green btn-flat">CANCEL</a> -->
                    <!-- /evCalendar/events/deleteEvent/?eventId=${event.id}&author=${event.user_id} -->
                    <!-- <a class="btn red accent-4" href="<?php echo URLROOT; ?>/events/deleteEvent/?eventId=<?php echo $event->id; ?>&author=<?php echo $event->user_id; ?>">Delete</a>
                            </div>
                        </div> -->
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<?php if ($data['hasPrevPage']) : ?>
    <a href="<?php echo URLROOT; ?>/events/myTodayEvents?page=<?php echo $data['prevPage']; ?>" class="btn btn-primary pull-left">
        <i class="fa fa-backward"></i> Prev
    </a>
<?php endif; ?>

<?php if ($data['hasNextPage']) : ?>
    <a href="<?php echo URLROOT; ?>/events/myTodayEvents?page=<?php echo $data['nextPage']; ?>" class="btn btn-primary pull-right">
        <i class="fa fa-forward"></i> Next
    </a>
<?php endif; ?>
<?php require_once APPROOT . '/views/inc/footer.php' ?>