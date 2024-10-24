
<?php
session_start(); // Start the session

// Check if user is logged in
$isLoggedIn = isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true;
$userId = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : '';

if(isset($_SESSION['FMSG']))
{
    $msg = $_SESSION['FMSG'];
    echo '<script>alert("'.$msg.'");</script>';
    unset($_SESSION['FMSG']);
}

?>
<!DOCTYPE html>
<html lang="en-US">

    <!-- Mirrored from www.radiustheme.com/demo/wordpress/themes/homlisti/contact/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 25 Jul 2024 13:27:31 GMT -->
    <!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="profile" href="https://gmpg.org/xfn/11" />
        <script>function loadAsync(e, t){var a, n = !1; a = document.createElement("script"), a.type = "text/javascript", a.src = e, a.onreadystatechange = function(){n || this.readyState && "complete" != this.readyState || (n = !0, "function" == typeof t && t())}, a.onload = a.onreadystatechange, document.getElementsByTagName("head")[0].appendChild(a)}</script>
        <title>Contact &#8211; HomListi</title>
        <meta name='robots' content='max-image-preview:large' />
        <noscript><style>#preloader{
                display:none;
            }</style></noscript><link rel='dns-prefetch' href='http://fonts.googleapis.com/' />
        <link rel="alternate" type="application/rss+xml" title="HomListi &raquo; Feed" href="../feed/index.php" />
        <link rel="alternate" type="application/rss+xml" title="HomListi &raquo; Comments Feed" href="../comments/feed/index.php" />
        <script>
            var wpo_server_info_css = {"user_agent":"Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/126.0.0.0 Safari\/537.36 Edg\/126.0.0.0"}
            var wpo_min71032d52 = document.createElement("link"); wpo_min71032d52.rel = "stylesheet", wpo_min71032d52.type = "text/css", wpo_min71032d52.media = "async", wpo_min71032d52.href = "../wp-content/themes/homlisti/assets/css/font-awesome.min.css", wpo_min71032d52.onload = function() {wpo_min71032d52.media = "all"}, document.getElementsByTagName("head")[0].appendChild(wpo_min71032d52);</script>
        <script>
            var wpo_server_info_css = {"user_agent":"Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/126.0.0.0 Safari\/537.36 Edg\/126.0.0.0"}
            var wpo_mine86e346d = document.createElement("link"); wpo_mine86e346d.rel = "stylesheet", wpo_mine86e346d.type = "text/css", wpo_mine86e346d.media = "async", wpo_mine86e346d.href = "../wp-content/plugins/elementor/assets/lib/font-awesome/css/fontawesome.min.css", wpo_mine86e346d.onload = function() {wpo_mine86e346d.media = "all"}, document.getElementsByTagName("head")[0].appendChild(wpo_mine86e346d);</script>
        <script>
            var wpo_server_info_css = {"user_agent":"Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/126.0.0.0 Safari\/537.36 Edg\/126.0.0.0"}
            var wpo_minb14c31e0 = document.createElement("link"); wpo_minb14c31e0.rel = "stylesheet", wpo_minb14c31e0.type = "text/css", wpo_minb14c31e0.media = "async", wpo_minb14c31e0.href = "../wp-content/plugins/elementor/assets/lib/font-awesome/css/solid.min.css", wpo_minb14c31e0.onload = function() {wpo_minb14c31e0.media = "all"}, document.getElementsByTagName("head")[0].appendChild(wpo_minb14c31e0);</script>
        <script>
            var wpo_server_info_css = {"user_agent":"Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/126.0.0.0 Safari\/537.36 Edg\/126.0.0.0"}
            var wpo_mine33a323f = document.createElement("link"); wpo_mine33a323f.rel = "stylesheet", wpo_mine33a323f.type = "text/css", wpo_mine33a323f.media = "async", wpo_mine33a323f.href = "../wp-content/plugins/elementor/assets/lib/font-awesome/css/brands.min.css", wpo_mine33a323f.onload = function() {wpo_mine33a323f.media = "all"}, document.getElementsByTagName("head")[0].appendChild(wpo_mine33a323f);</script>
        <script>
            var wpo_server_info_css = {"user_agent":"Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/126.0.0.0 Safari\/537.36 Edg\/126.0.0.0"}
            var wpo_mind5c46c7b = document.createElement("link"); wpo_mind5c46c7b.rel = "stylesheet", wpo_mind5c46c7b.type = "text/css", wpo_mind5c46c7b.media = "async", wpo_mind5c46c7b.href = "https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;family=Ubuntu:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;family=Mulish:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap", wpo_mind5c46c7b.onload = function() {wpo_mind5c46c7b.media = "all"}, document.getElementsByTagName("head")[0].appendChild(wpo_mind5c46c7b);</script>
        <style class="optimize_css_2" type="text/css" media="all">:root{
                --fluentform-primary:#1a7efb;
                --fluentform-secondary:#606266;
                --fluentform-danger:#f56c6c;
                --fluentform-border-color:#dadbdd;
                --fluentform-border-radius:7px
            }
            .ff-default .ff_btn_style{
                border:1px solid #fff0;
                border-radius:7px;
                cursor:pointer;
                display:inline-block;
                font-size:16px;
                font-weight:500;
                line-height:1.5;
                padding:8px 20px;
                position:relative;
                text-align:center;
                transition:background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
                -webkit-user-select:none;
                -moz-user-select:none;
                user-select:none;
                vertical-align:middle;
                white-space:nowrap
            }
            .ff-default .ff_btn_style:focus,.ff-default .ff_btn_style:hover{
                opacity:.8;
                outline:0;
                text-decoration:none
            }
            .ff-default .ff-btn-primary:not(.ff_btn_no_style){
                background-color:#007bff;
                border-color:#007bff;
                color:#fff
            }
            .ff-default .ff-btn-primary:not(.ff_btn_no_style):focus,.ff-default .ff-btn-primary:not(.ff_btn_no_style):hover{
                background-color:#0069d9;
                border-color:#0062cc;
                color:#fff
            }
            .ff-default .ff-btn-secondary:not(.ff_btn_no_style){
                background-color:#606266;
                border-color:#606266;
                color:#fff
            }
            .ff-default .ff-btn-secondary:not(.ff_btn_no_style):focus,.ff-default .ff-btn-secondary:not(.ff_btn_no_style):hover{
                background-color:#727b84;
                border-color:#6c757d;
                color:#fff
            }
            .ff-default .ff-btn-lg{
                border-radius:6px;
                font-size:18px;
                line-height:1.5;
                padding:8px 16px
            }
            .ff-default .ff-btn-sm{
                border-radius:3px;
                font-size:13px;
                line-height:1.5;
                padding:4px 8px
            }
            .ff-default .ff-el-form-control{
                background-clip:padding-box;
                background-image:none;
                border:1px solid var(--fluentform-border-color);
                border-radius:var(--fluentform-border-radius);
                color:var(--fluentform-secondary);
                font-family:-apple-system,"system-ui",Segoe UI,Roboto,Oxygen-Sans,Ubuntu,Cantarell,Helvetica Neue,sans-serif;
                line-height:1;
                margin-bottom:0;
                max-width:100%;
                padding:11px 15px;
                transition:border-color .15s ease-in-out,box-shadow .15s ease-in-out
            }
            .ff-default .ff-el-form-control:focus{
                background-color:#fff;
                border-color:var(--fluentform-primary);
                color:var(--fluentform-secondary);
                outline:none
            }
            .ff-default .ff-el-form-check label.ff-el-form-check-label{
                cursor:pointer;
                margin-bottom:7px
            }
            .ff-default .ff-el-form-check label.ff-el-form-check-label>span:after,.ff-default .ff-el-form-check label.ff-el-form-check-label>span:before{
                content:none
            }
            .ff-default .ff-el-form-check:last-child label.ff-el-form-check-label{
                margin-bottom:0
            }
            .ff-default textarea{
                min-height:90px
            }
            select.ff-el-form-control:not([size]):not([multiple]){
                height:42px
            }
            .elementor-editor-active .ff-form-loading .ff-step-container .fluentform-step:first-child{
                height:auto
            }
            .ff-upload-preview.ff_uploading{
                opacity:.8
            }
            @keyframes ff_move{
                0%{
                    background-position:0 0
                }
                to{
                    background-position:50px 50px
                }
            }
            .ff_uploading .ff-el-progress .ff-el-progress-bar{
                animation:ff_move 2s linear infinite;
                background-image:linear-gradient(-45deg,hsl(0 0% 100% / .2) 25%,transparent 0,transparent 50%,hsl(0 0% 100% / .2) 0,hsl(0 0% 100% / .2) 75%,transparent 0,transparent);
                background-size:50px 50px;
                border-bottom-left-radius:20px;
                border-bottom-right-radius:8px;
                border-top-left-radius:20px;
                border-top-right-radius:8px;
                bottom:0;
                content:"";
                left:0;
                overflow:hidden;
                position:absolute;
                right:0;
                top:0;
                z-index:1
            }
            .ff_payment_summary{
                overflow-x:scroll
            }
            .pac-container{
                z-index:99999!important
            }
            .ff-default{
                font-family:inherit
            }
            .ff-default .ff-el-input--label label{
                display:inline-block;
                font-weight:500;
                line-height:inherit;
                margin-bottom:0
            }</style>
        <style id='classic-theme-styles-inline-css' type='text/css'>
            /*! This file is auto-generated */
            .wp-block-button__link{
                color:#fff;
                background-color:#32373c;
                border-radius:9999px;
                box-shadow:none;
                text-decoration:none;
                padding:calc(.667em + 2px) calc(1.333em + 2px);
                font-size:1.125em
            }
            .wp-block-file__button{
                background:#32373c;
                color:#fff;
                text-decoration:none
            }
        </style>
        <style id='global-styles-inline-css' type='text/css'>
            :root{
                --wp--preset--aspect-ratio--square: 1;
                --wp--preset--aspect-ratio--4-3: 4/3;
                --wp--preset--aspect-ratio--3-4: 3/4;
                --wp--preset--aspect-ratio--3-2: 3/2;
                --wp--preset--aspect-ratio--2-3: 2/3;
                --wp--preset--aspect-ratio--16-9: 16/9;
                --wp--preset--aspect-ratio--9-16: 9/16;
                --wp--preset--color--black: #000000;
                --wp--preset--color--cyan-bluish-gray: #abb8c3;
                --wp--preset--color--white: #ffffff;
                --wp--preset--color--pale-pink: #f78da7;
                --wp--preset--color--vivid-red: #cf2e2e;
                --wp--preset--color--luminous-vivid-orange: #ff6900;
                --wp--preset--color--luminous-vivid-amber: #fcb900;
                --wp--preset--color--light-green-cyan: #7bdcb5;
                --wp--preset--color--vivid-green-cyan: #00d084;
                --wp--preset--color--pale-cyan-blue: #8ed1fc;
                --wp--preset--color--vivid-cyan-blue: #0693e3;
                --wp--preset--color--vivid-purple: #9b51e0;
                --wp--preset--gradient--vivid-cyan-blue-to-vivid-purple: linear-gradient(135deg,rgba(6,147,227,1) 0%,rgb(155,81,224) 100%);
                --wp--preset--gradient--light-green-cyan-to-vivid-green-cyan: linear-gradient(135deg,rgb(122,220,180) 0%,rgb(0,208,130) 100%);
                --wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange: linear-gradient(135deg,rgba(252,185,0,1) 0%,rgba(255,105,0,1) 100%);
                --wp--preset--gradient--luminous-vivid-orange-to-vivid-red: linear-gradient(135deg,rgba(255,105,0,1) 0%,rgb(207,46,46) 100%);
                --wp--preset--gradient--very-light-gray-to-cyan-bluish-gray: linear-gradient(135deg,rgb(238,238,238) 0%,rgb(169,184,195) 100%);
                --wp--preset--gradient--cool-to-warm-spectrum: linear-gradient(135deg,rgb(74,234,220) 0%,rgb(151,120,209) 20%,rgb(207,42,186) 40%,rgb(238,44,130) 60%,rgb(251,105,98) 80%,rgb(254,248,76) 100%);
                --wp--preset--gradient--blush-light-purple: linear-gradient(135deg,rgb(255,206,236) 0%,rgb(152,150,240) 100%);
                --wp--preset--gradient--blush-bordeaux: linear-gradient(135deg,rgb(254,205,165) 0%,rgb(254,45,45) 50%,rgb(107,0,62) 100%);
                --wp--preset--gradient--luminous-dusk: linear-gradient(135deg,rgb(255,203,112) 0%,rgb(199,81,192) 50%,rgb(65,88,208) 100%);
                --wp--preset--gradient--pale-ocean: linear-gradient(135deg,rgb(255,245,203) 0%,rgb(182,227,212) 50%,rgb(51,167,181) 100%);
                --wp--preset--gradient--electric-grass: linear-gradient(135deg,rgb(202,248,128) 0%,rgb(113,206,126) 100%);
                --wp--preset--gradient--midnight: linear-gradient(135deg,rgb(2,3,129) 0%,rgb(40,116,252) 100%);
                --wp--preset--font-size--small: 13px;
                --wp--preset--font-size--medium: 20px;
                --wp--preset--font-size--large: 36px;
                --wp--preset--font-size--x-large: 42px;
                --wp--preset--spacing--20: 0.44rem;
                --wp--preset--spacing--30: 0.67rem;
                --wp--preset--spacing--40: 1rem;
                --wp--preset--spacing--50: 1.5rem;
                --wp--preset--spacing--60: 2.25rem;
                --wp--preset--spacing--70: 3.38rem;
                --wp--preset--spacing--80: 5.06rem;
                --wp--preset--shadow--natural: 6px 6px 9px rgba(0, 0, 0, 0.2);
                --wp--preset--shadow--deep: 12px 12px 50px rgba(0, 0, 0, 0.4);
                --wp--preset--shadow--sharp: 6px 6px 0px rgba(0, 0, 0, 0.2);
                --wp--preset--shadow--outlined: 6px 6px 0px -3px rgba(255, 255, 255, 1), 6px 6px rgba(0, 0, 0, 1);
                --wp--preset--shadow--crisp: 6px 6px 0px rgba(0, 0, 0, 1);
            }
            :where(.is-layout-flex){
                gap: 0.5em;
            }
            :where(.is-layout-grid){
                gap: 0.5em;
            }
            body .is-layout-flex{
                display: flex;
            }
            .is-layout-flex{
                flex-wrap: wrap;
                align-items: center;
            }
            .is-layout-flex > :is(*, div){
                margin: 0;
            }
            body .is-layout-grid{
                display: grid;
            }
            .is-layout-grid > :is(*, div){
                margin: 0;
            }
            :where(.wp-block-columns.is-layout-flex){
                gap: 2em;
            }
            :where(.wp-block-columns.is-layout-grid){
                gap: 2em;
            }
            :where(.wp-block-post-template.is-layout-flex){
                gap: 1.25em;
            }
            :where(.wp-block-post-template.is-layout-grid){
                gap: 1.25em;
            }
            .has-black-color{
                color: var(--wp--preset--color--black) !important;
            }
            .has-cyan-bluish-gray-color{
                color: var(--wp--preset--color--cyan-bluish-gray) !important;
            }
            .has-white-color{
                color: var(--wp--preset--color--white) !important;
            }
            .has-pale-pink-color{
                color: var(--wp--preset--color--pale-pink) !important;
            }
            .has-vivid-red-color{
                color: var(--wp--preset--color--vivid-red) !important;
            }
            .has-luminous-vivid-orange-color{
                color: var(--wp--preset--color--luminous-vivid-orange) !important;
            }
            .has-luminous-vivid-amber-color{
                color: var(--wp--preset--color--luminous-vivid-amber) !important;
            }
            .has-light-green-cyan-color{
                color: var(--wp--preset--color--light-green-cyan) !important;
            }
            .has-vivid-green-cyan-color{
                color: var(--wp--preset--color--vivid-green-cyan) !important;
            }
            .has-pale-cyan-blue-color{
                color: var(--wp--preset--color--pale-cyan-blue) !important;
            }
            .has-vivid-cyan-blue-color{
                color: var(--wp--preset--color--vivid-cyan-blue) !important;
            }
            .has-vivid-purple-color{
                color: var(--wp--preset--color--vivid-purple) !important;
            }
            .has-black-background-color{
                background-color: var(--wp--preset--color--black) !important;
            }
            .has-cyan-bluish-gray-background-color{
                background-color: var(--wp--preset--color--cyan-bluish-gray) !important;
            }
            .has-white-background-color{
                background-color: var(--wp--preset--color--white) !important;
            }
            .has-pale-pink-background-color{
                background-color: var(--wp--preset--color--pale-pink) !important;
            }
            .has-vivid-red-background-color{
                background-color: var(--wp--preset--color--vivid-red) !important;
            }
            .has-luminous-vivid-orange-background-color{
                background-color: var(--wp--preset--color--luminous-vivid-orange) !important;
            }
            .has-luminous-vivid-amber-background-color{
                background-color: var(--wp--preset--color--luminous-vivid-amber) !important;
            }
            .has-light-green-cyan-background-color{
                background-color: var(--wp--preset--color--light-green-cyan) !important;
            }
            .has-vivid-green-cyan-background-color{
                background-color: var(--wp--preset--color--vivid-green-cyan) !important;
            }
            .has-pale-cyan-blue-background-color{
                background-color: var(--wp--preset--color--pale-cyan-blue) !important;
            }
            .has-vivid-cyan-blue-background-color{
                background-color: var(--wp--preset--color--vivid-cyan-blue) !important;
            }
            .has-vivid-purple-background-color{
                background-color: var(--wp--preset--color--vivid-purple) !important;
            }
            .has-black-border-color{
                border-color: var(--wp--preset--color--black) !important;
            }
            .has-cyan-bluish-gray-border-color{
                border-color: var(--wp--preset--color--cyan-bluish-gray) !important;
            }
            .has-white-border-color{
                border-color: var(--wp--preset--color--white) !important;
            }
            .has-pale-pink-border-color{
                border-color: var(--wp--preset--color--pale-pink) !important;
            }
            .has-vivid-red-border-color{
                border-color: var(--wp--preset--color--vivid-red) !important;
            }
            .has-luminous-vivid-orange-border-color{
                border-color: var(--wp--preset--color--luminous-vivid-orange) !important;
            }
            .has-luminous-vivid-amber-border-color{
                border-color: var(--wp--preset--color--luminous-vivid-amber) !important;
            }
            .has-light-green-cyan-border-color{
                border-color: var(--wp--preset--color--light-green-cyan) !important;
            }
            .has-vivid-green-cyan-border-color{
                border-color: var(--wp--preset--color--vivid-green-cyan) !important;
            }
            .has-pale-cyan-blue-border-color{
                border-color: var(--wp--preset--color--pale-cyan-blue) !important;
            }
            .has-vivid-cyan-blue-border-color{
                border-color: var(--wp--preset--color--vivid-cyan-blue) !important;
            }
            .has-vivid-purple-border-color{
                border-color: var(--wp--preset--color--vivid-purple) !important;
            }
            .has-vivid-cyan-blue-to-vivid-purple-gradient-background{
                background: var(--wp--preset--gradient--vivid-cyan-blue-to-vivid-purple) !important;
            }
            .has-light-green-cyan-to-vivid-green-cyan-gradient-background{
                background: var(--wp--preset--gradient--light-green-cyan-to-vivid-green-cyan) !important;
            }
            .has-luminous-vivid-amber-to-luminous-vivid-orange-gradient-background{
                background: var(--wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange) !important;
            }
            .has-luminous-vivid-orange-to-vivid-red-gradient-background{
                background: var(--wp--preset--gradient--luminous-vivid-orange-to-vivid-red) !important;
            }
            .has-very-light-gray-to-cyan-bluish-gray-gradient-background{
                background: var(--wp--preset--gradient--very-light-gray-to-cyan-bluish-gray) !important;
            }
            .has-cool-to-warm-spectrum-gradient-background{
                background: var(--wp--preset--gradient--cool-to-warm-spectrum) !important;
            }
            .has-blush-light-purple-gradient-background{
                background: var(--wp--preset--gradient--blush-light-purple) !important;
            }
            .has-blush-bordeaux-gradient-background{
                background: var(--wp--preset--gradient--blush-bordeaux) !important;
            }
            .has-luminous-dusk-gradient-background{
                background: var(--wp--preset--gradient--luminous-dusk) !important;
            }
            .has-pale-ocean-gradient-background{
                background: var(--wp--preset--gradient--pale-ocean) !important;
            }
            .has-electric-grass-gradient-background{
                background: var(--wp--preset--gradient--electric-grass) !important;
            }
            .has-midnight-gradient-background{
                background: var(--wp--preset--gradient--midnight) !important;
            }
            .has-small-font-size{
                font-size: var(--wp--preset--font-size--small) !important;
            }
            .has-medium-font-size{
                font-size: var(--wp--preset--font-size--medium) !important;
            }
            .has-large-font-size{
                font-size: var(--wp--preset--font-size--large) !important;
            }
            .has-x-large-font-size{
                font-size: var(--wp--preset--font-size--x-large) !important;
            }
            :where(.wp-block-post-template.is-layout-flex){
                gap: 1.25em;
            }
            :where(.wp-block-post-template.is-layout-grid){
                gap: 1.25em;
            }
            :where(.wp-block-columns.is-layout-flex){
                gap: 2em;
            }
            :where(.wp-block-columns.is-layout-grid){
                gap: 2em;
            }
            :root :where(.wp-block-pullquote){
                font-size: 1.5em;
                line-height: 1.6;
            }
        </style>
        <style class="optimize_css_2" type="text/css" media="all">@keyframes RtclzoomOut{
                0%{
                    opacity:1;
                    transform:scale(0)
                }
                to{
                    opacity:0;
                    transform:scale(1.5)
                }
            }
            .rtcl-gb-pricing-box{
                overflow:hidden;
                position:relative
            }
            .rtcl-gb-pricing-box.content-alignment-left{
                text-align:left
            }
            .rtcl-gb-pricing-box.content-alignment-left ul{
                align-items:flex-start
            }
            .rtcl-gb-pricing-box.content-alignment-center{
                text-align:center
            }
            .rtcl-gb-pricing-box.content-alignment-center ul{
                align-items:center
            }
            .rtcl-gb-pricing-box.content-alignment-center ul li{
                justify-content:center
            }
            .rtcl-gb-pricing-box.content-alignment-right{
                text-align:right
            }
            .rtcl-gb-pricing-box.content-alignment-right ul{
                align-items:flex-end
            }
            .rtcl-gb-pricing-box.content-alignment-right ul li{
                justify-content:end
            }
            .rtcl-gb-pricing-box .rtcl-gb-pricing-features{
                color:#444;
                line-height:2.2;
                margin-bottom:0
            }
            .rtcl-gb-pricing-box .rtcl-gb-pricing-features p{
                margin:0 0 10px
            }
            .rtcl-gb-pricing-box .rtcl-gb-pricing-features ul{
                font-size:medium;
                list-style:none;
                margin:0;
                padding:0
            }
            .rtcl-gb-pricing-box .rtcl-gb-pricing-features ul li{
                align-items:center;
                display:inline-flex;
                gap:8px
            }
            .rtcl-gb-pricing-box .rtcl-gb-pricing-features ul li svg{
                width:15px
            }
            .rtcl-gb-pricing-box .rtcl-gb-pricing-button a{
                align-items:center;
                display:inline-flex;
                gap:8px;
                justify-content:center
            }
            .rtcl-gb-pricing-box .rtcl-gb-pricing-button a svg{
                width:14px
            }
            .rtcl-gb-pricing-box .rtcl-gb-price{
                align-items:flex-end;
                display:inline-flex
            }
            .rtcl-gb-pricing-box .rtcl-gb-price.currency-right{
                flex-direction:row-reverse
            }
            .rtcl-gb-pricing-box .pricing-label{
                align-items:flex-end;
                background-color:var(--rtcl-primary-color);
                border:0;
                box-sizing:border-box;
                color:#fff;
                display:flex;
                font-size:14px;
                font-weight:400;
                height:80px;
                justify-content:center;
                padding:5px 25px;
                position:absolute;
                right:-65px;
                top:-30px;
                transform:rotate(45deg);
                width:150px
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-1{
                background-color:#f5f7fa;
                padding:60px 20px;
                transition:all .5s ease-out
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-1 .rtcl-gb-pricing-title{
                color:#222;
                font-size:22px;
                font-weight:700;
                line-height:1.5;
                margin-bottom:30px
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-1 .rtcl-gb-pricing-price{
                align-items:flex-end;
                display:inline-flex;
                font-size:48px;
                line-height:1;
                margin-bottom:30px
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-1 .rtcl-gb-price{
                align-items:flex-end;
                display:inline-flex
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-1 .rtcl-gb-pricing-currency{
                font-size:20px;
                font-weight:500;
                line-height:1;
                position:relative
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-1 .rtcl-gb-number{
                font-weight:700
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-1 .rtcl-gb-pricing-features ul{
                display:flex;
                flex-direction:column
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-1 .rtcl-gb-pricing-duration{
                font-size:16px
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-1 .rtcl-gb-pricing-button{
                color:#fff;
                margin-top:20px
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-1 .rtcl-gb-pricing-button a{
                background-color:var(--rtcl-button-bg-color);
                border-color:var(--rtcl-button-bg-color);
                border-radius:2px;
                border-style:solid;
                border-width:1px;
                color:var(--rtcl-button-color);
                font-size:14px;
                font-weight:600;
                line-height:1.5;
                min-width:140px;
                padding:15px 20px;
                text-align:center;
                text-decoration:none;
                text-transform:uppercase;
                transition:all .3s ease-out
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-1 .rtcl-gb-pricing-button a:hover{
                background-color:#fff0;
                border-color:var(--rtcl-button-hover-bg-color);
                color:#333
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2{
                background-color:#fff;
                border-radius:4px 4px 0 0
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2 .pricing-header{
                background-color:var(--rtcl-primary-color);
                padding:40px;
                text-align:center
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2 .rtcl-gb-pricing-title{
                color:#fff;
                font-size:30px;
                font-weight:300;
                margin-bottom:17px
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2 .rtcl-gb-pricing-price{
                align-items:flex-end;
                color:#fff;
                display:inline-flex;
                font-size:48px;
                font-weight:600;
                line-height:1;
                margin-bottom:10px;
                position:relative;
                z-index:1
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2 .rtcl-gb-pricing-duration{
                font-size:22px;
                font-weight:300
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2 .pricing-body{
                padding:25px 40px 10px
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2 .rtcl-gb-pricing-features{
                line-height:2
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2 .rtcl-gb-pricing-features ul li{
                display:flex
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2 .rtcl-gb-pricing-features ul i{
                color:#5a49f8;
                min-width:15px
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2 .pricing-footer{
                border-radius:0 0 4px 4px;
                padding:20px 40px 35px
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2 .rtcl-gb-pricing-button a{
                background-color:#fff0;
                border-color:var(--rtcl-button-bg-color);
                border-radius:4px;
                border-style:solid;
                border-width:1px;
                color:#5a49f8;
                font-size:1rem;
                font-weight:500;
                line-height:1.3;
                padding:10px 27px;
                position:relative;
                text-decoration:none;
                transition:all .5s ease-in-out;
                z-index:2
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2 .rtcl-gb-pricing-button a:hover{
                background-color:var(--rtcl-button-hover-bg-color);
                border-color:var(--rtcl-button-hover-bg-color);
                color:#fff
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2.content-alignment-left .pricing-header{
                text-align:left
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2.content-alignment-center .pricing-header{
                text-align:center
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2.content-alignment-right .pricing-header{
                text-align:right
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3{
                background:#fff;
                padding:60px 30px;
                position:relative;
                text-align:center;
                transition:all .3s ease-in-out;
                z-index:1
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3 .box-icon{
                align-items:center;
                border-radius:50%;
                display:inline-flex;
                height:160px;
                justify-content:center;
                line-height:1;
                margin-bottom:1.875rem;
                position:relative;
                width:160px;
                z-index:1
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3 .box-icon:after,.rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3 .box-icon:before{
                background-color:rgb(255 147 14 / .1);
                border-radius:50%;
                bottom:0;
                content:"";
                height:160px;
                left:0;
                margin:auto;
                overflow:hidden;
                position:absolute;
                right:0;
                top:0;
                transition:all .5s ease-in-out;
                width:160px;
                z-index:-1
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3 .box-icon:after{
                height:100px;
                width:100px
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3 .box-icon svg{
                fill:#ff930e;
                width:36px
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3 .rtcl-gb-pricing-title{
                color:#1d2124;
                font-size:22px;
                font-weight:600;
                line-height:1;
                margin-bottom:20px
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3 .rtcl-gb-pricing-features{
                margin-bottom:20px
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3 .rtcl-gb-pricing-features ul li{
                align-items:center;
                display:flex
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3 .rtcl-gb-price{
                color:#1d2124;
                display:flex;
                font-size:3rem;
                font-weight:600;
                justify-content:center;
                line-height:1;
                position:relative
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3 .rtcl-gb-pricing-duration{
                color:#646464;
                display:block;
                font-size:16px;
                font-weight:400;
                line-height:1.3;
                margin-top:10px
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3 .rtcl-gb-pricing-button{
                margin-top:30px
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3 .rtcl-gb-pricing-button a{
                align-items:center;
                border-color:var(--rtcl-button-bg-color);
                border-radius:4px;
                border-style:solid;
                border-width:1px;
                color:#5a49f8;
                display:inline-flex;
                font-size:1rem;
                font-weight:500;
                justify-content:center;
                padding:10px 27px;
                position:relative;
                text-decoration:none;
                transition:all .5s ease-in-out;
                z-index:2
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3 .rtcl-gb-pricing-button a:hover{
                background-color:var(--rtcl-button-hover-bg-color);
                border-color:var(--rtcl-button-hover-bg-color);
                color:#fff
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3.content-alignment-left .pricing-footer,.rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3.content-alignment-left .pricing-header{
                text-align:left
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3.content-alignment-left .rtcl-gb-pricing-price{
                align-items:flex-start;
                display:flex;
                flex-direction:column
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3.content-alignment-center{
                text-align:center
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3.content-alignment-right{
                text-align:right
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3.content-alignment-right .rtcl-gb-pricing-price{
                align-items:flex-end;
                display:flex;
                flex-direction:column
            }
            .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3:hover .box-icon:before{
                animation:RtclzoomOut 1s infinite
            }
            .rtcl-gb-listing-store .rtcl-item{
                background-color:#fff;
                border:1px solid rgb(0 0 0 / .05);
                color:#2a2a2a;
                height:100%;
                overflow:hidden;
                padding:25px;
                transition:all .3s ease-in
            }
            .rtcl-gb-listing-store .rtcl-item:hover{
                box-shadow:0 0 5px 1px rgb(0 0 0 / .2)
            }
            .rtcl-gb-listing-store .rtcl-item .rtcl-title{
                color:var(--rtcl-color-title);
                font-size:20px;
                font-weight:700;
                line-height:1.5;
                margin-bottom:6px;
                transition:all .3s ease-out
            }
            .rtcl-gb-listing-store .rtcl-item .rtcl-title:hover{
                color:var(--rtcl-primary-color)
            }
            .rtcl-gb-listing-store .rtcl-item .rtcl-title a{
                color:inherit
            }
            .rtcl-gb-listing-store .rtcl-item .rtcl-count{
                font-size:15px;
                line-height:1;
                margin-top:4px
            }
            .rtcl-gb-listing-store .rtcl-item .rtcl-description{
                font-size:16px;
                line-height:26px;
                margin-bottom:0;
                margin-top:14px
            }
            .rtcl-gb-listing-store.style-grid .rtcl-col-wrap{
                margin-bottom:30px
            }
            .rtcl-gb-listing-store.style-grid .rtcl-item{
                text-align:center
            }
            .rtcl-gb-listing-store.style-grid .rtcl-item .rtcl-logo{
                margin-bottom:15px
            }
            .rtcl-gb-listing-store.style-list{
                display:grid;
                gap:20px;
                margin-bottom:30px
            }
            .rtcl-gb-listing-store.style-list .rtcl-item{
                display:flex;
                gap:20px
            }</style>
        <style class="optimize_css_2" type="text/css" media="all">.rtcl .rtcl-stores{
                grid-column-gap:15px;
                grid-row-gap:15px;
                display:grid;
                grid-template-columns:repeat(4,1fr)
            }
            .rtcl .rtcl-stores .rtcl-store-item .rtcl-store-link{
                align-content:center;
                display:flex;
                flex-direction:column;
                justify-content:center
            }
            .rtcl .rtcl-stores .rtcl-store-item .rtcl-store-link:hover{
                text-decoration:none
            }
            .rtcl .rtcl-stores .rtcl-store-item .store-thumb{
                align-content:center;
                background-color:#fff;
                display:flex;
                justify-content:center
            }
            .rtcl .rtcl-stores .rtcl-store-item .store-thumb img{
                max-width:100%
            }
            .rtcl .rtcl-stores .rtcl-store-item .item-content{
                align-items:center;
                color:#2a2a2a;
                display:flex;
                flex-direction:column;
                justify-content:center;
                padding:10px 5px
            }
            .rtcl .rtcl-stores .rtcl-store-item .rtcl-store-title{
                font-size:20px;
                margin-bottom:5px;
                word-break:break-all
            }
            .rtcl .rtcl-stores .rtcl-store-item:hover .item-content{
                background-color:#1e73be;
                box-shadow:0 0 20px 0 hsl(0 0% 85% / .75);
                color:#fff
            }
            .rtcl .rtcl-stores.columns-6{
                grid-template-columns:repeat(6,1fr)
            }
            .rtcl .rtcl-stores.columns-5{
                grid-template-columns:repeat(5,1fr)
            }
            .rtcl .rtcl-stores.columns-4{
                grid-template-columns:repeat(4,1fr)
            }
            .rtcl .rtcl-stores.columns-3{
                grid-template-columns:repeat(3,1fr)
            }
            .rtcl .rtcl-stores.columns-2{
                grid-template-columns:repeat(2,1fr)
            }
            .rtcl .rtcl-stores.columns-1{
                grid-template-columns:repeat(1,1fr)
            }
            @media (max-width:991px){
                .rtcl .rtcl-stores,.rtcl .rtcl-stores.columns-4,.rtcl .rtcl-stores.columns-5,.rtcl .rtcl-stores.columns-6{
                    grid-template-columns:repeat(3,1fr)
                }
            }
            @media (max-width:767px){
                .rtcl .rtcl-stores,.rtcl .rtcl-stores.columns-3,.rtcl .rtcl-stores.columns-4,.rtcl .rtcl-stores.columns-5,.rtcl .rtcl-stores.columns-6{
                    grid-template-columns:repeat(2,1fr)
                }
            }
            @media (max-width:575px){
                .rtcl .rtcl-stores,.rtcl .rtcl-stores.columns-3,.rtcl .rtcl-stores.columns-4,.rtcl .rtcl-stores.columns-5,.rtcl .rtcl-stores.columns-6{
                    grid-template-columns:repeat(1,1fr)
                }
            }
            .rtcl .rtcl-pricing-table .price-item{
                border-radius:0;
                -moz-transition:all .3s ease;
                -o-transition:all .3s ease;
                -webkit-transition:all .3s ease
            }
            .rtcl .rtcl-pricing-table .price-item:hover{
                box-shadow:0 8px 12px 0 rgb(0 0 0 / .2)
            }
            .rtcl .rtcl-pricing-table .price-item .card-header{
                background-color:#57ac57;
                border-color:#71df71;
                border-bottom:1px solid #71df71;
                border-radius:0;
                box-shadow:inset 0 5px 0 rgb(50 50 50 / .2);
                color:#fff;
                text-shadow:0 3px 0 rgb(50 50 50 / .6);
                -moz-transition:all .3s ease;
                -o-transition:all .3s ease;
                -webkit-transition:all .3s ease
            }
            .rtcl .rtcl-pricing-table .price-item .rtcl-po-price{
                background-color:#ef5a5c;
                color:#fff;
                font-size:40px;
                text-shadow:0 3px 0 rgb(50 50 50 / .3)
            }
            .rtcl .rtcl-pricing-table .price-item .panel-footer{
                background-color:rgb(0 0 0 / .1);
                border-bottom:0;
                box-shadow:0 3px 0 rgb(0 0 0 / .3);
                color:#fff
            }
            .rtcl .rtcl-pricing-table .price-item .panel-footer .btn{
                border:0;
                box-shadow:inset 0 -1px 0 rgb(50 50 50 / .2)
            }
            .rtcl.store-content-wrap{
                background-color:#fff;
                border:1px solid #e1e1e1;
                padding:30px 30px 40px
            }
            .rtcl.store-content-wrap .store-banner{
                margin:-30px -30px 20px;
                position:relative
            }
            .rtcl.store-content-wrap .store-banner .banner{
                background:#008329;
                max-height:362px;
                min-height:250px
            }
            .rtcl.store-content-wrap .store-banner .store-name-logo{
                bottom:0;
                display:flex;
                left:0;
                margin:1rem;
                position:absolute;
                right:0
            }
            .rtcl.store-content-wrap .store-banner .store-name-logo .store-logo{
                align-items:center;
                background:#fff;
                border-radius:2px;
                box-sizing:content-box;
                display:flex;
                height:150px;
                justify-content:center;
                width:200px
            }
            .rtcl.store-content-wrap .store-banner .store-name-logo .store-logo img{
                max-height:100%;
                max-width:100%;
                -o-object-fit:contain;
                object-fit:contain;
                padding:2px
            }
            .rtcl.store-content-wrap .store-banner .store-name-logo .store-info{
                display:flex;
                flex-direction:column;
                justify-content:center;
                padding:1rem 2rem
            }
            .rtcl.store-content-wrap .store-banner .store-name-logo .store-info .rtcl-store-cat{
                color:#fff
            }
            .rtcl.store-content-wrap .store-banner .store-name-logo .store-info .rtcl-store-cat .rtcl-icon,.rtcl.store-content-wrap .store-banner .store-name-logo .store-info .rtcl-store-cat a{
                color:inherit
            }
            .rtcl.store-content-wrap .store-banner .store-name-logo .store-name h2{
                word-wrap:break-word;
                color:#fff;
                padding:0;
                text-shadow:0 1px 3px rgb(0 0 0 / .9);
                word-break:break-word
            }
            .rtcl.store-content-wrap .store-banner .store-name-logo .reviews-rating{
                align-items:center;
                color:#fff;
                display:flex
            }
            .rtcl.store-content-wrap .store-details .is-slogan,.rtcl.store-content-wrap .store-listing-list>h3{
                font-size:1.2858rem
            }
            .rtcl.store-content-wrap .store-information .store-details .store-description{
                margin:15px 0 55px;
                position:relative
            }
            .rtcl.store-content-wrap .store-information .store-details .store-description .fade-content{
                margin-bottom:2rem;
                max-height:9rem;
                overflow:hidden
            }
            .rtcl.store-content-wrap .store-information .store-details .store-description .fade-anchor{
                background:linear-gradient(180deg,#fff0,#fff0 .1rem,#fff 1.5rem);
                bottom:-30px;
                display:block;
                padding-top:30px;
                position:absolute;
                width:100%
            }
            .rtcl.store-content-wrap .store-information .store-info .store-info-item{
                word-wrap:break-word;
                border-bottom:1px solid #d4ded9;
                display:flex;
                margin-top:1rem;
                padding-bottom:.8rem;
                word-break:break-word
            }
            .rtcl.store-content-wrap .store-information .store-info .store-info-item .icon{
                align-items:center;
                justify-content:center;
                justify-items:center;
                padding-right:10px
            }
            .rtcl.store-content-wrap .store-information .store-info .store-info-item .text{
                align-items:center;
                justify-content:center;
                justify-items:center
            }
            .rtcl.store-content-wrap .store-information .store-info .store-info-item .text .open-day.always{
                color:#37a000
            }
            .rtcl.store-content-wrap .store-information .store-info .store-info-item .text .open-day .store-now{
                display:block
            }
            .rtcl.store-content-wrap .store-information .store-info .store-info-item .text .open-day .store-now.store-open{
                color:#37a000
            }
            .rtcl.store-content-wrap .store-information .store-info .store-info-item .text .open-day .store-now.store-close{
                color:#b4352d
            }
            .rtcl.store-content-wrap .store-information .store-info .store-info-item .text .open-day .label{
                font-size:100%;
                padding:0
            }
            .rtcl.store-content-wrap .store-information .store-info .store-info-item .text .open-day .hours{
                font-weight:700;
                margin-left:5px
            }
            .rtcl.store-content-wrap .store-information .store-info .store-info-item .text .open-day .hours span.close-hour:before{
                content:"-";
                margin:0 5px
            }
            .rtcl.store-content-wrap .store-information .store-info .store-info-item .text .close-day{
                color:#b4352d
            }
            .rtcl.store-content-wrap .store-information .store-info .store-info-item.store-email{
                flex-flow:row wrap
            }
            .rtcl.store-content-wrap .store-information .store-info .store-info-item.store-email .store-email-label{
                color:#008329;
                cursor:pointer;
                font-weight:700;
                width:100%
            }
            .rtcl.store-content-wrap .store-information .store-info .store-info-item.store-email #store-email-area{
                display:none;
                padding-top:10px;
                width:100%
            }
            .rtcl.store-content-wrap .store-information .store-info .store-social-media{
                flex-wrap:wrap;
                gap:10px
            }
            .rtcl.store-content-wrap .store-information .store-info .store-social-media a{
                color:#fff;
                display:inline-block;
                font-weight:400;
                margin-right:0;
                text-decoration:none;
                transition:all .5s ease-out
            }
            .rtcl.store-content-wrap .store-information .store-info .store-social-media a.tiktok,.rtcl.store-content-wrap .store-information .store-info .store-social-media a.twitter{
                align-items:center;
                background:#000;
                border-radius:50%;
                display:inline-flex;
                height:36px;
                justify-content:center;
                width:36px
            }
            .rtcl.store-content-wrap .store-information .store-info .store-social-media .rtcl-icon{
                align-items:center;
                background-color:#1e73be;
                border-radius:50%;
                color:#fff;
                display:flex;
                height:36px;
                justify-content:center;
                margin-right:0!important;
                text-align:center;
                width:36px
            }
            .rtcl.store-content-wrap .store-information .store-info .store-social-media .rtcl-icon.rtcl-icon-facebook{
                background:#3b5998
            }
            .rtcl.store-content-wrap .store-information .store-info .store-social-media .rtcl-icon.rtcl-icon-tiktok,.rtcl.store-content-wrap .store-information .store-info .store-social-media .rtcl-icon.rtcl-icon-twitter{
                background:#fff;
                height:16px;
                width:16px
            }
            .rtcl.store-content-wrap .store-information .store-info .store-social-media .rtcl-icon.rtcl-icon-youtube{
                background:red
            }
            .rtcl.store-content-wrap .store-information .store-info .store-social-media .rtcl-icon.rtcl-icon-instagram{
                background:#000
            }
            .rtcl.store-content-wrap .store-information .store-info .store-social-media .rtcl-icon.rtcl-icon-linkedin{
                background:#1178b3
            }
            .rtcl.store-content-wrap .store-information .store-info .store-social-media .rtcl-icon.rtcl-icon-pinterest-circled{
                background:#c8232c
            }
            .rtcl.store-content-wrap .store-information .store-info .store-social-media .rtcl-icon.rtcl-icon-gplus{
                background:#d34836
            }
            .rtcl.store-content-wrap .store-information .store-info .store-website a{
                color:inherit;
                text-decoration:none
            }
            .rtcl.store-content-wrap .store-information .store-info .store-website a:hover{
                color:var(--rtcl-primary-color)
            }
            .rtcl.store-content-wrap .store-information .store-info .reveal-phone{
                cursor:pointer;
                font-weight:700
            }
            .rtcl.store-content-wrap .store-information .store-info .reveal-phone:not(.revealed):hover{
                color:#37a000
            }
            .rtcl.store-content-wrap .store-information .store-info .reveal-phone.revealed small{
                display:none
            }
            .rtcl .store-more-details{
                padding:0 1.5rem 5px
            }
            .rtcl .store-more-details h3{
                border-bottom:1px solid #d4ded9;
                color:#000;
                margin-bottom:10px;
                padding-bottom:10px
            }
            .rtcl .store-more-details .more-item{
                word-wrap:break-word;
                margin-bottom:1.5rem;
                word-break:break-word
            }
            .rtcl .store-more-details .store-hours-list-wrap .store-hours-list .store-hour{
                margin-bottom:5px
            }
            .rtcl .store-more-details .store-hours-list-wrap .store-hours-list .store-hour .hour-day{
                text-transform:capitalize
            }
            .rtcl .store-more-details .store-hours-list-wrap .store-hours-list .store-hour:last-child{
                margin-bottom:0
            }
            .rtcl .store-more-details .store-hours-list-wrap .store-hours-list .store-hour.current-store-hour{
                font-weight:600
            }
            .rtcl .store-more-details .store-hours-list-wrap .store-hours-list .store-hour .oh-hours-wrap .oh-hours .close-hour:before{
                content:"--";
                padding:0 5px
            }
            .rtcl .store-more-details .store-hours-list-wrap .store-hours-list .store-hour .oh-hours-wrap .off-day{
                color:#b4352d
            }
            .rtcl .store-more-details .store-hours-list-wrap .store-hours-list .always-open{
                color:#37a000
            }
            .rtcl #store-details-modal #store-details-modal-label{
                text-align:center;
                width:100%
            }
            .rtcl .features span{
                display:block;
                margin-bottom:5px
            }
            .rtcl .rtcl-store-meta small{
                font-size:90%
            }
            .rtcl .rtcl-store-meta .rtcl-icon{
                margin-right:4px
            }
            .rtcl .rtcl-membership-promotion-actions{
                display:flex;
                justify-content:space-between;
                margin-bottom:1rem
            }
            .rtcl .rtcl-promotions-heading{
                border:1px solid #dee2e6;
                cursor:pointer;
                font-size:18px;
                line-height:1.4;
                margin:0;
                padding:10px 14px
            }
            .rtcl .rtcl-promotions-heading:before{
                content:"\e856";
                display:inline-block;
                font-family:rtcl,serif;
                margin-right:.5em
            }
            .rtcl .rtcl-promotions-heading+#rtcl-checkout-form,.rtcl .rtcl-promotions-heading+#rtcl-woo-checkout-form,.rtcl .rtcl-promotions-heading+.rtcl-membership-promotions-form-wrap{
                display:none
            }
            .rtcl .rtcl-promotions-heading.active:before{
                transform:rotate(180deg)
            }
            .rtcl .rtcl-membership-promotions .promotion-item{
                display:flex
            }
            .rtcl .rtcl-membership-promotions .promotion-item.label-item{
                font-weight:700
            }
            .rtcl .rtcl-membership-promotions .promotion-item .item-label{
                flex:0 0 90px
            }
            .rtcl .rtcl-membership-promotions .promotion-item .item-listings,.rtcl .rtcl-membership-promotions .promotion-item .item-validate{
                align-items:center;
                display:flex;
                flex:0 0 50px;
                justify-content:center
            }
            .rtcl .rtcl-membership-promotions .promotion-item+.promotion-item{
                border-top:1px solid #eee;
                margin-top:5px;
                padding-top:5px
            }
            .rtcl .pricing-description{
                margin-top:15px
            }
            .rtcl .promotion-validity small{
                margin-left:4px
            }
            .rtcl-store-widget-search-inline{
                display:flex;
                flex-wrap:wrap
            }
            .rtcl-store-widget-search-inline>div{
                flex:1 1 calc(33.3333% - 10px)
            }
            .rtcl-store-widget-search-inline .form-group{
                margin-bottom:0
            }
            .rtcl-store-widget-search-inline .form-group:nth-child(2),.rtcl-store-widget-search-inline .reset-btn,.rtcl-store-widget-search-inline .submit-btn{
                margin-left:10px
            }
            @media (max-width:479px){
                .rtcl-store-search-inline .rtcl-store-widget-search-inline>div{
                    flex:1 0 100%;
                    margin-bottom:10px
                }
                .rtcl-store-search-inline .rtcl-store-widget-search-inline .form-group:nth-child(2),.rtcl-store-search-inline .rtcl-store-widget-search-inline .submit-btn{
                    margin-left:0
                }
            }
            .rtcl-page.single-store .rtcl-store-item{
                padding:30px
            }
            @media (max-width:599px){
                .rtcl-page.single-store .rtcl-store-item{
                    padding:20px
                }
            }
            .rtcl-page.single-store .store-banner .reviews-rating{
                color:#ffb300!important
            }
            .rtcl-page.single-store .store-banner .reviews-rating .rtrs-star-empty:before,.rtcl-page.single-store .store-banner .reviews-rating .rtrs-star-half-alt:before,.rtcl-page.single-store .store-banner .reviews-rating .rtrs-star:before{
                margin-left:0
            }
            .rtcl-page.single-store .store-banner .reviews-rating .reviews-rating-count{
                color:#fff
            }
            .rtcl-page.single-store .rtrs-review-wrap{
                background-color:#fff0;
                margin:30px 0 0;
                padding:0
            }
            .rtcl-page.single-store .rtrs-review-wrap .rtrs-summary{
                background-color:#fff;
                box-shadow:0 1px 3px 0 rgb(0 0 0 / .1);
                padding:30px
            }
            @media (max-width:599px){
                .rtcl-page.single-store .rtrs-review-wrap .rtrs-summary{
                    padding:20px
                }
            }
            .rtcl-page.single-store .rtrs-review-wrap .rtrs-sorting-bar{
                background-color:#fff;
                box-shadow:0 1px 3px 0 rgb(0 0 0 / .1);
                padding:10px 30px
            }
            @media (max-width:599px){
                .rtcl-page.single-store .rtrs-review-wrap .rtrs-sorting-bar{
                    padding:10px 20px
                }
            }
            .rtcl-page.single-store .rtrs-review-wrap .rtrs-sorting-bar .rtrs-sorting-select select{
                background-color:#f8f8f8;
                box-shadow:none;
                color:#646464
            }
            .rtcl-page.single-store .rtrs-review-wrap .rtrs-review-box{
                background-color:#fff;
                box-shadow:0 1px 3px 0 rgb(0 0 0 / .1);
                margin:0 0 30px;
                padding:30px 30px 10px
            }
            @media (max-width:599px){
                .rtcl-page.single-store .rtrs-review-wrap .rtrs-review-box{
                    padding:20px 20px 10px
                }
            }
            .rtcl-page.single-store .rtrs-review-wrap .rtrs-review-box .rtrs-review-form{
                background-color:#f8f8f8;
                margin-left:30px
            }
            .rtcl-page.single-store .rtrs-review-wrap .rtrs-review-form{
                background-color:#fff;
                box-shadow:0 1px 3px 0 rgb(0 0 0 / .1);
                padding:30px
            }
            @media (max-width:599px){
                .rtcl-page.single-store .rtrs-review-wrap .rtrs-review-form{
                    padding:20px
                }
            }
            @media (min-width:401px) and (max-width:500px){
                .rtcl .store-more-details{
                    padding:10px 40px
                }
            }
            @media (min-width:0) and (max-width:400px){
                .rtcl .store-more-details{
                    padding:0
                }
            }
            .rtcl-el-store-widget-wrapper .load-more-wrapper .load-more-btn{
                box-shadow:none;
                margin-top:30px;
                outline:none
            }
            .rtcl-el-store-widget-wrapper .load-more-wrapper .load-more-btn .fa-sync-alt{
                margin-right:5px
            }
            .rtcl-el-store-widget-wrapper .load-more-wrapper.loading .fa-sync-alt{
                animation-delay:0s;
                animation-direction:normal;
                animation-duration:1.5s;
                animation-iteration-count:infinite;
                animation-name:fa-spin;
                animation-timing-function:linear
            }</style>
        <link rel='stylesheet' id='elementor-icons-css' href='../wp-content/plugins/elementor/assets/lib/eicons/css/elementor-icons.min.css' type='text/css' media='all' />
        <link rel='stylesheet' id='swiper-css' href='../wp-content/plugins/elementor/assets/lib/swiper/v8/css/swiper.min.css' type='text/css' media='all' />
        <style class="optimize_css_2" type="text/css" media="all">.elementor-kit-2673{
                --e-global-color-primary:#00C194;
                --e-global-color-secondary:#07C196;
                --e-global-color-text:#70778B;
                --e-global-color-accent:#00C194;
                --e-global-color-d22c469:#00A376;
                --e-global-color-4f65493:#EAF7F4;
                --e-global-color-00ccbeb:#212121;
                --e-global-color-2ab0c7b:#EAF7F4;
                --e-global-typography-primary-font-family:"Ubuntu";
                --e-global-typography-primary-font-weight:600;
                --e-global-typography-secondary-font-family:"Roboto";
                --e-global-typography-secondary-font-weight:400;
                --e-global-typography-text-font-family:"Roboto";
                --e-global-typography-text-font-weight:400;
                --e-global-typography-accent-font-family:"Roboto";
                --e-global-typography-accent-font-weight:500
            }
            .elementor-kit-2673 button,.elementor-kit-2673 input[type="button"],.elementor-kit-2673 input[type="submit"],.elementor-kit-2673 .elementor-button{
                font-family:"Mulish",Sans-serif
            }
            .elementor-section.elementor-section-boxed>.elementor-container{
                max-width:1240px
            }
            .e-con{
                --container-max-width:1240px
            }
            .elementor-widget:not(:last-child){
                margin-block-end:0
            }
            .elementor-element{
                --widgets-spacing:0px 0px
            }

            h1.entry-title{
                display:var(--page-title-display)
            }
            @media(max-width:992px){
                .elementor-section.elementor-section-boxed>.elementor-container{
                    max-width:1024px
                }
                .e-con{
                    --container-max-width:1024px
                }
            }
            @media(max-width:768px){
                .elementor-section.elementor-section-boxed>.elementor-container{
                    max-width:767px
                }
                .e-con{
                    --container-max-width:767px
                }
            }</style>
        <style class="optimize_css_2" type="text/css" media="all">.elementor-widget-heading .elementor-heading-title{
                color:var(--e-global-color-primary);
                font-family:var(--e-global-typography-primary-font-family),Sans-serif;
                font-weight:var(--e-global-typography-primary-font-weight)
            }
            .elementor-widget-image .widget-image-caption{
                color:var(--e-global-color-text);
                font-family:var(--e-global-typography-text-font-family),Sans-serif;
                font-weight:var(--e-global-typography-text-font-weight)
            }
            .elementor-widget-text-editor{
                color:var(--e-global-color-text);
                font-family:var(--e-global-typography-text-font-family),Sans-serif;
                font-weight:var(--e-global-typography-text-font-weight)
            }
            .elementor-widget-text-editor.elementor-drop-cap-view-stacked .elementor-drop-cap{
                background-color:var(--e-global-color-primary)
            }
            .elementor-widget-text-editor.elementor-drop-cap-view-framed .elementor-drop-cap,.elementor-widget-text-editor.elementor-drop-cap-view-default .elementor-drop-cap{
                color:var(--e-global-color-primary);
                border-color:var(--e-global-color-primary)
            }
            .elementor-widget-button .elementor-button{
                font-family:var(--e-global-typography-accent-font-family),Sans-serif;
                font-weight:var(--e-global-typography-accent-font-weight);
                background-color:var(--e-global-color-accent)
            }
            .elementor-widget-divider{
                --divider-color:var( --e-global-color-secondary )
            }
            .elementor-widget-divider .elementor-divider__text{
                color:var(--e-global-color-secondary);
                font-family:var(--e-global-typography-secondary-font-family),Sans-serif;
                font-weight:var(--e-global-typography-secondary-font-weight)
            }
            .elementor-widget-divider.elementor-view-stacked .elementor-icon{
                background-color:var(--e-global-color-secondary)
            }
            .elementor-widget-divider.elementor-view-framed .elementor-icon,.elementor-widget-divider.elementor-view-default .elementor-icon{
                color:var(--e-global-color-secondary);
                border-color:var(--e-global-color-secondary)
            }
            .elementor-widget-divider.elementor-view-framed .elementor-icon,.elementor-widget-divider.elementor-view-default .elementor-icon svg{
                fill:var(--e-global-color-secondary)
            }
            .elementor-widget-image-box .elementor-image-box-title{
                color:var(--e-global-color-primary);
                font-family:var(--e-global-typography-primary-font-family),Sans-serif;
                font-weight:var(--e-global-typography-primary-font-weight)
            }
            .elementor-widget-image-box .elementor-image-box-description{
                color:var(--e-global-color-text);
                font-family:var(--e-global-typography-text-font-family),Sans-serif;
                font-weight:var(--e-global-typography-text-font-weight)
            }
            .elementor-widget-icon.elementor-view-stacked .elementor-icon{
                background-color:var(--e-global-color-primary)
            }
            .elementor-widget-icon.elementor-view-framed .elementor-icon,.elementor-widget-icon.elementor-view-default .elementor-icon{
                color:var(--e-global-color-primary);
                border-color:var(--e-global-color-primary)
            }
            .elementor-widget-icon.elementor-view-framed .elementor-icon,.elementor-widget-icon.elementor-view-default .elementor-icon svg{
                fill:var(--e-global-color-primary)
            }
            .elementor-widget-icon-box.elementor-view-stacked .elementor-icon{
                background-color:var(--e-global-color-primary)
            }
            .elementor-widget-icon-box.elementor-view-framed .elementor-icon,.elementor-widget-icon-box.elementor-view-default .elementor-icon{
                fill:var(--e-global-color-primary);
                color:var(--e-global-color-primary);
                border-color:var(--e-global-color-primary)
            }
            .elementor-widget-icon-box .elementor-icon-box-title{
                color:var(--e-global-color-primary)
            }
            .elementor-widget-icon-box .elementor-icon-box-title,.elementor-widget-icon-box .elementor-icon-box-title a{
                font-family:var(--e-global-typography-primary-font-family),Sans-serif;
                font-weight:var(--e-global-typography-primary-font-weight)
            }
            .elementor-widget-icon-box .elementor-icon-box-description{
                color:var(--e-global-color-text);
                font-family:var(--e-global-typography-text-font-family),Sans-serif;
                font-weight:var(--e-global-typography-text-font-weight)
            }
            .elementor-widget-star-rating .elementor-star-rating__title{
                color:var(--e-global-color-text);
                font-family:var(--e-global-typography-text-font-family),Sans-serif;
                font-weight:var(--e-global-typography-text-font-weight)
            }
            .elementor-widget-image-gallery .gallery-item .gallery-caption{
                font-family:var(--e-global-typography-accent-font-family),Sans-serif;
                font-weight:var(--e-global-typography-accent-font-weight)
            }
            .elementor-widget-icon-list .elementor-icon-list-item:not(:last-child):after{
                border-color:var(--e-global-color-text)
            }
            .elementor-widget-icon-list .elementor-icon-list-icon i{
                color:var(--e-global-color-primary)
            }
            .elementor-widget-icon-list .elementor-icon-list-icon svg{
                fill:var(--e-global-color-primary)
            }
            .elementor-widget-icon-list .elementor-icon-list-item>.elementor-icon-list-text,.elementor-widget-icon-list .elementor-icon-list-item>a{
                font-family:var(--e-global-typography-text-font-family),Sans-serif;
                font-weight:var(--e-global-typography-text-font-weight)
            }
            .elementor-widget-icon-list .elementor-icon-list-text{
                color:var(--e-global-color-secondary)
            }
            .elementor-widget-counter .elementor-counter-number-wrapper{
                color:var(--e-global-color-primary);
                font-family:var(--e-global-typography-primary-font-family),Sans-serif;
                font-weight:var(--e-global-typography-primary-font-weight)
            }
            .elementor-widget-counter .elementor-counter-title{
                color:var(--e-global-color-secondary);
                font-family:var(--e-global-typography-secondary-font-family),Sans-serif;
                font-weight:var(--e-global-typography-secondary-font-weight)
            }
            .elementor-widget-progress .rt-progress-bar .elementor-progress-wrapper .elementor-progress-bar{
                background-color:var(--e-global-color-primary)
            }
            .elementor-widget-testimonial .elementor-testimonial-content{
                color:var(--e-global-color-text);
                font-family:var(--e-global-typography-text-font-family),Sans-serif;
                font-weight:var(--e-global-typography-text-font-weight)
            }
            .elementor-widget-testimonial .elementor-testimonial-name{
                color:var(--e-global-color-primary);
                font-family:var(--e-global-typography-primary-font-family),Sans-serif;
                font-weight:var(--e-global-typography-primary-font-weight)
            }
            .elementor-widget-testimonial .elementor-testimonial-job{
                color:var(--e-global-color-secondary);
                font-family:var(--e-global-typography-secondary-font-family),Sans-serif;
                font-weight:var(--e-global-typography-secondary-font-weight)
            }
            .elementor-widget-tabs .elementor-tab-title,.elementor-widget-tabs .elementor-tab-title a{
                color:var(--e-global-color-primary)
            }
            .elementor-widget-tabs .elementor-tab-title.elementor-active,.elementor-widget-tabs .elementor-tab-title.elementor-active a{
                color:var(--e-global-color-accent)
            }
            .elementor-widget-tabs .elementor-tab-title{
                font-family:var(--e-global-typography-primary-font-family),Sans-serif;
                font-weight:var(--e-global-typography-primary-font-weight)
            }
            .elementor-widget-tabs .elementor-tab-content{
                color:var(--e-global-color-text);
                font-family:var(--e-global-typography-text-font-family),Sans-serif;
                font-weight:var(--e-global-typography-text-font-weight)
            }
            .elementor-widget-accordion .elementor-accordion-icon,.elementor-widget-accordion .elementor-accordion-title{
                color:var(--e-global-color-primary)
            }
            .elementor-widget-accordion .elementor-accordion-icon svg{
                fill:var(--e-global-color-primary)
            }
            .elementor-widget-accordion .elementor-active .elementor-accordion-icon,.elementor-widget-accordion .elementor-active .elementor-accordion-title{
                color:var(--e-global-color-accent)
            }
            .elementor-widget-accordion .elementor-active .elementor-accordion-icon svg{
                fill:var(--e-global-color-accent)
            }
            .elementor-widget-accordion .elementor-accordion-title{
                font-family:var(--e-global-typography-primary-font-family),Sans-serif;
                font-weight:var(--e-global-typography-primary-font-weight)
            }
            .elementor-widget-accordion .elementor-tab-content{
                color:var(--e-global-color-text);
                font-family:var(--e-global-typography-text-font-family),Sans-serif;
                font-weight:var(--e-global-typography-text-font-weight)
            }
            .elementor-widget-toggle .elementor-toggle-title,.elementor-widget-toggle .elementor-toggle-icon{
                color:var(--e-global-color-primary)
            }
            .elementor-widget-toggle .elementor-toggle-icon svg{
                fill:var(--e-global-color-primary)
            }
            .elementor-widget-toggle .elementor-tab-title.elementor-active a,.elementor-widget-toggle .elementor-tab-title.elementor-active .elementor-toggle-icon{
                color:var(--e-global-color-accent)
            }
            .elementor-widget-toggle .elementor-toggle-title{
                font-family:var(--e-global-typography-primary-font-family),Sans-serif;
                font-weight:var(--e-global-typography-primary-font-weight)
            }
            .elementor-widget-toggle .elementor-tab-content{
                color:var(--e-global-color-text);
                font-family:var(--e-global-typography-text-font-family),Sans-serif;
                font-weight:var(--e-global-typography-text-font-weight)
            }
            .elementor-widget-alert .elementor-alert-title{
                font-family:var(--e-global-typography-primary-font-family),Sans-serif;
                font-weight:var(--e-global-typography-primary-font-weight)
            }
            .elementor-widget-alert .elementor-alert-description{
                font-family:var(--e-global-typography-text-font-family),Sans-serif;
                font-weight:var(--e-global-typography-text-font-weight)
            }
            .elementor-widget-fluent-form-widget .fluentform-widget-description{
                font-family:var(--e-global-typography-accent-font-family),Sans-serif;
                font-weight:var(--e-global-typography-accent-font-weight)
            }
            .elementor-widget-rt-properties-type-tab .isotope-classes-tab .nav-item{
                font-family:var(--e-global-typography-accent-font-family),Sans-serif;
                font-weight:var(--e-global-typography-accent-font-weight)
            }
            .elementor-widget-text-path{
                font-family:var(--e-global-typography-text-font-family),Sans-serif;
                font-weight:var(--e-global-typography-text-font-weight)
            }</style>
        <style class="optimize_css_2" type="text/css" media="all">.fluentform-widget-wrapper.hide-fluent-form-labels .ff-el-input--label{
                display:none!important
            }
            .fluentform-widget-wrapper.hide-error-message .ff-el-is-error .text-danger{
                display:none
            }
            .fluentform-widget-wrapper.fluentform-widget-align-left{
                margin:0 auto 0 0
            }
            .fluentform-widget-wrapper.fluentform-widget-align-center{
                float:none;
                margin:0 auto
            }
            .fluentform-widget-wrapper.fluentform-widget-align-right{
                margin:0 0 0 auto
            }
            .fluentform-widget-custom-radio-checkbox input[type=checkbox],.fluentform-widget-custom-radio-checkbox input[type=radio]{
                background:#ddd;
                height:15px;
                min-width:1px;
                outline:none;
                padding:3px;
                width:15px
            }
            .fluentform-widget-custom-radio-checkbox input[type=checkbox]:after,.fluentform-widget-custom-radio-checkbox input[type=radio]:after{
                border:0 solid #fff0;
                content:"";
                display:block;
                height:100%;
                margin:0;
                padding:0;
                width:100%
            }
            .fluentform-widget-custom-radio-checkbox input[type=checkbox]:checked:after,.fluentform-widget-custom-radio-checkbox input[type=radio]:checked:after{
                background:#999;
                background-image:url("data:image/svg+xml;charset=utf8,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3E%3Cpath fill='%23fff' d='M6.564.75l-3.59 3.612-1.538-1.55L0 4.26 2.974 7.25 8 2.193z'/%3E%3C/svg%3E");
                background-position:50%;
                background-repeat:no-repeat;
                background-size:12px
            }
            .fluentform-widget-custom-radio-checkbox input[type=radio],.fluentform-widget-custom-radio-checkbox input[type=radio]:after{
                border-radius:50%
            }
            .fluentform-widget-wrapper .frm-fluent-form .ff-step-header{
                margin-bottom:0
            }
            .ff-el-progress-bar{
                align-items:center;
                display:flex;
                height:100%;
                justify-content:flex-end
            }
            .fluent-form-widget-step-header-yes .ff-step-header .ff-el-progress-status,.fluent-form-widget-step-progressbar-yes .ff-el-progress{
                display:block
            }
            .fluent-form-widget-step-header-yes .frm-fluent-form .ff-step-header,.fluent-form-widget-step-progressbar-yes .frm-fluent-form .ff-step-header{
                margin-bottom:20px
            }
            .fluentform-widget-section-break-content-left .ff-el-group.ff-el-section-break{
                text-align:left
            }
            .fluentform-widget-section-break-content-center .ff-el-group.ff-el-section-break{
                text-align:center
            }
            .fluentform-widget-section-break-content-right .ff-el-group.ff-el-section-break{
                text-align:right
            }
            .fluentform-widget-submit-button-full-width .ff-btn-submit{
                display:block;
                width:100%
            }
            .fluentform-widget-submit-button-center .ff-el-group .ff-btn-submit,.fluentform-widget-submit-button-center .ff-el-group.ff-text-left .ff-btn-submit,.fluentform-widget-submit-button-center .ff-el-group.ff-text-right .ff-btn-submit{
                align-items:center;
                display:flex;
                justify-content:center;
                margin:0 auto
            }
            .fluentform-widget-submit-button-right .ff-el-group .ff-btn-submit,.fluentform-widget-submit-button-right .ff-el-group.ff-text-left .ff-btn-submit,.fluentform-widget-submit-button-right .ff-el-group.ff-text-right .ff-btn-submit{
                float:right
            }
            .fluentform-widget-submit-button-left .ff-el-group .ff-btn-submit,.fluentform-widget-submit-button-left .ff-el-group.ff-text-left .ff-btn-submit,.fluentform-widget-submit-button-left .ff-el-group.ff-text-right .ff-btn-submit{
                float:left
            }
            .fluentform-widget-wrapper.hide-placeholder input::-webkit-input-placeholder,.fluentform-widget-wrapper.hide-placeholder textarea::-webkit-input-placeholder{
                opacity:0;
                visibility:hidden
            }
            .fluentform-widget-wrapper.hide-placeholder input:-moz-placeholder,.fluentform-widget-wrapper.hide-placeholder input::-moz-placeholder,.fluentform-widget-wrapper.hide-placeholder textarea:-moz-placeholder,.fluentform-widget-wrapper.hide-placeholder textarea::-moz-placeholder{
                opacity:0;
                visibility:hidden
            }
            .fluentform-widget-wrapper.hide-placeholder input:-ms-input-placeholder,.fluentform-widget-wrapper.hide-placeholder textarea:-ms-input-placeholder{
                opacity:0;
                visibility:hidden
            }
            .fluentform-widget-wrapper.hide-placeholder input::-ms-input-placeholder,.fluentform-widget-wrapper.hide-placeholder textarea::-ms-input-placeholder{
                opacity:0;
                visibility:hidden
            }
            .lity{
                z-index:9999!important
            }</style>
        <style class="optimize_css_2" type="text/css" media="all">.elementor-2308 .elementor-element.elementor-element-f25a7df>.elementor-container>.elementor-column>.elementor-widget-wrap{
                align-content:center;
                align-items:center
            }
            .elementor-2308 .elementor-element.elementor-element-f25a7df{
                margin-top:120px;
                margin-bottom:100px
            }
            .elementor-2308 .elementor-element.elementor-element-c599729>.elementor-element-populated{
                padding:0 50px 0 10px
            }
            .elementor-2308 .elementor-element.elementor-element-e1aa780>.elementor-element-populated{
                margin:-10px 0 0 0;
                --e-column-margin-right:0px;
                --e-column-margin-left:0px;
                padding:0 0 0 0
            }
            .elementor-2308 .elementor-element.elementor-element-fba6d39 .section-title-wrapper .top-sub-title i{
                font-size:7px
            }
            .elementor-2308 .elementor-element.elementor-element-fba6d39 .section-title-wrapper .top-sub-title svg{
                width:7px;
                height:7px
            }
            .elementor-2308 .elementor-element.elementor-element-fba6d39 .section-title-wrapper .main-title{
                font-size:26px;
                font-weight:500
            }
            .elementor-2308 .elementor-element.elementor-element-fba6d39 .section-title-wrapper .description{
                font-size:15px;
                line-height:30px;
                color:#70778B
            }
            .elementor-2308 .elementor-element.elementor-element-fba6d39 .section-title-wrapper .description ul li::before{
                content:"\f00c";
                transform:translateY(0)
            }
            .elementor-2308 .elementor-element.elementor-element-fba6d39 .section-title-wrapper .background-title{
                opacity:1
            }
            .elementor-2308 .elementor-element.elementor-element-fba6d39 .section-title-wrapper{
                margin:0 0 30px 0
            }
            .elementor-2308 .elementor-element.elementor-element-d9cb8d9{
                border-style:solid;
                border-width:1px 1px 1px 1px;
                border-color:#E4E9F2;
                box-shadow:0 11px 35px 0 rgb(194 200 213 / .32);
                transition:background 0.3s,border 0.3s,border-radius 0.3s,box-shadow 0.3s;
                margin-top:0;
                margin-bottom:30px;
                padding:20px 18px 20px 18px
            }
            .elementor-2308 .elementor-element.elementor-element-d9cb8d9,.elementor-2308 .elementor-element.elementor-element-d9cb8d9>.elementor-background-overlay{
                border-radius:10px 10px 10px 10px
            }
            .elementor-2308 .elementor-element.elementor-element-d9cb8d9:hover{
                box-shadow:0 11px 35px 0 rgba(152.87771739130432,157.65317505720822,167.99999999999997,.32)
            }
            .elementor-2308 .elementor-element.elementor-element-d9cb8d9>.elementor-background-overlay{
                transition:background 0.3s,border-radius 0.3s,opacity 0.3s
            }
            .elementor-2308 .elementor-element.elementor-element-2f3d44f .rt-info-box .icon-holder{
                margin:0 0 0 0
            }
            .elementor-2308 .elementor-element.elementor-element-2f3d44f .rt-info-box .info-title{
                color:#70778B;
                font-family:"Roboto",Sans-serif;
                font-size:15px;
                font-weight:500;
                margin:-5px 0 0 0
            }
            .elementor-2308 .elementor-element.elementor-element-2f3d44f .rt-info-box .info-title a{
                color:#70778B
            }
            .elementor-2308 .elementor-element.elementor-element-2f3d44f .rt-info-box .content-holder p{
                color:#222;
                font-family:"Roboto",Sans-serif;
                font-size:18px;
                font-weight:500
            }
            .elementor-2308 .elementor-element.elementor-element-2f3d44f .rt-info-box .icon-holder i{
                width:60px;
                height:60px;
                line-height:60px;
                font-size:22px;
                border-radius:100px;
                color:var(--e-global-color-primary)
            }
            .elementor-2308 .elementor-element.elementor-element-2f3d44f .rt-info-box.icon-el-style-2 .icon-holder span{
                width:60px;
                height:60px;
                line-height:60px;
                border-radius:100px
            }
            .elementor-2308 .elementor-element.elementor-element-2f3d44f .rt-info-box .icon-holder svg{
                width:22px;
                height:22px
            }
            .elementor-2308 .elementor-element.elementor-element-2f3d44f .rt-info-box .icon-holder svg path{
                fill:var(--e-global-color-primary)
            }
            .elementor-2308 .elementor-element.elementor-element-2f3d44f .icon-el-style-2.rt-info-box .service-box .icon-holder span i{
                color:var(--e-global-color-primary)
            }
            .elementor-2308 .elementor-element.elementor-element-2f3d44f .icon-el-style-2.rt-info-box .service-box .icon-holder span svg path{
                fill:var(--e-global-color-primary)
            }
            .elementor-2308 .elementor-element.elementor-element-2f3d44f .rt-info-box .icon-holder i,.elementor-2308 .elementor-element.elementor-element-2f3d44f .rt-info-box.icon-el-style-2 .icon-holder span{
                background-color:#F9FBFE
            }
            .elementor-2308 .elementor-element.elementor-element-2f3d44f .rt-info-box:not(.icon-el-style-2) .icon-holder i,.elementor-2308 .elementor-element.elementor-element-2f3d44f .rt-info-box.icon-el-style-2 .icon-holder span{
                border-style:solid;
                border-width:1px 1px 1px 1px;
                border-color:#E5EAF2
            }
            .elementor-2308 .elementor-element.elementor-element-2f3d44f .rt-info-box:hover .icon-holder i{
                color:#FFF
            }
            .elementor-2308 .elementor-element.elementor-element-2f3d44f .icon-el-style-2.rt-info-box .service-box:hover span i{
                color:#FFFFFF!important
            }
            .elementor-2308 .elementor-element.elementor-element-2f3d44f .rt-info-box:hover .icon-holder i,.elementor-2308 .elementor-element.elementor-element-2f3d44f .rt-info-box.icon-el-style-2:hover .icon-holder span{
                background-color:var(--e-global-color-primary);
                border-style:solid;
                border-width:1px 1px 1px 1px;
                border-color:var(--e-global-color-primary)
            }
            .elementor-2308 .elementor-element.elementor-element-2f3d44f .rt-info-box .service-box{
                margin:0 0 7px 0
            }
            .elementor-2308 .elementor-element.elementor-element-831fd84{
                border-style:solid;
                border-width:1px 1px 1px 1px;
                border-color:#E4E9F2;
                box-shadow:0 11px 35px 0 rgb(194 200 213 / .32);
                transition:background 0.3s,border 0.3s,border-radius 0.3s,box-shadow 0.3s;
                margin-top:0;
                margin-bottom:30px;
                padding:20px 18px 20px 18px
            }
            .elementor-2308 .elementor-element.elementor-element-831fd84,.elementor-2308 .elementor-element.elementor-element-831fd84>.elementor-background-overlay{
                border-radius:10px 10px 10px 10px
            }
            .elementor-2308 .elementor-element.elementor-element-831fd84:hover{
                box-shadow:0 11px 35px 0 rgba(152.87771739130432,157.65317505720822,167.99999999999997,.32)
            }
            .elementor-2308 .elementor-element.elementor-element-831fd84>.elementor-background-overlay{
                transition:background 0.3s,border-radius 0.3s,opacity 0.3s
            }
            .elementor-2308 .elementor-element.elementor-element-0ff8102 .rt-info-box .icon-holder{
                margin:0 0 0 0
            }
            .elementor-2308 .elementor-element.elementor-element-0ff8102 .rt-info-box .info-title{
                color:#70778B;
                font-family:"Roboto",Sans-serif;
                font-size:15px;
                font-weight:500;
                margin:-5px 0 0 0
            }
            .elementor-2308 .elementor-element.elementor-element-0ff8102 .rt-info-box .info-title a{
                color:#70778B
            }
            .elementor-2308 .elementor-element.elementor-element-0ff8102 .rt-info-box .content-holder p{
                color:#222;
                font-family:"Roboto",Sans-serif;
                font-size:18px;
                font-weight:500
            }
            .elementor-2308 .elementor-element.elementor-element-0ff8102 .rt-info-box .icon-holder i{
                width:60px;
                height:60px;
                line-height:60px;
                font-size:22px;
                border-radius:100px;
                color:var(--e-global-color-primary)
            }
            .elementor-2308 .elementor-element.elementor-element-0ff8102 .rt-info-box.icon-el-style-2 .icon-holder span{
                width:60px;
                height:60px;
                line-height:60px;
                border-radius:100px
            }
            .elementor-2308 .elementor-element.elementor-element-0ff8102 .rt-info-box .icon-holder svg{
                width:22px;
                height:22px
            }
            .elementor-2308 .elementor-element.elementor-element-0ff8102 .rt-info-box .icon-holder svg path{
                fill:var(--e-global-color-primary)
            }
            .elementor-2308 .elementor-element.elementor-element-0ff8102 .icon-el-style-2.rt-info-box .service-box .icon-holder span i{
                color:var(--e-global-color-primary)
            }
            .elementor-2308 .elementor-element.elementor-element-0ff8102 .icon-el-style-2.rt-info-box .service-box .icon-holder span svg path{
                fill:var(--e-global-color-primary)
            }
            .elementor-2308 .elementor-element.elementor-element-0ff8102 .rt-info-box .icon-holder i,.elementor-2308 .elementor-element.elementor-element-0ff8102 .rt-info-box.icon-el-style-2 .icon-holder span{
                background-color:#F9FBFE
            }
            .elementor-2308 .elementor-element.elementor-element-0ff8102 .rt-info-box:not(.icon-el-style-2) .icon-holder i,.elementor-2308 .elementor-element.elementor-element-0ff8102 .rt-info-box.icon-el-style-2 .icon-holder span{
                border-style:solid;
                border-width:1px 1px 1px 1px;
                border-color:#E5EAF2
            }
            .elementor-2308 .elementor-element.elementor-element-0ff8102 .rt-info-box:hover .icon-holder i{
                color:#FFF
            }
            .elementor-2308 .elementor-element.elementor-element-0ff8102 .icon-el-style-2.rt-info-box .service-box:hover span i{
                color:#FFFFFF!important
            }
            .elementor-2308 .elementor-element.elementor-element-0ff8102 .rt-info-box:hover .icon-holder i,.elementor-2308 .elementor-element.elementor-element-0ff8102 .rt-info-box.icon-el-style-2:hover .icon-holder span{
                background-color:var(--e-global-color-primary);
                border-style:solid;
                border-width:1px 1px 1px 1px;
                border-color:var(--e-global-color-primary)
            }
            .elementor-2308 .elementor-element.elementor-element-0ff8102 .rt-info-box .service-box{
                margin:0 0 7px 0
            }
            .elementor-2308 .elementor-element.elementor-element-30c1269{
                border-style:solid;
                border-width:1px 1px 1px 1px;
                border-color:#E4E9F2;
                box-shadow:0 11px 35px 0 rgb(194 200 213 / .32);
                transition:background 0.3s,border 0.3s,border-radius 0.3s,box-shadow 0.3s;
                margin-top:0;
                margin-bottom:0;
                padding:20px 18px 20px 18px
            }
            .elementor-2308 .elementor-element.elementor-element-30c1269,.elementor-2308 .elementor-element.elementor-element-30c1269>.elementor-background-overlay{
                border-radius:10px 10px 10px 10px
            }
            .elementor-2308 .elementor-element.elementor-element-30c1269:hover{
                box-shadow:0 11px 35px 0 rgba(152.87771739130432,157.65317505720822,167.99999999999997,.32)
            }
            .elementor-2308 .elementor-element.elementor-element-30c1269>.elementor-background-overlay{
                transition:background 0.3s,border-radius 0.3s,opacity 0.3s
            }
            .elementor-2308 .elementor-element.elementor-element-7c03052 .rt-info-box .icon-holder{
                margin:0 0 0 0
            }
            .elementor-2308 .elementor-element.elementor-element-7c03052 .rt-info-box .info-title{
                color:#70778B;
                font-family:"Roboto",Sans-serif;
                font-size:15px;
                font-weight:500;
                margin:-5px 0 0 0
            }
            .elementor-2308 .elementor-element.elementor-element-7c03052 .rt-info-box .info-title a{
                color:#70778B
            }
            .elementor-2308 .elementor-element.elementor-element-7c03052 .rt-info-box .content-holder p{
                color:#144273;
                font-family:"Roboto",Sans-serif;
                font-size:18px;
                font-weight:500
            }
            .elementor-2308 .elementor-element.elementor-element-7c03052 .rt-info-box .icon-holder i{
                width:60px;
                height:60px;
                line-height:60px;
                font-size:22px;
                border-radius:100px;
                color:var(--e-global-color-primary)
            }
            .elementor-2308 .elementor-element.elementor-element-7c03052 .rt-info-box.icon-el-style-2 .icon-holder span{
                width:60px;
                height:60px;
                line-height:60px;
                border-radius:100px
            }
            .elementor-2308 .elementor-element.elementor-element-7c03052 .rt-info-box .icon-holder svg{
                width:22px;
                height:22px
            }
            .elementor-2308 .elementor-element.elementor-element-7c03052 .rt-info-box .icon-holder svg path{
                fill:var(--e-global-color-primary)
            }
            .elementor-2308 .elementor-element.elementor-element-7c03052 .icon-el-style-2.rt-info-box .service-box .icon-holder span i{
                color:var(--e-global-color-primary)
            }
            .elementor-2308 .elementor-element.elementor-element-7c03052 .icon-el-style-2.rt-info-box .service-box .icon-holder span svg path{
                fill:var(--e-global-color-primary)
            }
            .elementor-2308 .elementor-element.elementor-element-7c03052 .rt-info-box .icon-holder i,.elementor-2308 .elementor-element.elementor-element-7c03052 .rt-info-box.icon-el-style-2 .icon-holder span{
                background-color:#F9FBFE
            }
            .elementor-2308 .elementor-element.elementor-element-7c03052 .rt-info-box:not(.icon-el-style-2) .icon-holder i,.elementor-2308 .elementor-element.elementor-element-7c03052 .rt-info-box.icon-el-style-2 .icon-holder span{
                border-style:solid;
                border-width:1px 1px 1px 1px;
                border-color:#E5EAF2
            }
            .elementor-2308 .elementor-element.elementor-element-7c03052 .rt-info-box:hover .icon-holder i{
                color:#FFF
            }
            .elementor-2308 .elementor-element.elementor-element-7c03052 .icon-el-style-2.rt-info-box .service-box:hover span i{
                color:#FFFFFF!important
            }
            .elementor-2308 .elementor-element.elementor-element-7c03052 .rt-info-box:hover .icon-holder i,.elementor-2308 .elementor-element.elementor-element-7c03052 .rt-info-box.icon-el-style-2:hover .icon-holder span{
                background-color:var(--e-global-color-primary);
                border-style:solid;
                border-width:1px 1px 1px 1px;
                border-color:var(--e-global-color-primary)
            }
            .elementor-2308 .elementor-element.elementor-element-7c03052 .rt-info-box .service-box{
                margin:0 0 7px 0
            }
            .elementor-2308 .elementor-element.elementor-element-316fb9f{
                --grid-template-columns:repeat(0, auto);
                --icon-size:17px;
                --grid-column-gap:0px;
                --grid-row-gap:0px
            }
            .elementor-2308 .elementor-element.elementor-element-316fb9f .elementor-social-icon{
                background-color:#FFF0;
                --icon-padding:0.4em
            }
            .elementor-2308 .elementor-element.elementor-element-316fb9f .elementor-social-icon i{
                color:#B1B6C8
            }
            .elementor-2308 .elementor-element.elementor-element-316fb9f .elementor-social-icon svg{
                fill:#B1B6C8
            }
            .elementor-2308 .elementor-element.elementor-element-316fb9f .elementor-icon{
                border-radius:0 0 0 0
            }
            .elementor-2308 .elementor-element.elementor-element-316fb9f .elementor-social-icon:hover{
                background-color:#FFF0
            }
            .elementor-2308 .elementor-element.elementor-element-316fb9f .elementor-social-icon:hover i{
                color:var(--e-global-color-primary)
            }
            .elementor-2308 .elementor-element.elementor-element-316fb9f .elementor-social-icon:hover svg{
                fill:var(--e-global-color-primary)
            }
            .elementor-2308 .elementor-element.elementor-element-316fb9f>.elementor-widget-container{
                margin:-30px 71px 0 71px
            }
            .elementor-2308 .elementor-element.elementor-element-57dbaf1:not(.elementor-motion-effects-element-type-background)>.elementor-widget-wrap,.elementor-2308 .elementor-element.elementor-element-57dbaf1>.elementor-widget-wrap>.elementor-motion-effects-container>.elementor-motion-effects-layer{
                background-color:#FFF
            }
            .elementor-2308 .elementor-element.elementor-element-57dbaf1>.elementor-element-populated{
                border-style:solid;
                border-width:1px 1px 1px 1px;
                border-color:#EBEBEB;
                transition:background 0.3s,border 0.3s,border-radius 0.3s,box-shadow 0.3s;
                padding:30px 40px 30px 40px
            }
            .elementor-2308 .elementor-element.elementor-element-57dbaf1>.elementor-element-populated,.elementor-2308 .elementor-element.elementor-element-57dbaf1>.elementor-element-populated>.elementor-background-overlay,.elementor-2308 .elementor-element.elementor-element-57dbaf1>.elementor-background-slideshow{
                border-radius:10px 10px 10px 10px
            }
            .elementor-2308 .elementor-element.elementor-element-57dbaf1>.elementor-element-populated>.elementor-background-overlay{
                transition:background 0.3s,border-radius 0.3s,opacity 0.3s
            }
            .elementor-2308 .elementor-element.elementor-element-3fb60ee .section-title-wrapper .top-sub-title i{
                font-size:7px
            }
            .elementor-2308 .elementor-element.elementor-element-3fb60ee .section-title-wrapper .top-sub-title svg{
                width:7px;
                height:7px
            }
            .elementor-2308 .elementor-element.elementor-element-3fb60ee .section-title-wrapper .main-title{
                font-size:26px;
                font-weight:500
            }
            .elementor-2308 .elementor-element.elementor-element-3fb60ee .section-title-wrapper .description{
                font-size:15px;
                line-height:30px;
                color:#70778B
            }
            .elementor-2308 .elementor-element.elementor-element-3fb60ee .section-title-wrapper .description ul li::before{
                content:"\f00c";
                transform:translateY(0)
            }
            .elementor-2308 .elementor-element.elementor-element-3fb60ee .section-title-wrapper .background-title{
                opacity:1
            }
            .elementor-2308 .elementor-element.elementor-element-3fb60ee .section-title-wrapper{
                margin:0 0 27px 0
            }
            .elementor-2308 .elementor-element.elementor-element-3fb60ee>.elementor-widget-container{
                padding:0 30px 0 0
            }
            .elementor-2308 .elementor-element.elementor-element-4ea7ca8>.elementor-container>.elementor-column>.elementor-widget-wrap{
                align-content:center;
                align-items:center
            }
            .elementor-2308 .elementor-element.elementor-element-4ea7ca8{
                margin-top:0;
                margin-bottom:120px
            }
            .elementor-2308 .elementor-element.elementor-element-07fa2a4>.elementor-element-populated,.elementor-2308 .elementor-element.elementor-element-07fa2a4>.elementor-element-populated>.elementor-background-overlay,.elementor-2308 .elementor-element.elementor-element-07fa2a4>.elementor-background-slideshow{
                border-radius:10px 10px 10px 10px
            }
            .elementor-2308 .elementor-element.elementor-element-07fa2a4>.elementor-element-populated{
                margin:10px 10px 10px 10px;
                --e-column-margin-right:10px;
                --e-column-margin-left:10px;
                padding:0 0 0 0
            }
            .elementor-2308 .elementor-element.elementor-element-a2a1a1d>.elementor-widget-container{
                margin:-200px 0 -130px 0
            }
            @media(min-width:769px){
                .elementor-2308 .elementor-element.elementor-element-c599729{
                    width:50.805%
                }
                .elementor-2308 .elementor-element.elementor-element-57dbaf1{
                    width:49.195%
                }
            }
            @media(max-width:992px) and (min-width:769px){
                .elementor-2308 .elementor-element.elementor-element-c599729{
                    width:100%
                }
                .elementor-2308 .elementor-element.elementor-element-57dbaf1{
                    width:100%
                }
                .elementor-2308 .elementor-element.elementor-element-07fa2a4{
                    width:100%
                }
            }
            @media(max-width:992px){
                .elementor-2308 .elementor-element.elementor-element-c599729>.elementor-element-populated{
                    padding:15px 15px 15px 15px
                }
                .elementor-2308 .elementor-element.elementor-element-57dbaf1>.elementor-element-populated{
                    margin:15px 15px 15px 15px;
                    --e-column-margin-right:15px;
                    --e-column-margin-left:15px;
                    padding:15px 15px 15px 15px
                }
            }
            @media(max-width:768px){
                .elementor-2308 .elementor-element.elementor-element-316fb9f{
                    --icon-size:18px
                }
            }</style>
        <style class="optimize_css_2" type="text/css" media="all">@font-face{
                font-family:"flaticon";
                src:url(../wp-content/themes/homlisti/assets/fonts/flaticon.ttf#1721845095) format("truetype"),url(https://www.radiustheme.com/demo/wordpress/themes/homlisti/wp-content/themes/homlisti/assets/css/../fonts/flaticon.woff#1721845095) format("woff"),url(https://www.radiustheme.com/demo/wordpress/themes/homlisti/wp-content/themes/homlisti/assets/css/../fonts/flaticon.woff2#1721845095) format("woff2"),url(https://www.radiustheme.com/demo/wordpress/themes/homlisti/wp-content/themes/homlisti/assets/css/../fonts/flaticon.eot#1721845095) format("embedded-opentype"),url(https://www.radiustheme.com/demo/wordpress/themes/homlisti/wp-content/themes/homlisti/assets/css/../fonts/flaticon.svg?4c8541f813cac0753c62e0740c5ce069#flaticon) format("svg")
            }
            i[class^="flaticon-"]:before,i[class*=" flaticon-"]:before{
                font-family:flaticon!important;
                font-style:normal;
                font-weight:normal!important;
                font-variant:normal;
                text-transform:none;
                line-height:1;
                -webkit-font-smoothing:antialiased;
                -moz-osx-font-smoothing:grayscale
            }
            .flaticon-user:before{
                content:"\f101"
            }
            .flaticon-user-1:before{
                content:"\f102"
            }
            .flaticon-speech-bubble:before{
                content:"\f103"
            }
            .flaticon-next:before{
                content:"\f104"
            }
            .flaticon-share:before{
                content:"\f105"
            }
            .flaticon-share-1:before{
                content:"\f106"
            }
            .flaticon-left-and-right-arrows:before{
                content:"\f107"
            }
            .flaticon-heart:before{
                content:"\f108"
            }
            .flaticon-camera:before{
                content:"\f109"
            }
            .flaticon-video-player:before{
                content:"\f10a"
            }
            .flaticon-maps-and-flags:before{
                content:"\f10b"
            }
            .flaticon-check:before{
                content:"\f10c"
            }
            .flaticon-envelope:before{
                content:"\f10d"
            }
            .flaticon-phone-call:before{
                content:"\f10e"
            }
            .flaticon-call:before{
                content:"\f10f"
            }
            .flaticon-clock:before{
                content:"\f110"
            }
            .flaticon-play:before{
                content:"\f111"
            }
            .flaticon-loupe:before{
                content:"\f112"
            }
            .flaticon-user-2:before{
                content:"\f113"
            }
            .flaticon-bed:before{
                content:"\f114"
            }
            .flaticon-shower:before{
                content:"\f115"
            }
            .flaticon-pencil:before{
                content:"\f116"
            }
            .flaticon-two-overlapping-square:before{
                content:"\f117"
            }
            .flaticon-printer:before{
                content:"\f118"
            }
            .flaticon-comment:before{
                content:"\f119"
            }
            .flaticon-home:before{
                content:"\f11a"
            }
            .flaticon-garage:before{
                content:"\f11b"
            }
            .flaticon-full-size:before{
                content:"\f11c"
            }
            .flaticon-tag:before{
                content:"\f11d"
            }
            .flaticon-right-arrow:before{
                content:"\f11e"
            }
            .flaticon-left-arrow:before{
                content:"\f11f"
            }
            .flaticon-left-arrow-1:before{
                content:"\f120"
            }
            .flaticon-left-arrow-2:before{
                content:"\f121"
            }
            .flaticon-right-arrow-1:before{
                content:"\f122"
            }</style>
        <style class="optimize_css_2" type="text/css" media="all">.mfp-bg{
                top:0;
                left:0;
                width:100%;
                height:100%;
                z-index:1042;
                overflow:hidden;
                position:fixed;
                background:#0b0b0b;
                opacity:.8
            }
            .mfp-wrap{
                top:0;
                left:0;
                width:100%;
                height:100%;
                z-index:1043;
                position:fixed;
                outline:none!important;
                -webkit-backface-visibility:hidden
            }
            .mfp-container{
                text-align:center;
                position:absolute;
                width:100%;
                height:100%;
                left:0;
                top:0;
                padding:0 8px;
                box-sizing:border-box
            }
            .mfp-container:before{
                content:'';
                display:inline-block;
                height:100%;
                vertical-align:middle
            }
            .mfp-align-top .mfp-container:before{
                display:none
            }
            .mfp-content{
                position:relative;
                display:inline-block;
                vertical-align:middle;
                margin:0 auto;
                text-align:left;
                z-index:1045
            }
            .mfp-inline-holder .mfp-content,.mfp-ajax-holder .mfp-content{
                width:100%;
                cursor:auto
            }
            .mfp-ajax-cur{
                cursor:progress
            }
            .mfp-zoom-out-cur,.mfp-zoom-out-cur .mfp-image-holder .mfp-close{
                cursor:-moz-zoom-out;
                cursor:-webkit-zoom-out;
                cursor:zoom-out
            }
            .mfp-zoom{
                cursor:pointer;
                cursor:-webkit-zoom-in;
                cursor:-moz-zoom-in;
                cursor:zoom-in
            }
            .mfp-auto-cursor .mfp-content{
                cursor:auto
            }
            .mfp-close,.mfp-arrow,.mfp-preloader,.mfp-counter{
                -webkit-user-select:none;
                -moz-user-select:none;
                user-select:none
            }
            .mfp-loading.mfp-figure{
                display:none
            }
            .mfp-hide{
                display:none!important
            }
            .mfp-preloader{
                color:#CCC;
                position:absolute;
                top:50%;
                width:auto;
                text-align:center;
                margin-top:-.8em;
                left:8px;
                right:8px;
                z-index:1044
            }
            .mfp-preloader a{
                color:#CCC
            }
            .mfp-preloader a:hover{
                color:#FFF
            }
            .mfp-s-ready .mfp-preloader{
                display:none
            }
            .mfp-s-error .mfp-content{
                display:none
            }
            button.mfp-close,button.mfp-arrow{
                overflow:visible;
                cursor:pointer;
                background:#fff0;
                border:0;
                -webkit-appearance:none;
                display:block;
                outline:none;
                padding:0;
                z-index:1046;
                box-shadow:none;
                touch-action:manipulation
            }
            button::-moz-focus-inner{
                padding:0;
                border:0
            }
            .mfp-close{
                width:44px;
                height:44px;
                line-height:44px;
                position:absolute;
                right:0;
                top:0;
                text-decoration:none;
                text-align:center;
                opacity:.65;
                padding:0 0 18px 10px;
                color:#FFF;
                font-style:normal;
                font-size:28px;
                font-family:Arial,Baskerville,monospace
            }
            .mfp-close:hover,.mfp-close:focus{
                opacity:1
            }
            .mfp-close:active{
                top:1px
            }
            .mfp-close-btn-in .mfp-close{
                color:#333
            }
            .mfp-image-holder .mfp-close,.mfp-iframe-holder .mfp-close{
                color:#FFF;
                right:-6px;
                text-align:right;
                padding-right:6px;
                width:100%
            }
            .mfp-counter{
                position:absolute;
                top:0;
                right:0;
                color:#CCC;
                font-size:12px;
                line-height:18px;
                white-space:nowrap
            }
            .mfp-arrow{
                position:absolute;
                opacity:.65;
                margin:0;
                top:50%;
                margin-top:-55px;
                padding:0;
                width:90px;
                height:110px;
                -webkit-tap-highlight-color:#fff0
            }
            .mfp-arrow:active{
                margin-top:-54px
            }
            .mfp-arrow:hover,.mfp-arrow:focus{
                opacity:1
            }
            .mfp-arrow:before,.mfp-arrow:after{
                content:'';
                display:block;
                width:0;
                height:0;
                position:absolute;
                left:0;
                top:0;
                margin-top:35px;
                margin-left:35px;
                border:medium inset #fff0
            }
            .mfp-arrow:after{
                border-top-width:13px;
                border-bottom-width:13px;
                top:8px
            }
            .mfp-arrow:before{
                border-top-width:21px;
                border-bottom-width:21px;
                opacity:.7
            }
            .mfp-arrow-left{
                left:0
            }
            .mfp-arrow-left:after{
                border-right:17px solid #FFF;
                margin-left:31px
            }
            .mfp-arrow-left:before{
                margin-left:25px;
                border-right:27px solid #3F3F3F
            }
            .mfp-arrow-right{
                right:0
            }
            .mfp-arrow-right:after{
                border-left:17px solid #FFF;
                margin-left:39px
            }
            .mfp-arrow-right:before{
                border-left:27px solid #3F3F3F
            }
            .mfp-iframe-holder{
                padding-top:40px;
                padding-bottom:40px
            }
            .mfp-iframe-holder .mfp-content{
                line-height:0;
                width:100%;
                max-width:900px
            }
            .mfp-iframe-holder .mfp-close{
                top:-40px
            }
            .mfp-iframe-scaler{
                width:100%;
                height:0;
                overflow:hidden;
                padding-top:56.25%
            }
            .mfp-iframe-scaler iframe{
                position:absolute;
                display:block;
                top:0;
                left:0;
                width:100%;
                height:100%;
                box-shadow:0 0 8px rgb(0 0 0 / .6);
                background:#000
            }
            img.mfp-img{
                width:auto;
                max-width:100%;
                height:auto;
                display:block;
                line-height:0;
                box-sizing:border-box;
                padding:40px 0 40px;
                margin:0 auto
            }
            .mfp-figure{
                line-height:0
            }
            .mfp-figure:after{
                content:'';
                position:absolute;
                left:0;
                top:40px;
                bottom:40px;
                display:block;
                right:0;
                width:auto;
                height:auto;
                z-index:-1;
                box-shadow:0 0 8px rgb(0 0 0 / .6);
                background:#444
            }
            .mfp-figure small{
                color:#BDBDBD;
                display:block;
                font-size:12px;
                line-height:14px
            }
            .mfp-figure figure{
                margin:0
            }
            .mfp-bottom-bar{
                margin-top:-36px;
                position:absolute;
                top:100%;
                left:0;
                width:100%;
                cursor:auto
            }
            .mfp-title{
                text-align:left;
                line-height:18px;
                color:#F3F3F3;
                word-wrap:break-word;
                padding-right:36px
            }
            .mfp-image-holder .mfp-content{
                max-width:100%
            }
            .mfp-gallery .mfp-image-holder .mfp-figure{
                cursor:pointer
            }
            @media screen and (max-width:800px) and (orientation:landscape),screen and (max-height:300px){
                .mfp-img-mobile .mfp-image-holder{
                    padding-left:0;
                    padding-right:0
                }
                .mfp-img-mobile img.mfp-img{
                    padding:0
                }
                .mfp-img-mobile .mfp-figure:after{
                    top:0;
                    bottom:0
                }
                .mfp-img-mobile .mfp-figure small{
                    display:inline;
                    margin-left:5px
                }
                .mfp-img-mobile .mfp-bottom-bar{
                    background:rgb(0 0 0 / .6);
                    bottom:0;
                    margin:0;
                    top:auto;
                    padding:3px 5px;
                    position:fixed;
                    box-sizing:border-box
                }
                .mfp-img-mobile .mfp-bottom-bar:empty{
                    padding:0
                }
                .mfp-img-mobile .mfp-counter{
                    right:5px;
                    top:3px
                }
                .mfp-img-mobile .mfp-close{
                    top:0;
                    right:0;
                    width:35px;
                    height:35px;
                    line-height:35px;
                    background:rgb(0 0 0 / .6);
                    position:fixed;
                    text-align:center;
                    padding:0
                }
            }
            @media all and (max-width:900px){
                .mfp-arrow{
                    -webkit-transform:scale(.75);
                    transform:scale(.75)
                }
                .mfp-arrow-left{
                    -webkit-transform-origin:0;
                    transform-origin:0
                }
                .mfp-arrow-right{
                    -webkit-transform-origin:100%;
                    transform-origin:100%
                }
                .mfp-container{
                    padding-left:6px;
                    padding-right:6px
                }
            }</style>
        <style class="optimize_css_2" type="text/css" media="all">/*! Generated by Font Squirrel (https://www.fontsquirrel.com) on June 9, 2021 */
            @font-face{
                font-family:'quentinregular';
                src:url(../wp-content/themes/homlisti/assets/fonts/quentin-webfont.woff2) format('woff2'),url(https://www.radiustheme.com/demo/wordpress/themes/homlisti/wp-content/themes/homlisti/assets/css/../fonts/quentin-webfont.woff) format('woff');
                font-weight:400;
                font-style:normal
            }</style>
        <link rel='stylesheet' id='rangeSlider-css' href='../wp-content/themes/homlisti/assets/css/ion.rangeSlider.min.css' type='text/css' media='all' />
        <style id='homlisti-dynamic-inline-css' type='text/css'>
            :root{
                --rt-body-font: 'Roboto', sans-serif;
                ;
                --rt-heading-font: 'Ubuntu', sans-serif;
                --rt-menu-font: 'Ubuntu', sans-serif;
            }
            body {
                font-family: 'Roboto', sans-serif;
                font-size: 16px;
                line-height: 30px;
                font-weight : normal;
                font-style: normal;
            }
            .header-menu, .header-menu .navigation-area nav {
                font-family: 'Ubuntu', sans-serif;
            }
            .navigation-area nav > ul > li > a {
                line-height: 20px;
                font-weight : normal;
            }
            .navigation-area nav.template-main-menu > ul > li > a {
                font-size: 16px;
            }
            .navigation-area nav > ul > li ul.sub-menu li a {
                font-size: 15px;
                line-height: 22px;
            }
            .rtcl h1, .rtcl h2, .rtcl h3, .rtcl h4, .rtcl h5, .rtcl h6, h1,h2,h3,h4,h5,h6 {
                font-family: 'Ubuntu', sans-serif;
                font-weight : 500;
                font-style: normal;
            }
            h1 {
                font-size: 32px;
                line-height: 42px;
            }
            h2 {
                font-size: 28px;
                line-height: 40px;
            }
            h3 {
                font-size: 22px;
                line-height: 32px;
            }
            h4 {
                font-size: 20px;
                line-height: 30px;
            }
            h5 {
                font-size: 18px;
                line-height: 28px;
            }
            h6 {
                font-size: 16px;
                line-height: 26px;
            }
            :root {
                --rt-primary-color: #00c194;
                --rt-primary-dark: #00a376;
                --rt-primary-light: #50ffe4;
                --rt-primary-light2: #dceeea;
                --rt-primary-light3: #EAF7F4;
                --rt-secondary-color: #07c196;
                --rt-primary-rgb: 0, 193, 148;
                --rt-secondary-rgb: 7, 193, 150;
            }
            .elementor-kit-2673 {
                --e-global-color-primary: #00c194;
                --e-global-color-secondary: #07c196;
                --e-global-color-accent: #00c194;
                --e-global-color-d22c469: #00a376;
                --e-global-color-4f65493: #dceeea;
                --e-global-color-2ab0c7b: #EAF7F4;
            }
            body {
                color: #686868;
            }
            a:active, .rtcl a:hover, a:hover, a:focus {
                color: #07c196;
            }
            .header-add-property-btn .item-btn{
                background-color: #00c194;
            }
            .header-add-property-btn .item-btn::after{
                background-color: #07c196;
            }
            .mean-container a.meanmenu-reveal span {
                background-color: #00c194;
            }
            .header-mobile-icons a.header-btn {
                background-color: #00c194;
            }
            .header-mobile-icons a.header-btn:hover {
                background-color: #07c196;
            }
            .mean-container .mean-nav ul li a.mean-expand, .mean-container a.meanmenu-reveal {
                color: #00c194;
            }
            .header-style-4 .header-add-property-btn .item-btn, .header-icon-round .header-action ul li.button a, .navigation-area nav > ul > li > a {
                color: #000000;
            }
            .navigation-area nav > ul > li ul.sub-menu li a {
                color: #3a3a3a;
            }
            .header-icon-round .header-action ul li.button a:hover, .navigation-area nav > ul > li ul.sub-menu li a:hover, .header-menu .navigation-area nav ul li.current-menu-item a, .header-menu .navigation-area nav > ul > li > a:hover {
                color: #00c194;
            }
            .header-icon-round .header-action ul li.button a i {
                color: #00c194;
            }
            .header-icon-round .header-action ul li.button a:hover .icon-round {
                background-color: #07c196;
                border-color: #07c196;
            }
            .trheader .header-icon-round .header-action ul li.button a:hover .icon-round {
                background-color: #00c194;
                border-color: #00c194;
            }
            .header-topbar .topbar-right .social-icon a:hover{
                color: #50ffe4;
            }
            .trheader .site-header::before {
                background: rgba(0,0,0,0);
                background: -webkit-linear-gradient(top, rgba(0,0,0,0) 0%, rgba(0, 0, 0, 0) 100%);
                background: linear-gradient(to bottom, rgba(0,0,0,0) 0%, rgba(0, 0, 0, 0) 100%);
            }
            .breadcrumbs-banner .rtcl-breadcrumb {
                color: #565656;
            }
            .breadcrumbs-banner h1 {
                color: #212121;
            }
            .breadcrumbs-banner .rtcl-breadcrumb a:hover, .breadcrumbs-banner .rtcl-breadcrumb span {
                color: #00c194;
            }
            .navigation-area nav > ul li.page_item_has_children > a:after, .navigation-area nav > ul li.menu-item-has-children > a:after {
                border-color: #000000;
            }
        </style>
        <link rel='stylesheet' id='wpo_min-header-0-css' href='../wp-content/cache/wpo-minify/1721845095/assets/wpo-minify-header-946543c6.min.css' type='text/css' media='all' />
        <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin><script type="text/javascript" src="../wp-includes/js/jquery/jquery.min.js" id="jquery-core-js"></script>
        <script type="text/javascript" id="wpo_min-header-0-js-extra">
            /* <![CDATA[ */
            var rtcl_compare = {"ajaxurl":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-admin\/admin-ajax.php", "server_error":"Server Error!!"};
            var rtcl_quick_view = {"ajaxurl":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-admin\/admin-ajax.php", "server_error":"Server Error!!", "selector":".rtcl-quick-view", "max_width":"1000", "wrap_class":"rtcl-qvw no-heading"};
            /* ]]> */
        </script>
        <script>
            var wpo_server_info_js = {"user_agent":"Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/126.0.0.0 Safari\/537.36 Edg\/126.0.0.0"}
            loadAsync('../wp-content/cache/wpo-minify/1721845095/assets/wpo-minify-header-ac1568fa.min.js', null);</script>
        <link rel="https://api.w.org/" href="../wp-json/index.php" /><link rel="alternate" title="JSON" type="application/json" href="../wp-json/wp/v2/pages/2308.json" /><link rel="EditURI" type="application/rsd+xml" title="RSD" href="../xmlrpc0db0.php?rsd" />
        <meta name="generator" content="WordPress 6.6.1" />
        <link rel="canonical" href="index.php" />
        <link rel='shortlink' href='../index1991.html?p=2308' />
        <link rel="alternate" title="oEmbed (JSON)" type="application/json+oembed" href="../wp-json/oembed/1.0/embed2e3f.json?url=https%3A%2F%2Fwww.radiustheme.com%2Fdemo%2Fwordpress%2Fthemes%2Fhomlisti%2Fcontact%2F" />
        <link rel="alternate" title="oEmbed (XML)" type="text/xml+oembed" href="../wp-json/oembed/1.0/embed75e4?url=https%3A%2F%2Fwww.radiustheme.com%2Fdemo%2Fwordpress%2Fthemes%2Fhomlisti%2Fcontact%2F&amp;format=xml" />
        <meta name="generator" content="Elementor 3.23.2; features: additional_custom_breakpoints, e_lazyload; settings: css_print_method-external, google_font-enabled, font_display-auto">

        <!-- This Google structured data (Rich Snippet) auto generated by RadiusTheme Review Schema plugin version 2.2.2 -->

        <style>
            .e-con.e-parent:nth-of-type(n+4):not(.e-lazyloaded):not(.e-no-lazyload),
            .e-con.e-parent:nth-of-type(n+4):not(.e-lazyloaded):not(.e-no-lazyload) * {
                background-image: none !important;
            }
            @media screen and (max-height: 1024px) {
                .e-con.e-parent:nth-of-type(n+3):not(.e-lazyloaded):not(.e-no-lazyload),
                .e-con.e-parent:nth-of-type(n+3):not(.e-lazyloaded):not(.e-no-lazyload) * {
                    background-image: none !important;
                }
            }
            @media screen and (max-height: 640px) {
                .e-con.e-parent:nth-of-type(n+2):not(.e-lazyloaded):not(.e-no-lazyload),
                .e-con.e-parent:nth-of-type(n+2):not(.e-lazyloaded):not(.e-no-lazyload) * {
                    background-image: none !important;
                }
            }
        </style>
        <link rel="icon" href="../wp-content/uploads/2021/09/cropped-favicon-homlisti-32x32.png" sizes="32x32" />
        <link rel="icon" href="../wp-content/uploads/2021/09/cropped-favicon-homlisti-192x192.png" sizes="192x192" />
        <link rel="apple-touch-icon" href="../wp-content/uploads/2021/09/cropped-favicon-homlisti-180x180.png" />
        <meta name="msapplication-TileImage" content="https://www.radiustheme.com/demo/wordpress/themes/homlisti/wp-content/uploads/2021/09/cropped-favicon-homlisti-270x270.png" />
        <style type="text/css" id="wp-custom-css">
            .rt-el-testimonial-carousel .slick-list {
                overflow: hidden;
            }		</style>
    </head>
    <body class="page-template page-template-templates page-template-blank page-template-templatesblank-php page page-id-2308 rtcl-no-js HomListi-version-1.10.4 theme-homlisti header-style-4 header-width-box-width sticky-header no-trheader homlisti-core-installed product-grid-view page-contact elementor-default elementor-kit-2673 elementor-page elementor-page-2308">
        <div id="preloader" style="background-image:url(../wp-content/themes/homlisti/assets/img/preloader.gif);"></div>	<div id="wrapper" class="wrapper">
            <a class="skip-link screen-reader-text" href="#content">Skip to content</a>
            <header id="site-header" class="site-header">
                <div id="rt-sticky-placeholder"></div>
                <div id="header-menu" class="header-menu menu-layout1 header-icon-round">
                    <div class="container">
                        <div class="header-content">

                            <div class="logo-area">
                                <div class="site-branding">
                                    <a class="custom-logo" href="../index.php">
                                        <img class="img-fluid" src="../wp-content/uploads/2023/02/logo.svg"
                                             width="148"
                                             height="39"
                                             alt="HomListi"
                                             >
                                    </a>
                                </div>
                            </div>          
                            <div id="main-navigation" class="navigation-area menu-center">
                                <nav id="dropdown" class="template-main-menu"><ul id="menu-main-navigation" class="menu"><li id="menu-item-4356" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4735"><a href="../index.php">Home</a>
                                            <!--                                            <ul class="sub-menu">
                                                                                            <li id="menu-item-4358" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home menu-item-4358"><a href="../index.php">Home 1</a></li>
                                                                                            <li id="menu-item-4359" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4359"><a href="../home-2/index.php">Home 2</a></li>
                                                                                            <li id="menu-item-4357" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4357"><a href="../home-3/index.php">Home 3</a></li>
                                                                                            <li id="menu-item-7904" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-7904"><a href="../home-4/index.php">Home 4</a></li>
                                                                                            <li id="menu-item-17181" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17181"><a href="../home-5/index.php">Home 5</a></li>
                                                                                            <li id="menu-item-18057" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-18057"><a href="../home-6/index.php">Home 6</a></li>
                                                                                        </ul>-->
                                        </li>
                                        <li id="menu-item-4132" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4735"><a href="../about/index.php" aria-current="page">About</a></li>
                                        <li id="menu-item-4386" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4735"><a href="../property/affordable-green-villa-house-for-rent/index.php">Property</a>
                                            <!--                                            <ul class="sub-menu">
                                                                                            <li id="menu-item-4387" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4387"><a href="#">Column 1</a>
                                                                                                <ul class="sub-menu">
                                                                                                    <li id="menu-item-9149" class="menu-item menu-item-type-post_type_archive menu-item-object-rtcl_listing menu-item-9149"><a href="../all-properties/index.php">Properties Grid</a></li>
                                                                                                    <li id="menu-item-15637" class="menu-item menu-item-type-post_type_archive menu-item-object-rtcl_listing menu-item-15637"><a href="../all-properties/indexd1fd.html?view=list">Properties List</a></li>
                                                                                                    <li id="menu-item-16046" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-16046"><a href="../listing-map/index.php">Properties Map Grid</a></li>
                                                                                                    <li id="menu-item-16047" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-16047"><a href="../listing-map/indexd1fd.html?view=list">Properties Map List</a></li>
                                                                                                </ul>
                                                                                            </li>
                                                                                            <li id="menu-item-4391" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4391"><a href="#">Column 2</a>
                                                                                                <ul class="sub-menu">
                                                                                                    <li id="menu-item-15640" class="menu-item menu-item-type-post_type_archive menu-item-object-rtcl_listing menu-item-15640"><a href="../all-properties/index128e.html?layout=fullwidth">Properties Fullwidth</a></li>
                                                                                                    <li id="menu-item-17444" class="menu-item menu-item-type-post_type menu-item-object-rtcl_listing menu-item-17444"><a href="../property/triple-story-house-for-rent/index.php">Single Property &#8211; Default</a></li>
                                                                                                    <li id="menu-item-17418" class="menu-item menu-item-type-post_type menu-item-object-rtcl_listing menu-item-17418"><a href="../property/affordable-green-villa-house-for-rent/index.php">Single Property &#8211; Fullwidth</a></li>
                                                                                                    <li id="menu-item-17445" class="menu-item menu-item-type-post_type menu-item-object-rtcl_listing menu-item-17445"><a href="../property/sky-pool-villa-house-for-sale/index.php">Single Property &#8211; Grid</a></li>
                                                                                                </ul>
                                                                                            </li>
                                                                                        </ul>-->
                                        </li>
                                        <!--                                        <li id="menu-item-4733" class="mega-menu mega-menu-col-2 menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4733"><a href="#">Pages</a>
                                                                                    <ul class="sub-menu">
                                                                                        <li id="menu-item-17272" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-17272"><a href="#">Column</a>
                                                                                            <ul class="sub-menu">
                                                                                                <li id="menu-item-15643" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-15643"><a href="../agencies/index.php">Agencies</a></li>
                                                                                                <li id="menu-item-17451" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17451"><a href="../agents/index.php">Agents</a></li>
                                                                                                <li id="menu-item-17452" class="menu-item menu-item-type-post_type menu-item-object-rtcl_agent menu-item-17452"><a href="../agent/rosy_janner/index.php">Agent Details</a></li>
                                                                                            </ul>
                                                                                        </li>
                                                                                        <li id="menu-item-17273" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-17273"><a href="#">Column</a>
                                                                                            <ul class="sub-menu">
                                                                                                <li id="menu-item-8071" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8071"><a href="../pricing-table/index.php">Pricing Table</a></li>
                                                                                                <li id="menu-item-4734" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4734"><a href="../error-404.html">404 Error</a></li>
                                                                                            </ul>
                                                                                        </li>
                                                                                    </ul>
                                                                                </li>-->
                                        <!--                                        <li id="menu-item-4736" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4736"><a href="#">Blog</a>
                                                                                    <ul class="sub-menu">
                                                                                        <li id="menu-item-4615" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4615"><a href="../blog/index.php">Blog List</a></li>
                                                                                        <li id="menu-item-8849" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8849"><a href="../blog-grid/index.php">Blog Grid</a></li>
                                                                                        <li id="menu-item-17271" class="menu-item menu-item-type-post_type menu-item-object-post menu-item-17271"><a href="../develop-relationships-with-human-resource/index.php">Blog Details</a></li>
                                                                                    </ul>
                                                                                </li>-->
                                        <li id="menu-item-4735" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-3941 current_page_item menu-item-4132"><a href="../contact/index.php">Contact</a></li>
                                    </ul></nav>            </div>

                            <div class="listing-area">
                                <div class="header-action">
                                    <ul class="header-btn">
                                        <!--
                                                                                <li class="compare-btn has-count-number button" style="">
                                                                                    <a class="item-btn"
                                                                                       data-toggle="tooltip"
                                                                                       data-placement="bottom"
                                                                                       title="Compare"
                                                                                       href="../compare/index.php">
                                                                                        <i class="flaticon-left-and-right-arrows icon-round"></i>
                                                                                        <span class="count rt-compare-count">0</span>
                                                                                    </a>
                                                                                </li>
                                        
                                                                                <li class="favourite has-count-number button" style="">
                                                                                    <a class="item-btn"
                                                                                       data-toggle="tooltip"
                                                                                       data-placement="bottom"
                                                                                       title="Favourites"
                                                                                       href="../my-account/favourites/index.php">
                                                                                        <i class="flaticon-heart icon-round"></i>
                                                                                        <span class="count rt-header-favourite-count">0</span>
                                                                                    </a>
                                                                                </li>-->

                                        <li class="login-btn button" style="">
                                            <a class="item-btn"
                                               data-toggle="tooltip"
                                               data-placement="bottom"
                                               <?php if (isset($_SESSION['loggedin'])) { ?>
                                                   title=" Profile"
                                                   href="../Profile.php">
                                                   <?php }else
                                                   {
                                                       echo 'title=" sign in"';
                                                   echo 'href="../my-account/index.php">';
                                                   }
                                                   ?>

                                                 
                                                <i class="flaticon-user-1 icon-round"></i>
                                            </a>
                                        </li>




                                        <li class="submit-btn header-add-property-btn" style="">
                                            <a href="../post-an-ad/index.php" class="item-btn rt-animation-btn">
                                                <span>
                                                    <i class="fas fa-plus-circle"></i>
                                                </span>
                                                <div class="btn-text">Add Property</div>
                                            </a>
                                        </li>

                                        <li class="offcanvar_bar button" style="order: 99">
                                            <span class="sidebarBtn ">
                                                <span class="fa fa-bars">
                                                </span>
                                            </span>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    </header>

            <div id="mobile-menu-sticky-placeholder"></div>
            <div class="rt-header-menu mean-container mobile-offscreen-menu header-icon-round" id="meanmenu">
                <div class="mean-bar">
                    <div class="mobile-logo ">
                        <a class="custom-logo site-main-logo" href="../index.php">
                            <img class="img-fluid" src="../wp-content/uploads/2023/02/logo.svg" width="148" height="39"
                                 alt="HomListi">
                        </a>
                    </div>


                    <div class="listing-area">
                        <div class="header-action">
                            <ul class="header-btn">

                                <li class="compare-btn has-count-number button" style="">
                                    <a class="item-btn"
                                       data-toggle="tooltip"
                                       data-placement="bottom"
                                       title="Compare"
                                       href="../compare/index.php">
                                        <i class="flaticon-left-and-right-arrows icon-round"></i>
                                        <span class="count rt-compare-count">0</span>
                                    </a>
                                </li>

                                <!--                                <li class="favourite has-count-number button" style="">
                                                                    <a class="item-btn"
                                                                       data-toggle="tooltip"
                                                                       data-placement="bottom"
                                                                       title="Favourites"
                                                                       href="../my-account/favourites/index.php">
                                                                        <i class="flaticon-heart icon-round"></i>
                                                                        <span class="count rt-header-favourite-count">0</span>
                                                                    </a>
                                                                </li>-->

                               <li class="login-btn button" style="">
                                            <a class="item-btn"
                                               data-toggle="tooltip"
                                               data-placement="bottom"
                                               <?php if (isset($_SESSION['loggedin'])) { ?>
                                                   title=" Profile"
                                                   href="../Profile.php">
                                                   <?php }else
                                                   {
                                                       echo 'title=" sign in"';
                                                   echo 'href="../my-account/index.php">';
                                                   }
                                                   ?>

                                                 
                                                <i class="flaticon-user-1 icon-round"></i>
                                            </a>
                                        </li>




                                <li class="submit-btn header-add-property-btn" style="">
                                    <a href="../post-an-ad/index.php" class="item-btn rt-animation-btn">
                                        <span>
                                            <i class="fas fa-plus-circle"></i>
                                        </span>
                                        <div class="btn-text">Add Property</div>
                                    </a>
                                </li>

                                <li class="offcanvar_bar button" style="order: 99">
                                    <span class="sidebarBtn ">
                                        <span class="fa fa-bars">
                                        </span>
                                    </span>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>

                <div class="rt-slide-nav">
                    <div class="offscreen-navigation">
                        <nav class="menu-main-navigation-container"><ul id="menu-main-navigation-1" class="menu"><li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4356"><a href="#">Home</a>
                                    <ul class="sub-menu">
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home menu-item-4358"><a href="../index.php">Home 1</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4359"><a href="../home-2/index.php">Home 2</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4357"><a href="../home-3/index.php">Home 3</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-7904"><a href="../home-4/index.php">Home 4</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17181"><a href="../home-5/index.php">Home 5</a></li>
                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-18057"><a href="../home-6/index.php">Home 6</a></li>
                                    </ul>
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4132"><a href="../about/index.php">About</a></li>
                                <li class="mega-menu mega-menu-col-2 menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4386"><a href="#">Property</a>
                                    <ul class="sub-menu">
                                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4387"><a href="#">Column 1</a>
                                            <ul class="sub-menu">
                                                <li class="menu-item menu-item-type-post_type_archive menu-item-object-rtcl_listing menu-item-9149"><a href="../all-properties/index.php">Properties Grid</a></li>
                                                <li class="menu-item menu-item-type-post_type_archive menu-item-object-rtcl_listing menu-item-15637"><a href="../all-properties/indexd1fd.html?view=list">Properties List</a></li>
                                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-16046"><a href="../listing-map/index.php">Properties Map Grid</a></li>
                                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-16047"><a href="../listing-map/indexd1fd.html?view=list">Properties Map List</a></li>
                                            </ul>
                                        </li>
                                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4391"><a href="#">Column 2</a>
                                            <ul class="sub-menu">
                                                <li class="menu-item menu-item-type-post_type_archive menu-item-object-rtcl_listing menu-item-15640"><a href="../all-properties/index128e.html?layout=fullwidth">Properties Fullwidth</a></li>
                                                <li class="menu-item menu-item-type-post_type menu-item-object-rtcl_listing menu-item-17444"><a href="../property/triple-story-house-for-rent/index.php">Single Property &#8211; Default</a></li>
                                                <li class="menu-item menu-item-type-post_type menu-item-object-rtcl_listing menu-item-17418"><a href="../property/affordable-green-villa-house-for-rent/index.php">Single Property &#8211; Fullwidth</a></li>
                                                <li class="menu-item menu-item-type-post_type menu-item-object-rtcl_listing menu-item-17445"><a href="../property/sky-pool-villa-house-for-sale/index.php">Single Property &#8211; Grid</a></li>
                                            </ul>
                                        </li>
                                    </ul>
                                </li>
                                <!--                                <li class="mega-menu mega-menu-col-2 menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4733"><a href="#">Pages</a>
                                                                    <ul class="sub-menu">
                                                                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-17272"><a href="#">Column</a>
                                                                            <ul class="sub-menu">
                                                                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-15643"><a href="../agencies/index.php">Agencies</a></li>
                                                                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17451"><a href="../agents/index.php">Agents</a></li>
                                                                                <li class="menu-item menu-item-type-post_type menu-item-object-rtcl_agent menu-item-17452"><a href="../agent/rosy_janner/index.php">Agent Details</a></li>
                                                                            </ul>
                                                                        </li>
                                                                        <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-17273"><a href="#">Column</a>
                                                                            <ul class="sub-menu">
                                                                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8071"><a href="../pricing-table/index.php">Pricing Table</a></li>
                                                                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4734"><a href="../error-404.html">404 Error</a></li>
                                                                            </ul>
                                                                        </li>
                                                                    </ul>
                                                                </li>
                                                                <li class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4736"><a href="#">Blog</a>
                                                                    <ul class="sub-menu">
                                                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4615"><a href="../blog/index.php">Blog List</a></li>
                                                                        <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8849"><a href="../blog-grid/index.php">Blog Grid</a></li>
                                                                        <li class="menu-item menu-item-type-post_type menu-item-object-post menu-item-17271"><a href="../develop-relationships-with-human-resource/index.php">Blog Details</a></li>
                                                                    </ul>
                                                                </li>-->
                                <li class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-2308 current_page_item menu-item-4735"><a href="index.php" aria-current="page">Contact</a></li>
                            </ul></nav>        </div>
                </div>
            </div>
            <div id="content" class="site-content">

                <section class="breadcrumbs-banner style-1">
                    <div class="container">
                        <nav class="rtcl-breadcrumb"><a href="../index.php">Home</a>&nbsp;<i class="fas fa-angle-right"></i>&nbsp;<span>Contact</span></nav>                </div>

                </section>
                <div id="primary" class="elementor-page-content">
                    <div data-elementor-type="wp-page" data-elementor-id="2308" class="elementor elementor-2308">
                        <section class="elementor-section elementor-top-section elementor-element elementor-element-f25a7df elementor-section-content-middle elementor-section-boxed elementor-section-height-default elementor-section-height-default rt-parallax-bg-no" data-id="f25a7df" data-element_type="section">
                            <div class="elementor-container elementor-column-gap-default">
                                <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-c599729" data-id="c599729" data-element_type="column">
                                    <div class="elementor-widget-wrap elementor-element-populated">
                                        <section class="elementor-section elementor-inner-section elementor-element elementor-element-b5dec91 elementor-section-boxed elementor-section-height-default elementor-section-height-default rt-parallax-bg-no" data-id="b5dec91" data-element_type="section">
                                            <div class="elementor-container elementor-column-gap-default">
                                                <div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-e1aa780" data-id="e1aa780" data-element_type="column">
                                                    <div class="elementor-widget-wrap elementor-element-populated">
                                                        <div class="elementor-element elementor-element-fba6d39 elementor-widget elementor-widget-rt-title" data-id="fba6d39" data-element_type="widget" data-widget_type="rt-title.default">
                                                            <div class="elementor-widget-container">
                                                                <div class="section-title-wrapper">

                                                                    <!--Background Title-->

                                                                    <div class="title-inner-wrapper">

                                                                        <!--Top Sub Title-->

                                                                        <!--Main Title-->
                                                                        <h2 class="main-title">Get in Touch</h2>

                                                                        <!--Description-->Hello from Admin , You can provide your  feed back related to our website
                                                                        <div class="description"><p></p></div>
                                                                    </div>
                                                                </div>		</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <section class="elementor-section elementor-inner-section elementor-element elementor-element-d9cb8d9 elementor-section-boxed elementor-section-height-default elementor-section-height-default rt-parallax-bg-no" data-id="d9cb8d9" data-element_type="section">
                                            <div class="elementor-container elementor-column-gap-default">
                                                <div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-804f5be" data-id="804f5be" data-element_type="column">
                                                    <div class="elementor-widget-wrap elementor-element-populated">
                                                        <div class="elementor-element elementor-element-2f3d44f elementor-widget elementor-widget-rt-info-box" data-id="2f3d44f" data-element_type="widget" data-widget_type="rt-info-box.default">
                                                            <div class="elementor-widget-container">

                                                                <div class="service3-box-right rt-info-box-wrap-1 rt-info-box icon-el-style-1">
                                                                    <div class="service-box">
                                                                        <div class="service3-icon-holder icon-holder   ">
                                                                            <i aria-hidden="true" class="fas fa-map-marker-alt"></i>		</div>

                                                                        <div class="service3-content-holder content-holder content-align">
                                                                            <h3 class="info-title">
                                                                                Location				</h3>

                                                                            <p>234-Uka Tarsadia University.</p>

                                                                        </div>
                                                                    </div>
                                                                </div>		</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <section class="elementor-section elementor-inner-section elementor-element elementor-element-831fd84 elementor-section-boxed elementor-section-height-default elementor-section-height-default rt-parallax-bg-no" data-id="831fd84" data-element_type="section">
                                            <div class="elementor-container elementor-column-gap-default">
                                                <div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-9a03cb3" data-id="9a03cb3" data-element_type="column">
                                                    <div class="elementor-widget-wrap elementor-element-populated">
                                                        <div class="elementor-element elementor-element-0ff8102 elementor-widget elementor-widget-rt-info-box" data-id="0ff8102" data-element_type="widget" data-widget_type="rt-info-box.default">
                                                            <div class="elementor-widget-container">

                                                                <div class="service3-box-right rt-info-box-wrap-1 rt-info-box icon-el-style-1">
                                                                    <div class="service-box">
                                                                        <div class="service3-icon-holder icon-holder   ">
                                                                            <i aria-hidden="true" class="fas fa-phone-alt"></i>		</div>

                                                                        <div class="service3-content-holder content-holder content-align">
                                                                            <h3 class="info-title">
                                                                                Emergency Call				</h3>

                                                                            <p>+91 9054254726</p>

                                                                        </div>
                                                                    </div>
                                                                </div>		</div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                        <section class="elementor-section elementor-inner-section elementor-element elementor-element-30c1269 elementor-section-boxed elementor-section-height-default elementor-section-height-default rt-parallax-bg-no" data-id="30c1269" data-element_type="section">
                                            <div class="elementor-container elementor-column-gap-default">
                                                <div class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-d93ec53" data-id="d93ec53" data-element_type="column">
                                                    <div class="elementor-widget-wrap elementor-element-populated">
                                                        <div class="elementor-element elementor-element-7c03052 elementor-widget elementor-widget-rt-info-box" data-id="7c03052" data-element_type="widget" data-widget_type="rt-info-box.default">
                                                            <div class="elementor-widget-container">

                                                                <div class="service3-box-right rt-info-box-wrap-1 rt-info-box icon-el-style-1">
                                                                    <div class="service-box">
                                                                        <div class="service3-icon-holder icon-holder   ">
                                                                            <i aria-hidden="true" class="fas fa-share-alt"></i>		</div>

                                                                        <div class="service3-content-holder content-holder content-align">
                                                                            <h3 class="info-title">
                                                                                Follow Us On				</h3>


                                                                        </div>
                                                                    </div>
                                                                </div>		</div>
                                                        </div>
                                                        <div class="elementor-element elementor-element-316fb9f elementor-shape-rounded elementor-grid-0 elementor-widget elementor-widget-social-icons" data-id="316fb9f" data-element_type="widget" data-widget_type="social-icons.default">
                                                            <div class="elementor-widget-container">
                                                                <div class="elementor-social-icons-wrapper elementor-grid">
                                                                    <span class="elementor-grid-item">
                                                                        <a class="elementor-icon elementor-social-icon elementor-social-icon-facebook-f elementor-repeater-item-024870d" href="#" target="_blank">
                                                                            <span class="elementor-screen-only">Facebook-f</span>
                                                                            <i class="fab fa-facebook-f"></i>					</a>
                                                                    </span>
                                                                    <span class="elementor-grid-item">
                                                                        <a class="elementor-icon elementor-social-icon elementor-social-icon-twitter elementor-repeater-item-06fbff7" href="#" target="_blank">
                                                                            <span class="elementor-screen-only">Twitter</span>
                                                                            <i class="fab fa-twitter"></i>					</a>
                                                                    </span>
                                                                    <span class="elementor-grid-item">
                                                                        <a class="elementor-icon elementor-social-icon elementor-social-icon-vimeo-v elementor-repeater-item-a6acf8e" href="#" target="_blank">
                                                                            <span class="elementor-screen-only">Vimeo-v</span>
                                                                            <i class="fab fa-vimeo-v"></i>					</a>
                                                                    </span>
                                                                    <span class="elementor-grid-item">
                                                                        <a class="elementor-icon elementor-social-icon elementor-social-icon-pinterest-p elementor-repeater-item-fb22e9a" href="#" target="_blank">
                                                                            <span class="elementor-screen-only">Pinterest-p</span>
                                                                            <i class="fab fa-pinterest-p"></i>					</a>
                                                                    </span>
                                                                    <span class="elementor-grid-item">
                                                                        <a class="elementor-icon elementor-social-icon elementor-social-icon-whatsapp elementor-repeater-item-29840e5" href="#" target="_blank">
                                                                            <span class="elementor-screen-only">Whatsapp</span>
                                                                            <i class="fab fa-whatsapp"></i>					</a>
                                                                    </span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </section>
                                    </div>
                                </div>
                                <div class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-57dbaf1" data-id="57dbaf1" data-element_type="column" data-settings="{&quot;background_background&quot;:&quot;classic&quot;}">
                                    <div class="elementor-widget-wrap elementor-element-populated">
                                        <div class="elementor-element elementor-element-3fb60ee elementor-widget elementor-widget-rt-title" data-id="3fb60ee" data-element_type="widget" data-widget_type="rt-title.default">
                                            <div class="elementor-widget-container">
                                                <div class="section-title-wrapper">

                                                    <!--Background Title-->

                                                    <div class="title-inner-wrapper">

                                                        <!--Top Sub Title-->

                                                        <!--Main Title-->
                                                        <h2 class="main-title">Quick Contact</h2>

                                                        <!--Description-->
                                                        <div class="description"><p>Hello from Admin , You can provide your  feed back related to our website</p></div>
                                                    </div>
                                                </div>		</div>
                                        </div>
                                      <form method="post" action="FEEDBACK_SEND.php">
    <div class="elementor-shortcode">
        <div class='fluentform ff-default fluentform_wrapper_1 ffs_default_wrap'>
            <fieldset style="border: none!important;margin: 0!important;padding: 0!important;background-color: transparent!important;box-shadow: none!important;outline: none!important; min-inline-size: 100%;">
                <legend class="ff_screen_reader_title" style="display: block; margin: 0!important;padding: 0!important;height: 0!important;text-indent: -999999px;width: 0!important;overflow:hidden;">Contact Form</legend>

                <?php if ($isLoggedIn): ?>
                    <!-- User ID (read-only) -->
                    <div class='ff-t-container ff-column-container ff_columns_total_2'>
                        <div class='ff-t-cell ff-t-column-1' style='flex-basis: 50%;'>
                            <div class='ff-el-group'>
                                <div class="ff-el-input--label ff-el-is-required asterisk-right">
                                    <label for='ff_1_names_first_name_' aria-label="UserId">UserID</label>
                                </div>
                                <div class='ff-el-input--content'>
                                    <input type="text" value="<?php echo htmlspecialchars($userId); ?>" readonly name="txtUserID" id="ff_1_names_first_name_" class="ff-el-form-control" aria-invalid="false" aria-required="true">
                                </div>
                            </div>
                        </div>

                        <!-- Type (dropdown) -->
                        <div class='ff-t-cell ff-t-column-2' style='flex-basis: 50%;'>
                            <div class='ff-el-group'>
                                <div class="ff-el-input--label ff-el-is-required asterisk-right">
                                    <label for='ff_1_phone' aria-label="Type">Type</label>
                                </div>
                                <div class='ff-el-input--content'>
                                    <select name="type" class="ff-el-form-control" id="ff_1_phone" aria-required="true">
                                        <option value="BUG REPORT">BUG REPORT</option>
                                        <option value="REQUEST">REQUEST</option>
                                        <option value="SUGGESTION">SUGGESTION</option>
                                        <option value="COMPLIMENT">COMPLIMENT</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Description (textarea) -->
                    <div class='ff-el-group'>
                        <div class="ff-el-input--label ff-el-is-required asterisk-right">
                            <label for='ff_1_description' aria-label="Comments">Comments</label>
                        </div>
                        <div class='ff-el-input--content'>
                            <textarea name="description" id="ff_1_description" class="ff-el-form-control" rows="5" cols="40" aria-required="true"></textarea>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class='ff-el-group ff-text-left ff_submit_btn_wrapper'>
                        <button type="submit" name="feedback" class="ff-btn ff-btn-submit ff-btn-lg ff_btn_style">Send Message</button>
                    </div>
                <?php else: ?>
                    <div class='ff-el-group ff-text-left'>
                        <p>Please log in to send a Feedback.</p>
                    </div>
                <?php endif; ?>
            </fieldset>
        </div>
    </div>
</form>
</fieldset></form><div id='fluentform_1_errors' class='ff-errors-in-stack ff_form_instance_1_1 ff-form-loading_errors ff_form_instance_1_1_errors'></div></div>        <script type="text/javascript">
                                                                    window.fluent_form_ff_form_instance_1_1 = {"id":"1", "settings":{"layout":{"labelPlacement":"top", "helpMessagePlacement":"with_label", "errorMessagePlacement":"inline", "asteriskPlacement":"asterisk-right"}, "restrictions":{"denyEmptySubmission":{"enabled":false}}}, "form_instance":"ff_form_instance_1_1", "form_id_selector":"fluentform_1", "rules":{"names[first_name]":{"required":{"value":true, "message":"This field is required"}}, "names[middle_name]":{"required":{"value":false, "message":"This field is required"}}, "names[last_name]":{"required":{"value":false, "message":"This field is required"}}, "phone":{"required":{"value":true, "message":"This field is required"}}, "description":{"required":{"value":true, "message":"This field is required"}}}, "conditionals":{"names":{"type":"any", "status":true, "conditions":[{"field":"", "value":"", "operator":""}]}}};
                                                    </script>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                        <section class="elementor-section elementor-top-section elementor-element elementor-element-4ea7ca8 elementor-section-content-middle elementor-section-boxed elementor-section-height-default elementor-section-height-default rt-parallax-bg-no" data-id="4ea7ca8" data-element_type="section">
                            <div class="elementor-container elementor-column-gap-default">
                                <div class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-07fa2a4 overflow-hidden" data-id="07fa2a4" data-element_type="column">
                                    <div class="elementor-widget-wrap elementor-element-populated">
                                        <div class="elementor-element elementor-element-a2a1a1d elementor-widget elementor-widget-html" data-id="a2a1a1d" data-element_type="widget" data-widget_type="html.default">
                                            <div class="elementor-widget-container">
                                                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d12655.07462189681!2d-99.16545225773281!3d19.43934071811698!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85d1f8cdc19e3477%3A0xe98bef6360302321!2sUVM%20Campus%20San%20Rafael!5e0!3m2!1sbn!2sbd!4v1625466586177!5m2!1sbn!2sbd" width="1450" height="800" style="border:0;" allowfullscreen="" loading="lazy"></iframe>		</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>
                </div>
            </div><!-- #content -->

            <footer id="site-footer" class="site-footer footer-wrap footer-style-2 is-border">
                <div class="main-footer" style="">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12"><div id="homlisti_about-2" class="footer-box widget_homlisti_about"><div class="footer-logo two"><a href="../index.php"><img src="../wp-content/uploads/2023/02/logo_light.svg" alt="Footer light Logo" width="148" height="39"></a></div>        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
                                    <ul class="footer-social">
                                        <li class="rtin-facebook"><a href="#" target="_blank"><i
                                                    class="fab fa-facebook-f"></i></a></li>                <li class="rtin-twitter"><a href="#" target="_blank"><i
                                                    class="fab fa-x-twitter"></i></a></li>                <li class="rtin-linkedin"><a href="#" target="_blank"><i
                                                    class="fab fa-linkedin-in"></i></a></li>                <li class="rtin-pinterest"><a href="#" target="_blank"><i
                                                    class="fab fa-pinterest-p"></i></a></li>                <li class="rtin-instagram"><a href="#" target="_blank"><i
                                                    class="fab fa-instagram"></i></a></li>        </ul>

                                </div></div><div class="col-lg-3 col-sm-6 col-12"><div id="nav_menu-3" class="footer-box widget_nav_menu"><h3 class="footer-title">Quick Links</h3><div class="menu-quick-links-container"><ul id="menu-quick-links" class="menu"><li id="menu-item-8593" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8593"><a href="../about/index.php">About Us</a></li>
                                            <li id="menu-item-15814" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-15814"><a href="../blog/index.php">Blog &#038; Articles</a></li>
                                            <li id="menu-item-15823" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-15823"><a href="../terms-and-conditions/index.php">Terms and Conditions</a></li>
                                            <li id="menu-item-16012" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-privacy-policy menu-item-16012"><a rel="privacy-policy" href="../privacy-policy/index.php">Privacy Policy</a></li>
                                            <li id="menu-item-8594" class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-2308 current_page_item menu-item-8594"><a href="index.php" aria-current="page">Contact Us</a></li>
                                        </ul></div></div></div><div class="col-lg-3 col-sm-6 col-12"><div id="mc4wp_form_widget-2" class="footer-box widget_mc4wp_form_widget"><h3 class="footer-title">Newsletter</h3><script>(function() {
                                            window.mc4wp = window.mc4wp || {
                                            listeners: [],
                                                    forms: {
                                                    on: function(evt, cb) {
                                                    window.mc4wp.listeners.push(
                                                    {
                                                    event   : evt,
                                                            callback: cb
                                                    }
                                                    );
                                                    }
                                                    }
                                            }
                                            })();</script><!-- Mailchimp for WordPress v4.9.14 - https://wordpress.org/plugins/mailchimp-for-wp/ --><form id="mc4wp-form-1" class="mc4wp-form mc4wp-form-7934" method="post" data-id="7934" data-name="Subscribe" ><div class="mc4wp-form-fields"><div class="rt-mailchimp-wrap">
                                                <input type="email" name="EMAIL" placeholder="Enter e-mail addess" required class="form-control"/>
                                                <div class="rt-animation-btn">
                                                    <input type="submit" value="Subscribe" />
                                                </div>
                                            </div></div><label style="display: none !important;">Leave this field empty if you're human: <input type="text" name="_mc4wp_honeypot" value="" tabindex="-1" autocomplete="off" /></label><input type="hidden" name="_mc4wp_timestamp" value="1721882085" /><input type="hidden" name="_mc4wp_form_id" value="7934" /><input type="hidden" name="_mc4wp_form_element_id" value="mc4wp-form-1" /><div class="mc4wp-response"></div></form><!-- / Mailchimp for WordPress Plugin --></div><div id="text-2" class="footer-box widget_text">			<div class="textwidget"><p>We never span you!</p>
                                    </div>
                                </div></div><div class="col-lg-3 col-sm-6 col-12"><div id="rt_contact_widget-5" class="footer-box widget_rt_contact_widget"><h3 class="footer-title">Contact</h3>        <div class="rt-contact-wrapper">
                                        <ul>
                                            <li>
                                                <i class="fas fa-map-marker-alt"></i>
                                                <p>121 King St, Melbourne den 3000, Australia</p>
                                            </li>

                                            <li>
                                                <i class="fas fa-envelope"></i>
                                                <p><a target="_blank" href="mailto:info@example.com">info@example.com</a></p>
                                            </li>

                                            <li>
                                                <i class="fas fa-phone-alt"></i>
                                                <p><a target="_blank" href="tel:+123-596-000">+123-596-000</a></p>
                                            </li>

                                        </ul>
                                    </div>
                                </div></div>                </div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <div class="container">
                        <div class="row">
                            <div class="col-xl-6 col-lg-8">
                                <div class="footer-bottom-menu">
                                    <div class="menu-footer-menu-container"><ul id="menu-footer-menu" class="footer-link"><li id="menu-item-15964" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-15964"><a href="../terms-and-conditions/index.php">Terms of Use</a></li>
                                            <li id="menu-item-8232" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-privacy-policy menu-item-8232"><a rel="privacy-policy" href="../privacy-policy/index.php">Privacy Policy</a></li>
                                        </ul></div>                            </div>
                            </div>
                            <div class="col-xl-6 col-lg-4 text-right">
                                <p class="footer-copyright">
                                    2022© All right reserved by RadiusTheme                        </p>
                            </div>
                        </div>
                    </div>
                </div>
            </footer></div><!-- #page -->
        <a href="#" class="scrollToTop" style=""><i class="fa fa-angle-double-up"></i></a><script>(function() {function maybePrefixUrlField () {
            const value = this.value.trim()
                    if (value !== '' && value.indexOf('http') !== 0) {
            this.value = 'http://' + value
            }
            }

            const urlFields = document.querySelectorAll('.mc4wp-form input[type="url"]')
                    for (let j = 0; j < urlFields.length; j++) {
            urlFields[j].addEventListener('blur', maybePrefixUrlField)
            }
            })();</script>			<script type='text/javascript'>
                const lazyloadRunObserver = () => {
                const lazyloadBackgrounds = document.querySelectorAll(`.e-con.e-parent:not(.e-lazyloaded)`);
                const lazyloadBackgroundObserver = new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                if (entry.isIntersecting) {
                let lazyloadBackground = entry.target;
                if (lazyloadBackground) {
                lazyloadBackground.classList.add('e-lazyloaded');
                }
                lazyloadBackgroundObserver.unobserve(entry.target);
                }
                });
                }, { rootMargin: '200px 0px 200px 0px' });
                lazyloadBackgrounds.forEach((lazyloadBackground) => {
                lazyloadBackgroundObserver.observe(lazyloadBackground);
                });
                };
                const events = [
                        'DOMContentLoaded',
                        'elementor/lazyload/observe',
                ];
                events.forEach((event) => {
                document.addEventListener(event, lazyloadRunObserver);
                });
        </script>
        <script type="text/javascript">
            var c = document.body.className;
            c = c.replace(/rtcl-no-js/, 'rtcl-js');
            document.body.className = c;
        </script>
        <style>form.fluent_form_1 .ff-btn-submit:not(.ff_btn_no_style) {
                background-color: #409EFF;
                color: #ffffff;
            }</style><script type="text/javascript" id="wpo_min-footer-0-js-extra">
                /* <![CDATA[ */
                var rtcl = {"plugin_url":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-content\/plugins\/classified-listing", "decimal_point":".", "i18n_required_rating_text":"Please select a rating", "i18n_decimal_error":"Please enter in decimal (.) format without thousand separators.", "i18n_mon_decimal_error":"Please enter in monetary decimal (.) format without thousand separators and currency symbols.", "is_rtl":"", "is_admin":"", "ajaxurl":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-admin\/admin-ajax.php", "confirm_text":"Are you sure?", "re_send_confirm_text":"Are you sure you want to re-send verification link?", "__rtcl_wpnonce":"3ffbd98edb", "rtcl_listing_base":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/all-properties\/", "rtcl_category":"", "rtcl_category_base":"listing-category", "category_text":"Category", "go_back":"Go back", "location_text":"Location", "rtcl_location":"", "rtcl_location_base":"listing-location", "user_login_alert_message":"Sorry, you need to login first.", "upload_limit_alert_message":"Sorry, you have only %d images pending.", "delete_label":"Delete Permanently", "proceed_to_payment_btn_label":"Proceed to payment", "finish_submission_btn_label":"Finish submission", "phone_number_placeholder":"XXX", "popup_search_widget_auto_form_submission":"1", "loading":"Loading ...", "is_listing":"0", "is_listings":"", "listing_term":"", "has_map":"1", "online_status_seconds":"300", "online_status_offline_text":"Offline Now", "online_status_online_text":"Online Now"};
                var rtclAjaxFilterObj = {"clear_all_filter":"Clear all filters", "no_result_found":"No result found.", "result_count":{"all":"Showing all % results", "part":"Showing _ of % results"}, "filter_scroll_offset":"50"};
                var fluentFormVars = {"ajaxUrl":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-admin\/admin-ajax.php", "forms":[], "step_text":"Step %activeStep% of %totalStep% - %stepTitle%", "is_rtl":"", "date_i18n":{"previousMonth":"Previous Month", "nextMonth":"Next Month", "months":{"shorthand":["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"], "longhand":["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"]}, "weekdays":{"longhand":["Sunday", "Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday"], "shorthand":["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"]}, "daysInMonth":[31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31], "rangeSeparator":" to ", "weekAbbreviation":"Wk", "scrollTitle":"Scroll to increment", "toggleTitle":"Click to toggle", "amPM":["AM", "PM"], "yearAriaLabel":"Year", "firstDayOfWeek":1}, "pro_version":"", "fluentform_version":"5.1.19", "force_init":"", "stepAnimationDuration":"350", "upload_completed_txt":"100% Completed", "upload_start_txt":"0% Completed", "uploading_txt":"Uploading", "choice_js_vars":{"noResultsText":"No results found", "loadingText":"Loading...", "noChoicesText":"No choices to choose from", "itemSelectText":"Press to select", "maxItemText":"Only %%maxItemCount%% options can be added"}, "input_mask_vars":{"clearIfNotMatch":false}};
                var rtcl_map = {"plugin_url":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-content\/plugins\/classified-listing", "location":"local", "center":{"address":"New York United States", "lat":"43.1561681", "lng":"-75.8449946"}, "zoom":{"default":17, "search":17}, "cluster_options":{"center":{"lat":0, "lng":0}, "max_zoom":18, "zoom":3, "scroll_wheel":false, "fit_bound":true}};
                var HomListiObj = {"ajaxUrl":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-admin\/admin-ajax.php", "appendHtml":"", "themeUrl":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-content\/themes\/homlisti", "lsSideOffset":"130", "rtStickySidebar":"enable", "rtMagnificPopup":"enable"};
                var rtcl_single_listing_localized_params = {"slider_options":{"rtl":false, "autoHeight":true}, "slider_enabled":"1", "zoom_enabled":"1", "photoswipe_enabled":"1", "photoswipe_options":{"shareEl":false, "closeOnScroll":false, "history":false, "hideAnimationDuration":0, "showAnimationDuration":0}, "zoom_options":[]};
                /* ]]> */
        </script>
        <script>
            var wpo_server_info_js = {"user_agent":"Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/126.0.0.0 Safari\/537.36 Edg\/126.0.0.0"}
            loadAsync('../wp-content/cache/wpo-minify/1721845095/assets/wpo-minify-footer-5cdccdc1.min.js', null);</script>
        <script>
            var wpo_server_info_js = {"user_agent":"Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/126.0.0.0 Safari\/537.36 Edg\/126.0.0.0"}
            loadAsync('../wp-content/cache/wpo-minify/1721845095/assets/wpo-minify-footer-75cf087f.min.js', null);
        </script>
        <script type="application/javascript">
            ;(function ($) {
            var emi_result = $('#mortgage-calculator .emi-text');
            var mortgage_form = $('#mortgage-calculator .mortgage-form');
            mortgage_form.on('submit', function (e) {
            e.preventDefault();
            var rt_amount = $(this).find('.rt_amount').val();
            var rt_deposit = $(this).find('.rt_deposit').val();
            var rt_year = $(this).find('.rt_year').val();
            var rt_rate = $(this).find('.rt_rate').val();

            //Mortgage Calculation
            var deposit = (rt_amount * rt_deposit) / 100;
            //Loan Amount
            var loan = rt_amount - deposit;
            // Interest Rate as Month
            var rate = rt_rate / (12 * 100);
            // Total Month
            var months = rt_year * 12;
            // Calculation
            var k = Math.pow(1 + rate, months);

            var value = Math.ceil(loan * rate * (k / (k - 1)));

            emi_result.html("<span>Monthly Payment " + value + "</span>");
            emi_result.slideDown(600);
            });


            $('.mortgage-calculator .form-group .reset-btn').on('click', function (e) {
            e.preventDefault();
            $(':input', '.mortgage-form')
            .not(':button, :submit, :reset, :hidden')
            .val('')
            .removeAttr('checked')
            .removeAttr('selected');

            $(".mortgage-calculator .emi-text span").remove();
            });

            })(jQuery);
        </script>
    </body>

    <!-- Mirrored from www.radiustheme.com/demo/wordpress/themes/homlisti/contact/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 25 Jul 2024 13:27:39 GMT -->
</html>
<!-- Cached by WP-Optimize - https://getwpo.com - Last modified: July 25, 2024 4:34 am (UTC:0) -->
