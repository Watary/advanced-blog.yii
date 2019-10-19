<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\DetailView;
$url = Url::toRoute('/comments/find-comments', true);
?>
<div class="comments" id="comments-list"></div>

<script>
    function findComments(){
        id_comments = null;
        console.log('<?= $url ?>');
        $.ajax({
            url: '<?= $url ?>',
            type: 'post',
            data: {
                article: <?= $id_article ?>,
                id_comments: id_comments,
                _csrf: '<?=Yii::$app->request->getCsrfToken()?>'
            },
            success: function (data) {
                console.log('1');
                if(data.list_comments){
                    document.getElementById("comments-list").innerHTML = data.list_comments;
                }else{
                    console.log('2');
                    document.getElementById("comments-list").innerHTML = '<div class="alert alert-success" role="alert">Ця стаття не має коментарів</div>';
                }
            }
        });
    }

    setTimeout(findComments, 1000);
</script>


