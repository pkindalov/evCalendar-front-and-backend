<?php require APPROOT . '/views/inc/header.php'; ?>


<div class="row">
  <div class="col lg12">
    <h4>Events happened on <a href="<?php echo $data['todayURL']; ?>" target="_blank"><?php echo $data['today'] ?></a></h4>
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
  that.data = <?php echo $data['eventsEnc']; ?>;
  that.page = 1;
  that.pageSize = 10;
  that.offset = that.page * pageSize;

  function addContent(slicedData) {
    mainContainer.innerHTML = '';
    for (let index = 0; index < slicedData.length; index++) {
      let content = slicedData[index].html;
      let contentId = slicedData[index].id;
      let cardDiv = `<div id="event-${contentId}" class="col l12 m7">
                        <div class="card horizontal">
                          <div class="card-image"></div>
                          <div class="card-stacked">
                            <div class="card-content">
                              <p>${content}</p>
                            </div>
                          </div>
                        </div>
                      </div>`;
      mainContainer.innerHTML += cardDiv;
    }

    addPrevNextBtns();
  }

  function addPrevNextBtns(){
    let mainContainer = document.getElementById('eventContId');
    if(that.offset + that.pageSize <= that.data.length){
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
    }


    if(that.page > 1){
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
    }
  }

  document.addEventListener('DOMContentLoaded', function() {
    addContent(that.data.slice(that.page, that.offset), that.page, that.pageSize);
  });
</script>

<?php require APPROOT . '/views/inc/footer.php'; ?>