<?php require_once APPROOT . '/views/inc/header.php' ?>
<div class="row">
    <div class="col l12 s12 m12">
        <form id="editEventForm" action="/evCalendar/events/addNewEvent" method="post">
            <p>
                <label for="eventText">Text</label>
                <textarea id="eventText" name="eventText" class="materialize-textarea"></textarea>
            </p>
            <p>
                <label for="date">Date</label>
                <input type="text" name="date" id="date" class="datepicker" />
            </p>
            <p>
                <label for="hoursBegin">Event Begin Time</label>
                <input type="text" name="hoursBegin" id="hoursBegin" class="timepicker" />
            </p>
            <p>
                <label for="hoursFinish">Event Finish Time</label>
                <input type="text" name="hoursFinish" id="hoursFinish" class="timepicker" />
            </p>

            <p>
                <!-- <input type="submit" class="waves-effect waves-light btn" value="Save Changes" />
                <input type="reset" class="waves-effect waves-light btn" value="Clear" /> -->
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