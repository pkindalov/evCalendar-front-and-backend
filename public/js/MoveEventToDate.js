function setHash(newHash) {
    location.hash = 'Idontexists';
    location.hash = newHash;
}

let isMoveEventFormShown = false;

//move events functionality
function showHideMoveEventForm(eventId) {
    setHash(`btnMoveEv${eventId}`);
    // window.location.hash = `btnMoveEv${eventId}`;
    let currentMoveEventFormDiv = document.getElementById(`moveEventForm${eventId}`);
    isMoveEventFormShown = !isMoveEventFormShown;
    if (isMoveEventFormShown) {
        currentMoveEventFormDiv.style.display = 'block';
        return;
    }
    currentMoveEventFormDiv.style.display = 'none';

}

function moveEvent(eventId) {
    let dateToMove = document.getElementById(`moveToNewDate${eventId}`).value;
    let warningSpan = document.getElementById(`moveToNewDateSpanWarn${eventId}`);
    // window.location.hash = null;
    if (!eventId) {
        setHash(`btnMoveEv${eventId}`);
        warningSpan.innerText = 'Problem with event id';
        return;
    }
    if (!isMoveEventFormShown) return;
    if (!dateToMove) {
        setHash(`btnMoveEv${eventId}`);
        warningSpan.innerText = 'Wrong or empty date';
        return;
    }
    warningSpan.innerText = '';
    window.location = `/evCalendar/events/moveToNewDate?event=${eventId}&newDate=${dateToMove}`;
}