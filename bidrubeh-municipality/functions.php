<?php
define('BIDRUBEH_VER','1.9.111');
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
function bidrubeh_msg_device_token(){
  $token=isset($_COOKIE['bd_cfp'])?strtolower((string)$_COOKIE['bd_cfp']):'';
  return preg_match('/^[a-f0-9]{32}$/',$token)?$token:'';
}
function bidrubeh_norm_phone($raw){
  if(!is_scalar($raw)) return '';
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
  $token=bidrubeh_msg_device_token();
  if($fp===''&&$token==='') return ['count'=>0,'latest'=>null];
  $sql="SELECT DISTINCT p.ID FROM {$wpdb->posts} p INNER JOIN {$wpdb->postmeta} m1 ON p.ID=m1.post_id AND ((m1.meta_key='bd_fp' AND m1.meta_value=%s)";
  $values=[$fp];
  if($token!==''){
    $sql.=" OR (m1.meta_key='bd_device' AND m1.meta_value=%s)";
    $values[]=$token;
  }
  $sql.=") INNER JOIN {$wpdb->postmeta} m2 ON p.ID=m2.post_id AND m2.meta_key='bd_read' AND m2.meta_value='0' WHERE p.post_type='bidrubeh_msg' AND p.post_status='private' ORDER BY p.post_date DESC";
  $ids=$wpdb->get_col($wpdb->prepare($sql,$values));
  $latest=$ids?get_post((int)$ids[0]):null;
  return ['count'=>count($ids),'latest'=>$latest];
}
function bidrubeh_contact_pending($phone_norm=''){
  if($phone_norm!==''){
    $by_phone=bidrubeh_unread_by_phone($phone_norm);
    if($by_phone['count']>0) return array_merge($by_phone,['by'=>'phone']);
  }
  $by_device=bidrubeh_unread_by_ip();
  return $by_device['count']>0?array_merge($by_device,['by'=>'device']):null;
}
function bidrubeh_contact_release_locks(){
  if(empty($GLOBALS['bd_contact_locks'])) return;
  global $wpdb;
  foreach(array_reverse($GLOBALS['bd_contact_locks']) as $key) $wpdb->get_var($wpdb->prepare('SELECT RELEASE_LOCK(%s)',$key));
  unset($GLOBALS['bd_contact_locks']);
}
add_action('shutdown','bidrubeh_contact_release_locks');
function bidrubeh_contact_acquire_locks($phone_norm){
  global $wpdb;
  $device=bidrubeh_msg_device_token();
  $keys=[
    'bd_msg_p_'.substr(hash('sha256',$phone_norm),0,40),
    'bd_msg_f_'.substr(hash('sha256',bidrubeh_msg_fp()),0,40),
  ];
  if($device!=='') $keys[]='bd_msg_d_'.substr(hash('sha256',$device),0,40);
  sort($keys,SORT_STRING);
  foreach($keys as $key){
    if((string)$wpdb->get_var($wpdb->prepare('SELECT GET_LOCK(%s, %d)',$key,5))!=='1'){
      bidrubeh_contact_release_locks();
      return false;
    }
    $GLOBALS['bd_contact_locks'][]=$key;
  }
  return true;
}
function bidrubeh_contact_post_string($key){
  $value=$_POST[$key]??'';
  return is_scalar($value)?(string)wp_unslash($value):'';
}
add_action('template_redirect',function(){
  if(!isset($_POST['bd_contact_send'])) return;
  $state=['name'=>'','phone'=>'','message'=>'','error'=>'','field'=>'','check'=>null];
  $state['name']=sanitize_text_field(bidrubeh_contact_post_string('bd_name'));
  $state['phone']=sanitize_text_field(bidrubeh_contact_post_string('bd_phone2'));
  $state['message']=sanitize_textarea_field(bidrubeh_contact_post_string('bd_msg'));
  $nonce=sanitize_text_field(bidrubeh_contact_post_string('bd_contact_nonce'));
  $pn=bidrubeh_norm_phone($state['phone']);
  if(!wp_verify_nonce($nonce,'bd_contact')) $state['error']='اعتبار فرم به پایان رسیده است. صفحه را تازه‌سازی کنید و دوباره تلاش کنید.';
  elseif($pending=bidrubeh_contact_pending($pn)) $state['check']=$pending;
  elseif(trim($state['name'])===''){ $state['error']='لطفاً نام و نام خانوادگی خود را وارد کنید.'; $state['field']='bdName'; }
  elseif(trim($state['phone'])===''){ $state['error']='لطفاً شماره موبایل خود را وارد کنید.'; $state['field']='bdPhone'; }
  elseif(!preg_match('/^09\d{9}$/',$pn)){ $state['error']='شماره موبایل باید ۱۱ رقم و با ۰۹ شروع شود.'; $state['field']='bdPhone'; }
  elseif(trim($state['message'])===''){ $state['error']='لطفاً متن پیام را وارد کنید.'; $state['field']='bdMsg'; }
  elseif(mb_strlen(trim($state['message']))<10){ $state['error']='متن پیام باید حداقل ۱۰ کاراکتر باشد.'; $state['field']='bdMsg'; }
  elseif(!bidrubeh_contact_acquire_locks($pn)) $state['error']='درخواست دیگری در حال ثبت است. چند لحظه بعد دوباره تلاش کنید.';
  elseif($pending=bidrubeh_contact_pending($pn)) $state['check']=$pending;
  else{
    $name=$state['name']; $phone=$state['phone']; $message=$state['message'];
    $content="نام: $name\nتلفن: $phone\n\n$message";
    $id=wp_insert_post([
      'post_type'=>'bidrubeh_msg','post_title'=>$name.' — '.wp_date('Y/m/d H:i'),
      'post_content'=>$content,'post_status'=>'private',
      'meta_input'=>['bd_fp'=>bidrubeh_msg_fp(),'bd_device'=>bidrubeh_msg_device_token(),'bd_read'=>'0','bd_phone'=>$phone,'bd_phone_norm'=>$pn],
    ],true);
    if(is_wp_error($id)||!$id) $state['error']='پیام ذخیره نشد. لطفاً دوباره تلاش کنید.';
    else{
      $to=get_option('admin_email');
      if(is_email($to)) wp_mail($to,'پیام تماس با ما: '.$name,$content);
      bidrubeh_contact_release_locks();
      $url=get_permalink(get_queried_object_id());
      if(!$url) $url=home_url('/contact-us/');
      wp_safe_redirect(add_query_arg('bd_sent','1',$url));
      exit;
    }
  }
  bidrubeh_contact_release_locks();
  $GLOBALS['bd_contact_state']=$state;
});
function bidrubeh_contact_shortcode(){
  $state=$GLOBALS['bd_contact_state']??['name'=>'','phone'=>'','message'=>'','error'=>'','field'=>'','check'=>null];
  $check=$state['check']?:bidrubeh_contact_pending();
  $show_sent=isset($_GET['bd_sent'])&&$check;
  ob_start();
  if($show_sent) echo '<div class="bd-sent-ok" role="status"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><circle cx="12" cy="12" r="10"/><path d="M8 12.5l2.5 2.5L16 9.5"/></svg><div><strong>پیام شما ثبت شد.</strong><small>پس از خوانده شدن پیام توسط مدیر، امکان ارسال پیام تازه دارید.</small></div></div>';
  if($state['error']!=='') echo '<div class="bd-form-err" role="alert"><span class="bd-form-err-icon" aria-hidden="true">!</span><span>'.esc_html($state['error']).'</span></div>';
  if($check){
    $n=(int)$check['count'];
    $by=$check['by']??'device';
    $msg=$by==='phone'?sprintf('این شماره تلفن %s پیام خوانده‌نشده دارد.',bidrubeh_fa_digits($n)):sprintf('از این سیستم %s پیام خوانده‌نشده ثبت شده است.',bidrubeh_fa_digits($n));
    echo '<div class="bd-lock-box" role="status"><span class="bd-lock-ico" aria-hidden="true">⏳</span><div><strong>'.esc_html($msg).'</strong><small>تا زمان خوانده شدن پیام قبلی توسط مدیر، ارسال پیام تازه ممکن نیست.</small></div></div>';
  } else {
  ?>
  <form class="bd-contact-form" method="post" action="" id="bdContactForm">
    <?php wp_nonce_field('bd_contact','bd_contact_nonce'); ?>
    <input type="hidden" name="bd_contact_send" value="1">
    <p><label for="bdName">نام و نام خانوادگی *</label><input type="text" name="bd_name" id="bdName" required value="<?php echo esc_attr($state['name']); ?>"<?php echo $state['field']==='bdName'?' aria-invalid="true"':''; ?>><small class="bd-field-error" id="bdName-error"<?php echo $state['field']==='bdName'?'':' hidden'; ?>><?php echo $state['field']==='bdName'?esc_html($state['error']):''; ?></small></p>
    <p><label for="bdPhone">تلفن تماس (موبایل) *</label><input type="tel" name="bd_phone2" id="bdPhone" required inputmode="tel" maxlength="18" placeholder="۰۹۱۲۳۴۵۶۷۸۹" value="<?php echo esc_attr(bidrubeh_fa_digits($state['phone'])); ?>"<?php echo $state['field']==='bdPhone'?' aria-invalid="true"':''; ?>><small class="bd-field-error" id="bdPhone-error"<?php echo $state['field']==='bdPhone'?'':' hidden'; ?>><?php echo $state['field']==='bdPhone'?esc_html($state['error']):''; ?></small><small class="bd-phone-status" id="bdPhoneStatus" role="status" aria-live="polite"></small></p>
    <p class="full"><label for="bdMsg">متن پیام *</label><textarea name="bd_msg" id="bdMsg" rows="5" required minlength="10"<?php echo $state['field']==='bdMsg'?' aria-invalid="true"':''; ?>><?php echo esc_textarea($state['message']); ?></textarea><small class="bd-field-error" id="bdMsg-error"<?php echo $state['field']==='bdMsg'?'':' hidden'; ?>><?php echo $state['field']==='bdMsg'?esc_html($state['error']):''; ?></small></p>
    <p class="full"><button class="bd-send-btn" type="submit" id="bdSendBtn"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round" aria-hidden="true"><rect x="3" y="5" width="18" height="14" rx="2"/><path d="M3 7l9 6 9-6"/></svg><span>ارسال پیام</span></button></p>
  </form>
  <script>
  (function(){
    var form=document.getElementById('bdContactForm');
    if(!form) return;
    form.noValidate=true;
    var phone=document.getElementById('bdPhone'),status=document.getElementById('bdPhoneStatus'),button=document.getElementById('bdSendBtn');
    var timer,request=0,blocked=false;
    var summary=document.createElement('div');
    summary.className='bd-contact-error-summary';summary.setAttribute('role','alert');summary.hidden=true;
    form.insertBefore(summary,form.firstChild);
    function normalize(value){
      var digits=String(value).replace(/[۰-۹٠-٩]/g,function(d){return String('۰۱۲۳۴۵۶۷۸۹'.indexOf(d)>-1?'۰۱۲۳۴۵۶۷۸۹'.indexOf(d):'٠١٢٣٤٥٦٧٨٩'.indexOf(d));}).replace(/\D/g,'');
      if(digits.indexOf('0098')===0) digits='0'+digits.slice(4);
      else if(digits.indexOf('98')===0&&digits.length===12) digits='0'+digits.slice(2);
      else if(digits.length===10&&digits[0]==='9') digits='0'+digits;
      return digits;
    }
    function errorFor(el){
      var value=el.value.trim();
      if(!value) return el.id==='bdName'?'لطفاً نام و نام خانوادگی خود را وارد کنید.':el.id==='bdPhone'?'لطفاً شماره موبایل خود را وارد کنید.':'لطفاً متن پیام را وارد کنید.';
      if(el.id==='bdPhone'&&!/^09\d{9}$/.test(normalize(value))) return 'شماره موبایل باید ۱۱ رقم و با ۰۹ شروع شود.';
      if(el.id==='bdMsg'&&Array.from(value).length<10) return 'متن پیام باید حداقل ۱۰ کاراکتر باشد.';
      return '';
    }
    function showError(el,message){
      var node=document.getElementById(el.id+'-error');
      node.textContent=message;node.hidden=!message;
      if(message){el.setAttribute('aria-invalid','true');el.setAttribute('aria-describedby',node.id);}
      else{el.removeAttribute('aria-invalid');el.removeAttribute('aria-describedby');}
    }
    ['bdName','bdPhone','bdMsg'].forEach(function(id){
      var el=document.getElementById(id);
      el.addEventListener('input',function(){if(el.getAttribute('aria-invalid')==='true') showError(el,errorFor(el));if(!form.querySelector('[aria-invalid="true"]')) summary.hidden=true;});
    });
    function checkPhone(){
      var current=++request;
      if(!/^09\d{9}$/.test(normalize(phone.value))){status.textContent='';status.className='bd-phone-status';blocked=false;button.disabled=false;return;}
      status.textContent='در حال بررسی شماره…';status.className='bd-phone-status checking';
      fetch('<?php echo esc_url(admin_url('admin-ajax.php')); ?>?action=bidrubeh_check_phone&phone='+encodeURIComponent(phone.value))
        .then(function(response){if(!response.ok) throw new Error('network');return response.json();})
        .then(function(data){
          if(current!==request) return;
          blocked=!!(data&&data.count>0);
          if(blocked){status.textContent=data.by==='phone'?'این شماره پیام خوانده‌نشده دارد؛ پس از خوانده شدن آن می‌توانید پیام تازه بفرستید.':'از این سیستم پیام خوانده‌نشده ثبت شده است؛ پس از خوانده شدن آن می‌توانید پیام تازه بفرستید.';status.className='bd-phone-status blocked';}
          else{status.textContent='این شماره پیام خوانده‌نشده‌ای ندارد.';status.className='bd-phone-status ok';}
          button.disabled=blocked;
        }).catch(function(){if(current===request){status.textContent='بررسی خودکار در دسترس نیست؛ هنگام ارسال بررسی می‌شود.';status.className='bd-phone-status checking';blocked=false;button.disabled=false;}});
    }
    phone.addEventListener('input',function(){
      var cursor=phone.selectionStart;
      var shown=phone.value.replace(/[0-9٠-٩]/g,function(d){
        var digit=/[0-9]/.test(d)?Number(d):'٠١٢٣٤٥٦٧٨٩'.indexOf(d);
        return '۰۱۲۳۴۵۶۷۸۹'[digit];
      });
      if(shown!==phone.value){phone.value=shown;if(cursor!==null) phone.setSelectionRange(cursor,cursor);}
      clearTimeout(timer);request++;timer=setTimeout(checkPhone,450);
    });
    form.addEventListener('submit',function(event){
      var first=null;
      ['bdName','bdPhone','bdMsg'].forEach(function(id){var el=document.getElementById(id),error=errorFor(el);showError(el,error);if(error&&!first) first=el;});
      if(first||blocked){event.preventDefault();summary.textContent=blocked?'این شماره یا سیستم پیام خوانده‌نشده دارد.':'لطفاً موارد مشخص‌شده را اصلاح کنید.';summary.hidden=false;if(first) first.focus();}
      else button.disabled=true;
    });
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
add_action('init',function(){
  $tok=isset($_COOKIE['bd_cfp'])?preg_replace('/[^a-f0-9]/','',strtolower((string)$_COOKIE['bd_cfp'])):'';
  if(!is_user_logged_in()&&strlen($tok)!==32){
    $t=bin2hex(random_bytes(16));
    setcookie('bd_cfp',$t,time()+YEAR_IN_SECONDS,COOKIEPATH,COOKIE_DOMAIN,is_ssl(),true);
    $_COOKIE['bd_cfp']=$t;
  }
},1);
function bidrubeh_comment_blocked($post_id=null){
  if(current_user_can('moderate_comments')) return false;
  global $wpdb;
  $fp=bidrubeh_comment_fp();
  $tok=isset($_COOKIE['bd_cfp'])?preg_replace('/[^a-f0-9]/','',strtolower((string)$_COOKIE['bd_cfp'])):'';
  $like=strlen($tok)===32?$wpdb->esc_like('g'.$tok.'|').'%':$fp;
  $ip=isset($_SERVER['REMOTE_ADDR'])?(string)$_SERVER['REMOTE_ADDR']:'';
  $ua=isset($_SERVER['HTTP_USER_AGENT'])?substr((string)$_SERVER['HTTP_USER_AGENT'],0,120):'';
  $network_match=$ip!==''&&$ip!=='0'&&$ua!=='';
  $sql="SELECT 1 FROM {$wpdb->comments} c WHERE c.comment_approved='0' AND c.comment_type IN ('','comment') AND (EXISTS (SELECT 1 FROM {$wpdb->commentmeta} m WHERE m.comment_id=c.comment_ID AND m.meta_key='bd_fp' AND (m.meta_value=%s OR m.meta_value LIKE %s))";
  $values=[$fp,$like];
  if($network_match){
    $sql.=' OR (c.comment_author_IP=%s AND LEFT(c.comment_agent,120)=%s)';
    $values[]=$ip;
    $values[]=$ua;
  }
  $sql.=') LIMIT 1';
  return (bool)$wpdb->get_var($wpdb->prepare($sql,$values));
}
function bidrubeh_comment_release_lock(){
  if(empty($GLOBALS['bd_comment_sql_lock'])) return;
  global $wpdb;
  $wpdb->get_var($wpdb->prepare('SELECT RELEASE_LOCK(%s)',$GLOBALS['bd_comment_sql_lock']));
  unset($GLOBALS['bd_comment_sql_lock']);
}
add_action('shutdown','bidrubeh_comment_release_lock');
add_action('wp_insert_comment',function($cid){
  update_comment_meta($cid,'bd_fp',bidrubeh_comment_fp());
  bidrubeh_comment_release_lock();
});
add_filter('pre_comment_approved',function($approved,$commentdata){
  if(!empty($commentdata['user_ID'])&&user_can((int)$commentdata['user_ID'],'moderate_comments')) return $approved;
  return '0';
},10,2);
function bidrubeh_comment_guard(){
  if(current_user_can('moderate_comments')) return true;
  global $wpdb;
  $ip=isset($_SERVER['REMOTE_ADDR'])?(string)$_SERVER['REMOTE_ADDR']:'';
  $ua=isset($_SERVER['HTTP_USER_AGENT'])?substr((string)$_SERVER['HTTP_USER_AGENT'],0,120):'';
  $identity=$ip!==''&&$ua!==''?$ip.'|'.$ua:bidrubeh_comment_fp();
  $key='bd_comment_'.substr(hash('sha256',$identity),0,40);
  if((string)$wpdb->get_var($wpdb->prepare('SELECT GET_LOCK(%s, %d)',$key,5))!=='1'){
    return new WP_Error('bidrubeh_comment_busy','ثبت دیدگاه قبلی هنوز در حال انجام است. چند لحظه دیگر دوباره تلاش کنید.',['status'=>429]);
  }
  $GLOBALS['bd_comment_sql_lock']=$key;
  if(bidrubeh_comment_blocked()) return new WP_Error('bidrubeh_comment_pending','دیدگاه قبلی این سیستم هنوز در انتظار بررسی مدیر است. پس از تأیید یا رد آن می‌توانید دیدگاه جدید ثبت کنید.',['status'=>409]);
  return true;
}
add_filter('preprocess_comment',function($data){
  $guard=bidrubeh_comment_guard();
  if(is_wp_error($guard)) wp_die($guard->get_error_message(),'دیدگاه ثبت نشد',['response'=>$guard->get_error_data()['status']]);
  if(empty($data['user_ID'])){
    if(trim($data['comment_author']??'')===''){
      wp_die(__('لطفاً نام خود را وارد کنید.','bidrubeh'),__('نام الزامی است','bidrubeh'),['response'=>422]);
    }
    $em=trim($data['comment_author_email']??'');
    if($em===''){
      wp_die(__('لطفاً ایمیل خود را وارد کنید.','bidrubeh'),__('ایمیل الزامی است','bidrubeh'),['response'=>422]);
    }
    if(!is_email($em)){
      wp_die(__('ایمیل وارد شده معتبر نیست.','bidrubeh'),__('ایمیل نامعتبر','bidrubeh'),['response'=>422]);
    }
  }
  $t=trim(wp_strip_all_tags($data['comment_content']??''));
  if(mb_strlen($t)<10){
    wp_die(__('متن دیدگاه باید حداقل ۱۰ کاراکتر باشد.','bidrubeh'),__('متن کوتاه','bidrubeh'),['response'=>422]);
  }
  return $data;
});
add_filter('rest_pre_insert_comment',function($prepared){
  if(is_wp_error($prepared)) return $prepared;
  $guard=bidrubeh_comment_guard();
  if(is_wp_error($guard)) return $guard;
  if(!current_user_can('moderate_comments')) $prepared['comment_approved']='0';
  return $prepared;
});
add_filter('wp_die_handler',function($handler){
  if(basename((string)($_SERVER['SCRIPT_NAME']??''))==='wp-comments-post.php') return 'bidrubeh_comment_die_handler';
  return $handler;
});
function bidrubeh_comment_die_handler($message,$title='',$args=[]){
  $args=wp_parse_args($args,['response'=>500,'exit'=>true]);
  $status=(int)$args['response'];
  if($status===500) $status=400;
  if($status<400||$status>599) $status=400;
  if($message instanceof WP_Error) $message=$message->get_error_message();
  $message=trim(wp_strip_all_tags((string)$message));
  $title=trim(wp_strip_all_tags((string)$title));
  if($title==='') $title='ثبت دیدگاه انجام نشد';
  if($message==='') $message='لطفاً دوباره تلاش کنید.';
  $post_id=isset($_POST['comment_post_ID'])?absint($_POST['comment_post_ID']):0;
  $back=$post_id&&get_post_status($post_id)?get_permalink($post_id).'#respond':home_url('/');
  status_header($status);
  http_response_code($status);
  nocache_headers();
  header('Content-Type: text/html; charset='.get_bloginfo('charset'));
  ?>
  <!doctype html><html lang="fa" dir="rtl"><head><meta charset="<?php echo esc_attr(get_bloginfo('charset')); ?>"><meta name="viewport" content="width=device-width,initial-scale=1"><title><?php echo esc_html($title); ?> | <?php echo esc_html(get_bloginfo('name')); ?></title>
  <style>*{box-sizing:border-box}body{margin:0;min-height:100vh;display:grid;place-items:center;padding:24px;background:#f4f6f0;color:#213b32;font:16px/1.9 Tahoma,Arial,sans-serif}.card{width:min(100%,520px);padding:clamp(24px,5vw,42px);border:1px solid #dbe6db;border-radius:22px;background:#fff;box-shadow:0 18px 55px rgba(19,62,48,.1)}.icon{display:grid;place-items:center;width:58px;height:58px;border-radius:18px;background:#fff3e7;color:#a66324;font-size:28px;font-weight:800}h1{margin:20px 0 8px;font-size:23px;line-height:1.5;color:#103f34}p{margin:0 0 24px;color:#52645b}.actions{display:flex;gap:10px;flex-wrap:wrap}a{display:inline-block;border-radius:11px;padding:9px 19px;font-weight:700;text-decoration:none}a.primary{background:#155d4a;color:#fff}a.secondary{background:#edf4ee;color:#155d4a}a:focus-visible{outline:3px solid #c88a45;outline-offset:3px}</style></head><body><main class="card" role="alert"><span class="icon" aria-hidden="true">!</span><h1><?php echo esc_html($title); ?></h1><p><?php echo esc_html($message); ?></p><div class="actions"><a class="primary" href="<?php echo esc_url($back); ?>">بازگشت به دیدگاه‌ها</a><a class="secondary" href="<?php echo esc_url(home_url('/')); ?>">صفحه اصلی</a></div></main></body></html>
  <?php
  if($args['exit']) exit;
}
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
function bidrubeh_localize_text_digits($text){
  return preg_replace_callback('/&#(?:[0-9]+|x[0-9a-fA-F]+);|[0-9]+/u',function($number){
    $value=$number[0];
    if(strncmp($value,'&#',2)!==0) return bidrubeh_fa_digits($value);
    $code=strtolower($value[2]??'')==='x'?hexdec(substr($value,3,-1)):(int)substr($value,2,-1);
    return $code>=48&&$code<=57?bidrubeh_fa_digits(chr($code)):$value;
  },$text);
}
function bidrubeh_localize_visible_digits($html){
  if($html==='') return $html;
  return preg_replace_callback('~<!--.*?-->|<(?:script|style)\b[^>]*>.*?</(?:script|style)\s*>|<[^>]*>|[^<]+~is',function($part){
    $text=$part[0];
    if($text[0]!=='<') return bidrubeh_localize_text_digits($text);
    if(preg_match('/^<(?:!--|script\b|style\b)/i',$text)) return $text;
    return preg_replace_callback('/\b(alt|title|aria-label|placeholder)="([^"]*)"/i',function($attribute){
      return $attribute[1].'="'.bidrubeh_localize_text_digits($attribute[2]).'"';
    },$text);
  },$html);
}
add_action('template_redirect',function(){
  if(is_admin()||wp_doing_ajax()||is_feed()||is_robots()||is_trackback()||is_embed()||wp_is_json_request()||get_query_var('sitemap')||get_query_var('sitemap-stylesheet')) return;
  ob_start('bidrubeh_localize_visible_digits');
},20);
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
  $wp_customize->add_setting('bd_office_hours',['default'=>'شنبه تا چهارشنبه، ۷:۳۰ تا ۱۴:۳۰','sanitize_callback'=>'sanitize_text_field']);
  $wp_customize->add_control('bd_office_hours',['label'=>__('ساعات کاری','bidrubeh'),'description'=>__('از متن فعلی صفحه درباره ما گرفته شده است؛ در صورت تغییر برنامه، اینجا را به‌روزرسانی کنید.','bidrubeh'),'section'=>'bidrubeh_city','type'=>'text']);
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
  $wp_customize->add_section('bidrubeh_zones',['title'=>__('نواحی و محلات','bidrubeh'),'priority'=>32,'description'=>__('نام و توضیح واقعی هر محله را ثبت کنید. عنوان خالی = عدم نمایش در صفحه درباره ما.','bidrubeh')]);
  $zone_defs=[
    1=>['t'=>'','d'=>''],2=>['t'=>'','d'=>''],3=>['t'=>'','d'=>''],4=>['t'=>'','d'=>''],
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
    1=>['q'=>'ساعات کاری شهرداری بیدروبه چیست؟','a'=>'ساعات کاری تأییدشده در صفحه اصلی درج می‌شود. برای اطلاع بیشتر با شهرداری تماس بگیرید.'],
    2=>['q'=>'چگونه با شهرداری ارتباط بگیرم؟','a'=>'از صفحه «تماس با ما» پیام بفرستید یا با شماره درج‌شده در سایت تماس بگیرید.'],
    3=>['q'=>'چگونه درخواست شهری ثبت کنم؟','a'=>'از صفحه «تماس با ما» فرم را تکمیل کنید تا درخواست شما به شهرداری برسد.'],
    4=>['q'=>'اطلاعیه‌های مهم را کجا ببینم؟','a'=>'جدیدترین اطلاعیه در صفحه اصلی نمایش داده می‌شود و بقیه در آرشیو اطلاعیه‌ها قابل مشاهده‌اند.'],
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
    1=>['q'=>'ساعات کاری شهرداری بیدروبه چیست؟','a'=>'ساعات کاری تأییدشده در صفحه اصلی درج می‌شود. برای اطلاع بیشتر با شهرداری تماس بگیرید.'],
    2=>['q'=>'چگونه با شهرداری ارتباط بگیرم؟','a'=>'از صفحه «تماس با ما» پیام بفرستید یا با شماره درج‌شده در سایت تماس بگیرید.'],
    3=>['q'=>'چگونه درخواست شهری ثبت کنم؟','a'=>'از صفحه «تماس با ما» فرم را تکمیل کنید تا درخواست شما به شهرداری برسد.'],
    4=>['q'=>'اطلاعیه‌های مهم را کجا ببینم؟','a'=>'جدیدترین اطلاعیه در صفحه اصلی نمایش داده می‌شود و بقیه در آرشیو اطلاعیه‌ها قابل مشاهده‌اند.'],
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
    1=>['t'=>'','d'=>''],2=>['t'=>'','d'=>''],3=>['t'=>'','d'=>''],4=>['t'=>'','d'=>''],
    5=>['t'=>'','d'=>''],6=>['t'=>'','d'=>''],7=>['t'=>'','d'=>''],8=>['t'=>'','d'=>''],
  ];
  $out=[];
  foreach($defs as $i=>$d){
    $t=trim((string)get_theme_mod('bd_zone'.$i.'_title',$d['t']));
    $desc=trim((string)get_theme_mod('bd_zone'.$i.'_desc',$d['d']));
    if($t==='') continue;
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
  return preg_replace_callback('~</a>\s*\(([0-9]+)\)~u',function($m){
    $count=bidrubeh_fa_digits($m[1]);
    return '</a><span class="bd-cat-count" aria-label="'.esc_attr($count.' مطلب').'">'.esc_html($count).'</span>';
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
      echo '✅';
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
add_action('pre_get_posts',function($query){
  if(is_admin()||!$query->is_main_query()||!$query->is_category('akhbar')) return;
  $query->set('bd_news_archive',1);
  $query->set('category_name','');
  $query->set('cat','');
  $query->set('category__not_in',bidrubeh_latest_news_exclude());
  $query->set('post_type','post');
  $query->set('post_status','publish');
  $query->set('posts_per_page',10);
  $query->set('ignore_sticky_posts',1);
  $query->set('orderby','date');
  $query->set('order','DESC');
});
function bidrubeh_slider_speed(){
  $s=(int)get_theme_mod('bd_slider_speed',5);
  if($s<0) $s=0; if($s>60) $s=60;
  return (int)apply_filters('bidrubeh_slider_speed',$s);
}
function bidrubeh_slider_posts(){
  $q=new WP_Query(['posts_per_page'=>-1,'post_type'=>'post','post_status'=>'publish','ignore_sticky_posts'=>1,'no_found_rows'=>true,
    'meta_query'=>[['key'=>'bd_in_slider','value'=>'1']],'orderby'=>'date','order'=>'DESC']);
  return array_values((array)$q->posts);
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
  if(!bidrubeh_tourism_term()) return '';
  $args=bidrubeh_tourism_query_args();
  $q=new WP_Query($args);
  if(!$q->have_posts()) return '';
  $posts=array_values($q->posts);
  shuffle($posts);
  $out='<div class="bd-tour-grid" id="bdTourGrid" dir="rtl" data-speed="'.(int)bidrubeh_slider_speed().'">';
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
    'clock'=>'<circle cx="12" cy="12" r="9"/><path d="M12 7v5l3.5 2"/>',
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
