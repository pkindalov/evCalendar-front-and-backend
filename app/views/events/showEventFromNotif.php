<?php require_once APPROOT . '/views/inc/header.php' ?>

<!-- <?php //print_r($data['event'][0]); die(); 
        ?> -->

<div class="row">
    <div class="col s12 m7">
        <h2 class="header"><?php echo $data['event'][0]->date; ?></h2>
        <div class="card horizontal">
            <!-- <div class="card-image">
                <img src="https://lorempixel.com/100/190/nature/6">
            </div> -->
            <div class="card-stacked">
                <?php if ($data['timeleft'] <= 10) : ?>
                    <h6 class="red darken-4"><?php echo 'Time left: ' . $data['timeleft'] . " min" ?></h4>
                <?php else :  ?>
                    <h6 class="teal accent-3"><?php echo 'Time left: ' . $data['timeleft'] . " min" ?></h4>
                <?php endif; ?>
                <div class="card-content">
                    <P>Event start at: <?php echo $data['event'][0]->begin; ?></p>
                    <P>Event finish at: <?php echo $data['event'][0]->finish; ?></p>
                    <p><?php echo $data['event'][0]->text; ?></p>
                </div>
                <div class="card-action">
                    <a href="<?php echo URLROOT; ?>/events/turnOffNotif/<?php echo $data['event'][0]->id; ?>">Turn off notification for this event</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once APPROOT . '/views/inc/footer.php' ?>