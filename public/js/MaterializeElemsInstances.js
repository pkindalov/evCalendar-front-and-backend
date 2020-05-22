document.addEventListener('DOMContentLoaded', function () {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems);
    var selectElems = document.querySelectorAll('select');
    var selectInstances = M.FormSelect.init(selectElems);
    var modalEl = document.querySelectorAll('.modal');
    var modalElInstances = M.Modal.init(modalEl);
    var datePickers = document.querySelectorAll('.datepicker');
    var datepickersInstances = M.Datepicker.init(datePickers, {
        format: 'yyyy-mm-dd',
        showClearBtn: true
    });
    var timePickersElems = document.querySelectorAll('.timepicker');
    var timePickersInstances = M.Timepicker.init(timePickersElems, {
        twelveHour: false,
        showClearBtn: true
    });
    var dropDownElems = document.querySelectorAll('.dropdown-trigger');
    var instances = M.Dropdown.init(dropDownElems);
});