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
    <div class="mailField" id="mailForm">
      <input type="email" id="mail" /><br />
      <a href="#" id="sentMailBtn" class="btn">
        <span class="material-icons alignVertically">
          send
        </span>
        Send
      </a>
      <span id="invalidMailSpan" class="mailField validateMsg"></span>
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

<?php require APPROOT . '/views/inc/footer.php'; ?>