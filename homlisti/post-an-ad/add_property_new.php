<?php
session_start();

if (!isset($_SESSION['loggedin'])) {
    header("Location: /houserental-master/homlisti/my-account/index.php");
    exit();
}
include 'db_connection.php';

//if (!isset($_SESSION['email'])) {
//    header("Location: login.php");
//    exit();
//}


if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$uname = $_SESSION['email'];
$sql = "SELECT id FROM tbl_users WHERE email = '$uname'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $uid = $row['id'];  // Fetch user id
} else {
    echo "<script>alert('User not found!');</script>";
}

if (isset($_POST['btnsubmit'])) {
    $asql = "SELECT aadhar FROM tbl_users WHERE email = '$uname'";

    $ar = mysqli_query($conn, $asql);
    $res = mysqli_fetch_assoc($ar);
    if (!$res['aadhar'] > 0) {
        echo "<script>alert('Addhar is not updated please update Profile');</script>";
    } else {

        $cid = $_POST['cid'];
        $address = $_POST['address'];
        $rent = $_POST['rent'];
        $bedroom = $_POST['bedroom'];
        $bathroom = $_POST['bathroom'];
        $kitchen = $_POST['kitchen'];
        $floor = $_POST['floor'];
        $parking = $_POST['parking'];
        $description = $_POST['description'];
        $size = $_POST['size'];
        $SecurityDeposit=$_POST['SDEPOSIT'];

        if ($SecurityDeposit >= $rent) {
        echo "<script>alert('Security Deposit must be smaller than Rent.'); window.history.back();</script>";
        exit;
    }
        // File validation for document (only PDF allowed)
        $document = NULL;
        if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
            $documentType = mime_content_type($_FILES['document']['tmp_name']);
            if ($documentType == 'application/pdf') {
                $document = addslashes(file_get_contents($_FILES['document']['tmp_name']));
            } else {
                echo "<script>alert('Please upload only PDF files for the document.');</script>";
                
                die();
            }
        }

        // Insert property data
        $sql = "INSERT INTO property (cid, uid, adress, rent, bedroom, bathroom, kitchen, floor, parking, description, size, document,SecurityDeposit)
            VALUES ('$cid', '$uid', '$address', '$rent', '$bedroom', '$bathroom', '$kitchen', '$floor', '$parking', '$description', '$size', '$document','$SecurityDeposit')";

        if (mysqli_query($conn, $sql)) {
            $property_id = mysqli_insert_id($conn);

            // File validation for house images (only JPG, JPEG, PNG allowed)
            if (isset($_FILES['house_image']) && count($_FILES['house_image']['tmp_name']) > 0) {
                for ($i = 0; $i < count($_FILES['house_image']['tmp_name']); $i++) {
                    $imageType = mime_content_type($_FILES['house_image']['tmp_name'][$i]);
                    if ($imageType == 'image/jpeg' || $imageType == 'image/png') {
                        $house_image = addslashes(file_get_contents($_FILES['house_image']['tmp_name'][$i]));
                        $image_sql = "INSERT INTO tblimage (sid, pid, image) VALUES (NULL, '$property_id', '$house_image')";
                        mysqli_query($conn, $image_sql);
                    } else {
                        echo "<script>alert('Please upload only JPG, JPEG, or PNG images for house images.');</script>";
                        exit();
                    }
                }
            }

            echo "<script>alert('Property request is submitted wait for approval!');</script>";
        } else {
            echo "<script>alert('Error adding property. Please check your inputs or try again later.');</script>";
        }
    }
}



//if (isset($_POST['btnsubmit'])) {
//    $cid = $_POST['cid'];
//    $address = $_POST['address'];
//    $rent = $_POST['rent'];
//    $bedroom = $_POST['bedroom'];
//    $bathroom = $_POST['bathroom'];
//    $kitchen = $_POST['kitchen'];
//    $floor = $_POST['floor'];
//    $parking = $_POST['parking'];
//    $description = $_POST['description'];
//    $size = $_POST['size'];
//
//    $document = NULL;
//    if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
//        $document = addslashes(file_get_contents($_FILES['document']['tmp_name']));
//    }
//
//    $sql = "INSERT INTO property (cid, uid, adress, rent, bedroom, bathroom, kitchen, floor, parking, description, size, document) 
//        VALUES ('$cid', '$uid', '$address', '$rent', '$bedroom', '$bathroom', '$kitchen', '$floor', '$parking', '$description', '$size', '$document')";
//    if (isset($_POST['btnsubmit'])) {
//        if (mysqli_query($conn, $sql)) {
//            echo "New property added successfully!";
//        } else {
//            echo "Error: " . $sql . "<br>" . mysqli_error($conn);
//        }
//    }
//}
?>



<!--

