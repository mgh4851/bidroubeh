document.addEventListener('DOMContentLoaded',function(){
  var t=document.getElementById('menuToggle'),n=document.getElementById('mainNav');
  if(t&&n){t.setAttribute('aria-controls','mainNav');t.setAttribute('aria-expanded','false');t.addEventListener('click',function(){var open=n.classList.toggle('open');t.setAttribute('aria-expanded',open?'true':'false');});}
  Array.prototype.forEach.call(document.querySelectorAll('.bd-faq-q'),function(btn){
    btn.addEventListener('click',function(){
      var item=btn.parentElement,a=item.querySelector('.bd-faq-a'),open=item.classList.contains('open');
      Array.prototype.forEach.call(document.querySelectorAll('.bd-faq-item.open'),function(o){o.classList.remove('open');o.querySelector('.bd-faq-a').style.maxHeight=null;o.querySelector('.bd-faq-q').setAttribute('aria-expanded','false');});
      if(!open){item.classList.add('open');a.style.maxHeight=a.scrollHeight+'px';btn.setAttribute('aria-expanded','true');}
    });
  });
  function initSlider(id,slideSel){
    var slider=document.getElementById(id);
    if(!slider) return;
    var slides=Array.prototype.slice.call(slider.querySelectorAll(slideSel));
    if(!slides.length) return;
    var dotsBox=slider.querySelector('.bd-dots');
    var idx=0,timer=null,cleanupTimer=null;
    var speed=parseInt(slider.getAttribute('data-speed')||'0',10);
    var reduced=window.matchMedia&&window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if(dotsBox){slides.forEach(function(_,i){
      var d=document.createElement('button');
      d.type='button';d.setAttribute('aria-label','اسلاید '+(i+1));
      d.addEventListener('click',function(){go(i,i<idx?'prev':'next');restart();});
      dotsBox.appendChild(d);
    });}
    var dots=dotsBox?Array.prototype.slice.call(dotsBox.children):[];
    function go(i,direction,initial){
      var target=(i+slides.length)%slides.length;
      if(target===idx&&!initial)return;
      var old=slides[idx],incoming=slides[target];
      var animate=!initial&&!reduced&&slides.length>1;
      clearTimeout(cleanupTimer);
      slides.forEach(function(s){s.classList.remove('bd-slide-leaving-left','bd-slide-leaving-right','bd-slide-from-left');});
      if(animate){
        old.classList.remove('active');
        old.classList.add(direction==='prev'?'bd-slide-leaving-right':'bd-slide-leaving-left');
        if(direction==='prev')incoming.classList.add('bd-slide-from-left');
        incoming.getBoundingClientRect();
        incoming.classList.add('active');
        cleanupTimer=setTimeout(function(){slides.forEach(function(s){s.classList.remove('bd-slide-leaving-left','bd-slide-leaving-right','bd-slide-from-left');});},700);
      }else slides.forEach(function(s,k){s.classList.toggle('active',k===target);});
      idx=target;
      slides.forEach(function(s,k){s.setAttribute('aria-hidden',k===idx?'false':'true');s.inert=k!==idx;});
      dots.forEach(function(d,k){d.classList.toggle('active',k===idx);d.setAttribute('aria-pressed',k===idx?'true':'false');});
    }
    function restart(){
      if(timer)clearInterval(timer);
      if(!reduced&&speed>0&&slides.length>1)timer=setInterval(function(){go(idx+1,'next');},speed*1000);
    }
    var prev=slider.querySelector('.bd-prev'),next=slider.querySelector('.bd-next');
    if(prev)prev.addEventListener('click',function(){go(idx-1,'prev');restart();});
    if(next)next.addEventListener('click',function(){go(idx+1,'next');restart();});
    go(0,'next',true);
    restart();
  }
  initSlider('bdSlider','.bd-slide');
  function initMiniSlider(id){
    var slider=document.getElementById(id);
    if(!slider)return;
    var slides=Array.prototype.slice.call(slider.querySelectorAll('.bd-mini-slide'));
    if(!slides.length)return;
    var idx=0,timer=null,cleanupTimer=null;
    var speed=parseInt(slider.getAttribute('data-speed')||'0',10);
    var reduced=window.matchMedia&&window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    var counter=slider.querySelector('.bd-mini-counter');
    var fa='۰۱۲۳۴۵۶۷۸۹';
    function faNum(n){return String(n).replace(/[0-9]/g,function(d){return fa[d];});}
    function go(i,direction,initial){
      var target=(i+slides.length)%slides.length;
      if(target===idx&&!initial)return;
      var old=slides[idx],incoming=slides[target];
      clearTimeout(cleanupTimer);
      slides.forEach(function(s){s.classList.remove('bd-mini-leaving-left','bd-mini-leaving-right','bd-mini-from-left');});
      if(!initial&&!reduced&&slides.length>1){
        old.classList.remove('active');
        old.classList.add(direction==='prev'?'bd-mini-leaving-right':'bd-mini-leaving-left');
        if(direction==='prev')incoming.classList.add('bd-mini-from-left');
        incoming.getBoundingClientRect();
        incoming.classList.add('active');
        cleanupTimer=setTimeout(function(){slides.forEach(function(s){s.classList.remove('bd-mini-leaving-left','bd-mini-leaving-right','bd-mini-from-left');});},520);
      }else slides.forEach(function(s,k){s.classList.toggle('active',k===target);});
      idx=target;
      slides.forEach(function(s,k){s.setAttribute('aria-hidden',k===idx?'false':'true');s.inert=k!==idx;});
      if(counter)counter.textContent=faNum(idx+1)+' از '+faNum(slides.length);
    }
    function restart(){
      if(timer)clearInterval(timer);
      if(!reduced&&speed>0&&slides.length>1)timer=setInterval(function(){go(idx+1,'next');},speed*1000);
    }
    var prev=slider.querySelector('.bd-mini-prev'),next=slider.querySelector('.bd-mini-next');
    if(prev)prev.addEventListener('click',function(){go(idx-1,'prev');restart();});
    if(next)next.addEventListener('click',function(){go(idx+1,'next');restart();});
    go(0,'next',true);
    restart();
  }
  initMiniSlider('bdNoticeSlider');
  initMiniSlider('bdNewsSlider');
  (function initTourism(){
    var grid=document.getElementById('bdTourGrid');
    if(!grid)return;
    var cards=Array.prototype.slice.call(grid.querySelectorAll('.bd-tour-item'));
    var speed=parseInt(grid.getAttribute('data-speed')||'0',10);
    var reduced=window.matchMedia&&window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    if(cards.length<=4||!speed)return;
    var changing=false;
    function shuffle(items){
      for(var i=items.length-1;i>0;i--){var j=Math.floor(Math.random()*(i+1));var tmp=items[i];items[i]=items[j];items[j]=tmp;}
      return items;
    }
    function rotate(){
      if(changing)return;
      changing=true;
      var hidden=shuffle(cards.filter(function(card){return card.hidden;}));
      var visible=shuffle(cards.filter(function(card){return !card.hidden;}));
      var next=hidden.slice(0,4);
      if(next.length<4)next=next.concat(visible.slice(0,4-next.length));
      grid.classList.add('bd-tour-leaving');
      setTimeout(function(){
        cards.forEach(function(card){card.hidden=next.indexOf(card)===-1;});
        grid.classList.remove('bd-tour-leaving');
        grid.classList.add('bd-tour-entering');
        grid.getBoundingClientRect();
        setTimeout(function(){
          grid.classList.remove('bd-tour-entering');
          setTimeout(function(){changing=false;},740);
        },32);
      },740);
    }
    if(!reduced)setInterval(rotate,speed*1000);
  })();
  document.querySelectorAll('.sidebar .widget_categories').forEach(function(widget){
    var heading=widget.querySelector('h2,h3,.widget-title');
    if(!heading||widget.querySelector('details'))return;
    var details=document.createElement('details');
    var summary=document.createElement('summary');
    summary.appendChild(heading);
    details.appendChild(summary);
    while(widget.firstChild)details.appendChild(widget.firstChild);
    details.className='bd-category-disclosure';
    details.open=!window.matchMedia('(max-width:720px)').matches;
    widget.appendChild(details);
  });
  var topBtn=document.getElementById('bdToTop');
  if(topBtn){
    window.addEventListener('scroll',function(){topBtn.classList.toggle('show',window.scrollY>400);},{passive:true});
    topBtn.addEventListener('click',function(){window.scrollTo({top:0,behavior:'smooth'});});
  }
});
