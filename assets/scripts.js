/**
 * mobilecontent extension for Contao Open Source CMS
 *
 * @author  Kamil Kuzminski <https://github.com/qzminski>
 * @license LGPL
 */

/**
 * @see https://github.com/kaimallea/isMobile
 */
!function(a){var b=/iPhone/i,c=/iPod/i,d=/iPad/i,e=/(?=.*\bAndroid\b)(?=.*\bMobile\b)/i,f=/Android/i,g=/(?=.*\bAndroid\b)(?=.*\bSD4930UR\b)/i,h=/(?=.*\bAndroid\b)(?=.*\b(?:KFOT|KFTT|KFJWI|KFJWA|KFSOWI|KFTHWI|KFTHWA|KFAPWI|KFAPWA|KFARWI|KFASWI|KFSAWI|KFSAWA)\b)/i,i=/IEMobile/i,j=/(?=.*\bWindows\b)(?=.*\bARM\b)/i,k=/BlackBerry/i,l=/BB10/i,m=/Opera Mini/i,n=/(CriOS|Chrome)(?=.*\bMobile\b)/i,o=/(?=.*\bFirefox\b)(?=.*\bMobile\b)/i,p=new RegExp("(?:Nexus 7|BNTV250|Kindle Fire|Silk|GT-P1000)","i"),q=function(a,b){return a.test(b)},r=function(a){var r=a||navigator.userAgent,s=r.split("[FBAN");return"undefined"!=typeof s[1]&&(r=s[0]),s=r.split("Twitter"),"undefined"!=typeof s[1]&&(r=s[0]),this.apple={phone:q(b,r),ipod:q(c,r),tablet:!q(b,r)&&q(d,r),device:q(b,r)||q(c,r)||q(d,r)},this.amazon={phone:q(g,r),tablet:!q(g,r)&&q(h,r),device:q(g,r)||q(h,r)},this.android={phone:q(g,r)||q(e,r),tablet:!q(g,r)&&!q(e,r)&&(q(h,r)||q(f,r)),device:q(g,r)||q(h,r)||q(e,r)||q(f,r)},this.windows={phone:q(i,r),tablet:q(j,r),device:q(i,r)||q(j,r)},this.other={blackberry:q(k,r),blackberry10:q(l,r),opera:q(m,r),firefox:q(o,r),chrome:q(n,r),device:q(k,r)||q(l,r)||q(m,r)||q(o,r)||q(n,r)},this.seven_inch=q(p,r),this.any=this.apple.device||this.android.device||this.windows.device||this.other.device||this.seven_inch,this.phone=this.apple.phone||this.android.phone||this.windows.phone,this.tablet=this.apple.tablet||this.android.tablet||this.windows.tablet,"undefined"==typeof window?this:void 0},s=function(){var a=new r;return a.Class=r,a};"undefined"!=typeof module&&module.exports&&"undefined"==typeof window?module.exports=r:"undefined"!=typeof module&&module.exports&&"undefined"!=typeof window?module.exports=s():"function"==typeof define&&define.amd?define("isMobile",[],a.isMobile=s()):a.isMobile=s()}(this);

/**
 * @see https://github.com/js-cookie/js-cookie
 */
