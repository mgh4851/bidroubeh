<!DOCTYPE html>
<html dir="rtl" lang="fa-IR">
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<header class="site-header">
  <div class="header-topline">
    <div class="wrap">
      <div class="tl-info">پرتال رسمی <?php bloginfo('name'); ?> | <?php echo esc_html(get_theme_mod('bd_phone','061-00000000')); ?> | <?php echo esc_html(get_theme_mod('bd_email','info@bidrubeh.ir')); ?></div>
      <div class="tb-links"><?php if(function_exists('bidrubeh_header_occasion')) bidrubeh_header_occasion(); ?><a href="<?php echo esc_url(home_url('/')); ?>">صفحه اصلی</a><a href="<?php echo esc_url(home_url('/#news')); ?>">اخبار</a><a href="<?php echo esc_url(home_url('/#photos')); ?>">گزارش تصویری</a><a href="<?php echo esc_url(home_url('/#attractions')); ?>">جاذبه‌های گردشگری</a></div>
    </div>
  </div>
  <div class="wrap header-main">
    <a class="brand" href="<?php echo esc_url(home_url('/')); ?>">
      <?php $bd_logo_raw=trim((string)get_theme_mod('bd_logo','')); $bd_logo_w=(int)get_theme_mod('bd_logo_w',150); $bd_logo_h=(int)get_theme_mod('bd_logo_h',60); if($bd_logo_w<=0) $bd_logo_w=150; if($bd_logo_h<=0) $bd_logo_h=60; if(preg_match('#^https?://#i',$bd_logo_raw)) $bd_logo_url=$bd_logo_raw; elseif($bd_logo_raw!=='') $bd_logo_url=wp_get_attachment_image_url((int)$bd_logo_raw,'full'); else $bd_logo_url=''; if($bd_logo_url): ?>
      <img class="brand-logo" src="<?php echo esc_url($bd_logo_url); ?>" alt="<?php bloginfo('name'); ?>" width="<?php echo esc_attr($bd_logo_w); ?>" height="<?php echo esc_attr($bd_logo_h); ?>" style="width:<?php echo esc_attr($bd_logo_w); ?>px;height:<?php echo esc_attr($bd_logo_h); ?>px">
      <?php else: ?>
      <span class="brand-mark"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V10l7-6 7 6v11"/><path d="M9 21v-5h6v5M12 4v3"/></svg></span>
      <?php endif; ?>
    </a>
    <button class="menu-toggle" id="menuToggle">منو</button>
    <nav class="main-nav" id="mainNav">
      <?php wp_nav_menu(['theme_location'=>'primary','container'=>false,'menu_class'=>'','fallback_cb'=>'bidrubeh_menu_fallback']); ?>
    </nav>
    <span class="slogan">
      <?php $bd_slogan_raw=trim((string)get_theme_mod('bd_slogan','')); $bd_slogan_w=(int)get_theme_mod('bd_slogan_w',150); $bd_slogan_h=(int)get_theme_mod('bd_slogan_h',60); if($bd_slogan_w<=0) $bd_slogan_w=150; if($bd_slogan_h<=0) $bd_slogan_h=60; if(preg_match('#^https?://#i',$bd_slogan_raw)) $bd_slogan_url=$bd_slogan_raw; elseif($bd_slogan_raw!=='') $bd_slogan_url=wp_get_attachment_image_url((int)$bd_slogan_raw,'full'); else $bd_slogan_url=''; if($bd_slogan_url): ?>
      <img class="slogan-img" src="<?php echo esc_url($bd_slogan_url); ?>" alt="<?php esc_attr_e('شعار سال','bidrubeh'); ?>" width="<?php echo esc_attr($bd_slogan_w); ?>" height="<?php echo esc_attr($bd_slogan_h); ?>" style="width:<?php echo esc_attr($bd_slogan_w); ?>px;height:<?php echo esc_attr($bd_slogan_h); ?>px">
      <?php else: ?>
      <span class="slogan-ph"><?php esc_html_e('شعار سال','bidrubeh'); ?></span>
      <?php endif; ?>
    </span>
  </div>
</header>
<main>
