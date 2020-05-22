<?php require_once APPROOT . '/views/inc/header.php' ?>
<!-- <pre>
    <?php //print_r($data['sortedData']); 
    ?>
</pre> -->
<!-- <?php //print_r($data); 
        ?> -->
<!-- <?php //echo date('Y-m-d'); 
        ?> -->

<?php if (count($data['sortedData']) === 0) : ?>
    <div class="row">
        <div class="col l12 m12 s12">
            <h4>Sorry, no events found.</h4>
        </div>
    </div>
<?php endif; ?>


<?php foreach ($data['sortedData'] as $key => $eventsData) : ?>
    <div class="row">
        <div class="col l12 m12 s12 center-align">
            <h2 class="<?php if ($key === date('Y-m-d')) echo 'blue lighten-1' ?>"><?php echo $key; ?></h2>
        </div>
    </div>
    <?php foreach ($eventsData as $key => $event) : ?>
        <div class="row">
            <div class="col l12 s12 m12 <?php if ($event['date'] === date('Y-m-d')) echo 'blue lighten-1' ?> center-align">
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
                            <hr />
                            <div class="left-align">
                                <p>Begin: <?php echo $event['begin']; ?></p>
                                <p>Finish: <?php echo $event['finish']; ?></p>
                                <p>Date: <?php echo $event['date']; ?></p>
                                <p>Notification Turned <?php echo $event['showNotification'] == 1 ? "ON" : "OFF"; ?></p>
                                <hr/>
                                <div class="left-align">
                                    <?php if (isset($event['isMonthly']) && $event['isMonthly'] == 1) : ?>
                                        <label>
                                            <input type="checkbox" disabled="disabled" checked="checked"/>
                                            <span>Montly</span>
                                        </label>
                                        <br/>
                                    <?php else : ?>
                                        <label>
                                            <input type="checkbox" disabled="disabled" />
                                            <span>Not Monthly Currently</span>
                                        </label>
                                        <br/>
                                    <?php endif; ?>

                                    <?php if (isset($event['isYearly']) && $event['isYearly'] == 1) : ?>
                                        <label>
                                            <input type="checkbox" disabled="disabled" checked="checked"/>
                                            <span>Yearly</span>
                                        </label>
                                        <br/>
                                    <?php else : ?>
                                        <label>
                                            <input type="checkbox" disabled="disabled" />
                                            <span>Not Yearly Currently</span>
                                        </label>
                                        <br/>
                                    <?php endif; ?>

                                    <?php if (isset($event['isWeekly']) && $event['isWeekly'] == 1) : ?>
                                        <label>
                                            <input type="checkbox" disabled="disabled" checked="checked"/>
                                            <span>Weekly</span>
                                        </label>
                                        <br/>
                                    <?php else : ?>
                                        <label>
                                            <input type="checkbox" disabled="disabled" />
                                            <span>Not Weekly Currently</span>
                                        </label>
                                        <br/>
                                    <?php endif; ?>


                                    <?php if (isset($event['isDaily']) && $event['isDaily'] == 1) : ?>
                                        <label>
                                            <input type="checkbox" disabled="disabled" checked="checked"/>
                                            <span>Daily</span>
                                        </label>
                                        <br/>
                                    <?php else : ?>
                                        <label>
                                            <input type="checkbox" disabled="disabled"/>
                                            <span>Not Daily Currently</span>
                                        </label>
                                        <br/>
                                    <?php endif; ?>
                                </div>
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
                                <a href="<?php echo URLROOT; ?>/events/checkUncheckEvent/?eventId=<?php echo $event['id']; ?>&author=<?php echo $event['user_id']; ?>&checked=false">
                                    <span class="material-icons alignVertically">
                                        check_circle_outline
                                    </span>
                                    <span>Uncheck</span>
                                </a>

                            <?php else : ?>
                                <?php echo $event['checkedEvent']; ?>
                                <a href="<?php echo URLROOT; ?>/events/checkUncheckEvent/?eventId=<?php echo $event['id']; ?>&author=<?php echo $event['user_id']; ?>&checked=1">
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
                            <a href="#btnMoveEv<?php echo $event['id']; ?>" onclick="showHideMoveEventForm(<?php echo $event['id']; ?>)">
                                <span class="material-icons">
                                    rowing
                                </span>
                                <span>Move</span>
                            </a>
                            <div class="mailField" id="moveEventForm<?php echo $event['id']; ?>">
                                <label for="moveToNewDate<?php echo $event['id']; ?>">Choose Date To Move
                                    Event</label>
                                <input type="text" name="moveToNewDate" id="moveToNewDate<?php echo $event['id']; ?>" class="datepicker" />
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
                                    <a class="btn red accent-4" href="<?php echo URLROOT; ?>/events/deleteEvent/?eventId=<?php echo $event['id']; ?>&author=<?php echo $event['user_id']; ?>">Delete</a>
                                </div>
                            </div>




















                            <!-- <a class="btn blue lighten-2" href="<?php echo URLROOT; ?>/events/loadEventEdit/<?php echo $event['id']; ?>">Edit</a>
                            <?php if ($event['checkedEvent'] == 1) : ?>
                                <a class="btn red lighten-1" href="<?php echo URLROOT; ?>/events/checkUncheckEvent/?eventId=<?php echo $event['id']; ?>&author=<?php echo $event['user_id']; ?>&checked=false">Uncheck</a>

                            <?php else : ?>
                                <?php echo $event['checkedEvent']; ?>
                                <a class="btn cyan accent-3" href="<?php echo URLROOT; ?>/events/checkUncheckEvent/?eventId=<?php echo $event['id']; ?>&author=<?php echo $event['user_id']; ?>&checked=1">Check</a>
                            <?php endif; ?> -->

                            <!-- <?php if ($event['showNotification'] == 1) : ?>
                                <a class="btn red lighten-1" href="<?php echo URLROOT; ?>/events/turnOffNotif/<?php echo $event['id']; ?>">Notification Turn OFF</a>
                            <?php else : ?>
                                <a class="btn cyan accent-3" href="<?php echo URLROOT; ?>/events/turnOnNotif/<?php echo $event['id']; ?>">Notification Turn ON</a>
                            <?php endif; ?> -->

                            <!-- Modal Trigger -->
                            <!-- <button data-target="<?php echo $event['id']; ?>" class="btn modal-trigger red accent-4">Delete</button> -->

                            <!-- Modal Structure -->
                            <!-- <div id="<?php echo $event['id']; ?>" class="modal">
                                <div class="modal-content">
                                    <h4>Are you sure to delete <?php echo $event['date']; ?></h4>
                                    <p><?php echo $event['text']; ?></p>
                                </div>
                                <div class="modal-footer">
                                    <a href="#!" class="modal-close waves-effect waves-green btn-flat">CANCEL</a>
                                   
                                    <a class="btn red accent-4" href="<?php echo URLROOT; ?>/events/deleteEvent/?eventId=<?php echo $event['id']; ?>&author=<?php echo $event['user_id']; ?>">Delete</a>
                                </div>
                            </div> -->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>
<?php endforeach; ?>
<div class="row">
    <div class="col l12 m12 s12">
        <?php if ($data['hasPrevPage']) : ?>
            <a href="<?php echo URLROOT; ?>/events/searchEvent?keyword=<?php echo $data['keyword']; ?>&page=<?php echo $data['prevPage']; ?>" class="btn btn-primary pull-left">
                <span class="material-icons alignVertically">
                    navigate_before
                </span>
                Prev
            </a>
        <?php endif; ?>

        <?php if ($data['hasNextPage']) : ?>
            <a href="<?php echo URLROOT; ?>/events/searchEvent?keyword=<?php echo $data['keyword']; ?>&page=<?php echo $data['nextPage']; ?>" class="btn btn-primary pull-right">
                <span class="material-icons alignVertically">
                    navigate_next
                </span>
                Next
            </a>
        <?php endif; ?>
    </div>
</div>

<script src="<?php echo URLROOT ?>/js/MoveEventToDate.js"></script>

<?php require_once APPROOT . '/views/inc/footer.php' ?>