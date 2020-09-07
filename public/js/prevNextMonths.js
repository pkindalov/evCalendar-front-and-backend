let prevMonthBtn = document.getElementById('prevMonth');
let nextMonthBtn = document.getElementById('nextMonth');

let selectElems = document.querySelectorAll('#selMonth');
selMontSelect = selectElems[0];
let monthNum = parseInt(selMontSelect.value);

function getMonthStr(mode, monthNum) {
	let num = monthNum;
	switch (mode) {
		case 'prev':
			num--;
			num = num <= 0 ? 1 : num;
			break;
		case 'next':
			num++;
			num = num > 12 ? 12 : num;
			break;
		default:
			console.log('No such mode. Only prev and next');
			return;
			break;
	}

	num = num < 10 ? '0' + num : num;
	return num;
}

function updateSelectedIndexAndRelocate(numOfMonth, monthStr) {
	selMontSelect.selectedIndex = numOfMonth;
	window.location.href = '/evCalendar/events/listMyEvents?year=2020&month=' + monthStr + '&page=1';
}

prevMonthBtn.addEventListener('click', function() {
	let selectInstances = M.FormSelect.init(selectElems);
	let updatedMonthNum = monthNum - 1;
	let updatedMonthStr = getMonthStr('prev', monthNum);
	updateSelectedIndexAndRelocate(updatedMonthNum, updatedMonthStr);
});

nextMonthBtn.addEventListener('click', function() {
	let selectInstances = M.FormSelect.init(selectElems);
	let updatedMonthNum = monthNum + 1;
	let updatedMonthStr = getMonthStr('next', monthNum);
	updateSelectedIndexAndRelocate(updatedMonthNum, updatedMonthStr);
});
