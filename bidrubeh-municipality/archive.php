<?php get_header(); ?>
<section class="section"><div class="wrap content-grid">
<div>
<div class="loop-card bd-archive-heading"><span class="bd-archive-icon" aria-hidden="true"><?php echo bidrubeh_icon('news'); ?></span><div><h1><?php echo get_query_var('bd_news_archive')?'آخرین اخبار':wp_kses_post(get_the_archive_title()); ?></h1><?php if(!get_query_var('bd_news_archive')): ?><div class="bd-archive-description"><?php the_archive_description(); ?></div><?php else: ?><p>تازه‌ترین خبرهای منتشرشده در شهرداری بیدروبه</p><?php endif; ?></div></div>
<?php if(have_posts()): echo '<div class="news-grid" style="margin-bottom:14px">';
while(have_posts()): the_post(); ?>
<a class="news-thumb-card" href="<?php the_permalink(); ?>">
<?php if(has_post_thumbnail()) { the_post_thumbnail([400,260],['class'=>'news-thumb-img']); } else { echo '<span class="news-thumb-img news-thumb-ph"></span>'; } ?>
<span class="news-thumb-body"><strong><?php the_title(); ?></strong><small class="meta bd-post-meta"><span><?php echo esc_html(bidrubeh_pdate('')); ?></span><span>نویسنده: <?php the_author(); ?></span><?php echo bidrubeh_post_views_html(); ?><span class="bd-comment-count"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><path d="M21 12a8 8 0 0 1-8 8H5l-2 2V12a8 8 0 0 1 8-8h2a8 8 0 0 1 8 8z"/></svg><?php echo esc_html(bidrubeh_comments_label()); ?></span></small></span>
</a>
<?php endwhile; echo '</div>'; the_posts_pagination(); else: ?><div class="loop-card"><p>هنوز خبری منتشر نشده است.</p></div><?php endif; ?>
</div>
<?php get_sidebar(); ?>
</div></section>
<?php get_footer(); ?>
