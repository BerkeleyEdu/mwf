mwf.full.customizableMenu=function(c){if(!Array.prototype.filter){Array.prototype.filter=function(f){if(this==null){throw new TypeError()}var k=Object(this);var e=k.length>>>0;if(typeof f!="function"){throw new TypeError()}var j=[];var h=arguments[1];for(var g=0;g<e;g++){if(g in k){var l=k[g];if(f.call(h,l,g,k)){j.push(l)}}}return j}}var d=function(){var f=null,h;if(mwf.standard.preferences.isSupported()){h=mwf.standard.preferences.get(c);if(h!==null){try{f=JSON.parse(h)}catch(g){f=null}}}return f};var b=[];var a=[];return{render:function(h){var j,f,m,g;var l=document.getElementById(h);if(l===null){return}var e="";var k=d();if(k===null){k={};k.items=[];for(j=0;j<b.length;j++){k.items.push({key:b[j].key,on:1});e+=b[j].value}if(mwf.standard.preferences.isSupported()){mwf.standard.preferences.set(c,JSON.stringify(k))}}else{f=k.items||[];m=[];for(j=0;j<f.length;j++){if(f[j].hasOwnProperty("key")){m.push(f[j].key);if(f[j].hasOwnProperty("on")){if(f[j].on===1){g=b.filter(function(n,i,o){return n.key===this.key},f[j]);if(g.length>0){e+=g[0].value}}else{if(f[j].on===0){g=a.filter(function(n,i,o){return n.key===this.key},f[j]);if(g.length>0){e+=g[0].value}}}}}}for(j=0;j<b.length;j++){if(m.indexOf(b[j].key)==-1){e+=b[j].value;k.items.push({key:b[j].key,on:1})}}if(mwf.standard.preferences.isSupported()){mwf.standard.preferences.set(c,JSON.stringify(k))}}l.innerHTML=e},addItem:function(g,f,e){g=parseInt(g,10);b.push({key:g,value:f||""});a.push({key:g,value:e||""})},enableItem:function(l,f){l=parseInt(l,10);var g,k,e,j;var h=d();e=f?1:0;k={key:l,on:e};if(h===null){h={}}if(!h.hasOwnProperty("items")){h.items=[]}j=false;for(g in h.items){if(h.items[g].hasOwnProperty("key")&&h.items[g].key===l){h.items[g].on=e;j=true;break}}if(!j){h.items.push(k)}mwf.standard.preferences.set(c,JSON.stringify(h))},setItemPosition:function(g,e){g=parseInt(g,10);var f=d()||{};if(!f.hasOwnProperty("items")){f.items=[]}f.items[e-1]={key:g,on:1};mwf.standard.preferences.set(c,JSON.stringify(f))},reset:function(){mwf.standard.preferences.clear(c)}}};