<?php
/*
Template Name: Каталог
*/

function get_products($id) {
  return new WP_Query([
    'post_parent' => $id,
    'post_type' => 'page',
    'order' => 'ASC',
    'orderby' => 'menu_order',
    'meta_key' => '_wp_page_template',
    'meta_value' => 'template-product.php'
  ]);
}

function get_root($id) {
  $parent = wp_get_post_parent_id($id);
  if ($parent == 0) {
     return $id;
  } else {
     return get_root($parent);
  }
}

$current_id = get_the_ID();
$current_parent_id = wp_get_post_parent_id($current_id);
$root_id = get_root($current_id);
$root_cats = new WP_Query([
  'post_parent' => $root_id,
  'post_type' => 'page',
  'order' => 'ASC',
  'orderby' => 'menu_order',
  'meta_key' => '_wp_page_template',
  'meta_value' => 'template-catalog.php'
]);
$child_cats_args = [
  'post_type' => 'page',
  'order' => 'ASC',
  'orderby' => 'menu_order',
  'meta_key' => '_wp_page_template',
  'meta_value' => 'template-catalog.php'
];
// если родительская страница "Продукция", показать подкатегории
if ($current_parent_id === $root_id) {
  $child_cats_args['post_parent'] = $current_id;
}
// если текущая страница "Продукция", показать подкатегории подкатегорий
if ($current_id === $root_id) {
  $child_cats_args['post_parent__in'] = array_map(function ($item) {
    return $item->ID;
  }, $root_cats->get_posts());
}
// если "Продукция" не текущая и не родительская, показать подкатегории родительской
if ($current_parent_id !== $root_id && $current_id !== $root_id) {
  $child_cats_args['post_parent'] = $current_parent_id;
}
$child_cats = new WP_Query($child_cats_args);
// $child_cats = new WP_Query([
//   'post_parent' => $current_id,
//   'post_type' => 'page',
//   'order' => 'ASC',
//   'orderby' => 'menu_order',
//   'meta_key' => '_wp_page_template',
//   'meta_value' => 'template-catalog.php'
// ]);

?>
<!DOCTYPE html>
<html class="no-js" <?php language_attributes() ?> itemscope itemtype="http://schema.org/WebSite">
  <head>
    <?php get_template_part('partials/head') ?>
  </head>
  <body <?php body_class() ?>>
    <?php wp_body_open() ?>

    <div class="page">
      <?php get_template_part('partials/header') ?>

      <section class="catalog-section">
        <div class="ui-container">
          <div class="directions-grid">
            <?php while ($root_cats->have_posts()): ?>
            <?php $root_cats->the_post() ?>
            <div class="directions-grid__cell">
              <div class="directions-item<?php echo (get_the_ID() == $current_id ? ' directions-item_active' : '') ?>">
                <?php if ($icon = get_field('icon', get_the_ID())): ?>
                <div class="directions-item__icon">
                  <?php echo $icon ?>
                </div>
                <?php endif ?>
                <a href="<?php the_permalink() ?>" class="directions-item__title"><?php the_title() ?></a>
              </div>
            </div>
            <?php endwhile ?>
            <?php wp_reset_postdata() ?>
          </div>

          <div class="sections">
            <?php while ($child_cats->have_posts()): ?>
            <?php $child_cats->the_post() ?>
            <?php $products = get_products(get_the_ID()) ?>
            <div class="sections-item">
              <div class="sections-item__title"><?php the_title() ?></div>
              <?php if ($products->have_posts()): ?>
              <div class="sections-item__list">
                <div class="products-grid">
                  <?php while ($products->have_posts()): ?>
                  <?php $products->the_post() ?>
                  <div class="products-grid__cell">
                    <div class="product-item">
                      <figure class="product-item__image">
                        <img src="<?php the_post_thumbnail_url('theme-medium')?>" alt="<?php the_title() ?>" />
                      </figure>
                      <div class="product-item__body">
                        <div class="product-item__title"><?php the_title() ?></div>
                        <?php if ($labels = get_field('labels')): ?>
                        <div class="product-item__labels">
                          <?php echo implode(', ', array_map(function ($item) { return $item['value']; }, $labels)) ?>
                        </div>
                        <?php endif ?>
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
            <?php endwhile ?>
            <?php wp_reset_postdata() ?>
          </div>

          <div>
            <?php the_content() ?>
          </div>
        </div>
      </section>
    
      <?php get_template_part('partials/footer') ?>
    </div>

    <?php wp_footer() ?>
  </body>
</html>
