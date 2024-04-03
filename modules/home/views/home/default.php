<?php
$tmpl->addStylesheet('slick', 'libraries/slick-js');
$tmpl->addStylesheet('slick.theme', 'libraries/slick-js');
$tmpl->addStylesheet('owl.carousel.min', 'libraries/OwlCarousel2-2.3.4/dist/assets');
$tmpl->addStylesheet('owl.theme.default.min', 'libraries/OwlCarousel2-2.3.4/dist/assets');
$tmpl->addStylesheet('default', 'modules/home/assets/css');
$tmpl->addScript('owl.carousel.min', 'libraries/OwlCarousel2-2.3.4/dist');
$tmpl->addScript('default', 'modules/home/assets/js');
$tmpl->addScript('slick.min', 'libraries/slick-js');
?>
<div class="page-home">
    <div class="d-flex gap-3 section-top mb-3">
        <div class="section-top-center">
            <?php echo $tmpl->load_direct_blocks('banners', ['category_id' => '1', 'style' => 'slide']); ?>
        </div>
    </div>
    <div class="container">

       

    </div>
</div>