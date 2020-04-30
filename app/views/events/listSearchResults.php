<?php require_once APPROOT . '/views/inc/header.php' ?>
<!-- <pre>
    <?php //print_r($data['sortedData']); 
    ?>
</pre> -->
<!-- <?php //print_r($data); 
        ?> -->
<!-- <?php //echo date('Y-m-d'); 
        ?> -->

<?php if(count($data['sortedData']) === 0) : ?>
    <h4>Sorry, no events found.</h4>
<?php endif; ?>


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
                            <p>Notification Turned <?php echo $event['showNotification'] == 1 ? "ON" : "OFF"; ?></p>
                        </div>
                        <div class="card-action">
                            <a class="btn blue lighten-2" href="<?php echo URLROOT; ?>/events/loadEventEdit/<?php echo $event['id']; ?>">Edit</a>
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
            <a href="<?php echo URLROOT; ?>/events/searchEvent?keyword=<?php echo $data['keyword'];?>&page=<?php echo $data['prevPage']; ?>" class="btn btn-primary pull-left">
                <i class="fa fa-backward"></i> Prev
            </a>
        <?php endif; ?>

        <?php if ($data['hasNextPage']) : ?>
            <a href="<?php echo URLROOT; ?>/events/searchEvent?keyword=<?php echo $data['keyword'];?>&page=<?php echo $data['nextPage']; ?>" class="btn btn-primary pull-right">
                <i class="fa fa-forward"></i> Next
            </a>
        <?php endif; ?>
    </div>
</div>

<?php require_once APPROOT . '/views/inc/footer.php' ?>