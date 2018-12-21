<?php

/* @var $this yii\web\View */
\frontend\assets\plugins\ChartAsset::register($this);
?>
<!--<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Максимальный одновременный онлайн</h5>
            </div>
            <div class="ibox-content">
                <div>
                    <canvas id="stat-online" height="50"></canvas>
                    <div class="ajax-loader"></div>
                </div>
            </div>
        </div>
    </div>
</div>-->
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Максимальный одновременный онлайн</h5>
            </div>
            <div class="ibox-content">
                <div>
                    <canvas id="stat-online2" height="50"></canvas>
                    <div class="ajax-loader"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php 
if (Yii::$app->user->can(\common\models\User::ROLE_DILER)) {
?>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Поступления за последние 30 дней</h5>
            </div>
            <div class="ibox-content">
                <div>
                    <canvas id="stat-diler" height="50"></canvas>
                    <div class="ajax-loader"></div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>

<script>
    $(function(){
        var triggers = {
            'success' : 'chart:success:online'
        };
        //$ajax.json('<?= \yii\helpers\Url::to(['/stats/online/json']) ?>',null,null,triggers);

        $(window).on('chart:success:online', function(e, response) {
            $("#stat-online").closest('div').find('.ajax-loader').remove();
            var lineData = {
                labels: response.labels,
                datasets: [
                    {
                        fillColor: "rgba(220,220,220,0.2)",
                        strokeColor: "rgba(220,220,220,1)",
                        pointColor: "rgba(220,220,220,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: response.chart
                    }
                ]
            };

            var lineOptions = {
                scaleShowGridLines: true,
                scaleGridLineColor: "rgba(0,0,0,.05)",
                scaleGridLineWidth: 1,
                bezierCurve: true,
                bezierCurveTension: 0.4,
                pointDot: true,
                pointDotRadius: 4,
                pointDotStrokeWidth: 1,
                pointHitDetectionRadius: 20,
                datasetStroke: true,
                datasetStrokeWidth: 2,
                datasetFill: true,
                responsive: true,
                scaleBeginAtZero: true,
                tooltipTemplate: function(v) {return someOtherManipulation(v);}
            };


            var ctx = document.getElementById("stat-online").getContext("2d");
            var myNewChart = new Chart(ctx).Line(lineData, lineOptions);
        });



        triggers = {
            'success' : 'chart:success:online2'
        };
        $ajax.json('<?= \yii\helpers\Url::to(['/stats/online/json2']) ?>',null,null,triggers);
        $(window).on('chart:success:online2', function(e, response) {
            $("#stat-online2").closest('div').find('.ajax-loader').remove();
            var lineData = {
                labels: response.labels,
                datasets: [
                    {
                        fillColor: "rgba(220,220,220,0.2)",
                        strokeColor: "rgba(220,220,220,1)",
                        pointColor: "rgba(220,220,220,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: response.chart
                    }
                ]
            };

            var lineOptions = {
                scaleShowGridLines: true,
                scaleGridLineColor: "rgba(0,0,0,.05)",
                scaleGridLineWidth: 1,
                bezierCurve: true,
                bezierCurveTension: 0.4,
                pointDot: true,
                pointDotRadius: 4,
                pointDotStrokeWidth: 1,
                pointHitDetectionRadius: 20,
                datasetStroke: true,
                datasetStrokeWidth: 2,
                datasetFill: true,
                responsive: true,
                scaleBeginAtZero: true,
                tooltipTemplate: function(v) {return someOtherManipulation(v);}
            };


            var ctx = document.getElementById("stat-online2").getContext("2d");
            var myNewChart = new Chart(ctx).Line(lineData, lineOptions);
        });


	<?php if (Yii::$app->user->can(\common\models\User::ROLE_DILER)) { ?>

        triggers = {
            'success' : 'chart:success:stats'
        };
        $ajax.json('<?= \yii\helpers\Url::to(['/stats/diler/json']) ?>',null,null,triggers);

        $(window).on('chart:success:stats', function(e, response) {
            $("#stat-diler").closest('div').find('.ajax-loader').remove();
            var lineData = {
                labels: response.labels,
                datasets: [
                    {
                        fillColor: "rgba(220,220,220,0.2)",
                        strokeColor: "rgba(220,220,220,1)",
                        pointColor: "rgba(220,220,220,1)",
                        pointStrokeColor: "#fff",
                        pointHighlightFill: "#fff",
                        pointHighlightStroke: "rgba(220,220,220,1)",
                        data: response.chart
                    }
                ]
            };

            var lineOptions = {
                scaleShowGridLines: true,
                scaleGridLineColor: "rgba(0,0,0,.05)",
                scaleGridLineWidth: 1,
                bezierCurve: true,
                bezierCurveTension: 0.4,
                pointDot: true,
                pointDotRadius: 4,
                pointDotStrokeWidth: 1,
                pointHitDetectionRadius: 20,
                datasetStroke: true,
                datasetStrokeWidth: 2,
                datasetFill: true,
                responsive: true,
                scaleBeginAtZero: true,
                tooltipTemplate: function(v) {return someOtherManipulation(v);}
            };


            var ctx = document.getElementById("stat-diler").getContext("2d");
            var myNewChart = new Chart(ctx).Line(lineData, lineOptions);
        });

	<?php } ?>
    });

    function someOtherManipulation(v)
    {
        return v.label + ' = ' + v.value;
    }
</script>