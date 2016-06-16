<?php

namespace ricco\ticket\controllers;

use dektrium\user\models\User;
use ricco\ticket\Mailer;
use ricco\ticket\models\TicketBody;
use ricco\ticket\models\TicketHead;
use ricco\ticket\Module;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * @property Module $module
 */

class AdminController extends Controller
{
    /**
     * Выдорка всех тикетов
     * Сортировка по полю дата в обратном порядке
     * Постраничная навигация по 20 тикетов на страницу
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataPrivider = (new TicketHead())->dataProviderAdmin();
        Url::remember();

        return $this->render('index', ['dataProvider' => $dataPrivider]);
    }

    /**
     * Функция вытаскивает данные тикета по id и отображает данные
     * После получения пост данных id тикущего тикета присваевается к ответу и сохраняется
     * Потом идет выборка данных по шапке тикета, меняем ему статус и сохраняем
     * Проверяем если $mailSendAnswer === true значит делаем отправку уведомления од ответе пользователю создавшему тикет
     *
     * @param $id int
     * @return string|\yii\web\Response
     */
    public function actionAnswer($id)
    {
        $thisTicket = TicketBody::find()->where(['id_head' => $id])->asArray()->orderBy('date DESC')->all();
        $newTicket = new TicketBody();

        if (\Yii::$app->request->post()) {
            $newTicket->load(\Yii::$app->request->post());
            $newTicket->id_head = $id;

            if ($newTicket->save()) {
                $ticketHead = TicketHead::findOne($newTicket->id_head);
                $ticketHead->status = TicketHead::ANSWER;

                if ($ticketHead->save()) {
                    if ($this->module->mailSendAnswer !== false) {
                        (new Mailer())
                            ->sendMailDataTicket($ticketHead['topic'], $ticketHead['status'], $newTicket->id_head, $newTicket->text)
                            ->setDataFrom(User::findOne([
                                'id' => $ticketHead->user_id])['email'],
                                $this->module->subjectAnswer
                            )
                            ->senda('answer');
                    }
                }

                return $this->redirect(Url::to());
            }
        }

        return $this->render('answer', ['thisTicket' => $thisTicket, 'newTicket' => $newTicket]);
    }

    /**
     * Делаем выборку шапки тикета, меняем ему статус на закрытый и сохоаняем
     * Если $mailSendClosed === true, делаем отправку уведомления на email о закрытии тикета
     *
     * @param $id int id
     * @return \yii\web\Response
     */
    public function actionClosed($id)
    {
        $model = TicketHead::findOne($id);

        $model->status = TicketHead::CLOSED;

        if ($model->save()) {
            if ($this->module->mailSendClosed !== false) {
                (new Mailer())
                    ->sendMailDataTicket($model->department, $model->status, $model->id)
                    ->setDataFrom(User::findOne([
                        'id' => $model->user_id])['email'],
                        $this->module->subjectCloset
                    )
                    ->senda('closed');
            }
        }

        return $this->redirect(Url::previous());
    }

    /**
     * @param $id int
     * @return \yii\web\Response
     * @throws \Exception
     */
    public function actionDelete($id)
    {
        TicketHead::findOne($id)->delete();
        return $this->redirect(Url::previous());
    }
}