<?php require APPROOT . '/views/inc/header.php'; ?>

<!-- <pre>
    <?php print_r($data['events']); ?>
</pre> -->
<div class="row">
    <div class="col lg12">
        <h4>Events happened on <a href="<?php echo $data['todayURL']; ?>"target="_blank"><?php echo $data['today'] ?></a></h4>
    </div>
</div>

<?php foreach ($data['events'] as $key => $value) : ?>

  <div class="col s12 m7">
    <div class="card horizontal">
      <div class="card-image">
        <!-- <img src="https://lorempixel.com/100/190/nature/6"> -->
      </div>
      <div class="card-stacked">
        <div class="card-content">
          <p><?php echo $value['html']; ?></p>
        </div>
        <!-- <div class="card-action">
          <a href="#">This is a link</a>
        </div> -->
      </div>
    </div>
  </div>
            
   <!-- <?php echo $value['html']; ?> -->
<?php endforeach; ?>    

<?php require APPROOT . '/views/inc/footer.php'; ?>