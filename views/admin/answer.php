<?php
/** @var \ricco\ticket\models\TicketHead $newTicket */
use yii\helpers\Html;

/** @var \ricco\ticket\models\TicketBody $thisTicket */
?>
<div class="mainpanel">
    <div class="pageheader">
        <div class="media">
            <div class="media-body">
                <h4>Тикеты</h4>
            </div>
        </div><!-- media -->
    </div><!-- pageheader -->
    <div class="contentpanel">
        <div class="container-fluid">
            <div class="col-md-12">
                <a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['/ticket/admin/index'])?>" style="margin-bottom: 10px">Назад</a>
                <a class="btn btn-primary" style="width: 100%" role="button" data-toggle="collapse" href="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
                    <i class="glyphicon glyphicon-pencil pull-left"></i><span>Ответ</span>
                </a>
                <div class="collapse" id="collapseExample">
                    <div class="well">
                        <?php $form = \yii\widgets\ActiveForm::begin([]) ?>
                        <?=$form->field($newTicket, 'text')->textarea(['style' => 'height: 150px; resize: none;'])->label('Сообщение')->error()?>
                        <div class="text-center"><button class='btn btn-primary'>Отправить</button></div>
                        <?=$form->errorSummary($newTicket)?>
                        <?php $form->end() ?>
                    </div>
                </div>
                <div class="clearfix" style="margin-bottom: 20px"></div>
                <?php foreach ($thisTicket as $ticket) : ?>
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <span><?=$ticket['name_user']?>&nbsp;<span style="font-size: 12px">(<?=($ticket['client'] == 1) ? 'Сотрудник' : 'Клиент'?>)</span></span>
                            <span class="pull-right"><?=$ticket['date']?></span>
                        </div> <div class="panel-body">
                            <?=nl2br(Html::encode($ticket['text']))?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div><!-- contentpanel -->
</div><!-- mainpanel -->