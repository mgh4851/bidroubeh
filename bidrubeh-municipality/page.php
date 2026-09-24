<?php get_header(); ?>
<section class="section"><div class="wrap content-grid">
<div>
<?php while(have_posts()): the_post(); ?>
<article class="loop-card">
<h2><?php the_title(); ?></h2>
<?php if(has_post_thumbnail()) the_post_thumbnail('large'); ?>
<div><?php the_content(); ?></div>
</article>
<?php endwhile; ?>
</div>
<?php get_sidebar(); ?>
</div></section>
<?php get_footer(); ?>
