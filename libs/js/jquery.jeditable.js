/*
 * Jeditable - jQuery in place edit plugin
 *
 * Copyright (c) 2006-2009 Mika Tuupola, Dylan Verheul
 *
 * Licensed under the MIT license:
 *   http://www.opensource.org/licenses/mit-license.php
 *
 * Project home:
 *   http://www.appelsiini.net/projects/jeditable
 *
 * Based on editable by Dylan Verheul <dylan_at_dyve.net>:
 *    http://www.dyve.net/jquery/?editable
 *
 *//**
  * Version 1.7.1
  *
  * ** means there is basic unit tests for this parameter. 
  *
  * @name  Jeditable
  * @type  jQuery
  * @param String  target             (POST) URL or function to send edited content to **
  * @param Hash    options            additional options 
  * @param String  options[method]    method to use to send edited content (POST or PUT) **
  * @param Function options[callback] Function to run after submitting edited content **
  * @param String  options[name]      POST parameter name of edited content
  * @param String  options[id]        POST parameter name of edited div id
  * @param Hash    options[submitdata] Extra parameters to send when submitting edited content.
  * @param String  options[type]      text, textarea or select (or any 3rd party input type) **
  * @param Integer options[rows]      number of rows if using textarea ** 
  * @param Integer options[cols]      number of columns if using textarea **
  * @param Mixed   options[height]    'auto', 'none' or height in pixels **
  * @param Mixed   options[width]     'auto', 'none' or width in pixels **
  * @param String  options[loadurl]   URL to fetch input content before editing **
  * @param String  options[loadtype]  Request type for load url. Should be GET or POST.
  * @param String  options[loadtext]  Text to display while loading external content.
  * @param Mixed   options[loaddata]  Extra parameters to pass when fetching content before editing.
  * @param Mixed   options[data]      Or content given as paramameter. String or function.**
  * @param String  options[indicator] indicator html to show when saving
  * @param String  options[tooltip]   optional tooltip text via title attribute **
  * @param String  options[event]     jQuery event such as 'click' of 'dblclick' **
  * @param String  options[submit]    submit button value, empty means no button **
  * @param String  options[cancel]    cancel button value, empty means no button **
  * @param String  options[cssclass]  CSS class to apply to input form. 'inherit' to copy from parent. **
  * @param String  options[style]     Style to apply to input form 'inherit' to copy from parent. **
  * @param String  options[select]    true or false, when true text is highlighted ??
  * @param String  options[placeholder] Placeholder text or html to insert when element is empty. **
  * @param String  options[onblur]    'cancel', 'submit', 'ignore' or function ??
  *             
  * @param Function options[onsubmit] function(settings, original) { ... } called before submit
  * @param Function options[onreset]  function(settings, original) { ... } called before reset
  * @param Function options[onerror]  function(settings, original, xhr) { ... } called on error
  *             
  * @param Hash    options[ajaxoptions]  jQuery Ajax options. See docs.jquery.com.
  *             
  */(function($){$.fn.editable=function(e,t){if("disable"==e){$(this).data("disabled.editable",!0);return}if("enable"==e){$(this).data("disabled.editable",!1);return}if("destroy"==e){$(this).unbind($(this).data("event.editable")).removeData("disabled.editable").removeData("event.editable");return}var n=$.extend({},$.fn.editable.defaults,{target:e},t),r=$.editable.types[n.type].plugin||function(){},i=$.editable.types[n.type].submit||function(){},s=$.editable.types[n.type].buttons||$.editable.types.defaults.buttons,o=$.editable.types[n.type].content||$.editable.types.defaults.content,u=$.editable.types[n.type].element||$.editable.types.defaults.element,a=$.editable.types[n.type].reset||$.editable.types.defaults.reset,f=n.callback||function(){},l=n.onedit||function(){},c=n.onsubmit||function(){},h=n.onreset||function(){},p=n.onerror||a;n.tooltip&&$(this).attr("title",n.tooltip);n.autowidth="auto"==n.width;n.autoheight="auto"==n.height;return this.each(function(){var e=this,t=$(e).width(),d=$(e).height();$(this).data("event.editable",n.event);$.trim($(this).html())||$(this).html(n.placeholder);$(this).bind(n.event,function(h){if(!0===$(this).data("disabled.editable"))return;if(e.editing)return;if(!1===l.apply(this,[n,e]))return;h.preventDefault();h.stopPropagation();n.tooltip&&$(e).removeAttr("title");if(0==$(e).width()){n.width=t;n.height=d}else{n.width!="none"&&(n.width=n.autowidth?$(e).width():n.width);n.height!="none"&&(n.height=n.autoheight?$(e).height():n.height)}$(this).html().toLowerCase().replace(/(;|")/g,"")==n.placeholder.toLowerCase().replace(/(;|")/g,"")&&$(this).html("");e.editing=!0;e.revert=$(e).html();$(e).html("");var v=$("<form />");n.cssclass&&("inherit"==n.cssclass?v.attr("class",$(e).attr("class")):v.attr("class",n.cssclass));if(n.style)if("inherit"==n.style){v.attr("style",$(e).attr("style"));v.css("display",$(e).css("display"))}else v.attr("style",n.style);var m=u.apply(v,[n,e]),g;if(n.loadurl){var y=setTimeout(function(){m.disabled=!0;o.apply(v,[n.loadtext,n,e])},100),b={};b[n.id]=e.id;$.isFunction(n.loaddata)?$.extend(b,n.loaddata.apply(e,[e.revert,n])):$.extend(b,n.loaddata);$.ajax({type:n.loadtype,url:n.loadurl,data:b,async:!1,success:function(e){window.clearTimeout(y);g=e;m.disabled=!1}})}else if(n.data){g=n.data;$.isFunction(n.data)&&(g=n.data.apply(e,[e.revert,n]))}else g=e.revert;o.apply(v,[g,n,e]);m.attr("name",n.name);s.apply(v,[n,e]);$(e).append(v);r.apply(v,[n,e]);$(":input:visible:enabled:first",v).focus();n.select&&m.select();m.keydown(function(t){if(t.keyCode==27){t.preventDefault();a.apply(v,[n,e])}});var y;"cancel"==n.onblur?m.blur(function(t){y=setTimeout(function(){a.apply(v,[n,e])},500)}):"submit"==n.onblur?m.blur(function(e){y=setTimeout(function(){v.submit()},200)}):$.isFunction(n.onblur)?m.blur(function(t){n.onblur.apply(e,[m.val(),n])}):m.blur(function(e){});v.submit(function(t){y&&clearTimeout(y);t.preventDefault();if(!1!==c.apply(v,[n,e])&&!1!==i.apply(v,[n,e]))if($.isFunction(n.target)){var r=n.target.apply(e,[m.val(),n]);$(e).html(r);e.editing=!1;f.apply(e,[e.innerHTML,n]);$.trim($(e).html())||$(e).html(n.placeholder)}else{var s={};s[n.name]=m.val();s[n.id]=e.id;$.isFunction(n.submitdata)?$.extend(s,n.submitdata.apply(e,[e.revert,n])):$.extend(s,n.submitdata);"PUT"==n.method&&(s._method="put");$(e).html(n.indicator);var o={type:"POST",data:s,dataType:"html",url:n.target,success:function(t,r){o.dataType=="html"&&$(e).html(t);e.editing=!1;f.apply(e,[t,n]);$.trim($(e).html())||$(e).html(n.placeholder)},error:function(t,r,i){p.apply(v,[n,e,t])}};$.extend(o,n.ajaxoptions);$.ajax(o)}$(e).attr("title",n.tooltip);return!1})});this.reset=function(t){if(this.editing&&!1!==h.apply(t,[n,e])){$(e).html(e.revert);e.editing=!1;$.trim($(e).html())||$(e).html(n.placeholder);n.tooltip&&$(e).attr("title",n.tooltip)}}})};$.editable={types:{defaults:{element:function(e,t){var n=$('<input type="hidden"></input>');$(this).append(n);return n},content:function(e,t,n){$(":input:first",this).val(e)},reset:function(e,t){t.reset(this)},buttons:function(e,t){var n=this;if(e.submit){if(e.submit.match(/>$/))var r=$(e.submit).click(function(){r.attr("type")!="submit"&&n.submit()});else{var r=$('<button type="submit" />');r.html(e.submit)}$(this).append(r)}if(e.cancel){if(e.cancel.match(/>$/))var i=$(e.cancel);else{var i=$('<button type="cancel" />');i.html(e.cancel)}$(this).append(i);$(i).click(function(r){if($.isFunction($.editable.types[e.type].reset))var i=$.editable.types[e.type].reset;else var i=$.editable.types.defaults.reset;i.apply(n,[e,t]);return!1})}}},text:{element:function(e,t){var n=$("<input />");e.width!="none"&&n.width(e.width);e.height!="none"&&n.height(e.height);n.attr("autocomplete","off");$(this).append(n);return n}},textarea:{element:function(e,t){var n=$("<textarea />");e.rows?n.attr("rows",e.rows):e.height!="none"&&n.height(e.height);e.cols?n.attr("cols",e.cols):e.width!="none"&&n.width(e.width);$(this).append(n);return n}},select:{element:function(e,t){var n=$("<select />");$(this).append(n);return n},content:function(data,settings,original){if(String==data.constructor)eval("var json = "+data);else var json=data;for(var key in json){if(!json.hasOwnProperty(key))continue;if("selected"==key)continue;var option=$("<option />").val(key).append(json[key]);$("select",this).append(option)}$("select",this).children().each(function(){($(this).val()==json["selected"]||$(this).text()==$.trim(original.revert))&&$(this).attr("selected","selected")})}}},addInputType:function(e,t){$.editable.types[e]=t}};$.fn.editable.defaults={name:"value",id:"id",type:"text",width:"auto",height:"auto",event:"click.editable",onblur:"cancel",loadtype:"GET",loadtext:"Loading...",placeholder:"Click to edit",loaddata:{},submitdata:{},ajaxoptions:{}}})(jQuery);