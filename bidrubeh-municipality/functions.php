<?php
define('BIDRUBEH_VER','1.9.89');
add_action('customize_controls_enqueue_scripts',function(){
  wp_add_inline_script('customize-controls',"(function(){var fa='۰۱۲۳۴۵۶۷۸۹';function toFa(s){return String(s).replace(/[0-9]/g,function(d){return fa[d];});}document.addEventListener('input',function(e){var t=e.target;if(!t||!t.id||t.tagName!=='INPUT')return;if(/bd_(slider_count|slider_speed|notice_count|photo_count|logo_w|logo_h|slogan_w|slogan_h|bar\d+_pct)/.test(t.id){var p=null;try{p=t.selectionStart;}catch(_){}var v=toFa(t.value);if(v!==t.value){t.value=v;try{if(p!==null)t.setSelectionRange(p,p);}catch(_){}}}});})();");
});
function bidrubeh_fa_to_en($s){
  return str_replace(['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٠','١','٢','٣','٤','٥','٦','٧','٨','٩'],['0','1','2','3','4','5','6','7','8','9','0','1','2','3','4','5','6','7','8','9'],(string)$s);
}
function bidrubeh_sanitize_num($raw){
  $s=bidrubeh_fa_to_en($raw);
  $s=preg_replace('/\D+/','',$s);
  return absint($s);
}
function bidrubeh_sanitize_logo($raw){
  $raw=trim((string)$raw);
  if($raw==='') return '';
  if(preg_match('#^https?://#i',$raw)) return esc_url_raw($raw);
  return absint($raw);
}
function bidrubeh_social_img($k){
  $base=get_template_directory().'/assets/social/'.$k;
  $uri=get_template_directory_uri().'/assets/social/'.$k;
  if(file_exists($base.'.png')) return $uri.'.png';
  if(file_exists($base.'.svg')) return $uri.'.svg';
  return $uri.'.png';
}
function bidrubeh_whatsapp_url($raw){
  $raw=trim((string)$raw);
  if($raw==='') return '';
  if(preg_match('#^https?://#i',$raw)) return esc_url_raw($raw);
  if(preg_match('#^(www\.)?wa\.me/#i',$raw)) return esc_url_raw('https://'.ltrim($raw,'htps:/'));
  $d=str_replace(['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٠','١','٢','٣','٤','٥','٦','٧','٨','٩'],['0','1','2','3','4','5','6','7','8','9','0','1','2','3','4','5','6','7','8','9'],$raw);
  $d=preg_replace('/\D+/','',$d);
  if($d==='') return '';
  if(preg_match('/^0(\d+)$/',$d,$m)) $d='98'.$m[1];
  elseif(preg_match('/^0098(\d+)$/',$d,$m)) $d='98'.$m[1];
  return esc_url_raw('https://wa.me/'.$d);
}
function bidrubeh_social_url($raw,$base){
  $raw=trim((string)$raw);
  if($raw==='') return '';
  if(preg_match('#^https?://#i',$raw)) return esc_url_raw($raw);
  if(preg_match('#^(www\.)?(eitaa\.com|ble\.ir|bale\.ai|rubika\.ir)/#i',$raw)) return esc_url_raw('https://'.ltrim(ltrim($raw),'htps:/'));
  $raw=ltrim($raw,'@'); $raw=ltrim($raw,'/');
  if(strpos($raw,'/')!==false){ $parts=explode('/',$raw); $raw=end($parts); }
  $raw=str_replace(['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٠','١','٢','٣','٤','٥','٦','٧','٨','٩',' ','-'],['0','1','2','3','4','5','6','7','8','9','0','1','2','3','4','5','6','7','8','9','',''],$raw);
  $raw=preg_replace('/[^\w\.\-]/u','',$raw);
  $raw=trim($raw,'-/._');
  if($raw==='') return '';
  if(preg_match('/^(98|0098)9\d{8}$/',$raw)) $raw='0'.substr(preg_replace('/^(98|0098)/','',$raw),0);
  if(preg_match('/^989\d{9}$/',$raw)) $raw='0'.substr($raw,2);
  $raw=ltrim($raw,'+');
  if($raw==='') return '';
  return esc_url_raw(rtrim($base,'/').'/'.$raw);
}
function bidrubeh_socials(){
  return [
    ['k'=>'eitaa','label'=>'ایتا','url'=>bidrubeh_social_url(get_theme_mod('bd_eitaa',''),'https://eitaa.com/')],
    ['k'=>'bale','label'=>'بله','url'=>bidrubeh_social_url(get_theme_mod('bd_bale',''),'https://ble.ir/')],
    ['k'=>'rubika','label'=>'روبیکا','url'=>bidrubeh_social_url(get_theme_mod('bd_rubika',''),'https://rubika.ir/')],
    ['k'=>'whatsapp','label'=>'واتساپ','url'=>bidrubeh_whatsapp_url(get_theme_mod('bd_whatsapp',''))],
    ['k'=>'telegram','label'=>'تلگرام','url'=>bidrubeh_social_url(get_theme_mod('bd_telegram',''),'https://t.me/')],
    ['k'=>'instagram','label'=>'اینستاگرام','url'=>bidrubeh_social_url(get_theme_mod('bd_instagram',''),'https://instagram.com/')],
  ];
}
function bidrubeh_social_links(){
  $out='';
  foreach(bidrubeh_socials() as $s){
    if(empty($s['url'])) continue;
    $out.='<a class="bd-soc bd-soc-'.$s['k'].'" href="'.esc_url($s['url']).'" target="_blank" rel="noopener,noreferrer" aria-label="'.esc_attr($s['label']).'" title="'.esc_attr($s['label']).'"><img src="'.esc_url(bidrubeh_social_img($s['k'])).'" alt="'.esc_attr($s['label']).'" width="40" height="40" loading="lazy" draggable="false"></a>';
  }
  return $out;
}
function bidrubeh_menu_fallback(){
  echo '<ul><li><a href="'.esc_url(home_url('/')).'">صفحه اصلی</a></li><li><a href="#news">اخبار</a></li></ul>';
}
function bidrubeh_calendar_events(){
  return [
    '1-1'=>'نوروز','1-12'=>'روز جمهوری اسلامی ایران','1-13'=>'روز طبیعت',
    '2-10'=>'روز ملی خلیج فارس','2-25'=>'روز بزرگداشت فردوسی',
    '3-14'=>'رحلت امام خمینی (ره)','3-15'=>'قیام ۱۵ خرداد',
    '4-7'=>'شهادت آیت‌الله بهشتی و روز قوه قضائیه',
    '5-14'=>'روز صدور فرمان مشروطیت','5-17'=>'روز خبرنگار',
    '6-1'=>'روز پزشک','6-31'=>'آغاز هفته دفاع مقدس',
    '7-7'=>'روز آتش‌نشانی و ایمنی','7-20'=>'روز بزرگداشت حافظ',
    '8-13'=>'روز دانش‌آموز','9-16'=>'روز دانشجو',
    '10-9'=>'روز بصیرت و میثاق امت','10-19'=>'قیام مردم قم',
    '11-12'=>'بازگشت امام خمینی (ره)','11-22'=>'پیروزی انقلاب اسلامی',
    '12-15'=>'روز درختکاری','12-29'=>'روز ملی شدن صنعت نفت',
  ];
}
function bidrubeh_today_parts(){
  $dt=new DateTime('now',new DateTimeZone('Asia/Tehran'));
  [$jy,$jm,$jd]=bidrubeh_g2j((int)$dt->format('Y'),(int)$dt->format('n'),(int)$dt->format('j'));
  $months=['','فروردین','اردیبهشت','خرداد','تیر','مرداد','شهریور','مهر','آبان','آذر','دی','بهمن','اسفند'];
  $fa_wday=['یکشنبه','دوشنبه','سه‌شنبه','چهارشنبه','پنجشنبه','جمعه','شنبه'][(int)$dt->format('w')];
  return [$jy,$jm,$jd,$fa_wday,$months[$jm]];
}
function bidrubeh_today_event(){
  $events=bidrubeh_calendar_events();
  [$jy,$jm,$jd]=bidrubeh_today_parts();
  $key=$jm.'-'.$jd;
  return isset($events[$key])?$events[$key]:'';
}
function bidrubeh_header_occasion(){
  [$jy,$jm,$jd,$wday,$mname]=bidrubeh_today_parts();
  $line=$wday.' '.bidrubeh_fa_digits($jd.' '.$mname.' '.$jy);
  $ev=bidrubeh_today_event();
  echo '<span class="bd-today-badge">📅 '.esc_html($line).'</span>';
  if($ev!=='') echo '<span class="bd-event-badge">⭐ '.esc_html($ev).'</span>';
}
function bidrubeh_related_posts($post_id=null,$count=3){
  $post_id=$post_id?(int)$post_id:get_the_ID();
  $count=max(1,min(6,(int)$count));
  $found=[];
  $pick=function($args) use ($post_id,$count,&$found){
    $args=array_merge(['posts_per_page'=>$count,'post__not_in'=>array_merge([$post_id],array_map(function($p){ return $p->ID; },$found)),'ignore_sticky_posts'=>1,'no_found_rows'=>true,'post_status'=>'publish'],$args);
    $q=new WP_Query($args);
    foreach((array)$q->posts as $p){ $found[]=$p; if(count($found)>=$count) break; }
    wp_reset_postdata();
  };
  $tags=wp_get_post_tags($post_id,['fields'=>'ids']);
  if(!empty($tags)) $pick(['tag__in'=>array_map('intval',(array)$tags)]);
  if(count($found)<$count){
    $cats=wp_get_post_categories($post_id);
    if(!empty($cats)) $pick(['category__in'=>array_map('intval',(array)$cats)]);
  }
  if(count($found)<$count) $pick(['orderby'=>'date','order'=>'DESC']);
  return array_slice($found,0,$count);
}
function bidrubeh_render_calendar(){}
function bidrubeh_msg_fp(){
  if(is_user_logged_in()) return 'u'.get_current_user_id();
  $ip=isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'0';
  $ua=isset($_SERVER['HTTP_USER_AGENT'])?substr($_SERVER['HTTP_USER_AGENT'],0,120):'';
  return 'g'.substr(md5($ip.'|'.$ua),0,16);
}
function bidrubeh_norm_phone($raw){
  $s=(string)$raw;
  $s=str_replace(['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹','٠','١','٢','٣','٤','٥','٦','٧','٨','٩'],['0','1','2','3','4','5','6','7','8','9','0','1','2','3','4','5','6','7','8','9'],$s);
  $s=preg_replace('/\D+/','',$s);
  if(strpos($s,'0098')===0) $s='0'.substr($s,4);
  elseif(strpos($s,'98')===0&&strlen($s)===12) $s='0'.substr($s,2);
  elseif(strlen($s)===10&&$s[0]==='9') $s='0'.$s;
  return $s;
}
function bidrubeh_unread_by_phone($phone_norm){
  global $wpdb;
  if($phone_norm==='') return ['count'=>0,'latest'=>null];
  $ids=$wpdb->get_col($wpdb->prepare(
    "SELECT DISTINCT p.ID FROM {$wpdb->posts} p INNER JOIN {$wpdb->postmeta} m1 ON p.ID=m1.post_id AND m1.meta_key IN ('bd_phone_norm','bd_phone') AND m1.meta_value=%s INNER JOIN {$wpdb->postmeta} m2 ON p.ID=m2.post_id AND m2.meta_key='bd_read' AND m2.meta_value='0' WHERE p.post_type='bidrubeh_msg' AND p.post_status='private' ORDER BY p.post_date DESC",
    $phone_norm
  ));
  $latest=$ids?get_post((int)$ids[0]):null;
  return ['count'=>count($ids),'latest'=>$latest];
}
function bidrubeh_unread_by_ip($fp=null){
  global $wpdb;
  if($fp===null) $fp=bidrubeh_msg_fp();
  if($fp==='') return ['count'=>0,'latest'=>null];
  $ids=$wpdb->get_col($wpdb->prepare(
    "SELECT DISTINCT p.ID FROM {$wpdb->posts} p INNER JOIN {$wpdb->postmeta} m1 ON p.ID=m1.post_id AND m1.meta_key='bd_fp' AND m1.meta_value=%s INNER JOIN {$wpdb->postmeta} m2 ON p.ID=m2.post_id AND m2.meta_key='bd_read' AND m2.meta_value='0' WHERE p.post_type='bidrubeh_msg' AND p.post_status='private' ORDER BY p.post_date DESC",
    $fp
  ));
  $latest=$ids?get_post((int)$ids[0]):null;
  return ['count'=>count($ids),'latest'=>$latest];
}
function bidrubeh_pending_msg($fp){
  return null;
}
function bidrubeh_contact_shortcode(){
  $err=''; $v_name=''; $v_phone=''; $v_msg=''; $check=null;
  if(isset($_POST['bd_contact_send'])&&isset($_POST['bd_contact_nonce'])&&wp_verify_nonce($_POST['bd_contact_nonce'],'bd_contact')){
    $v_name=sanitize_text_field($_POST['bd_name']??'');
    $v_phone=sanitize_text_field($_POST['bd_phone2']??'');
    $v_msg=sanitize_textarea_field($_POST['bd_msg']??'');
    $pn=bidrubeh_norm_phone($v_phone);
    $page=(int)($_POST['bd_page']??0);
    if($v_name===''){ $err='لطفاً نام خود را وارد کنید.'; }
    elseif($v_phone===''){ $err='لطفاً شماره تلفن را وارد کنید.'; }
    elseif($v_msg===''){ $err='لطفاً متن پیام را وارد کنید.'; }
    elseif(strlen($pn)!==11||!preg_match('/^09\d{9}$/',$pn)){ $err='شماره تلفن باید دقیقاً ۱۱ رقم و با ۰۹ شروع شود (مثال: ۰۹۱۲۳۴۵۶۷۸۹).'; }
    elseif(mb_strlen(trim($v_msg))<10){ $err='متن پیام باید حداقل ۱۰ کاراکتر باشد.'; }
    else{
      $st=bidrubeh_unread_by_phone($pn);
      if($st['count']>0){
        $check=array_merge($st,['by'=>'phone']);
        $err='';
      }
      else{
        $ipst=bidrubeh_unread_by_ip();
        if($ipst['count']>0){
          $check=array_merge($ipst,['by'=>'ip']);
          $err='';
        }
        else{
          $to=get_option('admin_email');
          wp_mail($to,'پیام تماس با ما: '.$v_name,"نام: $v_name\nتلفن: $v_phone\n\n$v_msg");
          $id=wp_insert_post(['post_type'=>'bidrubeh_msg','post_title'=>$v_name.' — '.wp_date('Y/m/d H:i'),'post_content'=>"نام: $v_name\nتلفن: $v_phone\n\n$v_msg",'post_status'=>'private']);
          if($id&&!is_wp_error($id)){ update_post_meta($id,'bd_fp',bidrubeh_msg_fp()); update_post_meta($id,'bd_read',0); update_post_meta($id,'bd_phone',$v_phone); update_post_meta($id,'bd_phone_norm',$pn); }
          $url=$page?get_permalink($page):home_url('/contact-us/');
          wp_safe_redirect(add_query_arg('bd_sent','1',$url)); exit;
        }
      }
    }
  }
  $sent=isset($_GET['bd_sent']);
  if(!$check){
    $ipst2=bidrubeh_unread_by_ip();
    if($ipst2['count']>0) $check=array_merge($ipst2,['by'=>'ip']);
  }
  $show_sent=$sent && $check;
  ob_start();
  if($show_sent) echo '<div class="bd-sent-ok"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M8 12.5l2.5 2.5L16 9.5"/></svg><div><strong>پیام شما با موفقیت ثبت شد.</strong><small>تا خوانده شدن پیام توسط مدیر، با همین شماره امکان ارسال مجدد نیست.</small></div></div>';
  if($err!=='') echo '<div class="bd-form-err">'.esc_html($err).'</div>';
  if($check){
    $n=(int)$check['count'];
    $dt=$check['latest']?bidrubeh_fa_digits(get_the_date('', $check['latest'])):'';
    $by=$check['by']??'phone';
    $msg=$by==='ip'?sprintf('این دستگاه %s پیام خوانده‌نشده دارد.',bidrubeh_fa_digits($n)):sprintf('این شماره تلفن %s پیام خوانده‌نشده دارد.',bidrubeh_fa_digits($n));
    $hint=$by==='ip'?'آخرین پیام از این دستگاه در '.esc_html($dt).' ثبت شده و هنوز توسط مدیر خوانده نشده است. پس از خوانده شدن می‌توانید دوباره پیام بفرستید.':'آخرین پیام در '.esc_html($dt).' ثبت شده و هنوز توسط مدیر خوانده نشده است. پس از خوانده شدن، با همین شماره می‌توانید دوباره پیام بفرستید.';
    echo '<div class="bd-lock-box"><span class="bd-lock-ico">⏳</span><div><strong>'.esc_html($msg).'</strong><small>'.esc_html($hint).'</small></div></div>';
    echo '<button class="bd-send-btn" type="button" disabled><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg><span>منتظر خوانده شدن پیام قبلی…</span></button>';
  } else {
  ?>
  <?php $bd_ip0=bidrubeh_unread_by_ip(); if($bd_ip0['count']>0){ echo '<div class="bd-lock-box"><span class="bd-lock-ico">⏳</span><div><strong>'.esc_html(sprintf('این دستگاه %s پیام خوانده‌نشده دارد.',bidrubeh_fa_digits($bd_ip0['count']))).'</strong><small>تا خوانده شدن پیام قبلی توسط مدیر امکان ارسال نیست.</small></div></div>'; } ?>
  <form class="bd-contact-form" method="post" action="" id="bdContactForm">
    <?php wp_nonce_field('bd_contact','bd_contact_nonce'); ?>
    <input type="hidden" name="bd_page" value="<?php echo (int)get_the_ID(); ?>">
    <p><label>نام و نام خانوادگی *</label><input type="text" name="bd_name" id="bdName" required value="<?php echo esc_attr($v_name); ?>"<?php echo $bd_ip0['count']>0?' disabled':''; ?>></p>
    <p><label>تلفن تماس (موبایل) *</label><input type="tel" name="bd_phone2" id="bdPhone" required inputmode="numeric" maxlength="11" placeholder="۰۹۱۲۳۴۵۶۷۸۹" value="<?php echo esc_attr($v_phone); ?>"<?php echo $bd_ip0['count']>0?' disabled':''; ?>><small class="bd-phone-status" id="bdPhoneStatus"></small></p>
    <p class="full"><label>متن پیام *</label><textarea name="bd_msg" id="bdMsg" rows="5" required minlength="10"<?php echo $bd_ip0['count']>0?' disabled':''; ?>><?php echo esc_textarea($v_msg); ?></textarea></p>
    <p class="full"><button class="bd-send-btn" type="submit" name="bd_contact_send" id="bdSendBtn"<?php echo $bd_ip0['count']>0?' disabled':''; ?>><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg><span>ارسال پیام</span></button></p>
  </form>
  <script>
  (function(){
    var nm=document.getElementById('bdName'),mg=document.getElementById('bdMsg'),tx=document.getElementById('bdPhone');
    function faMsg(el,empty,short,long){
      if(!el) return;
      el.addEventListener('invalid',function(){
        if(el.validity.valueMissing) el.setCustomValidity(empty);
        else if(el.validity.tooShort) el.setCustomValidity(short);
        else if(el.validity.patternMismatch||el.validity.typeMismatch) el.setCustomValidity(long);
        else el.setCustomValidity('');
      });
      el.addEventListener('input',function(){el.setCustomValidity('');});
    }
    faMsg(nm,'لطفاً نام خود را وارد کنید.','','');
    faMsg(tx,'لطفاً شماره تلفن را وارد کنید.','','لطفاً یک شماره موبایل ۱۱ رقمی معتبر وارد کنید (۰۹…).');
    faMsg(mg,'لطفاً متن پیام را وارد کنید.','متن پیام باید حداقل ۱۰ کاراکتر باشد.','');
    var ph=document.getElementById('bdPhone'),st=document.getElementById('bdPhoneStatus'),btn=document.getElementById('bdSendBtn'),t=null;
    if(!ph) return;
    function fa(s){return String(s).replace(/[0-9]/g,function(d){return '۰۱۲۳۴۵۶۷۸۹'[d];});}
    function check(){
      var v=ph.value.replace(/[^۰-۹٠-٩0-9]/g,'');
      if(v.replace(/[^0-9۰-۹٠-٩]/g,'').length<4){st.textContent='';st.className='bd-phone-status';if(btn)btn.disabled=false;return;}
      st.textContent='در حال بررسی…';st.className='bd-phone-status checking';
      fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>?action=bidrubeh_check_phone&phone='+encodeURIComponent(ph.value))
        .then(function(r){return r.json();}).then(function(d){
          if(d&&d.count>0&&(d.by==='ip')){st.textContent='⚠ این دستگاه '+fa(d.count)+' پیام خوانده‌نشده دارد — تا خوانده شدن توسط مدیر امکان ارسال نیست.';st.className='bd-phone-status blocked';if(btn)btn.disabled=true;}
          else if(d&&d.count>0){st.textContent='⚠ این شماره '+fa(d.count)+' پیام خوانده‌نشده دارد — تا خوانده شدن توسط مدیر امکان ارسال نیست.';st.className='bd-phone-status blocked';if(btn)btn.disabled=true;}
          else{st.textContent='✓ این شماره پیام خوانده‌نشده‌ای ندارد.';st.className='bd-phone-status ok';if(btn)btn.disabled=false;}
        }).catch(function(){st.textContent='';});
    }
    ph.addEventListener('input',function(){clearTimeout(t);t=setTimeout(check,600);});
  })();
  </script>
  <?php
  }
  return ob_get_clean();
}
add_shortcode('bidrubeh_contact','bidrubeh_contact_shortcode');
add_action('wp_ajax_bidrubeh_check_phone','bidrubeh_ajax_check_phone');
add_action('wp_ajax_nopriv_bidrubeh_check_phone','bidrubeh_ajax_check_phone');
function bidrubeh_ajax_check_phone(){
  $pn=bidrubeh_norm_phone($_GET['phone']??'');
  $ipst=bidrubeh_unread_by_ip();
  if(strlen($pn)<4) wp_send_json(['count'=>(int)$ipst['count'],'by'=>$ipst['count']>0?'ip':'']);
  $st=bidrubeh_unread_by_phone($pn);
  if((int)$st['count']>0) wp_send_json(['count'=>(int)$st['count'],'by'=>'phone']);
  wp_send_json(['count'=>(int)$ipst['count'],'by'=>$ipst['count']>0?'ip':'']);
}
add_action('init',function(){
  register_post_type('bidrubeh_msg',['labels'=>['name'=>__('پیام‌های تماس','bidrubeh'),'singular_name'=>__('پیام','bidrubeh')],'public'=>false,'show_ui'=>true,'supports'=>['title','editor']]);
});
add_filter('manage_bidrubeh_msg_posts_columns',function($cols){
  $cols['bd_read']=__('وضعیت','bidrubeh');
  return $cols;
});
add_action('manage_bidrubeh_msg_posts_custom_column',function($col,$id){
  if($col==='bd_read') echo get_post_meta($id,'bd_read',true)?'✅ خوانده شده':'⏳ خوانده نشده';
},10,2);
add_action('add_meta_boxes_bidrubeh_msg',function($post){
  if($post->post_status!=='auto-draft'&&!get_post_meta($post->ID,'bd_read',true)){
    update_post_meta($post->ID,'bd_read',1);
    update_post_meta($post->ID,'bd_read_at',current_time('mysql'));
  }
  add_meta_box('bd_msg_info','اطلاعات پیام',function($p){
    echo '<p>وضعیت: <b>'.(get_post_meta($p->ID,'bd_read',true)?'✅ خوانده شده':'⏳ خوانده نشده').'</b></p>';
    echo '<p>تلفن: <b>'.esc_html(get_post_meta($p->ID,'bd_phone',true)).'</b></p>';
  },'bidrubeh_msg','side','high');
});
function bidrubeh_comment($comment,$args,$depth){
  $GLOBALS['comment']=$comment;
  $is_reply=$depth>1;
  $is_admin=$comment->user_id && (int)$comment->user_id===1;
  ?>
  <li <?php comment_class('bd-comment-item'); ?> id="comment-<?php comment_ID(); ?>">
  <div class="bd-msg<?php echo $is_reply?' is-reply':''; ?>">
    <div class="bd-bubble<?php echo $is_reply?' is-reply':''; ?>">
      <div class="bd-bubble-head">
        <strong class="bd-bubble-author"><?php echo esc_html(get_comment_author()); ?></strong>
        <?php if($is_admin): ?><span class="bd-admin-badge">مدیر</span><?php endif; ?>
        <?php if($is_reply): ?><span class="bd-answer-badge">پاسخ</span><?php endif; ?>
        <?php if($comment->comment_approved==='0'): ?>
          <span class="bd-moderation">در انتظار تأیید</span>
        <?php endif; ?>
      </div>
      <?php if($comment->comment_parent): $pc=get_comment($comment->comment_parent); if($pc): $qt=trim(wp_strip_all_tags($pc->comment_content)); if(mb_strlen($qt)>80) $qt=mb_substr($qt,0,80).'…'; ?>
      <div class="bd-reply-quote"><span class="bd-reply-qauthor"><?php echo esc_html(sprintf(__('پاسخ به %s:','bidrubeh'), get_comment_author($pc))); ?></span> <span class="bd-reply-qtext"><?php echo esc_html($qt); ?></span></div>
      <?php endif; endif; ?>
      <div class="bd-bubble-text"><?php comment_text(); ?></div>
      <div class="bd-bubble-foot">
        <span class="bd-time"><?php echo esc_html(bidrubeh_fa_digits(get_comment_date())); ?> | <?php echo esc_html(bidrubeh_fa_digits(get_comment_time('H:i'))); ?></span>
        <?php
        comment_reply_link(array_merge($args,[
          'depth'=>$depth,'max_depth'=>$args['max_depth'],
          'reply_text'=>'↩ پاسخ',
        ]));
        ?>
      </div>
    </div>
  </div>
  <?php
}

