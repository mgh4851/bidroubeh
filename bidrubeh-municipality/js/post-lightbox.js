document.addEventListener('DOMContentLoaded',function(){
  var article=document.querySelector('.bd-single-main .loop-card');
  if(!article||!window.HTMLDialogElement)return;
  var featured=article.querySelector('.bd-post-featured');
  var content=article.querySelector('.bd-post-content');
  if(content){
    function imageOnly(element){
      if(element.tagName==='FIGURE')return element.classList.contains('wp-block-image')&&element.querySelectorAll('img').length===1;
      if(element.tagName!=='P'||element.textContent.trim()||element.children.length!==1)return false;
      var child=element.firstElementChild;
      return child.tagName==='IMG'||(child.tagName==='A'&&child.children.length===1&&child.firstElementChild.tagName==='IMG');
    }
    var children=Array.prototype.slice.call(content.children);
    for(var i=0;i<children.length;){
      if(!imageOnly(children[i])){i++;continue;}
      var start=i;
      while(i<children.length&&imageOnly(children[i]))i++;
      if(i-start<2)continue;
      var row=document.createElement('div');
      row.className='bd-inline-image-row'+(i-start===2?' bd-inline-image-row-two':'');
      content.insertBefore(row,children[start]);
      for(var j=start;j<i;j++)row.appendChild(children[j]);
    }
  }
  var items=[];
  if(featured)items.push({trigger:featured,image:featured.querySelector('img'),full:featured.getAttribute('data-bd-full')});
  if(content)Array.prototype.forEach.call(content.querySelectorAll('img'),function(img){
    if(img.closest('.wp-lightbox-container'))return;
    var link=img.closest('a');
    var mediaLink=link&&/\.(?:avif|gif|jpe?g|png|webp)(?:[?#]|$)/i.test(link.href);
    if(link&&!mediaLink&&!img.closest('.wp-block-gallery, .gallery'))return;
    var source=img.getAttribute('data-bd-full')||(mediaLink?link.href:'');
    if(!source&&img.srcset){
      var candidates=img.srcset.split(',').map(function(part){
        var match=part.trim().match(/^(\S+)\s+(\d+)w$/);
        return match?{url:match[1],width:Number(match[2])}:null;
      }).filter(Boolean).sort(function(a,b){return b.width-a.width;});
      if(candidates.length)source=candidates[0].url;
    }
    if(!source)source=img.src.replace(/-\d+x\d+(?=\.(?:avif|gif|jpe?g|png|webp)(?:[?#]|$))/i,'');
    if(source&&source!==img.src&&img.closest('.bd-inline-image-row, .wp-block-gallery, .gallery')){
      var highResolution=new Image();
      highResolution.onload=function(){img.removeAttribute('srcset');img.removeAttribute('sizes');img.src=source;};
      highResolution.src=source;
    }
    img.setAttribute('data-bd-zoomable','');
    if(!link){img.setAttribute('role','button');img.tabIndex=0;img.setAttribute('aria-label','نمایش تصویر در اندازه بزرگ');}
    items.push({trigger:link||img,image:img,full:source||img.src,fallback:img.currentSrc||img.src});
  });
  if(!items.length)return;
  var dialog=document.createElement('dialog');
  dialog.className='bd-post-lightbox';
  dialog.setAttribute('aria-label','نمایش بزرگ تصاویر خبر');
  dialog.innerHTML='<button type="button" class="bd-lightbox-close" aria-label="بستن">×</button><button type="button" class="bd-lightbox-next" aria-label="تصویر بعدی" dir="ltr"><span class="bd-lightbox-chevron" aria-hidden="true"></span></button><img alt=""><p class="bd-lightbox-caption"></p><button type="button" class="bd-lightbox-prev" aria-label="تصویر قبلی" dir="ltr"><span class="bd-lightbox-chevron" aria-hidden="true"></span></button>';
  document.body.appendChild(dialog);
  var large=dialog.querySelector('img'),caption=dialog.querySelector('.bd-lightbox-caption');
  var prev=dialog.querySelector('.bd-lightbox-prev'),next=dialog.querySelector('.bd-lightbox-next');
  var current=0,lastFocus=null;
  large.addEventListener('error',function(){
    var fallback=items[current].fallback;
    if(large.src!==fallback)large.src=fallback;
  });
  function show(index){
    current=(index+items.length)%items.length;
    var item=items[current];
    large.src=item.full;
    large.alt=item.image.alt||'';
    var figcaption=item.image.closest('figure')&&item.image.closest('figure').querySelector('figcaption');
    caption.textContent=figcaption?figcaption.textContent.trim():(item.image.alt||'');
    caption.hidden=!caption.textContent;
    prev.hidden=next.hidden=items.length<2;
  }
  function open(index){lastFocus=document.activeElement;show(index);dialog.showModal();dialog.querySelector('.bd-lightbox-close').focus();}
  items.forEach(function(item,index){
    item.trigger.addEventListener('click',function(event){event.preventDefault();open(index);});
    if(item.trigger.tagName==='IMG')item.trigger.addEventListener('keydown',function(event){
      if(event.key==='Enter'||event.key===' '){event.preventDefault();open(index);}
    });
  });
  dialog.querySelector('.bd-lightbox-close').addEventListener('click',function(){dialog.close();});
  prev.addEventListener('click',function(){show(current-1);});
  next.addEventListener('click',function(){show(current+1);});
  dialog.addEventListener('keydown',function(event){
    if(event.key==='ArrowRight')show(current+1);
    if(event.key==='ArrowLeft')show(current-1);
  });
  dialog.addEventListener('close',function(){large.removeAttribute('src');if(lastFocus&&lastFocus.focus)lastFocus.focus();});
});
