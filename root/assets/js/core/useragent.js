mwf.userAgent=new function(){this.cookieName=mwf.site.cookie.prefix+"user_agent";var b=navigator.userAgent.toLowerCase();var a=function(c){return b.indexOf(c)!=-1};this.getOS=function(){if(b.match(/(iphone)|(ipad)|(ipod)/)!=null){return"iphone_os"}var d=0,c=["android","blackberry","windows phone os","windows mobile","symbian","webos","mac os x","windows nt","linux"];for(;d<c.length;d++){if(a(c[d])){return c[d]}}return""};this.getOSVersion=function(){var c=b,d,e="";switch(this.getOS()){case"iphone_os":d=c.indexOf("iphone os")+10;e=c.substring(d,c.indexOf(" ",d));case"blackberry":if(c.substring(0,10)=="blackberry"){d=c.indexOf("/")+1;e=c.substring(d,c.indexOf(" ",d))}break;case"android":if((d=c.indexOf("android "))!=-1){d+=8;e=c.substring(d,Math.min(c.indexOf(" ",d),c.indexOf(";",d),c.indexOf("-",d)))}break;case"windows_phone":if((d=c.indexOf("windows phone os "))!=-1){d+=17;e=c.substring(d,c.indexOf(";",d))}break;case"windows_mobile":if((d=c.indexOf("windows mobile/"))!=-1){d+=15;e=c.substring(d,c.indexOf(";",d))}break;case"symbian":if((d=c.indexOf("symbianos/"))!=-1){d+=10;e=c.substring(d,c.indexOf(";",d))}else{if((d=c.indexOf("symbian/"))!=-1){d+=8;e="s"+c.substring(d,c.indexOf(";",d))}}break;case"webos":if((d=c.indexOf("webos/"))!=-1){d+=6;e=c.substring(d,Math.min(c.indexOf(";",d)))}break}return e.replace(/\_/g,".")};this.getBrowser=function(){if(a("safari")){return this.getOS()=="android"?"android_webkit":"safari"}var c=0,d=["chrome","iemobile","camino","seamonkey","firefox","opera_mobi","opera_mini"];for(;c<d.length;c++){if(a(d[c])){return d[c]}}return""};this.getBrowserEngine=function(){if(a("applewebkit")){return"webkit"}var d=0,c=["trident","gecko","presto","khtml"];for(;d<c.length;d++){if(a(c[d])){return c[d]}}return""};this.getBrowserEngineVersion=function(){var d=b,e;var c=function(g){var f=d.indexOf(g)+g.length;return d.substring(f,Math.min(d.indexOf(" ",f),d.indexOf(";",f)))};switch(this.getBrowserEngine()){case"webkit":return c("applewebkit/");case"trident":return c("trident/");case"gecko":return c("gecko/");case"presto":e=d.indexOf("presto/")+7;return d.substring(e,Math.min(d.indexOf("/",e),d.indexOf(" ",e),d.indexOf(")",e)))}return""};this.generateCookieContent=function(){var c="{";c+='"s":"'+navigator.userAgent+'"';if(t=this.getOS()){c+=',"os":"'+t+'"'}if(t=this.getOSVersion()){c+=',"osv":"'+t+'"'}if(t=this.getBrowser()){c+=',"b":"'+t+'"'}if(t=this.getBrowserEngine()){c+=',"be":"'+t+'"'}if(t=this.getBrowserEngineVersion()){c+=',"bev":"'+t+'"'}c+="}";return c}};