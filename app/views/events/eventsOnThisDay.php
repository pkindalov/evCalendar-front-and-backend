<?php require APPROOT . '/views/inc/header.php'; ?>


<div class="row">
  <div class="col lg12">
    <h4>Events happened on <a href="<?php echo $data['todayURL']; ?>" target="_blank"><?php echo $data['today'] ?></a></h4>
  </div>
</div>

<div class="row">
  <div class="col l12">
    <a href="#" class="btn" id="showHideMailForm">Send By Email</a>
    <div class="mailField" id="mailForm">
      <input type="email" id="mail" /><br />
      <a href="#" id="sentMailBtn" class="btn">Send</a>
      <span id="invalidMailSpan" class="mailField validateMsg"></span>
    </div>
    <div id="progress" class="progress mailField">
      <div class="indeterminate"></div>
    </div>
  </div>
</div>

<div class="row">
  <div id="eventContId"></div>
</div>




<!-- <?php //foreach ($data['events'] as $key => $value) : 
      ?>
  <div class="col s12 m7">
    <div class="card horizontal">
      <div class="card-image">
       
      </div>
      <div class="card-stacked">
        <div class="card-content">
          <p><?php //echo $value['html']; 
              ?></p>
        </div>
        
      </div>
    </div>
  </div>
            
   
<?php //endforeach; 
?>     -->

<script>
  let that = this;
  let mainContainer = document.getElementById('eventContId');
  let showHideMailFormBtn = document.getElementById('showHideMailForm');
  let sendMailBtn = document.getElementById('sentMailBtn');
  let formContainer = document.getElementById('mailForm');
  let invalidMsgSpan = document.getElementById('invalidMailSpan');
  let progress = document.getElementById('progress');
  let showMailForm = false;
  that.data = <?php echo $data['eventsEnc']; ?>;
  that.page = 1;
  that.pageSize = 10;
  that.offset = that.page * pageSize;

  function addContent(slicedData) {
    mainContainer.innerHTML = '';
    for (let index = 0; index < slicedData.length - 1; index++) {
      let content = slicedData[index].html;
      let contentId = slicedData[index].id;
      let cardDiv = `<div id="event-${contentId}" class="col l12 m7">
                        <div class="card horizontal">
                          <div class="card-image"></div>
                          <div class="card-stacked">
                            <div class="card-content">
                            <div class="mailField">
                                <label>
                                  <input id="checkboxEvent${contentId}" type="checkbox" />
                                    <span>Choose to send</span>
                                </label>
                              </div>
                              <p>${content}</p>
                            </div>
                          </div>
                        </div>
                      </div>`;
      mainContainer.innerHTML += cardDiv;
    }

    addPrevNextBtns();
  }

  function addPrevNextBtns() {
    let mainContainer = document.getElementById('eventContId');
    let nextBtn = document.createElement('a');
    nextBtn.setAttribute('href', '#');
    nextBtn.setAttribute('class', 'btn');
    nextBtn.innerText = 'Next';
    nextBtn.onclick = () => {
      that.page++;
      that.offset = (that.page - 1) * that.pageSize;
      let newData = data.slice(that.offset, that.pageSize + that.offset);
      addContent(newData);
    }
    mainContainer.append(nextBtn);
    
    showMailForm = false;
    formContainer.style.display = 'none';
    // if (that.offset + that.pageSize <= that.data.length) {
    // }


    if (that.page > 1) {
      let prevBtn = document.createElement('a');
      prevBtn.setAttribute('href', '#');
      prevBtn.setAttribute('class', 'btn leftMargin');
      prevBtn.innerText = 'Prev';
      prevBtn.onclick = () => {
        that.page--;
        that.offset = (that.page - 1) * that.pageSize;
        let newData = data.slice(that.offset, that.offset + that.pageSize);
        addContent(newData);
      }
      mainContainer.append(prevBtn);
      showMailForm = false;
      formContainer.style.display = 'none';

    }
  }

  function showCheckboxesInCont(checkBoxesCount) {
    // console.log(mainContainer.children.length);
    for (let i = 0; i < checkBoxesCount - 1; i++) {
      if (mainContainer.children[i].children[0]) {
        let checkBoxDiv = mainContainer.children[i].children[0].children[1].children[0].children[0]
        checkBoxDiv.style.display = 'block';
      }
    }
  }

  function hideCheckboxesInCont(checkBoxesCount) {
    for (let i = 0; i < checkBoxesCount - 1; i++) {
      if (mainContainer.children[i].children[0]) {
        let checkBoxDiv = mainContainer.children[i].children[0].children[1].children[0].children[0]
        checkBoxDiv.style.display = 'none';
      }
    }
  }



  

  document.addEventListener('DOMContentLoaded', function() {
    addContent(that.data.slice(that.page, that.offset), that.page, that.pageSize);



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

      let divsArr = [{
        'textContent': []
      }];

      for (let i = 0; i < mainContainer.children.length - 1; i++) {
        // console.log(mainContainer.children[i]);
        if (mainContainer.children[i].children[0]) {
          const checkBox = mainContainer.children[i].children[0].children[1].children[0].children[0].children[0].children[0];
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
      request.open('POST', "<?php echo URLROOT; ?>/events/sendEventsOnThisDay");
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
      }

    });


  });
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>