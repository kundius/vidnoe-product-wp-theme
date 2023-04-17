<?php
/*
Template Name: Лендинг
*/
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

      <?php if ($intro = get_field('intro')): ?>
      <section class="intro">
        <div class="intro-bg">
          <div class="intro-bg__image"></div>
          <!-- <video autoplay muted loop playsinline class="intro-bg__video">
            <source src="{{ Vite::asset('resources/images/intro.mp4') }}" type="video/mp4">
          </video> -->
        </div>
        <div class="ui-container intro__container">
          <div class="intro__logo">
            <img src="<?php echo $intro['logo']['url'] ?>" alt="">
          </div>
          <div class="intro__content">
            <h1 class="intro__title">
              <?php echo $intro['title'] ?>
            </h1>
            <div class="intro__text">
              <?php echo $intro['description'] ?>
            </div>
          </div>
          <div class="intro__button">
            <button class="ui-button-primary" data-scroll="#order">
              <?php echo $intro['button'] ?>
            </button>
          </div>
        </div>
      </section>
      <?php endif ?>

      <?php if ($assortment = get_field('assortment')): ?>
      <section class="assortment" id="assortment">
        <div class="ui-container">
          <h2 class="assortment__title">
            <?php echo $assortment['title'] ?>
          </h2>
          <div class="assortment__separator"></div>
          <div class="assortment__list">
            <?php foreach ($assortment['items'] as $item): ?>
            <div class="assortment__list-item">
              <div class="assortment-item">
                <div class="assortment-item__image">
                  <img src="<?php echo $item['image']['url'] ?>" alt="">
                </div>
                <div class="assortment-item__title">
                  <?php echo $item['name'] ?>
                </div>
              </div>
            </div>
            <?php endforeach ?>
          </div>
        </div>
        <div class="assortment-bg">
          <div class="assortment-bg__left"></div>
          <div class="assortment-bg__right"></div>
        </div>
      </section>
      <?php endif ?>

      <?php if ($about = get_field('about')): ?>
      <section class="about" id="about">
        <div class="ui-container">
          <div class="about-headline">
            <div class="about-headline__title">
              <?php echo $about['title'] ?>
            </div>
            <div class="about-headline__desc">
              <?php echo $about['description'] ?>
            </div>
          </div>
          <div class="about-clients">
            <?php if ($list = $about['list']): ?>
            <div class="about-clients__title">
              <div class="about-clients__title-inner">
                <div class="about-clients__title-text">
                  <img src="<?php echo $list['icon']['url'] ?>" alt="">
                  <?php echo $list['title'] ?>
                </div>
              </div>
            </div>
            <?php endif ?>
            <div class="about-clients__list">
              <?php if ($first = $about['first']): ?>
              <div class="about-clients__list-item">
                <div class="about-clients__list-arrow"></div>
                <div class="about-clients__list-icon">
                  <img src="<?php echo $first['image']['url'] ?>" alt="">
                </div>
                <div class="about-clients__list-text">
                  <?php echo $first['name'] ?>
                </div>
              </div>
              <?php endif ?>
              <?php if ($second = $about['second']): ?>
              <div class="about-clients__list-item">
                <div class="about-clients__list-arrow"></div>
                <div class="about-clients__list-icon">
                  <img src="<?php echo $second['image']['url'] ?>" alt="">
                </div>
                <div class="about-clients__list-text">
                  <?php echo $second['name'] ?>
                </div>
              </div>
              <?php endif ?>
              <?php if ($third = $about['third']): ?>
              <div class="about-clients__list-item">
                <div class="about-clients__list-arrow"></div>
                <div class="about-clients__list-icon">
                  <img src="<?php echo $third['image']['url'] ?>" alt="">
                </div>
                <div class="about-clients__list-text">
                  <?php echo $third['name'] ?>
                </div>
              </div>
              <?php endif ?>
            </div>
          </div>
        </div>
        <div class="about-bg">
          <div class="about-bg__left"></div>
          <div class="about-bg__right"></div>
        </div>
      </section>
      <?php endif ?>

      <?php if ($principles = get_field('principles')): ?>
      <section class="principles" id="principles">
        <div class="ui-container">
          <div class="principles__title">
            <?php echo $principles['title'] ?>
          </div>
          <div class="principles__wrapper">
            <div class="principles__list">
              <?php foreach ($principles['items'] as $item): ?>
              <div class="principles__list-item">
                <div class="principles-item">
                  <div class="principles-item__title">
                    <?php echo $item['title'] ?>
                  </div>
                  <div class="principles-item__desc">
                    <?php echo $item['description'] ?>
                  </div>
                </div>
              </div>
              <?php endforeach ?>
            </div>
          </div>
          <div class="principles__button">
            <button class="ui-button-primary" data-scroll="#order"><?php echo $principles['button'] ?></button>
          </div>
        </div>
        <div class="principles-bg">
          <div class="principles-bg__left"></div>
          <div class="principles-bg__right"></div>
        </div>
      </section>
      <?php endif ?>

      <?php if ($gallery = get_field('gallery')): ?>
      <section class="gallery" id="gallery">
        <div class="ui-container">
          <div class="gallery__title">
            <?php echo $gallery['title'] ?>
          </div>
          <div class="gallery__body">
            <div class="swiper mySwiper">
              <div class="swiper-wrapper">
                <?php foreach ($gallery['items'] as $item): ?>
                <div class="swiper-slide">
                  <img src="<?php echo $item['url'] ?>" />
                </div>
                <?php endforeach ?>
              </div>
              <div class="swiper-button-next"></div>
              <div class="swiper-button-prev"></div>
            </div>
          </div>
        </div>
        <div class="gallery-bg">
          <div class="gallery-bg__left"></div>
          <div class="gallery-bg__right"></div>
        </div>
      </section>
      <?php endif ?>

      <?php if ($order = get_field('order')): ?>
      <section class="order" id="order">
        <div class="ui-container">
          <div class="order__title">
            <?php echo $order['title'] ?>
          </div>
          <div class="order__layout">
            <div class="order__layout-desc">
              <div class="order__desc">
                <?php echo $order['description'] ?>
              </div>
            </div>
            <div class="order__layout-form">
              <div class="order-form">
                <?php echo do_shortcode($order['form']) ?>
              </div>
            </div>
          </div>
        </div>
        <div class="order-bg">
          <div class="order-bg__left"></div>
          <div class="order-bg__right"></div>
        </div>
      </section>
      <?php endif ?>
    
      <?php get_template_part('partials/footer') ?>
    </div>

    <?php wp_footer() ?>
  </body>
</html>
