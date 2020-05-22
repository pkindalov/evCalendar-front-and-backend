<?php require APPROOT . '/views/inc/header.php'; ?>

<div class="row">
    <div class="col l12 s12">
        <table class="highlight">
            <thead>
                <tr>
                    <th>Months</th>
                    <th>Events Count</th>
                </tr>
            </thead>

            <tbody>
                <!-- <?php $count = 1; ?>  -->
                <?php foreach ($data['busyMonths'] as $key => $value) : ?>
                    <?php if ($key == $data['currentMonth']) : ?>
                        <tr class="currentWeek">
                            <td><?php echo $key; ?></td>
                            <!-- <td><?php //echo $count . ' ' . $key; 
                                        ?></td> -->
                            <td class="center-align"><?php echo $value[0]; ?></td>
                        </tr>
                    <?php else : ?>
                        <tr>
                            <td><?php echo $key; ?></td>
                            <!-- <td><?php //echo $count . ' ' . $key; 
                                        ?></td> -->
                            <td class="center-align"><?php echo $value[0]; ?></td>
                        </tr>
                    <?php endif; ?>
                    <!-- <?php $count++; ?>   -->
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

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
            label: '#number of events in month.',
            borderWidth: 1,
            beginAtZero: true
        }
        drawChartJS(options);
    });
</script>
<?php require APPROOT . '/views/inc/footer.php'; ?>