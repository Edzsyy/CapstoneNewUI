var $jscomp=$jscomp||{};$jscomp.scope={},$jscomp.findInternal=function(t,a,e){t instanceof String&&(t=String(t));for(var n=t.length,s=0;s<n;s++){var o=t[s];if(a.call(e,o,s,t))return{i:s,v:o}}return{i:-1,v:void 0}},$jscomp.ASSUME_ES5=!1,$jscomp.ASSUME_NO_NATIVE_MAP=!1,$jscomp.ASSUME_NO_NATIVE_SET=!1,$jscomp.SIMPLE_FROUND_POLYFILL=!1,$jscomp.defineProperty=$jscomp.ASSUME_ES5||"function"==typeof Object.defineProperties?Object.defineProperty:function(t,a,e){t!=Array.prototype&&t!=Object.prototype&&(t[a]=e.value)},$jscomp.getGlobal=function(t){return("undefined"==typeof window||window!==t)&&"undefined"!=typeof global&&null!=global?global:t},$jscomp.global=$jscomp.getGlobal(this),$jscomp.polyfill=function(t,a,e,n){if(a){for(e=$jscomp.global,t=t.split("."),n=0;n<t.length-1;n++){var s=t[n];s in e||(e[s]={}),e=e[s]}(a=a(n=e[t=t[t.length-1]]))!=n&&null!=a&&$jscomp.defineProperty(e,t,{configurable:!0,writable:!0,value:a})}},$jscomp.polyfill("Array.prototype.find",function(t){return t||function(t,a){return $jscomp.findInternal(this,t,a).v}},"es6","es3"),function(t,a,e){"function"==typeof define&&define.amd?define(["jquery"],t):"object"==typeof exports&&"undefined"==typeof Meteor?module.exports=t(require("jquery")):t(a||e)}(function(r){function i(c,g,M){var y={invalid:[],getCaret:function(){try{var t,a=0,e=c.get(0),n=document.selection,s=e.selectionStart;return n&&-1===navigator.appVersion.indexOf("MSIE 10")?((t=n.createRange()).moveStart("character",-y.val().length),a=t.text.length):!s&&"0"!==s||(a=s),a}catch(t){}},setCaret:function(t){try{var a,e;c.is(":focus")&&((a=c.get(0)).setSelectionRange?a.setSelectionRange(t,t):((e=a.createTextRange()).collapse(!0),e.moveEnd("character",t),e.moveStart("character",t),e.select()))}catch(t){}},events:function(){c.on("keydown.mask",function(t){c.data("mask-keycode",t.keyCode||t.which),c.data("mask-previus-value",c.val()),c.data("mask-previus-caret-pos",y.getCaret()),y.maskDigitPosMapOld=y.maskDigitPosMap}).on(r.jMaskGlobals.useInput?"input.mask":"keyup.mask",y.behaviour).on("paste.mask drop.mask",function(){setTimeout(function(){c.keydown().keyup()},100)}).on("change.mask",function(){c.data("changed",!0)}).on("blur.mask",function(){o===y.val()||c.data("changed")||c.trigger("change"),c.data("changed",!1)}).on("blur.mask",function(){o=y.val()}).on("focus.mask",function(t){!0===M.selectOnFocus&&r(t.target).select()}).on("focusout.mask",function(){M.clearIfNotMatch&&!n.test(y.val())&&y.val("")})},getRegexMask:function(){for(var t,a,e,n,s=[],o=0;o<g.length;o++)(t=b.translation[g.charAt(o)])?(a=t.pattern.toString().replace(/.{1}$|^.{1}/g,""),e=t.optional,(t=t.recursive)?(s.push(g.charAt(o)),n={digit:g.charAt(o),pattern:a}):s.push(e||t?a+"?":a)):s.push(g.charAt(o).replace(/[-\/\\^$*+?.()|[\]{}]/g,"\\$&"));return s=s.join(""),n&&(s=s.replace(new RegExp("("+n.digit+"(.*"+n.digit+")?)"),"($1)?").replace(new RegExp(n.digit,"g"),n.pattern)),new RegExp(s)},destroyEvents:function(){c.off("input keydown keyup paste drop blur focusout ".split(" ").join(".mask "))},val:function(t){var a=c.is("input")?"val":"text";return a=0<arguments.length?(c[a]()!==t&&c[a](t),c):c[a]()},calculateCaretPosition:function(t){var a=y.getMasked(),e=y.getCaret();if(t!==a){for(var n=c.data("mask-previus-caret-pos")||0,a=a.length,s=t.length,o=t=0,r=0,i=0,l=e;l<a&&y.maskDigitPosMap[l];l++)o++;for(l=e-1;0<=l&&y.maskDigitPosMap[l];l--)t++;for(l=e-1;0<=l;l--)y.maskDigitPosMap[l]&&r++;for(l=n-1;0<=l;l--)y.maskDigitPosMapOld[l]&&i++;s<e?e=10*a:e<=n&&n!==s?y.maskDigitPosMapOld[e]||(e=(n=e)-(i-r)-t,y.maskDigitPosMap[e]&&(e=n)):n<e&&(e=e+(r-i)+o)}return e},behaviour:function(t){t=t||window.event,y.invalid=[];var a=c.data("mask-keycode");if(-1===r.inArray(a,b.byPassKeys)){a=y.getMasked();var e=y.getCaret(),n=c.data("mask-previus-value")||"";return setTimeout(function(){y.setCaret(y.calculateCaretPosition(n))},r.jMaskGlobals.keyStrokeCompensation),y.val(a),y.setCaret(e),y.callbacks(t)}},getMasked:function(t,a){var e,n,s,o=[],r=void 0===a?y.val():a+"",i=0,l=g.length,c=0,u=r.length,p=1,f="push",d=-1,k=0;for(a=[],n=M.reverse?(f="unshift",p=-1,e=0,i=l-1,c=u-1,function(){return-1<i&&-1<c}):(e=l-1,function(){return i<l&&c<u});n();){var m=g.charAt(i),h=r.charAt(c),v=b.translation[m];v?(h.match(v.pattern)?(o[f](h),v.recursive&&(-1===d?d=i:i===e&&i!==d&&(i=d-p),e===d&&(i-=p)),i+=p):h===s?(k--,s=void 0):v.optional?(i+=p,c-=p):v.fallback?(o[f](v.fallback),i+=p,c-=p):y.invalid.push({p:c,v:h,e:v.pattern}),c+=p):(t||o[f](m),h===m?(a.push(c),c+=p):(s=m,a.push(c+k),k++),i+=p)}return t=g.charAt(e),l!==u+1||b.translation[t]||o.push(t),o=o.join(""),y.mapMaskdigitPositions(o,a,u),o},mapMaskdigitPositions:function(t,a,e){for(t=M.reverse?t.length-e:0,y.maskDigitPosMap={},e=0;e<a.length;e++)y.maskDigitPosMap[a[e]+t]=1},callbacks:function(t){function a(t,a,e){"function"==typeof M[t]&&a&&M[t].apply(this,e)}var e=y.val(),n=e!==o,s=[e,t,c,M];a("onChange",!0==n,s),a("onKeyPress",!0==n,s),a("onComplete",e.length===g.length,s),a("onInvalid",0<y.invalid.length,[e,t,c,y.invalid,M])}};c=r(c);var n,b=this,o=y.val();g="function"==typeof g?g(y.val(),void 0,c,M):g,b.mask=g,b.options=M,b.remove=function(){var t=y.getCaret();return b.options.placeholder&&c.removeAttr("placeholder"),c.data("mask-maxlength")&&c.removeAttr("maxlength"),y.destroyEvents(),y.val(b.getCleanVal()),y.setCaret(t),c},b.getCleanVal=function(){return y.getMasked(!0)},b.getMaskedVal=function(t){return y.getMasked(!1,t)},b.init=function(t){if(t=t||!1,M=M||{},b.clearIfNotMatch=r.jMaskGlobals.clearIfNotMatch,b.byPassKeys=r.jMaskGlobals.byPassKeys,b.translation=r.extend({},r.jMaskGlobals.translation,M.translation),b=r.extend(!0,{},b,M),n=y.getRegexMask(),t)y.events(),y.val(y.getMasked());else{M.placeholder&&c.attr("placeholder",M.placeholder),c.data("mask")&&c.attr("autocomplete","off");for(var a=!(t=0);t<g.length;t++){var e=b.translation[g.charAt(t)];if(e&&e.recursive){a=!1;break}}a&&c.attr("maxlength",g.length).data("mask-maxlength",!0),y.destroyEvents(),y.events(),t=y.getCaret(),y.val(y.getMasked()),y.setCaret(t)}},b.init(!c.is("input"))}r.maskWatchers={};function a(){var t=r(this),a={},e=t.attr("data-mask");if(t.attr("data-mask-reverse")&&(a.reverse=!0),t.attr("data-mask-clearifnotmatch")&&(a.clearIfNotMatch=!0),"true"===t.attr("data-mask-selectonfocus")&&(a.selectOnFocus=!0),l(t,e,a))return t.data("mask",new i(this,e,a))}var l=function(t,a,e){e=e||{};var n=r(t).data("mask"),s=JSON.stringify;t=r(t).val()||r(t).text();try{return"function"==typeof a&&(a=a(t)),"object"!=typeof n||s(n.options)!==s(e)||n.mask!==a}catch(t){}},t=function(t){var a=document.createElement("div"),e=(t="on"+t)in a;return e||(a.setAttribute(t,"return;"),e="function"==typeof a[t]),e};r.fn.mask=function(t,a){a=a||{};function e(){if(l(this,t,a))return r(this).data("mask",new i(this,t,a))}var n=this.selector,s=(o=r.jMaskGlobals).watchInterval,o=a.watchInputs||o.watchInputs;return r(this).each(e),n&&""!==n&&o&&(clearInterval(r.maskWatchers[n]),r.maskWatchers[n]=setInterval(function(){r(document).find(n).each(e)},s)),this},r.fn.masked=function(t){return this.data("mask").getMaskedVal(t)},r.fn.unmask=function(){return clearInterval(r.maskWatchers[this.selector]),delete r.maskWatchers[this.selector],this.each(function(){var t=r(this).data("mask");t&&t.remove().removeData("mask")})},r.fn.cleanVal=function(){return this.data("mask").getCleanVal()},r.applyDataMask=function(t){((t=t||r.jMaskGlobals.maskElements)instanceof r?t:r(t)).filter(r.jMaskGlobals.dataMaskAttr).each(a)},t={maskElements:"input,td,span,div",dataMaskAttr:"*[data-mask]",dataMask:!0,watchInterval:300,watchInputs:!0,keyStrokeCompensation:10,useInput:!/Chrome\/[2-4][0-9]|SamsungBrowser/.test(window.navigator.userAgent)&&t("input"),watchDataMask:!1,byPassKeys:[9,16,17,18,36,37,38,39,40,91],translation:{0:{pattern:/\d/},9:{pattern:/\d/,optional:!0},"#":{pattern:/\d/,recursive:!0},A:{pattern:/[a-zA-Z0-9]/},S:{pattern:/[a-zA-Z]/}}},r.jMaskGlobals=r.jMaskGlobals||{},(t=r.jMaskGlobals=r.extend(!0,{},t,r.jMaskGlobals)).dataMask&&r.applyDataMask(),setInterval(function(){r.jMaskGlobals.watchDataMask&&r.applyDataMask()},t.watchInterval)},window.jQuery,window.Zepto);