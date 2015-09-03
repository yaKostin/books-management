<?php

namespace common\modules\books\controllers;

use Yii;
use common\modules\books\models\Book;
use common\modules\books\models\BookSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;

/**
 * DefaultController implements the CRUD actions for Book model.
 */
class DefaultController extends Controller
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Book models.
     * @return mixed
     */
    public function actionIndexORIGINAL()
    {
        $searchModel = new BookSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    public function actionIndex() 
    {
    	$dataProvider = new ActiveDataProvider([
            'query' => Book::find(),
            'pagination' => [
                'pageSize' => 15,
            ],
            'sort' => [
                'attributes' => [
                    'id',
                    'name',
                    'date',
                    'date_create'
                    ]
                ]
        ]);

        $gridColumns = [
		    [
		        'attribute' => 'id',
		        'vAlign'=>'middle',
		    ],
		    [
		        'attribute' => 'name',
		    ],
		    [
		        'attribute' => 'preview', 
		        'format' => 'raw',
		        'value' => function ($model, $key, $index, $widget) {
		        	return "<a href='$model->preview' class='highslide' onclick='return hs.expand(this)'>
							    <img src='$model->preview' style='width: 60px; height: 80px;' />
							</a>";
		        },
		    ],
		    [
		        
		        'label' => 'Автор',
		        'value' => function ($model, $key, $index, $widget) {
		            return $model->author->firstname . " " . $model->author->lastname;
		        },
		    ],
		    [
		        'attribute' => 'date',
		    ],
		    [
		    	'class' => 'kartik\grid\ActionColumn',
		    	'header' => 'Кнопки действий'
		    ]
		];

        return $this->render('index', [
        	'dataProvider' => $dataProvider,
        	'gridColumns' => $gridColumns,
        	]);
    }

    /**
     * Displays a single Book model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	if(Yii::app()->request->isAjaxRequest) {
        	$this->renderPartial('view', [
            	'model' => $this->findModel($id),
        	]);
    	}
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Book model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Book();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing Book model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Book model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Book model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Book the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Book::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
