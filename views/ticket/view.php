<?php

use yii\helpers\Html;

$this->title = 'Support';

/** @var \ricco\ticket\models\TicketBody $newTicket */
/** @var \ricco\ticket\models\TicketBody $thisTicket */
/** @var \ricco\ticket\models\TicketFile $fileTicket */

?>
<div class="text_block2">
    <a class="btn btn-primary" href="<?= \yii\helpers\Url::to(['/ticket/ticket/index']) ?>" style="margin-bottom: 10px">Назад</a>
    <a class="btn btn-primary" style="width: 100%" role="button" data-toggle="collapse" href="#collapseExample"
       aria-expanded="false" aria-controls="collapseExample">
        <i class="glyphicon glyphicon-pencil pull-left"></i><span>Ответ</span>
    </a>
    <div class="collapse" id="collapseExample">
        <div class="well">
            <?php $form = \yii\widgets\ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
            <?= $form->field($newTicket,
                'text')->textarea(['style' => 'height: 150px; resize: none;'])->label('Сообщение')->error() ?>
            <?= $form->field($fileTicket, 'fileName[]')->fileInput([
                'multiple' => true,
                'accept'   => 'image/*',
            ])->label(false); ?>
            <div class="text-center">
                <button class='btn btn-primary'>Отправить</button>
            </div>
            <?= $form->errorSummary($newTicket) ?>
            <?php $form->end() ?>
        </div>
    </div>
    <div class="clearfix" style="margin-bottom: 20px"></div>
    <?php foreach ($thisTicket as $ticket) : ?>
        <div class="panel panel-primary">
            <div class="panel-heading">
                <span><?= $ticket['name_user'] ?>&nbsp;<span
                        style="font-size: 12px">(<?= ($ticket['client'] == 1) ? 'Сотрудник' : 'Клиент' ?>)</span></span>
                <span class="pull-right"><?= $ticket['date'] ?></span>
            </div>
            <div class="panel-body clearfix">
                <?= nl2br(Html::encode($ticket['text'])) ?>
                <?php if (!empty($ticket->file)) : ?>
                    <hr>
                    <?php foreach ($ticket->file as $file) : ?>
                        <button type="button" data-toggle="modal" data-target="#myModal_<?= $file->id?>"><img src="/fileTicket/<?= $file->fileName ?>" alt="..." class="img-thumbnail" width="50px"></button>
                        <div id="myModal_<?= $file->id ?>" class="modal fade" tabindex="-1" role="dialog"
                             aria-labelledby="myModalLabel" aria-hidden="true">
                            <div class="modal-dialog" style="width: 90%; background-size: contain;">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <img src="/fileTicket/<?= $file->fileName ?>" style="width:100%; background-size: contain;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>

            </div>
        </div>
    <?php endforeach; ?>
</div>
