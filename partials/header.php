<header class="header">
  <div class="ui-container">
    <div class="header__layout">
      <?php if ($header_logo = get_field('header_logo', 'option')): ?>
      <div class="header__layout-logo">
        <a href="/" class="header-logo"><img class="header-logo__image" src="<?php echo $header_logo['url'] ?>" alt=""></a>
      </div>
      <?php endif ?>
      <?php if ($header_slogan = get_field('header_slogan', 'option')): ?>
      <div class="header__layout-slogan">
        <div class="header-slogan">
          <?php echo $header_slogan ?>
        </div>
      </div>
      <?php endif ?>
      <div class="header__layout-gap-1"></div>
      <div class="header__layout-lang">
        <div class="header-lang">
          <div class="header-lang__button">
            <?php echo pll_current_language('name') ?>
          </div>
          <ul class="header-lang__list">
            <?php pll_the_languages() ?>
          </ul>
        </div>
      </div>
      <div class="header__layout-gap-2"></div>
      <div class="header__layout-menu">
        <?php wp_nav_menu([
          'container' => false,
          'theme_location' => 'menu-main',
          'menu_class' => 'header-menu'
        ]) ?>
        <!-- <ul class="header-menu">
          <li>
            <a href="#assortment" data-scroll="#assortment">{!! $translations['menu_assortment'] !!}</a>
          </li>
          <li>
            <a href="#about" data-scroll="#about">{!! $translations['menu_about'] !!}</a>
          </li>
          <li>
            <a href="#principles" data-scroll="#principles">{!! $translations['menu_principles'] !!}</a>
          </li>
          <li>
            <a href="#gallery" data-scroll="#gallery">{!! $translations['menu_gallery'] !!}</a>
          </li>
          <li>
            <a href="#order" data-scroll="#order">{!! $translations['menu_order'] !!}</a>
          </li>
          <li>
            <a href="#contacts" data-scroll="#contacts">{!! $translations['menu_contacts'] !!}</a>
          </li>
        </ul> -->
        <button class="header-toggle">
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
      <div class="header__layout-gap-3"></div>
      <?php if ($header_phone = get_field('header_phone', 'option')): ?>
      <div class="header__layout-contacts">
        <div class="header-contacts">
          <div class="header-contacts__title"><?php echo $header_phone['name'] ?></div>
          <a href="tel:<?php echo preg_replace('/[^0-9]/', '', $header_phone['number']) ?>" class="header-contacts__phone">
            <?php echo $header_phone['number'] ?>
          </a>
        </div>
      </div>
      <?php endif ?>
    </div>
  </div>
</header>
