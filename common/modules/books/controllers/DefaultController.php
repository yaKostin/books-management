<?php

namespace common\modules\books\controllers;

use Yii;
use common\modules\books\models\Author;
use common\modules\books\models\AuthorSearch;
use common\modules\books\models\Book;
use common\modules\books\models\BookSearch;
use yii\web\Controller;
use yii\filters\AccessControl;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\jui\DatePicker;

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
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'view', 'delete', 'update'],
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function afterAction($action, $result)
    {
    	Yii::$app->getUser()->setReturnUrl(Yii::$app->request->url);
        return parent::afterAction($action, $result);
    } 

    public function actionIndex() 
    {
    	$searchModel = new BookSearch();
    	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
    	$authorsArray = Author::getAuthorsArray();
    	
        $gridColumns = [
		    [
		        'attribute' => 'id',
		    ],
		    [
		        'attribute' => 'name',
		    ],
		    [
		        'attribute' => 'preview', 
		        'format' => 'raw',
		        'enableSorting' => false,
		        'value' => function ($model, $key, $index, $widget) {
		        	return "<a href='$model->preview' class='highslide' onclick='return hs.expand(this)'>
							    <img src='$model->preview' style='width: 60px; height: 80px;' />
							</a>";
		        },
		    ],
		    [
		    	'attribute' => 'author.firstname',
		        'label' => 'Автор',
		        'value' => function ($model, $key, $index, $widget) {
		            return $model->author->firstname . " " . $model->author->lastname;
		        },
		    ],
		    [
		        'attribute' => 'date',
		        'format' => 'date',
		    ],
		    [
	            'attribute' => 'date_create',
	            'format' => 'raw',
                'value' => function ($model, $key, $index, $widget) {
                    return \yii\timeago\TimeAgo::widget(['timestamp' => $model->date_create, 'language' => 'ru']);
                }
	        ],
		    [
		    	'class' => 'yii\grid\ActionColumn',
		    	'header' => 'Кнопки действий',
				'template' => '{update} {view} {delete}',
				'buttons' => [
					'update' => function ($url, $model, $key) {
						return Html::button('<span class="glyphicon glyphicon-pencil"></span>', 
			        				[
				        				'data-url' => Url::toRoute(['/books/default/update', 'id' => $model->id]), 
										'title' => 'Изменить',
										'class' => 'btn btn-update-book'
									]);
					},
				    'view' => function ($url, $model, $key) {
				        return Html::button('<span class="glyphicon glyphicon-eye-open"></span>', 
			        				[
				        				'data-url' => Url::toRoute(['/books/default/view', 'id' => $model->id]), 
										'title' => 'Просмотреть',
										'class' => 'btn btn-show-modal'
									]);
				    },
				    'delete' => function ($url, $model, $key) {
				        return Html::button('<span class="glyphicon glyphicon-remove"></span>', 
				        			[
				        				'data-url' => Url::toRoute(['/books/default/delete', 'id' => $model->id]),
										'title' => 'Удалить',
										'class' => 'btn btn-delete-book'
				        			]);
				    },
				],
		    ]
		];

        return $this->render('index', [
        	'dataProvider' => $dataProvider,
        	'searchModel' => $searchModel,
        	'gridColumns' => $gridColumns,
        	'authorsArray' => $authorsArray
        	]);
    }

    /**
     * Displays a single Book model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	if(Yii::$app->request->getIsAjax()) {
        	return $this->renderPartial('view', [
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
        	if (Yii::$app->request->getIsAjax()) {
        		return $this->renderPartial('create', [
        			'model' => $model,
        		]);
        	}
        	else {
	            return $this->render('create', [
	                'model' => $model,
	            ]);
        	}
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

        if ($model->load(Yii::$app->request->post()) && $model->update()) {
            $this->redirect(Url::previous('before_update_book'));
        } else {
        	Url::remember(Yii::$app->request->referrer, 'before_update_book');
        	$authorsArray = Author::getAuthorsArray();
            return $this->render('update', [
                'model' => $model,
                'authorsArray' => $authorsArray
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
        if (Yii::$app->request->getIsAjax()) {
        	return $this->findModel($id)->delete();
        }
        else {
        	return $this->redirect(['/books']);
        }
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
