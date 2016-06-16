<?php

namespace ricco\ticket\controllers;

use ricco\ticket\models\Ticket;
use ricco\ticket\models\TicketBody;
use ricco\ticket\models\TicketHead;
use yii\filters\AccessControl;
use dektrium\user\filters\AccessRule;
use yii\helpers\Url;
use yii\web\Controller;

/**
 * Default controller for the `ticket` module
 */
class TicketController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'ruleConfig' => [
                    'class' => AccessRule::className(),
                ],
                'rules' => [
                    [
                        'actions' => ['index', 'view', 'open'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
        ];
    }

    /**
     * Renders the index view for the module
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = (new TicketHead())->dataProvider();
        Url::remember();
        return $this->render('index', ['dataProvider' => $dataProvider]);
    }

    public function actionView($id)
    {
        $model = TicketBody::find()->where(['id_head' => $id])->orderBy('date DESC')->all();

        if (!$model) {
            return $this->actionIndex();
        }

        $newModel = new TicketBody();

        if (\Yii::$app->request->post() && $newModel->load(\Yii::$app->request->post()) && $newModel->validate()) {
            $ticket = TicketHead::findOne($id);
            $ticket->status = 1;
            if ($ticket->save()) {
                $newModel->id_head = $id;
                $newModel->save();
            }

            $this->redirect(Url::to());
        }

        return $this->render('view', ['model' => $model, 'new' => $newModel]);
    }

    public function actionOpen()
    {
        $tisketHead = new TicketHead();
        $tisketBody = new TicketBody();

        if(\Yii::$app->request->post()) {
            $tisketHead->load(\Yii::$app->request->post());
            $tisketBody->load(\Yii::$app->request->post());

            if ($tisketBody->validate() && $tisketHead->validate()) {
                $tisketHead->save();
                $tisketBody->id_head = $tisketHead->getPrimaryKey();
                $tisketBody->save();
                return $this->redirect(Url::previous());
            }
        }

        return $this->render('open', ['tisketHead' => $tisketHead, 'tisketBody' => $tisketBody]);
    }
}
