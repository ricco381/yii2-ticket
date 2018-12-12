<?php

namespace ricco\ticket\controllers;

use ricco\ticket\models\TicketBody;
use ricco\ticket\models\TicketFile;
use ricco\ticket\models\TicketHead;
use ricco\ticket\models\UploadForm;
use yii\filters\AccessControl;
use yii\filters\AccessRule;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;

/**
 * Default controller for the `ticket` module
 */
class TicketController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class'      => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules'      => [
                    [
                        'actions' => ['index', 'view', 'open'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Делается выборка тела тикета по id и отображаем данные
     * Если пришел пустой результат показываем список тикетов
     * Создаем экземпляр новой модели тикета
     * К нам пришел пост делаем загрузку в модель и проходим валидацию, если все хорошо делаем выборку шапки, меняем ей статус и сохраняем
     * Записываем id тикета новому ответу чтоб не потерялся и сохроняем новый ответ
     *
     * @param $id
     * @return string
     */
    public function actionView($id)
    {
        $ticket = TicketHead::findOne([
            'id'      => $id,
            'user_id' => \Yii::$app->user->id,
        ]);
        if ($ticket && $ticket->status == TicketHead::ANSWER) {
            $ticket->status = TicketHead::VIEWED;
            $ticket->save();
        }

        $thisTicket = TicketBody::find()->where(['id_head' => $id])->joinWith('file')->orderBy('date DESC')->all();

        if (!$ticket || !$thisTicket) {
            return $this->actionIndex();
        }

        $newTicket = new TicketBody();
        $ticketFile = new TicketFile();

        if (\Yii::$app->request->post() && $newTicket->load(\Yii::$app->request->post()) && $newTicket->validate()) {

            $ticket->status = TicketHead::WAIT;

            $uploadForm = new UploadForm();
            $uploadForm->imageFiles = UploadedFile::getInstances($ticketFile, 'fileName');

            if ($ticket->save() && $uploadForm->upload()) {
                $newTicket->id_head = $id;
                $newTicket->save();

                TicketFile::saveImage($newTicket, $uploadForm);
            } else {
                \Yii::$app->session->setFlash('error', $uploadForm->firstErrors['imageFiles']);

                return $this->render('view', [
                    'thisTicket' => $thisTicket,
                    'newTicket'  => $newTicket,
                    'fileTicket' => $ticketFile,
                ]);
            }

            if (\Yii::$app->request->isAjax) {
                return 'OK';
            }

            $this->redirect(Url::to());
        }

        return $this->render('view', [
            'thisTicket' => $thisTicket,
            'newTicket'  => $newTicket,
            'fileTicket' => $ticketFile,
        ]);
    }

    /**
     * Renders the index view for the module
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = (new TicketHead())->dataProviderUser();
        Url::remember();

        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    /**
     * Создаем два экземпляра
     * 1. Шапка тикета
     * 2. Тело тикета
     * Делаем рендеринг страницы
     * Если post, проводим загрузку данных в модели, делаем валидацию
     * Сохраняем сначало шапку, узнаем его id, этот id присваеваем телу сообщения чтоб не потерялось и сохраняем
     *
     * @return string|\yii\web\Response
     */
    public function actionOpen()
    {
        $ticketHead = new TicketHead();
        $ticketBody = new TicketBody();
        $ticketFile = new TicketFile();

        if (\Yii::$app->request->post()) {
            $ticketHead->load(\Yii::$app->request->post());
            $ticketBody->load(\Yii::$app->request->post());

            if ($ticketBody->validate() && $ticketHead->validate()) {
                if ($ticketHead->save()) {
                    $ticketBody->id_head = $ticketHead->getPrimaryKey();
                    $ticketBody->save();

                    $uploadForm = new UploadForm();
                    $uploadForm->imageFiles = UploadedFile::getInstances($ticketFile, 'fileName');
                    if ($uploadForm->upload()) {
                        TicketFile::saveImage($ticketBody, $uploadForm);
                    }

                    if (\Yii::$app->request->isAjax) {
                        return 'OK';
                    }

                    return $this->redirect(Url::previous());
                }
            }
        }

        return $this->render('open', [
            'ticketHead' => $ticketHead,
            'ticketBody' => $ticketBody,
            'qq'         => $this->module->qq,
            'fileTicket' => $ticketFile,
        ]);
    }
}
