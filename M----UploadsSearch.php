<?php


namespace app\modules\customer_review\models;

use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * xxxxSearch represents the model behind the search form of `xxxxUploads`.
 */
class MReviewUploadSearch extends MReviewUpload
{
    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['id'], 'integer'],
            [['team_by'], 'integer'],
            [['object_id'], 'integer'],

            [['created_at', 'updated_at', 'markdel_at'], 'integer'],
            [['created_by', 'updated_by', 'markdel_by'], 'integer'],

            [['size'], 'integer'],

            [['filename_original', 'md5', 'ext', 'mimetype'], 'string'],

            [['type_screenshot'], 'integer', 'max' => 1],
            [['type_goods_photo'], 'integer', 'max' => 1],
            [['type_customer_photo'], 'integer', 'max' => 1],
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
     * @param array $params2[]
     *
     * @return ActiveDataProvider
     */
    public function search($params, $params2 = [])
    {
        $query = MReviewUpload::find();

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
            'object_id' => $this->object_id,
            'team_by' => $this->team_by,
            'created_at' => $this->created_at,
            'created_by' => $this->created_by,
            'updated_at' => $this->updated_at,
            'updated_by' => $this->updated_by,
            'markdel_by' => $this->markdel_by,
            'markdel_at' => $this->markdel_at,
            'size' => $this->size,
        ]);

        $query->andFilterWhere(['like', 'filename_original', $this->filename_original])
            ->andFilterWhere(['like', 'md5', $this->md5])
            ->andFilterWhere(['like', 'ext', $this->ext])
            ->andFilterWhere(['like', 'mimetype', $this->mimetype]);

        if(!empty($this->type_screenshot)){
            if($this->type_screenshot == "1"){

                $query->andWhere(['type_screenshot' => 1]);

            } elseif($this->type_screenshot == "0"){

                $query->andWhere(['or',
                    ['is', 'type_screenshot', null],
                    ['type_screenshot' => 0]
                ]);

            }
        }

        if(!empty($this->type_goods_photo)){
            if($this->type_goods_photo == "1"){

                $query->andWhere(['type_goods_photo' => 1]);

            } elseif($this->type_goods_photo == "0"){

                $query->andWhere(['or',
                    ['is', 'type_goods_photo', null],
                    ['type_goods_photo' => 0]
                ]);

            }
        }

        if(!empty($this->type_customer_photo)){
            if($this->type_customer_photo == "1"){

                $query->andWhere(['type_customer_photo' => 1]);

            } elseif($this->type_customer_photo == "0"){

                $query->andWhere(['or',
                    ['is', 'type_customer_photo', null],
                    ['type_customer_photo' => 0]
                ]);

            }
        }

        // пример использования параметра $params2
        // находим основной объект, к которому привязан файл
        if(!empty($params2['object_id'])){
            $query->andWhere(['object_id' => $params2['object_id']]);
        }

        return $dataProvider;
    }

}
