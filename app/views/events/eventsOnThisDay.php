<?php require APPROOT . '/views/inc/header.php'; ?>


<div class="row">
  <div class="col lg12">
    <h4>Events happened on <a href="<?php echo $data['todayURL']; ?>" target="_blank"><?php echo $data['today'] ?></a></h4>
  </div>
</div>

<div class="row">
  <div class="col l12 s12">
    <a href="#" id="showHideMailForm">
      <span class="material-icons alignVertically">
        send
      </span>
      Send By Email
    </a>
      <a href="#" onclick="showHideCheckboxSelection()">
            <span class="material-icons alignVertically">
                description
            </span>
          Word
      </a>
    <div class="mailField" id="mailForm">
      <input type="email" id="mail" /><br />
      <a href="#" id="sentMailBtn" class="btn">
        <span class="material-icons alignVertically">
          send
        </span>
        Send
      </a>
        <a href="#" id="sendToGenWord" class="btn mailField">
        <span class="material-icons alignVertically">
          description
        </span>
            Select And Make Word File 
        </a>
        <a href="#" id="sendAllToGenWord" class="btn mailField">
        <span class="material-icons alignVertically">
          description
        </span>
            Print All On A Word File 
        </a>
      <span id="invalidMailSpan" class="mailField validateMsg"></span>
      <div id="selectDeselectAllBtnCont"></div>
    </div>
    <div id="progress" class="progress mailField">
      <div class="indeterminate"></div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col l12 s12">
    <div id="eventContId"></div>
  </div>
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

<script src="<?php echo URLROOT ?>/js/EventsOnThisDayPag.js"></script>
<script src="<?php echo URLROOT ?>/js/SendEventsOnThisDayByMail.js"></script>
<script>
  let that = this;
  let mainContainer = document.getElementById('eventContId');
  that.data = <?php echo $data['eventsEnc']; ?>;
  that.page = 1;
  that.pageSize = 10;
  that.offset = that.page * pageSize;

  document.addEventListener('DOMContentLoaded', function() {
    addContent(that.data.slice(that.page, that.offset), that.page, that.pageSize);
  });


</script>
    <script>
        that.dataToGenWord = [];
        function  showHideCheckboxSelection() {
            showHideMailForm();
            // console.log(document.getElementById('sendToGenWord'));
            if(showMailForm){
                document.getElementById('sendToGenWord').style.display = 'inline-block';
                document.getElementById('sendAllToGenWord').style.display = 'inline-block';
                return;
            }
            document.getElementById('sendToGenWord').style.display = 'none';
            document.getElementById('sendAllToGenWord').style.display = 'none';
        }
        function  iterateSelDivs() {
            for (let i = 0; i < mainContainer.children.length - 1; i++) {
                // console.log(mainContainer.children[i]);
                if (mainContainer.children[i].children[0].nodeName == 'DIV') {
                    const checkBox =
                        mainContainer.children[i].children[0].children[1].children[0].children[0].children[0].children[0];
                    if (checkBox.checked) {
                        let elObj = {};
                        const textEl = mainContainer.children[i].children[0].children[1].children[0].children[1];
                        elObj.event = textEl.innerHTML;
                        that.dataToGenWord.push(elObj);
                    }
                }
            }

        }

        let sendToGenWordFileBtn = document.getElementById('sendToGenWord');
        sendToGenWordFileBtn.addEventListener('click', function () {
            iterateSelDivs();
            if(that.dataToGenWord.length === 0){
                alert("You must choose at least one event for generatation word file");
                return;
            }

            let formData = new FormData();
            formData.append('dayEvents', JSON.stringify(that.dataToGenWord));
            let request = new XMLHttpRequest();
            request.open('POST', URLROOT + '/events/genSelEventsHappToday');
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
            };
        });

       let sendPrintAllEventsOnWordFile = document.getElementById('sendAllToGenWord');
       sendPrintAllEventsOnWordFile.addEventListener('click', function(){
        let formData = new FormData();
            formData.append('dayEvents', JSON.stringify(that.data));
            let request = new XMLHttpRequest();
            request.open('POST', URLROOT + '/events/genWordFileAllEvents');
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
            };
       });

    </script>

<?php require APPROOT . '/views/inc/footer.php'; ?>