!function(a){var b=!1;if("function"==typeof define&&define.amd&&(define(a),b=!0),"object"==typeof exports&&(module.exports=a(),b=!0),!b){var c=window.Cookies,d=window.Cookies=a();d.noConflict=function(){return window.Cookies=c,d}}}(function(){function a(){for(var a=0,b={};a<arguments.length;a++){var c=arguments[a];for(var d in c)b[d]=c[d]}return b}function b(c){function d(b,e,f){var g;if("undefined"!=typeof document){if(arguments.length>1){if(f=a({path:"/"},d.defaults,f),"number"==typeof f.expires){var h=new Date;h.setMilliseconds(h.getMilliseconds()+864e5*f.expires),f.expires=h}f.expires=f.expires?f.expires.toUTCString():"";try{g=JSON.stringify(e),/^[\{\[]/.test(g)&&(e=g)}catch(p){}e=c.write?c.write(e,b):encodeURIComponent(e+"").replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g,decodeURIComponent),b=encodeURIComponent(b+""),b=b.replace(/%(23|24|26|2B|5E|60|7C)/g,decodeURIComponent),b=b.replace(/[\(\)]/g,escape);var i="";for(var j in f)f[j]&&(i+="; "+j,!0!==f[j]&&(i+="="+f[j]));return document.cookie=b+"="+e+i}b||(g={});for(var k=document.cookie?document.cookie.split("; "):[],l=0;l<k.length;l++){var m=k[l].split("="),n=m.slice(1).join("=");'"'===n.charAt(0)&&(n=n.slice(1,-1));try{var o=m[0].replace(/(%[0-9A-Z]{2})+/g,decodeURIComponent);if(n=c.read?c.read(n,o):c(n,o)||n.replace(/(%[0-9A-Z]{2})+/g,decodeURIComponent),this.json)try{n=JSON.parse(n)}catch(p){}if(b===o){g=n;break}b||(g[o]=n)}catch(p){}}return g}}return d.set=d,d.get=function(a){return d.call(d,a)},d.getJSON=function(){return d.apply({json:!0},[].slice.call(arguments))},d.defaults={},d.remove=function(b,c){d(b,"",a(c,{expires:-1}))},d.withConverter=b,d}return b(function(){})});

/**
 * Initialize the toggler
 */
document.addEventListener('DOMContentLoaded', function () {
    var cookieDismiss = 'mobile-content-dismiss';
    var cookieRedirect = 'mobile-content-redirect';

    // Set the redirect cookie
    if (window.location.hash === '#mobile-toggle') {
        Cookies.set(cookieRedirect, 1);
    }

    function mobile(toggler) {
        var breakpoint = toggler.dataset.breakpoint ? parseInt(toggler.dataset.breakpoint, 10) : 0;

        if (breakpoint > 0) {
            return window.matchMedia('(max-width:' + breakpoint + 'px)').matches;
        } else {
            return isMobile.any;
        }
    }

    Array.from(document.querySelectorAll('[data-mobile-toggler]')).forEach(function (toggler) {
        var isMobileDomain = toggler.dataset.mobileToggler === 'mobile';

        // Do not show the toggler if we are on the correct domain for the device
        if ((isMobileDomain && mobile(toggler)) || (!isMobileDomain && !mobile(toggler))) {
            return;
        }

        // Auto redirect the user to the correct URL if it has not decided explicitly yet (no cookie)
        if (toggler.dataset.redirectDesktop && toggler.dataset.redirectMobile && !Cookies.get(cookieRedirect)) {
            var target = mobile(toggler) ? toggler.dataset.redirectMobile : toggler.dataset.redirectDesktop;

            if (window.location.host !== target) {
                // Add the CSS class
                if (document.body.classList) {
                    document.body.classList.add('mobile-content-redirecting');
                }

                window.location = target;
            }
        }

        // The alert has been already dismissed
        if (Cookies.get(cookieDismiss)) {
            return;
        }

        // Show the toggler
        toggler.style.display = 'block';

        // Show only the link to desktop if we are on mobile domain with desktop device
        if (isMobileDomain && !mobile(toggler)) {
            toggler.querySelector('[data-toggle="mobile"]').style.display = 'none';
        } else if (!isMobileDomain && mobile(toggler)) {
            // Show only the link to mobile if we are on desktop domain with mobile device
            toggler.querySelector('[data-toggle="desktop"]').style.display = 'none';
        }

        // Bind the event to close links
        Array.from(toggler.querySelectorAll('[data-close]')).forEach(function (link) {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                toggler.style.display = 'none';
                Cookies.set(cookieDismiss, 1, { expires: 30 });
            });
        });
    });
});
