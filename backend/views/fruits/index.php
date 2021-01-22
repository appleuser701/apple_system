<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel common\models\FruitsSearch */
/* @var $dataProvider yii\data\ArrayDataProvider */

$this->title = 'Фрукты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="fruits-index">

    <h1><?//= Html::encode($this->title) ?></h1>

    <p>
        <?=Html::a('Сгенерировать фрукты',['gen'], ['class' => 'btn btn-success'])?>
    </p>


    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        //'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute'=>'type_id',
                'label'=>$searchModel->getAttributeLabel('type_id'),
                'value'=>'type.name',
            ],

            [
                'attribute'=>'status_id',
                'label'=>$searchModel->getAttributeLabel('status_id'),
                'value'=>'status.name',
            ],

            [
                'attribute'=>'stateSort',
                'label'=>$searchModel->getAttributeLabel('stateSort'),
                'value'=>function($model) {
                    return $model->state;
                }
            ],

            [
                'attribute'=>'size',
                'label'=>$searchModel->getAttributeLabel('size'),
                'value'=>function($model) {
                    return $model->size . '%';
                }
            ],

            [
                'attribute'=>'color_id',
                'label'=>$searchModel->getAttributeLabel('color_id'),
                'contentOptions'=>function($model) {
                    $color='#' . $model->color->hex_code;
                    return ['style'=>"background:$color"];
                },
                'value'=>'color.name'
            ],

            [
                'attribute'=>'appearance_time',
                'label'=>$searchModel->getAttributeLabel('appearance_time'),
                'value'=>function($model) {
                    $ts=$model->appearance_time;
                    return date('Y-m-d H:i:s', $ts);
                }
            ],

            [
                'attribute'=>'fall_time',
                'label'=>$searchModel->getAttributeLabel('fall_time'),
                'value'=>function($model) {
                    $ts=$model->fall_time;

                    if($ts) {
                        return date('Y-m-d H:i:s', $ts);
                    } else {
                        return null;
                    }
                }
            ],

            [
                'label' => 'опции',
                'contentOptions' => ['style' => 'min-width:205px;  '],
                'format' => 'raw',
                'value' => function($model, $key, $index, $column) {

                    $action_fall="/fruits/fall?id=$model->id";

                    $tpl='';
                    $tpl.="<div class='pull-left' style='margin: 1px 5px 0 0;'>";
                    $tpl.="<a class='btn btn-danger btn-sm' href='$action_fall'>";
                    $tpl.="Упасть";
                    $tpl.="</a>";
                    $tpl.="</button>";
                    $tpl.="</div>";

                    $options='';
                    $options.="<option selected disabled value=''>Выберите %</option>";

                    for($i=1; $i<=$model->size; $i++)
                    {
                        $options.="<option value='$i'>";
                        $options.="$i%";
                        $options.="</option>\n";
                    }

                    $action_eat = "/fruits/eat";
                    $tpl.="<div class='clearfix'>";
                    $tpl.="<form class='eat-form form-inline' action='$action_eat' method='get'>
                                <div class='form-group form-group-sm'>
                                    <select name='num' class='eat-percent form-control'>
                                        $options
                                    </select>
                                </div>
                                <input type='hidden' name='id' value='$model->id'>
                                <button type='submit' class='eat-btn btn btn-success btn-sm'>
                                    Съесть
                                </button>
                            </form>";
                    $tpl.="</div>";

                    return $tpl;
                }
            ]
        ],
    ]); ?>

    <?php

    $this->registerJs("

            $(function() {
             
                $('.eat-form').submit(function (e) {
                    
                    var list=$(this).find('.eat-percent');
                    if($(list).length) {
                        var opt=$(list).find('option:selected').val();
                        
                        if(!$(list).find('option:selected').val()) {
                            $(list).css({'border':'1px solid red'})
                            return false;
                        }
                    }
                    
                    return true;
                });
                
                $('.eat-form').change(function(e){
                    $('.eat-percent').css({'border':''});
                });
            });
    ");

    ?>


</div>
