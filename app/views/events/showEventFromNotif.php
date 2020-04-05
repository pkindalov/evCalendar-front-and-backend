<?php require_once APPROOT . '/views/inc/header.php' ?>

<!-- <?php //print_r($data['event'][0]); die(); ?> -->

<div class="row">
    <div class="col s12 m7">
        <h2 class="header"><?php echo $data['event'][0]->date; ?></h2>
        <div class="card horizontal">
            <!-- <div class="card-image">
                <img src="https://lorempixel.com/100/190/nature/6">
            </div> -->
            <div class="card-stacked">
                <div class="card-content">
                    <P>Event start at: <?php echo $data['event'][0]->begin; ?></p>
                    <P>Event finish at: <?php echo $data['event'][0]->finish; ?></p>
                    <p><?php echo $data['event'][0]->text; ?></p>
                </div>
                <div class="card-action">
                    <a href="/events/turnOffNotif/<?php echo $data['event'][0]->id;?>">Turn off notification for this event</a>
                </div>
            </div>
        </div>
    </div>
</div>
<?php require_once APPROOT . '/views/inc/footer.php' ?>