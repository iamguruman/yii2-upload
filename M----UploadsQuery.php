<?php


namespace app\modules\customer_review\models;

/**
 * This is the ActiveQuery class for [[M----Uploads]].
 *
 * @see MReviewUpload
 */
class MReviewUploadQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    public function init()
    {
        parent::init();

        if(aIfHideMarkdel()){
            $this->andWhere(['m_review__uploads.markdel_by' => null]);
        }
    }

    /**
     * {@inheritdoc}
     * @return MReviewUploadQuery[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * {@inheritdoc}
     * @return MReviewUploadQuery|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
