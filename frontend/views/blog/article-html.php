<?php
use yii\helpers\Url;
?>
<article class="blog-article" style="">
    <div class="image" style="background-image: url('<?= Url::to('/upload/article-image/1920x1080_910.jpg', true) ?>')"></div>
    <div class="article-body">
            <span class="article-info">
                <span><i class="fas fa-user"></i> <a href="<?= Url::to(['/profile/1']) ?>">Username</a></span>
                <span><i class="fas fa-server"></i>
                    <?php if($article->category->title){ ?>
                        <a href="<?= Url::to(['/blog/category/'.$article->category->alias]) ?>"><?= $article->category->title ?></a>
                    <?php }else{ ?>
                        <a href="<?= Url::to(['/blog/category/uncategorized']) ?>">Uncategorized</a>
                    <?php } ?>
                </span>
                <span><i class="far fa-calendar-alt"></i> <?= date('d-m-Y | H:i', 1562618814) ?></span>

                    <span>
                        <i class="fas fa-tags"></i>
                            <a href="<?= Url::to(['/blog/tag/html']) ?>">HTML</a>
                            <a href="<?= Url::to(['/blog/tag/php']) ?>">PHP</a>
                    </span>

                <span class="badge badge-secondary"><i class="far fa-comment-dots"></i> 3</span>
                <span class="badge badge-secondary"><i class="fas fa-eye"></i> 78</span>
                <span class="badge badge-secondary"><i class="fas fa-eye"></i> 324</span>
            </span>

        <div class="rating">
            <div class="rating-box">
                <div class="background-box"> </div>
                <div id="slider-box" class="slider-box" style="width: 93%"> </div>
                <div id="slider-select-box" class="slider-select-box"> </div>
                <div class="image-box">
                    <?php for($i = 1; $i <= 10; $i++){ ?><div id="star-<?= $i ?>" class="image" style="background-image: url('<?= '/upload/design/star.png' ?>')"></div><?php } ?>
                </div>
            </div>
        </div>

        <h2 class="article-title">Nisl pretium fusce id velit</h2>
        <p class="article-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Sit amet nisl suscipit adipiscing bibendum. Elit sed vulputate mi sit. Pretium viverra suspendisse potenti nullam. Volutpat lacus laoreet non curabitur gravida. Nulla facilisi morbi tempus iaculis. Amet aliquam id diam maecenas. Amet cursus sit amet dictum sit amet justo donec enim. Erat velit scelerisque in dictum non consectetur a erat. Diam donec adipiscing tristique risus nec feugiat in fermentum. Turpis egestas maecenas pharetra convallis posuere morbi leo urna molestie. Faucibus turpis in eu mi bibendum neque. Commodo odio aenean sed adipiscing. Pulvinar etiam non<em><strong> </strong></em>quam lacus. <em><strong>Sagittis eu volutpat odio facilisis mauris sit amet massa. Integer feugiat scelerisque varius morbi enim.</strong></em> Parturient montes nascetur ridiculus mus mauris vitae ultricies leo integer. Nunc scelerisque viverra mauris in. Enim diam vulputate ut pharetra. Est velit egestas dui id.</p>
    </div>
    <a href="<?= Url::to(['/blog/article/'.$article->alias]) ?>" class="btn btn-lg btn-block">Show more</a>
</article>