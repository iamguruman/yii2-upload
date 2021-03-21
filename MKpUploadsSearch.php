<?php

namespace app\modules\kp\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\modules\kp\models\MKpUploads;

/**
 * MKpUploadsSearch represents the model behind the search form of `app\modules\kp\models\MKpUploads`.
 */
class MKpUploadsSearch extends MKpUploads
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id', 'kp_id', 'team_id', 'created_at', 'created_by', 'updated_at', 'updated_by', 'markdel_by', 'size', 'type_anketa'], 'integer'],
            [['markdel_at', 'filename_original', 'md5', 'ext', 'mimetype'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params, $params2 = [])
    {
        $query = MKpUploads::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'kp_id' => $this->kp_id,
            'team_id' => $this->team_id,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'markdel_by' => $this->markdel_by,
            'markdel_at' => $this->markdel_at,
            'size' => $this->size,
            'type_anketa' => $this->type_anketa,
        ]);

        $query->andFilterWhere(['like', 'filename_original', $this->filename_original])
            ->andFilterWhere(['like', 'md5', $this->md5])
            ->andFilterWhere(['like', 'ext', $this->ext])
            ->andFilterWhere(['like', 'mimetype', $this->mimetype]);

        if(!empty($params2['kp_id'])){
            $query->andWhere(['kp_id' => $params2['kp_id']]);
        }

        return $dataProvider;
    }
}
