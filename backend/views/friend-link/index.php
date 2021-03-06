<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2016/3/21
 * Time: 14:14
 */
use feehi\grid\GridView;
use feehi\widgets\Bar;
use yii\helpers\Html;
use backend\models\FriendLink;
use yii\helpers\Url;
use feehi\libs\Constants;

$this->title = "Friendly Links";
?>
<div class="row">
    <div class="col-sm-12">
        <div class="ibox">
            <?= $this->render('/widgets/_ibox-title') ?>
            <div class="ibox-content">
                <?= Bar::widget()?>
                <?= GridView::widget([
                    'dataProvider' => $dataProvider,
                    'columns' => [
                        [
                            'class' => 'feehi\grid\CheckboxColumn',
                        ],
                        [
                            'attribute' => 'name'
                        ],
                        [
                            'attribute' => 'url',
                            'format' => 'raw',
                            'value' => function($model){
                                return Html::a($model->url, $model->url, ['target'=>'_blank']);
                            }
                        ],
                        [
                            'attribute' => 'sort',
                            'format' => 'raw',
                            'value' => function($model){
                                return Html::input('number', "sort[{$model['id']}]", $model['sort']);
                            }
                        ],
                        [
                            'attribute' => 'status',
                            'format' => 'raw',
                            'value' => function($model, $key, $index, $column) {
                                if($model->status == FriendLink::DISPLAY_YES){
                                    $url = Url::to(['change-status', 'id'=>$model->id, 'status'=>0, 'field'=>'status']);
                                    $class = 'btn btn-info btn-xs btn-rounded';
                                    $confirm =  Yii::t('app', 'Are you sure you want to disable this item?');
                                }else{
                                    $url = Url::to(['change-status', 'id'=>$model->id, 'status'=>1, 'field'=>'status']);
                                    $class = 'btn btn-default btn-xs btn-rounded';
                                    $confirm =  Yii::t('app', 'Are you sure you want to enable this item?');
                                }
                                return Html::a(Constants::getYesNoItems($model->status), $url, [
                                    'class'=>$class,
                                    'data-confirm' => $confirm,
                                    'data-method' => 'post',
                                    'data-pjax' => '0',
                                ]);

                            },
                        ],
                        [
                            'attribute' => 'created_at',
                            'format' => 'date',
                        ],
                        [
                            'attribute' => 'updated_at',
                            'format' => 'date',
                        ],
                        [
                            'class' => 'feehi\grid\ActionColumn',
                        ]
                    ]
                ])
                ?>
            </div>
        </div>
    </div>
</div>