function bidrubeh_comment_fp(){
  if(is_user_logged_in()) return 'u'.get_current_user_id();
  $tok=isset($_COOKIE['bd_cfp'])?preg_replace('/[^a-f0-9]/','',strtolower((string)$_COOKIE['bd_cfp'])):'';
  if(strlen($tok)!==32) $tok='';
  $ip=isset($_SERVER['REMOTE_ADDR'])?$_SERVER['REMOTE_ADDR']:'0';
  $ua=isset($_SERVER['HTTP_USER_AGENT'])?substr($_SERVER['HTTP_USER_AGENT'],0,120):'';
  return 'g'.$tok.'|'.substr(md5($ip.'|'.$ua),0,12);
}
function bidrubeh_comment_ip(){
  return isset($_SERVER['REMOTE_ADDR'])?(string)$_SERVER['REMOTE_ADDR']:'0';
}
function bidrubeh_comment_ip_blocked($post_id=null){
  if(current_user_can('moderate_comments')) return false;
  $post_id=$post_id?(int)$post_id:(int)get_the_ID();
  if(!$post_id) return false;
  $ip=bidrubeh_comment_ip();
  if($ip===''||$ip==='0') return false;
  global $wpdb;
  $n=(int)$wpdb->get_var($wpdb->prepare("SELECT COUNT(*) FROM {$wpdb->comments} WHERE comment_post_ID=%d AND comment_author_IP=%s AND comment_approved='0'",$post_id,$ip));
  return $n>0;
}
add_action('init',function(){
  if(!is_user_logged_in()&&empty($_COOKIE['bd_cfp'])){
    $t=bin2hex(random_bytes(16));
    setcookie('bd_cfp',$t,time()+YEAR_IN_SECONDS,COOKIEPATH,COOKIE_DOMAIN,is_ssl(),true);
    $_COOKIE['bd_cfp']=$t;
  }
},1);
function bidrubeh_comment_blocked($post_id=null){
  if(current_user_can('moderate_comments')) return false;
  $post_id=$post_id?(int)$post_id:(int)get_the_ID();
  if(!$post_id) return false;
  if(bidrubeh_comment_ip_blocked($post_id)) return true;
  $n=get_comments(['post_id'=>$post_id,'meta_key'=>'bd_fp','meta_value'=>bidrubeh_comment_fp(),'status'=>'hold','count'=>true,'bd_lock_check'=>true]);
  return $n>0;
}
add_action('comment_post',function($cid){ update_comment_meta($cid,'bd_fp',bidrubeh_comment_fp()); });
add_filter('pre_comment_approved',function($approved,$commentdata){
  if(!empty($commentdata['user_ID'])&&user_can((int)$commentdata['user_ID'],'moderate_comments')) return $approved;
  return '0';
},10,2);
add_filter('preprocess_comment',function($data){
  if(empty($data['user_ID'])){
    if(trim($data['comment_author']??'')===''){
      wp_die(__('لطفاً نام خود را وارد کنید.','bidrubeh'),__('نام الزامی است','bidrubeh'),['response'=>403,'back_link'=>true]);
    }
    $em=trim($data['comment_author_email']??'');
    if($em===''){
      wp_die(__('لطفاً ایمیل خود را وارد کنید.','bidrubeh'),__('ایمیل الزامی است','bidrubeh'),['response'=>403,'back_link'=>true]);
    }
    if(!is_email($em)){
      wp_die(__('ایمیل وارد شده معتبر نیست.','bidrubeh'),__('ایمیل نامعتبر','bidrubeh'),['response'=>403,'back_link'=>true]);
    }
  }
  $t=trim(wp_strip_all_tags($data['comment_content']??''));
  if(mb_strlen($t)<10){
    wp_die(__('متن دیدگاه باید حداقل ۱۰ کاراکتر باشد.','bidrubeh'),__('متن کوتاه','bidrubeh'),['response'=>403,'back_link'=>true]);
  }
  if(current_user_can('moderate_comments')) return $data;
  $pid=(int)$data['comment_post_ID'];
  if(bidrubeh_comment_blocked($pid)){
    wp_die(__('دیدگاه قبلی شما هنوز توسط مدیر تأیید نشده است. پس از تأیید یا حذف آن می‌توانید دیدگاه جدید ثبت کنید.','bidrubeh'),__('محدودیت ارسال دیدگاه','bidrubeh'),['response'=>403,'back_link'=>true]);
  }
  return $data;
});
add_filter('comment_reply_link',function($link){
  if(!current_user_can('moderate_comments')&&bidrubeh_comment_blocked()) return '';
  return $link;
});
add_filter('comments_array',function($comments,$post_id){
  if(current_user_can('moderate_comments')) return $comments;
  return array_values(array_filter((array)$comments,function($c){ return isset($c->comment_approved)&&$c->comment_approved==='1'; }));
},10,2);
add_action('pre_get_comments',function($q){
  if(is_admin()) return;
  if(current_user_can('moderate_comments')) return;
  if(!empty($q->query_vars['bd_lock_check'])) return;
  $q->query_vars['include_unapproved']='';
  $q->query_vars['status']='approve';
});
function bidrubeh_fa_digits($s){
  return str_replace(['0','1','2','3','4','5','6','7','8','9'],['۰','۱','۲','۳','۴','۵','۶','۷','۸','۹'],(string)$s);
}
function bidrubeh_g2j($gy,$gm,$gd){
  $g_d_m=[0,31,59,90,120,151,181,212,243,273,304,334];
  if($gy>1600){ $jy=979; $gy-=1600; } else { $jy=0; $gy-=621; }
  $gy2=($gm>2)?($gy+1):$gy;
  $days=(365*$gy)+((int)(($gy2+3)/4))-((int)(($gy2+99)/100))+((int)(($gy2+399)/400))-80+$gd+$g_d_m[$gm-1];
  $jy+=33*((int)($days/12053)); $days%=12053;
  $jy+=4*((int)($days/1461)); $days%=1461;
  if($days>365){ $jy+=(int)(($days-1)/365); $days=($days-1)%365; }
  $jm=($days<186)?1+(int)($days/31):7+(int)(($days-186)/30);
  $jd=1+(($days<186)?($days%31):(($days-186)%30));
  return [$jy,$jm,$jd];
}
function bidrubeh_parsidate_active(){
  if(class_exists('WPParsidate\App\Core\FixDates')) return true;
  $active=(array)get_option('active_plugins',[]);
  foreach($active as $p){ if(strpos($p,'wp-parsidate')!==false) return true; }
  return false;
}
function bidrubeh_pdate($format=''){
  return bidrubeh_fa_digits(get_the_date($format));
}
function bidrubeh_jdate($post=null){
  if(bidrubeh_parsidate_active()){
    $d=$post ? get_the_date('', $post) : get_the_date('');
    if($d) return bidrubeh_fa_digits($d);
  }
  if(function_exists('get_post_timestamp')){ $ts=get_post_timestamp($post); }
  else { $ts=get_post_time('U',true,$post); }
  if(!$ts) $ts=time();
  $g=explode('-',wp_date('Y-n-j',$ts));
  [$jy,$jm,$jd]=bidrubeh_g2j((int)$g[0],(int)$g[1],(int)$g[2]);
  return bidrubeh_fa_digits(sprintf('%d/%02d/%02d',$jy,$jm,$jd));
}
if(!bidrubeh_parsidate_active()){
  add_filter('get_the_date',function($the_date,$format,$post){
    if(is_admin()) return $the_date;
    return bidrubeh_jdate($post);
  },10,3);
  add_filter('get_comment_date',function($date,$format,$comment){
    if(is_admin()) return $date;
    return $date;
  },10,3);
}
add_action('after_setup_theme',function(){
  load_theme_textdomain('bidrubeh',get_template_directory().'/languages');
  add_theme_support('title-tag');
  add_theme_support('automatic-feed-links');
  add_theme_support('post-thumbnails');
  set_post_thumbnail_size(640,400,true);
  add_theme_support('custom-logo',['height'=>64,'width'=>64,'flex-width'=>true,'flex-height'=>true]);
  add_theme_support('html5',['search-form','comment-form','comment-list','gallery','caption']);
  register_nav_menus(['primary'=>__('منوی اصلی','bidrubeh'),'footer'=>__('منوی فوتر','bidrubeh')]);
});
add_action('widgets_init',function(){
  register_sidebar(['name'=>__('ستون کناری','bidrubeh'),'id'=>'sidebar-1','before_widget'=>'<div class="widget %2$s">','after_widget'=>'</div>','before_title'=>'<h3>','after_title'=>'</h3>']);
  register_sidebar(['name'=>__('فوتر ۱','bidrubeh'),'id'=>'footer-1','before_widget'=>'<div>','after_widget'=>'</div>','before_title'=>'<h4>','after_title'=>'</h4>']);
  register_sidebar(['name'=>__('فوتر ۲','bidrubeh'),'id'=>'footer-2','before_widget'=>'<div>','after_widget'=>'</div>','before_title'=>'<h4>','after_title'=>'</h4>']);
});
add_action('wp_enqueue_scripts',function(){
  wp_enqueue_style('bidrubeh-style',get_stylesheet_uri(),[],BIDRUBEH_VER);
  wp_enqueue_script('bidrubeh-main',get_template_directory_uri().'/js/main.js',[],BIDRUBEH_VER,true);
});
add_action('customize_register',function($wp_customize){
  $wp_customize->add_section('bidrubeh_brand',['title'=>__('لوگوی سایت','bidrubeh'),'priority'=>29,'description'=>__('تصویر دلخواه لوگو را بارگذاری کنید و ابعاد نمایشی آن را تنظیم کنید. خالی = نمایش نشان پیش‌فرض.','bidrubeh')]);
  $wp_customize->add_setting('bd_logo',['default'=>'','sanitize_callback'=>'bidrubeh_sanitize_logo','transport'=>'refresh']);
  $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,'bd_logo',['label'=>__('تصویر لوگو','bidrubeh'),'section'=>'bidrubeh_brand']));
  $wp_customize->add_setting('bd_logo_w',['default'=>150,'sanitize_callback'=>'bidrubeh_sanitize_num','transport'=>'refresh']);
  $wp_customize->add_control('bd_logo_w',['label'=>__('پهنای لوگو (پیکسل)','bidrubeh'),'description'=>__('عدد فارسی یا انگلیسی، مثلا ۱۵۰ یا 150','bidrubeh'),'section'=>'bidrubeh_brand','type'=>'text','input_attrs'=>['inputmode'=>'numeric','placeholder'=>'۱۵۰']]);
  $wp_customize->add_setting('bd_logo_h',['default'=>60,'sanitize_callback'=>'bidrubeh_sanitize_num','transport'=>'refresh']);
  $wp_customize->add_control('bd_logo_h',['label'=>__('ارتفاع لوگو (پیکسل)','bidrubeh'),'description'=>__('عدد فارسی یا انگلیسی، مثلا ۶۰ یا 60','bidrubeh'),'section'=>'bidrubeh_brand','type'=>'text','input_attrs'=>['inputmode'=>'numeric','placeholder'=>'۶۰']]);
  $wp_customize->add_setting('bd_slogan',['default'=>'','sanitize_callback'=>'bidrubeh_sanitize_logo','transport'=>'refresh']);
  $wp_customize->add_control(new WP_Customize_Image_Control($wp_customize,'bd_slogan',['label'=>__('تصویر شعار سال','bidrubeh'),'section'=>'bidrubeh_brand']));
  $wp_customize->add_setting('bd_slogan_w',['default'=>150,'sanitize_callback'=>'bidrubeh_sanitize_num','transport'=>'refresh']);
  $wp_customize->add_control('bd_slogan_w',['label'=>__('پهنای شعار سال (پیکسل)','bidrubeh'),'description'=>__('عدد فارسی یا انگلیسی، مثلا ۱۵۰ یا 150','bidrubeh'),'section'=>'bidrubeh_brand','type'=>'text','input_attrs'=>['inputmode'=>'numeric','placeholder'=>'۱۵۰']]);
  $wp_customize->add_setting('bd_slogan_h',['default'=>60,'sanitize_callback'=>'bidrubeh_sanitize_num','transport'=>'refresh']);
  $wp_customize->add_control('bd_slogan_h',['label'=>__('ارتفاع شعار سال (پیکسل)','bidrubeh'),'description'=>__('عدد فارسی یا انگلیسی، مثلا ۶۰ یا 60','bidrubeh'),'section'=>'bidrubeh_brand','type'=>'text','input_attrs'=>['inputmode'=>'numeric','placeholder'=>'۶۰']]);
  $wp_customize->add_section('bidrubeh_city',['title'=>__('تنظیمات شهرداری','bidrubeh'),'priority'=>30]);
  $fields=[
    'bd_phone'=>['label'=>__('تلفن','bidrubeh'),'def'=>'061-00000000'],
    'bd_email'=>['label'=>__('ایمیل','bidrubeh'),'def'=>'info@bidrubeh.ir'],
    'bd_address'=>['label'=>__('نشانی','bidrubeh'),'def'=>'خوزستان، بیدروبه، ساختمان شهرداری مرکزی'],
    'bd_hero_title'=>['label'=>__('تیتر هیرو','bidrubeh'),'def'=>'شهرداری بیدروبه؛ شهر مشارکت، خدمت و پیشرفت'],
    'bd_hero_sub'=>['label'=>__('زیرتیتر هیرو','bidrubeh'),'def'=>'پرتال رسمی اطلاع‌رسانی، خدمات الکترونیک و اخبار مدیریت شهری بیدروبه'],
    'bd_population'=>['label'=>__('جمعیت','bidrubeh'),'def'=>'۲۵٬۰۰۰+'],
    'bd_area'=>['label'=>__('وسعت شهر','bidrubeh'),'def'=>'۱۸ کیلومتر مربع'],
    'bd_hotline'=>['label'=>__('سامانه ۱۳۷','bidrubeh'),'def'=>'۱۳۷'],
    'bd_stat3_val'=>['label'=>__('آمار ۳ — عدد','bidrubeh'),'def'=>'۲۴ ساعته'],
    'bd_stat3_label'=>['label'=>__('آمار ۳ — برچسب','bidrubeh'),'def'=>'پاسخگویی ۱۳۷'],
    'bd_stat4_val'=>['label'=>__('آمار ۴ — عدد','bidrubeh'),'def'=>'۹۰٪'],
    'bd_stat4_label'=>['label'=>__('آمار ۴ — برچسب','bidrubeh'),'def'=>'شاخص رضایت'],
  ];
  foreach($fields as $key=>$f){
    $wp_customize->add_setting($key,['default'=>$f['def'],'sanitize_callback'=>'sanitize_text_field']);
    $wp_customize->add_control($key,['label'=>$f['label'],'section'=>'bidrubeh_city','type'=>'text']);
  }
  $wp_customize->add_setting('bd_notice_cat',['default'=>'etelaeieh','sanitize_callback'=>'sanitize_text_field']);
  $wp_customize->add_control('bd_notice_cat',['label'=>__('دسته اطلاعیه‌ها (نامک)','bidrubeh'),'description'=>__('نامک دسته‌ای که اطلاعیه‌ها از آن خوانده می‌شود، مثلا etelaeieh','bidrubeh'),'section'=>'bidrubeh_city','type'=>'text']);
  $wp_customize->add_setting('bd_notice_count',['default'=>5,'sanitize_callback'=>'bidrubeh_sanitize_num']);
  $wp_customize->add_control('bd_notice_count',['label'=>__('تعداد اطلاعیه‌ها','bidrubeh'),'description'=>__('عدد فارسی یا انگلیسی، مثلا ۵ یا 5','bidrubeh'),'section'=>'bidrubeh_city','type'=>'text','input_attrs'=>['inputmode'=>'numeric','placeholder'=>'۵']]);
  $wp_customize->add_setting('bd_slider_count',['default'=>5,'sanitize_callback'=>'bidrubeh_sanitize_num']);
  $wp_customize->add_control('bd_slider_count',['label'=>__('تعداد اسلایدها','bidrubeh'),'description'=>__('عدد فارسی یا انگلیسی، مثلا ۵ یا 5','bidrubeh'),'section'=>'bidrubeh_city','type'=>'text','input_attrs'=>['inputmode'=>'numeric','placeholder'=>'۵']]);
  $wp_customize->add_setting('bd_slider_filter',['default'=>'','sanitize_callback'=>'sanitize_text_field']);
  $wp_customize->add_control('bd_slider_filter',['label'=>__('فیلتر متن اسلایدر','bidrubeh'),'description'=>__('واژه‌ها با کاما جدا شود، مثلا آزمون,تست. خبرهایی که تیترشان این واژه‌ها را داشته باشد در اسلایدر نمایش داده نمی‌شود. خالی = بدون فیلتر.','bidrubeh'),'section'=>'bidrubeh_city','type'=>'text']);
  $wp_customize->add_setting('bd_slider_speed',['default'=>5,'sanitize_callback'=>'bidrubeh_sanitize_num']);
  $wp_customize->add_control('bd_slider_speed',['label'=>__('سرعت اسلایدر (ثانیه)','bidrubeh'),'description'=>__('عدد فارسی یا انگلیسی، مثلا ۵ یا 5. صفر = توقف خودکار.','bidrubeh'),'section'=>'bidrubeh_city','type'=>'text','input_attrs'=>['inputmode'=>'numeric','placeholder'=>'۵']]);
  $wp_customize->add_setting('bd_photo_cat',['default'=>'gozaresh-tasviri','sanitize_callback'=>'sanitize_text_field']);
  $wp_customize->add_control('bd_photo_cat',['label'=>__('دسته گزارش تصویری (نامک)','bidrubeh'),'description'=>__('نامک دسته گزارش‌های تصویری، مثلا gozaresh-tasviri','bidrubeh'),'section'=>'bidrubeh_city','type'=>'text']);
  $wp_customize->add_setting('bd_photo_count',['default'=>3,'sanitize_callback'=>'bidrubeh_sanitize_num']);
  $wp_customize->add_control('bd_photo_count',['label'=>__('تعداد گزارش تصویری','bidrubeh'),'description'=>__('عدد فارسی یا انگلیسی، مثلا ۴ یا 4','bidrubeh'),'section'=>'bidrubeh_city','type'=>'text','input_attrs'=>['inputmode'=>'numeric','placeholder'=>'۴']]);
  $wp_customize->add_setting('bd_attract_cat',['default'=>'tourist-attractions','sanitize_callback'=>'sanitize_text_field']);
  $wp_customize->add_control('bd_attract_cat',['label'=>__('دسته جاذبه‌های گردشگری (نامک)','bidrubeh'),'description'=>__('نامک دسته جاذبه‌ها، مثلا tourist-attractions','bidrubeh'),'section'=>'bidrubeh_city','type'=>'text']);
  $wp_customize->add_section('bidrubeh_social',['title'=>__('شبکه‌های اجتماعی','bidrubeh'),'priority'=>31,'description'=>__('شناسه (آیدی)، شماره موبایل یا لینک کامل را وارد کنید. خالی = عدم نمایش. مثال: bidrubeh_admin یا 09123456789 یا https://eitaa.com/bidrubeh_admin','bidrubeh')]);
  $soc=[
    'bd_eitaa'=>__('ایتا (Eitaa)','bidrubeh'),
    'bd_bale'=>__('بله (Bale)','bidrubeh'),
    'bd_rubika'=>__('روبیکا (Rubika)','bidrubeh'),
    'bd_whatsapp'=>__('واتساپ (WhatsApp)','bidrubeh'),
    'bd_telegram'=>__('تلگرام (Telegram)','bidrubeh'),
    'bd_instagram'=>__('اینستاگرام (Instagram)','bidrubeh'),
  ];
  foreach($soc as $key=>$label){
    $wp_customize->add_setting($key,['default'=>'','sanitize_callback'=>'sanitize_text_field','transport'=>'refresh']);
    $wp_customize->add_control($key,['label'=>$label,'section'=>'bidrubeh_social','type'=>'text']);
  }
  $wp_customize->add_section('bidrubeh_zones',['title'=>__('نواحی و محلات','bidrubeh'),'priority'=>32,'description'=>__('عنوان خالی = عدم نمایش آن ناحیه. هر تعداد که پر کنید در صفحه اصلی نمایش داده می‌شود.','bidrubeh')]);
  $zone_defs=[
    1=>['t'=>'ناحیه ۱ — مرکز شهر','d'=>'نشانی: خیابان اصلی، ساختمان شهرداری مرکزی | تلفن: 061-00000000'],
    2=>['t'=>'ناحیه ۲ — محلات شرقی','d'=>'خدمات عمرانی، فضای سبز و جمع‌آوری پسماند'],
    3=>['t'=>'ناحیه ۳ — محلات غربی','d'=>'بهسازی معابر، روشنایی و زیباسازی'],
    4=>['t'=>'ناحیه ۴ — حاشیه و روستاهای الحاقی','d'=>'آبرسانی، راه روستایی و خدمات اجتماعی'],
    5=>['t'=>'','d'=>''],6=>['t'=>'','d'=>''],7=>['t'=>'','d'=>''],8=>['t'=>'','d'=>''],
  ];
  foreach($zone_defs as $i=>$d){
    $wp_customize->add_setting('bd_zone'.$i.'_title',['default'=>$d['t'],'sanitize_callback'=>'sanitize_text_field','transport'=>'refresh']);
    $wp_customize->add_control('bd_zone'.$i.'_title',['label'=>sprintf(__('ناحیه %s — عنوان','bidrubeh'),bidrubeh_fa_digits($i)),'section'=>'bidrubeh_zones','type'=>'text']);
    $wp_customize->add_setting('bd_zone'.$i.'_desc',['default'=>$d['d'],'sanitize_callback'=>'sanitize_text_field','transport'=>'refresh']);
    $wp_customize->add_control('bd_zone'.$i.'_desc',['label'=>sprintf(__('ناحیه %s — توضیح','bidrubeh'),bidrubeh_fa_digits($i)),'section'=>'bidrubeh_zones','type'=>'textarea']);
  }
  $wp_customize->add_section('bidrubeh_info',['title'=>__('کارت‌های اطلاعاتی','bidrubeh'),'priority'=>33,'description'=>__('عنوان خالی = عدم نمایش آن کارت. هر کارت ۳ آمار (عدد + برچسب) دارد.','bidrubeh')]);
  $info_defs=[
    1=>['t'=>'اطلاعات شهری','d'=>'مدیریت یکپارچه خدمات، عمران محلات و نگهداشت معابر و پارک‌ها.','n'=>[['۴','ناحیه خدماتی'],['۱۲','پارک و بوستان'],['۳۰+','پروژه فعال']]],
    2=>['t'=>'فرهنگ و اجتماع','d'=>'برنامه‌های فرهنگی، ورزشی و آموزشی برای خانواده‌ها و جوانان.','n'=>[['۶','فرهنگسرا'],['۲۰+','رویداد سالانه'],['۸','زمین ورزشی']]],
    3=>['t'=>'محیط زیست','d'=>'توسعه فضای سبز، تفکیک پسماند و هوای پاک‌تر برای بیدروبه.','n'=>[['۹۰٪','تفکیک مبدأ'],['۱۵','هزار اصله درخت'],['۱۰۰٪','روشنایی معابر اصلی']]],
    4=>['t'=>'','d'=>'','n'=>[['','',''],['','',''],['','','']]],
    5=>['t'=>'','d'=>'','n'=>[['','',''],['','',''],['','','']]],
    6=>['t'=>'','d'=>'','n'=>[['','',''],['','',''],['','','']]],
  ];
  foreach($info_defs as $i=>$d){
    $wp_customize->add_setting('bd_info'.$i.'_title',['default'=>$d['t'],'sanitize_callback'=>'sanitize_text_field','transport'=>'refresh']);
    $wp_customize->add_control('bd_info'.$i.'_title',['label'=>sprintf(__('کارت %s — عنوان','bidrubeh'),bidrubeh_fa_digits($i)),'section'=>'bidrubeh_info','type'=>'text']);
    $wp_customize->add_setting('bd_info'.$i.'_desc',['default'=>$d['d'],'sanitize_callback'=>'sanitize_text_field','transport'=>'refresh']);
    $wp_customize->add_control('bd_info'.$i.'_desc',['label'=>sprintf(__('کارت %s — توضیح','bidrubeh'),bidrubeh_fa_digits($i)),'section'=>'bidrubeh_info','type'=>'textarea']);
    foreach([1,2,3] as $k){
      $wp_customize->add_setting('bd_info'.$i.'_n'.$k.'v',['default'=>$d['n'][$k-1][0],'sanitize_callback'=>'sanitize_text_field','transport'=>'refresh']);
      $wp_customize->add_control('bd_info'.$i.'_n'.$k.'v',['label'=>sprintf(__('کارت %s — آمار %s (عدد)','bidrubeh'),bidrubeh_fa_digits($i),bidrubeh_fa_digits($k)),'section'=>'bidrubeh_info','type'=>'text']);
      $wp_customize->add_setting('bd_info'.$i.'_n'.$k.'l',['default'=>$d['n'][$k-1][1],'sanitize_callback'=>'sanitize_text_field','transport'=>'refresh']);
      $wp_customize->add_control('bd_info'.$i.'_n'.$k.'l',['label'=>sprintf(__('کارت %s — آمار %s (برچسب)','bidrubeh'),bidrubeh_fa_digits($i),bidrubeh_fa_digits($k)),'section'=>'bidrubeh_info','type'=>'text']);
    }
  }
  $wp_customize->add_section('bidrubeh_faq',['title'=>__('سوالات متداول','bidrubeh'),'priority'=>34,'description'=>__('سوال خالی = عدم نمایش آن مورد. روی سوال در سایت کلیک کنید تا پاسخ باز شود.','bidrubeh')]);
  $faq_defs=[
    1=>['q'=>'ساعات کاری شهرداری بیدروبه چیست؟','a'=>'شنبه تا چهارشنبه ۷:۳۰ تا ۱۴:۳۰. سامانه ۱۳۷ به‌صورت ۲۴ ساعته پاسخگوست.'],
    2=>['q'=>'چگونه عوارض نوسازی را پرداخت کنم؟','a'=>'از طریق میز خدمت الکترونیک پرتال یا مراجعه حضوری به ساختمان شهرداری مرکزی.'],
    3=>['q'=>'چگونه درخواست عمرانی ثبت کنم؟','a'=>'از صفحه «تماس با ما» فرم را تکمیل کنید؛ پس از خوانده شدن توسط مدیر می‌توانید دوباره پیام بفرستید.'],
    4=>['q'=>'برنامه جمع‌آوری پسماند خشک چیست؟','a'=>'برنامه هفتگی در بخش اطلاعیه‌ها منتشر می‌شود؛ تفکیک مبدأ را رعایت کنید.'],
    5=>['q'=>'','a'=>''],6=>['q'=>'','a'=>''],7=>['q'=>'','a'=>''],8=>['q'=>'','a'=>''],9=>['q'=>'','a'=>''],10=>['q'=>'','a'=>''],
  ];
  foreach($faq_defs as $i=>$d){
    $wp_customize->add_setting('bd_faq'.$i.'_q',['default'=>$d['q'],'sanitize_callback'=>'sanitize_text_field','transport'=>'refresh']);
    $wp_customize->add_control('bd_faq'.$i.'_q',['label'=>sprintf(__('سوال %s','bidrubeh'),bidrubeh_fa_digits($i)),'section'=>'bidrubeh_faq','type'=>'text']);
    $wp_customize->add_setting('bd_faq'.$i.'_a',['default'=>$d['a'],'sanitize_callback'=>'sanitize_textarea_field','transport'=>'refresh']);
    $wp_customize->add_control('bd_faq'.$i.'_a',['label'=>sprintf(__('پاسخ %s','bidrubeh'),bidrubeh_fa_digits($i)),'section'=>'bidrubeh_faq','type'=>'textarea']);
  }
  $wp_customize->add_section('bidrubeh_bars',['title'=>__('نوارهای پیشرفت','bidrubeh'),'priority'=>35,'description'=>__('عنوان و درصد هر نوار (۰ تا ۱۰۰).','bidrubeh')]);
  $bar_defs=[1=>['t'=>'رضایت از خدمات','p'=>88],2=>['t'=>'پاسخگویی ۱۳۷','p'=>92],3=>['t'=>'توسعه فضای سبز','p'=>76],4=>['t'=>'خدمات غیرحضوری','p'=>84]];
  foreach($bar_defs as $i=>$d){
    $wp_customize->add_setting('bd_bar'.$i.'_title',['default'=>$d['t'],'sanitize_callback'=>'sanitize_text_field','transport'=>'refresh']);
    $wp_customize->add_control('bd_bar'.$i.'_title',['label'=>sprintf(__('عنوان نوار %s','bidrubeh'),bidrubeh_fa_digits($i)),'section'=>'bidrubeh_bars','type'=>'text']);
    $wp_customize->add_setting('bd_bar'.$i.'_pct',['default'=>$d['p'],'sanitize_callback'=>'bidrubeh_sanitize_num','transport'=>'refresh']);
    $wp_customize->add_control('bd_bar'.$i.'_pct',['label'=>sprintf(__('درصد نوار %s (۰–۱۰۰)','bidrubeh'),bidrubeh_fa_digits($i)),'description'=>__('عدد فارسی یا انگلیسی، مثلا ۸۸ یا 88','bidrubeh'),'section'=>'bidrubeh_bars','type'=>'text','input_attrs'=>['inputmode'=>'numeric','placeholder'=>'۸۸']]);
  }
  $wp_customize->add_section('bidrubeh_about',['title'=>__('صفحه درباره ما','bidrubeh'),'priority'=>36,'description'=>__('عنوان خالی = عدم نمایش آن مورد.','bidrubeh')]);
  $anum=[
    'bd_about_num3_val'=>['label'=>__('آمار ۳ — عدد','bidrubeh'),'def'=>'۱۲'],
    'bd_about_num3_label'=>['label'=>__('آمار ۳ — برچسب','bidrubeh'),'def'=>'پارک و بوستان'],
    'bd_about_num4_val'=>['label'=>__('آمار ۴ — عدد','bidrubeh'),'def'=>'۳۰+'],
    'bd_about_num4_label'=>['label'=>__('آمار ۴ — برچسب','bidrubeh'),'def'=>'پروژه فعال'],
  ];
  foreach($anum as $key=>$f){
    $wp_customize->add_setting($key,['default'=>$f['def'],'sanitize_callback'=>'sanitize_text_field','transport'=>'refresh']);
    $wp_customize->add_control($key,['label'=>$f['label'],'section'=>'bidrubeh_about','type'=>'text']);
  }
  $mission_defs=[
    1=>['t'=>'🎯 مأموریت ما','d'=>'ارائه خدمات شهری سریع، شفاف و غیرحضوری؛ نگهداشت معابر، فضای سبز و ارتقای کیفیت زندگی شهروندان بیدروبه.'],
    2=>['t'=>'👁️ چشم‌انداز','d'=>'بیدروبه؛ شهری تمیز، ایمن و سرزنده با مشارکت فعال شهروندان و توسعه متوازن محلات در افق ۱۴۱۰.'],
    3=>['t'=>'💎 ارزش‌ها','d'=>'شفافیت، پاسخگویی، عدالت در توزیع خدمات، احترام به شهروند و حفاظت از محیط زیست.'],
    4=>['t'=>'','d'=>''],
  ];
  foreach($mission_defs as $i=>$d){
    $wp_customize->add_setting('bd_mission'.$i.'_title',['default'=>$d['t'],'sanitize_callback'=>'sanitize_text_field','transport'=>'refresh']);
    $wp_customize->add_control('bd_mission'.$i.'_title',['label'=>sprintf(__('مأموریت %s — عنوان','bidrubeh'),bidrubeh_fa_digits($i)),'section'=>'bidrubeh_about','type'=>'text']);
    $wp_customize->add_setting('bd_mission'.$i.'_desc',['default'=>$d['d'],'sanitize_callback'=>'sanitize_text_field','transport'=>'refresh']);
    $wp_customize->add_control('bd_mission'.$i.'_desc',['label'=>sprintf(__('مأموریت %s — توضیح','bidrubeh'),bidrubeh_fa_digits($i)),'section'=>'bidrubeh_about','type'=>'textarea']);
  }
  $tl_defs=[
    1=>['t'=>'تأسیس شهرداری','d'=>'آغاز خدمات‌رسانی رسمی به شهروندان بیدروبه'],
    2=>['t'=>'توسعه محلات','d'=>'بهسازی معابر، روشنایی و فضای سبز در ۴ ناحیه خدماتی'],
    3=>['t'=>'خدمات الکترونیک','d'=>'راه‌اندازی پرتال، سامانه ۱۳۷ و میز خدمت غیرحضوری'],
    4=>['t'=>'امروز','d'=>'شفافیت، مشارکت شهروندان و توسعه پایدار شهری'],
    5=>['t'=>'','d'=>''],6=>['t'=>'','d'=>''],
  ];
  foreach($tl_defs as $i=>$d){
    $wp_customize->add_setting('bd_tl'.$i.'_title',['default'=>$d['t'],'sanitize_callback'=>'sanitize_text_field','transport'=>'refresh']);
    $wp_customize->add_control('bd_tl'.$i.'_title',['label'=>sprintf(__('مسیر %s — عنوان','bidrubeh'),bidrubeh_fa_digits($i)),'section'=>'bidrubeh_about','type'=>'text']);
    $wp_customize->add_setting('bd_tl'.$i.'_desc',['default'=>$d['d'],'sanitize_callback'=>'sanitize_text_field','transport'=>'refresh']);
    $wp_customize->add_control('bd_tl'.$i.'_desc',['label'=>sprintf(__('مسیر %s — توضیح','bidrubeh'),bidrubeh_fa_digits($i)),'section'=>'bidrubeh_about','type'=>'textarea']);
  }
  $wp_customize->add_section('bidrubeh_footer',['title'=>__('پیوندهای فوتر','bidrubeh'),'priority'=>37,'description'=>__('عنوان‌ها و پیوندهای ستون‌های پایین صفحه. عنوان خالی = عدم نمایش آن مورد.','bidrubeh')]);
  $wp_customize->add_setting('bd_footer1_title',['default'=>'پیوندها','sanitize_callback'=>'sanitize_text_field','transport'=>'refresh']);
  $wp_customize->add_control('bd_footer1_title',['label'=>__('عنوان ستون پیوندها','bidrubeh'),'section'=>'bidrubeh_footer','type'=>'text']);
  $wp_customize->add_setting('bd_footer2_title',['default'=>'دسترسی سریع','sanitize_callback'=>'sanitize_text_field','transport'=>'refresh']);
  $wp_customize->add_control('bd_footer2_title',['label'=>__('عنوان ستون دسترسی سریع','bidrubeh'),'section'=>'bidrubeh_footer','type'=>'text']);
  $flink_defs=[
    1=>['t'=>'استانداری خوزستان','u'=>'https://www.ostan-khz.ir'],
    2=>['t'=>'پایگاه اطلاع‌رسانی دولت','u'=>'https://dolat.ir'],
    3=>['t'=>'دفتر مقام معظم رهبری','u'=>'https://www.leader.ir'],
    4=>['t'=>'سامانه ملی خدمات دولت','u'=>'https://khadamat.mardom.ir'],
    5=>['t'=>'شورای اسلامی شهر','u'=>''],
    6=>['t'=>'سامانه ۱۳۷','u'=>''],
  ];
  foreach($flink_defs as $i=>$d){
    $wp_customize->add_setting('bd_flink'.$i.'_title',['default'=>$d['t'],'sanitize_callback'=>'sanitize_text_field','transport'=>'refresh']);
    $wp_customize->add_control('bd_flink'.$i.'_title',['label'=>sprintf(__('پیوند %s — عنوان','bidrubeh'),bidrubeh_fa_digits($i)),'section'=>'bidrubeh_footer','type'=>'text']);
    $wp_customize->add_setting('bd_flink'.$i.'_url',['default'=>$d['u'],'sanitize_callback'=>'esc_url_raw','transport'=>'refresh']);
    $wp_customize->add_control('bd_flink'.$i.'_url',['label'=>sprintf(__('پیوند %s — نشانی','bidrubeh'),bidrubeh_fa_digits($i)),'section'=>'bidrubeh_footer','type'=>'url']);
  }
});
function bidrubeh_footer_links(){
  $defs=[1=>['t'=>'استانداری خوزستان','u'=>'https://www.ostan-khz.ir'],2=>['t'=>'پایگاه اطلاع‌رسانی دولت','u'=>'https://dolat.ir'],3=>['t'=>'دفتر مقام معظم رهبری','u'=>'https://www.leader.ir'],4=>['t'=>'سامانه ملی خدمات دولت','u'=>'https://khadamat.mardom.ir'],5=>['t'=>'شورای اسلامی شهر','u'=>''],6=>['t'=>'سامانه ۱۳۷','u'=>'']];
  $out=[];
  foreach($defs as $i=>$d){
    $t=trim((string)get_theme_mod('bd_flink'.$i.'_title',$d['t']));
    if($t==='') continue;
    $u=trim((string)get_theme_mod('bd_flink'.$i.'_url',$d['u']));
    $out[]=['t'=>$t,'u'=>$u===''?'#':$u];
  }
  return $out;
}
function bidrubeh_faqs(){
  $defs=[
    1=>['q'=>'ساعات کاری شهرداری بیدروبه چیست؟','a'=>'شنبه تا چهارشنبه ۷:۳۰ تا ۱۴:۳۰. سامانه ۱۳۷ به‌صورت ۲۴ ساعته پاسخگوست.'],
    2=>['q'=>'چگونه عوارض نوسازی را پرداخت کنم؟','a'=>'از طریق میز خدمت الکترونیک پرتال یا مراجعه حضوری به ساختمان شهرداری مرکزی.'],
    3=>['q'=>'چگونه درخواست عمرانی ثبت کنم؟','a'=>'از صفحه «تماس با ما» فرم را تکمیل کنید؛ پس از خوانده شدن توسط مدیر می‌توانید دوباره پیام بفرستید.'],
    4=>['q'=>'برنامه جمع‌آوری پسماند خشک چیست؟','a'=>'برنامه هفتگی در بخش اطلاعیه‌ها منتشر می‌شود؛ تفکیک مبدأ را رعایت کنید.'],
    5=>['q'=>'','a'=>''],6=>['q'=>'','a'=>''],7=>['q'=>'','a'=>''],8=>['q'=>'','a'=>''],9=>['q'=>'','a'=>''],10=>['q'=>'','a'=>''],
  ];
  $out=[];
  foreach($defs as $i=>$d){
    $q=trim((string)get_theme_mod('bd_faq'.$i.'_q',$d['q']));
    if($q==='') continue;
    $out[]=['q'=>$q,'a'=>trim((string)get_theme_mod('bd_faq'.$i.'_a',$d['a']))];
  }
  return $out;
}
function bidrubeh_bars(){
  $defs=[1=>['t'=>'رضایت از خدمات','p'=>88],2=>['t'=>'پاسخگویی ۱۳۷','p'=>92],3=>['t'=>'توسعه فضای سبز','p'=>76],4=>['t'=>'خدمات غیرحضوری','p'=>84]];
  $out=[];
  foreach($defs as $i=>$d){
    $t=trim((string)get_theme_mod('bd_bar'.$i.'_title',$d['t']));
    $p=(int)get_theme_mod('bd_bar'.$i.'_pct',$d['p']);
    if($p<0) $p=0; if($p>100) $p=100;
    if($t==='') continue;
    $out[]=['t'=>$t,'p'=>$p];
  }
  return $out;
}
function bidrubeh_zones(){
  $defs=[
    1=>['t'=>'ناحیه ۱ — مرکز شهر','d'=>'نشانی: خیابان اصلی، ساختمان شهرداری مرکزی | تلفن: 061-00000000'],
    2=>['t'=>'ناحیه ۲ — محلات شرقی','d'=>'خدمات عمرانی، فضای سبز و جمع‌آوری پسماند'],
    3=>['t'=>'ناحیه ۳ — محلات غربی','d'=>'بهسازی معابر، روشنایی و زیباسازی'],
    4=>['t'=>'ناحیه ۴ — حاشیه و روستاهای الحاقی','d'=>'آبرسانی، راه روستایی و خدمات اجتماعی'],
    5=>['t'=>'','d'=>''],6=>['t'=>'','d'=>''],7=>['t'=>'','d'=>''],8=>['t'=>'','d'=>''],
  ];
  $out=[];
  foreach($defs as $i=>$d){
    $t=trim((string)get_theme_mod('bd_zone'.$i.'_title',$d['t']));
    $desc=trim((string)get_theme_mod('bd_zone'.$i.'_desc',$d['d']));
    if($t==='') continue;
    $desc=str_replace('061-00000000',(string)get_theme_mod('bd_phone','061-00000000'),$desc);
    $out[]=['t'=>$t,'d'=>$desc];
  }
  return $out;
}
function bidrubeh_info_cards(){
  $defs=[
    1=>['t'=>'اطلاعات شهری','d'=>'مدیریت یکپارچه خدمات، عمران محلات و نگهداشت معابر و پارک‌ها.','n'=>[['۴','ناحیه خدماتی'],['۱۲','پارک و بوستان'],['۳۰+','پروژه فعال']]],
    2=>['t'=>'فرهنگ و اجتماع','d'=>'برنامه‌های فرهنگی، ورزشی و آموزشی برای خانواده‌ها و جوانان.','n'=>[['۶','فرهنگسرا'],['۲۰+','رویداد سالانه'],['۸','زمین ورزشی']]],
    3=>['t'=>'محیط زیست','d'=>'توسعه فضای سبز، تفکیک پسماند و هوای پاک‌تر برای بیدروبه.','n'=>[['۹۰٪','تفکیک مبدأ'],['۱۵','هزار اصله درخت'],['۱۰۰٪','روشنایی معابر اصلی']]],
    4=>['t'=>'','d'=>'','n'=>[['','',''],['','',''],['','','']]],
    5=>['t'=>'','d'=>'','n'=>[['','',''],['','',''],['','','']]],
    6=>['t'=>'','d'=>'','n'=>[['','',''],['','',''],['','','']]],
  ];
  $out=[];
  foreach($defs as $i=>$d){
    $t=trim((string)get_theme_mod('bd_info'.$i.'_title',$d['t']));
    if($t==='') continue;
    $desc=trim((string)get_theme_mod('bd_info'.$i.'_desc',$d['d']));
    $nums=[];
    foreach([1,2,3] as $k){
      $v=trim((string)get_theme_mod('bd_info'.$i.'_n'.$k.'v',$d['n'][$k-1][0]));
      $l=trim((string)get_theme_mod('bd_info'.$i.'_n'.$k.'l',$d['n'][$k-1][1]));
      if($v===''&&$l==='') continue;
      $nums[]=['v'=>$v,'l'=>$l];
    }
    $out[]=['t'=>$t,'d'=>$desc,'n'=>$nums];
  }
  return $out;
}
function bidrubeh_missions(){
  $defs=[
    1=>['t'=>'🎯 مأموریت ما','d'=>'ارائه خدمات شهری سریع، شفاف و غیرحضوری؛ نگهداشت معابر، فضای سبز و ارتقای کیفیت زندگی شهروندان بیدروبه.'],
    2=>['t'=>'👁️ چشم‌انداز','d'=>'بیدروبه؛ شهری تمیز، ایمن و سرزنده با مشارکت فعال شهروندان و توسعه متوازن محلات در افق ۱۴۱۰.'],
    3=>['t'=>'💎 ارزش‌ها','d'=>'شفافیت، پاسخگویی، عدالت در توزیع خدمات، احترام به شهروند و حفاظت از محیط زیست.'],
    4=>['t'=>'','d'=>''],
  ];
  $out=[];
  foreach($defs as $i=>$d){
    $t=trim((string)get_theme_mod('bd_mission'.$i.'_title',$d['t']));
    if($t==='') continue;
    $out[]=['t'=>$t,'d'=>trim((string)get_theme_mod('bd_mission'.$i.'_desc',$d['d']))];
  }
  return $out;
}
function bidrubeh_timeline(){
  $defs=[
    1=>['t'=>'تأسیس شهرداری','d'=>'آغاز خدمات‌رسانی رسمی به شهروندان بیدروبه'],
    2=>['t'=>'توسعه محلات','d'=>'بهسازی معابر، روشنایی و فضای سبز در ۴ ناحیه خدماتی'],
    3=>['t'=>'خدمات الکترونیک','d'=>'راه‌اندازی پرتال، سامانه ۱۳۷ و میز خدمت غیرحضوری'],
    4=>['t'=>'امروز','d'=>'شفافیت، مشارکت شهروندان و توسعه پایدار شهری'],
    5=>['t'=>'','d'=>''],6=>['t'=>'','d'=>''],
  ];
  $out=[];
  foreach($defs as $i=>$d){
    $t=trim((string)get_theme_mod('bd_tl'.$i.'_title',$d['t']));
    if($t==='') continue;
    $out[]=['t'=>$t,'d'=>trim((string)get_theme_mod('bd_tl'.$i.'_desc',$d['d']))];
  }
  return $out;
}
function bidrubeh_comments_label($post_id=null){
  $n=(int)get_comments_number($post_id);
  if($n<1) return 'بدون دیدگاه';
  return sprintf('%s دیدگاه',bidrubeh_fa_digits($n));
}
function bidrubeh_news_count(){
  $c=wp_count_posts('post');
  return bidrubeh_fa_digits(isset($c->publish)?(int)$c->publish:0);
}
add_filter('wp_list_categories',function($html){
  return preg_replace_callback('/\((\d+)\)/',function($m){
    return '('.bidrubeh_fa_digits($m[1]).')';
  },$html);
});
function bidrubeh_notice_query_args(){
  $cat=trim((string)get_theme_mod('bd_notice_cat','etelaeieh'));
  $count=(int)get_theme_mod('bd_notice_count',5);
  if($count<1) $count=5;
  if($count>10) $count=10;
  $args=['posts_per_page'=>$count,'ignore_sticky_posts'=>1,'no_found_rows'=>true];
  if($cat==='') return array_merge($args,['post__in'=>[0]]);
  $term=get_category_by_slug($cat);
  if(!$term) return array_merge($args,['post__in'=>[0]]);
  $args['cat']=(int)$term->term_id;
  return $args;
}
function bidrubeh_photo_query_args(){
  $cat=trim((string)get_theme_mod('bd_photo_cat','gozaresh-tasviri'));
  $count=(int)get_theme_mod('bd_photo_count',3);
  if($count<1) $count=3;
  if($count>10) $count=10;
  $args=['posts_per_page'=>$count,'ignore_sticky_posts'=>1,'no_found_rows'=>true];
  if($cat!=='') $args['category_name']=$cat;
  return $args;
}
add_action('add_meta_boxes',function(){
  add_meta_box('bidrubeh_slider',__('اسلایدر صفحه اصلی','bidrubeh'),function($post){
    wp_nonce_field('bidrubeh_slider_meta','bidrubeh_slider_nonce');
    $v=get_post_meta($post->ID,'bd_in_slider',true);
    echo '<label><input type="checkbox" name="bd_in_slider" value="1"'.checked($v,'1',false).'> '.esc_html__('نمایش این خبر در اسلایدر','bidrubeh').'</label>';
  },'post','side','default');
});
add_action('save_post_post',function($post_id){
  if(!isset($_POST['bidrubeh_slider_nonce'])||!wp_verify_nonce($_POST['bidrubeh_slider_nonce'],'bidrubeh_slider_meta')) return;
  if(defined('DOING_AUTOSAVE')&&DOING_AUTOSAVE) return;
  if(!current_user_can('edit_post',$post_id)) return;
  if(!empty($_POST['bd_in_slider'])) update_post_meta($post_id,'bd_in_slider','1');
  else delete_post_meta($post_id,'bd_in_slider');
});
add_action('restrict_manage_posts',function($post_type,$which){
  if($post_type!=='post'||$which!=='top') return;
  $sel=isset($_GET['bd_slider'])?sanitize_key($_GET['bd_slider']):'';
  echo '<select name="bd_slider"><option value="">'.esc_html__('همه — اسلایدر','bidrubeh').'</option>';
  echo '<option value="yes"'.selected($sel,'yes',false).'>'.esc_html__('در اسلایدر','bidrubeh').'</option>';
  echo '<option value="no"'.selected($sel,'no',false).'>'.esc_html__('خارج از اسلایدر','bidrubeh').'</option></select>';
},10,2);
add_action('pre_get_posts',function($q){
  if(!is_admin()||!$q->is_main_query()) return;
  global $pagenow;
  if($pagenow!=='edit.php') return;
  $pt=$q->get('post_type');
  if($pt===''||$pt===null) $pt='post';
  if($pt!=='post') return;
  $sel=isset($_GET['bd_slider'])?sanitize_key($_GET['bd_slider']):'';
  if($sel!=='yes'&&$sel!=='no') return;
  $mq=(array)$q->get('meta_query');
  if($sel==='yes') $mq[]=array('key'=>'bd_in_slider','value'=>'1');
  else $mq[]=array('relation'=>'OR',array('key'=>'bd_in_slider','compare'=>'NOT EXISTS'),array('key'=>'bd_in_slider','value'=>'1','compare'=>'!='));
  $q->set('meta_query',$mq);
});
add_filter('manage_post_posts_columns',function($cols){
  $cols['bd_slider']=__('اسلایدر','bidrubeh');
  $cols['bd_comments']=__('دیدگاه‌ها','bidrubeh');
  $cols['bd_pings']=__('بازتاب‌ها','bidrubeh');
  return $cols;
});
add_action('manage_post_posts_custom_column',function($col,$id){
  if($col==='bd_slider'){
    if(get_post_meta($id,'bd_in_slider',true)==='1'){
      if(function_exists('bidrubeh_slider_is_blocked')&&bidrubeh_slider_is_blocked(get_post($id))) echo '⚠ '.esc_html__('مسدود با فیلتر متن','bidrubeh');
      else echo '✅';
    }
    else echo '—';
    return;
  }
  if($col==='bd_comments'){
    echo get_post($id)->comment_status==='open'?'✅ '.esc_html__('باز','bidrubeh'):'❌ '.esc_html__('بسته','bidrubeh');
    return;
  }
  if($col==='bd_pings'){
    echo get_post($id)->ping_status==='open'?'✅ '.esc_html__('باز','bidrubeh'):'❌ '.esc_html__('بسته','bidrubeh');
    return;
  }
},10,2);
add_filter('get_default_comment_status',function($status,$post_type,$comment_type){
  if($post_type==='post') return 'closed';
  return $status;
},10,3);
function bidrubeh_latest_news_exclude(){
  $ex=[];
  $defs=['bd_photo_cat'=>'gozaresh-tasviri','bd_notice_cat'=>'etelaeieh'];
  foreach($defs as $key=>$def){
    $slug=trim((string)get_theme_mod($key,$def));
    if($slug==='') continue;
    $t=get_category_by_slug($slug);
    if($t) $ex[]=(int)$t->term_id;
  }
  $tt=bidrubeh_tourism_term();
  if($tt) $ex[]=(int)$tt->term_id;
  return $ex;
}
function bidrubeh_slider_exclude(){
  $ex=[];
  $pslug=trim((string)get_theme_mod('bd_photo_cat','gozaresh-tasviri'));
  if($pslug!==''){ $pt=get_category_by_slug($pslug); if($pt) $ex[]=(int)$pt->term_id; }
  return $ex;
}
function bidrubeh_slider_speed(){
  $s=(int)get_theme_mod('bd_slider_speed',5);
  if($s<0) $s=0; if($s>60) $s=60;
  return (int)apply_filters('bidrubeh_slider_speed',$s);
}
function bidrubeh_slider_filter_words(){
  $raw=trim((string)get_theme_mod('bd_slider_filter',''));
  $words=$raw===''?[]:preg_split('/[،,]+/u',$raw);
  $words=array_values(array_filter(array_map('trim',(array)$words)));
  return (array)apply_filters('bidrubeh_slider_filter_words',$words);
}
function bidrubeh_slider_is_blocked($post){
  $blocked=false;
  $words=bidrubeh_slider_filter_words();
  if(!empty($words)){
    $title=$post instanceof WP_Post?$post->post_title:get_the_title($post);
    foreach($words as $w){ if($w!==''&&mb_stripos($title,$w)!==false){ $blocked=true; break; } }
  }
  return (bool)apply_filters('bidrubeh_slider_is_blocked',$blocked,$post,$words);
}
function bidrubeh_slider_posts($count=5){
  $count=max(1,min(10,(int)$count));
  $ex=bidrubeh_slider_exclude();
  $mq=new WP_Query(['posts_per_page'=>$count,'ignore_sticky_posts'=>1,'no_found_rows'=>true,
    'meta_query'=>[['key'=>'bd_in_slider','value'=>'1']],
    'category__not_in'=>$ex,'orderby'=>'date','order'=>'DESC']);
  $posts=[];
  foreach((array)$mq->posts as $p){ if(!bidrubeh_slider_is_blocked($p)) $posts[]=$p; if(count($posts)>=$count) break; }
  wp_reset_postdata();
  return array_slice($posts,0,$count);
}
function bidrubeh_tourism_term(){
  foreach(['جاذبه‌های گردشگری','جاذبه های گردشگری'] as $name){
    $t=get_term_by('name',$name,'category');
    if($t&&!is_wp_error($t)) return $t;
  }
  $slug=trim((string)get_theme_mod('bd_attract_cat','tourist-attractions'));
  if($slug!==''){ $t=get_category_by_slug($slug); if($t) return $t; }
  return null;
}
function bidrubeh_tourism_query_args(){
  $t=bidrubeh_tourism_term();
  $args=['posts_per_page'=>-1,'post_type'=>'post','post_status'=>'publish','ignore_sticky_posts'=>1,'no_found_rows'=>true,'orderby'=>'date','order'=>'DESC'];
  if($t) $args['cat']=(int)$t->term_id;
  return $args;
}
function bidrubeh_tourism_cards(){
  $args=bidrubeh_tourism_query_args();
  $args['posts_per_page']=20;
  $q=new WP_Query($args);
  if(!$q->have_posts()) return '';
  $posts=array_values($q->posts);
  wp_reset_postdata();
  shuffle($posts);
  $out='<div class="bd-tour-grid" id="bdTourGrid" data-speed="'.(int)bidrubeh_slider_speed().'" dir="rtl">';
  foreach($posts as $i=>$p){
    $link=get_permalink($p);
    $title=get_the_title($p);
    if(has_post_thumbnail($p->ID)) $thumb=get_the_post_thumbnail($p->ID,'medium',['class'=>'bd-tour-img']);
    else $thumb='<span class="bd-tour-img bd-tour-ph"></span>';
    $out.='<a class="bd-tour-item" href="'.esc_url($link).'" title="'.esc_attr($title).'"'.($i<4?'':' hidden').'>';
    $out.=$thumb;
    $out.='<span class="bd-tour-title">'.esc_html($title).'</span></a>';
  }
  $out.='</div>';
  return $out;
}
add_shortcode('tourism_gallery',function(){ return bidrubeh_tourism_cards(); });
add_filter('widget_posts_args',function($args){
  $tt=function_exists('bidrubeh_tourism_term')?bidrubeh_tourism_term():null;
  if($tt){
    $ex=isset($args['category__not_in'])?(array)$args['category__not_in']:[];
    $ex[]=(int)$tt->term_id;
    $args['category__not_in']=array_values(array_unique($ex));
  }
  return $args;
});
function bidrubeh_icon($name){
  $p=[
    'desk'=>'<rect x="3" y="4" width="18" height="12" rx="2"/><path d="M8 20h8M12 16v4"/>',
    'card'=>'<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 10h18"/>',
    'phone'=>'<path d="M5 4h4l2 5-3 2a12 12 0 0 0 5 5l2-3 5 2v4a2 2 0 0 1-2 2A16 16 0 0 1 3 6a2 2 0 0 1 2-2z"/>',
    'mail'=>'<rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/>',
    'pin'=>'<path d="M12 21s7-5.5 7-11a7 7 0 1 0-14 0c0 5.5 7 11 7 11z"/><circle cx="12" cy="10" r="2.5"/>',
    'chart'=>'<path d="M4 20V10M10 20V4M16 20v-8M22 20H2"/>',
    'doc'=>'<path d="M7 3h7l5 5v13H7z"/><path d="M14 3v5h5M10 13h6M10 17h6"/>',
    'eye'=>'<path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/><circle cx="12" cy="12" r="3"/>',
    'map'=>'<path d="M9 4 3 6v14l6-2 6 2 6-2V4l-6 2-6-2zM9 4v14M15 6v14"/>',
    'news'=>'<path d="M4 5h13v14H6a2 2 0 0 1-2-2z"/><path d="M17 8h3v11a1 1 0 0 1-1 1M7 9h8M7 13h8"/>',
    'cam'=>'<rect x="3" y="7" width="13" height="11" rx="2"/><path d="M16 10l5-3v10l-5-3"/>',
    'eitaa'=>'<path d="M12 2l8 4v6c0 5-3.5 8.5-8 10-4.5-1.5-8-5-8-10V6z"/><path d="M8.5 11.5l2.5 2.5 4.5-5"/>',
    'bale'=>'<path d="M21 11.5a8.5 8.5 0 0 1-12.5 7.5L3 21l2-5.5A8.5 8.5 0 1 1 21 11.5z"/><path d="M9 9.5c1 2.5 3 4.5 5.5 5.5M9 12.5c.6 1.4 1.8 2.6 3.2 3.2M9 15.2c.4.8 1 1.4 1.8 1.8"/>',
    'rubika'=>'<circle cx="12" cy="12" r="9"/><circle cx="12" cy="12" r="3.5"/><path d="M12 3v5M12 16v5M3 12h5M16 12h5"/>',
    'link'=>'<path d="M10 14a5 5 0 0 0 7 0l3-3a5 5 0 0 0-7-7l-1.5 1.5"/><path d="M14 10a5 5 0 0 0-7 0l-3 3a5 5 0 0 0 7 7l1.5-1.5"/>',
    'bolt'=>'<path d="M13 2 4 14h6l-1 8 9-12h-6z"/>',
    'bank'=>'<path d="M3 9l9-6 9 6M4 9v11M20 9v11M8 12v5M12 12v5M16 12v5M2 21h20"/>',
  ];
  $inner=isset($p[$name])?$p[$name]:$p['doc'];
  return '<svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round">'.$inner.'</svg>';
}
function bidrubeh_services(){
  return [
    ['t'=>'شهروندسپاری','d'=>'خدمات غیرحضوری','i'=>'desk','u'=>'#services'],
    ['t'=>'پرداخت عوارض','d'=>'نوسازی و خودرو','i'=>'card','u'=>'#services'],
    ['t'=>'سامانه ۱۳۷','d'=>'ارتباط با شهرداری','i'=>'phone','u'=>'#services'],
    ['t'=>'استعلام پرونده','d'=>'پیگیری درخواست‌ها','i'=>'doc','u'=>'#services'],
    ['t'=>'شفافیت','d'=>'مناقصات و مزایدات','i'=>'eye','u'=>'#services'],
    ['t'=>'نقشه شهر','d'=>'اماکن و مسیرها','i'=>'map','u'=>'#services'],
    ['t'=>'آخرین اخبار','d'=>'اطلاع‌رسانی','i'=>'news','u'=>'#news'],
    ['t'=>'گزارش تصویری','d'=>'چندرسانه‌ای','i'=>'cam','u'=>'#news'],
  ];
}
add_filter('excerpt_length',function(){return 28;});
add_filter('widget_display_callback',function($instance,$widget,$args){
  if(!($widget instanceof WP_Widget_Recent_Posts)) return $instance;
  $title=isset($instance['title'])?$instance['title']:'';
  $number=isset($instance['number'])?absint($instance['number']):5;
  if($number<1||$number>20) $number=5;
  echo $args['before_widget'];
  if($title!=='') echo $args['before_title'].apply_filters('widget_title',$title).$args['after_title'];
  $targs=['posts_per_page'=>$number,'ignore_sticky_posts'=>1,'no_found_rows'=>true,'post_status'=>'publish'];
  $tt=bidrubeh_tourism_term();
  if($tt) $targs['category__not_in']=[(int)$tt->term_id];
  $q=new WP_Query($targs);
  if($q->have_posts()){
    echo '<ul class="bd-recent-list">';
    while($q->have_posts()){
      $q->the_post();
      echo '<li><a href="'.esc_url(get_permalink()).'">';
      if(has_post_thumbnail()) echo get_the_post_thumbnail(get_the_ID(),[96,72],['class'=>'bd-recent-thumb']);
      echo '<span class="bd-recent-title">'.esc_html(get_the_title()).'</span></a></li>';
    }
    echo '</ul>';
    wp_reset_postdata();
  }
  echo $args['after_widget'];
  return false;
},10,3);