<!DOCTYPE html>
<html lang="en-US">

     Mirrored from www.radiustheme.com/demo/wordpress/themes/homlisti/my-account/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 25 Jul 2024 13:27:50 GMT 
     Added by HTTrack <meta http-equiv="content-type" content="text/html;charset=UTF-8" /> /Added by HTTrack 
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="profile" href="https://gmpg.org/xfn/11" />
        <script>function loadAsync(e, t){var a, n = !1; a = document.createElement("script"), a.type = "text/javascript", a.src = e, a.onreadystatechange = function(){n || this.readyState && "complete" != this.readyState || (n = !0, "function" == typeof t && t())}, a.onload = a.onreadystatechange, document.getElementsByTagName("head")[0].appendChild(a)}</script>
        <title>My Account &#8211; HomListi</title>
        <meta name='robots' content='max-image-preview:large, noindex, follow' />
        <noscript><style>#preloader{
            display:none;
        }</style></noscript><link rel='dns-prefetch' href='http://fonts.googleapis.com/' />
        <link rel="alternate" type="application/rss+xml" title="HomListi &raquo; Feed" href="../feed/index.php" />
        <link rel="alternate" type="application/rss+xml" title="HomListi &raquo; Comments Feed" href="../comments/feed/index.php" />
        <script>
            var wpo_server_info_css = {"user_agent":"Mozilla\/4.5 (compatible; HTTrack 3.0x; Windows 98)"}
            var wpo_min71032d52 = document.createElement("link"); wpo_min71032d52.rel = "stylesheet", wpo_min71032d52.type = "text/css", wpo_min71032d52.media = "async", wpo_min71032d52.href = "../wp-content/themes/homlisti/assets/css/font-awesome.min.css", wpo_min71032d52.onload = function() {wpo_min71032d52.media = "all"}, document.getElementsByTagName("head")[0].appendChild(wpo_min71032d52);</script>
        <script>
            var wpo_server_info_css = {"user_agent":"Mozilla\/4.5 (compatible; HTTrack 3.0x; Windows 98)"}
            var wpo_min4ee42faa = document.createElement("link"); wpo_min4ee42faa.rel = "stylesheet", wpo_min4ee42faa.type = "text/css", wpo_min4ee42faa.media = "async", wpo_min4ee42faa.href = "https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,600;0,700&amp;family=Ubuntu:ital,wght@0,300;0,400;0,500;0,600;0,700&amp;display=swap", wpo_min4ee42faa.onload = function() {wpo_min4ee42faa.media = "all"}, document.getElementsByTagName("head")[0].appendChild(wpo_min4ee42faa);</script>
        <style id='wp-block-library-theme-inline-css' type='text/css'>
            .wp-block-audio :where(figcaption){
                color:#555;
                font-size:13px;
                text-align:center
            }
            .is-dark-theme .wp-block-audio :where(figcaption){
                color:#ffffffa6
            }
            .wp-block-audio{
                margin:0 0 1em
            }
            .wp-block-code{
                border:1px solid #ccc;
                border-radius:4px;
                font-family:Menlo,Consolas,monaco,monospace;
                padding:.8em 1em
            }
            .wp-block-embed :where(figcaption){
                color:#555;
                font-size:13px;
                text-align:center
            }
            .is-dark-theme .wp-block-embed :where(figcaption){
                color:#ffffffa6
            }
            .wp-block-embed{
                margin:0 0 1em
            }
            .blocks-gallery-caption{
                color:#555;
                font-size:13px;
                text-align:center
            }
            .is-dark-theme .blocks-gallery-caption{
                color:#ffffffa6
            }
            :root :where(.wp-block-image figcaption){
                color:#555;
                font-size:13px;
                text-align:center
            }
            .is-dark-theme :root :where(.wp-block-image figcaption){
                color:#ffffffa6
            }
            .wp-block-image{
                margin:0 0 1em
            }
            .wp-block-pullquote{
                border-bottom:4px solid;
                border-top:4px solid;
                color:currentColor;
                margin-bottom:1.75em
            }
            .wp-block-pullquote cite,.wp-block-pullquote footer,.wp-block-pullquote__citation{
                color:currentColor;
                font-size:.8125em;
                font-style:normal;
                text-transform:uppercase
            }
            .wp-block-quote{
                border-left:.25em solid;
                margin:0 0 1.75em;
                padding-left:1em
            }
            .wp-block-quote cite,.wp-block-quote footer{
                color:currentColor;
                font-size:.8125em;
                font-style:normal;
                position:relative
            }
            .wp-block-quote.has-text-align-right{
                border-left:none;
                border-right:.25em solid;
                padding-left:0;
                padding-right:1em
            }
            .wp-block-quote.has-text-align-center{
                border:none;
                padding-left:0
            }
            .wp-block-quote.is-large,.wp-block-quote.is-style-large,.wp-block-quote.is-style-plain{
                border:none
            }
            .wp-block-search .wp-block-search__label{
                font-weight:700
            }
            .wp-block-search__button{
                border:1px solid #ccc;
                padding:.375em .625em
            }
            :where(.wp-block-group.has-background){
                padding:1.25em 2.375em
            }
            .wp-block-separator.has-css-opacity{
                opacity:.4
            }
            .wp-block-separator{
                border:none;
                border-bottom:2px solid;
                margin-left:auto;
                margin-right:auto
            }
            .wp-block-separator.has-alpha-channel-opacity{
                opacity:1
            }
            .wp-block-separator:not(.is-style-wide):not(.is-style-dots){
                width:100px
            }
            .wp-block-separator.has-background:not(.is-style-dots){
                border-bottom:none;
                height:1px
            }
            .wp-block-separator.has-background:not(.is-style-wide):not(.is-style-dots){
                height:2px
            }
            .wp-block-table{
                margin:0 0 1em
            }
            .wp-block-table td,.wp-block-table th{
                word-break:normal
            }
            .wp-block-table :where(figcaption){
                color:#555;
                font-size:13px;
                text-align:center
            }
            .is-dark-theme .wp-block-table :where(figcaption){
                color:#ffffffa6
            }
            .wp-block-video :where(figcaption){
                color:#555;
                font-size:13px;
                text-align:center
            }
            .is-dark-theme .wp-block-video :where(figcaption){
                color:#ffffffa6
            }
            .wp-block-video{
                margin:0 0 1em
            }
            :root :where(.wp-block-template-part.has-background){
                margin-bottom:0;
                margin-top:0;
                padding:1.25em 2.375em
            }
        </style>
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
        <style class="optimize_css_2" type="text/css" media="all">@font-face{
            font-family:"flaticon";
            src:url(../wp-content/themes/homlisti/assets/fonts/flaticon.ttf#1721845095) format("truetype"),url(../index.phpwp-content/themes/homlisti/assets/css/../fonts/flaticon.woff#1721845095) format("woff"),url(../index.phpwp-content/themes/homlisti/assets/css/../fonts/flaticon.woff2#1721845095) format("woff2"),url(../index.phpwp-content/themes/homlisti/assets/css/../fonts/flaticon.eot#1721845095) format("embedded-opentype"),url(../index.phpwp-content/themes/homlisti/assets/css/../fonts/flaticon.svg?4c8541f813cac0753c62e0740c5ce069#flaticon) format("svg")
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
                src:url(../wp-content/themes/homlisti/assets/fonts/quentin-webfont.woff2) format('woff2'),url(../index.phpwp-content/themes/homlisti/assets/css/../fonts/quentin-webfont.woff) format('woff');
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
        <link rel='stylesheet' id='wpo_min-header-0-css' href='../wp-content/cache/wpo-minify/1721845095/assets/wpo-minify-header-17003f4d.min.css' type='text/css' media='all' />
        <script type="text/javascript" src="../wp-includes/js/jquery/jquery.min.js" id="jquery-core-js"></script>
        <script type="text/javascript" id="wpo_min-header-0-js-extra">
            /* <![CDATA[ */
            var rtcl_validator = {"messages":{"session_expired":"Session Expired!!", "server_error":"Server Error!!", "required":"This field is required.", "remote":"Please fix this field.", "email":"Please enter a valid email address.", "url":"Please enter a valid URL.", "date":"Please enter a valid date.", "dateISO":"Please enter a valid date (ISO).", "number":"Please enter a valid number.", "digits":"Please enter only digits.", "equalTo":"Please enter the same value again.", "maxlength":"Please enter no more than {0} characters.", "minlength":"Please enter at least {0} characters.", "rangelength":"Please enter a value between {0} and {1} characters long.", "range":"Please enter a value between {0} and {1}.", "pattern":"Invalid format.", "maxWords":"Please enter {0} words or less.", "minWords":"Please enter at least {0} words.", "rangeWords":"Please enter between {0} and {1} words.", "alphanumeric":"Letters, numbers, and underscores only please", "lettersonly":"Only alphabets and spaces are allowed.", "accept":"Please enter a value with a valid mimetype.", "max":"Please enter a value less than or equal to {0}.", "min":"Please enter a value greater than or equal to {0}.", "step":"Please enter a multiple of {0}.", "extension":"Please Select a value file with a valid extension.", "password":"Your password must be at least 6 characters long.", "greaterThan":"Max must be greater than min", "maxPrice":"Max price must be greater than regular price", "cc":{"number":"Please enter a valid credit card number.", "cvc":"Enter a valid cvc number.", "expiry":"Enter a valid expiry date", "incorrect_number":"Your card number is incorrect.", "abort":"A network error has occurred, and you have not been charged. Please try again."}}, "pwsL10n":{"unknown":"Password strength unknown", "short":"Very weak", "bad":"Weak", "good":"Medium", "strong":"Strong", "mismatch":"Mismatch"}, "scroll_top":"200", "pw_min_length":"6"};
            var rtcl_compare = {"ajaxurl":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-admin\/admin-ajax.php", "server_error":"Server Error!!"};
            var rtcl_quick_view = {"ajaxurl":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-admin\/admin-ajax.php", "server_error":"Server Error!!", "selector":".rtcl-quick-view", "max_width":"1000", "wrap_class":"rtcl-qvw no-heading"};
            /* ]]> */
        </script>
        <script>
            var wpo_server_info_js = {"user_agent":"Mozilla\/4.5 (compatible; HTTrack 3.0x; Windows 98)"}
            loadAsync('../wp-content/cache/wpo-minify/1721845095/assets/wpo-minify-header-422682a3.min.js', null);</script>
        <link rel="https://api.w.org/" href="../wp-json/index.php" /><link rel="alternate" title="JSON" type="application/json" href="../wp-json/wp/v2/pages/95.json" /><link rel="EditURI" type="application/rsd+xml" title="RSD" href="../xmlrpc0db0.php?rsd" />
        <meta name="generator" content="WordPress 6.6.1" />
        <link rel="canonical" href="index.php" />
        <link rel='shortlink' href='../index5eda.html?p=95' />
        <link rel="alternate" title="oEmbed (JSON)" type="application/json+oembed" href="../wp-json/oembed/1.0/embed56d6.json?url=https%3A%2F%2Fwww.radiustheme.com%2Fdemo%2Fwordpress%2Fthemes%2Fhomlisti%2Fmy-account%2F" />
        <link rel="alternate" title="oEmbed (XML)" type="text/xml+oembed" href="../wp-json/oembed/1.0/embedaac4?url=https%3A%2F%2Fwww.radiustheme.com%2Fdemo%2Fwordpress%2Fthemes%2Fhomlisti%2Fmy-account%2F&amp;format=xml" />
        <meta name="generator" content="Elementor 3.23.2; features: additional_custom_breakpoints, e_lazyload; settings: css_print_method-external, google_font-enabled, font_display-auto">

         This Google structured data (Rich Snippet) auto generated by RadiusTheme Review Schema plugin version 2.2.2 

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
        <meta name="msapplication-TileImage" content="../index.phpwp-content/uploads/2021/09/cropped-favicon-homlisti-270x270.png" />
        <style type="text/css" id="wp-custom-css">
            .rt-el-testimonial-carousel .slick-list {
                overflow: hidden;
            }		</style>
         <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 1000px; /* Increased width for better field alignment */
            margin: 60px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        h2 {
            text-align: center;
            font-size: 24px;
            color: #333;
            margin-bottom: 30px;
            letter-spacing: 1px;
        }

        label {
            font-weight: bold;
            margin-top: 10px;
            color: #333;
        }

        input[type="text"],
        input[type="number"],
        textarea,
        select,
        input[type="file"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            transition: border-color 0.3s ease;
            box-sizing: border-box;
        }

        input[type="text"]:focus,
        input[type="number"]:focus,
        textarea:focus,
        select:focus,
        input[type="file"]:focus {
            border-color: #4CAF50;
            outline: none;
        }

        input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            padding: 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            letter-spacing: 1px;
            transition: background-color 0.3s ease;
            width: 100%;
            animation: popIn 0.5s ease-in-out;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        /* Flexbox to align form groups in rows of 4 */
        .form-group {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 20px; /* Spacing between fields */
        }

        .form-group > div {
            flex: 1 1 23%; /* Four fields in a row */
        }

        textarea {
            width: 100%; /* Ensure textarea takes full width */
        }

        @keyframes popIn {
            0% {
                transform: scale(0.9);
            }
            100% {
                transform: scale(1);
            }
        }

        /* Additional Hover Effect */
        input[type="submit"]:hover {
            background-color: #66bb6a;
            transition: background-color 0.2s ease-in-out;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .fade-in {
            opacity: 0;
            animation: fadeEffect 1.5s forwards;
        }

        @keyframes fadeEffect {
            0% {
                opacity: 0;
            }
            100% {
                opacity: 1;
            }
        }
    </style>
    </head>
    <body class="page-template-default page page-id-95 rtcl-account rtcl-page rtcl-no-js HomListi-version-1.10.4 theme-homlisti header-style-4 header-width-box-width sticky-header no-trheader homlisti-core-installed product-grid-view page-my-account elementor-default elementor-kit-2673">
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
                            </div>            <div id="main-navigation" class="navigation-area menu-center">
                                <nav id="dropdown" class="template-main-menu"><ul id="menu-main-navigation" class="menu"><li id="menu-item-4356" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4356"><a href="../NEWDashboard.php">Home</a>
                                            <ul class="sub-menu">
                                                <li id="menu-item-4358" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home menu-item-4358"><a href="../index.php">Home 1</a></li>
                                                <li id="menu-item-4359" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4359"><a href="../home-2/index.php">Home 2</a></li>
                                                <li id="menu-item-4357" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4357"><a href="../home-3/index.php">Home 3</a></li>
                                                <li id="menu-item-7904" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-7904"><a href="../home-4/index.php">Home 4</a></li>
                                                <li id="menu-item-17181" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17181"><a href="../home-5/index.php">Home 5</a></li>
                                                <li id="menu-item-18057" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-18057"><a href="../home-6/index.php">Home 6</a></li>
                                            </ul>
                                        </li>
                                        <li id="menu-item-4132" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4132"><a href="../about/index.php">About</a></li>
                                        <li id="menu-item-4386" class="mega-menu mega-menu-col-2 menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4386"><a href="#">Property</a>
                                            <ul class="sub-menu">
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
                                            </ul>
                                        </li>
                                        <li id="menu-item-4733" class="mega-menu mega-menu-col-2 menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4733"><a href="#">Pages</a>
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
                                        </li>
                                        <li id="menu-item-4736" class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4736"><a href="#">Blog</a>
                                            <ul class="sub-menu">
                                                <li id="menu-item-4615" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4615"><a href="../blog/index.php">Blog List</a></li>
                                                <li id="menu-item-8849" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8849"><a href="../blog-grid/index.php">Blog Grid</a></li>
                                                <li id="menu-item-17271" class="menu-item menu-item-type-post_type menu-item-object-post menu-item-17271"><a href="../develop-relationships-with-human-resource/index.php">Blog Details</a></li>
                                            </ul>
                                        </li>
                                        <li id="menu-item-4735" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4735"><a href="../contact/index.php">Contact</a></li>
                                    </ul></nav>            </div>

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

                                        <li class="favourite has-count-number button" style="">
                                            <a class="item-btn"
                                               data-toggle="tooltip"
                                               data-placement="bottom"
                                               title="Favourites"
                                               href="favourites/index.php">
                                                <i class="flaticon-heart icon-round"></i>
                                                <span class="count rt-header-favourite-count">0</span>
                                            </a>
                                        </li>

                                        <li class="login-btn button" style="">
                                            <a class="item-btn"
                                               data-toggle="tooltip"
                                               data-placement="bottom"
                                               title=" Sign in"
                                               href="index.php">
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

                                <li class="favourite has-count-number button" style="">
                                    <a class="item-btn"
                                       data-toggle="tooltip"
                                       data-placement="bottom"
                                       title="Favourites"
                                       href="favourites/index.php">
                                        <i class="flaticon-heart icon-round"></i>
                                        <span class="count rt-header-favourite-count">0</span>
                                    </a>
                                </li>

                                <li class="login-btn button" style="">
                                    <a class="item-btn"
                                       data-toggle="tooltip"
                                       data-placement="bottom"
                                       title=" Sign in"
                                       href="index.php">
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
                                <li class="mega-menu mega-menu-col-2 menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4733"><a href="#">Pages</a>
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
                                </li>
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4735"><a href="../contact/index.php">Contact</a></li>
                            </ul></nav>        </div>
                </div>
            </div>
            <div id="content" class="site-content">

                <section class="breadcrumbs-banner style-1">
                    <div class="container">
                        <nav class="rtcl-breadcrumb"><a href="https://www.radiustheme.com/demo/wordpress/themes/homlisti">Home</a>&nbsp;<i class="fas fa-angle-right"></i>&nbsp;<span>My Account</span></nav>                </div>

                </section>
                <main class="site-main content-area ptb-100 homlisti-myaccount">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-12 col-sm-12 col-12">
                                <div class="page-content-block">
                                    <div class="main-content">
                                        <div class="clearfix">
                                            <div id="post-95" class="post-95 page type-page status-publish">
                                                <div class="rtcl">
                                                    <div id="rtcl-user-login-wrapper" class="separate-registration-form">


                                                        <div class="rtcl-login-form-wrap">
                                                            <h2>Login</h2>
                                                            <form id="rtcl-login-form" class="form-horizontal" method="post" action="">
                                                                <div class="rtcl-form-group">
                                                                    <label for="rtcl-user-login" class="rtcl-field-label">
                                                                         E-mail                    <strong class="rtcl-required">*</strong>
                                                                    </label>
                                                                    <input type="text" name="email" autocomplete="username"
                                                                           value=""
                                                                           id="rtcl-user-login" class="rtcl-form-control" required/>
                                                                </div>

                                                                <div class="rtcl-form-group">
                                                                    <label for="rtcl-user-pass" class="rtcl-field-label">
                                                                        Password                    <strong class="rtcl-required">*</strong>
                                                                    </label>
                                                                    <input type="password" name="password" id="rtcl-user-pass" autocomplete="current-password"
                                                                           class="rtcl-form-control" required/>
                                                                </div>


                                                                <div class="rtcl-form-group">
                                                                    <div id="rtcl-login-g-recaptcha"></div>
                                                                    <div id="rtcl-login-g-recaptcha-message"></div>
                                                                </div>

                                                                <div class="rtcl-form-group rtcl-login-form-submit-wrap">

                                                                    <button type="submit" name="login" class="btn" value="login">
                                                                        Login                </button>
                                                                    <div class="form-check">
                                                                        <input type="checkbox" name="rememberme" id="rtcl-rememberme" value="forever">
                                                                        <label class="form-check-label" for="rtcl-rememberme">
                                                                            Remember Me                    </label>
                                                                    </div>
                                                                </div>
                                                                <div class="rtcl-form-group rtcl-form-group-no-margin-bottom">
                                                                    <p class="rtcl-forgot-password">
                                                                        <a href="lost-pass/index.php">Forgot your password?</a>
                                                                         <p>If you don't have an account, <a href="registration.php">register here</a></p>
                                                                    </p>
                                                                </div>
                                                                <input type="hidden" id="rtcl-login-nonce" name="rtcl-login-nonce" value="cf52537014" /><input type="hidden" name="_wp_http_referer" value="/demo/wordpress/themes/homlisti/my-account/" /><input type="hidden" name="redirect_to" value="index.php" />        </form>
                                                        </div>
                                                         
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="page-pagination">
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div> #content 
<div class="container fade-in">
        <h2>Property Entry Form</h2>
        <form action="property_page.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                 Category and Address 
                <div>
                    <label for="category">Category:</label>
                    <select name="cid" id="category" required>
                        <option value="">Select Category</option>
<?php
//                        $conn = mysqli_connect("localhost", "root", "", "house_rental");
//
//                        if (!$conn) {
//                            die("Connection failed: " . mysqli_connect_error());
//                        }
//
//                        $sql = "SELECT id, cname FROM tblcategory";
//                        $result = mysqli_query($conn, $sql);
//
//                        while ($row = mysqli_fetch_assoc($result)) {
//                            echo "<option value='" . $row['id'] . "'>" . $row['cname'] . "</option>";
//                        }
//
//                        mysqli_close($conn);
?>
                    </select>
                </div>

                <div>
                    <label for="address">Address:</label>
                    <input type="text" id="address" name="address" maxlength="255" required>
                </div>

                 Rent 
                <div>
                    <label for="rent">Rent:</label>
                    <input type="number" step="0.01" id="rent" name="rent" placeholder="Rent" required>
                </div>

                 Bedrooms 
                <div>
                    <label for="bedroom">Bedrooms:</label>
                    <input type="number" id="bedroom" name="bedroom" placeholder="Bedrooms" required>
                </div>

                 Bathrooms 
                <div>
                    <label for="bathroom">Bathrooms:</label>
                    <input type="number" id="bathroom" name="bathroom" placeholder="Bathrooms" required>
                </div>

                 Kitchen 
                <div>
                    <label for="kitchen">Kitchen:</label>
                    <input type="number" id="kitchen" name="kitchen" placeholder="Kitchen" required>
                </div>

                 Floor 
                <div>
                    <label for="floor">Floor:</label>
                    <input type="number" id="floor" name="floor" placeholder="Floor" required>
                </div>

                 Parking 
                <div>
                    <label for="parking">Parking:</label>
                    <input type="number" min="0" max="1" id="parking" name="parking" placeholder="Parking (0 or 1)" required>
                </div>

                 Property Size 
                <div>
                    <label for="size">Property Size (in square feet):</label>
                    <input type="number" step="0.01" id="size" name="size" placeholder="Size">
                </div>

                 Description 
                <div style="flex: 1 1 100%;">
                    <label for="description">Description:</label>
                    <textarea id="description" name="description" rows="3"></textarea>
                </div>

                 Upload Document 
                <div>
                    <label for="document">Upload Document:</label>
                    <input type="file" id="document" name="document" required>
                </div>

                 Upload House Image 
                <div>
                    <label for="house_image">Upload House Image:</label>
                    <input type="file" id="house_image" name="house_image" required>
                </div>
            </div>

             Submit Button 
            <input type="submit" name="btnsubmit" value="Submit">
        </form>
    </div>

            <footer id="site-footer" class="site-footer footer-wrap footer-style-1 is-border">
                <div class="main-footer">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-3 col-sm-6 col-12"><div id="homlisti_about-2" class="footer-box widget_homlisti_about"><div class="footer-logo one"><a href="../index.php"><img src="../wp-content/uploads/2023/02/logo.svg" alt="Footer main Logo" width="148" height="39"></a></div>        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
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
                                            <li id="menu-item-8594" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8594"><a href="../contact/index.php">Contact Us</a></li>
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
                                            })();</script> Mailchimp for WordPress v4.9.14 - https://wordpress.org/plugins/mailchimp-for-wp/ <form id="mc4wp-form-1" class="mc4wp-form mc4wp-form-7934" method="post" data-id="7934" data-name="Subscribe" ><div class="mc4wp-form-fields"><div class="rt-mailchimp-wrap">
                                                <input type="email" name="EMAIL" placeholder="Enter e-mail addess" required class="form-control"/>
                                                <div class="rt-animation-btn">
                                                    <input type="submit" value="Subscribe" />
                                                </div>
                                            </div></div><label style="display: none !important;">Leave this field empty if you're human: <input type="text" name="_mc4wp_honeypot" value="" tabindex="-1" autocomplete="off" /></label><input type="hidden" name="_mc4wp_timestamp" value="1721913716" /><input type="hidden" name="_mc4wp_form_id" value="7934" /><input type="hidden" name="_mc4wp_form_element_id" value="mc4wp-form-1" /><div class="mc4wp-response"></div></form> / Mailchimp for WordPress Plugin </div><div id="text-2" class="footer-box widget_text">			<div class="textwidget"><p>We never span you!</p>
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
            </footer></div> #page 
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
        <script type="text/javascript" id="wpo_min-footer-0-js-extra">
            /* <![CDATA[ */
            var rtcl = {"plugin_url":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-content\/plugins\/classified-listing", "decimal_point":".", "i18n_required_rating_text":"Please select a rating", "i18n_decimal_error":"Please enter in decimal (.) format without thousand separators.", "i18n_mon_decimal_error":"Please enter in monetary decimal (.) format without thousand separators and currency symbols.", "is_rtl":"", "is_admin":"", "ajaxurl":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-admin\/admin-ajax.php", "confirm_text":"Are you sure?", "re_send_confirm_text":"Are you sure you want to re-send verification link?", "__rtcl_wpnonce":"affb6d8463", "rtcl_listing_base":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/all-properties\/", "rtcl_category":"", "rtcl_category_base":"listing-category", "category_text":"Category", "go_back":"Go back", "location_text":"Location", "rtcl_location":"", "rtcl_location_base":"listing-location", "user_login_alert_message":"Sorry, you need to login first.", "upload_limit_alert_message":"Sorry, you have only %d images pending.", "delete_label":"Delete Permanently", "proceed_to_payment_btn_label":"Proceed to payment", "finish_submission_btn_label":"Finish submission", "phone_number_placeholder":"XXX", "popup_search_widget_auto_form_submission":"1", "loading":"Loading ...", "is_listing":"0", "is_listings":"", "listing_term":"", "has_map":"1", "online_status_seconds":"300", "online_status_offline_text":"Offline Now", "online_status_online_text":"Online Now"};
            var rtclAjaxFilterObj = {"clear_all_filter":"Clear all filters", "no_result_found":"No result found.", "result_count":{"all":"Showing all % results", "part":"Showing _ of % results"}, "filter_scroll_offset":"50"};
            var rtcl_store = {"store_time_options":{"icons":{"up":"rtcl-icon-up-open", "down":"rtcl-icon-down-open"}}, "ajaxurl":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-admin\/admin-ajax.php", "confirm_text":"Are You sure?", "__rtcl_wpnonce":"affb6d8463", "max_image_size":"3145728", "store_id":"0", "image_allowed_type":["png", "jpg", "jpeg"], "error_common":"Error while upload image", "error_image_size":"Image size is more then 3 MB.", "error_image_extension":"File extension not supported.", "server_error":"Server Error.", "lng":{"error":"Error while processing data"}};
            var rtcl_map = {"plugin_url":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-content\/plugins\/classified-listing", "location":"local", "center":{"address":"New York United States", "lat":"43.1561681", "lng":"-75.8449946"}, "zoom":{"default":17, "search":17}, "cluster_options":{"center":{"lat":0, "lng":0}, "max_zoom":18, "zoom":3, "scroll_wheel":false, "fit_bound":true}};
            var HomListiObj = {"ajaxUrl":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-admin\/admin-ajax.php", "appendHtml":"", "themeUrl":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-content\/themes\/homlisti", "lsSideOffset":"130", "rtStickySidebar":"enable", "rtMagnificPopup":"enable"};
            var rtcl_single_listing_localized_params = {"slider_options":{"rtl":false, "autoHeight":true}, "slider_enabled":"1", "zoom_enabled":"1", "photoswipe_enabled":"1", "photoswipe_options":{"shareEl":false, "closeOnScroll":false, "history":false, "hideAnimationDuration":0, "showAnimationDuration":0}, "zoom_options":[]};
            /* ]]> */
        </script>
        <script>
            var wpo_server_info_js = {"user_agent":"Mozilla\/4.5 (compatible; HTTrack 3.0x; Windows 98)"}
            loadAsync('../wp-content/cache/wpo-minify/1721845095/assets/wpo-minify-footer-f329a969.min.js', null);
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

     Mirrored from www.radiustheme.com/demo/wordpress/themes/homlisti/my-account/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 25 Jul 2024 13:27:52 GMT 
</html>
 WP Optimize page cache - https://getwpo.com - Page not served from cache  -->
<?php
//session_start();
//
//if (isset($_SESSION['loggedin'])) {
//    header("Location: /houserental-master/homlisti/NEWDashboard.php");
//    exit();
//}
//
//header("Cache-Control: no-cache, no-store, must-revalidate");
//header("Pragma: no-cache");
//header("Expires: 0");
//
//$message = '';
//
//$c = mysqli_connect('localhost', 'root', '', 'house_rental');
//
//if (!$c) {
//    die("Connection failed: " . mysqli_connect_error());
//}
//
//if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
//    $email = $_POST['email'];
//    $password = $_POST['password'];
//
//    $query = "SELECT password,fname FROM tbl_users WHERE email = '$email'";
//    $nameQuery="select fname from tbl_users where email='$email'";
//  
//    $result = mysqli_query($c, $query);
//    
//    if ($result && mysqli_num_rows($result) > 0) {
//        $row = mysqli_fetch_assoc($result);
//        $stored_password = $row['password'];
//        $_SESSION['name']=$row['fname'];
//        if (password_verify($password, $stored_password)) {
//            $_SESSION['loggedin'] = true;
//            $_SESSION['email'] = $email; 
//            header("Location: /houserental-master/homlisti/NEWDashboard.php"); 
//            exit();
//        } else {
//            echo '<script>alert("Invalid email or password.")</script>';
//        }
//    } else {
//      echo '<script>alert("Invalid email or password.")</script>';
//    }
//}
//
//mysqli_close($c);
//
?>
<!DOCTYPE html>
<html lang="en-US">

    <!-- Mirrored from www.radiustheme.com/demo/wordpress/themes/homlisti/my-account/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 25 Jul 2024 13:27:50 GMT -->
    <!-- Added by HTTrack --><meta http-equiv="content-type" content="text/html;charset=UTF-8" /><!-- /Added by HTTrack -->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="profile" href="https://gmpg.org/xfn/11" />
        <script>function loadAsync(e, t){var a, n = !1; a = document.createElement("script"), a.type = "text/javascript", a.src = e, a.onreadystatechange = function(){n || this.readyState && "complete" != this.readyState || (n = !0, "function" == typeof t && t())}, a.onload = a.onreadystatechange, document.getElementsByTagName("head")[0].appendChild(a)}</script>
        <title>My Account &#8211; HomListi</title>
        <meta name='robots' content='max-image-preview:large, noindex, follow' />
        <noscript><style>#preloader{
                display:none;
            }</style></noscript><link rel='dns-prefetch' href='http://fonts.googleapis.com/' />
        <link rel="alternate" type="application/rss+xml" title="HomListi &raquo; Feed" href="../feed/index.php" />
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

        <link rel="alternate" type="application/rss+xml" title="HomListi &raquo; Comments Feed" href="../comments/feed/index.php" />
        <script>
            var wpo_server_info_css = {"user_agent":"Mozilla\/4.5 (compatible; HTTrack 3.0x; Windows 98)"}
            var wpo_min71032d52 = document.createElement("link"); wpo_min71032d52.rel = "stylesheet", wpo_min71032d52.type = "text/css", wpo_min71032d52.media = "async", wpo_min71032d52.href = "../wp-content/themes/homlisti/assets/css/font-awesome.min.css", wpo_min71032d52.onload = function() {wpo_min71032d52.media = "all"}, document.getElementsByTagName("head")[0].appendChild(wpo_min71032d52);</script>
        <script>
            var wpo_server_info_css = {"user_agent":"Mozilla\/4.5 (compatible; HTTrack 3.0x; Windows 98)"}
            var wpo_min4ee42faa = document.createElement("link"); wpo_min4ee42faa.rel = "stylesheet", wpo_min4ee42faa.type = "text/css", wpo_min4ee42faa.media = "async", wpo_min4ee42faa.href = "https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,600;0,700&amp;family=Ubuntu:ital,wght@0,300;0,400;0,500;0,600;0,700&amp;display=swap", wpo_min4ee42faa.onload = function() {wpo_min4ee42faa.media = "all"}, document.getElementsByTagName("head")[0].appendChild(wpo_min4ee42faa);</script>
        <style id='wp-block-library-theme-inline-css' type='text/css'>
            .form-group {
                margin-bottom: 20px;
            }

            h2 {
                font-size: 24px;
                font-weight: bold;
                margin-bottom: 20px;
            }

            input[type="submit"] {
                padding: 10px 20px;
            }

            .wp-block-audio :where(figcaption){
                color:#555;
                font-size:13px;
                text-align:center
            }
            .is-dark-theme .wp-block-audio :where(figcaption){
                color:#ffffffa6
            }
            .wp-block-audio{
                margin:0 0 1em
            }
            .wp-block-code{
                border:1px solid #ccc;
                border-radius:4px;
                font-family:Menlo,Consolas,monaco,monospace;
                padding:.8em 1em
            }
            .wp-block-embed :where(figcaption){
                color:#555;
                font-size:13px;
                text-align:center
            }
            .is-dark-theme .wp-block-embed :where(figcaption){
                color:#ffffffa6
            }
            .wp-block-embed{
                margin:0 0 1em
            }
            .blocks-gallery-caption{
                color:#555;
                font-size:13px;
                text-align:center
            }
            .is-dark-theme .blocks-gallery-caption{
                color:#ffffffa6
            }
            :root :where(.wp-block-image figcaption){
                color:#555;
                font-size:13px;
                text-align:center
            }
            .is-dark-theme :root :where(.wp-block-image figcaption){
                color:#ffffffa6
            }
            .wp-block-image{
                margin:0 0 1em
            }
            .wp-block-pullquote{
                border-bottom:4px solid;
                border-top:4px solid;
                color:currentColor;
                margin-bottom:1.75em
            }
            .wp-block-pullquote cite,.wp-block-pullquote footer,.wp-block-pullquote__citation{
                color:currentColor;
                font-size:.8125em;
                font-style:normal;
                text-transform:uppercase
            }
            .wp-block-quote{
                border-left:.25em solid;
                margin:0 0 1.75em;
                padding-left:1em
            }
            .wp-block-quote cite,.wp-block-quote footer{
                color:currentColor;
                font-size:.8125em;
                font-style:normal;
                position:relative
            }
            .wp-block-quote.has-text-align-right{
                border-left:none;
                border-right:.25em solid;
                padding-left:0;
                padding-right:1em
            }
            .wp-block-quote.has-text-align-center{
                border:none;
                padding-left:0
            }
            .wp-block-quote.is-large,.wp-block-quote.is-style-large,.wp-block-quote.is-style-plain{
                border:none
            }
            .wp-block-search .wp-block-search__label{
                font-weight:700
            }
            .wp-block-search__button{
                border:1px solid #ccc;
                padding:.375em .625em
            }
            :where(.wp-block-group.has-background){
                padding:1.25em 2.375em
            }
            .wp-block-separator.has-css-opacity{
                opacity:.4
            }
            .wp-block-separator{
                border:none;
                border-bottom:2px solid;
                margin-left:auto;
                margin-right:auto
            }
            .wp-block-separator.has-alpha-channel-opacity{
                opacity:1
            }
            .wp-block-separator:not(.is-style-wide):not(.is-style-dots){
                width:100px
            }
            .wp-block-separator.has-background:not(.is-style-dots){
                border-bottom:none;
                height:1px
            }
            .wp-block-separator.has-background:not(.is-style-wide):not(.is-style-dots){
                height:2px
            }
            .wp-block-table{
                margin:0 0 1em
            }
            .wp-block-table td,.wp-block-table th{
                word-break:normal
            }
            .wp-block-table :where(figcaption){
                color:#555;
                font-size:13px;
                text-align:center
            }
            .is-dark-theme .wp-block-table :where(figcaption){
                color:#ffffffa6
            }
            .wp-block-video :where(figcaption){
                color:#555;
                font-size:13px;
                text-align:center
            }
            .is-dark-theme .wp-block-video :where(figcaption){
                color:#ffffffa6
            }
            .wp-block-video{
                margin:0 0 1em
            }
            :root :where(.wp-block-template-part.has-background){
                margin-bottom:0;
                margin-top:0;
                padding:1.25em 2.375em
            }
        </style>
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
        <style class="optimize_css_2" type="text/css" media="all">@font-face{
                font-family:"flaticon";
                src:url(../wp-content/themes/homlisti/assets/fonts/flaticon.ttf#1721845095) format("truetype"),url(../index.phpwp-content/themes/homlisti/assets/css/../fonts/flaticon.woff#1721845095) format("woff"),url(../index.phpwp-content/themes/homlisti/assets/css/../fonts/flaticon.woff2#1721845095) format("woff2"),url(../index.phpwp-content/themes/homlisti/assets/css/../fonts/flaticon.eot#1721845095) format("embedded-opentype"),url(../index.phpwp-content/themes/homlisti/assets/css/../fonts/flaticon.svg?4c8541f813cac0753c62e0740c5ce069#flaticon) format("svg")
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
                src:url(../wp-content/themes/homlisti/assets/fonts/quentin-webfont.woff2) format('woff2'),url(../index.phpwp-content/themes/homlisti/assets/css/../fonts/quentin-webfont.woff) format('woff');
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
        <style>
input[type=number]::-webkit-inner-spin-button,
input[type=number]::-webkit-outer-spin-button {
    -webkit-appearance: none;
    margin: 0;
}

input[type=number] {
    -moz-appearance: textfield;
}
            /* Center the form and expand its width */
            .container.fade-in {
                max-width: 1200px; /* Increased width to 100% container */
                width: 100%;
                margin: 0 auto;
            }

            /* Form inputs padding */
            .form-group {
                margin-bottom: 20px;
            }

            /* Label and input styles */
            label {
                font-weight: bold;
            }

            .form-control {
                width: 100%;
                padding: 10px;
                font-size: 1rem;
            }
            .form-select:focus {
                border-color: #28a745; /* Green border on focus */
                box-shadow: 0 0 0 0.25rem rgba(40, 167, 69, 0.25); /* Green shadow */
            }

            /* Button Styling */
            input[type="submit"] {
                padding: 12px 40px;
                font-size: 18px;
            }

            /* Align text center for headings */
            .text-center {
                text-align: center;
            }

        </style>
        <link rel='stylesheet' id='wpo_min-header-0-css' href='../wp-content/cache/wpo-minify/1721845095/assets/wpo-minify-header-17003f4d.min.css' type='text/css' media='all' />
        <script type="text/javascript" src="../wp-includes/js/jquery/jquery.min.js" id="jquery-core-js"></script>
        <script type="text/javascript" id="wpo_min-header-0-js-extra">
            /* <![CDATA[ */
            var rtcl_validator = {"messages":{"session_expired":"Session Expired!!", "server_error":"Server Error!!", "required":"This field is required.", "remote":"Please fix this field.", "email":"Please enter a valid email address.", "url":"Please enter a valid URL.", "date":"Please enter a valid date.", "dateISO":"Please enter a valid date (ISO).", "number":"Please enter a valid number.", "digits":"Please enter only digits.", "equalTo":"Please enter the same value again.", "maxlength":"Please enter no more than {0} characters.", "minlength":"Please enter at least {0} characters.", "rangelength":"Please enter a value between {0} and {1} characters long.", "range":"Please enter a value between {0} and {1}.", "pattern":"Invalid format.", "maxWords":"Please enter {0} words or less.", "minWords":"Please enter at least {0} words.", "rangeWords":"Please enter between {0} and {1} words.", "alphanumeric":"Letters, numbers, and underscores only please", "lettersonly":"Only alphabets and spaces are allowed.", "accept":"Please enter a value with a valid mimetype.", "max":"Please enter a value less than or equal to {0}.", "min":"Please enter a value greater than or equal to {0}.", "step":"Please enter a multiple of {0}.", "extension":"Please Select a value file with a valid extension.", "password":"Your password must be at least 6 characters long.", "greaterThan":"Max must be greater than min", "maxPrice":"Max price must be greater than regular price", "cc":{"number":"Please enter a valid credit card number.", "cvc":"Enter a valid cvc number.", "expiry":"Enter a valid expiry date", "incorrect_number":"Your card number is incorrect.", "abort":"A network error has occurred, and you have not been charged. Please try again."}}, "pwsL10n":{"unknown":"Password strength unknown", "short":"Very weak", "bad":"Weak", "good":"Medium", "strong":"Strong", "mismatch":"Mismatch"}, "scroll_top":"200", "pw_min_length":"6"};
            var rtcl_compare = {"ajaxurl":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-admin\/admin-ajax.php", "server_error":"Server Error!!"};
            var rtcl_quick_view = {"ajaxurl":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-admin\/admin-ajax.php", "server_error":"Server Error!!", "selector":".rtcl-quick-view", "max_width":"1000", "wrap_class":"rtcl-qvw no-heading"};
            /* ]]> */
        </script>
        <script>
            var wpo_server_info_js = {"user_agent":"Mozilla\/4.5 (compatible; HTTrack 3.0x; Windows 98)"}
            loadAsync('../wp-content/cache/wpo-minify/1721845095/assets/wpo-minify-header-422682a3.min.js', null);</script>
        <link rel="https://api.w.org/" href="../wp-json/index.php" /><link rel="alternate" title="JSON" type="application/json" href="../wp-json/wp/v2/pages/95.json" /><link rel="EditURI" type="application/rsd+xml" title="RSD" href="../xmlrpc0db0.php?rsd" />
        <meta name="generator" content="WordPress 6.6.1" />
        <link rel="canonical" href="index.php" />
        <link rel='shortlink' href='../index5eda.html?p=95' />
        <link rel="alternate" title="oEmbed (JSON)" type="application/json+oembed" href="../wp-json/oembed/1.0/embed56d6.json?url=https%3A%2F%2Fwww.radiustheme.com%2Fdemo%2Fwordpress%2Fthemes%2Fhomlisti%2Fmy-account%2F" />
        <link rel="alternate" title="oEmbed (XML)" type="text/xml+oembed" href="../wp-json/oembed/1.0/embedaac4?url=https%3A%2F%2Fwww.radiustheme.com%2Fdemo%2Fwordpress%2Fthemes%2Fhomlisti%2Fmy-account%2F&amp;format=xml" />
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
        <meta name="msapplication-TileImage" content="../index.phpwp-content/uploads/2021/09/cropped-favicon-homlisti-270x270.png" />
        <style type="text/css" id="wp-custom-css">
            .rt-el-testimonial-carousel .slick-list {
                overflow: hidden;
            }		</style>
    </head>
    <body class="page-template-default page page-id-95 rtcl-account rtcl-page rtcl-no-js HomListi-version-1.10.4 theme-homlisti header-style-4 header-width-box-width sticky-header no-trheader homlisti-core-installed product-grid-view page-my-account elementor-default elementor-kit-2673">
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
                                        <li id="menu-item-4735" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4735"><a href="../contact/index.php">Contact</a></li>
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
                                        -->
                                        <!--                                        <li class="favourite has-count-number button" style="">
                                                                                    <a class="item-btn"
                                                                                       data-toggle="tooltip"
                                                                                       data-placement="bottom"
                                                                                       title="Favourites"
                                                                                       href="favourites/index.php">
                                                                                        <i class="flaticon-heart icon-round"></i>
                                                                                        <span class="count rt-header-favourite-count">0</span>
                                                                                    </a>
                                                                                </li>-->

                                        <li class="login-btn button" style="">
                                            <a class="item-btn"
                                               data-toggle="tooltip"
                                               data-placement="bottom"
                                               title=" Profile"
                                               href="../Profile.php">
                                                <i class="flaticon-user-1 icon-round"></i>
                                            </a>
                                        </li>



                                        <!--                                        <li class="submit-btn header-add-property-btn" style="">
                                                                                    <a href="../post-an-ad/index.php" class="item-btn rt-animation-btn">
                                                                                        <span>
                                                                                            <i class="fas fa-plus-circle"></i>
                                                                                        </span>
                                                                                        <div class="btn-text">Add Property</div>
                                                                                    </a>
                                                                                </li>-->

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
                                                                </li>-->
                                <!--
                                                                <li class="favourite has-count-number button" style="">
                                                                    <a class="item-btn"
                                                                       data-toggle="tooltip"
                                                                       data-placement="bottom"
                                                                       title="Favourites"
                                                                       href="favourites/index.php">
                                                                        <i class="flaticon-heart icon-round"></i>
                                                                        <span class="count rt-header-favourite-count">0</span>
                                                                    </a>
                                                                </li>-->

                                <li class="login-btn button" style="">
                                    <a class="item-btn"
                                       data-toggle="tooltip"
                                       data-placement="bottom"
                                       title=" Sign in"
                                       href="index.php">
                                        <i class="flaticon-user-1 icon-round"></i>
                                    </a>
                                </li>



                                <!--                                <li class="submit-btn header-add-property-btn" style="">
                                                                    <a href="../post-an-ad/index.php" class="item-btn rt-animation-btn">
                                                                        <span>
                                                                            <i class="fas fa-plus-circle"></i>
                                                                        </span>
                                                                        <div class="btn-text">Add Property</div>
                                                                    </a>
                                                                </li>-->

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
                                <li class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4735"><a href="../contact/index.php">Contact</a></li>
                            </ul></nav>        </div>
                </div>
            </div>
            <div id="content" class="site-content">

                <section class="breadcrumbs-banner style-1">
                    <div class="container">
                        <nav class="rtcl-breadcrumb"><a href="https://www.radiustheme.com/demo/wordpress/themes/homlisti">Home</a>&nbsp;<i class="fas fa-angle-right"></i>&nbsp;<span>My Account</span></nav>                </div>

                </section>
                <main class="site-main content-area ptb-100 homlisti-myaccount">
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-8">
                                <div class="card shadow-sm">
                                    <div class="card-body">
                                        <h2 class="text-center mb-4">Property Entry Form</h2>
                                        <form method="POST" enctype="multipart/form-data">
                                            <div class="row mb-3">
                                                <div class="col-md-6 mb-3">
                                                    <label for="category" class="form-label">Category:</label>
                                                    <select class="form-control" name="cid" id="category" required>
                                                        <option value="" disabled selected>Select Category</option>
                                                        <?php
                                                        $conn = mysqli_connect("localhost", "root", "", "house_rental");
                                                        if (!$conn) {
                                                            die("Connection failed: " . mysqli_connect_error());
                                                        }
                                                        $sql = "SELECT id, cname FROM tblcategory";
                                                        $result = mysqli_query($conn, $sql);
                                                        while ($row = mysqli_fetch_assoc($result)) {
                                                            echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['cname']) . "</option>";
                                                        }
                                                        mysqli_close($conn);
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="address" class="form-label">Address:</label>
                                                    <input type="text" class="form-control" id="address" name="address" maxlength="255" required>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="rent" class="form-label">Rent:</label>
                                                    <input type="number" step="0.01" class="form-control" id="rent" name="rent" placeholder="Rent" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="bedroom" class="form-label">Bedrooms:</label>
                                                    <input type="number" class="form-control" id="bedroom" name="bedroom" placeholder="Bedrooms" required>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="bathroom" class="form-label">Bathrooms:</label>
                                                    <input type="number" class="form-control" id="bathroom" name="bathroom" placeholder="Bathrooms" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="kitchen" class="form-label">Kitchen:</label>
                                                    <input type="number" class="form-control" id="kitchen" name="kitchen" placeholder="Kitchen" required>
                                                </div>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="floor" class="form-label">Floor:</label>
                                                    <input type="number" class="form-control" id="floor" name="floor" placeholder="Floor" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="parking" class="form-label">Parking:</label>
                                                    <input type="number" min="0" max="1" class="form-control" id="parking" name="parking" placeholder="Parking (0 or 1)" required>
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="size" class="form-label">Property Size (in square feet):</label>
                                                <input type="number" step="0.01" class="form-control" id="size" name="size" placeholder="Size" required>
                                            </div>
                                             
                                            <div class="mb-3">
                                                <label for="SDEPOSIT" class="form-label">Security Deposit:</label>
                                                <input type="number" class="form-control" id="SDEPOSIT" name="SDEPOSIT" placeholder="Security Deposit" required>
                                            </div>
                                            
                                            <div class="mb-3">
                                                <label for="description" class="form-label">Description:</label>
                                                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
                                            </div>

                                            <div class="row mb-3">
                                                <div class="col-md-6">
                                                    <label for="document" class="form-label">Upload Document:</label>
                                                    <input type="file" class="form-control" id="document" name="document" required>
                                                </div>
                                                <div class="col-md-6">
                                                    <label for="house_image" class="form-label">Upload House Image:</label>
                                                    <input type="file" class="form-control" id="house_image" name="house_image[]" required multiple>
                                                </div>
                                            </div>

                                            <div class="text-center">
                                                <input type="submit" class="btn btn-success btn-lg" name="btnsubmit" value="Submit">
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>

                <!-- Ensure Bootstrap CSS is included -->
                <link href="https://stackpath.bootstrapcdn.com/bootstrap/5.1.3/css/bootstrap.min.css" rel="stylesheet">




                <footer id="site-footer" class="site-footer footer-wrap footer-style-1 is-border">
                    <div class="main-footer">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-3 col-sm-6 col-12"><div id="homlisti_about-2" class="footer-box widget_homlisti_about"><div class="footer-logo one"><a href="../index.php"><img src="../wp-content/uploads/2023/02/logo.svg" alt="Footer main Logo" width="148" height="39"></a></div>        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam</p>
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
                                                <li id="menu-item-8594" class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8594"><a href="../contact/index.php">Contact Us</a></li>
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
                                                </div></div><label style="display: none !important;">Leave this field empty if you're human: <input type="text" name="_mc4wp_honeypot" value="" tabindex="-1" autocomplete="off" /></label><input type="hidden" name="_mc4wp_timestamp" value="1721913716" /><input type="hidden" name="_mc4wp_form_id" value="7934" /><input type="hidden" name="_mc4wp_form_element_id" value="mc4wp-form-1" /><div class="mc4wp-response"></div></form><!-- / Mailchimp for WordPress Plugin --></div><div id="text-2" class="footer-box widget_text">			<div class="textwidget"><p>We never span you!</p>
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
            <script type="text/javascript" id="wpo_min-footer-0-js-extra">
                /* <![CDATA[ */
                var rtcl = {"plugin_url":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-content\/plugins\/classified-listing", "decimal_point":".", "i18n_required_rating_text":"Please select a rating", "i18n_decimal_error":"Please enter in decimal (.) format without thousand separators.", "i18n_mon_decimal_error":"Please enter in monetary decimal (.) format without thousand separators and currency symbols.", "is_rtl":"", "is_admin":"", "ajaxurl":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-admin\/admin-ajax.php", "confirm_text":"Are you sure?", "re_send_confirm_text":"Are you sure you want to re-send verification link?", "__rtcl_wpnonce":"affb6d8463", "rtcl_listing_base":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/all-properties\/", "rtcl_category":"", "rtcl_category_base":"listing-category", "category_text":"Category", "go_back":"Go back", "location_text":"Location", "rtcl_location":"", "rtcl_location_base":"listing-location", "user_login_alert_message":"Sorry, you need to login first.", "upload_limit_alert_message":"Sorry, you have only %d images pending.", "delete_label":"Delete Permanently", "proceed_to_payment_btn_label":"Proceed to payment", "finish_submission_btn_label":"Finish submission", "phone_number_placeholder":"XXX", "popup_search_widget_auto_form_submission":"1", "loading":"Loading ...", "is_listing":"0", "is_listings":"", "listing_term":"", "has_map":"1", "online_status_seconds":"300", "online_status_offline_text":"Offline Now", "online_status_online_text":"Online Now"};
                var rtclAjaxFilterObj = {"clear_all_filter":"Clear all filters", "no_result_found":"No result found.", "result_count":{"all":"Showing all % results", "part":"Showing _ of % results"}, "filter_scroll_offset":"50"};
                var rtcl_store = {"store_time_options":{"icons":{"up":"rtcl-icon-up-open", "down":"rtcl-icon-down-open"}}, "ajaxurl":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-admin\/admin-ajax.php", "confirm_text":"Are You sure?", "__rtcl_wpnonce":"affb6d8463", "max_image_size":"3145728", "store_id":"0", "image_allowed_type":["png", "jpg", "jpeg"], "error_common":"Error while upload image", "error_image_size":"Image size is more then 3 MB.", "error_image_extension":"File extension not supported.", "server_error":"Server Error.", "lng":{"error":"Error while processing data"}};
                var rtcl_map = {"plugin_url":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-content\/plugins\/classified-listing", "location":"local", "center":{"address":"New York United States", "lat":"43.1561681", "lng":"-75.8449946"}, "zoom":{"default":17, "search":17}, "cluster_options":{"center":{"lat":0, "lng":0}, "max_zoom":18, "zoom":3, "scroll_wheel":false, "fit_bound":true}};
                var HomListiObj = {"ajaxUrl":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-admin\/admin-ajax.php", "appendHtml":"", "themeUrl":"https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-content\/themes\/homlisti", "lsSideOffset":"130", "rtStickySidebar":"enable", "rtMagnificPopup":"enable"};
                var rtcl_single_listing_localized_params = {"slider_options":{"rtl":false, "autoHeight":true}, "slider_enabled":"1", "zoom_enabled":"1", "photoswipe_enabled":"1", "photoswipe_options":{"shareEl":false, "closeOnScroll":false, "history":false, "hideAnimationDuration":0, "showAnimationDuration":0}, "zoom_options":[]};
                /* ]]> */
            </script>
            <script>
                var wpo_server_info_js = {"user_agent":"Mozilla\/4.5 (compatible; HTTrack 3.0x; Windows 98)"}
                loadAsync('../wp-content/cache/wpo-minify/1721845095/assets/wpo-minify-footer-f329a969.min.js', null);
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

    <!-- Mirrored from www.radiustheme.com/demo/wordpress/themes/homlisti/my-account/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 25 Jul 2024 13:27:52 GMT -->
</html>
<!-- WP Optimize page cache - https://getwpo.com - Page not served from cache  -->
