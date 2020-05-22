let mailFormShown = false;

function showCheckBoxes(count, date) {
    for (let i = 0; i < count; i++) {
        let checkBoxId = `checkedDay${date}Num${i}`;
        let checkBox = document.getElementById(checkBoxId);
        checkBox.style.display = 'block';
    }
}

function hideCheckBoxes(count, date) {
    for (let i = 0; i < count; i++) {
        let checkBoxId = `checkedDay${date}Num${i}`;
        let checkBox = document.getElementById(checkBoxId);
        checkBox.style.display = 'none';
    }
}

function showMailForm(date) {
    let mainContainer = document.getElementById(date);
    let mailField = document.getElementById(`input${date}`);
    let sendMailBtn = document.getElementById(`sendMailBtn${date}`);
    let validateSpan = document.getElementById(`invalidMailSpan${date}`);
    const importantDivStarPos = 3;
    const checkBoxNum = mainContainer.children.length - importantDivStarPos;
    // console.log(checkBoxNum);
    // console.log(mainContainer.children);
    // console.log(mainContainer.children.length);

    mailFormShown = !mailFormShown;
    if (mailFormShown) {
        mailField.style.display = 'block';
        sendMailBtn.style.display = 'block';
        validateSpan.style.display = 'block';
        //enable visility of checkboxes
        showCheckBoxes(checkBoxNum, date);


    } else {
        mailField.style.display = 'none';
        sendMailBtn.style.display = 'none';
        validateSpan.style.display = 'none';
        hideCheckBoxes(checkBoxNum, date);
    }
}

function sendMailTo(date) {
    let mainContainer = document.getElementById(date);
    let mail = document.getElementById(`input${date}`).value;
    let invalidMsgSpan = document.getElementById(`invalidMailSpan${date}`);
    let progressBar = document.getElementById(`progress${date}`);
    let dayEventsToSend = document.getElementById(date).innerHTML;


    let divsArr = [{
        'date': date,
        'textContent': []
    }];

    //iterate divs and search checked ones. Begin from index 3 because from there is the div with checkbox;
    for (let i = 3; i < mainContainer.children.length; i++) {
        let currentDiv = mainContainer.children[i];
        let divContent = currentDiv.children[0].children[0].children[1].children[0];
        let checkbox = currentDiv.children[0].children[0].children[1].children[0].children[0].children[0].children[0].checked;
        // console.log(divContent);
        //these are the <p> content of the main div. - date, begin, finish etc...
        if (checkbox) {
            divsArr[0].textContent.push(divContent.children[1].textContent);
            divsArr[0].textContent.push(divContent.children[2].textContent);
            divsArr[0].textContent.push(divContent.children[3].textContent);
            divsArr[0].textContent.push(divContent.children[4].textContent);
        }
    }

    if (divsArr[0].textContent.length < 1) {
        invalidMsgSpan.innerText = 'You must choose at least one event';
        return;
    }

    const regex = /^(([^<>()\[\]\.,;:\s@\"]+(\.[^<>()\[\]\.,;:\s@\"]+)*)|(\".+\"))@(([^<>()[\]\.,;:\s@\"]+\.)+[^<>()[\]\.,;:\s@\"]{2,})$/i;
    const result = regex.test(String(mail).toLowerCase());
    if (!result) {
        invalidMsgSpan.innerText = 'Invalid mail';
        return false;
    }
    invalidMsgSpan.style.display = 'none';
    progressBar.style.display = 'block';


    let formData = new FormData();
    formData.append('receiver', mail);
    formData.append('dayEvents', JSON.stringify(divsArr));
    // formData.append('dayEvents', dayEventsToSend);


    let request = new XMLHttpRequest();
    request.open('POST', URLROOT + "/events/sendToMail");
    request.send(formData);
    request.onreadystatechange = function() {
        if (request.readyState == XMLHttpRequest.DONE) {
            const serverResp = JSON.parse(request.responseText);
            if (serverResp.success) {
                invalidMsgSpan.style.color = 'green';
                invalidMsgSpan.innerText = 'Mail sent successfull';
                invalidMsgSpan.style.display = 'block';
                progressBar.style.display = 'none';

                return;
            } else {
                invalidMsgSpan.display = 'block';
                invalidMsgSpan.innerText = 'There is some problem sending mail';
                return;
            }
        }
    }
}