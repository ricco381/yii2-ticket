<?php
/** @var \ricco\ticket\models\TicketHead $dataProvider */
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
        <a href="<?=\yii\helpers\Url::toRoute(['admin/open'])?>" class="btn btn-default">Написать</a>
        <br><br>
        <div class="container-fluid">
            <div class="col-md-12">
                <?= \yii\grid\GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns'      => [
                        [
                            'attribute' => 'userName',
                            'value'     => 'userName.username',
                        ],
                        [
                            'attribute' => 'department',
                            'value'     => 'department',
                        ],
                        [
                            'attribute' => 'topic',
                            'value'     => 'topic',
                        ],
                        [
                            'attribute' => 'status',
                            'value'     => function ($model) {
                                switch ($model->body['client']) {
                                    case 0 :
                                        if ($model->status == \ricco\ticket\models\TicketHead::CLOSED) {
                                            return '<div class="label label-success">Клиент</div>&nbsp;<div class="label label-default">Закрыт</div>';
                                        }
                                        return '<div class="label label-success">Клиент</div>';
                                    case 1 :
                                        if ($model->status == \ricco\ticket\models\TicketHead::CLOSED) {
                                            return '<div class="label label-primary">Администратор</div>&nbsp;<div class="label label-default">Закрыт</div>';
                                        }
                                        return '<div class="label label-primary">Администратор</div>';
                                }
                            },
                            'format'    => 'html',
                        ],
                        [
                            'attribute' => 'date_update',
                            'value'     => 'date_update',
                        ],
                        [
                            'class'         => 'yii\grid\ActionColumn',
                            'template'      => '{update}&nbsp;{delete}&nbsp;{closed}',
                            'headerOptions' => [
                                'style' => 'width:230px',
                            ],
                            'buttons'       => [
                                'update' => function ($url, $model) {
                                    return \yii\helpers\Html::a('Ответить',
                                        \yii\helpers\Url::toRoute(['admin/answer'. 'id' => $model['id']]),
                                        ['class' => 'btn-xs btn-info']);
                                },
                                'delete' => function ($url, $model) {
                                    return \yii\helpers\Html::a('Удалить',
                                        \yii\helpers\Url::to(['admin/delete', 'id' => $model['id']]),
                                        [
                                            'class'   => 'btn-xs btn-danger',
                                            'onclick' => 'return confirm("Вы действительно хотите удалить?")',
                                        ]
                                    );
                                },
                                'closed' => function ($url, $model) {
                                    return \yii\helpers\Html::a('Закрыть',
                                        \yii\helpers\Url::to(['admin/closed', 'id' => $model['id']]),
                                        [
                                            'class'   => 'btn-xs btn-primary',
                                            'onclick' => 'return confirm("Вы действительно хотите закрыть тикет?")',
                                        ]
                                    );
                                },
                            ],
                        ],
                    ],
                ]) ?>
            </div>
        </div>
    </div><!-- contentpanel -->
</div><!-- mainpanel -->