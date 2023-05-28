<?php
$category = get_queried_object();
$query_params = [
  'post_type' => 'post',
  'posts_per_page' => 12,
  'order' => 'DESC',
  'orderby' => 'date',
  'paged' => get_query_var('paged') ?: 1,
  'tax_query' => [
    'relation' => 'OR',
    [
      'taxonomy' => $category->taxonomy,
      'field' => 'id',
      'terms' => [$category->term_id]
    ]
  ]
];
$query = new WP_Query($query_params);
?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes()?> itemscope itemtype="http://schema.org/WebSite">
  <head>
    <?php get_template_part('partials/head');?>
  </head>
  <body <?php body_class() ?>>
    <?php wp_body_open() ?>

    <div class="page">
      <?php get_template_part('partials/header') ?>

      <section class="catalog-section">
        <div class="ui-container">
          <div class="sections">
            <div class="sections-item">
              <div class="sections-item__title"><?php single_cat_title() ?></div>
              <?php if ($query->have_posts()): ?>
              <div class="sections-item__list">
                <div class="products-grid">
                  <?php while ($query->have_posts()): ?>
                  <?php $item = $query->the_post() ?>
                  <div class="products-grid__cell">
                    <div class="product-item">
                      <figure class="product-item__image">
                        <img src="<?php the_post_thumbnail_url('theme-medium')?>" alt="<?php the_title() ?>" />
                      </figure>
                      <div class="product-item__body">
                        <div class="product-item__title"><?php the_title() ?></div>
                        <div class="product-item__labels">
                          <?php echo \DomenART\Theme\Services\Theme::excerpt(['maxchar' => 400, 'text' => $item->post_excerpt ?: $item->post_content]) ?>
                        </div>
                        <div class="product-item__more">
                          <a href="<?php the_permalink() ?>" class="product-item__more-link">Подробнее</a>
                        </div>
                      </div>
                    </div>
                  </div>
                  <?php endwhile ?>
                  <?php wp_reset_postdata() ?>
                </div>
              </div>
              <?php endif ?>
            </div>
          </div>
          <?php wp_pagenavi(['query' => $query]) ?>
        </div>
      </section>

      <?php get_template_part('partials/footer')?>
    </div>
  </body>
</html>
