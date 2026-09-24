document.addEventListener('DOMContentLoaded',function(){
  var t=document.getElementById('menuToggle'),n=document.getElementById('mainNav');
  if(t&&n){t.addEventListener('click',function(){n.classList.toggle('open');});}
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
    var idx=0,timer=null;
    if(dotsBox){slides.forEach(function(_,i){
      var d=document.createElement('button');
      d.type='button';d.setAttribute('aria-label','اسلاید '+(i+1));
      d.addEventListener('click',function(){go(i);restart();});
      dotsBox.appendChild(d);
    });}
    var dots=dotsBox?Array.prototype.slice.call(dotsBox.children):[];
    function go(i){
      idx=(i+slides.length)%slides.length;
      slides.forEach(function(s,k){s.classList.toggle('active',k===idx);});
      dots.forEach(function(d,k){d.classList.toggle('active',k===idx);});
    }
    function restart(){
      if(timer){clearInterval(timer);timer=null;}
      var s=parseInt(slider.getAttribute('data-speed')||'5',10);
      if(isNaN(s)||s<0) s=5;
      if(s===0) return;
      timer=setInterval(function(){go(idx+1);},s*1000);
    }
    var prev=slider.querySelector('.bd-prev'),next=slider.querySelector('.bd-next');
    if(prev)prev.addEventListener('click',function(){go(idx-1);restart();});
    if(next)next.addEventListener('click',function(){go(idx+1);restart();});
    go(0);restart();
  }
  initSlider('bdSlider','.bd-slide');
  var topBtn=document.getElementById('bdToTop');
  if(topBtn){
    window.addEventListener('scroll',function(){topBtn.classList.toggle('show',window.scrollY>400);},{passive:true});
    topBtn.addEventListener('click',function(){window.scrollTo({top:0,behavior:'smooth'});});
  }
  var tour=document.getElementById('bdTourGrid');
  if(tour){
    var items=Array.prototype.slice.call(tour.querySelectorAll('.bd-tour-item'));
    if(items.length>4){
      var ts=parseInt(tour.getAttribute('data-speed')||'5',10);
      if(isNaN(ts)||ts<0) ts=5;
      function shuffleArr(a){for(var i=a.length-1;i>0;i--){var j=Math.floor(Math.random()*(i+1));var tmp=a[i];a[i]=a[j];a[j]=tmp;}return a;}
      var prev=items.filter(function(el){return !el.hidden;});
      if(ts>0){
        setInterval(function(){
          tour.classList.add('bd-tour-fading');
          setTimeout(function(){
            var shown=[];
            if(items.length>=8){
              var rest=shuffleArr(items.filter(function(el){return prev.indexOf(el)<0;}));
              shown=rest.slice(0,4);
              if(shown.length<4){
                var extra=shuffleArr(prev.filter(function(el){return shown.indexOf(el)<0;}));
                shown=shown.concat(extra.slice(0,4-shown.length));
              }
            }else{
              var pool=items.slice();
              while(shown.length<4&&pool.length){shown.push(pool.splice(Math.floor(Math.random()*pool.length),1)[0]);}
            }
            items.forEach(function(el){el.hidden=shown.indexOf(el)<0;});
            prev=shown;
            void tour.offsetWidth;
            tour.classList.remove('bd-tour-fading');
          },360);
        },ts*1000);
      }
    }
  }
});
