function initSlides(){$("#gospelcenter_pagebundle_page_slides").hide();$("#gospelcenter_pagebundle_pageglobaltype_slides").hide();var e=$("#slide").html(),t=Handlebars.compile(e),n=t();$("fieldset#slides").append(n);$("article.slide").each(function(e){var t=$(this).attr("id");$("div[id=gospelcenter_pagebundle_page_slides_"+e+"] input").attr("data-slide",t);$("div[id=gospelcenter_pagebundle_pageglobaltype_slides_"+e+"] input").attr("data-slide",t)})}function moveSlideUp(e){$(e).prev().before($(e));var t=$(e).attr("id");updateSort()}function moveSlideDown(e){$(e).next().after($(e));var t=$(e).attr("id");updateSort()}function updateSort(){$("article.slide").each(function(e){var t=$(this).attr("id");$("input[data-slide="+t+"]").val(e+1)})}function formMultiplePage(){$("fieldset.page").hide();$("fieldset.page:first").show();var e='<nav class="sub_nav"><ul></ul></nav>';$("fieldset.header").after(e);var t=$("nav.sub_nav ul");$("fieldset.page").each(function(e){var n=$("legend",this).html();$(t).append('<li><a id="'+(e+1)+'" href="#">'+n+"</a></li>");e==0&&$("li a",t).addClass("current")});$("fieldset.page > legend").remove()}function setDateTime(e){var t=$(e).val(),n=stringToDate(t);if(n!=null){n=Date.parse(n).toString("d MMMM yyyy");t=n}else t="";$(e).val(t);$(e).autoGrowInput()}function switchFieldset(e){$("fieldset.page").hide();$("fieldset.page").each(function(t){t==e-1&&$(this).show()});$("nav.sub_nav a").removeClass("current");$("nav.sub_nav ul li:nth-of-type("+e+") a").addClass("current")}function stylingForm(){$("input[type=datetime]").each(function(){var e=$(this).data("structure");$(this).attr("placeholder",e)})}function displayMultipleRelationFrom(){$("form fieldset[data-prototype]").each(function(){var e=$(this).data("legend");$(this).attr("id",e);$(this).append("<legend>"+e+"</legend>");var t=$('<a href="#" data-id="'+e+'" id="add" class="buttonRounded">Add a new '+e+"</a>");$(this).append(t);$(this).attr("data-nbField","0")})}function addEntityForm(e){console.log(e);var t=$(e).data("nbfield");t++;var n=$(e).data("legend"),r=$(e).data("prototype").replace(/__name__label__/g,n+t).replace(/__name__/g,t),i=$(r).attr("id");console.log(t);$(e).append(r);$(e).data("nbfield",t)}function deleteEntityForm(){}function stringToDate(e){var t=!1,n=!1,r=!1,i=new RegExp("[ ,;/.]+","g"),s=e.split(i);0<s[0]<32&&(t=!0);Date.parse(s[1])&&(n=!0);if(s.length>1&&!n){s[1]=removeDiacritics(s[1]);var o={janvier:1,fevrier:2,mars:3,avril:4,mai:5,juin:6,juillet:7,aout:8,septembre:9,octobre:10,novembre:11,decembre:12,january:1,february:2,march:3,april:4,may:5,june:6,july:7,august:8,september:9,october:10,november:11,december:12,januar:1,februar:2,marz:3,april:4,Mai:5,Juni:6,Juli:7,August:8,September:9,Oktober:10,November:11,Dezember:12},u=o[s[1]];if(0<u<13){n=!0;s[1]=u}}if(s.length>2)s[2]>0&&(r=!0);else{year=(new Date).toString("yyyy");s[2]=year;r=!0}if(t&&n&&r){day=s[0];s[0]=s[1];s[1]=day;return s.toString()}return null}function removeDiacritics(e){var t=e.split(""),n="";for(var r=0;r<t.length;r++)n+=t[r]in diacriticsMap?diacriticsMap[t[r]]:t[r];return n}function initCheckBox(e){$(e).parent().addClass("checkbox");var t=$(e).data("icon");$(e).after('<div id="'+t+'" class="icon"></div>');$(e).attr("checked")&&$("div[id="+t+"]").addClass("selected");$(e).hide()}function setCheckbox(e){var t=$(e).attr("id");console.log(t);$(e).hasClass("selected")?$(e).removeClass("selected"):$(e).addClass("selected");$("input[data-icon="+t+"]").attr("checked")?$("input[data-icon="+t+"]").prop("checked",!1):$("input[data-icon="+t+"]").prop("checked",!0)}function initRadio(e){$(e).parent().addClass("radio");var t=$(e).data("icon"),n='<div id="'+t+'" class="radio-icon">';$("input[type=radio]",e).each(function(){var e=$(this).val(),t="";$(this).attr("checked")&&(t="selected");n+='<div id="'+e+'" class="'+t+'"></div>'});n+="</div>";$(e).after(n);$(e).hide()}function setRadio(e){var t=$(e).parent().attr("id"),n=$(e).attr("id"),r=$(e).parent();$("div",r).each(function(){$(this).removeClass("selected")});$(e).hasClass("selected")?$(e).removeClass("selected"):$(e).addClass("selected");$("div[data-icon="+t+"] input[value="+n+"]").attr("checked")?$("div[data-icon="+t+"] input[value="+n+"]").prop("checked",!1):$("div[data-icon="+t+"] input[value="+n+"]").prop("checked",!0)}function setSelectOption(e){var t=$(e).attr("id"),n=$(e).parent().data("select");$(e).toggleClass("selected");var r=$("select[id="+n+"]"),i=$("option[value="+t+"]",r);$(i).prop("selected")?$(i).attr("selected",!1):$(i).attr("selected",!0)}function initSlectMultiple(){$("select.selectMultiple[multiple=multiple]").each(function(){var e=$(this).attr("id"),t=$("#selectMultiple").html(),n=Handlebars.compile(t),r=[];$("option",this).each(function(){var e=[];$(this).attr("selected")?e.selected="selected":e.selected="";e.id=$(this).attr("value");e.text=$(this).text();r.push(e)});var i={selectId:e,options:r},s=n(i);$(this).after(s);$(this).hide()})}$(document).ready(function(){initSlides();$(".slide #up").click(function(){var e=$(this).parent().parent();moveSlideUp(e)});$(".slide #down").click(function(){var e=$(this).parent().parent();moveSlideDown(e)})});$(document).ready(function(){displayMultipleRelationFrom();formMultiplePage();stylingForm();$("input[type=checkbox]").each(function(){initCheckBox(this)});$("input[type=radio]").parent().each(function(){initRadio(this)});$("input[type=datetime]").each(function(){setDateTime(this)});$("form").on("click","div.icon",function(){setCheckbox(this)});$("form").on("click","div.radio-icon div",function(){setRadio(this)});$("form.person fieldset.header input.resize").autoGrowInput();$("form.person fieldset.header").on("keyup","input.resize",function(){$(this).autoGrowInput()});$("form").on("click","nav.sub_nav a",function(){event.preventDefault();var e=$(this).attr("id");switchFieldset(e)});$("form").on("focusout","input[type=datetime]",function(){setDateTime(this)});$("form fieldset[data-prototype]").on("click","#add",function(e){e.preventDefault();var t=$(this).data("id"),n=$("fieldset #"+t);addEntityForm(n)})});Date.CultureInfo={name:"en-US",englishName:"English (United States)",nativeName:"English (United States)",dayNames:["Sunday","Monday","Tuesday","Wednesday","Thursday","Friday","Saturday"],abbreviatedDayNames:["Sun","Mon","Tue","Wed","Thu","Fri","Sat"],shortestDayNames:["Su","Mo","Tu","We","Th","Fr","Sa"],firstLetterDayNames:["S","M","T","W","T","F","S"],monthNames:["January","February","March","April","May","June","July","August","September","October","November","December"],abbreviatedMonthNames:["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"],amDesignator:"AM",pmDesignator:"PM",firstDayOfWeek:0,twoDigitYearMax:2029,dateElementOrder:"mdy",formatPatterns:{shortDate:"M/d/yyyy",longDate:"dddd, MMMM dd, yyyy",shortTime:"h:mm tt",longTime:"h:mm:ss tt",fullDateTime:"dddd, MMMM dd, yyyy h:mm:ss tt",sortableDateTime:"yyyy-MM-ddTHH:mm:ss",universalSortableDateTime:"yyyy-MM-dd HH:mm:ssZ",rfc1123:"ddd, dd MMM yyyy HH:mm:ss GMT",monthDay:"MMMM dd",yearMonth:"MMMM, yyyy"},regexPatterns:{jan:/^jan(uary)?/i,feb:/^feb(ruary)?/i,mar:/^mar(ch)?/i,apr:/^apr(il)?/i,may:/^may/i,jun:/^jun(e)?/i,jul:/^jul(y)?/i,aug:/^aug(ust)?/i,sep:/^sep(t(ember)?)?/i,oct:/^oct(ober)?/i,nov:/^nov(ember)?/i,dec:/^dec(ember)?/i,sun:/^su(n(day)?)?/i,mon:/^mo(n(day)?)?/i,tue:/^tu(e(s(day)?)?)?/i,wed:/^we(d(nesday)?)?/i,thu:/^th(u(r(s(day)?)?)?)?/i,fri:/^fr(i(day)?)?/i,sat:/^sa(t(urday)?)?/i,future:/^next/i,past:/^last|past|prev(ious)?/i,add:/^(\+|after|from)/i,subtract:/^(\-|before|ago)/i,yesterday:/^yesterday/i,today:/^t(oday)?/i,tomorrow:/^tomorrow/i,now:/^n(ow)?/i,millisecond:/^ms|milli(second)?s?/i,second:/^sec(ond)?s?/i,minute:/^min(ute)?s?/i,hour:/^h(ou)?rs?/i,week:/^w(ee)?k/i,month:/^m(o(nth)?s?)?/i,day:/^d(ays?)?/i,year:/^y((ea)?rs?)?/i,shortMeridian:/^(a|p)/i,longMeridian:/^(a\.?m?\.?|p\.?m?\.?)/i,timezone:/^((e(s|d)t|c(s|d)t|m(s|d)t|p(s|d)t)|((gmt)?\s*(\+|\-)\s*\d\d\d\d?)|gmt)/i,ordinalSuffix:/^\s*(st|nd|rd|th)/i,timeContext:/^\s*(\:|a|p)/i},abbreviatedTimeZoneStandard:{GMT:"-000",EST:"-0400",CST:"-0500",MST:"-0600",PST:"-0700"},abbreviatedTimeZoneDST:{GMT:"-000",EDT:"-0500",CDT:"-0600",MDT:"-0700",PDT:"-0800"}};Date.getMonthNumberFromName=function(e){var t=Date.CultureInfo.monthNames,n=Date.CultureInfo.abbreviatedMonthNames,r=e.toLowerCase();for(var i=0;i<t.length;i++)if(t[i].toLowerCase()==r||n[i].toLowerCase()==r)return i;return-1};Date.getDayNumberFromName=function(e){var t=Date.CultureInfo.dayNames,n=Date.CultureInfo.abbreviatedDayNames,r=Date.CultureInfo.shortestDayNames,i=e.toLowerCase();for(var s=0;s<t.length;s++)if(t[s].toLowerCase()==i||n[s].toLowerCase()==i)return s;return-1};Date.isLeapYear=function(e){return e%4===0&&e%100!==0||e%400===0};Date.getDaysInMonth=function(e,t){return[31,Date.isLeapYear(e)?29:28,31,30,31,30,31,31,30,31,30,31][t]};Date.getTimezoneOffset=function(e,t){return t||!1?Date.CultureInfo.abbreviatedTimeZoneDST[e.toUpperCase()]:Date.CultureInfo.abbreviatedTimeZoneStandard[e.toUpperCase()]};Date.getTimezoneAbbreviation=function(e,t){var n=t||!1?Date.CultureInfo.abbreviatedTimeZoneDST:Date.CultureInfo.abbreviatedTimeZoneStandard,r;for(r in n)if(n[r]===e)return r;return null};Date.prototype.clone=function(){return new Date(this.getTime())};Date.prototype.compareTo=function(e){if(isNaN(this))throw new Error(this);if(e instanceof Date&&!isNaN(e))return this>e?1:this<e?-1:0;throw new TypeError(e)};Date.prototype.equals=function(e){return this.compareTo(e)===0};Date.prototype.between=function(e,t){var n=this.getTime();return n>=e.getTime()&&n<=t.getTime()};Date.prototype.addMilliseconds=function(e){this.setMilliseconds(this.getMilliseconds()+e);return this};Date.prototype.addSeconds=function(e){return this.addMilliseconds(e*1e3)};Date.prototype.addMinutes=function(e){return this.addMilliseconds(e*6e4)};Date.prototype.addHours=function(e){return this.addMilliseconds(e*36e5)};Date.prototype.addDays=function(e){return this.addMilliseconds(e*864e5)};Date.prototype.addWeeks=function(e){return this.addMilliseconds(e*6048e5)};Date.prototype.addMonths=function(e){var t=this.getDate();this.setDate(1);this.setMonth(this.getMonth()+e);this.setDate(Math.min(t,this.getDaysInMonth()));return this};Date.prototype.addYears=function(e){return this.addMonths(e*12)};Date.prototype.add=function(e){if(typeof e=="number"){this._orient=e;return this}var t=e;(t.millisecond||t.milliseconds)&&this.addMilliseconds(t.millisecond||t.milliseconds);(t.second||t.seconds)&&this.addSeconds(t.second||t.seconds);(t.minute||t.minutes)&&this.addMinutes(t.minute||t.minutes);(t.hour||t.hours)&&this.addHours(t.hour||t.hours);(t.month||t.months)&&this.addMonths(t.month||t.months);(t.year||t.years)&&this.addYears(t.year||t.years);(t.day||t.days)&&this.addDays(t.day||t.days);return this};Date._validate=function(e,t,n,r){if(typeof e!="number")throw new TypeError(e+" is not a Number.");if(e<t||e>n)throw new RangeError(e+" is not a valid value for "+r+".");return!0};Date.validateMillisecond=function(e){return Date._validate(e,0,999,"milliseconds")};Date.validateSecond=function(e){return Date._validate(e,0,59,"seconds")};Date.validateMinute=function(e){return Date._validate(e,0,59,"minutes")};Date.validateHour=function(e){return Date._validate(e,0,23,"hours")};Date.validateDay=function(e,t,n){return Date._validate(e,1,Date.getDaysInMonth(t,n),"days")};Date.validateMonth=function(e){return Date._validate(e,0,11,"months")};Date.validateYear=function(e){return Date._validate(e,1,9999,"seconds")};Date.prototype.set=function(e){var t=e;!t.millisecond&&t.millisecond!==0&&(t.millisecond=-1);!t.second&&t.second!==0&&(t.second=-1);!t.minute&&t.minute!==0&&(t.minute=-1);!t.hour&&t.hour!==0&&(t.hour=-1);!t.day&&t.day!==0&&(t.day=-1);!t.month&&t.month!==0&&(t.month=-1);!t.year&&t.year!==0&&(t.year=-1);t.millisecond!=-1&&Date.validateMillisecond(t.millisecond)&&this.addMilliseconds(t.millisecond-this.getMilliseconds());t.second!=-1&&Date.validateSecond(t.second)&&this.addSeconds(t.second-this.getSeconds());t.minute!=-1&&Date.validateMinute(t.minute)&&this.addMinutes(t.minute-this.getMinutes());t.hour!=-1&&Date.validateHour(t.hour)&&this.addHours(t.hour-this.getHours());t.month!==-1&&Date.validateMonth(t.month)&&this.addMonths(t.month-this.getMonth());t.year!=-1&&Date.validateYear(t.year)&&this.addYears(t.year-this.getFullYear());t.day!=-1&&Date.validateDay(t.day,this.getFullYear(),this.getMonth())&&this.addDays(t.day-this.getDate());t.timezone&&this.setTimezone(t.timezone);t.timezoneOffset&&this.setTimezoneOffset(t.timezoneOffset);return this};Date.prototype.clearTime=function(){this.setHours(0);this.setMinutes(0);this.setSeconds(0);this.setMilliseconds(0);return this};Date.prototype.isLeapYear=function(){var e=this.getFullYear();return e%4===0&&e%100!==0||e%400===0};Date.prototype.isWeekday=function(){return!this.is().sat()&&!this.is().sun()};Date.prototype.getDaysInMonth=function(){return Date.getDaysInMonth(this.getFullYear(),this.getMonth())};Date.prototype.moveToFirstDayOfMonth=function(){return this.set({day:1})};Date.prototype.moveToLastDayOfMonth=function(){return this.set({day:this.getDaysInMonth()})};Date.prototype.moveToDayOfWeek=function(e,t){var n=(e-this.getDay()+7*(t||1))%7;return this.addDays(n===0?n+=7*(t||1):n)};Date.prototype.moveToMonth=function(e,t){var n=(e-this.getMonth()+12*(t||1))%12;return this.addMonths(n===0?n+=12*(t||1):n)};Date.prototype.getDayOfYear=function(){return Math.floor((this-new Date(this.getFullYear(),0,1))/864e5)};Date.prototype.getWeekOfYear=function(e){var t=this.getFullYear(),n=this.getMonth(),r=this.getDate(),i=e||Date.CultureInfo.firstDayOfWeek,s=8-(new Date(t,0,1)).getDay();s==8&&(s=1);var o=(Date.UTC(t,n,r,0,0,0)-Date.UTC(t,0,1,0,0,0))/864e5+1,u=Math.floor((o-s+7)/7);if(u===i){t--;var a=8-(new Date(t,0,1)).getDay();a==2||a==8?u=53:u=52}return u};Date.prototype.isDST=function(){console.log("isDST");return this.toString().match(/(E|C|M|P)(S|D)T/)[2]=="D"};Date.prototype.getTimezone=function(){return Date.getTimezoneAbbreviation(this.getUTCOffset,this.isDST())};Date.prototype.setTimezoneOffset=function(e){var t=this.getTimezoneOffset(),n=Number(e)*-6/10;this.addMinutes(n-t);return this};Date.prototype.setTimezone=function(e){return this.setTimezoneOffset(Date.getTimezoneOffset(e))};Date.prototype.getUTCOffset=function(){var e=this.getTimezoneOffset()*-10/6,t;if(e<0){t=(e-1e4).toString();return t[0]+t.substr(2)}t=(e+1e4).toString();return"+"+t.substr(1)};Date.prototype.getDayName=function(e){return e?Date.CultureInfo.abbreviatedDayNames[this.getDay()]:Date.CultureInfo.dayNames[this.getDay()]};Date.prototype.getMonthName=function(e){return e?Date.CultureInfo.abbreviatedMonthNames[this.getMonth()]:Date.CultureInfo.monthNames[this.getMonth()]};Date.prototype._toString=Date.prototype.toString;Date.prototype.toString=function(e){var t=this,n=function(t){return t.toString().length==1?"0"+t:t};return e?e.replace(/dd?d?d?|MM?M?M?|yy?y?y?|hh?|HH?|mm?|ss?|tt?|zz?z?/g,function(e){switch(e){case"hh":return n(t.getHours()<13?t.getHours():t.getHours()-12);case"h":return t.getHours()<13?t.getHours():t.getHours()-12;case"HH":return n(t.getHours());case"H":return t.getHours();case"mm":return n(t.getMinutes());case"m":return t.getMinutes();case"ss":return n(t.getSeconds());case"s":return t.getSeconds();case"yyyy":return t.getFullYear();case"yy":return t.getFullYear().toString().substring(2,4);case"dddd":return t.getDayName();case"ddd":return t.getDayName(!0);case"dd":return n(t.getDate());case"d":return t.getDate().toString();case"MMMM":return t.getMonthName();case"MMM":return t.getMonthName(!0);case"MM":return n(t.getMonth()+1);case"M":return t.getMonth()+1;case"t":return t.getHours()<12?Date.CultureInfo.amDesignator.substring(0,1):Date.CultureInfo.pmDesignator.substring(0,1);case"tt":return t.getHours()<12?Date.CultureInfo.amDesignator:Date.CultureInfo.pmDesignator;case"zzz":case"zz":case"z":return""}}):this._toString()};Date.now=function(){return new Date};Date.today=function(){return Date.now().clearTime()};Date.prototype._orient=1;Date.prototype.next=function(){this._orient=1;return this};Date.prototype.last=Date.prototype.prev=Date.prototype.previous=function(){this._orient=-1;return this};Date.prototype._is=!1;Date.prototype.is=function(){this._is=!0;return this};Number.prototype._dateElement="day";Number.prototype.fromNow=function(){var e={};e[this._dateElement]=this;return Date.now().add(e)};Number.prototype.ago=function(){var e={};e[this._dateElement]=this*-1;return Date.now().add(e)};(function(){var e=Date.prototype,t=Number.prototype,n="sunday monday tuesday wednesday thursday friday saturday".split(/\s/),r="january february march april may june july august september october november december".split(/\s/),i="Millisecond Second Minute Hour Day Week Month Year".split(/\s/),s,o=function(e){return function(){if(this._is){this._is=!1;return this.getDay()==e}return this.moveToDayOfWeek(e,this._orient)}};for(var u=0;u<n.length;u++)e[n[u]]=e[n[u].substring(0,3)]=o(u);var a=function(e){return function(){if(this._is){this._is=!1;return this.getMonth()===e}return this.moveToMonth(e,this._orient)}};for(var f=0;f<r.length;f++)e[r[f]]=e[r[f].substring(0,3)]=a(f);var l=function(e){return function(){e.substring(e.length-1)!="s"&&(e+="s");return this["add"+e](this._orient)}},c=function(e){return function(){this._dateElement=e;return this}};for(var h=0;h<i.length;h++){s=i[h].toLowerCase();e[s]=e[s+"s"]=l(i[h]);t[s]=t[s+"s"]=c(s)}})();Date.prototype.toJSONString=function(){return this.toString("yyyy-MM-ddThh:mm:ssZ")};Date.prototype.toShortDateString=function(){return this.toString(Date.CultureInfo.formatPatterns.shortDatePattern)};Date.prototype.toLongDateString=function(){return this.toString(Date.CultureInfo.formatPatterns.longDatePattern)};Date.prototype.toShortTimeString=function(){return this.toString(Date.CultureInfo.formatPatterns.shortTimePattern)};Date.prototype.toLongTimeString=function(){return this.toString(Date.CultureInfo.formatPatterns.longTimePattern)};Date.prototype.getOrdinal=function(){switch(this.getDate()){case 1:case 21:case 31:return"st";case 2:case 22:return"nd";case 3:case 23:return"rd";default:return"th"}};(function(){Date.Parsing={Exception:function(e){this.message="Parse error at '"+e.substring(0,10)+" ...'"}};var e=Date.Parsing,t=e.Operators={rtoken:function(t){return function(n){var i=n.match(t);if(i)return[i[0],n.substring(i[0].length)];throw new e.Exception(n)}},token:function(e){return function(e){return t.rtoken(new RegExp("^s*"+e+"s*"))(e)}},stoken:function(e){return t.rtoken(new RegExp("^"+e))},until:function(e){return function(t){var n=[],r=null;while(t.length){try{r=e.call(this,t)}catch(i){n.push(r[0]);t=r[1];continue}break}return[n,t]}},many:function(e){return function(t){var n=[],r=null;while(t.length){try{r=e.call(this,t)}catch(i){return[n,t]}n.push(r[0]);t=r[1]}return[n,t]}},optional:function(e){return function(t){var n=null;try{n=e.call(this,t)}catch(r){return[null,t]}return[n[0],n[1]]}},not:function(t){return function(n){try{t.call(this,n)}catch(r){return[null,n]}throw new e.Exception(n)}},ignore:function(e){return e?function(t){var n=null;n=e.call(this,t);return[null,n[1]]}:null},product:function(){var e=arguments[0],n=Array.prototype.slice.call(arguments,1),r=[];for(var i=0;i<e.length;i++)r.push(t.each(e[i],n));return r},cache:function(t){var n={},r=null;return function(i){try{r=n[i]=n[i]||t.call(this,i)}catch(s){r=n[i]=s}if(r instanceof e.Exception)throw r;return r}},any:function(){var t=arguments;return function(n){var r=null;for(var i=0;i<t.length;i++){if(t[i]==null)continue;try{r=t[i].call(this,n)}catch(s){r=null}if(r)return r}throw new e.Exception(n)}},each:function(){var t=arguments;return function(n){var r=[],i=null;for(var s=0;s<t.length;s++){if(t[s]==null)continue;try{i=t[s].call(this,n)}catch(o){throw new e.Exception(n)}r.push(i[0]);n=i[1]}return[r,n]}},all:function(){var e=arguments,t=t;return t.each(t.optional(e))},sequence:function(n,r,i){r=r||t.rtoken(/^\s*/);i=i||null;return n.length==1?n[0]:function(t){var s=null,o=null,u=[];for(var a=0;a<n.length;a++){try{s=n[a].call(this,t)}catch(f){break}u.push(s[0]);try{o=r.call(this,s[1])}catch(l){o=null;break}t=o[1]}if(!s)throw new e.Exception(t);if(o)throw new e.Exception(o[1]);if(i)try{s=i.call(this,s[1])}catch(h){throw new e.Exception(s[1])}return[u,s?s[1]:t]}},between:function(e,n,i){i=i||e;var s=t.each(t.ignore(e),n,t.ignore(i));return function(e){var t=s.call(this,e);return[[t[0][0],r[0][2]],t[1]]}},list:function(e,n,r){n=n||t.rtoken(/^\s*/);r=r||null;return e instanceof Array?t.each(t.product(e.slice(0,-1),t.ignore(n)),e.slice(-1),t.ignore(r)):t.each(t.many(t.each(e,t.ignore(n))),px,t.ignore(r))},set:function(n,r,i){r=r||t.rtoken(/^\s*/);i=i||null;return function(s){var o=null,u=null,a=null,f=null,l=[[],s],h=!1;for(var p=0;p<n.length;p++){a=null;u=null;o=null;h=n.length==1;try{o=n[p].call(this,s)}catch(v){continue}f=[[o[0]],o[1]];if(o[1].length>0&&!h)try{a=r.call(this,o[1])}catch(m){h=!0}else h=!0;!h&&a[1].length===0&&(h=!0);if(!h){var g=[];for(var y=0;y<n.length;y++)p!=y&&g.push(n[y]);u=t.set(g,r).call(this,a[1]);if(u[0].length>0){f[0]=f[0].concat(u[0]);f[1]=u[1]}}f[1].length<l[1].length&&(l=f);if(l[1].length===0)break}if(l[0].length===0)return l;if(i){try{a=i.call(this,l[1])}catch(b){throw new e.Exception(l[1])}l[1]=a[1]}return l}},forward:function(e,t){return function(n){return e[t].call(this,n)}},replace:function(e,t){return function(n){var r=e.call(this,n);return[t,r[1]]}},process:function(e,t){return function(n){var r=e.call(this,n);return[t.call(this,r[0]),r[1]]}},min:function(t,n){return function(r){var i=n.call(this,r);if(i[0].length<t)throw new e.Exception(r);return i}}},n=function(e){return function(){var t=null,n=[];arguments.length>1?t=Array.prototype.slice.call(arguments):arguments[0]instanceof Array&&(t=arguments[0]);if(!t)return e.apply(null,arguments);for(var r=0,i=t.shift();r<i.length;r++){t.unshift(i[r]);n.push(e.apply(null,t));t.shift();return n}}},i="optional not ignore cache".split(/\s/);for(var s=0;s<i.length;s++)t[i[s]]=n(t[i[s]]);var o=function(e){return function(){return arguments[0]instanceof Array?e.apply(null,arguments[0]):e.apply(null,arguments)}},u="each any all".split(/\s/);for(var a=0;a<u.length;a++)t[u[a]]=o(t[u[a]])})();(function(){var e=function(t){var n=[];for(var r=0;r<t.length;r++)t[r]instanceof Array?n=n.concat(e(t[r])):t[r]&&n.push(t[r]);return n};Date.Grammar={};Date.Translator={hour:function(e){return function(){this.hour=Number(e)}},minute:function(e){return function(){this.minute=Number(e)}},second:function(e){return function(){this.second=Number(e)}},meridian:function(e){return function(){this.meridian=e.slice(0,1).toLowerCase()}},timezone:function(e){return function(){var t=e.replace(/[^\d\+\-]/g,"");t.length?this.timezoneOffset=Number(t):this.timezone=e.toLowerCase()}},day:function(e){var t=e[0];return function(){this.day=Number(t.match(/\d+/)[0])}},month:function(e){return function(){this.month=e.length==3?Date.getMonthNumberFromName(e):Number(e)-1}},year:function(e){return function(){var t=Number(e);this.year=e.length>2?t:t+(t+2e3<Date.CultureInfo.twoDigitYearMax?2e3:1900)}},rday:function(e){return function(){switch(e){case"yesterday":this.days=-1;break;case"tomorrow":this.days=1;break;case"today":this.days=0;break;case"now":this.days=0;this.now=!0}}},finishExact:function(e){e=e instanceof Array?e:[e];var t=new Date;this.year=t.getFullYear();this.month=t.getMonth();this.day=1;this.hour=0;this.minute=0;this.second=0;for(var n=0;n<e.length;n++)e[n]&&e[n].call(this);this.hour=this.meridian=="p"&&this.hour<13?this.hour+12:this.hour;if(this.day>Date.getDaysInMonth(this.year,this.month))throw new RangeError(this.day+" is not a valid value for days.");var r=new Date(this.year,this.month,this.day,this.hour,this.minute,this.second);this.timezone?r.set({timezone:this.timezone}):this.timezoneOffset&&r.set({timezoneOffset:this.timezoneOffset});return r},finish:function(t){t=t instanceof Array?e(t):[t];if(t.length===0)return null;for(var n=0;n<t.length;n++)typeof t[n]=="function"&&t[n].call(this);if(this.now)return new Date;var r=Date.today(),i=null,s=this.days!=null||!!this.orient||!!this.operator;if(s){var o,u,a;a=this.orient=="past"||this.operator=="subtract"?-1:1;if(this.weekday){this.unit="day";o=Date.getDayNumberFromName(this.weekday)-r.getDay();u=7;this.days=o?(o+a*u)%u:a*u}if(this.month){this.unit="month";o=this.month-r.getMonth();u=12;this.months=o?(o+a*u)%u:a*u;this.month=null}this.unit||(this.unit="day");if(this[this.unit+"s"]==null||this.operator!=null){this.value||(this.value=1);if(this.unit=="week"){this.unit="day";this.value=this.value*7}this[this.unit+"s"]=this.value*a}return r.add(this)}this.meridian&&this.hour&&(this.hour=this.hour<13&&this.meridian=="p"?this.hour+12:this.hour);this.weekday&&!this.day&&(this.day=r.addDays(Date.getDayNumberFromName(this.weekday)-r.getDay()).getDate());this.month&&!this.day&&(this.day=1);return r.set(this)}};var t=Date.Parsing.Operators,n=Date.Grammar,r=Date.Translator,i;n.datePartDelimiter=t.rtoken(/^([\s\-\.\,\/\x27]+)/);n.timePartDelimiter=t.stoken(":");n.whiteSpace=t.rtoken(/^\s*/);n.generalDelimiter=t.rtoken(/^(([\s\,]|at|on)+)/);var s={};n.ctoken=function(e){var n=s[e];if(!n){var r=Date.CultureInfo.regexPatterns,i=e.split(/\s+/),o=[];for(var u=0;u<i.length;u++)o.push(t.replace(t.rtoken(r[i[u]]),i[u]));n=s[e]=t.any.apply(null,o)}return n};n.ctoken2=function(e){return t.rtoken(Date.CultureInfo.regexPatterns[e])};n.h=t.cache(t.process(t.rtoken(/^(0[0-9]|1[0-2]|[1-9])/),r.hour));n.hh=t.cache(t.process(t.rtoken(/^(0[0-9]|1[0-2])/),r.hour));n.H=t.cache(t.process(t.rtoken(/^([0-1][0-9]|2[0-3]|[0-9])/),r.hour));n.HH=t.cache(t.process(t.rtoken(/^([0-1][0-9]|2[0-3])/),r.hour));n.m=t.cache(t.process(t.rtoken(/^([0-5][0-9]|[0-9])/),r.minute));n.mm=t.cache(t.process(t.rtoken(/^[0-5][0-9]/),r.minute));n.s=t.cache(t.process(t.rtoken(/^([0-5][0-9]|[0-9])/),r.second));n.ss=t.cache(t.process(t.rtoken(/^[0-5][0-9]/),r.second));n.hms=t.cache(t.sequence([n.H,n.mm,n.ss],n.timePartDelimiter));n.t=t.cache(t.process(n.ctoken2("shortMeridian"),r.meridian));n.tt=t.cache(t.process(n.ctoken2("longMeridian"),r.meridian));n.z=t.cache(t.process(t.rtoken(/^(\+|\-)?\s*\d\d\d\d?/),r.timezone));n.zz=t.cache(t.process(t.rtoken(/^(\+|\-)\s*\d\d\d\d/),r.timezone));n.zzz=t.cache(t.process(n.ctoken2("timezone"),r.timezone));n.timeSuffix=t.each(t.ignore(n.whiteSpace),t.set([n.tt,n.zzz]));n.time=t.each(t.optional(t.ignore(t.stoken("T"))),n.hms,n.timeSuffix);n.d=t.cache(t.process(t.each(t.rtoken(/^([0-2]\d|3[0-1]|\d)/),t.optional(n.ctoken2("ordinalSuffix"))),r.day));n.dd=t.cache(t.process(t.each(t.rtoken(/^([0-2]\d|3[0-1])/),t.optional(n.ctoken2("ordinalSuffix"))),r.day));n.ddd=n.dddd=t.cache(t.process(n.ctoken("sun mon tue wed thu fri sat"),function(e){return function(){this.weekday=e}}));n.M=t.cache(t.process(t.rtoken(/^(1[0-2]|0\d|\d)/),r.month));n.MM=t.cache(t.process(t.rtoken(/^(1[0-2]|0\d)/),r.month));n.MMM=n.MMMM=t.cache(t.process(n.ctoken("jan feb mar apr may jun jul aug sep oct nov dec"),r.month));n.y=t.cache(t.process(t.rtoken(/^(\d\d?)/),r.year));n.yy=t.cache(t.process(t.rtoken(/^(\d\d)/),r.year));n.yyy=t.cache(t.process(t.rtoken(/^(\d\d?\d?\d?)/),r.year));n.yyyy=t.cache(t.process(t.rtoken(/^(\d\d\d\d)/),r.year));i=function(){return t.each(t.any.apply(null,arguments),t.not(n.ctoken2("timeContext")))};n.day=i(n.d,n.dd);n.month=i(n.M,n.MMM);n.year=i(n.yyyy,n.yy);n.orientation=t.process(n.ctoken("past future"),function(e){return function(){this.orient=e}});n.operator=t.process(n.ctoken("add subtract"),function(e){return function(){this.operator=e}});n.rday=t.process(n.ctoken("yesterday tomorrow today now"),r.rday);n.unit=t.process(n.ctoken("minute hour day week month year"),function(e){return function(){this.unit=e}});n.value=t.process(t.rtoken(/^\d\d?(st|nd|rd|th)?/),function(e){return function(){this.value=e.replace(/\D/g,"")}});n.expression=t.set([n.rday,n.operator,n.value,n.unit,n.orientation,n.ddd,n.MMM]);i=function(){return t.set(arguments,n.datePartDelimiter)};n.mdy=i(n.ddd,n.month,n.day,n.year);n.ymd=i(n.ddd,n.year,n.month,n.day);n.dmy=i(n.ddd,n.day,n.month,n.year);n.date=function(e){return(n[Date.CultureInfo.dateElementOrder]||n.mdy).call(this,e)};n.format=t.process(t.many(t.any(t.process(t.rtoken(/^(dd?d?d?|MM?M?M?|yy?y?y?|hh?|HH?|mm?|ss?|tt?|zz?z?)/),function(e){if(n[e])return n[e];throw Date.Parsing.Exception(e)}),t.process(t.rtoken(/^[^dMyhHmstz]+/),function(e){return t.ignore(t.stoken(e))}))),function(e){return t.process(t.each.apply(null,e),r.finishExact)});var o={},u=function(e){return o[e]=o[e]||n.format(e)[0]};n.formats=function(e){if(e instanceof Array){var n=[];for(var r=0;r<e.length;r++)n.push(u(e[r]));return t.any.apply(null,n)}return u(e)};n._formats=n.formats(["yyyy-MM-ddTHH:mm:ss","ddd, MMM dd, yyyy H:mm:ss tt","ddd MMM d yyyy HH:mm:ss zzz","d"]);n._start=t.process(t.set([n.date,n.time,n.expression],n.generalDelimiter,n.whiteSpace),r.finish);n.start=function(e){try{var t=n._formats.call({},e);if(t[1].length===0)return t}catch(r){}return n._start.call({},e)}})();Date._parse=Date.parse;Date.parse=function(e){var t=null;if(!e)return null;try{t=Date.Grammar.start.call({},e)}catch(n){return null}return t[1].length===0?t[0]:null};Date.getParseFunction=function(e){var t=Date.Grammar.formats(e);return function(e){var n=null;try{n=t.call({},e)}catch(r){return null}return n[1].length===0?n[0]:null}};Date.parseExact=function(e,t){return Date.getParseFunction(t)(e)};$(document).ready(function(){$(".elastic").elastic()});(function(e){jQuery.fn.extend({elastic:function(){var t=["paddingTop","paddingRight","paddingBottom","paddingLeft","fontSize","lineHeight","fontFamily","width","fontWeight","border-top-width","border-right-width","border-bottom-width","border-left-width","borderTopStyle","borderTopColor","borderRightStyle","borderRightColor","borderBottomStyle","borderBottomColor","borderLeftStyle","borderLeftColor"];return this.each(function(){function f(){var e=Math.floor(parseInt(n.width(),10));if(r.width()!==e){r.css({width:e+"px"});c(!0)}}function l(e,t){var r=Math.floor(parseInt(e,10));n.height()!==r&&n.css({height:r+"px",overflow:t})}function c(e){var t=n.val().replace(/&/g,"&amp;").replace(/ {2}/g,"&nbsp;").replace(/<|>/g,"&gt;").replace(/\n/g,"<br />"),u=r.html().replace(/<br>/ig,"<br />");if(e||t+"&nbsp;"!==u){r.html(t+"&nbsp;");if(Math.abs(r.height()+i-n.height())>3){var a=r.height()+i;a>=o?l(o,"auto"):a<=s?l(s,"hidden"):l(a,"hidden")}}}if(this.type!=="textarea")return!1;var n=jQuery(this),r=jQuery("<div />").css({position:"absolute",display:"none","word-wrap":"break-word","white-space":"pre-wrap"}),i=parseInt(n.css("line-height"),10)||parseInt(n.css("font-size"),"10"),s=parseInt(n.css("height"),10)||i*3,o=parseInt(n.css("max-height"),10)||Number.MAX_VALUE,u=0;o<0&&(o=Number.MAX_VALUE);r.appendTo(n.parent());var a=t.length;while(a--)r.css(t[a].toString(),n.css(t[a].toString()));n.css({overflow:"hidden"});n.bind("keyup change cut paste",function(){c()});e(window).bind("resize",f);n.bind("resize",f);n.bind("update",c);n.bind("blur",function(){r.height()<o&&(r.height()>s?n.height(r.height()):n.height(s))});n.bind("input paste",function(e){setTimeout(c,250)});c()})}})})(jQuery);(function(e){e.fn.autoGrowInput=function(t){t=e.extend({maxWidth:400,minWidth:10,comfortZone:10},t);this.filter("input:text, input[type = datetime]").each(function(){var n=t.minWidth||e(this).width(),r="",i=e(this),s=e("<tester/>").css({position:"absolute",top:-9999,left:-9999,width:"auto",fontSize:i.css("fontSize"),fontFamily:i.css("fontFamily"),fontWeight:i.css("fontWeight"),letterSpacing:i.css("letterSpacing"),whiteSpace:"nowrap"}),u=function(){if(r===(r=i.val()))return;var e=r.replace(/&/g,"&amp;").replace(/\s/g,"&nbsp;").replace(/</g,"&lt;").replace(/>/g,"&gt;");s.html(e);var u=s.width(),a=u+t.comfortZone>=n?u+t.comfortZone:n,f=i.width(),l=a<f&&a>=n||a>n&&a<t.maxWidth;l&&i.width(a)};s.insertAfter(i);e(this).bind("keyup keydown blur update",u)});return this}})(jQuery);var defaultDiacriticsRemovalap=[{base:"A",letters:"AⒶＡÀÁÂẦẤẪẨÃĀĂẰẮẴẲȦǠÄǞẢÅǺǍȀȂẠẬẶḀĄȺⱯ"},{base:"AA",letters:"Ꜳ"},{base:"AE",letters:"ÆǼǢ"},{base:"AO",letters:"Ꜵ"},{base:"AU",letters:"Ꜷ"},{base:"AV",letters:"ꜸꜺ"},{base:"AY",letters:"Ꜽ"},{base:"B",letters:"BⒷＢḂḄḆɃƂƁ"},{base:"C",letters:"CⒸＣĆĈĊČÇḈƇȻꜾ"},{base:"D",letters:"DⒹＤḊĎḌḐḒḎĐƋƊƉꝹ"},{base:"DZ",letters:"ǱǄ"},{base:"Dz",letters:"ǲǅ"},{base:"E",letters:"EⒺＥÈÉÊỀẾỄỂẼĒḔḖĔĖËẺĚȄȆẸỆȨḜĘḘḚƐƎ"},{base:"F",letters:"FⒻＦḞƑꝻ"},{base:"G",letters:"GⒼＧǴĜḠĞĠǦĢǤƓꞠꝽꝾ"},{base:"H",letters:"HⒽＨĤḢḦȞḤḨḪĦⱧⱵꞍ"},{base:"I",letters:"IⒾＩÌÍÎĨĪĬİÏḮỈǏȈȊỊĮḬƗ"},{base:"J",letters:"JⒿＪĴɈ"},{base:"K",letters:"KⓀＫḰǨḲĶḴƘⱩꝀꝂꝄꞢ"},{base:"L",letters:"LⓁＬĿĹĽḶḸĻḼḺŁȽⱢⱠꝈꝆꞀ"
},{base:"LJ",letters:"Ǉ"},{base:"Lj",letters:"ǈ"},{base:"M",letters:"MⓂＭḾṀṂⱮƜ"},{base:"N",letters:"NⓃＮǸŃÑṄŇṆŅṊṈȠƝꞐꞤ"},{base:"NJ",letters:"Ǌ"},{base:"Nj",letters:"ǋ"},{base:"O",letters:"OⓄＯÒÓÔỒỐỖỔÕṌȬṎŌṐṒŎȮȰÖȪỎŐǑȌȎƠỜỚỠỞỢỌỘǪǬØǾƆƟꝊꝌ"},{base:"OI",letters:"Ƣ"},{base:"OO",letters:"Ꝏ"},{base:"OU",letters:"Ȣ"},{base:"P",letters:"PⓅＰṔṖƤⱣꝐꝒꝔ"},{base:"Q",letters:"QⓆＱꝖꝘɊ"},{base:"R",letters:"RⓇＲŔṘŘȐȒṚṜŖṞɌⱤꝚꞦꞂ"},{base:"S",letters:"SⓈＳẞŚṤŜṠŠṦṢṨȘŞⱾꞨꞄ"},{base:"T",letters:"TⓉＴṪŤṬȚŢṰṮŦƬƮȾꞆ"},{base:"TZ",letters:"Ꜩ"},{base:"U",letters:"UⓊＵÙÚÛŨṸŪṺŬÜǛǗǕǙỦŮŰǓȔȖƯỪỨỮỬỰỤṲŲṶṴɄ"},{base:"V",letters:"VⓋＶṼṾƲꝞɅ"},{base:"VY",letters:"Ꝡ"},{base:"W",letters:"WⓌＷẀẂŴẆẄẈⱲ"},{base:"X",letters:"XⓍＸẊẌ"},{base:"Y",letters:"YⓎＹỲÝŶỸȲẎŸỶỴƳɎỾ"},{base:"Z",letters:"ZⓏＺŹẐŻŽẒẔƵȤⱿⱫꝢ"},{base:"a",letters:"aⓐａẚàáâầấẫẩãāăằắẵẳȧǡäǟảåǻǎȁȃạậặḁąⱥɐ"},{base:"aa",letters:"ꜳ"},{base:"ae",letters:"æǽǣ"},{base:"ao",letters:"ꜵ"},{base:"au",letters:"ꜷ"},{base:"av",letters:"ꜹꜻ"},{base:"ay",letters:"ꜽ"},{base:"b",letters:"bⓑｂḃḅḇƀƃɓ"},{base:"c",letters:"cⓒｃćĉċčçḉƈȼꜿↄ"},{base:"d",letters:"dⓓｄḋďḍḑḓḏđƌɖɗꝺ"},{base:"dz",letters:"ǳǆ"},{base:"e",letters:"eⓔｅèéêềếễểẽēḕḗĕėëẻěȅȇẹệȩḝęḙḛɇɛǝ"},{base:"f",letters:"fⓕｆḟƒꝼ"},{base:"g",letters:"gⓖｇǵĝḡğġǧģǥɠꞡᵹꝿ"},{base:"h",letters:"hⓗｈĥḣḧȟḥḩḫẖħⱨⱶɥ"},{base:"hv",letters:"ƕ"},{base:"i",letters:"iⓘｉìíîĩīĭïḯỉǐȉȋịįḭɨı"},{base:"j",letters:"jⓙｊĵǰɉ"},{base:"k",letters:"kⓚｋḱǩḳķḵƙⱪꝁꝃꝅꞣ"},{base:"l",letters:"lⓛｌŀĺľḷḹļḽḻſłƚɫⱡꝉꞁꝇ"},{base:"lj",letters:"ǉ"},{base:"m",letters:"mⓜｍḿṁṃɱɯ"},{base:"n",letters:"nⓝｎǹńñṅňṇņṋṉƞɲŉꞑꞥ"},{base:"nj",letters:"ǌ"},{base:"o",letters:"oⓞｏòóôồốỗổõṍȭṏōṑṓŏȯȱöȫỏőǒȍȏơờớỡởợọộǫǭøǿɔꝋꝍɵ"},{base:"oi",letters:"ƣ"},{base:"ou",letters:"ȣ"},{base:"oo",letters:"ꝏ"},{base:"p",letters:"pⓟｐṕṗƥᵽꝑꝓꝕ"},{base:"q",letters:"qⓠｑɋꝗꝙ"},{base:"r",letters:"rⓡｒŕṙřȑȓṛṝŗṟɍɽꝛꞧꞃ"},{base:"s",letters:"sⓢｓßśṥŝṡšṧṣṩșşȿꞩꞅẛ"},{base:"t",letters:"tⓣｔṫẗťṭțţṱṯŧƭʈⱦꞇ"},{base:"tz",letters:"ꜩ"},{base:"u",letters:"uⓤｕùúûũṹūṻŭüǜǘǖǚủůűǔȕȗưừứữửựụṳųṷṵʉ"},{base:"v",letters:"vⓥｖṽṿʋꝟʌ"},{base:"vy",letters:"ꝡ"},{base:"w",letters:"wⓦｗẁẃŵẇẅẘẉⱳ"},{base:"x",letters:"xⓧｘẋẍ"},{base:"y",letters:"yⓨｙỳýŷỹȳẏÿỷẙỵƴɏỿ"},{base:"z",letters:"zⓩｚźẑżžẓẕƶȥɀⱬꝣ"}],diacriticsMap={};for(var i=0;i<defaultDiacriticsRemovalap.length;i++){var letters=defaultDiacriticsRemovalap[i].letters.split("");for(var j=0;j<letters.length;j++)diacriticsMap[letters[j]]=defaultDiacriticsRemovalap[i].base}$(document).ready(function(){initSlectMultiple();$("form").on("click","ul.selectMultiple li",function(){setSelectOption(this)})});