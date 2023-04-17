<!DOCTYPE html>
<html class="no-js" <?php language_attributes()?> itemscope itemtype="http://schema.org/WebSite">
  <head>
    <?php get_template_part('partials/head')?>
  </head>
  <body <?php body_class()?>>
    <?php wp_body_open()?>

    <div class="ui-wrapper">
      <?php get_template_part('partials/header') ?>

      <div class="single-details">
        <div class="ui-container">
          <h1 class="single-details__title"><?php the_title() ?></h1>

          <div class="single-details__date">
            <?php echo get_the_date('d.m.Y') ?>
          </div>

          <div class="single-details__content ui-content">
            <?php the_content() ?>
          </div>

          <?php if ($related = get_field('post_related')): ?>
          <div class="related">
            <div class="related__title">Вам может быть интересно:</div>
            <div class="related__grid">
              <?php foreach ($related as $item): ?>
              <div class="related__grid-cell">
                <article class="related-card">
                  <div class="related-card__date">
                    <?php echo get_the_date('d.m.Y', $item->ID) ?>
                  </div>

                  <h2 class="related-card__title">
                    <?php echo get_the_title($item->ID) ?>
                  </h2>

                  <figure class="related-card__image">
                    <img src="<?php echo get_the_post_thumbnail_url($item->ID, 'theme-medium') ?>" alt="<?php echo get_the_title($item->ID) ?>" />
                  </figure>

                  <div class="related-card__excerpt">
                    <?php echo get_the_excerpt($item->ID) ?>
                  </div>

                  <div class="related-card__more">
                    <a href="<?php the_permalink($item->ID) ?>" class="ui-button-more ui-button-more_with-arrow ui-button-more_upper">Читать дальше</a>
                  </div>
                </article>
              </div>
              <?php endforeach ?>
            </div>
          </div>
          <?php endif?>
        </div>
      </div>

      <?php get_template_part('partials/footer')?>
    </div>
  </body>
</html>
