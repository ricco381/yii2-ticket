<?php
use ricco\ticket\models\TicketHead;
?>
<p style="text-align: center;"><img src="#" alt=""/></p>
<p style="text-align: left; font-size: 14px;"><?= \yii\bootstrap\Html::encode($textTicket)?></p>
<hr/>
<p>
    <strong>Тикет:&nbsp;</strong><?=$nameTicket?>
    <br/>
    <strong>Статус:&nbsp;</strong>
    <?php
    switch ($status) {
        case TicketHead::OPEN :
            echo 'Открыт';break;
        case TicketHead::WAIT :
            echo 'Ожидание';break;
        case TicketHead::ANSWER :
            echo 'Отвечен';break;
        case TicketHead::CLOSED :
            echo 'Закрыт';break;
    }
    ?>
    <br/>
    <strong>Ссылка:&nbsp;
        <a
            href="<?=$link?>"><?=$link?>
        </a>
    </strong>
</p>
<hr/>
<em>
    <span style="color: #808080;">Это письмо сформировано автоматически. Отвечать на него не нужно</span>
</em
