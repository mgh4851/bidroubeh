<!DOCTYPE html>
<html dir="rtl" lang="fa-IR">
<head>
<meta charset="<?php bloginfo('charset'); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<?php wp_head(); ?>
</head>
<body <?php body_class(); ?>>
<a class="bd-skip-link" href="#bd-main">رفتن به محتوای اصلی</a>
<header class="site-header">
  <div class="header-topline">
    <div class="wrap">
      <div class="bd-top-identity"><a class="tl-info" href="<?php echo esc_url(home_url('/')); ?>" aria-label="پرتال رسمی <?php echo esc_attr(get_bloginfo('name')); ?>، صفحه اصلی">پرتال رسمی <?php bloginfo('name'); ?></a>
      <?php $bd_top_phone=trim((string)get_theme_mod('bd_phone','')); if($bd_top_phone==='') $bd_top_phone=trim((string)get_theme_mod('bd_hotline','۱۳۷')); $bd_top_dial=preg_replace('/[^0-9]/','',bidrubeh_fa_to_en($bd_top_phone)); if($bd_top_phone!=='' && $bd_top_dial!==''): ?>
      <a class="bd-top-phone" href="<?php echo esc_url('tel:'.$bd_top_dial); ?>"><span aria-hidden="true"><?php echo bidrubeh_icon('phone'); ?></span><span>تماس: <bdi dir="ltr"><?php echo esc_html($bd_top_phone); ?></bdi></span></a>
      <?php endif; ?>
      </div>
      <div class="tb-links"><?php if(function_exists('bidrubeh_header_occasion')) bidrubeh_header_occasion(); ?><a href="<?php echo esc_url(home_url('/#photos')); ?>">گزارش تصویری</a><a href="<?php echo esc_url(home_url('/#attractions')); ?>">دیدنی‌های شهر</a></div>
    </div>
  </div>
  <div class="wrap header-main">
    <a class="brand" href="<?php echo esc_url(home_url('/')); ?>">
      <?php $bd_logo_raw=trim((string)get_theme_mod('bd_logo','')); $bd_logo_w=(int)get_theme_mod('bd_logo_w',150); $bd_logo_h=(int)get_theme_mod('bd_logo_h',60); if($bd_logo_w<=0) $bd_logo_w=150; if($bd_logo_h<=0) $bd_logo_h=60; if(preg_match('#^https?://#i',$bd_logo_raw)) $bd_logo_url=$bd_logo_raw; elseif($bd_logo_raw!=='') $bd_logo_url=wp_get_attachment_image_url((int)$bd_logo_raw,'full'); else $bd_logo_url=''; if($bd_logo_url): ?>
      <img class="brand-logo" src="<?php echo esc_url($bd_logo_url); ?>" alt="<?php bloginfo('name'); ?>" width="<?php echo esc_attr($bd_logo_w); ?>" height="<?php echo esc_attr($bd_logo_h); ?>" style="width:<?php echo esc_attr($bd_logo_w); ?>px;height:<?php echo esc_attr($bd_logo_h); ?>px">
      <?php else: ?>
      <span class="brand-mark"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" stroke-linejoin="round"><path d="M3 21h18M5 21V10l7-6 7 6v11"/><path d="M9 21v-5h6v5M12 4v3"/></svg></span>
      <span class="brand-name"><?php bloginfo('name'); ?></span>
      <?php endif; ?>
    </a>
    <button class="menu-toggle" id="menuToggle" type="button">منو</button>
    <nav class="main-nav" id="mainNav" aria-label="منوی اصلی">
      <?php wp_nav_menu(['theme_location'=>'primary','container'=>false,'menu_class'=>'','fallback_cb'=>'bidrubeh_menu_fallback']); ?>
    </nav>
    <?php $bd_slogan_raw=trim((string)get_theme_mod('bd_slogan','')); if(preg_match('#^https?://#i',$bd_slogan_raw)) $bd_slogan_url=$bd_slogan_raw; elseif($bd_slogan_raw!=='') $bd_slogan_url=wp_get_attachment_image_url((int)$bd_slogan_raw,'full'); else $bd_slogan_url='';
    $bd_portrait=trim((string)get_theme_mod('bd_header_portrait','')); $bd_portrait_url=preg_match('#^https?://#i',$bd_portrait)?$bd_portrait:wp_get_attachment_image_url((int)$bd_portrait,'medium');
    if(($bd_slogan_url && $bd_slogan_url!==$bd_logo_url)||$bd_portrait_url): ?>
    <div class="bd-header-images<?php echo $bd_portrait_url?' bd-has-portrait':''; ?>">
    <?php if($bd_slogan_url && $bd_slogan_url!==$bd_logo_url): ?>
    <span class="slogan"><img class="slogan-img" src="<?php echo esc_url($bd_slogan_url); ?>" alt="<?php esc_attr_e('شعار سال','bidrubeh'); ?>" width="100" height="44"></span>
    <?php endif; ?>
    <?php if($bd_portrait_url): ?>
    <span class="bd-header-portrait"><img src="<?php echo esc_url($bd_portrait_url); ?>" alt="<?php esc_attr_e('تصویر رهبری','bidrubeh'); ?>" width="100" height="60"></span>
    <?php endif; ?>
    </div>
    <?php endif; ?>
  </div>
</header>
<main id="bd-main">
