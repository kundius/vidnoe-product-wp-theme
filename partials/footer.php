<?php if ($contacts = get_field('contacts', 'option')): ?>
<section class="contacts" id="contacts">
  <div class="ui-container">
    <div class="contacts__title">
      <?php echo $contacts['title'] ?>
    </div>
    <div class="contacts__layout">
      <div class="contacts__layout-content">
        <div class="contacts-group">
          <div class="contacts-group__title">
            <?php echo $contacts['subtitle'] ?>
          </div>
          <a href="tel:<?php echo preg_replace('/[^0-9]/', '', $contacts['phone']) ?>" class="contacts-group__phone">
            <span><?php echo $contacts['phone'] ?></span>
          </a>
          <a href="https://wa.me/<?php echo preg_replace('/[^0-9]/', '', $contacts['whatsapp']) ?>" class="contacts-group__whatsapp" target="_blank">
            <span><?php echo $contacts['whatsapp'] ?></span>
          </a>
          <a href="tel:<?php echo preg_replace('/[^0-9]/', '', $contacts['phone']) ?>" class="contacts-group__phone-text">
            <span><?php echo $contacts['phone'] ?></span>
          </a>
          <a href="email:<?php echo $contacts['email'] ?>" class="contacts-group__email">
            <span><?php echo $contacts['email'] ?></span>
          </a>
        </div>
      </div>
      <img class="contacts__layout-figure" src="<?php echo $contacts['image']['url'] ?>" />
    </div>
  </div>
  <div class="contacts-bg">
    <div class="contacts-bg__left"></div>
    <div class="contacts-bg__right"></div>
  </div>
</section>
<?php endif ?>

<footer class="footer">
  <div class="footer-primary">
    <div class="ui-container">
      <div class="footer-primary__layout">
        <?php if ($footer_logo = get_field('footer_logo', 'option')): ?>
        <div class="footer-primary__layout-logo">
          <img class="footer-logo" src="<?php echo $footer_logo['url'] ?>" alt="">
        </div>
        <?php endif ?>
        <div class="footer-primary__layout-sep-1"></div>
        <div class="footer-primary__layout-about">
          <?php if ($footer_about = get_field('footer_about', 'option')): ?>
          <div class="footer-about">
            <div class="footer-about__primary">
              <?php echo $footer_about['primary'] ?>
            </div>
            <div class="footer-about__secondary">
              <?php echo $footer_about['secondary'] ?>
            </div>
          </div>
          <?php endif ?>
        </div>
        <div class="footer-primary__layout-sep-2"></div>
        <?php if ($footer_juridical = get_field('footer_juridical', 'option')): ?>
        <div class="footer-primary__layout-jur">
          <div class="footer-jur">
            <?php echo $footer_juridical ?>
          </div>
        </div>
        <?php endif ?>
        <div class="footer-primary__layout-sep-3"></div>
        <div class="footer-primary__layout-menu">
          <?php wp_nav_menu([
            'container' => false,
            'theme_location' => 'menu-main',
            'menu_class' => 'footer-menu'
          ]) ?>
        </div>
      </div>
    </div>
  </div>
  <div class="footer-secondary">
    <div class="ui-container">
      <div class="footer-secondary__layout">
        <?php if ($footer_copyright = get_field('footer_copyright', 'option')): ?>
        <div class="footer-secondary__layout-copyright">
          <?php echo $footer_copyright ?>
        </div>
        <?php endif ?>
        <div class="footer-secondary__layout-sitemap">
          <!-- <a href="#">Карта сайта</a> -->
        </div>
        <?php if ($policy_title = get_field('policy_title', 'option')): ?>
        <div class="footer-secondary__layout-rules">
          <a href="#rulesModal" data-hystmodal="#rulesModal"><?php echo $policy_title ?></a>
        </div>
        <?php endif ?>
      </div>
    </div>
  </div>
</footer>

<div class="hystmodal" id="rulesModal" aria-hidden="true">
  <div class="hystmodal__wrap">
    <div class="hystmodal__window hystmodal__window--long" role="dialog" aria-modal="true">
      <button data-hystclose class="hystmodal__close">Close</button>
      <?php if ($policy_title = get_field('policy_title', 'option')): ?>
      <div class="hystmodal__title"><?php echo $policy_title ?></div>
      <?php endif ?>
      <?php if ($policy_content = get_field('policy_content', 'option')): ?>
      <?php echo $policy_content ?>
      <?php endif ?>
    </div>
  </div>
</div>

<div class="hystmodal hystmodal--small" id="order" aria-hidden="true">
  <div class="hystmodal__wrap">
    <div class="hystmodal__window" role="dialog" aria-modal="true">
      <button data-hystclose class="hystmodal__close">Close</button>
      <div class="modal-form">
        <?php echo do_shortcode(get_field('product', 'option')['order_form']) ?>
      </div>
    </div>
  </div>
</div>
