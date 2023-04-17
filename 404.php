<!DOCTYPE html>
<html class="no-js" <?php language_attributes()?> itemscope itemtype="http://schema.org/WebSite">
  <head>
    <?php get_template_part('partials/head');?>
  </head>
  <body <?php body_class();?>>
    <?php wp_body_open();?>

    <div class="ui-wrapper">
      <?php get_template_part('partials/header') ?>

      <div class="page-not-found">
        <div class="not-found">
          <div class="not-found__code">404</div>
          <div class="not-found__body">
            <div class="not-found__title">
              Страница не найдена
            </div>
            <div class="not-found__desc">
              Возможно, она была перемещена или удалена.<br />
              <br />
              Вернитесь назад или сообщите нам об ошибке
            </div>
            <div class="not-found__back">
              <a href="#" class="ui-button-submit ui-button-submit_with-arrow">
                Вернуться назад
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <?php wp_footer() ?>
  </body>
</html>
