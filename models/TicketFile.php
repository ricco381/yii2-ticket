<?php

namespace ricco\ticket\models;

use Yii;

/**
 * This is the model class for table "ticket_file".
 *
 * @property integer    $id
 * @property integer    $id_body
 * @property string     $fileName
 *
 * @property TicketBody $idBody
 */
class TicketFile extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ticket_file';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_body'], 'integer'],
            [['fileName'], 'string', 'max' => 255],
            [
                ['id_body'],
                'exist',
                'skipOnError'     => true,
                'targetClass'     => TicketBody::className(),
                'targetAttribute' => ['id_body' => 'id'],
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'       => Yii::t('app', 'ID'),
            'id_body'  => Yii::t('app', 'Id Body'),
            'fileName' => Yii::t('app', 'File Name'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getIdBody()
    {
        return $this->hasOne(TicketBody::className(), ['id' => 'id_body']);
    }
    
    public static function saveImage($ticket, $uploadForm)
    {
        
        foreach ($uploadForm->getName() as $file) {
            $ticketFile = new TicketFile();
            $ticketFile->id_body = $ticket->primaryKey;
            $ticketFile->fileName = $file;
            $ticketFile->save();
        }
    }
}
