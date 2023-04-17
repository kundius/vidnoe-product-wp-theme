<?php
/*
Template Name: Продукт
*/
$product_option = get_field('product', 'option');
?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes();?> itemscope itemtype="http://schema.org/WebSite">
  <head>
    <?php get_template_part('partials/head');?>
  </head>
  <body <?php body_class() ?>>
    <?php wp_body_open() ?>

    <div class="page">
      <?php get_template_part('partials/header') ?>

      <section class="product-section">
        <div class="ui-container">
          <div class="product-layout">
            <?php if ($gallery = get_field('gallery')): ?>
            <div class="product-layout__gallery">
              <div class="swiper productSwiper">
                <div class="swiper-wrapper">
                  <?php foreach ($gallery as $item): ?>
                  <div class="swiper-slide">
                    <img src="<?php echo $item['url'] ?>" />
                  </div>
                  <?php endforeach ?>
                </div>
                <div class="swiper-button-next"></div>
                <div class="swiper-button-prev"></div>
              </div>
            </div>
            <?php endif ?>

            <div class="product-layout__details">
              <div class="product-details">
                <h1 class="product-details__title">
                  <?php the_title() ?>
                </h1>

                <?php if ($labels = get_field('labels')): ?>
                <div class="product-details__labels">
                  <?php echo implode(', ', array_map(function ($item) { return $item['value']; }, $labels)) ?>
                </div>
                <?php endif ?>

                <?php if ($params = get_field('params')): ?>
                <div class="product-details__params">
                  <?php foreach ($params as $param): ?>
                  <div class="product-details__param">
                    <div class="product-details__param-name">
                      <?php echo $param['name'] ?>
                    </div>
                    <div class="product-details__param-value">
                      <?php echo $param['value'] ?>
                    </div>
                  </div>
                  <?php endforeach ?>
                </div>
                <?php endif ?>

                <div class="product-details__spacer"></div>

                <div class="product-details__buttons">
                  <button class="product-details__button" data-hystmodal="#order">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                    <span>
                      <?php echo $product_option['order_button'] ?>
                    </span>
                  </button>
                  <?php if ($product_option['price_file']): ?>
                  <a href="<?php echo $product_option['price_file'] ?>" class="product-details__button" target="_blank">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                      <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 002.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 00-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 00.75-.75 2.25 2.25 0 00-.1-.664m-5.8 0A2.251 2.251 0 0113.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25zM6.75 12h.008v.008H6.75V12zm0 3h.008v.008H6.75V15zm0 3h.008v.008H6.75V18z" />
                    </svg>
                    <span><?php echo $product_option['price_button'] ?></span>
                  </a>
                  <?php endif ?>
                </div>
              </div>
            </div>
          </div>

          <?php if ($product_option['benefits']): ?>
          <div class="product-benefits">
            <div class="product-benefits-grid">
              <?php foreach ($product_option['benefits'] as $item): ?>
                <div class="product-benefits-grid__cell">
                  <div class="product-benefits-item">
                    <div class="product-benefits-item__icon">
                        <?php echo $item['icon'] ?>
                    </div>
                    <div class="product-benefits-item__name">
                      <?php echo $item['name'] ?>
                    </div>
                  </div>
                </div>
              <?php endforeach ?>
            </div>
          </div>
          <?php endif ?>

          <div class="product-content">
            <div class="product-content__body">
              <?php the_content() ?>
              <?php echo $product_option['content'] ?>
            </div>
          </div>
        </div>
      </section>
    
      <?php get_template_part('partials/footer') ?>
    </div>

    <?php wp_footer() ?>
  </body>
</html>
