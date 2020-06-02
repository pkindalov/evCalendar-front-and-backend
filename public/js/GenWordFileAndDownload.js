function genWordFileAndDownload(date) {
    let formData = new FormData();
    formData.append('dayEvents', JSON.stringify(data[date]));
    let request = new XMLHttpRequest();
    request.open('POST', URLROOT + "/events/genWordFileEvents");
    request.send(formData);
    request.responseType = 'blob';
    request.onreadystatechange = function() {
        if (request.readyState == XMLHttpRequest.DONE) {
            let download = URL.createObjectURL(request.response);
            let a = document.createElement("a");
            a.href = download;
            a.download = "file-" + new Date().getTime() + '.doc';
            document.body.appendChild(a);
            a.click();
        }
    }
}