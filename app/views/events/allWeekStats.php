<?php require APPROOT . '/views/inc/header.php'; ?>

<pre>
    <!-- <?php //print_r($data['busyWeeks']); 
            // echo date('w');
            ?> -->
</pre>

<div class="row">
    <div class="col l12 s12">
        <table class="highlight">
            <thead>
                <tr>
                    <th>Number Week/Week</th>
                    <th>Events Count</th>
                </tr>
            </thead>

            <tbody>
               <?php $count = 1; ?> 
                <?php foreach ($data['busyWeeks'] as $key => $value) : ?>
                    <?php if ($key == $data['currentWeek']) : ?>
                        <tr class="currentWeek">
                            <td><?php echo $count . ' ' . $key; ?></td>
                            <td class="center-align"><?php echo $value[0]; ?></td>
                        </tr>
                    <?php else : ?>
                        <tr>
                            <td><?php echo $count . ' ' . $key; ?></td>
                            <td class="center-align"><?php echo $value[0]; ?></td>
                        </tr>
                    <?php endif; ?>
                  <?php $count++; ?>  
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Google chart here -->
<div class="row">
    <div class="col l12 s10">
        <canvas id="myChart" width="300" height="400"></canvas>
        <!-- <div id="chart_div"></div> -->
    </div>
</div>


<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
<script src="<?php echo URLROOT ?>/js/drawChartJs.js"></script>
<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const dataLabels = <?php echo $data['dateLabels']; ?>;
        const dataValues = <?php echo $data['dateValues']; ?>;
        const options = {
            ctx: 'myChart',
            labels: dataLabels,
            data: dataValues,
            type: 'bar',
            backgroundColor: [],
            label: '# of events in week. Started week is shown on hover window when you put mouse on bar',
            borderWidth: 1,
            beginAtZero: true
        }
        drawChartJS(options);
       
        //GOOGLE STUPID SHITS

        // let myGoogleData = <?php //echo $data['googleBarChartData']; 
                                ?>;


        //     google.charts.load('current', {
        //         packages: ['corechart', 'bar']
        //     });
        //     google.charts.setOnLoadCallback(drawStacked);

        //     function drawStacked() {
        //         var data = google.visualization.arrayToDataTable(myGoogleData);

        //         var options = {
        //             title: 'Count of events per week',
        //             chartArea: {
        //                 width: '50%'
        //             },
        //             isStacked: true,
        //             hAxis: {
        //                 title: 'Total Count Of Events',
        //                 minValue: 0,
        //             },
        //             vAxis: {
        //                 title: 'Weeks'
        //             }
        //         };
        //         var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
        //         chart.draw(data, options);
        //     }
    });
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>