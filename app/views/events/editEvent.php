<?php require_once APPROOT . '/views/inc/header.php' ?>
<!-- <?php //print_r($data); 
        ?> -->
<div class="row">
    <div class="col l12 s12 m12">
        <form id="editEventForm" action="/evCalendar/events/editEvent/<?php echo $data['event']->id; ?>" method="post">
            <p>
                <label for="eventTextName">Text</label>
                <textarea id="eventTextName" name="eventTextName" class="materialize-textarea"><?php echo $data['event']->text; ?></textarea>
            </p>
            <p>
                <label for="editedDate">Date</label>
                <input type="text" name="editedDate" id="editedDate" class="datepicker" value="<?php echo $data['event']->date; ?>" />
            </p>
            <p>
                <label for="hoursBegin">Event Begin Time</label>
                <input type="text" name="hoursBegin" id="hoursBegin" value="<?php echo $data['event']->begin; ?>" class="timepicker" />
            </p>
            <p>
                <label for="hoursFinish">Event Finish Time</label>
                <input type="text" name="hoursFinish" id="hoursFinish" value="<?php echo $data['event']->finish; ?>" class="timepicker" />
            </p>


            <!-- ${!event.checked ? '' : 'checked' } -->
            <!-- <input type="checkbox" name="checkedEvent" value="Checked" ${!event.checked ? '' : 'checked'} /> -->
            <label for="checkedEvent">Check</label>
            <?php if ($data['event']->checkedEvent == '') : ?>
                <input type="checkbox" name="checkedEvent" id="checkedEvent" value="Checked" />
            <?php else : ?>
                <input type="checkbox" name="checkedEvent" id="checkedEvent" value="Checked" checked="checked" />
            <?php endif; ?>
            <span></span>

            <p>
                <input type="hidden" name="eventAuthor" value="<?php echo $data['event']->user_id; ?>" />
                <!-- <input type="submit" class="waves-effect waves-light btn" value="Save Changes" /> -->
                <button class="waves-effect waves-light btn" type="submit">
                    <span class="material-icons alignVertically">
                        save
                    </span>
                    Save
                </button>
                <!-- <input type="reset" class="waves-effect waves-light btn" value="Clear" /> -->
                <button type="reset" class="waves-effect waves-light btn">
                    <span class="material-icons alignVertically">
                        clear
                    </span>
                    Reset
                </button>
            </p>
        </form>
    </div>
</div>
<?php require_once APPROOT . '/views/inc/footer.php' ?>