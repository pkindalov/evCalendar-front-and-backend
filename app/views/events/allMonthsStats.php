<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
    <div class="col l12">
        <table class="highlight">
            <thead>
                <tr>
                    <th>Months</th>
                    <th>Events Count</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($data['busyMonths'] as $key => $value) : ?>
                    <?php if ($key == $data['currentMonth']) : ?>
                        <tr class="currentWeek">
                            <td><?php echo $key; ?></td>
                            <td class="center-align"><?php echo $value[0]; ?></td>
                        </tr>
                    <?php else : ?>
                        <tr>
                            <td><?php echo $key; ?></td>
                            <td class="center-align"><?php echo $value[0]; ?></td>
                        </tr>
                    <?php endif; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="col l12">
        <canvas id="myChart" width="300" height="400"></canvas>
        <!-- <div id="chart_div"></div> -->
    </div>
</div>

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.3/Chart.js"></script>
<!-- <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script> -->
<script>
    document.addEventListener('DOMContentLoaded', function() {

        const dateLabels = <?php echo $data['dateLabels']; ?>;
        const dateValues = <?php echo $data['dateValues']; ?>;
        // console.log(dateLabels);
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                // labels: ['Red', 'Blue', 'Yellow', 'Green', 'Purple', 'Orange'],
                labels: dateLabels,
                datasets: [{
                    label: '# of events in month. Started week is shown on hover window when you put mouse on bar',
                    // data: [12, 19, 3, 5, 2, 3],
                    data: dateValues,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 99, 132, 0.2)',
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    });   

</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>