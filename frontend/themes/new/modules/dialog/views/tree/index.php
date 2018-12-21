<?php
/**
 * Created by PhpStorm.
 * User: nnikitchenko
 * Date: 25.05.2016
 *
 * @var \common\models\dialog\DialogQuest[] $DialogQuest
 * @var \common\models\Quest $Quest
 */ ?>
<style>
    .vertical-timeline-content p {
        margin: 0;
    }
</style>
<div class="row">
    <div class="col-lg-12">
        <div class="ibox">
            <div class="ibox-title">
                <h5>Квест: <?= $Quest->name ?></h5>
            </div>
            <div class="ibox-content">
                <div id="vertical-timeline" class="vertical-container dark-timeline center-orientation">
                    <?php foreach ($DialogQuest as $Dialog): ?>
                        <div class="vertical-timeline-block">
                            <div class="vertical-timeline-icon blue-bg">
                                <i class="fa fa-file-text"></i>
                            </div>

                            <div class="vertical-timeline-content">
                                <?= $Dialog->message ?>
                            </div>
                        </div>
                        <div class="vertical-timeline-block">
                            <div class="vertical-timeline-icon blue-bg">
                                <i class="fa fa-file-text"></i>
                            </div>

                            <?php foreach ($Dialog->questDialogActions as $Action): ?>
                                <div class="vertical-timeline-content">
                                    <?= $Action->message ?>
                                </div>
                                <div style="clear: right;height: 5px;"></div>
                            <?php endforeach; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</div>
