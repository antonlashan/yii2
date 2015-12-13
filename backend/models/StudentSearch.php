<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\UserDetail;

/**
 * StudentSearch represents the model behind the search form about `common\models\User`.
 */
class StudentSearch extends UserDetail {

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['academic_year', 'exam_center_id'], 'required'],
            [['initials', 'reg_no'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios() {
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
    public function search($params) {
        $query = UserDetail::find()
                ->joinWith('user', true, 'INNER JOIN')
                ->where(['is_admin' => \common\models\User::IS_ADMIN_NO]);

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $query->andFilterWhere([
            'academic_year' => $this->academic_year,
            'exam_center_id' => $this->exam_center_id,
        ]);

        $query->andFilterWhere(['like', 'initials', $this->initials])
                ->andFilterWhere(['like', 'reg_no', $this->reg_no]);

        return $dataProvider;
    }

}
