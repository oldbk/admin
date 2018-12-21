<?php
/* @var $this yii\web\View */
/* @var $this yii\web\View */
\frontend\assets\plugins\ChartAsset::register($this);
?>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Старт производств</h5>
            </div>
            <div class="ibox-content">
                <div>
                    <canvas id="stat-craft-start" height="50"></canvas>
                    <div class="ajax-loader"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Потрачено екр на ускорение</h5>
            </div>
            <div class="ibox-content">
                <div>
                    <canvas id="stat-craft-ekr" height="50"></canvas>
                    <div class="ajax-loader"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Получено опыта по всем профессиям</h5>
            </div>
            <div class="ibox-content">
                <div>
                    <canvas id="stat-craft-exp" height="50"></canvas>
                    <div class="ajax-loader"></div>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-lg-12">
        <div class="ibox float-e-margins">
            <div class="ibox-title">
                <h5>Потрачено времени на крафт в днях</h5>
            </div>
            <div class="ibox-content">
                <div>
                    <canvas id="stat-craft-time" height="50"></canvas>
                    <div class="ajax-loader"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>

    $(function(){
	// CRAFT START

        var triggers = {
            'success' : 'chart:success:craftstart'
        };

        $ajax.json('<?= \yii\helpers\Url::to(['/recipe/stats/craftstartjson']) ?>',null,null,triggers);

        $(window).on('chart:success:craftstart', function(e, response) {
            $("#stat-craft-start").closest('div').find('.ajax-loader').remove();
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


            var ctx = document.getElementById("stat-craft-start").getContext("2d");
            var myNewChart = new Chart(ctx).Line(lineData, lineOptions);
        });


	// EKR
        var triggers = {
            'success' : 'chart:success:craftekr'
        };

        $ajax.json('<?= \yii\helpers\Url::to(['/recipe/stats/craftekrjson']) ?>',null,null,triggers);

        $(window).on('chart:success:craftekr', function(e, response) {
            $("#stat-craft-ekr").closest('div').find('.ajax-loader').remove();
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


            var ctx = document.getElementById("stat-craft-ekr").getContext("2d");
            var myNewChart = new Chart(ctx).Line(lineData, lineOptions);
        });

	// EXp
        var triggers = {
            'success' : 'chart:success:craftexp'
        };

        $ajax.json('<?= \yii\helpers\Url::to(['/recipe/stats/craftexpjson']) ?>',null,null,triggers);

        $(window).on('chart:success:craftexp', function(e, response) {
            $("#stat-craft-exp").closest('div').find('.ajax-loader').remove();
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


            var ctx = document.getElementById("stat-craft-exp").getContext("2d");
            var myNewChart = new Chart(ctx).Line(lineData, lineOptions);
        });


	// TIME
        var triggers = {
            'success' : 'chart:success:crafttime'
        };

        $ajax.json('<?= \yii\helpers\Url::to(['/recipe/stats/crafttimejson']) ?>',null,null,triggers);

        $(window).on('chart:success:crafttime', function(e, response) {
            $("#stat-craft-time").closest('div').find('.ajax-loader').remove();
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


            var ctx = document.getElementById("stat-craft-time").getContext("2d");
            var myNewChart = new Chart(ctx).Line(lineData, lineOptions);
        });

    });

    function someOtherManipulation(v)
    {
        return v.label + ' = ' + v.value;
    }
</script>
