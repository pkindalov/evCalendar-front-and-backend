</div> <!-- Ending div of .container -->
<!-- <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script> -->

<footer class="page-footer">
          <div class="container startSplash">
            <div class="row">
              <div class="col l6 s12">
                <!-- <h5 class="white-text">Footer Content</h5> -->
                <!-- <p class="grey-text text-lighten-4">You can use rows and columns here to organize your footer content.</p> -->
              </div>
              <!-- <div class="col l4 offset-l2 s12">
                <h5 class="white-text">Links</h5>
                <ul>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 1</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
                  <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
                </ul>
              </div> -->
            </div>
          </div>
          <div class="footer-copyright">
            <div class="container startSplash">
            © 2014 Copyright Text
            <!-- <a class="grey-text text-lighten-4 right" href="#!">More Links</a> -->
            </div>
          </div>
        </footer>
  
<script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>    
<script>
    document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.sidenav');
    var instances = M.Sidenav.init(elems);
    var selectElems = document.querySelectorAll('select');
    var selectInstances = M.FormSelect.init(selectElems);
    var modalEl = document.querySelectorAll('.modal');
    var modalElInstances = M.Modal.init(modalEl);
    var datePickers = document.querySelectorAll('.datepicker');
    var datepickersInstances = M.Datepicker.init(datePickers, { format: 'yyyy-mm-dd', showClearBtn: true });
    var timePickersElems = document.querySelectorAll('.timepicker');
    var timePickersInstances = M.Timepicker.init(timePickersElems, { twelveHour: false, showClearBtn: true });

  
  });
</script>    
</body>
</html>