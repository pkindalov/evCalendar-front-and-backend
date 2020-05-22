// const URLROOT = 'https://192.168.0.125/evCalendar';
// let mainContainer = document.getElementById('eventContId');
let showHideMailFormBtn = document.getElementById('showHideMailForm');
let sendMailBtn = document.getElementById('sentMailBtn');
let formContainer = document.getElementById('mailForm');
let invalidMsgSpan = document.getElementById('invalidMailSpan');
let progress = document.getElementById('progress');
let showMailForm = false;

function showCheckboxesInCont(checkBoxesCount) {
	// console.log(mainContainer.children.length);
	for (let i = 0; i < checkBoxesCount - 1; i++) {
		if (mainContainer.children[i].children[0].nodeName == 'DIV') {
			let checkBoxDiv = mainContainer.children[i].children[0].children[1].children[0].children[0];
			checkBoxDiv.style.display = 'block';
		}
	}
}

function hideCheckboxesInCont(checkBoxesCount) {
	for (let i = 0; i < checkBoxesCount - 1; i++) {
		if (mainContainer.children[i].children[0].nodeName == 'DIV') {
			let checkBoxDiv = mainContainer.children[i].children[0].children[1].children[0].children[0];
			checkBoxDiv.style.display = 'none';
		}
	}
}

showHideMailFormBtn.addEventListener('click', function() {
	showMailForm = !showMailForm;
	if (showMailForm) {
		formContainer.style.display = 'block';
		showCheckboxesInCont(mainContainer.children.length);
		return;
	}
	formContainer.style.display = 'none';
	progress.style.display = 'none';
	hideCheckboxesInCont(mainContainer.children.length);
});

sendMailBtn.addEventListener('click', function() {
	let divsArr = [
		{
			textContent: []
		}
	];

	for (let i = 0; i < mainContainer.children.length - 1; i++) {
		// console.log(mainContainer.children[i]);
		if (mainContainer.children[i].children[0].nodeName == 'DIV') {
			const checkBox =
				mainContainer.children[i].children[0].children[1].children[0].children[0].children[0].children[0];
			if (checkBox.checked) {
				let elObj = {};
				const textEl = mainContainer.children[i].children[0].children[1].children[0].children[1];
				elObj.event = textEl.innerHTML;
				divsArr[0].textContent.push(elObj);
			}
		}
		// console.log(checkBox);
	}

	if (divsArr[0].textContent.length < 1) {
		invalidMsgSpan.style.display = 'block';
		invalidMsgSpan.innerText = 'You must choose at least one event';
		return;
	}

	invalidMsgSpan.style.display = 'none';

	let userEmail = document.getElementById('mail').value;
	const regex = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
	const result = regex.test(String(userEmail).toLowerCase());

	if (!result) {
		invalidMsgSpan.style.display = 'block';
		invalidMsgSpan.innerText = 'Invalid mail';
		return false;
	}

	invalidMsgSpan.style.display = 'none';
	progress.style.display = 'block';

	let formData = new FormData();
	formData.append('receiver', userEmail);
	formData.append('dayEvents', JSON.stringify(divsArr));
	// formData.append('dayEvents', dayEventsToSend);

	let request = new XMLHttpRequest();
	request.open('POST', URLROOT + '/events/sendEventsOnThisDay');
	request.send(formData);
	request.onreadystatechange = function() {
		if (request.readyState == XMLHttpRequest.DONE) {
			const serverResp = JSON.parse(request.responseText);
			if (serverResp.success) {
				invalidMsgSpan.style.color = 'green';
				invalidMsgSpan.innerText = 'Mail sent successfull';
				invalidMsgSpan.style.display = 'block';
				progress.style.display = 'none';
				formContainer.style.display = 'none';
				return;
			} else {
				invalidMsgSpan.display = 'block';
				invalidMsgSpan.innerText = 'There is some problem sending mail';
				return;
			}
		}
	};
});
