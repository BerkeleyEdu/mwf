mwf.server=new function(){this.cookieNameLocal=mwf.site.cookie.prefix+"server";this.mustRedirect=false;this.mustReload=false;this.error=false;var b=mwf.site,d=mwf.classification,c=mwf.userAgent,a=mwf.screen;this.init=function(){if(!mwf.capability.cookie()){return}var e=d.generateCookieContent();if(!b.cookie.exists(d.cookieName)||b.cookie.classification!=e){this.setCookie(d.cookieName,e)}if(!b.cookie.exists(c.cookieName)){this.setCookie(c.cookieName,c.generateCookieContent())}if(!b.cookie.exists(a.cookieName)){this.setCookie(a.cookieName,a.generateCookieContent())}if(this.error){return}if(this.mustReload&&!mwf.override.isRedirecting){document.location.reload()}else{if(this.mustRedirect&&!mwf.override.isRedirecting){window.location=b.asset.root+"/passthru.php?return="+encodeURIComponent(window.location)}}};this.setCookie=function(g,e){var f=mwf.site.local.isSameOrigin();if(f){document.cookie=g+"="+e+";path=/";this.mustReload=true}else{this.mustRedirect=true}}};mwf.server.init();