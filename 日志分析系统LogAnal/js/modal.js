/*
* jQuery modal plugin
*
* Created by Peter Viszt (gtpassatgt@gmail.com) on 2010-10-01.
*
*/
(function(a){a.fn.modal=function(b){var c={width:400,showSpeed:500,closeSpeed:500,title:true,skin:"default"};var b=a.extend(c,b);return this.each(function(){var e=a(this).attr("href");var d=e.substr(0,1);var g=a(this).attr("title");if(d=="#"){a(e).addClass("novisible")}a(this).click(function(){function h(){var s,q;if(window.innerHeight&&window.scrollMaxY){s=window.innerWidth+window.scrollMaxX;q=window.innerHeight+window.scrollMaxY}else{if(document.body.scrollHeight>document.body.offsetHeight){s=document.body.scrollWidth;q=document.body.scrollHeight}else{s=document.body.offsetWidth;q=document.body.offsetHeight}}var r,t;if(self.innerHeight){if(document.documentElement.clientWidth){r=document.documentElement.clientWidth}else{r=self.innerWidth}t=self.innerHeight}else{if(document.documentElement&&document.documentElement.clientHeight){r=document.documentElement.clientWidth;t=document.documentElement.clientHeight}else{if(document.body){r=document.body.clientWidth;t=document.body.clientHeight}}}if(q<t){pageHeight=t}else{pageHeight=q}if(s<r){pageWidth=s}else{pageWidth=r}return[pageWidth,pageHeight]}var k=h();var n="height:"+pageHeight+"px";var p="width:"+b.width+"px;";var l="left:"+(pageWidth-b.width)/2+"px";var j="left:"+(pageWidth-50)/2+"px";if(a.browser.msie){var n="height:"+pageHeight+"px;background:url(../images/overlay.png)";var l="left:"+(pageWidth-b.width)/2+"px;position:absolute;";var j="left:"+(pageWidth-50)/2+"px;position:absolute;"}var i='<div class="overlay" style="'+n+'"></div>';var o='<div class="modal_window '+b.skin+'" style="'+p+l+'"><div class="header"><h2>'+g+'<span>Close</span></h2></div><div id="modal_inner"></div></div>';if(a.browser.msie){var o='<div class="modal_window border '+b.skin+'" style="'+p+l+'"><div class="header"><h2>'+g+'<span>Close</span></h2></div><div id="modal_inner"></div></div>'}var m='<div class="modal_loader" style="'+j+'"></div>';a("body").append(i);a("body").append(o);a("body").append(m);if(g==0){a(".modal_window .header").hide()}else{if(b.title==false){a(".modal_window .header").hide()}}a(".overlay").fadeIn(b.showSpeed,function(){if(d=="#"){if(a(e).length==0){f();a().Message({time:5000,text:"This element doesn't exist: "+e})}else{a(e).clone().appendTo("#modal_inner")}a(".modal_loader").fadeOut();a(".modal_window").fadeIn()}else{a("#modal_inner").load(e,function(r,s,q){if(s=="error"){f();a().Message({time:5000,text:"There was an error making the AJAX request"})}a(".modal_loader").fadeOut();a(".modal_window").fadeIn()})}});a(".overlay,.header h2 span").click(function(){f()});return false});function f(){a(".modal_window,.overlay").fadeOut(b.closeSpeed,function(){a(".modal_window,.overlay,.modal_loader").remove()})}})}})(jQuery);