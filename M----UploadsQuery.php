<?php

namespace app\modules\kp\models;

/**
 * This is the ActiveQuery class for [[MKpUploads]].
 *
 * @see MKpUploads
 */
class MKpUploadsQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function init()
    {
        parent::init();

        if(aIfHideMarkdel()){
            $this->andWhere(['m_kp__uploads.markdel_by' => null]);
        }
    }

    /**
     * {@inheritdoc}
     * @return MKpUploads[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MKpUploads|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
