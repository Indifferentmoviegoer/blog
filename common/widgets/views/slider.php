<?php

use common\models\Gallery;

/* @var $slider Gallery */

?>

<div class="container">
    <div class="col-lg-6">
        <div id="myCarousel" class="carousel slide gallery-carousel" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                <li data-target="#myCarousel" data-slide-to="1"></li>
                <li data-target="#myCarousel" data-slide-to="2"></li>
            </ol>

            <div class="carousel-inner">
                <?php for ($i = 0; $i < count($slider); $i++): ?>
                    <?php if ($i == 0): ?>
                        <div class="item active">
                            <img src="/img/uploads/gallery/<?= $slider[$i]->name ?>" alt="">
                        </div>
                    <?php else: ?>
                        <div class="item">
                            <img src="/img/uploads/gallery/<?= $slider[$i]->name ?>" alt="">
                        </div>
                    <?php endif; ?>
                <?php endfor; ?>
            </div>

            <a class="left carousel-control" href="#myCarousel" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="right carousel-control" href="#myCarousel" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
</div>
