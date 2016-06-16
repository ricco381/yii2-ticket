<?php

namespace ricco\ticket\controllers;

use ricco\ticket\models\TicketBody;
use ricco\ticket\models\TicketHead;
use yii\data\ActiveDataProvider;
use yii\helpers\Url;
use yii\web\Controller;

class AdminController extends Controller
{
    //public $layout = '@app/module/admin/views/layouts/index.php';

    public function actionIndex()
    {
        $query = TicketHead::find()->joinWith('user');
        $dataPrivider = new ActiveDataProvider([
            'query' => $query,
            'sort' => [
                'defaultOrder' => [
                    'date_update' => SORT_DESC
                ]
            ],
            'pagination' => [
                'pageSize' => 20
            ]
        ]);

        Url::remember();

        return $this->render('index', ['dataProvider' => $dataPrivider]);
    }

    public function actionAnswer($id)
    {
        $model = TicketBody::find()->where(['id_head' => $id])->asArray()->orderBy('date DESC')->all();
        $new = new TicketBody();

        if (\Yii::$app->request->post()) {
            $new->load(\Yii::$app->request->post());
            $new->id_head = $id;

            if ($new->save()) {
                $model = TicketHead::findOne($id);
                $model->status = TicketHead::ANSWER;
                $model->save();
                return $this->redirect(Url::to());
            }
        }

        return $this->render('answer', ['model' => $model, 'new' => $new]);
    }

    public function actionDelete($id)
    {
        TicketHead::findOne($id)->delete();
        return $this->redirect(Url::previous());
    }

    public function actionClosed($id)
    {
        $model = TicketHead::findOne($id);

        $model->status = TicketHead::CLOSED;
        $model->save();

        return $this->redirect(Url::previous());
    }
}