<!DOCTYPE html>
<html class="no-js" <?php language_attributes()?> itemscope itemtype="http://schema.org/WebSite">
  <head>
    <?php get_template_part('partials/head');?>
  </head>
  <body <?php body_class() ?>>
    <?php wp_body_open() ?>

    <div class="ui-wrapper">
      <?php get_template_part('partials/header') ?>

      <div class="page-main">
        <div class="ui-container">
          <div class="page-headline">
            <h1 class="page-headline__title"><?php single_cat_title() ?></h1>
          </div>

          <?php // $template = get_field('template', 'category_' . get_queried_object_id()) ?>

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
          $parent_id = $category->parent === 0 ? $category->term_id : $category->parent;
          $nav = get_term_children($parent_id, 'category');
          $nav_enabled = false;
          ?>
          <div class="projects-layout">
            <?php if (count($nav) > 0 && $nav_enabled): ?>
            <div class="projects-layout__nav">
              <div class="projects-nav">
                <ul class="projects-nav__list">
                  <li class="projects-nav__item<?php if ($category->term_id === $parent_id): ?> projects-nav__item_active<?php endif ?>">
                    <a href="<?php echo get_term_link($parent_id) ?>" class="projects-nav__link">Все</a>
                  </li>
                  <?php foreach ($nav as $child): $term = get_term_by('id', $child, 'category'); ?>
                  <li class="projects-nav__item<?php if ($category->term_id === $child): ?> projects-nav__item_active<?php endif ?>">
                    <a href="<?php echo get_term_link($term) ?>" class="projects-nav__link"><?php echo esc_html($term->name) ?></a>
                  </li>
                  <?php endforeach; ?>
                </ul>
              </div>
            </div>
            <?php endif ?>

            <div class="projects-layout__list">
              <div class="projects-list">
                <?php foreach ($query->posts as $item): ?>
                <div class="projects-list__item">
                  <article class="projects-card">
                    <figure class="projects-card__image">
                      <img src="<?php echo get_the_post_thumbnail_url($item, 'theme-medium') ?>" alt="<?php echo get_the_title($item) ?>" />
                    </figure>

                    <?php if ($description = get_field('description', $item->ID)): ?>
                    <div class="projects-card__date"><?php echo $description ?></div>
                    <?php endif ?>

                    <div class="projects-card__title">
                      <a href="<?php the_permalink($item->ID) ?>">
                        <?php echo get_the_title($item) ?>
                      </a>
                    </div>

                    <!-- <div class="projects-card__excerpt">
                      <?php echo \DomenART\Theme\Services\Theme::excerpt(['maxchar' => 400, 'text' => $item->post_excerpt ?: $item->post_content]) ?>
                    </div> -->

                    <!-- <div class="projects-card__more">
                      <a href="<?php the_permalink($item->ID) ?>" class="projects-card__more-link">
                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="15" viewBox="0 0 25 15"><path d="M18 14.998v-6h-8v-3s5.38.021 8 0V0l6.068 7.95zm-13-9h3v3H5zm-5 0h3v3H0z"/>
                      </svg>
                    </a>
                    </div> -->
                  </article>
                </div>
                <?php endforeach; ?>
              </div>
            </div>
    
            <div class="projects-layout__pagination">
              <?php wp_pagenavi(['query' => $query]) ?>
            </div>
          </div>
        </div>
      </div>

      <?php get_template_part('partials/footer')?>
    </div>
  </body>
</html>
