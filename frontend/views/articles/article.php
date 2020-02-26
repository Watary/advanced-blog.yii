<?php
use yii\helpers\Url;
?>
<div class="row">
    <div class="col-sm-8 col-md-9">
        <div class="blog">
            <article class="blog-article" style="">
                <?php if($article->image){ ?>
                    <div class="image" style="background-image: url('<?= $article->image ?>')"></div>
                <?php } ?>
                <div class="article-body">
                    <span class="article-info">
                        <span><i class="fas fa-user"></i> <a href="<?= Url::to(['/profile/'.$article->author->id]) ?>"><?= $article->author->username ?></a></span>
                        <span><i class="fas fa-server"></i>
                            <?php if($article->category->title){ ?>
                                <a href="<?= Url::to(['/blog/category/'.$article->category->alias]) ?>"><?= $article->category->title ?></a>
                            <?php }else{ ?>
                                <a href="<?= Url::to(['/blog/category/uncategorized']) ?>">Uncategorized</a>
                            <?php } ?>
                        </span>
                        <span><i class="far fa-calendar-alt"></i> <?= date('d-m-Y | H:i', $article->created_at) ?></span>
                        <?php if($article->articletag){ ?>
                            <span>
                                <i class="fas fa-tags"></i>
                                <?php foreach ($article->articletag as $item) { ?>
                                    <a href="<?= Url::to(['/blog/tag/'.$item->tag->alias]) ?>"><?= $item->tag->title ?></a>
                                <?php } ?>
                            </span>
                        <?php } ?>
                        <span class="badge badge-secondary"><i class="far fa-comment-dots"></i> <?= $article->count_comments ?></span>
                        <span class="badge badge-secondary"><i class="fas fa-eye"></i> <?= $article->count_show ?></span>
                        <span class="badge badge-secondary"><i class="fas fa-eye"></i> <?= $article->count_show_all ?></span>
                    </span>

                    <div class="rating">
                        <div class="rating-box">
                            <div class="background-box"> </div>
                            <div id="slider-box" class="slider-box" style="width: <?= $article->mark*10 ?>%"> </div>
                            <div id="slider-select-box" class="slider-select-box"> </div>
                            <div class="image-box">
                                <?php for($i = 1; $i <= 10; $i++){ ?><div id="star-<?= $i ?>" <?php if(!$isMark && !Yii::$app->user->isGuest){ ?>onclick="setMark(<?= $i ?>)" onmouseout="document.getElementById('slider-select-box').style.width = '0%'" onmousemove="document.getElementById('slider-select-box').style.width = '<?= $i*10 ?>%'"<?php } ?> class="image" style="background-image: url('<?= '/design/star.png' ?>')"></div><?php } ?>
                            </div>
                        </div>
                    </div>

                    <h2 class="article-title"><?= $article->title ?></h2>
                    <p class="article-text"><?= $article->text ?></p>
                </div>
            </article>
        </div>
    </div>

    <div class="col-sm-4 col-md-3">
        sidebar
    </div>
</div>

<?php if(!$isMark && !Yii::$app->user->isGuest){ ?>
    <script>
        var id_article = <?= $article->id ?>;
        var cop = document.getElementById("comments-answer-form");

        function showFormComment(comment){
            document.getElementById("article-comments-answer").id_comment.value=comment;
            document.getElementById("comments-answer-text").value  = '';
            document.getElementById("answer-"+comment).appendChild(cop);
        }

        function setMark(mark) {
            $.ajax({
                url: '<?= Url::toRoute('/articles/set-mark', true) ?>',
                type: 'POST',
                data: {
                    mark: mark,
                    article: <?= $article->id ?>,
                },
                success: function (data) {
                    console.log(data);
                    document.getElementById('slider-box').style.width = (data*10)+'%';
                }
            });
        }
    </script>
<?php } ?>