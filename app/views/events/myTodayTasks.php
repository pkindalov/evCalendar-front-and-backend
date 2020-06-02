<?php require_once APPROOT . '/views/inc/header.php' ?>
<!-- <pre>
        <?php //print_r($data['events']); 
        ?>
    </pre> -->

<?php if (count($data['events']) == 0) : ?>
    <div class="row">
        <div class="col l12 m12 s12">
            <h2 class="center-align">You have no task for today.</h2>
        </div>
    </div>
<?php else : ?>


    <h2 class="header center-align"><?php echo $data['todayDate']; ?></h2>
    <button onclick="genWordFileAndDownload('<?php echo $data['todayDate']; ?>')" class="btn">
        <span class="material-icons alignVertically">
            description
        </span>
        Word
    </button>
    <?php foreach ($data['events'] as $key => $event) : ?>
        <div class="col l12 s12 center-align">
            <div class="card horizontal">
                <div class="card-image"></div>
                <div class="card-stacked">
                    <div class="card-content left-align">
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
                        <hr />
                        <p>Begin: <?php echo $event->begin; ?></p>
                        <p>Finish: <?php echo $event->finish; ?></p>
                        <p>Date: <?php echo $event->date; ?></p>
                        <p>Status:
                            <?php if ($event->readed == 1) : ?>
                                <span>VIEWED</span>
                            <?php else : ?>
                                <span>NOT VIEWED YET</span>
                            <?php endif; ?>
                        </p>

                        <p>Notification Turned <?php echo $event->showNotification == 1 ? "ON" : "OFF"; ?></p>
                    </div>
                    <div class="card-action">
                        <?php if ($event->readed == 1) : ?>
                            <a class="btn  blue darken-4" href="<?php echo URLROOT; ?>/events/markAsUnread/<?php echo $event->id; ?>">
                                <span class="material-icons alignVertically">
                                    markunread
                                </span>
                                Make Unread
                            </a>

                        <?php else : ?>
                            <a class="btn blue lighten-2" href="<?php echo URLROOT; ?>/events/markAsReaded/<?php echo $event->id; ?>">
                                <span class="material-icons alignVertically">
                                    drafts
                                </span>
                                Read
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="row">
        <div class="col l12 s12">
            <?php if ($data['hasPrevPage']) : ?>
                <a href="<?php echo URLROOT; ?>/events/myTodayEvents?page=<?php echo $data['prevPage']; ?>" class="btn btn-primary pull-left">
                    <span class="material-icons alignVertically">
                        navigate_before
                    </span>
                    Prev
                </a>
            <?php endif; ?>

            <?php if ($data['hasNextPage']) : ?>
                <a href="<?php echo URLROOT; ?>/events/myTodayEvents?page=<?php echo $data['nextPage']; ?>" class="btn btn-primary pull-right">
                    <span class="material-icons alignVertically">
                        navigate_next
                    </span>
                    Next
                </a>
            <?php endif; ?>

        </div>
    </div>
<?php endif; ?>

<script src="<?php echo URLROOT ?>/js/GenWordFileAndDownload.js"></script>
<script>
    const data = <?php echo $data['sortedDataJSON']; ?>;
</script>



<?php require_once APPROOT . '/views/inc/footer.php' ?>