<?php
session_start();

if (isset($_SESSION['loggedin'])) {
    header("Location: /houserental-master/homlisti/NEWDashboard.php");
    exit();
}

?>
<?php
//if (!isset($_SESSION['email'])) {
//    header("Location: login.php");
//    exit();
//}

$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'house_rental';

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}



$query = "
    SELECT * 
    FROM property 
    WHERE status = 'Allow' and AvailabilityStatus='Available'
    ORDER BY RAND() 
    LIMIT 3
";
$result = $conn->query($query);

$properties = [];
$propertyIds = [];

// Fetch properties and collect their IDs
while ($row = $result->fetch_assoc()) {
    $properties[$row['pid']] = [
        'details' => $row,
        'images' => []
    ];
    $propertyIds[] = $row['pid'];
}

// Step 2: Fetch images for these properties
if (count($propertyIds) > 0) {
    $ids = implode(',', $propertyIds);
    $imageQuery = "SELECT * FROM tblimage WHERE pid IN ($ids)";
    $imageResult = $conn->query($imageQuery);

    while ($imageRow = $imageResult->fetch_assoc()) {
        $pid = $imageRow['pid'];
        $properties[$pid]['images'][] = base64_encode($imageRow['image']);
    }
}

$conn->close();
?><!-- comment -->
<!DOCTYPE html>
<html lang="en-US">
  <!-- Mirrored from www.radiustheme.com/demo/wordpress/themes/homlisti/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 25 Jul 2024 13:21:13 GMT -->
  <!-- Added by HTTrack --><meta
    http-equiv="content-type"
    content="text/html;charset=UTF-8"
  /><!-- /Added by HTTrack -->
  <head>
       <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f4f4f4;
           
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
            color: #333;
        }
        .property {
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 10px;
            padding: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.2s;
            margin-bottom: 15px;
        }
        .property:hover {
            transform: translateY(-5px);
        }
        .slideshow {
            position: relative;
            height: 200px; /* Adjusted height for better visuals */
            overflow: hidden;
            border-radius: 5px;
        }
        .slideshow-images {
            display: flex;
            animation: slide 10s infinite;
        }
        .slideshow-images img {
            min-width: 100%;
            height: auto;
            border-radius: 5px;
            object-fit: cover;
        }
        @keyframes slide {
            0%, 20% { transform: translateX(0); }
            25%, 45% { transform: translateX(-100%); }
            50%, 70% { transform: translateX(-200%); }
            75%, 100% { transform: translateX(-300%); }
        }
        .action-icons {
            display: flex;
            justify-content: space-between;
            margin-top: 15px;
        }
        .action-icons a, .action-icons button {
            text-decoration: none;
            color: #3498db;
            transition: color 0.3s;
        }
        .action-icons a:hover, .action-icons button:hover {
            color: #2980b9;
        }
            .request-rent-button {
    background-color: #cce5ff; /* Light blue background */
    color: #004085; /* Dark blue text */
    border: 1px solid #004085; /* Dark blue border for definition */
    padding: 8px 15px;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s, color 0.3s;
}

.request-rent-button:hover {
    background-color: #004085; /* Dark blue background on hover */
    color: #ffffff; /* White text on hover */
}

        /* Dropdown Styling */
        select {
            height: 38px; /* Adjust height */
            border-radius: 5px; /* Rounded corners */
            border: 1px solid #ccc; /* Border color */
            padding: 5px; /* Padding inside dropdown */
            background-color: #fff; /* Background color */
            font-size: 16px; /* Font size */
            transition: border-color 0.3s; /* Transition effect */
        }
        /* Add some styles for the header */
        
        select:focus {
            border-color: #3498db; /* Border color on focus */
            outline: none; /* Remove default outline */
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5); /* Add shadow on focus */
        }

        /* Optional: Style for all form inputs to maintain consistency */
        input[type="text"],
        input[type="number"],
        input[type="email"],
        input[type="password"] {
            border-radius: 5px; /* Rounded corners */
            border: 1px solid #ccc; /* Border color */
            padding: 8px; /* Padding inside input */
            font-size: 16px; /* Font size */
            transition: border-color 0.3s; /* Transition effect */
        }

        input:focus {
            border-color: #3498db; /* Border color on focus */
            outline: none; /* Remove default outline */
            box-shadow: 0 0 5px rgba(52, 152, 219, 0.5); /* Add shadow on focus */
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script>
    $(document).ready(function() {
        $('#searchForm').on('submit', function(e) {
            e.preventDefault(); 

            $.ajax({
                type: 'GET',
                url: 'test2.php', 
                data: $(this).serialize(), 
                success: function(response) {
                    $('#propertyResults').html(response); 
                },
                error: function() {
                    alert('Error fetching properties.');
                }
            });
        });
    });
    </script>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="profile" href="https://gmpg.org/xfn/11" />
    <script>
      function loadAsync(e, t) {
        var a,
          n = !1;
        (a = document.createElement("script")),
          (a.type = "text/javascript"),
          (a.src = e),
          (a.onreadystatechange = function () {
            n ||
              (this.readyState && "complete" != this.readyState) ||
              ((n = !0), "function" == typeof t && t());
          }),
          (a.onload = a.onreadystatechange),
          document.getElementsByTagName("head")[0].appendChild(a);
      }
    </script>
    <title>HomListi &#8211; Real Estate WordPress Theme</title>
    <meta name="robots" content="max-image-preview:large" />
    <noscript
      ><style>
        #preloader {
          display: none;
        }
      </style></noscript
    >
    <link rel="dns-prefetch" href="http://fonts.googleapis.com/" />
    <link
      rel="alternate"
      type="application/rss+xml"
      title="HomListi &raquo; Feed"
      href="feed/index.php"
    />
    <link
      rel="alternate"
      type="application/rss+xml"
      title="HomListi &raquo; Comments Feed"
      href="comments/feed/index.php"
    />
    <script>
      var wpo_server_info_css = {
        user_agent:
          "Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/126.0.0.0 Safari\/537.36",
      };
      var wpo_min71032d52 = document.createElement("link");
      (wpo_min71032d52.rel = "stylesheet"),
        (wpo_min71032d52.type = "text/css"),
        (wpo_min71032d52.media = "async"),
        (wpo_min71032d52.href =
          "wp-content/themes/homlisti/assets/css/font-awesome.min.css"),
        (wpo_min71032d52.onload = function () {
          wpo_min71032d52.media = "all";
        }),
        document.getElementsByTagName("head")[0].appendChild(wpo_min71032d52);
    </script>
    <script>
      var wpo_server_info_css = {
        user_agent:
          "Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/126.0.0.0 Safari\/537.36",
      };
      var wpo_mine86e346d = document.createElement("link");
      (wpo_mine86e346d.rel = "stylesheet"),
        (wpo_mine86e346d.type = "text/css"),
        (wpo_mine86e346d.media = "async"),
        (wpo_mine86e346d.href =
          "wp-content/plugins/elementor/assets/lib/font-awesome/css/fontawesome.min.css"),
        (wpo_mine86e346d.onload = function () {
          wpo_mine86e346d.media = "all";
        }),
        document.getElementsByTagName("head")[0].appendChild(wpo_mine86e346d);
    </script>
    <script>
      var wpo_server_info_css = {
        user_agent:
          "Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/126.0.0.0 Safari\/537.36",
      };
      var wpo_minb14c31e0 = document.createElement("link");
      (wpo_minb14c31e0.rel = "stylesheet"),
        (wpo_minb14c31e0.type = "text/css"),
        (wpo_minb14c31e0.media = "async"),
        (wpo_minb14c31e0.href =
          "wp-content/plugins/elementor/assets/lib/font-awesome/css/solid.min.css"),
        (wpo_minb14c31e0.onload = function () {
          wpo_minb14c31e0.media = "all";
        }),
        document.getElementsByTagName("head")[0].appendChild(wpo_minb14c31e0);
    </script>
    <script>
      var wpo_server_info_css = {
        user_agent:
          "Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/126.0.0.0 Safari\/537.36",
      };
      var wpo_mind5c46c7b = document.createElement("link");
      (wpo_mind5c46c7b.rel = "stylesheet"),
        (wpo_mind5c46c7b.type = "text/css"),
        (wpo_mind5c46c7b.media = "async"),
        (wpo_mind5c46c7b.href =
          "https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;family=Ubuntu:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;family=Mulish:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&amp;display=swap"),
        (wpo_mind5c46c7b.onload = function () {
          wpo_mind5c46c7b.media = "all";
        }),
        document.getElementsByTagName("head")[0].appendChild(wpo_mind5c46c7b);
    </script>
    <style id="classic-theme-styles-inline-css" type="text/css">
      /*! This file is auto-generated */
      .wp-block-button__link {
        color: #fff;
        background-color: #32373c;
        border-radius: 9999px;
        box-shadow: none;
        text-decoration: none;
        padding: calc(0.667em + 2px) calc(1.333em + 2px);
        font-size: 1.125em;
      }
      .wp-block-file__button {
        background: #32373c;
        color: #fff;
        text-decoration: none;
      }
    </style>
    <style id="global-styles-inline-css" type="text/css">
      :root {
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
        --wp--preset--gradient--vivid-cyan-blue-to-vivid-purple: linear-gradient(
          135deg,
          rgba(6, 147, 227, 1) 0%,
          rgb(155, 81, 224) 100%
        );
        --wp--preset--gradient--light-green-cyan-to-vivid-green-cyan: linear-gradient(
          135deg,
          rgb(122, 220, 180) 0%,
          rgb(0, 208, 130) 100%
        );
        --wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange: linear-gradient(
          135deg,
          rgba(252, 185, 0, 1) 0%,
          rgba(255, 105, 0, 1) 100%
        );
        --wp--preset--gradient--luminous-vivid-orange-to-vivid-red: linear-gradient(
          135deg,
          rgba(255, 105, 0, 1) 0%,
          rgb(207, 46, 46) 100%
        );
        --wp--preset--gradient--very-light-gray-to-cyan-bluish-gray: linear-gradient(
          135deg,
          rgb(238, 238, 238) 0%,
          rgb(169, 184, 195) 100%
        );
        --wp--preset--gradient--cool-to-warm-spectrum: linear-gradient(
          135deg,
          rgb(74, 234, 220) 0%,
          rgb(151, 120, 209) 20%,
          rgb(207, 42, 186) 40%,
          rgb(238, 44, 130) 60%,
          rgb(251, 105, 98) 80%,
          rgb(254, 248, 76) 100%
        );
        --wp--preset--gradient--blush-light-purple: linear-gradient(
          135deg,
          rgb(255, 206, 236) 0%,
          rgb(152, 150, 240) 100%
        );
        --wp--preset--gradient--blush-bordeaux: linear-gradient(
          135deg,
          rgb(254, 205, 165) 0%,
          rgb(254, 45, 45) 50%,
          rgb(107, 0, 62) 100%
        );
        --wp--preset--gradient--luminous-dusk: linear-gradient(
          135deg,
          rgb(255, 203, 112) 0%,
          rgb(199, 81, 192) 50%,
          rgb(65, 88, 208) 100%
        );
        --wp--preset--gradient--pale-ocean: linear-gradient(
          135deg,
          rgb(255, 245, 203) 0%,
          rgb(182, 227, 212) 50%,
          rgb(51, 167, 181) 100%
        );
        --wp--preset--gradient--electric-grass: linear-gradient(
          135deg,
          rgb(202, 248, 128) 0%,
          rgb(113, 206, 126) 100%
        );
        --wp--preset--gradient--midnight: linear-gradient(
          135deg,
          rgb(2, 3, 129) 0%,
          rgb(40, 116, 252) 100%
        );
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
        --wp--preset--shadow--outlined: 6px 6px 0px -3px rgba(255, 255, 255, 1),
          6px 6px rgba(0, 0, 0, 1);
        --wp--preset--shadow--crisp: 6px 6px 0px rgba(0, 0, 0, 1);
      }
      :where(.is-layout-flex) {
        gap: 0.5em;
      }
      :where(.is-layout-grid) {
        gap: 0.5em;
      }
      body .is-layout-flex {
        display: flex;
      }
      .is-layout-flex {
        flex-wrap: wrap;
        align-items: center;
      }
      .is-layout-flex > :is(*, div) {
        margin: 0;
      }
      body .is-layout-grid {
        display: grid;
      }
      .is-layout-grid > :is(*, div) {
        margin: 0;
      }
      :where(.wp-block-columns.is-layout-flex) {
        gap: 2em;
      }
      :where(.wp-block-columns.is-layout-grid) {
        gap: 2em;
      }
      :where(.wp-block-post-template.is-layout-flex) {
        gap: 1.25em;
      }
      :where(.wp-block-post-template.is-layout-grid) {
        gap: 1.25em;
      }
      .has-black-color {
        color: var(--wp--preset--color--black) !important;
      }
      .has-cyan-bluish-gray-color {
        color: var(--wp--preset--color--cyan-bluish-gray) !important;
      }
      .has-white-color {
        color: var(--wp--preset--color--white) !important;
      }
      .has-pale-pink-color {
        color: var(--wp--preset--color--pale-pink) !important;
      }
      .has-vivid-red-color {
        color: var(--wp--preset--color--vivid-red) !important;
      }
      .has-luminous-vivid-orange-color {
        color: var(--wp--preset--color--luminous-vivid-orange) !important;
      }
      .has-luminous-vivid-amber-color {
        color: var(--wp--preset--color--luminous-vivid-amber) !important;
      }
      .has-light-green-cyan-color {
        color: var(--wp--preset--color--light-green-cyan) !important;
      }
      .has-vivid-green-cyan-color {
        color: var(--wp--preset--color--vivid-green-cyan) !important;
      }
      .has-pale-cyan-blue-color {
        color: var(--wp--preset--color--pale-cyan-blue) !important;
      }
      .has-vivid-cyan-blue-color {
        color: var(--wp--preset--color--vivid-cyan-blue) !important;
      }
      .has-vivid-purple-color {
        color: var(--wp--preset--color--vivid-purple) !important;
      }
      .has-black-background-color {
        background-color: var(--wp--preset--color--black) !important;
      }
      .has-cyan-bluish-gray-background-color {
        background-color: var(--wp--preset--color--cyan-bluish-gray) !important;
      }
      .has-white-background-color {
        background-color: var(--wp--preset--color--white) !important;
      }
      .has-pale-pink-background-color {
        background-color: var(--wp--preset--color--pale-pink) !important;
      }
      .has-vivid-red-background-color {
        background-color: var(--wp--preset--color--vivid-red) !important;
      }
      .has-luminous-vivid-orange-background-color {
        background-color: var(
          --wp--preset--color--luminous-vivid-orange
        ) !important;
      }
      .has-luminous-vivid-amber-background-color {
        background-color: var(
          --wp--preset--color--luminous-vivid-amber
        ) !important;
      }
      .has-light-green-cyan-background-color {
        background-color: var(--wp--preset--color--light-green-cyan) !important;
      }
      .has-vivid-green-cyan-background-color {
        background-color: var(--wp--preset--color--vivid-green-cyan) !important;
      }
      .has-pale-cyan-blue-background-color {
        background-color: var(--wp--preset--color--pale-cyan-blue) !important;
      }
      .has-vivid-cyan-blue-background-color {
        background-color: var(--wp--preset--color--vivid-cyan-blue) !important;
      }
      .has-vivid-purple-background-color {
        background-color: var(--wp--preset--color--vivid-purple) !important;
      }
      .has-black-border-color {
        border-color: var(--wp--preset--color--black) !important;
      }
      .has-cyan-bluish-gray-border-color {
        border-color: var(--wp--preset--color--cyan-bluish-gray) !important;
      }
      .has-white-border-color {
        border-color: var(--wp--preset--color--white) !important;
      }
      .has-pale-pink-border-color {
        border-color: var(--wp--preset--color--pale-pink) !important;
      }
      .has-vivid-red-border-color {
        border-color: var(--wp--preset--color--vivid-red) !important;
      }
      .has-luminous-vivid-orange-border-color {
        border-color: var(
          --wp--preset--color--luminous-vivid-orange
        ) !important;
      }
      .has-luminous-vivid-amber-border-color {
        border-color: var(--wp--preset--color--luminous-vivid-amber) !important;
      }
      .has-light-green-cyan-border-color {
        border-color: var(--wp--preset--color--light-green-cyan) !important;
      }
      .has-vivid-green-cyan-border-color {
        border-color: var(--wp--preset--color--vivid-green-cyan) !important;
      }
      .has-pale-cyan-blue-border-color {
        border-color: var(--wp--preset--color--pale-cyan-blue) !important;
      }
      .has-vivid-cyan-blue-border-color {
        border-color: var(--wp--preset--color--vivid-cyan-blue) !important;
      }
      .has-vivid-purple-border-color {
        border-color: var(--wp--preset--color--vivid-purple) !important;
      }
      .has-vivid-cyan-blue-to-vivid-purple-gradient-background {
        background: var(
          --wp--preset--gradient--vivid-cyan-blue-to-vivid-purple
        ) !important;
      }
      .has-light-green-cyan-to-vivid-green-cyan-gradient-background {
        background: var(
          --wp--preset--gradient--light-green-cyan-to-vivid-green-cyan
        ) !important;
      }
      .has-luminous-vivid-amber-to-luminous-vivid-orange-gradient-background {
        background: var(
          --wp--preset--gradient--luminous-vivid-amber-to-luminous-vivid-orange
        ) !important;
      }
      .has-luminous-vivid-orange-to-vivid-red-gradient-background {
        background: var(
          --wp--preset--gradient--luminous-vivid-orange-to-vivid-red
        ) !important;
      }
      .has-very-light-gray-to-cyan-bluish-gray-gradient-background {
        background: var(
          --wp--preset--gradient--very-light-gray-to-cyan-bluish-gray
        ) !important;
      }
      .has-cool-to-warm-spectrum-gradient-background {
        background: var(
          --wp--preset--gradient--cool-to-warm-spectrum
        ) !important;
      }
      .has-blush-light-purple-gradient-background {
        background: var(--wp--preset--gradient--blush-light-purple) !important;
      }
      .has-blush-bordeaux-gradient-background {
        background: var(--wp--preset--gradient--blush-bordeaux) !important;
      }
      .has-luminous-dusk-gradient-background {
        background: var(--wp--preset--gradient--luminous-dusk) !important;
      }
      .has-pale-ocean-gradient-background {
        background: var(--wp--preset--gradient--pale-ocean) !important;
      }
      .has-electric-grass-gradient-background {
        background: var(--wp--preset--gradient--electric-grass) !important;
      }
      .has-midnight-gradient-background {
        background: var(--wp--preset--gradient--midnight) !important;
      }
      .has-small-font-size {
        font-size: var(--wp--preset--font-size--small) !important;
      }
      .has-medium-font-size {
        font-size: var(--wp--preset--font-size--medium) !important;
      }
      .has-large-font-size {
        font-size: var(--wp--preset--font-size--large) !important;
      }
      .has-x-large-font-size {
        font-size: var(--wp--preset--font-size--x-large) !important;
      }
      :where(.wp-block-post-template.is-layout-flex) {
        gap: 1.25em;
      }
      :where(.wp-block-post-template.is-layout-grid) {
        gap: 1.25em;
      }
      :where(.wp-block-columns.is-layout-flex) {
        gap: 2em;
      }
      :where(.wp-block-columns.is-layout-grid) {
        gap: 2em;
      }
      :root :where(.wp-block-pullquote) {
        font-size: 1.5em;
        line-height: 1.6;
      }
    </style>
    <style class="optimize_css_2" type="text/css" media="all">
      @keyframes RtclzoomOut {
        0% {
          opacity: 1;
          transform: scale(0);
        }
        to {
          opacity: 0;
          transform: scale(1.5);
        }
      }
      .rtcl-gb-pricing-box {
        overflow: hidden;
        position: relative;
      }
      .rtcl-gb-pricing-box.content-alignment-left {
        text-align: left;
      }
      .rtcl-gb-pricing-box.content-alignment-left ul {
        align-items: flex-start;
      }
      .rtcl-gb-pricing-box.content-alignment-center {
        text-align: center;
      }
      .rtcl-gb-pricing-box.content-alignment-center ul {
        align-items: center;
      }
      .rtcl-gb-pricing-box.content-alignment-center ul li {
        justify-content: center;
      }
      .rtcl-gb-pricing-box.content-alignment-right {
        text-align: right;
      }
      .rtcl-gb-pricing-box.content-alignment-right ul {
        align-items: flex-end;
      }
      .rtcl-gb-pricing-box.content-alignment-right ul li {
        justify-content: end;
      }
      .rtcl-gb-pricing-box .rtcl-gb-pricing-features {
        color: #444;
        line-height: 2.2;
        margin-bottom: 0;
      }
      .rtcl-gb-pricing-box .rtcl-gb-pricing-features p {
        margin: 0 0 10px;
      }
      .rtcl-gb-pricing-box .rtcl-gb-pricing-features ul {
        font-size: medium;
        list-style: none;
        margin: 0;
        padding: 0;
      }
      .rtcl-gb-pricing-box .rtcl-gb-pricing-features ul li {
        align-items: center;
        display: inline-flex;
        gap: 8px;
      }
      .rtcl-gb-pricing-box .rtcl-gb-pricing-features ul li svg {
        width: 15px;
      }
      .rtcl-gb-pricing-box .rtcl-gb-pricing-button a {
        align-items: center;
        display: inline-flex;
        gap: 8px;
        justify-content: center;
      }
      .rtcl-gb-pricing-box .rtcl-gb-pricing-button a svg {
        width: 14px;
      }
      .rtcl-gb-pricing-box .rtcl-gb-price {
        align-items: flex-end;
        display: inline-flex;
      }
      .rtcl-gb-pricing-box .rtcl-gb-price.currency-right {
        flex-direction: row-reverse;
      }
      .rtcl-gb-pricing-box .pricing-label {
        align-items: flex-end;
        background-color: var(--rtcl-primary-color);
        border: 0;
        box-sizing: border-box;
        color: #fff;
        display: flex;
        font-size: 14px;
        font-weight: 400;
        height: 80px;
        justify-content: center;
        padding: 5px 25px;
        position: absolute;
        right: -65px;
        top: -30px;
        transform: rotate(45deg);
        width: 150px;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-1 {
        background-color: #f5f7fa;
        padding: 60px 20px;
        transition: all 0.5s ease-out;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-1 .rtcl-gb-pricing-title {
        color: #222;
        font-size: 22px;
        font-weight: 700;
        line-height: 1.5;
        margin-bottom: 30px;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-1 .rtcl-gb-pricing-price {
        align-items: flex-end;
        display: inline-flex;
        font-size: 48px;
        line-height: 1;
        margin-bottom: 30px;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-1 .rtcl-gb-price {
        align-items: flex-end;
        display: inline-flex;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-1
        .rtcl-gb-pricing-currency {
        font-size: 20px;
        font-weight: 500;
        line-height: 1;
        position: relative;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-1 .rtcl-gb-number {
        font-weight: 700;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-1
        .rtcl-gb-pricing-features
        ul {
        display: flex;
        flex-direction: column;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-1
        .rtcl-gb-pricing-duration {
        font-size: 16px;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-1 .rtcl-gb-pricing-button {
        color: #fff;
        margin-top: 20px;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-1
        .rtcl-gb-pricing-button
        a {
        background-color: var(--rtcl-button-bg-color);
        border-color: var(--rtcl-button-bg-color);
        border-radius: 2px;
        border-style: solid;
        border-width: 1px;
        color: var(--rtcl-button-color);
        font-size: 14px;
        font-weight: 600;
        line-height: 1.5;
        min-width: 140px;
        padding: 15px 20px;
        text-align: center;
        text-decoration: none;
        text-transform: uppercase;
        transition: all 0.3s ease-out;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-1
        .rtcl-gb-pricing-button
        a:hover {
        background-color: #fff0;
        border-color: var(--rtcl-button-hover-bg-color);
        color: #333;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2 {
        background-color: #fff;
        border-radius: 4px 4px 0 0;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2 .pricing-header {
        background-color: var(--rtcl-primary-color);
        padding: 40px;
        text-align: center;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2 .rtcl-gb-pricing-title {
        color: #fff;
        font-size: 30px;
        font-weight: 300;
        margin-bottom: 17px;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2 .rtcl-gb-pricing-price {
        align-items: flex-end;
        color: #fff;
        display: inline-flex;
        font-size: 48px;
        font-weight: 600;
        line-height: 1;
        margin-bottom: 10px;
        position: relative;
        z-index: 1;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2
        .rtcl-gb-pricing-duration {
        font-size: 22px;
        font-weight: 300;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2 .pricing-body {
        padding: 25px 40px 10px;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2
        .rtcl-gb-pricing-features {
        line-height: 2;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2
        .rtcl-gb-pricing-features
        ul
        li {
        display: flex;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2
        .rtcl-gb-pricing-features
        ul
        i {
        color: #5a49f8;
        min-width: 15px;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2 .pricing-footer {
        border-radius: 0 0 4px 4px;
        padding: 20px 40px 35px;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2
        .rtcl-gb-pricing-button
        a {
        background-color: #fff0;
        border-color: var(--rtcl-button-bg-color);
        border-radius: 4px;
        border-style: solid;
        border-width: 1px;
        color: #5a49f8;
        font-size: 1rem;
        font-weight: 500;
        line-height: 1.3;
        padding: 10px 27px;
        position: relative;
        text-decoration: none;
        transition: all 0.5s ease-in-out;
        z-index: 2;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2
        .rtcl-gb-pricing-button
        a:hover {
        background-color: var(--rtcl-button-hover-bg-color);
        border-color: var(--rtcl-button-hover-bg-color);
        color: #fff;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2.content-alignment-left
        .pricing-header {
        text-align: left;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2.content-alignment-center
        .pricing-header {
        text-align: center;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-2.content-alignment-right
        .pricing-header {
        text-align: right;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3 {
        background: #fff;
        padding: 60px 30px;
        position: relative;
        text-align: center;
        transition: all 0.3s ease-in-out;
        z-index: 1;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3 .box-icon {
        align-items: center;
        border-radius: 50%;
        display: inline-flex;
        height: 160px;
        justify-content: center;
        line-height: 1;
        margin-bottom: 1.875rem;
        position: relative;
        width: 160px;
        z-index: 1;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3 .box-icon:after,
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3 .box-icon:before {
        background-color: rgb(255 147 14 / 0.1);
        border-radius: 50%;
        bottom: 0;
        content: "";
        height: 160px;
        left: 0;
        margin: auto;
        overflow: hidden;
        position: absolute;
        right: 0;
        top: 0;
        transition: all 0.5s ease-in-out;
        width: 160px;
        z-index: -1;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3 .box-icon:after {
        height: 100px;
        width: 100px;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3 .box-icon svg {
        fill: #ff930e;
        width: 36px;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3 .rtcl-gb-pricing-title {
        color: #1d2124;
        font-size: 22px;
        font-weight: 600;
        line-height: 1;
        margin-bottom: 20px;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3
        .rtcl-gb-pricing-features {
        margin-bottom: 20px;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3
        .rtcl-gb-pricing-features
        ul
        li {
        align-items: center;
        display: flex;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3 .rtcl-gb-price {
        color: #1d2124;
        display: flex;
        font-size: 3rem;
        font-weight: 600;
        justify-content: center;
        line-height: 1;
        position: relative;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3
        .rtcl-gb-pricing-duration {
        color: #646464;
        display: block;
        font-size: 16px;
        font-weight: 400;
        line-height: 1.3;
        margin-top: 10px;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3 .rtcl-gb-pricing-button {
        margin-top: 30px;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3
        .rtcl-gb-pricing-button
        a {
        align-items: center;
        border-color: var(--rtcl-button-bg-color);
        border-radius: 4px;
        border-style: solid;
        border-width: 1px;
        color: #5a49f8;
        display: inline-flex;
        font-size: 1rem;
        font-weight: 500;
        justify-content: center;
        padding: 10px 27px;
        position: relative;
        text-decoration: none;
        transition: all 0.5s ease-in-out;
        z-index: 2;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3
        .rtcl-gb-pricing-button
        a:hover {
        background-color: var(--rtcl-button-hover-bg-color);
        border-color: var(--rtcl-button-hover-bg-color);
        color: #fff;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3.content-alignment-left
        .pricing-footer,
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3.content-alignment-left
        .pricing-header {
        text-align: left;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3.content-alignment-left
        .rtcl-gb-pricing-price {
        align-items: flex-start;
        display: flex;
        flex-direction: column;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3.content-alignment-center {
        text-align: center;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3.content-alignment-right {
        text-align: right;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3.content-alignment-right
        .rtcl-gb-pricing-price {
        align-items: flex-end;
        display: flex;
        flex-direction: column;
      }
      .rtcl-gb-pricing-box.rtcl-gb-pricing-box-view-3:hover .box-icon:before {
        animation: RtclzoomOut 1s infinite;
      }
      .rtcl-gb-listing-store .rtcl-item {
        background-color: #fff;
        border: 1px solid rgb(0 0 0 / 0.05);
        color: #2a2a2a;
        height: 100%;
        overflow: hidden;
        padding: 25px;
        transition: all 0.3s ease-in;
      }
      .rtcl-gb-listing-store .rtcl-item:hover {
        box-shadow: 0 0 5px 1px rgb(0 0 0 / 0.2);
      }
      .rtcl-gb-listing-store .rtcl-item .rtcl-title {
        color: var(--rtcl-color-title);
        font-size: 20px;
        font-weight: 700;
        line-height: 1.5;
        margin-bottom: 6px;
        transition: all 0.3s ease-out;
      }
      .rtcl-gb-listing-store .rtcl-item .rtcl-title:hover {
        color: var(--rtcl-primary-color);
      }
      .rtcl-gb-listing-store .rtcl-item .rtcl-title a {
        color: inherit;
      }
      .rtcl-gb-listing-store .rtcl-item .rtcl-count {
        font-size: 15px;
        line-height: 1;
        margin-top: 4px;
      }
      .rtcl-gb-listing-store .rtcl-item .rtcl-description {
        font-size: 16px;
        line-height: 26px;
        margin-bottom: 0;
        margin-top: 14px;
      }
      .rtcl-gb-listing-store.style-grid .rtcl-col-wrap {
        margin-bottom: 30px;
      }
      .rtcl-gb-listing-store.style-grid .rtcl-item {
        text-align: center;
      }
      .rtcl-gb-listing-store.style-grid .rtcl-item .rtcl-logo {
        margin-bottom: 15px;
      }
      .rtcl-gb-listing-store.style-list {
        display: grid;
        gap: 20px;
        margin-bottom: 30px;
      }
      .rtcl-gb-listing-store.style-list .rtcl-item {
        display: flex;
        gap: 20px;
      }
    </style>
    <style class="optimize_css_2" type="text/css" media="all">
      .rtcl .rtcl-stores {
        grid-column-gap: 15px;
        grid-row-gap: 15px;
        display: grid;
        grid-template-columns: repeat(4, 1fr);
      }
      .rtcl .rtcl-stores .rtcl-store-item .rtcl-store-link {
        align-content: center;
        display: flex;
        flex-direction: column;
        justify-content: center;
      }
      .rtcl .rtcl-stores .rtcl-store-item .rtcl-store-link:hover {
        text-decoration: none;
      }
      .rtcl .rtcl-stores .rtcl-store-item .store-thumb {
        align-content: center;
        background-color: #fff;
        display: flex;
        justify-content: center;
      }
      .rtcl .rtcl-stores .rtcl-store-item .store-thumb img {
        max-width: 100%;
      }
      .rtcl .rtcl-stores .rtcl-store-item .item-content {
        align-items: center;
        color: #2a2a2a;
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 10px 5px;
      }
      .rtcl .rtcl-stores .rtcl-store-item .rtcl-store-title {
        font-size: 20px;
        margin-bottom: 5px;
        word-break: break-all;
      }
      .rtcl .rtcl-stores .rtcl-store-item:hover .item-content {
        background-color: #1e73be;
        box-shadow: 0 0 20px 0 hsl(0 0% 85% / 0.75);
        color: #fff;
      }
      .rtcl .rtcl-stores.columns-6 {
        grid-template-columns: repeat(6, 1fr);
      }
      .rtcl .rtcl-stores.columns-5 {
        grid-template-columns: repeat(5, 1fr);
      }
      .rtcl .rtcl-stores.columns-4 {
        grid-template-columns: repeat(4, 1fr);
      }
      .rtcl .rtcl-stores.columns-3 {
        grid-template-columns: repeat(3, 1fr);
      }
      .rtcl .rtcl-stores.columns-2 {
        grid-template-columns: repeat(2, 1fr);
      }
      .rtcl .rtcl-stores.columns-1 {
        grid-template-columns: repeat(1, 1fr);
      }
      @media (max-width: 991px) {
        .rtcl .rtcl-stores,
        .rtcl .rtcl-stores.columns-4,
        .rtcl .rtcl-stores.columns-5,
        .rtcl .rtcl-stores.columns-6 {
          grid-template-columns: repeat(3, 1fr);
        }
      }
      @media (max-width: 767px) {
        .rtcl .rtcl-stores,
        .rtcl .rtcl-stores.columns-3,
        .rtcl .rtcl-stores.columns-4,
        .rtcl .rtcl-stores.columns-5,
        .rtcl .rtcl-stores.columns-6 {
          grid-template-columns: repeat(2, 1fr);
        }
      }
      @media (max-width: 575px) {
        .rtcl .rtcl-stores,
        .rtcl .rtcl-stores.columns-3,
        .rtcl .rtcl-stores.columns-4,
        .rtcl .rtcl-stores.columns-5,
        .rtcl .rtcl-stores.columns-6 {
          grid-template-columns: repeat(1, 1fr);
        }
      }
      .rtcl .rtcl-pricing-table .price-item {
        border-radius: 0;
        -moz-transition: all 0.3s ease;
        -o-transition: all 0.3s ease;
        -webkit-transition: all 0.3s ease;
      }
      .rtcl .rtcl-pricing-table .price-item:hover {
        box-shadow: 0 8px 12px 0 rgb(0 0 0 / 0.2);
      }
      .rtcl .rtcl-pricing-table .price-item .card-header {
        background-color: #57ac57;
        border-color: #71df71;
        border-bottom: 1px solid #71df71;
        border-radius: 0;
        box-shadow: inset 0 5px 0 rgb(50 50 50 / 0.2);
        color: #fff;
        text-shadow: 0 3px 0 rgb(50 50 50 / 0.6);
        -moz-transition: all 0.3s ease;
        -o-transition: all 0.3s ease;
        -webkit-transition: all 0.3s ease;
      }
      .rtcl .rtcl-pricing-table .price-item .rtcl-po-price {
        background-color: #ef5a5c;
        color: #fff;
        font-size: 40px;
        text-shadow: 0 3px 0 rgb(50 50 50 / 0.3);
      }
      .rtcl .rtcl-pricing-table .price-item .panel-footer {
        background-color: rgb(0 0 0 / 0.1);
        border-bottom: 0;
        box-shadow: 0 3px 0 rgb(0 0 0 / 0.3);
        color: #fff;
      }
      .rtcl .rtcl-pricing-table .price-item .panel-footer .btn {
        border: 0;
        box-shadow: inset 0 -1px 0 rgb(50 50 50 / 0.2);
      }
      .rtcl.store-content-wrap {
        background-color: #fff;
        border: 1px solid #e1e1e1;
        padding: 30px 30px 40px;
      }
      .rtcl.store-content-wrap .store-banner {
        margin: -30px -30px 20px;
        position: relative;
      }
      .rtcl.store-content-wrap .store-banner .banner {
        background: #008329;
        max-height: 362px;
        min-height: 250px;
      }
      .rtcl.store-content-wrap .store-banner .store-name-logo {
        bottom: 0;
        display: flex;
        left: 0;
        margin: 1rem;
        position: absolute;
        right: 0;
      }
      .rtcl.store-content-wrap .store-banner .store-name-logo .store-logo {
        align-items: center;
        background: #fff;
        border-radius: 2px;
        box-sizing: content-box;
        display: flex;
        height: 150px;
        justify-content: center;
        width: 200px;
      }
      .rtcl.store-content-wrap .store-banner .store-name-logo .store-logo img {
        max-height: 100%;
        max-width: 100%;
        -o-object-fit: contain;
        object-fit: contain;
        padding: 2px;
      }
      .rtcl.store-content-wrap .store-banner .store-name-logo .store-info {
        display: flex;
        flex-direction: column;
        justify-content: center;
        padding: 1rem 2rem;
      }
      .rtcl.store-content-wrap
        .store-banner
        .store-name-logo
        .store-info
        .rtcl-store-cat {
        color: #fff;
      }
      .rtcl.store-content-wrap
        .store-banner
        .store-name-logo
        .store-info
        .rtcl-store-cat
        .rtcl-icon,
      .rtcl.store-content-wrap
        .store-banner
        .store-name-logo
        .store-info
        .rtcl-store-cat
        a {
        color: inherit;
      }
      .rtcl.store-content-wrap .store-banner .store-name-logo .store-name h2 {
        word-wrap: break-word;
        color: #fff;
        padding: 0;
        text-shadow: 0 1px 3px rgb(0 0 0 / 0.9);
        word-break: break-word;
      }
      .rtcl.store-content-wrap .store-banner .store-name-logo .reviews-rating {
        align-items: center;
        color: #fff;
        display: flex;
      }
      .rtcl.store-content-wrap .store-details .is-slogan,
      .rtcl.store-content-wrap .store-listing-list > h3 {
        font-size: 1.2858rem;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-details
        .store-description {
        margin: 15px 0 55px;
        position: relative;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-details
        .store-description
        .fade-content {
        margin-bottom: 2rem;
        max-height: 9rem;
        overflow: hidden;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-details
        .store-description
        .fade-anchor {
        background: linear-gradient(180deg, #fff0, #fff0 0.1rem, #fff 1.5rem);
        bottom: -30px;
        display: block;
        padding-top: 30px;
        position: absolute;
        width: 100%;
      }
      .rtcl.store-content-wrap .store-information .store-info .store-info-item {
        word-wrap: break-word;
        border-bottom: 1px solid #d4ded9;
        display: flex;
        margin-top: 1rem;
        padding-bottom: 0.8rem;
        word-break: break-word;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-info-item
        .icon {
        align-items: center;
        justify-content: center;
        justify-items: center;
        padding-right: 10px;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-info-item
        .text {
        align-items: center;
        justify-content: center;
        justify-items: center;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-info-item
        .text
        .open-day.always {
        color: #37a000;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-info-item
        .text
        .open-day
        .store-now {
        display: block;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-info-item
        .text
        .open-day
        .store-now.store-open {
        color: #37a000;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-info-item
        .text
        .open-day
        .store-now.store-close {
        color: #b4352d;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-info-item
        .text
        .open-day
        .label {
        font-size: 100%;
        padding: 0;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-info-item
        .text
        .open-day
        .hours {
        font-weight: 700;
        margin-left: 5px;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-info-item
        .text
        .open-day
        .hours
        span.close-hour:before {
        content: "-";
        margin: 0 5px;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-info-item
        .text
        .close-day {
        color: #b4352d;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-info-item.store-email {
        flex-flow: row wrap;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-info-item.store-email
        .store-email-label {
        color: #008329;
        cursor: pointer;
        font-weight: 700;
        width: 100%;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-info-item.store-email
        #store-email-area {
        display: none;
        padding-top: 10px;
        width: 100%;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-social-media {
        flex-wrap: wrap;
        gap: 10px;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-social-media
        a {
        color: #fff;
        display: inline-block;
        font-weight: 400;
        margin-right: 0;
        text-decoration: none;
        transition: all 0.5s ease-out;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-social-media
        a.tiktok,
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-social-media
        a.twitter {
        align-items: center;
        background: #000;
        border-radius: 50%;
        display: inline-flex;
        height: 36px;
        justify-content: center;
        width: 36px;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-social-media
        .rtcl-icon {
        align-items: center;
        background-color: #1e73be;
        border-radius: 50%;
        color: #fff;
        display: flex;
        height: 36px;
        justify-content: center;
        margin-right: 0 !important;
        text-align: center;
        width: 36px;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-social-media
        .rtcl-icon.rtcl-icon-facebook {
        background: #3b5998;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-social-media
        .rtcl-icon.rtcl-icon-tiktok,
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-social-media
        .rtcl-icon.rtcl-icon-twitter {
        background: #fff;
        height: 16px;
        width: 16px;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-social-media
        .rtcl-icon.rtcl-icon-youtube {
        background: red;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-social-media
        .rtcl-icon.rtcl-icon-instagram {
        background: #000;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-social-media
        .rtcl-icon.rtcl-icon-linkedin {
        background: #1178b3;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-social-media
        .rtcl-icon.rtcl-icon-pinterest-circled {
        background: #c8232c;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-social-media
        .rtcl-icon.rtcl-icon-gplus {
        background: #d34836;
      }
      .rtcl.store-content-wrap .store-information .store-info .store-website a {
        color: inherit;
        text-decoration: none;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .store-website
        a:hover {
        color: var(--rtcl-primary-color);
      }
      .rtcl.store-content-wrap .store-information .store-info .reveal-phone {
        cursor: pointer;
        font-weight: 700;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .reveal-phone:not(.revealed):hover {
        color: #37a000;
      }
      .rtcl.store-content-wrap
        .store-information
        .store-info
        .reveal-phone.revealed
        small {
        display: none;
      }
      .rtcl .store-more-details {
        padding: 0 1.5rem 5px;
      }
      .rtcl .store-more-details h3 {
        border-bottom: 1px solid #d4ded9;
        color: #000;
        margin-bottom: 10px;
        padding-bottom: 10px;
      }
      .rtcl .store-more-details .more-item {
        word-wrap: break-word;
        margin-bottom: 1.5rem;
        word-break: break-word;
      }
      .rtcl
        .store-more-details
        .store-hours-list-wrap
        .store-hours-list
        .store-hour {
        margin-bottom: 5px;
      }
      .rtcl
        .store-more-details
        .store-hours-list-wrap
        .store-hours-list
        .store-hour
        .hour-day {
        text-transform: capitalize;
      }
      .rtcl
        .store-more-details
        .store-hours-list-wrap
        .store-hours-list
        .store-hour:last-child {
        margin-bottom: 0;
      }
      .rtcl
        .store-more-details
        .store-hours-list-wrap
        .store-hours-list
        .store-hour.current-store-hour {
        font-weight: 600;
      }
      .rtcl
        .store-more-details
        .store-hours-list-wrap
        .store-hours-list
        .store-hour
        .oh-hours-wrap
        .oh-hours
        .close-hour:before {
        content: "--";
        padding: 0 5px;
      }
      .rtcl
        .store-more-details
        .store-hours-list-wrap
        .store-hours-list
        .store-hour
        .oh-hours-wrap
        .off-day {
        color: #b4352d;
      }
      .rtcl
        .store-more-details
        .store-hours-list-wrap
        .store-hours-list
        .always-open {
        color: #37a000;
      }
      .rtcl #store-details-modal #store-details-modal-label {
        text-align: center;
        width: 100%;
      }
      .rtcl .features span {
        display: block;
        margin-bottom: 5px;
      }
      .rtcl .rtcl-store-meta small {
        font-size: 90%;
      }
      .rtcl .rtcl-store-meta .rtcl-icon {
        margin-right: 4px;
      }
      .rtcl .rtcl-membership-promotion-actions {
        display: flex;
        justify-content: space-between;
        margin-bottom: 1rem;
      }
      .rtcl .rtcl-promotions-heading {
        border: 1px solid #dee2e6;
        cursor: pointer;
        font-size: 18px;
        line-height: 1.4;
        margin: 0;
        padding: 10px 14px;
      }
      .rtcl .rtcl-promotions-heading:before {
        content: "\e856";
        display: inline-block;
        font-family: rtcl, serif;
        margin-right: 0.5em;
      }
      .rtcl .rtcl-promotions-heading + #rtcl-checkout-form,
      .rtcl .rtcl-promotions-heading + #rtcl-woo-checkout-form,
      .rtcl .rtcl-promotions-heading + .rtcl-membership-promotions-form-wrap {
        display: none;
      }
      .rtcl .rtcl-promotions-heading.active:before {
        transform: rotate(180deg);
      }
      .rtcl .rtcl-membership-promotions .promotion-item {
        display: flex;
      }
      .rtcl .rtcl-membership-promotions .promotion-item.label-item {
        font-weight: 700;
      }
      .rtcl .rtcl-membership-promotions .promotion-item .item-label {
        flex: 0 0 90px;
      }
      .rtcl .rtcl-membership-promotions .promotion-item .item-listings,
      .rtcl .rtcl-membership-promotions .promotion-item .item-validate {
        align-items: center;
        display: flex;
        flex: 0 0 50px;
        justify-content: center;
      }
      .rtcl .rtcl-membership-promotions .promotion-item + .promotion-item {
        border-top: 1px solid #eee;
        margin-top: 5px;
        padding-top: 5px;
      }
      .rtcl .pricing-description {
        margin-top: 15px;
      }
      .rtcl .promotion-validity small {
        margin-left: 4px;
      }
      .rtcl-store-widget-search-inline {
        display: flex;
        flex-wrap: wrap;
      }
      .rtcl-store-widget-search-inline > div {
        flex: 1 1 calc(33.3333% - 10px);
      }
      .rtcl-store-widget-search-inline .form-group {
        margin-bottom: 0;
      }
      .rtcl-store-widget-search-inline .form-group:nth-child(2),
      .rtcl-store-widget-search-inline .reset-btn,
      .rtcl-store-widget-search-inline .submit-btn {
        margin-left: 10px;
      }
      @media (max-width: 479px) {
        .rtcl-store-search-inline .rtcl-store-widget-search-inline > div {
          flex: 1 0 100%;
          margin-bottom: 10px;
        }
        .rtcl-store-search-inline
          .rtcl-store-widget-search-inline
          .form-group:nth-child(2),
        .rtcl-store-search-inline .rtcl-store-widget-search-inline .submit-btn {
          margin-left: 0;
        }
      }
      .rtcl-page.single-store .rtcl-store-item {
        padding: 30px;
      }
      @media (max-width: 599px) {
        .rtcl-page.single-store .rtcl-store-item {
          padding: 20px;
        }
      }
      .rtcl-page.single-store .store-banner .reviews-rating {
        color: #ffb300 !important;
      }
      .rtcl-page.single-store
        .store-banner
        .reviews-rating
        .rtrs-star-empty:before,
      .rtcl-page.single-store
        .store-banner
        .reviews-rating
        .rtrs-star-half-alt:before,
      .rtcl-page.single-store .store-banner .reviews-rating .rtrs-star:before {
        margin-left: 0;
      }
      .rtcl-page.single-store
        .store-banner
        .reviews-rating
        .reviews-rating-count {
        color: #fff;
      }
      .rtcl-page.single-store .rtrs-review-wrap {
        background-color: #fff0;
        margin: 30px 0 0;
        padding: 0;
      }
      .rtcl-page.single-store .rtrs-review-wrap .rtrs-summary {
        background-color: #fff;
        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
        padding: 30px;
      }
      @media (max-width: 599px) {
        .rtcl-page.single-store .rtrs-review-wrap .rtrs-summary {
          padding: 20px;
        }
      }
      .rtcl-page.single-store .rtrs-review-wrap .rtrs-sorting-bar {
        background-color: #fff;
        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
        padding: 10px 30px;
      }
      @media (max-width: 599px) {
        .rtcl-page.single-store .rtrs-review-wrap .rtrs-sorting-bar {
          padding: 10px 20px;
        }
      }
      .rtcl-page.single-store
        .rtrs-review-wrap
        .rtrs-sorting-bar
        .rtrs-sorting-select
        select {
        background-color: #f8f8f8;
        box-shadow: none;
        color: #646464;
      }
      .rtcl-page.single-store .rtrs-review-wrap .rtrs-review-box {
        background-color: #fff;
        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
        margin: 0 0 30px;
        padding: 30px 30px 10px;
      }
      @media (max-width: 599px) {
        .rtcl-page.single-store .rtrs-review-wrap .rtrs-review-box {
          padding: 20px 20px 10px;
        }
      }
      .rtcl-page.single-store
        .rtrs-review-wrap
        .rtrs-review-box
        .rtrs-review-form {
        background-color: #f8f8f8;
        margin-left: 30px;
      }
      .rtcl-page.single-store .rtrs-review-wrap .rtrs-review-form {
        background-color: #fff;
        box-shadow: 0 1px 3px 0 rgb(0 0 0 / 0.1);
        padding: 30px;
      }
      @media (max-width: 599px) {
        .rtcl-page.single-store .rtrs-review-wrap .rtrs-review-form {
          padding: 20px;
        }
      }
      @media (min-width: 401px) and (max-width: 500px) {
        .rtcl .store-more-details {
          padding: 10px 40px;
        }
      }
      @media (min-width: 0) and (max-width: 400px) {
        .rtcl .store-more-details {
          padding: 0;
        }
      }
      .rtcl-el-store-widget-wrapper .load-more-wrapper .load-more-btn {
        box-shadow: none;
        margin-top: 30px;
        outline: none;
      }
      .rtcl-el-store-widget-wrapper
        .load-more-wrapper
        .load-more-btn
        .fa-sync-alt {
        margin-right: 5px;
      }
      .rtcl-el-store-widget-wrapper .load-more-wrapper.loading .fa-sync-alt {
        animation-delay: 0s;
        animation-direction: normal;
        animation-duration: 1.5s;
        animation-iteration-count: infinite;
        animation-name: fa-spin;
        animation-timing-function: linear;
      }
    </style>
    <link
      rel="stylesheet"
      id="elementor-icons-css"
      href="wp-content/plugins/elementor/assets/lib/eicons/css/elementor-icons.min.css"
      type="text/css"
      media="all"
    />
    <link
      rel="stylesheet"
      id="swiper-css"
      href="wp-content/plugins/elementor/assets/lib/swiper/v8/css/swiper.min.css"
      type="text/css"
      media="all"
    />
    <style class="optimize_css_2" type="text/css" media="all">
      .elementor-kit-2673 {
        --e-global-color-primary: #00c194;
        --e-global-color-secondary: #07c196;
        --e-global-color-text: #70778b;
        --e-global-color-accent: #00c194;
        --e-global-color-d22c469: #00a376;
        --e-global-color-4f65493: #eaf7f4;
        --e-global-color-00ccbeb: #212121;
        --e-global-color-2ab0c7b: #eaf7f4;
        --e-global-typography-primary-font-family: "Ubuntu";
        --e-global-typography-primary-font-weight: 600;
        --e-global-typography-secondary-font-family: "Roboto";
        --e-global-typography-secondary-font-weight: 400;
        --e-global-typography-text-font-family: "Roboto";
        --e-global-typography-text-font-weight: 400;
        --e-global-typography-accent-font-family: "Roboto";
        --e-global-typography-accent-font-weight: 500;
      }
      .elementor-kit-2673 button,
      .elementor-kit-2673 input[type="button"],
      .elementor-kit-2673 input[type="submit"],
      .elementor-kit-2673 .elementor-button {
        font-family: "Mulish", Sans-serif;
      }
      .elementor-section.elementor-section-boxed > .elementor-container {
        max-width: 1240px;
      }
      .e-con {
        --container-max-width: 1240px;
      }
      .elementor-widget:not(:last-child) {
        margin-block-end: 0;
      }
      .elementor-element {
        --widgets-spacing: 0px 0px;
      }

      h1.entry-title {
        display: var(--page-title-display);
      }
      @media (max-width: 992px) {
        .elementor-section.elementor-section-boxed > .elementor-container {
          max-width: 1024px;
        }
        .e-con {
          --container-max-width: 1024px;
        }
      }
      @media (max-width: 768px) {
        .elementor-section.elementor-section-boxed > .elementor-container {
          max-width: 767px;
        }
        .e-con {
          --container-max-width: 767px;
        }
      }
    </style>
    <style class="optimize_css_2" type="text/css" media="all">
      .elementor-widget-heading .elementor-heading-title {
        color: var(--e-global-color-primary);
        font-family: var(--e-global-typography-primary-font-family), Sans-serif;
        font-weight: var(--e-global-typography-primary-font-weight);
      }
      .elementor-widget-image .widget-image-caption {
        color: var(--e-global-color-text);
        font-family: var(--e-global-typography-text-font-family), Sans-serif;
        font-weight: var(--e-global-typography-text-font-weight);
      }
      .elementor-widget-text-editor {
        color: var(--e-global-color-text);
        font-family: var(--e-global-typography-text-font-family), Sans-serif;
        font-weight: var(--e-global-typography-text-font-weight);
      }
      .elementor-widget-text-editor.elementor-drop-cap-view-stacked
        .elementor-drop-cap {
        background-color: var(--e-global-color-primary);
      }
      .elementor-widget-text-editor.elementor-drop-cap-view-framed
        .elementor-drop-cap,
      .elementor-widget-text-editor.elementor-drop-cap-view-default
        .elementor-drop-cap {
        color: var(--e-global-color-primary);
        border-color: var(--e-global-color-primary);
      }
      .elementor-widget-button .elementor-button {
        font-family: var(--e-global-typography-accent-font-family), Sans-serif;
        font-weight: var(--e-global-typography-accent-font-weight);
        background-color: var(--e-global-color-accent);
      }
      .elementor-widget-divider {
        --divider-color: var(--e-global-color-secondary);
      }
      .elementor-widget-divider .elementor-divider__text {
        color: var(--e-global-color-secondary);
        font-family: var(--e-global-typography-secondary-font-family),
          Sans-serif;
        font-weight: var(--e-global-typography-secondary-font-weight);
      }
      .elementor-widget-divider.elementor-view-stacked .elementor-icon {
        background-color: var(--e-global-color-secondary);
      }
      .elementor-widget-divider.elementor-view-framed .elementor-icon,
      .elementor-widget-divider.elementor-view-default .elementor-icon {
        color: var(--e-global-color-secondary);
        border-color: var(--e-global-color-secondary);
      }
      .elementor-widget-divider.elementor-view-framed .elementor-icon,
      .elementor-widget-divider.elementor-view-default .elementor-icon svg {
        fill: var(--e-global-color-secondary);
      }
      .elementor-widget-image-box .elementor-image-box-title {
        color: var(--e-global-color-primary);
        font-family: var(--e-global-typography-primary-font-family), Sans-serif;
        font-weight: var(--e-global-typography-primary-font-weight);
      }
      .elementor-widget-image-box .elementor-image-box-description {
        color: var(--e-global-color-text);
        font-family: var(--e-global-typography-text-font-family), Sans-serif;
        font-weight: var(--e-global-typography-text-font-weight);
      }
      .elementor-widget-icon.elementor-view-stacked .elementor-icon {
        background-color: var(--e-global-color-primary);
      }
      .elementor-widget-icon.elementor-view-framed .elementor-icon,
      .elementor-widget-icon.elementor-view-default .elementor-icon {
        color: var(--e-global-color-primary);
        border-color: var(--e-global-color-primary);
      }
      .elementor-widget-icon.elementor-view-framed .elementor-icon,
      .elementor-widget-icon.elementor-view-default .elementor-icon svg {
        fill: var(--e-global-color-primary);
      }
      .elementor-widget-icon-box.elementor-view-stacked .elementor-icon {
        background-color: var(--e-global-color-primary);
      }
      .elementor-widget-icon-box.elementor-view-framed .elementor-icon,
      .elementor-widget-icon-box.elementor-view-default .elementor-icon {
        fill: var(--e-global-color-primary);
        color: var(--e-global-color-primary);
        border-color: var(--e-global-color-primary);
      }
      .elementor-widget-icon-box .elementor-icon-box-title {
        color: var(--e-global-color-primary);
      }
      .elementor-widget-icon-box .elementor-icon-box-title,
      .elementor-widget-icon-box .elementor-icon-box-title a {
        font-family: var(--e-global-typography-primary-font-family), Sans-serif;
        font-weight: var(--e-global-typography-primary-font-weight);
      }
      .elementor-widget-icon-box .elementor-icon-box-description {
        color: var(--e-global-color-text);
        font-family: var(--e-global-typography-text-font-family), Sans-serif;
        font-weight: var(--e-global-typography-text-font-weight);
      }
      .elementor-widget-star-rating .elementor-star-rating__title {
        color: var(--e-global-color-text);
        font-family: var(--e-global-typography-text-font-family), Sans-serif;
        font-weight: var(--e-global-typography-text-font-weight);
      }
      .elementor-widget-image-gallery .gallery-item .gallery-caption {
        font-family: var(--e-global-typography-accent-font-family), Sans-serif;
        font-weight: var(--e-global-typography-accent-font-weight);
      }
      .elementor-widget-icon-list
        .elementor-icon-list-item:not(:last-child):after {
        border-color: var(--e-global-color-text);
      }
      .elementor-widget-icon-list .elementor-icon-list-icon i {
        color: var(--e-global-color-primary);
      }
      .elementor-widget-icon-list .elementor-icon-list-icon svg {
        fill: var(--e-global-color-primary);
      }
      .elementor-widget-icon-list
        .elementor-icon-list-item
        > .elementor-icon-list-text,
      .elementor-widget-icon-list .elementor-icon-list-item > a {
        font-family: var(--e-global-typography-text-font-family), Sans-serif;
        font-weight: var(--e-global-typography-text-font-weight);
      }
      .elementor-widget-icon-list .elementor-icon-list-text {
        color: var(--e-global-color-secondary);
      }
      .elementor-widget-counter .elementor-counter-number-wrapper {
        color: var(--e-global-color-primary);
        font-family: var(--e-global-typography-primary-font-family), Sans-serif;
        font-weight: var(--e-global-typography-primary-font-weight);
      }
      .elementor-widget-counter .elementor-counter-title {
        color: var(--e-global-color-secondary);
        font-family: var(--e-global-typography-secondary-font-family),
          Sans-serif;
        font-weight: var(--e-global-typography-secondary-font-weight);
      }
      .elementor-widget-progress
        .rt-progress-bar
        .elementor-progress-wrapper
        .elementor-progress-bar {
        background-color: var(--e-global-color-primary);
      }
      .elementor-widget-testimonial .elementor-testimonial-content {
        color: var(--e-global-color-text);
        font-family: var(--e-global-typography-text-font-family), Sans-serif;
        font-weight: var(--e-global-typography-text-font-weight);
      }
      .elementor-widget-testimonial .elementor-testimonial-name {
        color: var(--e-global-color-primary);
        font-family: var(--e-global-typography-primary-font-family), Sans-serif;
        font-weight: var(--e-global-typography-primary-font-weight);
      }
      .elementor-widget-testimonial .elementor-testimonial-job {
        color: var(--e-global-color-secondary);
        font-family: var(--e-global-typography-secondary-font-family),
          Sans-serif;
        font-weight: var(--e-global-typography-secondary-font-weight);
      }
      .elementor-widget-tabs .elementor-tab-title,
      .elementor-widget-tabs .elementor-tab-title a {
        color: var(--e-global-color-primary);
      }
      .elementor-widget-tabs .elementor-tab-title.elementor-active,
      .elementor-widget-tabs .elementor-tab-title.elementor-active a {
        color: var(--e-global-color-accent);
      }
      .elementor-widget-tabs .elementor-tab-title {
        font-family: var(--e-global-typography-primary-font-family), Sans-serif;
        font-weight: var(--e-global-typography-primary-font-weight);
      }
      .elementor-widget-tabs .elementor-tab-content {
        color: var(--e-global-color-text);
        font-family: var(--e-global-typography-text-font-family), Sans-serif;
        font-weight: var(--e-global-typography-text-font-weight);
      }
      .elementor-widget-accordion .elementor-accordion-icon,
      .elementor-widget-accordion .elementor-accordion-title {
        color: var(--e-global-color-primary);
      }
      .elementor-widget-accordion .elementor-accordion-icon svg {
        fill: var(--e-global-color-primary);
      }
      .elementor-widget-accordion .elementor-active .elementor-accordion-icon,
      .elementor-widget-accordion .elementor-active .elementor-accordion-title {
        color: var(--e-global-color-accent);
      }
      .elementor-widget-accordion
        .elementor-active
        .elementor-accordion-icon
        svg {
        fill: var(--e-global-color-accent);
      }
      .elementor-widget-accordion .elementor-accordion-title {
        font-family: var(--e-global-typography-primary-font-family), Sans-serif;
        font-weight: var(--e-global-typography-primary-font-weight);
      }
      .elementor-widget-accordion .elementor-tab-content {
        color: var(--e-global-color-text);
        font-family: var(--e-global-typography-text-font-family), Sans-serif;
        font-weight: var(--e-global-typography-text-font-weight);
      }
      .elementor-widget-toggle .elementor-toggle-title,
      .elementor-widget-toggle .elementor-toggle-icon {
        color: var(--e-global-color-primary);
      }
      .elementor-widget-toggle .elementor-toggle-icon svg {
        fill: var(--e-global-color-primary);
      }
      .elementor-widget-toggle .elementor-tab-title.elementor-active a,
      .elementor-widget-toggle
        .elementor-tab-title.elementor-active
        .elementor-toggle-icon {
        color: var(--e-global-color-accent);
      }
      .elementor-widget-toggle .elementor-toggle-title {
        font-family: var(--e-global-typography-primary-font-family), Sans-serif;
        font-weight: var(--e-global-typography-primary-font-weight);
      }
      .elementor-widget-toggle .elementor-tab-content {
        color: var(--e-global-color-text);
        font-family: var(--e-global-typography-text-font-family), Sans-serif;
        font-weight: var(--e-global-typography-text-font-weight);
      }
      .elementor-widget-alert .elementor-alert-title {
        font-family: var(--e-global-typography-primary-font-family), Sans-serif;
        font-weight: var(--e-global-typography-primary-font-weight);
      }
      .elementor-widget-alert .elementor-alert-description {
        font-family: var(--e-global-typography-text-font-family), Sans-serif;
        font-weight: var(--e-global-typography-text-font-weight);
      }
      .elementor-widget-fluent-form-widget .fluentform-widget-description {
        font-family: var(--e-global-typography-accent-font-family), Sans-serif;
        font-weight: var(--e-global-typography-accent-font-weight);
      }
      .elementor-widget-rt-properties-type-tab .isotope-classes-tab .nav-item {
        font-family: var(--e-global-typography-accent-font-family), Sans-serif;
        font-weight: var(--e-global-typography-accent-font-weight);
      }
      .elementor-widget-text-path {
        font-family: var(--e-global-typography-text-font-family), Sans-serif;
        font-weight: var(--e-global-typography-text-font-weight);
      }
    </style>
    <style class="optimize_css_2" type="text/css" media="all">
      @font-face {
        font-family: "flaticon";
        src: url(wp-content/themes/homlisti/assets/fonts/flaticon.ttf#1721845095)
            format("truetype"),
          url(https://www.radiustheme.com/demo/wordpress/themes/homlisti/wp-content/themes/homlisti/assets/css/../fonts/flaticon.woff#1721845095)
            format("woff"),
          url(https://www.radiustheme.com/demo/wordpress/themes/homlisti/wp-content/themes/homlisti/assets/css/../fonts/flaticon.woff2#1721845095)
            format("woff2"),
          url(https://www.radiustheme.com/demo/wordpress/themes/homlisti/wp-content/themes/homlisti/assets/css/../fonts/flaticon.eot#1721845095)
            format("embedded-opentype"),
          url(https://www.radiustheme.com/demo/wordpress/themes/homlisti/wp-content/themes/homlisti/assets/css/../fonts/flaticon.svg?4c8541f813cac0753c62e0740c5ce069#flaticon)
            format("svg");
      }
      i[class^="flaticon-"]:before,
      i[class*=" flaticon-"]:before {
        font-family: flaticon !important;
        font-style: normal;
        font-weight: normal !important;
        font-variant: normal;
        text-transform: none;
        line-height: 1;
        -webkit-font-smoothing: antialiased;
        -moz-osx-font-smoothing: grayscale;
      }
      .flaticon-user:before {
        content: "\f101";
      }
      .flaticon-user-1:before {
        content: "\f102";
      }
      .flaticon-speech-bubble:before {
        content: "\f103";
      }
      .flaticon-next:before {
        content: "\f104";
      }
      .flaticon-share:before {
        content: "\f105";
      }
      .flaticon-share-1:before {
        content: "\f106";
      }
      .flaticon-left-and-right-arrows:before {
        content: "\f107";
      }
      .flaticon-heart:before {
        content: "\f108";
      }
      .flaticon-camera:before {
        content: "\f109";
      }
      .flaticon-video-player:before {
        content: "\f10a";
      }
      .flaticon-maps-and-flags:before {
        content: "\f10b";
      }
      .flaticon-check:before {
        content: "\f10c";
      }
      .flaticon-envelope:before {
        content: "\f10d";
      }
      .flaticon-phone-call:before {
        content: "\f10e";
      }
      .flaticon-call:before {
        content: "\f10f";
      }
      .flaticon-clock:before {
        content: "\f110";
      }
      .flaticon-play:before {
        content: "\f111";
      }
      .flaticon-loupe:before {
        content: "\f112";
      }
      .flaticon-user-2:before {
        content: "\f113";
      }
      .flaticon-bed:before {
        content: "\f114";
      }
      .flaticon-shower:before {
        content: "\f115";
      }
      .flaticon-pencil:before {
        content: "\f116";
      }
      .flaticon-two-overlapping-square:before {
        content: "\f117";
      }
      .flaticon-printer:before {
        content: "\f118";
      }
      .flaticon-comment:before {
        content: "\f119";
      }
      .flaticon-home:before {
        content: "\f11a";
      }
      .flaticon-garage:before {
        content: "\f11b";
      }
      .flaticon-full-size:before {
        content: "\f11c";
      }
      .flaticon-tag:before {
        content: "\f11d";
      }
      .flaticon-right-arrow:before {
        content: "\f11e";
      }
      .flaticon-left-arrow:before {
        content: "\f11f";
      }
      .flaticon-left-arrow-1:before {
        content: "\f120";
      }
      .flaticon-left-arrow-2:before {
        content: "\f121";
      }
      .flaticon-right-arrow-1:before {
        content: "\f122";
      }
    </style>
    <style class="optimize_css_2" type="text/css" media="all">
      .mfp-bg {
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1042;
        overflow: hidden;
        position: fixed;
        background: #0b0b0b;
        opacity: 0.8;
      }
      .mfp-wrap {
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        z-index: 1043;
        position: fixed;
        outline: none !important;
        -webkit-backface-visibility: hidden;
      }
      .mfp-container {
        text-align: center;
        position: absolute;
        width: 100%;
        height: 100%;
        left: 0;
        top: 0;
        padding: 0 8px;
        box-sizing: border-box;
      }
      .mfp-container:before {
        content: "";
        display: inline-block;
        height: 100%;
        vertical-align: middle;
      }
      .mfp-align-top .mfp-container:before {
        display: none;
      }
      .mfp-content {
        position: relative;
        display: inline-block;
        vertical-align: middle;
        margin: 0 auto;
        text-align: left;
        z-index: 1045;
      }
      .mfp-inline-holder .mfp-content,
      .mfp-ajax-holder .mfp-content {
        width: 100%;
        cursor: auto;
      }
      .mfp-ajax-cur {
        cursor: progress;
      }
      .mfp-zoom-out-cur,
      .mfp-zoom-out-cur .mfp-image-holder .mfp-close {
        cursor: -moz-zoom-out;
        cursor: -webkit-zoom-out;
        cursor: zoom-out;
      }
      .mfp-zoom {
        cursor: pointer;
        cursor: -webkit-zoom-in;
        cursor: -moz-zoom-in;
        cursor: zoom-in;
      }
      .mfp-auto-cursor .mfp-content {
        cursor: auto;
      }
      .mfp-close,
      .mfp-arrow,
      .mfp-preloader,
      .mfp-counter {
        -webkit-user-select: none;
        -moz-user-select: none;
        user-select: none;
      }
      .mfp-loading.mfp-figure {
        display: none;
      }
      .mfp-hide {
        display: none !important;
      }
      .mfp-preloader {
        color: #ccc;
        position: absolute;
        top: 50%;
        width: auto;
        text-align: center;
        margin-top: -0.8em;
        left: 8px;
        right: 8px;
        z-index: 1044;
      }
      .mfp-preloader a {
        color: #ccc;
      }
      .mfp-preloader a:hover {
        color: #fff;
      }
      .mfp-s-ready .mfp-preloader {
        display: none;
      }
      .mfp-s-error .mfp-content {
        display: none;
      }
      button.mfp-close,
      button.mfp-arrow {
        overflow: visible;
        cursor: pointer;
        background: #fff0;
        border: 0;
        -webkit-appearance: none;
        display: block;
        outline: none;
        padding: 0;
        z-index: 1046;
        box-shadow: none;
        touch-action: manipulation;
      }
      button::-moz-focus-inner {
        padding: 0;
        border: 0;
      }
      .mfp-close {
        width: 44px;
        height: 44px;
        line-height: 44px;
        position: absolute;
        right: 0;
        top: 0;
        text-decoration: none;
        text-align: center;
        opacity: 0.65;
        padding: 0 0 18px 10px;
        color: #fff;
        font-style: normal;
        font-size: 28px;
        font-family: Arial, Baskerville, monospace;
      }
      .mfp-close:hover,
      .mfp-close:focus {
        opacity: 1;
      }
      .mfp-close:active {
        top: 1px;
      }
      .mfp-close-btn-in .mfp-close {
        color: #333;
      }
      .mfp-image-holder .mfp-close,
      .mfp-iframe-holder .mfp-close {
        color: #fff;
        right: -6px;
        text-align: right;
        padding-right: 6px;
        width: 100%;
      }
      .mfp-counter {
        position: absolute;
        top: 0;
        right: 0;
        color: #ccc;
        font-size: 12px;
        line-height: 18px;
        white-space: nowrap;
      }
      .mfp-arrow {
        position: absolute;
        opacity: 0.65;
        margin: 0;
        top: 50%;
        margin-top: -55px;
        padding: 0;
        width: 90px;
        height: 110px;
        -webkit-tap-highlight-color: #fff0;
      }
      .mfp-arrow:active {
        margin-top: -54px;
      }
      .mfp-arrow:hover,
      .mfp-arrow:focus {
        opacity: 1;
      }
      .mfp-arrow:before,
      .mfp-arrow:after {
        content: "";
        display: block;
        width: 0;
        height: 0;
        position: absolute;
        left: 0;
        top: 0;
        margin-top: 35px;
        margin-left: 35px;
        border: medium inset #fff0;
      }
      .mfp-arrow:after {
        border-top-width: 13px;
        border-bottom-width: 13px;
        top: 8px;
      }
      .mfp-arrow:before {
        border-top-width: 21px;
        border-bottom-width: 21px;
        opacity: 0.7;
      }
      .mfp-arrow-left {
        left: 0;
      }
      .mfp-arrow-left:after {
        border-right: 17px solid #fff;
        margin-left: 31px;
      }
      .mfp-arrow-left:before {
        margin-left: 25px;
        border-right: 27px solid #3f3f3f;
      }
      .mfp-arrow-right {
        right: 0;
      }
      .mfp-arrow-right:after {
        border-left: 17px solid #fff;
        margin-left: 39px;
      }
      .mfp-arrow-right:before {
        border-left: 27px solid #3f3f3f;
      }
      .mfp-iframe-holder {
        padding-top: 40px;
        padding-bottom: 40px;
      }
      .mfp-iframe-holder .mfp-content {
        line-height: 0;
        width: 100%;
        max-width: 900px;
      }
      .mfp-iframe-holder .mfp-close {
        top: -40px;
      }
      .mfp-iframe-scaler {
        width: 100%;
        height: 0;
        overflow: hidden;
        padding-top: 56.25%;
      }
      .mfp-iframe-scaler iframe {
        position: absolute;
        display: block;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        box-shadow: 0 0 8px rgb(0 0 0 / 0.6);
        background: #000;
      }
      img.mfp-img {
        width: auto;
        max-width: 100%;
        height: auto;
        display: block;
        line-height: 0;
        box-sizing: border-box;
        padding: 40px 0 40px;
        margin: 0 auto;
      }
      .mfp-figure {
        line-height: 0;
      }
      .mfp-figure:after {
        content: "";
        position: absolute;
        left: 0;
        top: 40px;
        bottom: 40px;
        display: block;
        right: 0;
        width: auto;
        height: auto;
        z-index: -1;
        box-shadow: 0 0 8px rgb(0 0 0 / 0.6);
        background: #444;
      }
      .mfp-figure small {
        color: #bdbdbd;
        display: block;
        font-size: 12px;
        line-height: 14px;
      }
      .mfp-figure figure {
        margin: 0;
      }
      .mfp-bottom-bar {
        margin-top: -36px;
        position: absolute;
        top: 100%;
        left: 0;
        width: 100%;
        cursor: auto;
      }
      .mfp-title {
        text-align: left;
        line-height: 18px;
        color: #f3f3f3;
        word-wrap: break-word;
        padding-right: 36px;
      }
      .mfp-image-holder .mfp-content {
        max-width: 100%;
      }
      .mfp-gallery .mfp-image-holder .mfp-figure {
        cursor: pointer;
      }
      @media screen and (max-width: 800px) and (orientation: landscape),
        screen and (max-height: 300px) {
        .mfp-img-mobile .mfp-image-holder {
          padding-left: 0;
          padding-right: 0;
        }
        .mfp-img-mobile img.mfp-img {
          padding: 0;
        }
        .mfp-img-mobile .mfp-figure:after {
          top: 0;
          bottom: 0;
        }
        .mfp-img-mobile .mfp-figure small {
          display: inline;
          margin-left: 5px;
        }
        .mfp-img-mobile .mfp-bottom-bar {
          background: rgb(0 0 0 / 0.6);
          bottom: 0;
          margin: 0;
          top: auto;
          padding: 3px 5px;
          position: fixed;
          box-sizing: border-box;
        }
        .mfp-img-mobile .mfp-bottom-bar:empty {
          padding: 0;
        }
        .mfp-img-mobile .mfp-counter {
          right: 5px;
          top: 3px;
        }
        .mfp-img-mobile .mfp-close {
          top: 0;
          right: 0;
          width: 35px;
          height: 35px;
          line-height: 35px;
          background: rgb(0 0 0 / 0.6);
          position: fixed;
          text-align: center;
          padding: 0;
        }
      }
      @media all and (max-width: 900px) {
        .mfp-arrow {
          -webkit-transform: scale(0.75);
          transform: scale(0.75);
        }
        .mfp-arrow-left {
          -webkit-transform-origin: 0;
          transform-origin: 0;
        }
        .mfp-arrow-right {
          -webkit-transform-origin: 100%;
          transform-origin: 100%;
        }
        .mfp-container {
          padding-left: 6px;
          padding-right: 6px;
        }
      }
    </style>
    <style class="optimize_css_2" type="text/css" media="all">
      /*! Generated by Font Squirrel (https://www.fontsquirrel.com) on June 9, 2021 */
      @font-face {
        font-family: "quentinregular";
        src: url(wp-content/themes/homlisti/assets/fonts/quentin-webfont.woff2)
            format("woff2"),
          url(https://www.radiustheme.com/demo/wordpress/themes/homlisti/wp-content/themes/homlisti/assets/css/../fonts/quentin-webfont.woff)
            format("woff");
        font-weight: 400;
        font-style: normal;
      }
    </style>
    <link
      rel="stylesheet"
      id="rangeSlider-css"
      href="wp-content/themes/homlisti/assets/css/ion.rangeSlider.min.css"
      type="text/css"
      media="all"
    />
    <style id="homlisti-dynamic-inline-css" type="text/css">
      :root {
        --rt-body-font: "Roboto", sans-serif;
        --rt-heading-font: "Ubuntu", sans-serif;
        --rt-menu-font: "Ubuntu", sans-serif;
      }
      body {
        font-family: "Roboto", sans-serif;
        font-size: 16px;
        line-height: 30px;
        font-weight: normal;
        font-style: normal;
      }
      .header-menu,
      .header-menu .navigation-area nav {
        font-family: "Ubuntu", sans-serif;
      }
      .navigation-area nav > ul > li > a {
        line-height: 20px;
        font-weight: normal;
      }
      .navigation-area nav.template-main-menu > ul > li > a {
        font-size: 16px;
      }
      .navigation-area nav > ul > li ul.sub-menu li a {
        font-size: 15px;
        line-height: 22px;
      }
      .rtcl h1,
      .rtcl h2,
      .rtcl h3,
      .rtcl h4,
      .rtcl h5,
      .rtcl h6,
      h1,
      h2,
      h3,
      h4,
      h5,
      h6 {
        font-family: "Ubuntu", sans-serif;
        font-weight: 500;
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
        --rt-primary-light3: #eaf7f4;
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
        --e-global-color-2ab0c7b: #eaf7f4;
      }
      body {
        color: #686868;
      }
      a:active,
      .rtcl a:hover,
      a:hover,
      a:focus {
        color: #07c196;
      }
      .header-add-property-btn .item-btn {
        background-color: #00c194;
      }
      .header-add-property-btn .item-btn::after {
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
      .mean-container .mean-nav ul li a.mean-expand,
      .mean-container a.meanmenu-reveal {
        color: #00c194;
      }
      .header-style-4 .header-add-property-btn .item-btn,
      .header-icon-round .header-action ul li.button a,
      .navigation-area nav > ul > li > a {
        color: #000000;
      }
      .navigation-area nav > ul > li ul.sub-menu li a {
        color: #3a3a3a;
      }
      .header-icon-round .header-action ul li.button a:hover,
      .navigation-area nav > ul > li ul.sub-menu li a:hover,
      .header-menu .navigation-area nav ul li.current-menu-item a,
      .header-menu .navigation-area nav > ul > li > a:hover {
        color: #00c194;
      }
      .header-icon-round .header-action ul li.button a i {
        color: #00c194;
      }
      .header-icon-round .header-action ul li.button a:hover .icon-round {
        background-color: #07c196;
        border-color: #07c196;
      }
      .trheader
        .header-icon-round
        .header-action
        ul
        li.button
        a:hover
        .icon-round {
        background-color: #00c194;
        border-color: #00c194;
      }
      .header-topbar .topbar-right .social-icon a:hover {
        color: #50ffe4;
      }
      .trheader .site-header::before {
        background: rgba(0, 0, 0, 0);
        background: -webkit-linear-gradient(
          top,
          rgba(0, 0, 0, 0) 0%,
          rgba(0, 0, 0, 0) 100%
        );
        background: linear-gradient(
          to bottom,
          rgba(0, 0, 0, 0) 0%,
          rgba(0, 0, 0, 0) 100%
        );
      }
      .breadcrumbs-banner .rtcl-breadcrumb {
        color: #565656;
      }
      .breadcrumbs-banner h1 {
        color: #212121;
      }
      .breadcrumbs-banner .rtcl-breadcrumb a:hover,
      .breadcrumbs-banner .rtcl-breadcrumb span {
        color: #00c194;
      }
      .navigation-area nav > ul li.page_item_has_children > a:after,
      .navigation-area nav > ul li.menu-item-has-children > a:after {
        border-color: #000000;
      }
    </style>
    <link
      rel="stylesheet"
      id="wpo_min-header-0-css"
      href="wp-content/cache/wpo-minify/1721845095/assets/wpo-minify-header-d8e84213.min.css"
      type="text/css"
      media="all"
    />
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin />
    <script
      type="text/javascript"
      src="wp-includes/js/jquery/jquery.min.js"
      id="jquery-core-js"
    ></script>
    <script type="text/javascript" id="wpo_min-header-0-js-extra">
      /* <![CDATA[ */
      var rtcl_compare = {
        ajaxurl:
          "https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-admin\/admin-ajax.php",
        server_error: "Server Error!!",
      };
      var rtcl_quick_view = {
        ajaxurl:
          "https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-admin\/admin-ajax.php",
        server_error: "Server Error!!",
        selector: ".rtcl-quick-view",
        max_width: "1000",
        wrap_class: "rtcl-qvw no-heading",
      };
      /* ]]> */
    </script>
    <script>
      var wpo_server_info_js = {
        user_agent:
          "Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/126.0.0.0 Safari\/537.36",
      };
      loadAsync(
        "wp-content/cache/wpo-minify/1721845095/assets/wpo-minify-header-ac1568fa.min.js",
        null
      );
    </script>
    <link rel="https://api.w.org/" href="wp-json/index.php" />
    <link
      rel="alternate"
      title="JSON"
      type="application/json"
      href="wp-json/wp/v2/pages/3344.json"
    />
    <link
      rel="EditURI"
      type="application/rsd+xml"
      title="RSD"
      href="xmlrpc0db0.php?rsd"
    />
    <meta name="generator" content="WordPress 6.6.1" />
    <link rel="canonical" href="index.php" />
    <link rel="shortlink" href="index.php" />
    <link
      rel="alternate"
      title="oEmbed (JSON)"
      type="application/json+oembed"
      href="wp-json/oembed/1.0/embede327.json?url=https%3A%2F%2Fwww.radiustheme.com%2Fdemo%2Fwordpress%2Fthemes%2Fhomlisti%2F"
    />
    <link
      rel="alternate"
      title="oEmbed (XML)"
      type="text/xml+oembed"
      href="wp-json/oembed/1.0/embedcc72?url=https%3A%2F%2Fwww.radiustheme.com%2Fdemo%2Fwordpress%2Fthemes%2Fhomlisti%2F&amp;format=xml"
    />
    <meta
      name="generator"
      content="Elementor 3.23.2; features: additional_custom_breakpoints, e_lazyload; settings: css_print_method-external, google_font-enabled, font_display-auto"
    />

    <!-- This Google structured data (Rich Snippet) auto generated by RadiusTheme Review Schema plugin version 2.2.2 -->

    <style>
      .e-con.e-parent:nth-of-type(n + 4):not(.e-lazyloaded):not(.e-no-lazyload),
      .e-con.e-parent:nth-of-type(n + 4):not(.e-lazyloaded):not(.e-no-lazyload)
        * {
        background-image: none !important;
      }
      @media screen and (max-height: 1024px) {
        .e-con.e-parent:nth-of-type(n + 3):not(.e-lazyloaded):not(
            .e-no-lazyload
          ),
        .e-con.e-parent:nth-of-type(n + 3):not(.e-lazyloaded):not(
            .e-no-lazyload
          )
          * {
          background-image: none !important;
        }
      }
      @media screen and (max-height: 640px) {
        .e-con.e-parent:nth-of-type(n + 2):not(.e-lazyloaded):not(
            .e-no-lazyload
          ),
        .e-con.e-parent:nth-of-type(n + 2):not(.e-lazyloaded):not(
            .e-no-lazyload
          )
          * {
          background-image: none !important;
        }
      }
    </style>
    <link
      rel="icon"
      href="wp-content/uploads/2021/09/cropped-favicon-homlisti-32x32.png"
      sizes="32x32"
    />
    <link
      rel="icon"
      href="wp-content/uploads/2021/09/cropped-favicon-homlisti-192x192.png"
      sizes="192x192"
    />
    <link
      rel="apple-touch-icon"
      href="wp-content/uploads/2021/09/cropped-favicon-homlisti-180x180.png"
    />
    <meta
      name="msapplication-TileImage"
      content="https://www.radiustheme.com/demo/wordpress/themes/homlisti/wp-content/uploads/2021/09/cropped-favicon-homlisti-270x270.png"
    />
    <style type="text/css" id="wp-custom-css">
      .rt-el-testimonial-carousel .slick-list {
        overflow: hidden;
      }
    </style>
  </head>
  <body
    class="home page-template page-template-templates page-template-blank page-template-templatesblank-php page page-id-3344 rtcl-no-js HomListi-version-1.10.4 theme-homlisti header-style-4 header-width-box-width sticky-header trheader front-page homlisti-core-installed product-grid-view page-home-1 elementor-default elementor-kit-2673 elementor-page elementor-page-3344"
  >
    <div
      id="preloader"
      style="
        background-image: url(wp-content/themes/homlisti/assets/img/preloader.gif);
      "
    ></div>
    <div id="wrapper" class="wrapper">
      <a class="skip-link screen-reader-text" href="#content"
        >Skip to content</a
      >
      <header id="site-header" class="site-header">
        <div id="rt-sticky-placeholder"></div>
        <div
          id="header-menu"
          class="header-menu menu-layout1 header-icon-round"
        >
          <div class="container">
            <div class="header-content">
              <div class="logo-area">
                <div class="site-branding">
                  <a class="custom-logo" href="index.php">
                    <img
                      class="img-fluid"
                      src="wp-content/uploads/2023/02/logo_light.svg"
                      width="148"
                      height="39"
                      alt="HomListi"
                    />
                  </a>
                </div>
              </div>
             <div id="main-navigation" class="navigation-area menu-center">
                <nav id="dropdown" class="template-main-menu">
                  <ul id="menu-main-navigation" class="menu">
                    <li
                      id="menu-item-4356"
                      class="menu-item menu-item-type-post_type menu-item-object-page current-menu-item page_item page-item-3941 current_page_item menu-item-4132"
                    >
                      <a href="NEWDashboard.php">Home</a>
<!--                      <ul class="sub-menu">
                        <li
                          id="menu-item-4358"
                          class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-3344 current_page_item menu-item-4358"
                        >
                          <a href="index.php" aria-current="page">Home 1</a>
                        </li>
                        <li
                          id="menu-item-4359"
                          class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4359"
                        >
                          <a href="home-2/index.php">Home 2</a>
                        </li>
                        <li
                          id="menu-item-4357"
                          class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4357"
                        >
                          <a href="home-3/index.php">Home 3</a>
                        </li>
                        <li
                          id="menu-item-7904"
                          class="menu-item menu-item-type-post_type menu-item-object-page menu-item-7904"
                        >
                          <a href="home-4/index.php">Home 4</a>
                        </li>
                        <li
                          id="menu-item-17181"
                          class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17181"
                        >
                          <a href="home-5/index.php">Home 5</a>
                        </li>
                        <li
                          id="menu-item-18057"
                          class="menu-item menu-item-type-post_type menu-item-object-page menu-item-18057"
                        >
                          <a href="home-6/index.php">Home 6</a>
                        </li>
                      </ul>
                    </li>-->
                    <li
                      id="menu-item-4132"
                      class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4132"
                    >
                      <a href="about/index.php">About</a>
                    </li>
                    <li
                      id="menu-item-4386"
                      class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4132"
                    >
                      <a href="/houserental-master/homlisti/property/affordable-green-villa-house-for-rent/index.php">Property</a>
<!--                      <ul class="sub-menu">
                        <li
                          id="menu-item-4387"
                          class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4387"
                        >
                          <a href="#">Column 1</a>
                          <ul class="sub-menu">
                            <li
                              id="menu-item-9149"
                              class="menu-item menu-item-type-post_type_archive menu-item-object-rtcl_listing menu-item-9149"
                            >
                              <a href="all-properties/index.php"
                                >Properties Grid</a
                              >
                            </li>
                            <li
                              id="menu-item-15637"
                              class="menu-item menu-item-type-post_type_archive menu-item-object-rtcl_listing menu-item-15637"
                            >
                              <a href="all-properties/indexd1fd.html?view=list"
                                >Properties List</a
                              >
                            </li>
                            <li
                              id="menu-item-16046"
                              class="menu-item menu-item-type-post_type menu-item-object-page menu-item-16046"
                            >
                              <a href="listing-map/index.php"
                                >Properties Map Grid</a
                              >
                            </li>
                            <li
                              id="menu-item-16047"
                              class="menu-item menu-item-type-post_type menu-item-object-page menu-item-16047"
                            >
                              <a href="listing-map/indexd1fd.html?view=list"
                                >Properties Map List</a
                              >
                            </li>
                          </ul>
                        </li>
                        <li
                          id="menu-item-4391"
                          class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4391"
                        >
                          <a href="#">Column 2</a>
                          <ul class="sub-menu">
                            <li
                              id="menu-item-15640"
                              class="menu-item menu-item-type-post_type_archive menu-item-object-rtcl_listing menu-item-15640"
                            >
                              <a
                                href="all-properties/index128e.html?layout=fullwidth"
                                >Properties Fullwidth</a
                              >
                            </li>-->
<!--                            <li
                              id="menu-item-17444"
                              class="menu-item menu-item-type-post_type menu-item-object-rtcl_listing menu-item-17444"
                            >
                              <a
                                href="property/triple-story-house-for-rent/index.php"
                                >Single Property &#8211; Default</a
                              >
                            </li>
                            <li
                              id="menu-item-17418"
                              class="menu-item menu-item-type-post_type menu-item-object-rtcl_listing menu-item-17418"
                            >
                              <a
                                href="property/affordable-green-villa-house-for-rent/index.php"
                                >Single Property &#8211; Fullwidth</a
                              >
                            </li>
                            <li
                              id="menu-item-17445"
                              class="menu-item menu-item-type-post_type menu-item-object-rtcl_listing menu-item-17445"
                            >
                              <a
                                href="property/sky-pool-villa-house-for-sale/index.php"
                                >Single Property &#8211; Grid</a
                              >
                            </li>
                          </ul>
                        </li>
                      </ul>
                    </li>-->
<!--                    <li
                      id="menu-item-4733"
                      class="mega-menu mega-menu-col-2 menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4733"
                    >
                      <a href="#">Pages</a>
                      <ul class="sub-menu">
                        <li
                          id="menu-item-17272"
                          class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-17272"
                        >
                          <a href="#">Column</a>
                          <ul class="sub-menu">
                            <li
                              id="menu-item-15643"
                              class="menu-item menu-item-type-post_type menu-item-object-page menu-item-15643"
                            >
                              <a href="agencies/index.php">Agencies</a>
                            </li>
                            <li
                              id="menu-item-17451"
                              class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17451"
                            >
                              <a href="agents/index.php">Agents</a>
                            </li>
                            <li
                              id="menu-item-17452"
                              class="menu-item menu-item-type-post_type menu-item-object-rtcl_agent menu-item-17452"
                            >
                              <a href="agent/rosy_janner/index.php"
                                >Agent Details</a
                              >
                            </li>
                          </ul>
                        </li>
                        <li
                          id="menu-item-17273"
                          class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-17273"
                        >
                          <a href="#">Column</a>
                          <ul class="sub-menu">
                            <li
                              id="menu-item-8071"
                              class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8071"
                            >
                              <a href="pricing-table/index.php"
                                >Pricing Table</a
                              >
                            </li>
                            <li
                              id="menu-item-4734"
                              class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4734"
                            >
                              <a href="error-404.html">404 Error</a>
                            </li>
                          </ul>
                        </li>
                      </ul>
                    </li>-->
<!--                    <li
                      id="menu-item-4736"
                      class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4736"
                    >
                      <a href="#">Blog</a>
                      <ul class="sub-menu">
                        <li
                          id="menu-item-4615"
                          class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4615"
                        >
                          <a href="blog/index.php">Blog List</a>
                        </li>
                        <li
                          id="menu-item-8849"
                          class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8849"
                        >
                          <a href="blog-grid/index.php">Blog Grid</a>
                        </li>
                        <li
                          id="menu-item-17271"
                          class="menu-item menu-item-type-post_type menu-item-object-post menu-item-17271"
                        >
                          <a
                            href="develop-relationships-with-human-resource/index.php"
                            >Blog Details</a
                          >
                        </li>
                      </ul>
                    </li>-->
                    <li
                      id="menu-item-4735"
                      class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4735"
                    >
                      <a href="contact/index.php">Contact</a>
                    </li>
                  </ul>
                </nav>
              </div>

              <div class="listing-area">
                <div class="header-action">
                  <ul class="header-btn">
<!--                    <li class="compare-btn has-count-number button" style="">
                      <a
                        class="item-btn"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="Compare"
                        href="compare/index.php"
                      >
                        <i
                          class="flaticon-left-and-right-arrows icon-round"
                        ></i>
                        <span class="count rt-compare-count">0</span>
                      </a>
                    </li>-->
<!--
                    <li class="favourite has-count-number button" style="">
                      <a
                        class="item-btn"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title="Favourites"
                        href="my-account/favourites/index.php"
                      >
                        <i class="flaticon-heart icon-round"></i>
                        <span class="count rt-header-favourite-count">0</span>
                      </a>
                    </li>-->

                    <li class="login-btn button" style="">
                      <a
                        class="item-btn"
                        data-toggle="tooltip"
                        data-placement="bottom"
                        title=" Sign in"
                        href="my-account/index.php"
                      >
                        <i class="flaticon-user-1 icon-round"></i>
                      </a>
                    </li>

                    <li class="submit-btn header-add-property-btn" style="">
                      <a
                        href="post-an-ad/index.php"
                        class="item-btn rt-animation-btn"
                      >
                        <span>
                          <i class="fas fa-plus-circle"></i>
                        </span>
                        <div class="btn-text">Add Property</div>
                      </a>
                    </li>

                    <li class="offcanvar_bar button" style="order: 99">
                      <span class="sidebarBtn">
                        <span class="fa fa-bars"> </span>
                      </span>
                    </li>
                  </ul>
                </div>
              </div>
            </div>
          </div>
        </div>
      </header>

      <div id="mobile-menu-sticky-placeholder"></div>
      <div
        class="rt-header-menu mean-container mobile-offscreen-menu header-icon-round"
        id="meanmenu"
      >
        <div class="mean-bar">
          <div class="mobile-logo">
            <a class="custom-logo site-main-logo" href="index.php">
              <img
                class="img-fluid"
                src="wp-content/uploads/2023/02/logo_light.svg"
                width="148"
                height="39"
                alt="HomListi"
              />
            </a>
          </div>

          <div class="listing-area">
            <div class="header-action">
              <ul class="header-btn">
                <li class="compare-btn has-count-number button" style="">
                  <a
                    class="item-btn"
                    data-toggle="tooltip"
                    data-placement="bottom"
                    title="Compare"
                    href="compare/index.php"
                  >
                    <i class="flaticon-left-and-right-arrows icon-round"></i>
                    <span class="count rt-compare-count">0</span>
                  </a>
                </li>

                <li class="favourite has-count-number button" style="">
                  <a
                    class="item-btn"
                    data-toggle="tooltip"
                    data-placement="bottom"
                    title="Favourites"
                    href="my-account/favourites/index.php"
                  >
                    <i class="flaticon-heart icon-round"></i>
                    <span class="count rt-header-favourite-count">0</span>
                  </a>
                </li>

                <li class="login-btn button" style="">
                  <a
                    class="item-btn"
                    data-toggle="tooltip"
                    data-placement="bottom"
                    title=" Sign in"
                    href="my-account/index.php"
                  >
                    <i class="flaticon-user-1 icon-round"></i>
                  </a>
                </li>

                <li class="submit-btn header-add-property-btn" style="">
                  <a
                    href="post-an-ad/index.php"
                    class="item-btn rt-animation-btn"
                  >
                    <span>
                      <i class="fas fa-plus-circle"></i>
                    </span>
                    <div class="btn-text">Add Property</div>
                  </a>
                </li>

                <li class="offcanvar_bar button" style="order: 99">
                  <span class="sidebarBtn">
                    <span class="fa fa-bars"> </span>
                  </span>
                </li>
              </ul>
            </div>
          </div>
        </div>

        <div class="rt-slide-nav">
          <div class="offscreen-navigation">
            <nav class="menu-main-navigation-container">
              <ul id="menu-main-navigation-1" class="menu">
                <li
                  class="menu-item menu-item-type-custom menu-item-object-custom current-menu-ancestor current-menu-parent menu-item-has-children menu-item-4356"
                >
                  <a href="#">Home</a>
                  <ul class="sub-menu">
                    <li
                      class="menu-item menu-item-type-post_type menu-item-object-page menu-item-home current-menu-item page_item page-item-3344 current_page_item menu-item-4358"
                    >
                      <a href="index.php" aria-current="page">Home 1</a>
                    </li>
                    <li
                      class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4359"
                    >
                      <a href="home-2/index.php">Home 2</a>
                    </li>
                    <li
                      class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4357"
                    >
                      <a href="home-3/index.php">Home 3</a>
                    </li>
                    <li
                      class="menu-item menu-item-type-post_type menu-item-object-page menu-item-7904"
                    >
                      <a href="home-4/index.php">Home 4</a>
                    </li>
                    <li
                      class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17181"
                    >
                      <a href="home-5/index.php">Home 5</a>
                    </li>
                    <li
                      class="menu-item menu-item-type-post_type menu-item-object-page menu-item-18057"
                    >
                      <a href="home-6/index.php">Home 6</a>
                    </li>
                  </ul>
                </li>
                <li
                  class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4132"
                >
                  <a href="about/index.php">About</a>
                </li>
                <li
                  class="mega-menu mega-menu-col-2 menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4386"
                >
                  <a href="#">Property</a>
                  <ul class="sub-menu">
                    <li
                      class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4387"
                    >
                      <a href="#">Column 1</a>
                      <ul class="sub-menu">
                        <li
                          class="menu-item menu-item-type-post_type_archive menu-item-object-rtcl_listing menu-item-9149"
                        >
                          <a href="all-properties/index.php"
                            >Properties Grid</a
                          >
                        </li>
                        <li
                          class="menu-item menu-item-type-post_type_archive menu-item-object-rtcl_listing menu-item-15637"
                        >
                          <a href="all-properties/indexd1fd.html?view=list"
                            >Properties List</a
                          >
                        </li>
                        <li
                          class="menu-item menu-item-type-post_type menu-item-object-page menu-item-16046"
                        >
                          <a href="listing-map/index.php"
                            >Properties Map Grid</a
                          >
                        </li>
                        <li
                          class="menu-item menu-item-type-post_type menu-item-object-page menu-item-16047"
                        >
                          <a href="listing-map/indexd1fd.html?view=list"
                            >Properties Map List</a
                          >
                        </li>
                      </ul>
                    </li>
                    <li
                      class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4391"
                    >
                      <a href="#">Column 2</a>
                      <ul class="sub-menu">
                        <li
                          class="menu-item menu-item-type-post_type_archive menu-item-object-rtcl_listing menu-item-15640"
                        >
                          <a
                            href="all-properties/index128e.html?layout=fullwidth"
                            >Properties Fullwidth</a
                          >
                        </li>
                        <li
                          class="menu-item menu-item-type-post_type menu-item-object-rtcl_listing menu-item-17444"
                        >
                          <a
                            href="property/triple-story-house-for-rent/index.php"
                            >Single Property &#8211; Default</a
                          >
                        </li>
                        <li
                          class="menu-item menu-item-type-post_type menu-item-object-rtcl_listing menu-item-17418"
                        >
                          <a
                            href="property/affordable-green-villa-house-for-rent/index.php"
                            >Single Property &#8211; Fullwidth</a
                          >
                        </li>
                        <li
                          class="menu-item menu-item-type-post_type menu-item-object-rtcl_listing menu-item-17445"
                        >
                          <a
                            href="property/sky-pool-villa-house-for-sale/index.php"
                            >Single Property &#8211; Grid</a
                          >
                        </li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <li
                  class="mega-menu mega-menu-col-2 menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4733"
                >
                  <a href="#">Pages</a>
                  <ul class="sub-menu">
                    <li
                      class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-17272"
                    >
                      <a href="#">Column</a>
                      <ul class="sub-menu">
                        <li
                          class="menu-item menu-item-type-post_type menu-item-object-page menu-item-15643"
                        >
                          <a href="agencies/index.php">Agencies</a>
                        </li>
                        <li
                          class="menu-item menu-item-type-post_type menu-item-object-page menu-item-17451"
                        >
                          <a href="agents/index.php">Agents</a>
                        </li>
                        <li
                          class="menu-item menu-item-type-post_type menu-item-object-rtcl_agent menu-item-17452"
                        >
                          <a href="agent/rosy_janner/index.php"
                            >Agent Details</a
                          >
                        </li>
                      </ul>
                    </li>
                    <li
                      class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-17273"
                    >
                      <a href="#">Column</a>
                      <ul class="sub-menu">
                        <li
                          class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8071"
                        >
                          <a href="pricing-table/index.php">Pricing Table</a>
                        </li>
                        <li
                          class="menu-item menu-item-type-custom menu-item-object-custom menu-item-4734"
                        >
                          <a href="error-404.html">404 Error</a>
                        </li>
                      </ul>
                    </li>
                  </ul>
                </li>
                <li
                  class="menu-item menu-item-type-custom menu-item-object-custom menu-item-has-children menu-item-4736"
                >
                  <a href="#">Blog</a>
                  <ul class="sub-menu">
                    <li
                      class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4615"
                    >
                      <a href="blog/index.php">Blog List</a>
                    </li>
                    <li
                      class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8849"
                    >
                      <a href="blog-grid/index.php">Blog Grid</a>
                    </li>
                    <li
                      class="menu-item menu-item-type-post_type menu-item-object-post menu-item-17271"
                    >
                      <a
                        href="develop-relationships-with-human-resource/index.php"
                        >Blog Details</a
                      >
                    </li>
                  </ul>
                </li>
                <li
                  class="menu-item menu-item-type-post_type menu-item-object-page menu-item-4735"
                >
                  <a href="contact/index.php">Contact</a>
                </li>
              </ul>
            </nav>
          </div>
        </div>
      </div>
      <div id="content" class="site-content">
        <div id="primary" class="elementor-page-content">
          <div
            data-elementor-type="wp-page"
            data-elementor-id="3344"
            class="elementor elementor-3344"
          >
            <section
              class="elementor-section elementor-top-section elementor-element elementor-element-014c6b6 elementor-section-height-min-height elementor-section-boxed elementor-section-height-default elementor-section-items-middle rt-parallax-bg-no"
              data-id="014c6b6"
              data-element_type="section"
              data-settings='{"background_background":"classic","shape_divider_bottom":"curve","shape_divider_bottom_negative":"yes"}'
            >
              <div
                class="elementor-shape elementor-shape-bottom"
                data-negative="true"
              >
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 1000 100"
                  preserveAspectRatio="none"
                >
                  <path
                    class="elementor-shape-fill"
                    d="M500,97C126.7,96.3,0.8,19.8,0,0v100l1000,0V1C1000,19.4,873.3,97.8,500,97z"
                  />
                </svg>
              </div>
              <div class="elementor-container elementor-column-gap-default">
                <div
                  class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-d7d78ae"
                  data-id="d7d78ae"
                  data-element_type="column"
                  data-settings='{"background_background":"classic","animation":"none"}'
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-55c01b7 elementor-invisible elementor-widget elementor-widget-rt-title"
                      data-id="55c01b7"
                      data-element_type="widget"
                      data-settings='{"_animation":"fadeInUp","_animation_delay":400}'
                      data-widget_type="rt-title.default"
                    >
                      <div class="elementor-widget-container">
                        <div class="section-title-wrapper">
                          <!--Background Title-->

                          <div class="title-inner-wrapper">
                            <!--Top Sub Title-->

                            <!--Main Title-->
                            <h1 class="main-title">
                              Find the perfect place to <br />
                              Live with your family
                            </h1>

                            <!--Description-->
                          </div>
                        </div>
                      </div>
                    </div>
<!--                    <div
                      class="elementor-element elementor-element-2d71612 elementor-invisible elementor-widget elementor-widget-wp-widget-homlisti_advanced_search"
                      data-id="2d71612"
                      data-element_type="widget"
                      data-settings='{"_animation":"fadeInUp","_animation_delay":700}'
                      data-widget_type="wp-widget-homlisti_advanced_search.default"
                    >
                      <div class="elementor-widget-container">
                        <div
                          class="orientation-vertical advanced-search-banner custom-bg home1"
                        >
                          <div class="banner-box banner-layout-home1">
                            <form
                              action="index.php"
                              class="advance-search-form rtcl-widget-search-form"
                              data-min-price="0"
                              data-max-price="5000"
                            >
                              <div class="listing-category-list">
                                <div
                                  class="search-item rtin-category search-radio search-radio-check rtcl-category-ajax"
                                >
                                  <ul class="list-inline">
                                    <li class="apartments" data-category="112">
                                      <label for="apartments" class="">
                                        <i
                                          class="rtcl-icon rtcl-icon-building"
                                        ></i>
                                        <span>Apartments</span>
                                        <input
                                          type="radio"
                                          name="rtcl_category"
                                          id="apartments"
                                          value="apartments"
                                        />
                                      </label>
                                    </li>
                                    <li class="commercial" data-category="126">
                                      <label for="commercial" class="">
                                        <i class="rtcl-icon rtcl-icon-bank"></i>
                                        <span>Commercial</span>
                                        <input
                                          type="radio"
                                          name="rtcl_category"
                                          id="commercial"
                                          value="commercial"
                                        />
                                      </label>
                                    </li>
                                    <li class="office" data-category="162">
                                      <label for="office" class="">
                                        <i
                                          class="rtcl-icon rtcl-icon-briefcase"
                                        ></i>
                                        <span>Office</span>
                                        <input
                                          type="radio"
                                          name="rtcl_category"
                                          id="office"
                                          value="office"
                                        />
                                      </label>
                                    </li>
                                    <li class="restaurant" data-category="204">
                                      <label for="restaurant" class="">
                                        <i class="rtcl-icon rtcl-icon-food"></i>
                                        <span>Restaurant</span>
                                        <input
                                          type="radio"
                                          name="rtcl_category"
                                          id="restaurant"
                                          value="restaurant"
                                        />
                                      </label>
                                    </li>
                                    <li class="studio-home" data-category="203">
                                      <label for="studio-home" class="">
                                        <i
                                          class="rtcl-icon rtcl-icon- flaticon-home"
                                        ></i>
                                        <span>Studio Home</span>
                                        <input
                                          type="radio"
                                          name="rtcl_category"
                                          id="studio-home"
                                          value="studio-home"
                                        />
                                      </label>
                                    </li>
                                    <li class="villa" data-category="75">
                                      <label for="villa" class="">
                                        <i
                                          class="rtcl-icon rtcl-icon-building-filled"
                                        ></i>
                                        <span>Villa</span>
                                        <input
                                          type="radio"
                                          name="rtcl_category"
                                          id="villa"
                                          value="villa"
                                        />
                                      </label>
                                    </li>
                                  </ul>
                                </div>
                              </div>-->

<!--                              <div class="search-box">
                                <div
                                  class="search-item search-keyword search-select"
                                >
                                  <div class="input-group">
                                    <input
                                      type="text"
                                      data-type="listing"
                                      name="s"
                                      class="rtcl-autocomplete form-control"
                                      placeholder="Enter Keyword here ..."
                                      value=""
                                    />
                                  </div>
                                </div>-->

<!--                                <div class="search-item search-select">
                                  <select
                                    class="select2"
                                    name="filters[ad_type]"
                                    data-placeholder="Select Type"
                                  >
                                    <option value="">Select Type</option>
                                    <option value="sell">Sell</option>
                                    <option value="buy">Buy</option>
                                    <option value="rent">Rent</option>
                                  </select>
                                </div>-->

<!--                                <div
                                  class="search-item search-select rtin-location"
                                >
                                   
                                    
                                    <select 
                                    id="rtcl-location-search-2813977249"
                                    class="select2 rtcl-location-search" name="cid" id="category" required>
                                        <option value="" disabled selected>Select Category</option>
                                        <?php
//                                        $conn = mysqli_connect("localhost", "root", "", "house_rental");
//                                        if (!$conn) {
//                                            die("Connection failed: " . mysqli_connect_error());
//                                        }
//                                        $sql = "SELECT id, cname FROM tblcategory";
//                                        $result = mysqli_query($conn, $sql);
//                                        while ($row = mysqli_fetch_assoc($result)) {
//                                            echo "<option value='" . $row['id'] . "'>" . htmlspecialchars($row['cname']) . "</option>";
//                                        }
//                                        mysqli_close($conn);
                                        ?>
                                    </select>
                                
                                </div>

                                <div class="search-item search-btn">
                                  <button
                                    class="advanced-btn collapsed"
                                    type="button"
                                  >
                                    <i class="fas fa-sliders-h"></i>
                                  </button>
                                  <button type="submit" class="submit-btn">
                                    Search
                                  </button>
                                </div>
                              </div>-->
<!--                              <div
                                class="advanced-search-box"
                                id="advanced-search"
                              >
                                <div
                                  class="advanced-box advanced-banner-box rtcl_cf_by_category_html"
                                  data-price-search="yes"
                                >
                                  <div class="search-item checkbox-wrapper">
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        id="rtcl_checkbox_4216tv-cable"
                                        type="checkbox"
                                        name="filters[_field_4216][]"
                                        value="tv-cable"
                                      /><label
                                        class="form-check-label"
                                        for="rtcl_checkbox_4216tv-cable"
                                        >TV Cable</label
                                      >
                                    </div>
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        id="rtcl_checkbox_4216air-conditioning"
                                        type="checkbox"
                                        name="filters[_field_4216][]"
                                        value="air-conditioning"
                                      /><label
                                        class="form-check-label"
                                        for="rtcl_checkbox_4216air-conditioning"
                                        >Air Conditioning</label
                                      >
                                    </div>
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        id="rtcl_checkbox_4216barbeque"
                                        type="checkbox"
                                        name="filters[_field_4216][]"
                                        value="barbeque"
                                      /><label
                                        class="form-check-label"
                                        for="rtcl_checkbox_4216barbeque"
                                        >Barbeque</label
                                      >
                                    </div>
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        id="rtcl_checkbox_4216gym"
                                        type="checkbox"
                                        name="filters[_field_4216][]"
                                        value="gym"
                                      /><label
                                        class="form-check-label"
                                        for="rtcl_checkbox_4216gym"
                                        >Gym</label
                                      >
                                    </div>
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        id="rtcl_checkbox_4216swimming-pool"
                                        type="checkbox"
                                        name="filters[_field_4216][]"
                                        value="swimming-pool"
                                      /><label
                                        class="form-check-label"
                                        for="rtcl_checkbox_4216swimming-pool"
                                        >Swimming Pool</label
                                      >
                                    </div>
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        id="rtcl_checkbox_4216laundry"
                                        type="checkbox"
                                        name="filters[_field_4216][]"
                                        value="laundry"
                                      /><label
                                        class="form-check-label"
                                        for="rtcl_checkbox_4216laundry"
                                        >Laundry</label
                                      >
                                    </div>
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        id="rtcl_checkbox_4216microwave"
                                        type="checkbox"
                                        name="filters[_field_4216][]"
                                        value="microwave"
                                      /><label
                                        class="form-check-label"
                                        for="rtcl_checkbox_4216microwave"
                                        >Microwave</label
                                      >
                                    </div>
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        id="rtcl_checkbox_4216outdoor-shower"
                                        type="checkbox"
                                        name="filters[_field_4216][]"
                                        value="outdoor-shower"
                                      /><label
                                        class="form-check-label"
                                        for="rtcl_checkbox_4216outdoor-shower"
                                        >Outdoor Shower</label
                                      >
                                    </div>
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        id="rtcl_checkbox_4216lawn"
                                        type="checkbox"
                                        name="filters[_field_4216][]"
                                        value="lawn"
                                      /><label
                                        class="form-check-label"
                                        for="rtcl_checkbox_4216lawn"
                                        >Lawn</label
                                      >
                                    </div>
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        id="rtcl_checkbox_4216refrigerator"
                                        type="checkbox"
                                        name="filters[_field_4216][]"
                                        value="refrigerator"
                                      /><label
                                        class="form-check-label"
                                        for="rtcl_checkbox_4216refrigerator"
                                        >Refrigerator</label
                                      >
                                    </div>
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        id="rtcl_checkbox_4216sauna"
                                        type="checkbox"
                                        name="filters[_field_4216][]"
                                        value="sauna"
                                      /><label
                                        class="form-check-label"
                                        for="rtcl_checkbox_4216sauna"
                                        >Sauna</label
                                      >
                                    </div>
                                    <div class="form-check">
                                      <input
                                        class="form-check-input"
                                        id="rtcl_checkbox_4216washer"
                                        type="checkbox"
                                        name="filters[_field_4216][]"
                                        value="washer"
                                      /><label
                                        class="form-check-label"
                                        for="rtcl_checkbox_4216washer"
                                        >Washer</label
                                      >
                                    </div>
                                  </div>
                                  <div class="search-item search-select">
                                    <select
                                      name="filters[_field_4316]"
                                      id="rtcl_select_4316639695203"
                                      data-placeholder="Bedroom"
                                      class="select2"
                                    >
                                      <option value="">Bedroom</option>
                                      <option value="1">1</option>
                                      <option value="2">2</option>
                                      <option value="3">3</option>
                                      <option value="4">4</option>
                                      <option value="5">5</option>
                                      <option value="6">6</option>
                                    </select>
                                  </div>
                                  <div class="search-item search-select">
                                    <select
                                      name="filters[_field_4321]"
                                      id="rtcl_select_43213339555458"
                                      data-placeholder="Bath"
                                      class="select2"
                                    >
                                      <option value="">Bath</option>
                                      <option value="1">1</option>
                                      <option value="2">2</option>
                                      <option value="3">3</option>
                                      <option value="4">4</option>
                                    </select>
                                  </div>
                                  <div class="search-item">
                                    <div class="price-range">
                                      <label>Sqft</label>
                                      <input
                                        type="number"
                                        class="ion-rangeslider"
                                        id="rtcl_number_4317"
                                        data-step="any"
                                        data-min="0"
                                        data-max="100000"
                                      />
                                      <input
                                        type="hidden"
                                        class="min-volumn"
                                        name="filters[_field_4317][min]"
                                        value=""
                                      /><input
                                        type="hidden"
                                        class="max-volumn"
                                        name="filters[_field_4317][max]"
                                        value=""
                                      />
                                    </div>
                                  </div>
                                  <div class="search-item">
                                    <div class="price-range">
                                      <label>Price</label>
                                      <input
                                        type="number"
                                        class="ion-rangeslider"
                                        data-prefix="&#036;"
                                        data-min="0"
                                        data-max="5000"
                                      />
                                      <input
                                        type="hidden"
                                        class="min-volumn"
                                        name="filters[price][min]"
                                        value=""
                                      />
                                      <input
                                        type="hidden"
                                        class="max-volumn"
                                        name="filters[price][max]"
                                        value=""
                                      />
                                    </div>
                                  </div>
                                </div>
                              </div>-->
                            </form>
                          </div>
                        </div>
                      </div>
                    </div>
                    <section
                      class="elementor-section elementor-inner-section elementor-element elementor-element-888bb94 elementor-section-boxed elementor-section-height-default elementor-section-height-default rt-parallax-bg-no"
                      data-id="888bb94"
                      data-element_type="section"
                    >
                      <div
                        class="elementor-container elementor-column-gap-default"
                      >
                        <div
                          class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-b9d8f1b elementor-invisible"
                          data-id="b9d8f1b"
                          data-element_type="column"
                          data-settings='{"animation":"fadeInUp","animation_delay":800}'
                        >
                          <div
                            class="elementor-widget-wrap elementor-element-populated"
                          >
                            <div
                              class="elementor-element elementor-element-d28a46b elementor-widget__width-auto elementor-widget elementor-widget-heading"
                              data-id="d28a46b"
                              data-element_type="widget"
                              data-widget_type="heading.default"
                            >
                              <div class="elementor-widget-container">
                                <h2
                                  class="elementor-heading-title elementor-size-default"
                                >
                                  We’ve more than
                                  <strong>54,000</strong> apartments, place &
                                  plot.​
                                </h2>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                  </div>
                </div>
              </div>
            </section>
<!--            <section
              class="elementor-section elementor-top-section elementor-element elementor-element-ba0d1ce elementor-section-content-middle elementor-section-boxed elementor-section-height-default elementor-section-height-default rt-parallax-bg-no"
              data-id="ba0d1ce"
              data-element_type="section"
            >
              <div class="elementor-container elementor-column-gap-default">
                <div
                  class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-c2e8ff4"
                  data-id="c2e8ff4"
                  data-element_type="column"
                >-->
<!--                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-49ebbc6 elementor-invisible elementor-widget elementor-widget-rt-title"
                      data-id="49ebbc6"
                      data-element_type="widget"
                      data-settings='{"_animation":"fadeInUp","_animation_delay":100}'
                      data-widget_type="rt-title.default"
                    >
                      <div class="elementor-widget-container">
                        <div class="section-title-wrapper">
                          Background Title

                          <div class="title-inner-wrapper">
                            Top Sub Title
                            <div class="top-sub-title-wrap">
                              <span class="top-sub-title">
                                <i
                                  style="margin-right: 5px"
                                  class="fa fa-circle"
                                  aria-hidden="true"
                                ></i
                                >Our Clients
                              </span>
                            </div>

                            Main Title
                            <h2 class="main-title">
                              We're going to became <br />
                              partners for the long run
                            </h2>

                            Description
                            <div class="description">
                              <p>
                                Ghen an unknown printer took a galley of type
                                andscr ambledit to make a type specimen book has
                                survived not only five centuries but also.
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="elementor-column elementor-col-66 elementor-top-column elementor-element elementor-element-a603685 elementor-invisible"
                  data-id="a603685"
                  data-element_type="column"
                  data-settings='{"animation":"fadeInUp","animation_delay":100}'
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-27b92ae gallery-spacing-custom rt-client-logo elementor-widget elementor-widget-image-gallery"
                      data-id="27b92ae"
                      data-element_type="widget"
                      data-settings='{"_animation":"none","_animation_delay":200}'
                      data-widget_type="image-gallery.default"
                    >
                      <div class="elementor-widget-container">
                        <div class="elementor-image-gallery">
                          <div
                            id="gallery-1"
                            class="gallery galleryid-3344 gallery-columns-3 gallery-size-full"
                          >
                            <figure class="gallery-item">
                              <div class="gallery-icon landscape">
                                <a
                                  data-elementor-open-lightbox="yes"
                                  data-elementor-lightbox-slideshow="27b92ae"
                                  data-elementor-lightbox-title="client-logo-6"
                                  data-e-action-hash="#elementor-action%3Aaction%3Dlightbox%26settings%3DeyJpZCI6MTY4MTksInVybCI6Imh0dHBzOlwvXC93d3cucmFkaXVzdGhlbWUuY29tXC9kZW1vXC93b3JkcHJlc3NcL3RoZW1lc1wvaG9tbGlzdGlcL3dwLWNvbnRlbnRcL3VwbG9hZHNcLzIwMjFcLzEwXC9jbGllbnQtbG9nby02LnN2ZyIsInNsaWRlc2hvdyI6IjI3YjkyYWUifQ%3D%3D"
                                  href="wp-content/uploads/2021/10/client-logo-6.svg"
                                  ><img
                                    decoding="async"
                                    width="200"
                                    height="117"
                                    src="wp-content/uploads/2021/10/client-logo-6.svg"
                                    class="attachment-full size-full"
                                    alt=""
                                    title=""
                                /></a>
                              </div>
                            </figure>
                            <figure class="gallery-item">
                              <div class="gallery-icon landscape">
                                <a
                                  data-elementor-open-lightbox="yes"
                                  data-elementor-lightbox-slideshow="27b92ae"
                                  data-elementor-lightbox-title="client-logo-5"
                                  data-e-action-hash="#elementor-action%3Aaction%3Dlightbox%26settings%3DeyJpZCI6MTY4MTgsInVybCI6Imh0dHBzOlwvXC93d3cucmFkaXVzdGhlbWUuY29tXC9kZW1vXC93b3JkcHJlc3NcL3RoZW1lc1wvaG9tbGlzdGlcL3dwLWNvbnRlbnRcL3VwbG9hZHNcLzIwMjFcLzEwXC9jbGllbnQtbG9nby01LnN2ZyIsInNsaWRlc2hvdyI6IjI3YjkyYWUifQ%3D%3D"
                                  href="wp-content/uploads/2021/10/client-logo-5.svg"
                                  ><img
                                    loading="lazy"
                                    decoding="async"
                                    width="200"
                                    height="117"
                                    src="wp-content/uploads/2021/10/client-logo-5.svg"
                                    class="attachment-full size-full"
                                    alt=""
                                    title=""
                                /></a>
                              </div>
                            </figure>
                            <figure class="gallery-item">
                              <div class="gallery-icon landscape">
                                <a
                                  data-elementor-open-lightbox="yes"
                                  data-elementor-lightbox-slideshow="27b92ae"
                                  data-elementor-lightbox-title="client-logo-4"
                                  data-e-action-hash="#elementor-action%3Aaction%3Dlightbox%26settings%3DeyJpZCI6MTY4MTcsInVybCI6Imh0dHBzOlwvXC93d3cucmFkaXVzdGhlbWUuY29tXC9kZW1vXC93b3JkcHJlc3NcL3RoZW1lc1wvaG9tbGlzdGlcL3dwLWNvbnRlbnRcL3VwbG9hZHNcLzIwMjFcLzEwXC9jbGllbnQtbG9nby00LnN2ZyIsInNsaWRlc2hvdyI6IjI3YjkyYWUifQ%3D%3D"
                                  href="wp-content/uploads/2021/10/client-logo-4.svg"
                                  ><img
                                    loading="lazy"
                                    decoding="async"
                                    width="200"
                                    height="117"
                                    src="wp-content/uploads/2021/10/client-logo-4.svg"
                                    class="attachment-full size-full"
                                    alt=""
                                    title=""
                                /></a>
                              </div>
                            </figure>
                            <figure class="gallery-item">
                              <div class="gallery-icon landscape">
                                <a
                                  data-elementor-open-lightbox="yes"
                                  data-elementor-lightbox-slideshow="27b92ae"
                                  data-elementor-lightbox-title="client-logo-3"
                                  data-e-action-hash="#elementor-action%3Aaction%3Dlightbox%26settings%3DeyJpZCI6MTY4MTYsInVybCI6Imh0dHBzOlwvXC93d3cucmFkaXVzdGhlbWUuY29tXC9kZW1vXC93b3JkcHJlc3NcL3RoZW1lc1wvaG9tbGlzdGlcL3dwLWNvbnRlbnRcL3VwbG9hZHNcLzIwMjFcLzEwXC9jbGllbnQtbG9nby0zLnN2ZyIsInNsaWRlc2hvdyI6IjI3YjkyYWUifQ%3D%3D"
                                  href="wp-content/uploads/2021/10/client-logo-3.svg"
                                  ><img
                                    loading="lazy"
                                    decoding="async"
                                    width="200"
                                    height="117"
                                    src="wp-content/uploads/2021/10/client-logo-3.svg"
                                    class="attachment-full size-full"
                                    alt=""
                                    title=""
                                /></a>
                              </div>
                            </figure>
                            <figure class="gallery-item">
                              <div class="gallery-icon landscape">
                                <a
                                  data-elementor-open-lightbox="yes"
                                  data-elementor-lightbox-slideshow="27b92ae"
                                  data-elementor-lightbox-title="client-logo-2"
                                  data-e-action-hash="#elementor-action%3Aaction%3Dlightbox%26settings%3DeyJpZCI6MTY4MTUsInVybCI6Imh0dHBzOlwvXC93d3cucmFkaXVzdGhlbWUuY29tXC9kZW1vXC93b3JkcHJlc3NcL3RoZW1lc1wvaG9tbGlzdGlcL3dwLWNvbnRlbnRcL3VwbG9hZHNcLzIwMjFcLzEwXC9jbGllbnQtbG9nby0yLnN2ZyIsInNsaWRlc2hvdyI6IjI3YjkyYWUifQ%3D%3D"
                                  href="wp-content/uploads/2021/10/client-logo-2.svg"
                                  ><img
                                    loading="lazy"
                                    decoding="async"
                                    width="200"
                                    height="117"
                                    src="wp-content/uploads/2021/10/client-logo-2.svg"
                                    class="attachment-full size-full"
                                    alt=""
                                    title=""
                                /></a>
                              </div>
                            </figure>
                            <figure class="gallery-item">
                              <div class="gallery-icon landscape">
                                <a
                                  data-elementor-open-lightbox="yes"
                                  data-elementor-lightbox-slideshow="27b92ae"
                                  data-elementor-lightbox-title="client-logo-1"
                                  data-e-action-hash="#elementor-action%3Aaction%3Dlightbox%26settings%3DeyJpZCI6MTY4MTQsInVybCI6Imh0dHBzOlwvXC93d3cucmFkaXVzdGhlbWUuY29tXC9kZW1vXC93b3JkcHJlc3NcL3RoZW1lc1wvaG9tbGlzdGlcL3dwLWNvbnRlbnRcL3VwbG9hZHNcLzIwMjFcLzEwXC9jbGllbnQtbG9nby0xLnN2ZyIsInNsaWRlc2hvdyI6IjI3YjkyYWUifQ%3D%3D"
                                  href="wp-content/uploads/2021/10/client-logo-1.svg"
                                  ><img
                                    loading="lazy"
                                    decoding="async"
                                    width="200"
                                    height="117"
                                    src="wp-content/uploads/2021/10/client-logo-1.svg"
                                    class="attachment-full size-full"
                                    alt=""
                                    title=""
                                /></a>
                              </div>
                            </figure>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <section
              class="elementor-section elementor-top-section elementor-element elementor-element-111372a elementor-section-boxed elementor-section-height-default elementor-section-height-default rt-parallax-bg-no"
              data-id="111372a"
              data-element_type="section"
              data-settings='{"background_background":"classic"}'
            >
              <div class="elementor-container elementor-column-gap-default">
                <div
                  class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-3bcf642"
                  data-id="3bcf642"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <section
                      class="elementor-section elementor-inner-section elementor-element elementor-element-b6af248 elementor-section-boxed elementor-section-height-default elementor-section-height-default rt-parallax-bg-no"
                      data-id="b6af248"
                      data-element_type="section"
                    >
                      <div
                        class="elementor-container elementor-column-gap-default"
                      >
                        <div
                          class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-1509ca9"
                          data-id="1509ca9"
                          data-element_type="column"
                        >
                          <div
                            class="elementor-widget-wrap elementor-element-populated"
                          >
                            <div
                              class="elementor-element elementor-element-59da1ee elementor-widget elementor-widget-rt-title"
                              data-id="59da1ee"
                              data-element_type="widget"
                              data-widget_type="rt-title.default"
                            >
                              <div class="elementor-widget-container">
                                <div class="section-title-wrapper">
                                  Background Title
                                  <div class="bg-title-wrap">
                                    <span class="background-title solid">
                                      Properties
                                    </span>
                                  </div>

                                  <div class="title-inner-wrapper">
                                    Top Sub Title
                                    <div class="top-sub-title-wrap">
                                      <span class="top-sub-title">
                                        <i
                                          style="margin-right: 5px"
                                          class="fa fa-circle"
                                          aria-hidden="true"
                                        ></i
                                        >Our PROPERTIES
                                      </span>
                                    </div>

                                    Main Title
                                    <h2 class="main-title">
                                      Latest Properties
                                    </h2>

                                    Description
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div
                          class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-45ba17c elementor-hidden-tablet elementor-hidden-phone"
                          data-id="45ba17c"
                          data-element_type="column"
                        >
                          <div class="elementor-widget-wrap"></div>
                        </div>
                      </div>
                    </section>
                    <div
                      class="elementor-element elementor-element-c0e24d4 is-price-range-hide label_position_thumb listing-border-radius-enable listing-title-wrap-enable elementor-invisible elementor-widget elementor-widget-rt-properties-type-tab"
                      data-id="c0e24d4"
                      data-element_type="widget"
                      data-settings='{"_animation":"fadeInUp"}'
                      data-widget_type="rt-properties-type-tab.default"
                    >
                      <div class="elementor-widget-container">
                        <div
                          class="rt-el-listing-wrapper isotope-wrap product-grid style3 has-listing-footer visible"
                          id="inner-isotope"
                        >
                          <div class="filter-wrapper">
                            <div class="isotope-classes-tab">
                              <a
                                class="nav-item"
                                data-filter=".rent172190245699"
                                >Rent</a
                              >
                            </div>
                          </div>

                          <div class="row featuredContainer">
                            <div
                              class="col-lg-4 col-md-6 col-sm-12 sell172190245699"
                            >
                              <div class="product-box style2">
                                <div class="product-thumb">
                                  <a
                                    href="property/countryside-modern-lake-view-restaurant/index.php"
                                    ><img
                                      loading="lazy"
                                      decoding="async"
                                      width="400"
                                      height="240"
                                      src="wp-content/uploads/classified-listing/2022/03/mike_hussy4-400x240.jpg"
                                      class="rtcl-thumbnail"
                                      alt="mike_hussy4"
                                      title=""
                                  /></a>

                                  <div class="product-type">
                                    <span class="listing-type-badge">
                                      For Sell
                                    </span>
                                  </div>

                                  <div class="rtcl-listing-badge-wrap">
                                    <span
                                      class="badge rtcl-badge-popular popular-badge badge-success"
                                      >Popular</span
                                    ><span class="badge rtcl-badge-_top"
                                      >Top</span
                                    >
                                  </div>

                                  <div class="product-price">
                                    <div class="rtcl-price price-type-fixed">
                                      <span class="rtcl-price-amount amount"
                                        ><bdi
                                          ><span
                                            class="rtcl-price-currencySymbol"
                                            >&#36;</span
                                          >50<span class="price-shorthand"
                                            >K</span
                                          ></bdi
                                        ></span
                                      >
                                    </div>
                                  </div>

                                  <div class="listing-action">
                                    <a
                                      href="javascript:void(0)"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      data-original-title="Favourites"
                                      class="rtcl-require-login"
                                      ><i
                                        class="rtcl-icon rtcl-icon-heart-empty"
                                      ></i
                                      ><span class="favourite-label"></span
                                    ></a>
                                    <a
                                      class="rtcl-compare"
                                      href="#"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      title=""
                                      data-original-title="Compare"
                                      data-listing_id="17389"
                                    >
                                      <i
                                        class="flaticon-left-and-right-arrows"
                                      ></i>
                                    </a>

                                    <a
                                      class="rtcl-quick-view"
                                      href="#"
                                      title="Quick View"
                                      data-listing_id="17389"
                                    >
                                      <i
                                        class="rtcl-icon rtcl-icon-zoom-in"
                                      ></i>
                                    </a>
                                  </div>
                                </div>
                                <div class="product-content">
                                  <div class="product-top-content">
                                    <div class="product-category">
                                      <a
                                        href="listing-category/commercial/index.php"
                                        >Commercial</a
                                      >
                                    </div>
                                    <h3 class="item-title rt-main-title">
                                      <a
                                        href="property/countryside-modern-lake-view-restaurant/index.php"
                                      >
                                        Countryside Modern Lake View Restaurant
                                      </a>
                                    </h3>

                                    <ul class="entry-meta">
                                      <li>
                                        <i class="fas fa-map-marker-alt"></i
                                        ><a
                                          href="listing-location/new-jersey/index.php"
                                          >New Jersey</a
                                        >
                                      </li>
                                    </ul>

                                    <div class="list-information space-between">
                                      <ul class="product-features">
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-bed"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Beds </span>

                                            <span class="value">
                                              <span>0</span>4
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-shower"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Baths </span>

                                            <span class="value">
                                              <span>0</span>2
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-full-size"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> </span>

                                            <span class="value"> 2000 </span>

                                            <span class="suffix"> Sqft </span>
                                          </span>
                                        </li>
                                      </ul>
                                    </div>
                                  </div>

                                  <div class="product-bottom-content">
                                    <ul>
                                      <li class="item-author">
                                        <div class="media">
                                          <div class="item-img">
                                            <img
                                              loading="lazy"
                                              decoding="async"
                                              width="40"
                                              height="40"
                                              src="wp-content/uploads/classified-listing/2022/03/tom_steven-150x150.jpg"
                                              class="attachment-40x40 size-40x40"
                                              alt=""
                                              title=""
                                            />
                                          </div>
                                          <div class="media-body">
                                            <div class="item-title">
                                              <span>By</span>
                                              <a
                                                class="author-link"
                                                href="agent/tom_steven/index.php"
                                              >
                                                Tom Steven
                                              </a>
                                            </div>
                                          </div>
                                        </div>
                                      </li>
                                      <li class="action-btn">
                                        <a
                                          class="btn btn-primary"
                                          href="property/countryside-modern-lake-view-restaurant/index.php"
                                        >
                                          Details
                                        </a>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div
                              class="col-lg-4 col-md-6 col-sm-12 sell172190245699"
                            >
                              <div class="product-box style2">
                                <div class="product-thumb">
                                  <a
                                    href="property/gorgeous-apartment-building/index.php"
                                    ><img
                                      loading="lazy"
                                      decoding="async"
                                      width="400"
                                      height="240"
                                      src="wp-content/uploads/classified-listing/2022/03/david_lee9-400x240.jpg"
                                      class="rtcl-thumbnail"
                                      alt="david_lee9"
                                      title=""
                                  /></a>

                                  <div class="product-type">
                                    <span class="listing-type-badge">
                                      For Sell
                                    </span>
                                  </div>

                                  <div class="rtcl-listing-badge-wrap">
                                    <span
                                      class="badge rtcl-badge-popular popular-badge badge-success"
                                      >Popular</span
                                    >
                                  </div>

                                  <div class="product-price">
                                    <div class="rtcl-price price-type-fixed">
                                      <span class="rtcl-price-amount amount"
                                        ><bdi
                                          ><span
                                            class="rtcl-price-currencySymbol"
                                            >&#36;</span
                                          >1,000,000</bdi
                                        ></span
                                      ><span class="rtcl-price-meta"
                                        ><span
                                          class="rtcl-price-unit-label rtcl-price-unit-total"
                                          >total</span
                                        ></span
                                      >
                                    </div>
                                  </div>

                                  <div class="listing-action">
                                    <a
                                      href="javascript:void(0)"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      data-original-title="Favourites"
                                      class="rtcl-require-login"
                                      ><i
                                        class="rtcl-icon rtcl-icon-heart-empty"
                                      ></i
                                      ><span class="favourite-label"></span
                                    ></a>
                                    <a
                                      class="rtcl-compare"
                                      href="#"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      title=""
                                      data-original-title="Compare"
                                      data-listing_id="17380"
                                    >
                                      <i
                                        class="flaticon-left-and-right-arrows"
                                      ></i>
                                    </a>

                                    <a
                                      class="rtcl-quick-view"
                                      href="#"
                                      title="Quick View"
                                      data-listing_id="17380"
                                    >
                                      <i
                                        class="rtcl-icon rtcl-icon-zoom-in"
                                      ></i>
                                    </a>
                                  </div>
                                </div>
                                <div class="product-content">
                                  <div class="product-top-content">
                                    <div class="product-category">
                                      <a
                                        href="listing-category/apartments/index.php"
                                        >Apartments</a
                                      >
                                    </div>
                                    <h3 class="item-title rt-main-title">
                                      <a
                                        href="property/gorgeous-apartment-building/index.php"
                                      >
                                        Gorgeous Apartment Building
                                      </a>
                                    </h3>

                                    <ul class="entry-meta">
                                      <li>
                                        <i class="fas fa-map-marker-alt"></i
                                        ><a
                                          href="listing-location/california/claremont/index.php"
                                          >Claremont</a
                                        ><span class="rtcl-delimiter">,</span>
                                        <a
                                          href="listing-location/california/index.php"
                                          >California</a
                                        >
                                      </li>
                                    </ul>

                                    <div class="list-information space-between">
                                      <ul class="product-features">
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-bed"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Beds </span>

                                            <span class="value">
                                              <span>0</span>6
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-shower"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Baths </span>

                                            <span class="value">
                                              <span>0</span>4
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-full-size"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> </span>

                                            <span class="value"> 3000 </span>

                                            <span class="suffix"> Sqft </span>
                                          </span>
                                        </li>
                                      </ul>
                                    </div>
                                  </div>

                                  <div class="product-bottom-content">
                                    <ul>
                                      <li class="item-author">
                                        <div class="media">
                                          <div class="item-img">
                                            <img
                                              loading="lazy"
                                              decoding="async"
                                              width="40"
                                              height="40"
                                              src="wp-content/uploads/classified-listing/2022/03/david_lee-150x150.jpg"
                                              class="attachment-40x40 size-40x40"
                                              alt=""
                                              title=""
                                            />
                                          </div>
                                          <div class="media-body">
                                            <div class="item-title">
                                              <span>By</span>
                                              <a
                                                class="author-link"
                                                href="agent/david_lee/index.php"
                                              >
                                                David Lee
                                              </a>
                                            </div>
                                          </div>
                                        </div>
                                      </li>
                                      <li class="action-btn">
                                        <a
                                          class="btn btn-primary"
                                          href="property/gorgeous-apartment-building/index.php"
                                        >
                                          Details
                                        </a>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div
                              class="col-lg-4 col-md-6 col-sm-12 sell172190245699"
                            >
                              <div class="product-box style2">
                                <div class="product-thumb">
                                  <a
                                    href="property/sky-pool-villa-house-for-sale/index.php"
                                    ><img
                                      loading="lazy"
                                      decoding="async"
                                      width="400"
                                      height="240"
                                      src="wp-content/uploads/classified-listing/2022/03/mike_hussy-400x240.jpg"
                                      class="rtcl-thumbnail"
                                      alt="mike_hussy"
                                      title=""
                                  /></a>

                                  <div class="product-type">
                                    <span class="listing-type-badge">
                                      For Sell
                                    </span>
                                  </div>

                                  <div class="rtcl-listing-badge-wrap">
                                    <span class="badge rtcl-badge-featured"
                                      >Featured</span
                                    ><span
                                      class="badge rtcl-badge-popular popular-badge badge-success"
                                      >Popular</span
                                    >
                                  </div>

                                  <div class="product-price">
                                    <div class="rtcl-price price-type-fixed">
                                      <span class="rtcl-price-amount amount"
                                        ><bdi
                                          ><span
                                            class="rtcl-price-currencySymbol"
                                            >&#36;</span
                                          >1,500</bdi
                                        ></span
                                      >
                                    </div>
                                  </div>

                                  <div class="listing-action">
                                    <a
                                      href="javascript:void(0)"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      data-original-title="Favourites"
                                      class="rtcl-require-login"
                                      ><i
                                        class="rtcl-icon rtcl-icon-heart-empty"
                                      ></i
                                      ><span class="favourite-label"></span
                                    ></a>
                                    <a
                                      class="rtcl-compare"
                                      href="#"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      title=""
                                      data-original-title="Compare"
                                      data-listing_id="17384"
                                    >
                                      <i
                                        class="flaticon-left-and-right-arrows"
                                      ></i>
                                    </a>

                                    <a
                                      class="rtcl-quick-view"
                                      href="#"
                                      title="Quick View"
                                      data-listing_id="17384"
                                    >
                                      <i
                                        class="rtcl-icon rtcl-icon-zoom-in"
                                      ></i>
                                    </a>
                                  </div>
                                </div>
                                <div class="product-content">
                                  <div class="product-top-content">
                                    <div class="product-category">
                                      <a
                                        href="listing-category/villa/index.php"
                                        >Villa</a
                                      >
                                    </div>
                                    <h3 class="item-title rt-main-title">
                                      <a
                                        href="property/sky-pool-villa-house-for-sale/index.php"
                                      >
                                        Sky Pool Villa House for Sale
                                      </a>
                                    </h3>

                                    <ul class="entry-meta">
                                      <li>
                                        <i class="fas fa-map-marker-alt"></i
                                        ><a
                                          href="listing-location/louisiana/index.php"
                                          >Louisiana</a
                                        >
                                      </li>
                                    </ul>

                                    <div class="list-information space-between">
                                      <ul class="product-features">
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-bed"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Beds </span>

                                            <span class="value">
                                              <span>0</span>3
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-shower"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Baths </span>

                                            <span class="value">
                                              <span>0</span>3
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-full-size"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> </span>

                                            <span class="value"> 1850 </span>

                                            <span class="suffix"> Sqft </span>
                                          </span>
                                        </li>
                                      </ul>
                                    </div>
                                  </div>

                                  <div class="product-bottom-content">
                                    <ul>
                                      <li class="item-author">
                                        <div class="media">
                                          <div class="item-img">
                                            <img
                                              loading="lazy"
                                              decoding="async"
                                              width="40"
                                              height="40"
                                              src="wp-content/uploads/classified-listing/2022/03/mike_hussy-1-150x150.jpg"
                                              class="attachment-40x40 size-40x40"
                                              alt=""
                                              title=""
                                            />
                                          </div>
                                          <div class="media-body">
                                            <div class="item-title">
                                              <span>By</span>
                                              <a
                                                class="author-link"
                                                href="agent/mike_hussy/index.php"
                                              >
                                                Mike Hussy
                                              </a>
                                            </div>
                                          </div>
                                        </div>
                                      </li>
                                      <li class="action-btn">
                                        <a
                                          class="btn btn-primary"
                                          href="property/sky-pool-villa-house-for-sale/index.php"
                                        >
                                          Details
                                        </a>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div
                              class="col-lg-4 col-md-6 col-sm-12 sell172190245699"
                            >
                              <div class="product-box style2">
                                <div class="product-thumb">
                                  <a
                                    href="property/the-most-luxurious-fitted-sells-properties/index.php"
                                    ><img
                                      loading="lazy"
                                      decoding="async"
                                      width="400"
                                      height="240"
                                      src="wp-content/uploads/classified-listing/2022/03/david_lee5-400x240.jpg"
                                      class="rtcl-thumbnail"
                                      alt="david_lee5"
                                      title=""
                                  /></a>

                                  <div class="product-type">
                                    <span class="listing-type-badge">
                                      For Sell
                                    </span>
                                  </div>

                                  <div class="rtcl-listing-badge-wrap">
                                    <span
                                      class="badge rtcl-badge-popular popular-badge badge-success"
                                      >Popular</span
                                    >
                                  </div>

                                  <div class="product-price">
                                    <div class="rtcl-price price-type-fixed">
                                      <span class="rtcl-price-amount amount"
                                        ><bdi
                                          ><span
                                            class="rtcl-price-currencySymbol"
                                            >&#36;</span
                                          >312,000</bdi
                                        ></span
                                      >
                                    </div>
                                  </div>

                                  <div class="listing-action">
                                    <a
                                      href="javascript:void(0)"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      data-original-title="Favourites"
                                      class="rtcl-require-login"
                                      ><i
                                        class="rtcl-icon rtcl-icon-heart-empty"
                                      ></i
                                      ><span class="favourite-label"></span
                                    ></a>
                                    <a
                                      class="rtcl-compare"
                                      href="#"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      title=""
                                      data-original-title="Compare"
                                      data-listing_id="17373"
                                    >
                                      <i
                                        class="flaticon-left-and-right-arrows"
                                      ></i>
                                    </a>

                                    <a
                                      class="rtcl-quick-view"
                                      href="#"
                                      title="Quick View"
                                      data-listing_id="17373"
                                    >
                                      <i
                                        class="rtcl-icon rtcl-icon-zoom-in"
                                      ></i>
                                    </a>
                                  </div>
                                </div>
                                <div class="product-content">
                                  <div class="product-top-content">
                                    <div class="product-category">
                                      <a
                                        href="listing-category/commercial/index.php"
                                        >Commercial</a
                                      >
                                    </div>
                                    <h3 class="item-title rt-main-title">
                                      <a
                                        href="property/the-most-luxurious-fitted-sells-properties/index.php"
                                      >
                                        The Most Luxurious Fitted Sells
                                        Properties
                                      </a>
                                    </h3>

                                    <ul class="entry-meta">
                                      <li>
                                        <i class="fas fa-map-marker-alt"></i
                                        ><a
                                          href="listing-location/california/claremont/index.php"
                                          >Claremont</a
                                        ><span class="rtcl-delimiter">,</span>
                                        <a
                                          href="listing-location/california/index.php"
                                          >California</a
                                        >
                                      </li>
                                    </ul>

                                    <div class="list-information space-between">
                                      <ul class="product-features">
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-bed"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Beds </span>

                                            <span class="value">
                                              <span>0</span>3
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-shower"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Baths </span>

                                            <span class="value">
                                              <span>0</span>2
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-full-size"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> </span>

                                            <span class="value"> 1800 </span>

                                            <span class="suffix"> Sqft </span>
                                          </span>
                                        </li>
                                      </ul>
                                    </div>
                                  </div>

                                  <div class="product-bottom-content">
                                    <ul>
                                      <li class="item-author">
                                        <div class="media">
                                          <div class="item-img">
                                            <img
                                              loading="lazy"
                                              decoding="async"
                                              width="40"
                                              height="40"
                                              src="wp-content/uploads/classified-listing/2022/03/david_lee-150x150.jpg"
                                              class="attachment-40x40 size-40x40"
                                              alt=""
                                              title=""
                                            />
                                          </div>
                                          <div class="media-body">
                                            <div class="item-title">
                                              <span>By</span>
                                              <a
                                                class="author-link"
                                                href="agent/david_lee/index.php"
                                              >
                                                David Lee
                                              </a>
                                            </div>
                                          </div>
                                        </div>
                                      </li>
                                      <li class="action-btn">
                                        <a
                                          class="btn btn-primary"
                                          href="property/the-most-luxurious-fitted-sells-properties/index.php"
                                        >
                                          Details
                                        </a>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div
                              class="col-lg-4 col-md-6 col-sm-12 sell172190245699"
                            >
                              <div class="product-box style2">
                                <div class="product-thumb">
                                  <a
                                    href="property/the-most-luxurious-office-for-sale/index.php"
                                    ><img
                                      loading="lazy"
                                      decoding="async"
                                      width="400"
                                      height="240"
                                      src="wp-content/uploads/classified-listing/2022/03/david_lee7-400x240.jpg"
                                      class="rtcl-thumbnail"
                                      alt="david_lee7"
                                      title=""
                                  /></a>

                                  <div class="product-type">
                                    <span class="listing-type-badge">
                                      For Sell
                                    </span>
                                  </div>

                                  <div class="rtcl-listing-badge-wrap">
                                    <span
                                      class="badge rtcl-badge-popular popular-badge badge-success"
                                      >Popular</span
                                    >
                                  </div>

                                  <div class="product-price">
                                    <div
                                      class="rtcl-price price-type-negotiable"
                                    >
                                      <span class="rtcl-price-amount amount"
                                        ><bdi
                                          ><span
                                            class="rtcl-price-currencySymbol"
                                            >&#36;</span
                                          >550,000</bdi
                                        ></span
                                      >
                                    </div>
                                  </div>

                                  <div class="listing-action">
                                    <a
                                      href="javascript:void(0)"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      data-original-title="Favourites"
                                      class="rtcl-require-login"
                                      ><i
                                        class="rtcl-icon rtcl-icon-heart-empty"
                                      ></i
                                      ><span class="favourite-label"></span
                                    ></a>
                                    <a
                                      class="rtcl-compare"
                                      href="#"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      title=""
                                      data-original-title="Compare"
                                      data-listing_id="17376"
                                    >
                                      <i
                                        class="flaticon-left-and-right-arrows"
                                      ></i>
                                    </a>

                                    <a
                                      class="rtcl-quick-view"
                                      href="#"
                                      title="Quick View"
                                      data-listing_id="17376"
                                    >
                                      <i
                                        class="rtcl-icon rtcl-icon-zoom-in"
                                      ></i>
                                    </a>
                                  </div>
                                </div>
                                <div class="product-content">
                                  <div class="product-top-content">
                                    <div class="product-category">
                                      <a
                                        href="listing-category/office/index.php"
                                        >Office</a
                                      >
                                    </div>
                                    <h3 class="item-title rt-main-title">
                                      <a
                                        href="property/the-most-luxurious-office-for-sale/index.php"
                                      >
                                        The Most Luxurious Office for sale
                                      </a>
                                    </h3>

                                    <ul class="entry-meta">
                                      <li>
                                        <i class="fas fa-map-marker-alt"></i
                                        ><a
                                          href="listing-location/california/claremont/index.php"
                                          >Claremont</a
                                        ><span class="rtcl-delimiter">,</span>
                                        <a
                                          href="listing-location/california/index.php"
                                          >California</a
                                        >
                                      </li>
                                    </ul>

                                    <div class="list-information space-between">
                                      <ul class="product-features">
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-bed"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Beds </span>

                                            <span class="value">
                                              <span>0</span>3
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-shower"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Baths </span>

                                            <span class="value">
                                              <span>0</span>2
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-full-size"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> </span>

                                            <span class="value"> 25000 </span>

                                            <span class="suffix"> Sqft </span>
                                          </span>
                                        </li>
                                      </ul>
                                    </div>
                                  </div>

                                  <div class="product-bottom-content">
                                    <ul>
                                      <li class="item-author">
                                        <div class="media">
                                          <div class="item-img">
                                            <img
                                              loading="lazy"
                                              decoding="async"
                                              width="40"
                                              height="40"
                                              src="wp-content/uploads/classified-listing/2022/03/david_lee-150x150.jpg"
                                              class="attachment-40x40 size-40x40"
                                              alt=""
                                              title=""
                                            />
                                          </div>
                                          <div class="media-body">
                                            <div class="item-title">
                                              <span>By</span>
                                              <a
                                                class="author-link"
                                                href="agent/david_lee/index.php"
                                              >
                                                David Lee
                                              </a>
                                            </div>
                                          </div>
                                        </div>
                                      </li>
                                      <li class="action-btn">
                                        <a
                                          class="btn btn-primary"
                                          href="property/the-most-luxurious-office-for-sale/index.php"
                                        >
                                          Details
                                        </a>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div
                              class="col-lg-4 col-md-6 col-sm-12 sell172190245699"
                            >
                              <div class="product-box style2">
                                <div class="product-thumb">
                                  <a
                                    href="property/three-bedrooms-room-luxurious-apartments/index.php"
                                    ><img
                                      loading="lazy"
                                      decoding="async"
                                      width="400"
                                      height="240"
                                      src="wp-content/uploads/classified-listing/2022/03/david_lee1-400x240.jpg"
                                      class="rtcl-thumbnail"
                                      alt="david_lee1"
                                      title=""
                                  /></a>

                                  <div class="product-type">
                                    <span class="listing-type-badge">
                                      For Sell
                                    </span>
                                  </div>

                                  <div class="rtcl-listing-badge-wrap"></div>

                                  <div class="product-price">
                                    <div class="rtcl-price price-type-fixed">
                                      <span class="rtcl-price-amount amount"
                                        ><bdi
                                          ><span
                                            class="rtcl-price-currencySymbol"
                                            >&#36;</span
                                          >300,000</bdi
                                        ></span
                                      >
                                    </div>
                                  </div>

                                  <div class="listing-action">
                                    <a
                                      href="javascript:void(0)"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      data-original-title="Favourites"
                                      class="rtcl-require-login"
                                      ><i
                                        class="rtcl-icon rtcl-icon-heart-empty"
                                      ></i
                                      ><span class="favourite-label"></span
                                    ></a>
                                    <a
                                      class="rtcl-compare"
                                      href="#"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      title=""
                                      data-original-title="Compare"
                                      data-listing_id="17362"
                                    >
                                      <i
                                        class="flaticon-left-and-right-arrows"
                                      ></i>
                                    </a>

                                    <a
                                      class="rtcl-quick-view"
                                      href="#"
                                      title="Quick View"
                                      data-listing_id="17362"
                                    >
                                      <i
                                        class="rtcl-icon rtcl-icon-zoom-in"
                                      ></i>
                                    </a>
                                  </div>
                                </div>
                                <div class="product-content">
                                  <div class="product-top-content">
                                    <div class="product-category">
                                      <a
                                        href="listing-category/commercial/index.php"
                                        >Commercial</a
                                      >
                                    </div>
                                    <h3 class="item-title rt-main-title">
                                      <a
                                        href="property/three-bedrooms-room-luxurious-apartments/index.php"
                                      >
                                        Three Bedrooms Room Luxurious Apartments
                                      </a>
                                    </h3>

                                    <ul class="entry-meta">
                                      <li>
                                        <i class="fas fa-map-marker-alt"></i
                                        ><a
                                          href="listing-location/california/claremont/index.php"
                                          >Claremont</a
                                        ><span class="rtcl-delimiter">,</span>
                                        <a
                                          href="listing-location/california/index.php"
                                          >California</a
                                        >
                                      </li>
                                    </ul>

                                    <div class="list-information space-between">
                                      <ul class="product-features">
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-bed"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Beds </span>

                                            <span class="value">
                                              <span>0</span>3
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-shower"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Baths </span>

                                            <span class="value">
                                              <span>0</span>3
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-full-size"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> </span>

                                            <span class="value"> 1800 </span>

                                            <span class="suffix"> Sqft </span>
                                          </span>
                                        </li>
                                      </ul>
                                    </div>
                                  </div>

                                  <div class="product-bottom-content">
                                    <ul>
                                      <li class="item-author">
                                        <div class="media">
                                          <div class="item-img">
                                            <img
                                              loading="lazy"
                                              decoding="async"
                                              width="40"
                                              height="40"
                                              src="wp-content/uploads/classified-listing/2022/03/david_lee-150x150.jpg"
                                              class="attachment-40x40 size-40x40"
                                              alt=""
                                              title=""
                                            />
                                          </div>
                                          <div class="media-body">
                                            <div class="item-title">
                                              <span>By</span>
                                              <a
                                                class="author-link"
                                                href="agent/david_lee/index.php"
                                              >
                                                David Lee
                                              </a>
                                            </div>
                                          </div>
                                        </div>
                                      </li>
                                      <li class="action-btn">
                                        <a
                                          class="btn btn-primary"
                                          href="property/three-bedrooms-room-luxurious-apartments/index.php"
                                        >
                                          Details
                                        </a>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div
                              class="col-lg-4 col-md-6 col-sm-12 buy172190245699"
                            >
                              <div class="product-box style2">
                                <div class="product-thumb">
                                  <a
                                    href="property/brand-new-shopping-mall-for-buy/index.php"
                                    ><img
                                      loading="lazy"
                                      decoding="async"
                                      width="400"
                                      height="240"
                                      src="wp-content/uploads/classified-listing/2022/03/robert_blue1-1-400x240.jpg"
                                      class="rtcl-thumbnail"
                                      alt="robert_blue1-1"
                                      title=""
                                  /></a>

                                  <div class="product-type">
                                    <span class="listing-type-badge">
                                      For Buy
                                    </span>
                                  </div>

                                  <div class="rtcl-listing-badge-wrap">
                                    <span
                                      class="badge rtcl-badge-popular popular-badge badge-success"
                                      >Popular</span
                                    >
                                  </div>

                                  <div class="product-price">
                                    <div
                                      class="rtcl-price price-type-negotiable"
                                    >
                                      <span class="rtcl-price-amount amount"
                                        ><bdi
                                          ><span
                                            class="rtcl-price-currencySymbol"
                                            >&#36;</span
                                          >30,000</bdi
                                        ></span
                                      ><span class="rtcl-price-meta"
                                        ><span
                                          class="rtcl-price-unit-label rtcl-price-unit-total"
                                          >total</span
                                        ></span
                                      >
                                    </div>
                                  </div>

                                  <div class="listing-action">
                                    <a
                                      href="javascript:void(0)"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      data-original-title="Favourites"
                                      class="rtcl-require-login"
                                      ><i
                                        class="rtcl-icon rtcl-icon-heart-empty"
                                      ></i
                                      ><span class="favourite-label"></span
                                    ></a>
                                    <a
                                      class="rtcl-compare"
                                      href="#"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      title=""
                                      data-original-title="Compare"
                                      data-listing_id="17438"
                                    >
                                      <i
                                        class="flaticon-left-and-right-arrows"
                                      ></i>
                                    </a>

                                    <a
                                      class="rtcl-quick-view"
                                      href="#"
                                      title="Quick View"
                                      data-listing_id="17438"
                                    >
                                      <i
                                        class="rtcl-icon rtcl-icon-zoom-in"
                                      ></i>
                                    </a>
                                  </div>
                                </div>
                                <div class="product-content">
                                  <div class="product-top-content">
                                    <div class="product-category">
                                      <a
                                        href="listing-category/apartments/index.php"
                                        >Apartments</a
                                      >
                                    </div>
                                    <h3 class="item-title rt-main-title">
                                      <a
                                        href="property/brand-new-shopping-mall-for-buy/index.php"
                                      >
                                        Brand New Shopping Mall for buy
                                      </a>
                                    </h3>

                                    <ul class="entry-meta">
                                      <li>
                                        <i class="fas fa-map-marker-alt"></i
                                        ><a
                                          href="listing-location/new-jersey/index.php"
                                          >New Jersey</a
                                        >
                                      </li>
                                    </ul>

                                    <div class="list-information space-between">
                                      <ul class="product-features">
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-bed"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Beds </span>

                                            <span class="value">
                                              <span>0</span>3
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-shower"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Baths </span>

                                            <span class="value">
                                              <span>0</span>3
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-full-size"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> </span>

                                            <span class="value"> 2000 </span>

                                            <span class="suffix"> Sqft </span>
                                          </span>
                                        </li>
                                      </ul>
                                    </div>
                                  </div>

                                  <div class="product-bottom-content">
                                    <ul>
                                      <li class="item-author">
                                        <div class="media">
                                          <div class="item-img">
                                            <img
                                              loading="lazy"
                                              decoding="async"
                                              width="40"
                                              height="40"
                                              src="wp-content/uploads/classified-listing/2022/03/robert_blue-150x150.jpg"
                                              class="attachment-40x40 size-40x40"
                                              alt=""
                                              title=""
                                            />
                                          </div>
                                          <div class="media-body">
                                            <div class="item-title">
                                              <span>By</span>
                                              <a
                                                class="author-link"
                                                href="agent/robert_blue/index.php"
                                              >
                                                Robert Blue
                                              </a>
                                            </div>
                                          </div>
                                        </div>
                                      </li>
                                      <li class="action-btn">
                                        <a
                                          class="btn btn-primary"
                                          href="property/brand-new-shopping-mall-for-buy/index.php"
                                        >
                                          Details
                                        </a>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div
                              class="col-lg-4 col-md-6 col-sm-12 buy172190245699"
                            >
                              <div class="product-box style2">
                                <div class="product-thumb">
                                  <a
                                    href="property/modern-apartment-with-a-pole-for-buy/index.php"
                                    ><img
                                      loading="lazy"
                                      decoding="async"
                                      width="400"
                                      height="240"
                                      src="wp-content/uploads/classified-listing/2022/03/rosy_janner1-400x240.jpg"
                                      class="rtcl-thumbnail"
                                      alt="rosy_janner1"
                                      title=""
                                  /></a>

                                  <div class="product-type">
                                    <span class="listing-type-badge">
                                      For Buy
                                    </span>
                                  </div>

                                  <div class="rtcl-listing-badge-wrap"></div>

                                  <div class="product-price">
                                    <div class="rtcl-price price-type-fixed">
                                      <span class="rtcl-price-amount amount"
                                        ><bdi
                                          ><span
                                            class="rtcl-price-currencySymbol"
                                            >&#36;</span
                                          >350,000</bdi
                                        ></span
                                      >
                                    </div>
                                  </div>

                                  <div class="listing-action">
                                    <a
                                      href="javascript:void(0)"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      data-original-title="Favourites"
                                      class="rtcl-require-login"
                                      ><i
                                        class="rtcl-icon rtcl-icon-heart-empty"
                                      ></i
                                      ><span class="favourite-label"></span
                                    ></a>
                                    <a
                                      class="rtcl-compare"
                                      href="#"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      title=""
                                      data-original-title="Compare"
                                      data-listing_id="17353"
                                    >
                                      <i
                                        class="flaticon-left-and-right-arrows"
                                      ></i>
                                    </a>

                                    <a
                                      class="rtcl-quick-view"
                                      href="#"
                                      title="Quick View"
                                      data-listing_id="17353"
                                    >
                                      <i
                                        class="rtcl-icon rtcl-icon-zoom-in"
                                      ></i>
                                    </a>
                                  </div>
                                </div>
                                <div class="product-content">
                                  <div class="product-top-content">
                                    <div class="product-category">
                                      <a
                                        href="listing-category/restaurant/index.php"
                                        >Restaurant</a
                                      >
                                    </div>
                                    <h3 class="item-title rt-main-title">
                                      <a
                                        href="property/modern-apartment-with-a-pole-for-buy/index.php"
                                      >
                                        Modern apartment with a pole for buy
                                      </a>
                                    </h3>

                                    <ul class="entry-meta">
                                      <li>
                                        <i class="fas fa-map-marker-alt"></i
                                        ><a
                                          href="listing-location/kansas/abilene/index.php"
                                          >Abilene</a
                                        ><span class="rtcl-delimiter">,</span>
                                        <a
                                          href="listing-location/kansas/index.php"
                                          >Kansas</a
                                        >
                                      </li>
                                    </ul>

                                    <div class="list-information space-between">
                                      <ul class="product-features">
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-bed"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Beds </span>

                                            <span class="value">
                                              <span>0</span>3
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-shower"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Baths </span>

                                            <span class="value">
                                              <span>0</span>3
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-full-size"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> </span>

                                            <span class="value"> 2200 </span>

                                            <span class="suffix"> Sqft </span>
                                          </span>
                                        </li>
                                      </ul>
                                    </div>
                                  </div>

                                  <div class="product-bottom-content">
                                    <ul>
                                      <li class="item-author">
                                        <div class="media">
                                          <div class="item-img">
                                            <img
                                              loading="lazy"
                                              decoding="async"
                                              width="40"
                                              height="40"
                                              src="wp-content/uploads/classified-listing/2022/03/rosy_janner-150x150.jpg"
                                              class="attachment-40x40 size-40x40"
                                              alt=""
                                              title=""
                                            />
                                          </div>
                                          <div class="media-body">
                                            <div class="item-title">
                                              <span>By</span>
                                              <a
                                                class="author-link"
                                                href="agent/rosy_janner/index.php"
                                              >
                                                Rosy Janner
                                              </a>
                                            </div>
                                          </div>
                                        </div>
                                      </li>
                                      <li class="action-btn">
                                        <a
                                          class="btn btn-primary"
                                          href="property/modern-apartment-with-a-pole-for-buy/index.php"
                                        >
                                          Details
                                        </a>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div
                              class="col-lg-4 col-md-6 col-sm-12 buy172190245699"
                            >
                              <div class="product-box style2">
                                <div class="product-thumb">
                                  <a
                                    href="property/northwest-office-space/index.php"
                                    ><img
                                      loading="lazy"
                                      decoding="async"
                                      width="400"
                                      height="240"
                                      src="wp-content/uploads/classified-listing/2022/03/daziy_millar3-1-400x240.jpg"
                                      class="rtcl-thumbnail"
                                      alt="daziy_millar3-1"
                                      title=""
                                  /></a>

                                  <div class="product-type">
                                    <span class="listing-type-badge">
                                      For Buy
                                    </span>
                                  </div>

                                  <div class="rtcl-listing-badge-wrap">
                                    <span
                                      class="badge rtcl-badge-popular popular-badge badge-success"
                                      >Popular</span
                                    ><span class="badge rtcl-badge-_top"
                                      >Top</span
                                    >
                                  </div>

                                  <div class="product-price">
                                    <div class="rtcl-price price-type-fixed">
                                      <span class="rtcl-price-amount amount"
                                        ><bdi
                                          ><span
                                            class="rtcl-price-currencySymbol"
                                            >&#36;</span
                                          >450,000</bdi
                                        ></span
                                      >
                                    </div>
                                  </div>

                                  <div class="listing-action">
                                    <a
                                      href="javascript:void(0)"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      data-original-title="Favourites"
                                      class="rtcl-require-login"
                                      ><i
                                        class="rtcl-icon rtcl-icon-heart-empty"
                                      ></i
                                      ><span class="favourite-label"></span
                                    ></a>
                                    <a
                                      class="rtcl-compare"
                                      href="#"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      title=""
                                      data-original-title="Compare"
                                      data-listing_id="17433"
                                    >
                                      <i
                                        class="flaticon-left-and-right-arrows"
                                      ></i>
                                    </a>

                                    <a
                                      class="rtcl-quick-view"
                                      href="#"
                                      title="Quick View"
                                      data-listing_id="17433"
                                    >
                                      <i
                                        class="rtcl-icon rtcl-icon-zoom-in"
                                      ></i>
                                    </a>
                                  </div>
                                </div>
                                <div class="product-content">
                                  <div class="product-top-content">
                                    <div class="product-category">
                                      <a
                                        href="listing-category/apartments/index.php"
                                        >Apartments</a
                                      >
                                    </div>
                                    <h3 class="item-title rt-main-title">
                                      <a
                                        href="property/northwest-office-space/index.php"
                                      >
                                        Northwest Office Space
                                      </a>
                                    </h3>

                                    <ul class="entry-meta">
                                      <li>
                                        <i class="fas fa-map-marker-alt"></i
                                        ><a
                                          href="listing-location/new-jersey/index.php"
                                          >New Jersey</a
                                        >
                                      </li>
                                    </ul>

                                    <div class="list-information space-between">
                                      <ul class="product-features">
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-bed"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Beds </span>

                                            <span class="value">
                                              <span>0</span>3
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-shower"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Baths </span>

                                            <span class="value">
                                              <span>0</span>3
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-full-size"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> </span>

                                            <span class="value"> 1500 </span>

                                            <span class="suffix"> Sqft </span>
                                          </span>
                                        </li>
                                      </ul>
                                    </div>
                                  </div>

                                  <div class="product-bottom-content">
                                    <ul>
                                      <li class="item-author">
                                        <div class="media">
                                          <div class="item-img">
                                            <img
                                              loading="lazy"
                                              decoding="async"
                                              width="40"
                                              height="40"
                                              src="wp-content/uploads/classified-listing/2022/03/daziy_millar-150x150.jpg"
                                              class="attachment-40x40 size-40x40"
                                              alt=""
                                              title=""
                                            />
                                          </div>
                                          <div class="media-body">
                                            <div class="item-title">
                                              <span>By</span>
                                              <a
                                                class="author-link"
                                                href="agent/daziy_millar/index.php"
                                              >
                                                Daziy Millar
                                              </a>
                                            </div>
                                          </div>
                                        </div>
                                      </li>
                                      <li class="action-btn">
                                        <a
                                          class="btn btn-primary"
                                          href="property/northwest-office-space/index.php"
                                        >
                                          Details
                                        </a>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div
                              class="col-lg-4 col-md-6 col-sm-12 rent172190245699"
                            >
                              <div class="product-box style2">
                                <div class="product-thumb">
                                  <a
                                    href="property/affordable-green-villa-house-for-rent/index.php"
                                    ><img
                                      loading="lazy"
                                      decoding="async"
                                      width="400"
                                      height="240"
                                      src="wp-content/uploads/classified-listing/2022/03/mike_hussy6-400x240.jpg"
                                      class="rtcl-thumbnail"
                                      alt="mike_hussy6"
                                      title=""
                                  /></a>

                                  <div class="product-type">
                                    <span class="listing-type-badge">
                                      For Rent
                                    </span>
                                  </div>

                                  <div class="rtcl-listing-badge-wrap">
                                    <span
                                      class="badge rtcl-badge-popular popular-badge badge-success"
                                      >Popular</span
                                    ><span class="badge rtcl-badge-_bump_up"
                                      >Bump Up</span
                                    >
                                  </div>

                                  <div class="product-price">
                                    <div
                                      class="rtcl-price price-type-on_call"
                                    ></div>
                                  </div>

                                  <div class="listing-action">
                                    <a
                                      href="javascript:void(0)"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      data-original-title="Favourites"
                                      class="rtcl-require-login"
                                      ><i
                                        class="rtcl-icon rtcl-icon-heart-empty"
                                      ></i
                                      ><span class="favourite-label"></span
                                    ></a>
                                    <a
                                      class="rtcl-compare"
                                      href="#"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      title=""
                                      data-original-title="Compare"
                                      data-listing_id="17393"
                                    >
                                      <i
                                        class="flaticon-left-and-right-arrows"
                                      ></i>
                                    </a>

                                    <a
                                      class="rtcl-quick-view"
                                      href="#"
                                      title="Quick View"
                                      data-listing_id="17393"
                                    >
                                      <i
                                        class="rtcl-icon rtcl-icon-zoom-in"
                                      ></i>
                                    </a>
                                  </div>
                                </div>
                                <div class="product-content">
                                  <div class="product-top-content">
                                    <div class="product-category">
                                      <a
                                        href="listing-category/restaurant/index.php"
                                        >Restaurant</a
                                      >
                                    </div>
                                    <h3 class="item-title rt-main-title">
                                      <a
                                        href="property/affordable-green-villa-house-for-rent/index.php"
                                      >
                                        Affordable Green Villa House for Rent
                                      </a>
                                    </h3>

                                    <ul class="entry-meta">
                                      <li>
                                        <i class="fas fa-map-marker-alt"></i
                                        ><a
                                          href="listing-location/new-jersey/index.php"
                                          >New Jersey</a
                                        >
                                      </li>
                                    </ul>

                                    <div class="list-information space-between">
                                      <ul class="product-features">
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-bed"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Beds </span>

                                            <span class="value">
                                              <span>0</span>2
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-shower"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Baths </span>

                                            <span class="value">
                                              <span>0</span>2
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-full-size"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> </span>

                                            <span class="value"> 1300 </span>

                                            <span class="suffix"> Sqft </span>
                                          </span>
                                        </li>
                                      </ul>
                                    </div>
                                  </div>

                                  <div class="product-bottom-content">
                                    <ul>
                                      <li class="item-author">
                                        <div class="media">
                                          <div class="item-img">
                                            <img
                                              loading="lazy"
                                              decoding="async"
                                              width="40"
                                              height="40"
                                              src="wp-content/uploads/classified-listing/2022/03/tom_steven-150x150.jpg"
                                              class="attachment-40x40 size-40x40"
                                              alt=""
                                              title=""
                                            />
                                          </div>
                                          <div class="media-body">
                                            <div class="item-title">
                                              <span>By</span>
                                              <a
                                                class="author-link"
                                                href="agent/tom_steven/index.php"
                                              >
                                                Tom Steven
                                              </a>
                                            </div>
                                          </div>
                                        </div>
                                      </li>
                                      <li class="action-btn">
                                        <a
                                          class="btn btn-primary"
                                          href="property/affordable-green-villa-house-for-rent/index.php"
                                        >
                                          Details
                                        </a>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div
                              class="col-lg-4 col-md-6 col-sm-12 rent172190245699"
                            >
                              <div class="product-box style2">
                                <div class="product-thumb">
                                  <a
                                    href="property/diamond-manco-apartment/index.php"
                                    ><img
                                      loading="lazy"
                                      decoding="async"
                                      width="400"
                                      height="240"
                                      src="wp-content/uploads/classified-listing/2022/03/daziy_millar1-1-400x240.jpg"
                                      class="rtcl-thumbnail"
                                      alt="daziy_millar1-1"
                                      title=""
                                  /></a>

                                  <div class="product-type">
                                    <span class="listing-type-badge">
                                      For Rent
                                    </span>
                                  </div>

                                  <div class="rtcl-listing-badge-wrap">
                                    <span class="badge rtcl-badge-featured"
                                      >Featured</span
                                    ><span
                                      class="badge rtcl-badge-popular popular-badge badge-success"
                                      >Popular</span
                                    >
                                  </div>

                                  <div class="product-price">
                                    <div class="rtcl-price price-type-fixed">
                                      <span class="rtcl-price-amount amount"
                                        ><bdi
                                          ><span
                                            class="rtcl-price-currencySymbol"
                                            >&#36;</span
                                          >2,500</bdi
                                        ></span
                                      >
                                    </div>
                                  </div>

                                  <div class="listing-action">
                                    <a
                                      href="javascript:void(0)"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      data-original-title="Favourites"
                                      class="rtcl-require-login"
                                      ><i
                                        class="rtcl-icon rtcl-icon-heart-empty"
                                      ></i
                                      ><span class="favourite-label"></span
                                    ></a>
                                    <a
                                      class="rtcl-compare"
                                      href="#"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      title=""
                                      data-original-title="Compare"
                                      data-listing_id="17430"
                                    >
                                      <i
                                        class="flaticon-left-and-right-arrows"
                                      ></i>
                                    </a>

                                    <a
                                      class="rtcl-quick-view"
                                      href="#"
                                      title="Quick View"
                                      data-listing_id="17430"
                                    >
                                      <i
                                        class="rtcl-icon rtcl-icon-zoom-in"
                                      ></i>
                                    </a>
                                  </div>
                                </div>
                                <div class="product-content">
                                  <div class="product-top-content">
                                    <div class="product-category">
                                      <a
                                        href="listing-category/villa/index.php"
                                        >Villa</a
                                      >
                                    </div>
                                    <h3 class="item-title rt-main-title">
                                      <a
                                        href="property/diamond-manco-apartment/index.php"
                                      >
                                        Diamond Manco Apartment
                                      </a>
                                    </h3>

                                    <ul class="entry-meta">
                                      <li>
                                        <i class="fas fa-map-marker-alt"></i
                                        ><a
                                          href="listing-location/new-jersey/index.php"
                                          >New Jersey</a
                                        >
                                      </li>
                                    </ul>

                                    <div class="list-information space-between">
                                      <ul class="product-features">
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-bed"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Beds </span>

                                            <span class="value">
                                              <span>0</span>3
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-shower"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Baths </span>

                                            <span class="value">
                                              <span>0</span>3
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-full-size"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> </span>

                                            <span class="value"> 2500 </span>

                                            <span class="suffix"> Sqft </span>
                                          </span>
                                        </li>
                                      </ul>
                                    </div>
                                  </div>

                                  <div class="product-bottom-content">
                                    <ul>
                                      <li class="item-author">
                                        <div class="media">
                                          <div class="item-img">
                                            <img
                                              loading="lazy"
                                              decoding="async"
                                              width="40"
                                              height="40"
                                              src="wp-content/uploads/classified-listing/2022/03/daziy_millar-150x150.jpg"
                                              class="attachment-40x40 size-40x40"
                                              alt=""
                                              title=""
                                            />
                                          </div>
                                          <div class="media-body">
                                            <div class="item-title">
                                              <span>By</span>
                                              <a
                                                class="author-link"
                                                href="agent/daziy_millar/index.php"
                                              >
                                                Daziy Millar
                                              </a>
                                            </div>
                                          </div>
                                        </div>
                                      </li>
                                      <li class="action-btn">
                                        <a
                                          class="btn btn-primary"
                                          href="property/diamond-manco-apartment/index.php"
                                        >
                                          Details
                                        </a>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div
                              class="col-lg-4 col-md-6 col-sm-12 rent172190245699"
                            >
                              <div class="product-box style2">
                                <div class="product-thumb">
                                  <a
                                    href="property/luxury-house-in-kansas/index.php"
                                    ><img
                                      loading="lazy"
                                      decoding="async"
                                      width="400"
                                      height="240"
                                      src="wp-content/uploads/classified-listing/2022/03/rosy_janner4-400x240.jpg"
                                      class="rtcl-thumbnail"
                                      alt="rosy_janner4"
                                      title=""
                                  /></a>

                                  <div class="product-type">
                                    <span class="listing-type-badge">
                                      For Rent
                                    </span>
                                  </div>

                                  <div class="rtcl-listing-badge-wrap">
                                    <span class="badge rtcl-badge-featured"
                                      >Featured</span
                                    >
                                  </div>

                                  <div class="product-price">
                                    <div class="rtcl-price price-type-fixed">
                                      <span class="rtcl-price-amount amount"
                                        ><bdi
                                          ><span
                                            class="rtcl-price-currencySymbol"
                                            >&#36;</span
                                          >1,500</bdi
                                        ></span
                                      >
                                    </div>
                                  </div>

                                  <div class="listing-action">
                                    <a
                                      href="javascript:void(0)"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      data-original-title="Favourites"
                                      class="rtcl-require-login"
                                      ><i
                                        class="rtcl-icon rtcl-icon-heart-empty"
                                      ></i
                                      ><span class="favourite-label"></span
                                    ></a>
                                    <a
                                      class="rtcl-compare"
                                      href="#"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      title=""
                                      data-original-title="Compare"
                                      data-listing_id="17357"
                                    >
                                      <i
                                        class="flaticon-left-and-right-arrows"
                                      ></i>
                                    </a>

                                    <a
                                      class="rtcl-quick-view"
                                      href="#"
                                      title="Quick View"
                                      data-listing_id="17357"
                                    >
                                      <i
                                        class="rtcl-icon rtcl-icon-zoom-in"
                                      ></i>
                                    </a>
                                  </div>
                                </div>
                                <div class="product-content">
                                  <div class="product-top-content">
                                    <div class="product-category">
                                      <a
                                        href="listing-category/villa/index.php"
                                        >Villa</a
                                      >
                                    </div>
                                    <h3 class="item-title rt-main-title">
                                      <a
                                        href="property/luxury-house-in-kansas/index.php"
                                      >
                                        Luxury House in Kansas
                                      </a>
                                    </h3>

                                    <ul class="entry-meta">
                                      <li>
                                        <i class="fas fa-map-marker-alt"></i
                                        ><a
                                          href="listing-location/kansas/abilene/index.php"
                                          >Abilene</a
                                        ><span class="rtcl-delimiter">,</span>
                                        <a
                                          href="listing-location/kansas/index.php"
                                          >Kansas</a
                                        >
                                      </li>
                                    </ul>

                                    <div class="list-information space-between">
                                      <ul class="product-features">
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-bed"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Beds </span>

                                            <span class="value">
                                              <span>0</span>3
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-shower"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Baths </span>

                                            <span class="value">
                                              <span>0</span>2
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-full-size"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> </span>

                                            <span class="value"> 1800 </span>

                                            <span class="suffix"> Sqft </span>
                                          </span>
                                        </li>
                                      </ul>
                                    </div>
                                  </div>

                                  <div class="product-bottom-content">
                                    <ul>
                                      <li class="item-author">
                                        <div class="media">
                                          <div class="item-img">
                                            <img
                                              loading="lazy"
                                              decoding="async"
                                              width="40"
                                              height="40"
                                              src="wp-content/uploads/classified-listing/2022/03/rosy_janner-150x150.jpg"
                                              class="attachment-40x40 size-40x40"
                                              alt=""
                                              title=""
                                            />
                                          </div>
                                          <div class="media-body">
                                            <div class="item-title">
                                              <span>By</span>
                                              <a
                                                class="author-link"
                                                href="agent/rosy_janner/index.php"
                                              >
                                                Rosy Janner
                                              </a>
                                            </div>
                                          </div>
                                        </div>
                                      </li>
                                      <li class="action-btn">
                                        <a
                                          class="btn btn-primary"
                                          href="property/luxury-house-in-kansas/index.php"
                                        >
                                          Details
                                        </a>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div
                              class="col-lg-4 col-md-6 col-sm-12 rent172190245699"
                            >
                              <div class="product-box style2">
                                <div class="product-thumb">
                                  <a
                                    href="property/triple-story-house-for-rent/index.php"
                                    ><img
                                      loading="lazy"
                                      decoding="async"
                                      width="400"
                                      height="240"
                                      src="wp-content/uploads/classified-listing/2022/03/robert_blue5-1-400x240.jpg"
                                      class="rtcl-thumbnail"
                                      alt="robert_blue5-1"
                                      title=""
                                  /></a>

                                  <div class="product-type">
                                    <span class="listing-type-badge">
                                      For Rent
                                    </span>
                                  </div>

                                  <div class="rtcl-listing-badge-wrap">
                                    <span
                                      class="badge rtcl-badge-popular popular-badge badge-success"
                                      >Popular</span
                                    >
                                  </div>

                                  <div class="product-price">
                                    <div class="rtcl-price price-type-fixed">
                                      <div class="rtcl-price-range">
                                        <span class="price-from"
                                          ><span
                                            class="rtcl-price-amount amount"
                                            ><bdi
                                              ><span
                                                class="rtcl-price-currencySymbol"
                                                >&#36;</span
                                              >13,500</bdi
                                            ></span
                                          ></span
                                        >
                                        <span class="dash">&ndash;</span>
                                        <span class="price-to"
                                          ><span
                                            class="rtcl-price-amount amount"
                                            ><bdi
                                              ><span
                                                class="rtcl-price-currencySymbol"
                                                >&#36;</span
                                              >20,000</bdi
                                            ></span
                                          ></span
                                        >
                                      </div>
                                      <span class="rtcl-price-meta"
                                        ><span
                                          class="rtcl-price-unit-label rtcl-price-unit-year"
                                          >yr</span
                                        ></span
                                      >
                                    </div>
                                  </div>

                                  <div class="listing-action">
                                    <a
                                      href="javascript:void(0)"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      data-original-title="Favourites"
                                      class="rtcl-require-login"
                                      ><i
                                        class="rtcl-icon rtcl-icon-heart-empty"
                                      ></i
                                      ><span class="favourite-label"></span
                                    ></a>
                                    <a
                                      class="rtcl-compare"
                                      href="#"
                                      data-toggle="tooltip"
                                      data-placement="top"
                                      title=""
                                      data-original-title="Compare"
                                      data-listing_id="17441"
                                    >
                                      <i
                                        class="flaticon-left-and-right-arrows"
                                      ></i>
                                    </a>

                                    <a
                                      class="rtcl-quick-view"
                                      href="#"
                                      title="Quick View"
                                      data-listing_id="17441"
                                    >
                                      <i
                                        class="rtcl-icon rtcl-icon-zoom-in"
                                      ></i>
                                    </a>
                                  </div>
                                </div>
                                <div class="product-content">
                                  <div class="product-top-content">
                                    <div class="product-category">
                                      <a
                                        href="listing-category/studio-home/index.php"
                                        >Studio Home</a
                                      >
                                    </div>
                                    <h3 class="item-title rt-main-title">
                                      <a
                                        href="property/triple-story-house-for-rent/index.php"
                                      >
                                        Triple Story House for Rent
                                      </a>
                                    </h3>

                                    <ul class="entry-meta">
                                      <li>
                                        <i class="fas fa-map-marker-alt"></i
                                        ><a
                                          href="listing-location/new-jersey/index.php"
                                          >New Jersey</a
                                        >
                                      </li>
                                    </ul>

                                    <div class="list-information space-between">
                                      <ul class="product-features">
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-bed"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Beds </span>

                                            <span class="value">
                                              <span>0</span>3
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-shower"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> Baths </span>

                                            <span class="value">
                                              <span>0</span>2
                                            </span>

                                            <span class="suffix"> </span>
                                          </span>
                                        </li>
                                        <li>
                                          <i
                                            class="rtcl-icon rtcl-icon- flaticon-full-size"
                                          ></i>
                                          <span class="listable-value">
                                            <span class="prefix"> </span>

                                            <span class="value"> 1500 </span>

                                            <span class="suffix"> Sqft </span>
                                          </span>
                                        </li>
                                      </ul>
                                    </div>
                                  </div>

                                  <div class="product-bottom-content">
                                    <ul>
                                      <li class="item-author">
                                        <div class="media">
                                          <div class="item-img">
                                            <img
                                              loading="lazy"
                                              decoding="async"
                                              width="40"
                                              height="40"
                                              src="wp-content/uploads/classified-listing/2022/03/robert_blue-150x150.jpg"
                                              class="attachment-40x40 size-40x40"
                                              alt=""
                                              title=""
                                            />
                                          </div>
                                          <div class="media-body">
                                            <div class="item-title">
                                              <span>By</span>
                                              <a
                                                class="author-link"
                                                href="agent/robert_blue/index.php"
                                              >
                                                Robert Blue
                                              </a>
                                            </div>
                                          </div>
                                        </div>
                                      </li>
                                      <li class="action-btn">
                                        <a
                                          class="btn btn-primary"
                                          href="property/triple-story-house-for-rent/index.php"
                                        >
                                          Details
                                        </a>
                                      </li>
                                    </ul>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <section
              class="elementor-section elementor-top-section elementor-element elementor-element-9743c31 has-placeholder elementor-section-boxed elementor-section-height-default elementor-section-height-default rt-parallax-bg-no"
              data-id="9743c31"
              data-element_type="section"
              data-settings='{"background_background":"classic"}'
            >
              <div class="elementor-container elementor-column-gap-default">
                <div
                  class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-02acf30"
                  data-id="02acf30"
                  data-element_type="column"
                  data-settings='{"animation":"none"}'
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-a754fcc rt-parallax-follow-current-element elementor-widget elementor-widget-rt-parallax"
                      data-id="a754fcc"
                      data-element_type="widget"
                      data-widget_type="rt-parallax.default"
                    >
                      <div class="elementor-widget-container">
                        <img
                          decoding="async"
                          width="95"
                          height="95"
                          src="wp-content/uploads/2021/06/top-layer.png"
                          alt="Animated Image"
                          data-position="100"
                          class="rt-animated-img motion-effects 1 follow-with-mouse elementor-repeater-item-da21c77"
                        />
                      </div>
                    </div>
                    <div
                      class="elementor-element elementor-element-033e829 elementor-invisible elementor-widget elementor-widget-rt-video-icon"
                      data-id="033e829"
                      data-element_type="widget"
                      data-settings='{"_animation":"fadeInLeft","_animation_delay":100}'
                      data-widget_type="rt-video-icon.default"
                    >
                      <div class="elementor-widget-container">
                        <div class="rt-video-icon-wrapper icon-style1" style="">
                          <div class="video-icon-inner">
                            <div class="icon-left">
                              <div class="icon-box">
                                <a
                                  class="popup-youtube video-popup-icon"
                                  href="https://www.youtube.com/watch?v=XHOmBV4js_E"
                                >
                                  <span class="triangle"></span>
                                  <span
                                    class="rt-ripple-effect"
                                    style="
                                      box-shadow: 0 0 0 10px
                                          rgb(0 193 148 / 40%),
                                        0 0 0 20px rgb(0 193 148 / 30%),
                                        0 0 0 30px rgb(0 193 148 / 20%);
                                    "
                                  ></span>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div
                      class="elementor-element elementor-element-6176a0c rt-parallax-follow-current-element elementor-widget elementor-widget-rt-parallax"
                      data-id="6176a0c"
                      data-element_type="widget"
                      data-widget_type="rt-parallax.default"
                    >
                      <div class="elementor-widget-container">
                        <img
                          decoding="async"
                          width="90"
                          height="90"
                          src="wp-content/uploads/2021/06/bottom-layer.png"
                          alt="Animated Image"
                          data-position="-100"
                          class="rt-animated-img motion-effects 1 follow-with-mouse elementor-repeater-item-7647b6a"
                        />
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-93cb45c"
                  data-id="93cb45c"
                  data-element_type="column"
                  data-settings='{"animation":"none"}'
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-3e4e71b elementor-invisible elementor-widget elementor-widget-rt-title"
                      data-id="3e4e71b"
                      data-element_type="widget"
                      data-settings='{"_animation":"fadeInRight","_animation_delay":100}'
                      data-widget_type="rt-title.default"
                    >
                      <div class="elementor-widget-container">
                        <div class="section-title-wrapper">
                          Background Title
                          <div class="bg-title-wrap">
                            <span class="background-title solid"> Choose </span>
                          </div>

                          <div class="title-inner-wrapper">
                            Top Sub Title
                            <div class="top-sub-title-wrap">
                              <span class="top-sub-title">
                                <i
                                  style="margin-right: 5px"
                                  class="fa fa-circle"
                                  aria-hidden="true"
                                ></i
                                >Why Choose Our Properties
                              </span>
                            </div>

                            Main Title
                            <h2 class="main-title">
                              The experts in local and <br />
                              international property
                            </h2>

                            Description
                            <div class="description">
                              <p>
                                Agent hen an unknown printer took a galley of
                                type and scramble<br />d it to make a type
                                specimen book. It has survived not only five
                                <br />centuries, but also the leap into
                                electronic.
                              </p>
                              <ul>
                                <li>Outstanding property</li>
                                <li>Modern City Locations</li>
                                <li>Specialist services</li>
                                <li>Market-leading research</li>
                              </ul>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div
                      class="elementor-element elementor-element-6f150b8 elementor-button-animation-enable elementor-invisible elementor-widget elementor-widget-button"
                      data-id="6f150b8"
                      data-element_type="widget"
                      data-settings='{"_animation":"fadeInRight","_animation_delay":100}'
                      data-widget_type="button.default"
                    >
                      <div class="elementor-widget-container">
                        <div class="elementor-button-wrapper">
                          <a
                            class="elementor-button elementor-button-link elementor-size-sm"
                            href="#"
                          >
                            <span class="elementor-button-content-wrapper">
                              <span class="elementor-button-text"
                                >Read More</span
                              >
                            </span>
                          </a>
                        </div>
                      </div>
                    </div>
                    <div
                      class="elementor-element elementor-element-4d009d3 elementor-invisible elementor-widget elementor-widget-rt-image-placeholder"
                      data-id="4d009d3"
                      data-element_type="widget"
                      data-settings='{"_animation":"slideInRight","_animation_delay":300}'
                      data-widget_type="rt-image-placeholder.default"
                    >
                      <div class="elementor-widget-container">
                        <img
                          loading="lazy"
                          decoding="async"
                          width="571"
                          height="371"
                          src="wp-content/uploads/2021/09/video-bg-2.svg"
                          class="rt-image-placeholder"
                          alt="Animated Image"
                          title=""
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <section
              class="elementor-section elementor-top-section elementor-element elementor-element-bdf8b25 elementor-section-content-middle elementor-section-boxed elementor-section-height-default elementor-section-height-default rt-parallax-bg-no"
              data-id="bdf8b25"
              data-element_type="section"
              data-settings='{"background_background":"classic"}'
            >
              <div class="elementor-container elementor-column-gap-default">
                <div
                  class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-b0a196b"
                  data-id="b0a196b"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-af64b34 elementor-widget elementor-widget-rt-title"
                      data-id="af64b34"
                      data-element_type="widget"
                      data-settings='{"_animation":"none"}'
                      data-widget_type="rt-title.default"
                    >
                      <div class="elementor-widget-container">
                        <div class="section-title-wrapper">
                          Background Title
                          <div class="bg-title-wrap">
                            <span class="background-title solid">
                              Locations
                            </span>
                          </div>

                          <div class="title-inner-wrapper">
                            Top Sub Title
                            <div class="top-sub-title-wrap">
                              <span class="top-sub-title">
                                <i
                                  style="margin-right: 5px"
                                  class="fa fa-circle"
                                  aria-hidden="true"
                                ></i
                                >Top Areas
                              </span>
                            </div>

                            Main Title
                            <h2 class="main-title">Find Your Neighborhood</h2>

                            Description
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="elementor-column elementor-col-50 elementor-top-column elementor-element elementor-element-3765e45"
                  data-id="3765e45"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-0427024 elementor-align-right elementor-mobile-align-center elementor-button-animation-enable elementor-widget elementor-widget-button"
                      data-id="0427024"
                      data-element_type="widget"
                      data-widget_type="button.default"
                    >
                      <div class="elementor-widget-container">
                        <div class="elementor-button-wrapper">
                          <a
                            class="elementor-button elementor-button-link elementor-size-sm"
                            href="#"
                          >
                            <span class="elementor-button-content-wrapper">
                              <span class="elementor-button-text"
                                >Explore More</span
                              >
                            </span>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <section
              class="elementor-section elementor-top-section elementor-element elementor-element-d6f54da elementor-section-boxed elementor-section-height-default elementor-section-height-default rt-parallax-bg-no"
              data-id="d6f54da"
              data-element_type="section"
              data-settings='{"background_background":"classic"}'
            >
              <div class="elementor-container elementor-column-gap-custom">
                <div
                  class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-d27e891"
                  data-id="d27e891"
                  data-element_type="column"
                  data-settings='{"animation":"none"}'
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-fa7b800 listing-location-radiuse-enable rt-location-grayscale-disable rt-location-grayscale-hover-disable elementor-invisible elementor-widget elementor-widget-rt-listing-location-box"
                      data-id="fa7b800"
                      data-element_type="widget"
                      data-settings='{"_animation":"slideInUp","_animation_delay":100}'
                      data-widget_type="rt-listing-location-box.default"
                    >
                      <div class="elementor-widget-container">
                        <div
                          class="rt-el-listing-location-box category-browse category-cities style2"
                        >
                          <div class="category-box rtin-has-count">
                            <div class="img-wrap">
                              <div class="item-img">
                                <div class="overlay"></div>
                              </div>
                            </div>
                            <div class="item-content">
                              <div class="item-count yes">04 Properties</div>
                              <h3 class="item-title">
                                <a
                                  href="listing-location/california/index.php"
                                >
                                  California
                                </a>
                              </h3>
                              <a href="listing-location/california/index.php">
                                <i class="fas fa-arrow-right link-icon"></i>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-9f9f70f"
                  data-id="9f9f70f"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-3613153 listing-location-radiuse-enable rt-location-grayscale-disable rt-location-grayscale-hover-disable elementor-invisible elementor-widget elementor-widget-rt-listing-location-box"
                      data-id="3613153"
                      data-element_type="widget"
                      data-settings='{"_animation":"slideInUp","_animation_delay":200}'
                      data-widget_type="rt-listing-location-box.default"
                    >
                      <div class="elementor-widget-container">
                        <div
                          class="rt-el-listing-location-box category-browse category-cities style2"
                        >
                          <div class="category-box rtin-has-count">
                            <div class="img-wrap">
                              <div class="item-img">
                                <div class="overlay"></div>
                              </div>
                            </div>
                            <div class="item-content">
                              <div class="item-count yes">04 Properties</div>
                              <h3 class="item-title">
                                <a
                                  href="listing-location/california/claremont/index.php"
                                >
                                  Claremont
                                </a>
                              </h3>
                              <a
                                href="listing-location/california/claremont/index.php"
                              >
                                <i class="fas fa-arrow-right link-icon"></i>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-6817298"
                  data-id="6817298"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-ea5a9ff listing-location-radiuse-enable rt-location-grayscale-disable rt-location-grayscale-hover-disable elementor-invisible elementor-widget elementor-widget-rt-listing-location-box"
                      data-id="ea5a9ff"
                      data-element_type="widget"
                      data-settings='{"_animation":"slideInUp","_animation_delay":300}'
                      data-widget_type="rt-listing-location-box.default"
                    >
                      <div class="elementor-widget-container">
                        <div
                          class="rt-el-listing-location-box category-browse category-cities style2"
                        >
                          <div class="category-box rtin-has-count">
                            <div class="img-wrap">
                              <div class="item-img">
                                <div class="overlay"></div>
                              </div>
                            </div>
                            <div class="item-content">
                              <div class="item-count yes">02 Properties</div>
                              <h3 class="item-title">
                                <a
                                  href="listing-location/kansas/abilene/index.php"
                                >
                                  Abilene
                                </a>
                              </h3>
                              <a
                                href="listing-location/kansas/abilene/index.php"
                              >
                                <i class="fas fa-arrow-right link-icon"></i>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="elementor-column elementor-col-25 elementor-top-column elementor-element elementor-element-728b0c5"
                  data-id="728b0c5"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-0a6950f listing-location-radiuse-enable rt-location-grayscale-disable rt-location-grayscale-hover-disable elementor-invisible elementor-widget elementor-widget-rt-listing-location-box"
                      data-id="0a6950f"
                      data-element_type="widget"
                      data-settings='{"_animation":"slideInUp","_animation_delay":400}'
                      data-widget_type="rt-listing-location-box.default"
                    >
                      <div class="elementor-widget-container">
                        <div
                          class="rt-el-listing-location-box category-browse category-cities style2"
                        >
                          <div class="category-box rtin-has-count">
                            <div class="img-wrap">
                              <div class="item-img">
                                <div class="overlay"></div>
                              </div>
                            </div>
                            <div class="item-content">
                              <div class="item-count yes">02 Properties</div>
                              <h3 class="item-title">
                                <a href="listing-location/kansas/index.php">
                                  Kansas
                                </a>
                              </h3>
                              <a href="listing-location/kansas/index.php">
                                <i class="fas fa-arrow-right link-icon"></i>
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <section
              data-speed="0.5"
              data-bg-image="https://www.radiustheme.com/demo/wordpress/themes/homlisti/wp-content/uploads/2021/08/promo-bg-1.jpg"
              class="elementor-section elementor-top-section elementor-element elementor-element-f8c9b67 elementor-section-height-min-height rt-parallax-bg-yes elementor-section-boxed elementor-section-height-default elementor-section-items-middle rt-parallax-transition-off"
              data-id="f8c9b67"
              data-element_type="section"
              data-settings='{"background_background":"classic"}'
            >
              <div class="elementor-background-overlay"></div>
              <div class="elementor-container elementor-column-gap-default">
                <div
                  class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-c9769d9 elementor-invisible"
                  data-id="c9769d9"
                  data-element_type="column"
                  data-settings='{"background_background":"classic","animation":"slideInUp","animation_delay":100}'
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-db15e1d elementor-widget elementor-widget-rt-title"
                      data-id="db15e1d"
                      data-element_type="widget"
                      data-widget_type="rt-title.default"
                    >
                      <div class="elementor-widget-container">
                        <div class="section-title-wrapper">
                          Background Title

                          <div class="title-inner-wrapper">
                            Top Sub Title
                            <div class="top-sub-title-wrap">
                              <span class="top-sub-title">
                                <i
                                  style="margin-right: 5px"
                                  class="fa fa-circle"
                                  aria-hidden="true"
                                ></i
                                >Let’s Take a Tour
                              </span>
                            </div>

                            Main Title
                            <h2 class="main-title">
                              Search Property Smarter,<br />
                              Quicker &amp; Anywhere
                            </h2>

                            Description
                          </div>
                        </div>
                      </div>
                    </div>
                    <div
                      class="elementor-element elementor-element-2599e06 elementor-widget elementor-widget-rt-video-icon"
                      data-id="2599e06"
                      data-element_type="widget"
                      data-widget_type="rt-video-icon.default"
                    >
                      <div class="elementor-widget-container">
                        <div class="rt-video-icon-wrapper icon-style2" style="">
                          <div class="video-icon-inner">
                            <div class="icon-left">
                              <div class="icon-box">
                                <a
                                  class="popup-youtube video-popup-icon"
                                  href="https://www.youtube.com/watch?v=XHOmBV4js_E"
                                >
                                  <span class="triangle"></span>
                                  <span
                                    class="rt-ripple-effect"
                                    style=""
                                  ></span>
                                </a>
                              </div>
                            </div>
                            <div class="icon-right">
                              <a
                                class="popup-youtube button-text"
                                href="https://www.youtube.com/watch?v=XHOmBV4js_E"
                              >
                                Play Video
                              </a>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="elementor-column elementor-col-66 elementor-top-column elementor-element elementor-element-c548f87"
                  data-id="c548f87"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-a2d5f48 elementor-invisible elementor-widget elementor-widget-rt-title"
                      data-id="a2d5f48"
                      data-element_type="widget"
                      data-settings='{"_animation":"slideInUp","_animation_delay":200}'
                      data-widget_type="rt-title.default"
                    >
                      <div class="elementor-widget-container">
                        <div class="section-title-wrapper">
                          Background Title
                          <div class="bg-title-wrap">
                            <span class="background-title solid">
                              Property For All
                            </span>
                          </div>

                          <div class="title-inner-wrapper">
                            Top Sub Title

                            Main Title

                            Description
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <section
              class="elementor-section elementor-top-section elementor-element elementor-element-fc27fe9 elementor-section-boxed elementor-section-height-default elementor-section-height-default rt-parallax-bg-no"
              data-id="fc27fe9"
              data-element_type="section"
            >
              <div class="elementor-container elementor-column-gap-default">
                <div
                  class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-cf5e3ea"
                  data-id="cf5e3ea"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-4a6b02f elementor-widget elementor-widget-rt-title"
                      data-id="4a6b02f"
                      data-element_type="widget"
                      data-widget_type="rt-title.default"
                    >
                      <div class="elementor-widget-container">
                        <div class="section-title-wrapper">
                          Background Title
                          <div class="bg-title-wrap">
                            <span class="background-title solid">
                              Our Agents
                            </span>
                          </div>

                          <div class="title-inner-wrapper">
                            Top Sub Title
                            <div class="top-sub-title-wrap">
                              <span class="top-sub-title">
                                Expertise Is Here
                              </span>
                            </div>

                            Main Title
                            <h2 class="main-title">Our Exclusive Agetns</h2>

                            Description
                          </div>
                        </div>
                      </div>
                    </div>
                    <div
                      class="elementor-element elementor-element-b83ac92 elementor-widget elementor-widget-rtcl-agent"
                      data-id="b83ac92"
                      data-element_type="widget"
                      data-widget_type="rtcl-agent.default"
                    >
                      <div class="elementor-widget-container">
                        <div class="rt-agents-wrapper row style1">
                          <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="agent-block">
                              <div class="item-img">
                                <img
                                  loading="lazy"
                                  decoding="async"
                                  width="240"
                                  height="240"
                                  src="wp-content/uploads/classified-listing/2022/03/rosy_janner.jpg"
                                  class="attachment-420x240 size-420x240"
                                  alt=""
                                  title=""
                                />
                                <div class="category-box">
                                  <div class="item-category">2 Listings</div>
                                </div>
                              </div>

                              <div class="item-content">
                                <div class="item-title">
                                  <h3 class="agent-name">
                                    <a href="agent/rosy_janner/index.php">
                                      Rosy Janner
                                    </a>
                                  </h3>

                                  <h4 class="item-subtitle">
                                    <a href="agency/sunshine/index.php"
                                      >Sunshine</a
                                    >
                                  </h4>
                                </div>

                                <div class="item-contact">
                                  <div class="item-icon">
                                    <i class="fas fa-phone-alt"></i>
                                  </div>
                                  <div class="item-phn-no">
                                    Call:
                                    <a href="tel:+442037691880"
                                      >+442037691880</a
                                    >
                                  </div>
                                </div>
                              </div>

                              <div class="social-icon">
                                <a
                                  href="#"
                                  class="social-hover-icon social-link"
                                >
                                  <i class="fas fa-share-alt"></i>
                                </a>
                                <a
                                  target="_blank"
                                  href="https://www.facebook.com/"
                                >
                                  <i class="rtcl-icon rtcl-icon-facebook"></i>
                                </a>
                                <a
                                  target="_blank"
                                  href="https://www.twiter.com/"
                                >
                                  <i class="rtcl-icon rtcl-icon-twitter"></i>
                                </a>
                                <a
                                  target="_blank"
                                  href="https://www.youtube.com/"
                                >
                                  <i class="rtcl-icon rtcl-icon-youtube"></i>
                                </a>
                                <a
                                  target="_blank"
                                  href="https://www.pinterest.com/"
                                >
                                  <i class="rtcl-icon rtcl-icon-pinterest"></i>
                                </a>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="agent-block">
                              <div class="item-img">
                                <img
                                  loading="lazy"
                                  decoding="async"
                                  width="240"
                                  height="240"
                                  src="wp-content/uploads/classified-listing/2022/03/david_lee.jpg"
                                  class="attachment-420x240 size-420x240"
                                  alt=""
                                  title=""
                                />
                                <div class="category-box">
                                  <div class="item-category">4 Listings</div>
                                </div>
                              </div>

                              <div class="item-content">
                                <div class="item-title">
                                  <h3 class="agent-name">
                                    <a href="agent/david_lee/index.php">
                                      David Lee
                                    </a>
                                  </h3>

                                  <h4 class="item-subtitle">
                                    <a href="agency/sunshine/index.php"
                                      >Sunshine</a
                                    >
                                  </h4>
                                </div>

                                <div class="item-contact">
                                  <div class="item-icon">
                                    <i class="fas fa-phone-alt"></i>
                                  </div>
                                  <div class="item-phn-no">
                                    Call:
                                    <a href="tel:+182137121886"
                                      >+182137121886</a
                                    >
                                  </div>
                                </div>
                              </div>

                              <div class="social-icon">
                                <a
                                  href="#"
                                  class="social-hover-icon social-link"
                                >
                                  <i class="fas fa-share-alt"></i>
                                </a>
                                <a
                                  target="_blank"
                                  href="https://www.facebook.com/"
                                >
                                  <i class="rtcl-icon rtcl-icon-facebook"></i>
                                </a>
                                <a
                                  target="_blank"
                                  href="https://www.twiter.com/"
                                >
                                  <i class="rtcl-icon rtcl-icon-twitter"></i>
                                </a>
                                <a
                                  target="_blank"
                                  href="https://www.linkedin.com/"
                                >
                                  <i class="rtcl-icon rtcl-icon-linkedin"></i>
                                </a>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="agent-block">
                              <div class="item-img">
                                <img
                                  loading="lazy"
                                  decoding="async"
                                  width="240"
                                  height="240"
                                  src="wp-content/uploads/classified-listing/2022/03/mike_hussy-1.jpg"
                                  class="attachment-420x240 size-420x240"
                                  alt=""
                                  title=""
                                />
                                <div class="category-box">
                                  <div class="item-category">1 Listing</div>
                                </div>
                              </div>

                              <div class="item-content">
                                <div class="item-title">
                                  <h3 class="agent-name">
                                    <a href="agent/mike_hussy/index.php">
                                      Mike Hussy
                                    </a>
                                  </h3>

                                  <h4 class="item-subtitle">
                                    <a href="agency/eco-builders/index.php"
                                      >Eco Builders</a
                                    >
                                  </h4>
                                </div>

                                <div class="item-contact">
                                  <div class="item-icon">
                                    <i class="fas fa-phone-alt"></i>
                                  </div>
                                  <div class="item-phn-no">
                                    Call:
                                    <a href="tel:+442037691880"
                                      >+442037691880</a
                                    >
                                  </div>
                                </div>
                              </div>

                              <div class="social-icon">
                                <a
                                  href="#"
                                  class="social-hover-icon social-link"
                                >
                                  <i class="fas fa-share-alt"></i>
                                </a>
                                <a
                                  target="_blank"
                                  href="https://www.facebook.com/"
                                >
                                  <i class="rtcl-icon rtcl-icon-facebook"></i>
                                </a>
                                <a
                                  target="_blank"
                                  href="https://www.twiter.com/"
                                >
                                  <i class="rtcl-icon rtcl-icon-twitter"></i>
                                </a>
                                <a
                                  target="_blank"
                                  href="https://www.pinterest.com/"
                                >
                                  <i class="rtcl-icon rtcl-icon-pinterest"></i>
                                </a>
                              </div>
                            </div>
                          </div>
                          <div class="col-lg-3 col-md-6 col-sm-6">
                            <div class="agent-block">
                              <div class="item-img">
                                <img
                                  loading="lazy"
                                  decoding="async"
                                  width="240"
                                  height="240"
                                  src="wp-content/uploads/classified-listing/2022/03/tom_steven.jpg"
                                  class="attachment-420x240 size-420x240"
                                  alt=""
                                  title=""
                                />
                                <div class="category-box">
                                  <div class="item-category">2 Listings</div>
                                </div>
                              </div>

                              <div class="item-content">
                                <div class="item-title">
                                  <h3 class="agent-name">
                                    <a href="agent/tom_steven/index.php">
                                      Tom Steven
                                    </a>
                                  </h3>

                                  <h4 class="item-subtitle">
                                    <a href="agency/sweet-home/index.php"
                                      >Sweet Home</a
                                    >
                                  </h4>
                                </div>

                                <div class="item-contact">
                                  <div class="item-icon">
                                    <i class="fas fa-phone-alt"></i>
                                  </div>
                                  <div class="item-phn-no">
                                    Call:
                                    <a href="tel:+052015698546"
                                      >+052015698546</a
                                    >
                                  </div>
                                </div>
                              </div>

                              <div class="social-icon">
                                <a
                                  href="#"
                                  class="social-hover-icon social-link"
                                >
                                  <i class="fas fa-share-alt"></i>
                                </a>
                                <a
                                  target="_blank"
                                  href="https://www.facebook.com/"
                                >
                                  <i class="rtcl-icon rtcl-icon-facebook"></i>
                                </a>
                                <a
                                  target="_blank"
                                  href="https://www.twiter.com/"
                                >
                                  <i class="rtcl-icon rtcl-icon-twitter"></i>
                                </a>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <section
              class="elementor-section elementor-top-section elementor-element elementor-element-5a674c9 elementor-section-boxed elementor-section-height-default elementor-section-height-default rt-parallax-bg-no"
              data-id="5a674c9"
              data-element_type="section"
            >
              <div class="elementor-container elementor-column-gap-default">
                <div
                  class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-2959944"
                  data-id="2959944"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <section
                      class="elementor-section elementor-inner-section elementor-element elementor-element-71ddf80 elementor-section-height-min-height elementor-section-content-middle elementor-section-boxed elementor-section-height-default rt-parallax-bg-no elementor-invisible"
                      data-id="71ddf80"
                      data-element_type="section"
                      data-settings='{"background_background":"classic","animation":"fadeInUp"}'
                    >
                      <div
                        class="elementor-container elementor-column-gap-default"
                      >
                        <div
                          class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-79707a4"
                          data-id="79707a4"
                          data-element_type="column"
                        >
                          <div
                            class="elementor-widget-wrap elementor-element-populated"
                          >
                            <div
                              class="elementor-element elementor-element-f48069f elementor-widget elementor-widget-rt-info-box"
                              data-id="f48069f"
                              data-element_type="widget"
                              data-widget_type="rt-info-box.default"
                            >
                              <div class="elementor-widget-container">
                                <div
                                  class="service3-box-right rt-info-box-wrap-1 rt-info-box icon-el-style-1"
                                >
                                  <div class="service-box">
                                    <div
                                      class="service3-icon-holder icon-holder"
                                    >
                                      <i
                                        aria-hidden="true"
                                        class="fas fa-users"
                                      ></i>
                                    </div>

                                    <div
                                      class="service3-content-holder content-holder content-align"
                                    >
                                      <h3 class="info-title">
                                        Become an Agent
                                      </h3>

                                      <p>
                                        Agent hen an unknown printer took a
                                        galley scramble
                                      </p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div
                          class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-a81b124"
                          data-id="a81b124"
                          data-element_type="column"
                        >
                          <div
                            class="elementor-widget-wrap elementor-element-populated"
                          >
                            <div
                              class="elementor-element elementor-element-77dbea5 elementor-align-right elementor-mobile-align-center elementor-button-animation-enable elementor-widget elementor-widget-button"
                              data-id="77dbea5"
                              data-element_type="widget"
                              data-widget_type="button.default"
                            >
                              <div class="elementor-widget-container">
                                <div class="elementor-button-wrapper">
                                  <a
                                    class="elementor-button elementor-button-link elementor-size-sm"
                                    href="#"
                                  >
                                    <span
                                      class="elementor-button-content-wrapper"
                                    >
                                      <span class="elementor-button-text"
                                        >Join Now</span
                                      >
                                    </span>
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                  </div>
                </div>
              </div>
            </section>
            <section
              class="elementor-section elementor-top-section elementor-element elementor-element-f417175 has-placeholder elementor-section-boxed elementor-section-height-default elementor-section-height-default rt-parallax-bg-no"
              data-id="f417175"
              data-element_type="section"
              data-settings='{"background_background":"classic"}'
            >
              <div class="elementor-background-overlay"></div>
              <div class="elementor-container elementor-column-gap-default">
                <div
                  class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-2ba4fae"
                  data-id="2ba4fae"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <section
                      class="elementor-section elementor-inner-section elementor-element elementor-element-b90df4c elementor-section-boxed elementor-section-height-default elementor-section-height-default rt-parallax-bg-no"
                      data-id="b90df4c"
                      data-element_type="section"
                    >
                      <div
                        class="elementor-container elementor-column-gap-default"
                      >
                        <div
                          class="elementor-column elementor-col-100 elementor-inner-column elementor-element elementor-element-b595084"
                          data-id="b595084"
                          data-element_type="column"
                        >
                          <div
                            class="elementor-widget-wrap elementor-element-populated"
                          >
                            <div
                              class="elementor-element elementor-element-6185dad elementor-widget elementor-widget-rt-title"
                              data-id="6185dad"
                              data-element_type="widget"
                              data-widget_type="rt-title.default"
                            >
                              <div class="elementor-widget-container">
                                <div class="section-title-wrapper">
                                  Background Title
                                  <div class="bg-title-wrap">
                                    <span class="background-title solid">
                                      Numbers
                                    </span>
                                  </div>

                                  <div class="title-inner-wrapper">
                                    Top Sub Title

                                    Main Title
                                    <h2 class="main-title">
                                      Real Estate by the Numbers
                                    </h2>

                                    Description
                                    <div class="description">
                                      <p>
                                        In 2021 things look like this percentage
                                      </p>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                    <section
                      class="elementor-section elementor-inner-section elementor-element elementor-element-26ca0de elementor-section-boxed elementor-section-height-default elementor-section-height-default rt-parallax-bg-no"
                      data-id="26ca0de"
                      data-element_type="section"
                    >
                      <div
                        class="elementor-container elementor-column-gap-default"
                      >
                        <div
                          class="elementor-column elementor-col-25 elementor-inner-column elementor-element elementor-element-45fd040"
                          data-id="45fd040"
                          data-element_type="column"
                        >
                          <div
                            class="elementor-widget-wrap elementor-element-populated"
                          >
                            <div
                              class="elementor-element elementor-element-aab3079 elementor-counter-circle-style elementor-invisible elementor-widget elementor-widget-counter"
                              data-id="aab3079"
                              data-element_type="widget"
                              data-settings='{"_animation":"zoomIn","_animation_delay":100}'
                              data-widget_type="counter.default"
                            >
                              <div class="elementor-widget-container">
                                <div class="elementor-counter">
                                  <div class="elementor-counter-title">
                                    Completed Property
                                  </div>
                                  <div class="elementor-counter-number-wrapper">
                                    <span
                                      class="elementor-counter-number-prefix"
                                    ></span>
                                    <span
                                      class="elementor-counter-number"
                                      data-duration="2000"
                                      data-to-value="80"
                                      data-from-value="0"
                                      data-delimiter=","
                                      >0</span
                                    >
                                    <span
                                      class="elementor-counter-number-suffix"
                                      >%</span
                                    >
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div
                          class="elementor-column elementor-col-25 elementor-inner-column elementor-element elementor-element-5225dd7"
                          data-id="5225dd7"
                          data-element_type="column"
                        >
                          <div
                            class="elementor-widget-wrap elementor-element-populated"
                          >
                            <div
                              class="elementor-element elementor-element-f892a60 elementor-counter-circle-style elementor-invisible elementor-widget elementor-widget-counter"
                              data-id="f892a60"
                              data-element_type="widget"
                              data-settings='{"_animation":"zoomIn","_animation_delay":100}'
                              data-widget_type="counter.default"
                            >
                              <div class="elementor-widget-container">
                                <div class="elementor-counter">
                                  <div class="elementor-counter-title">
                                    Property Taxes
                                  </div>
                                  <div class="elementor-counter-number-wrapper">
                                    <span
                                      class="elementor-counter-number-prefix"
                                    ></span>
                                    <span
                                      class="elementor-counter-number"
                                      data-duration="2000"
                                      data-to-value="27"
                                      data-from-value="0"
                                      data-delimiter=","
                                      >0</span
                                    >
                                    <span
                                      class="elementor-counter-number-suffix"
                                      >%</span
                                    >
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div
                          class="elementor-column elementor-col-25 elementor-inner-column elementor-element elementor-element-c30fd4d"
                          data-id="c30fd4d"
                          data-element_type="column"
                        >
                          <div
                            class="elementor-widget-wrap elementor-element-populated"
                          >
                            <div
                              class="elementor-element elementor-element-7c96648 elementor-counter-circle-style elementor-invisible elementor-widget elementor-widget-counter"
                              data-id="7c96648"
                              data-element_type="widget"
                              data-settings='{"_animation":"zoomIn","_animation_delay":100}'
                              data-widget_type="counter.default"
                            >
                              <div class="elementor-widget-container">
                                <div class="elementor-counter">
                                  <div class="elementor-counter-title">
                                    Satisfied Customers
                                  </div>
                                  <div class="elementor-counter-number-wrapper">
                                    <span
                                      class="elementor-counter-number-prefix"
                                    ></span>
                                    <span
                                      class="elementor-counter-number"
                                      data-duration="2000"
                                      data-to-value="99"
                                      data-from-value="0"
                                      data-delimiter=","
                                      >0</span
                                    >
                                    <span
                                      class="elementor-counter-number-suffix"
                                      >%</span
                                    >
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div
                          class="elementor-column elementor-col-25 elementor-inner-column elementor-element elementor-element-5116b1d"
                          data-id="5116b1d"
                          data-element_type="column"
                        >
                          <div
                            class="elementor-widget-wrap elementor-element-populated"
                          >
                            <div
                              class="elementor-element elementor-element-ee07a18 elementor-counter-circle-style elementor-invisible elementor-widget elementor-widget-counter"
                              data-id="ee07a18"
                              data-element_type="widget"
                              data-settings='{"_animation":"zoomIn","_animation_delay":100}'
                              data-widget_type="counter.default"
                            >
                              <div class="elementor-widget-container">
                                <div class="elementor-counter">
                                  <div class="elementor-counter-title">
                                    Home ownership
                                  </div>
                                  <div class="elementor-counter-number-wrapper">
                                    <span
                                      class="elementor-counter-number-prefix"
                                    ></span>
                                    <span
                                      class="elementor-counter-number"
                                      data-duration="2000"
                                      data-to-value="50"
                                      data-from-value="0"
                                      data-delimiter=","
                                      >0</span
                                    >
                                    <span
                                      class="elementor-counter-number-suffix"
                                      >%</span
                                    >
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                    <div
                      class="elementor-element elementor-element-5cf2bdc elementor-invisible elementor-widget elementor-widget-rt-image-placeholder"
                      data-id="5cf2bdc"
                      data-element_type="widget"
                      data-settings='{"_animation":"slideInUp"}'
                      data-widget_type="rt-image-placeholder.default"
                    >
                      <div class="elementor-widget-container">
                        <img
                          loading="lazy"
                          decoding="async"
                          width="1477"
                          height="183"
                          src="wp-content/uploads/2021/07/counter-bg-2.png"
                          class="rt-image-placeholder"
                          alt="Animated Image"
                          title=""
                        />
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <section
              class="elementor-section elementor-top-section elementor-element elementor-element-e06cff2 elementor-section-boxed elementor-section-height-default elementor-section-height-default rt-parallax-bg-no"
              data-id="e06cff2"
              data-element_type="section"
              data-settings='{"background_background":"gradient"}'
            >
              <div class="elementor-container elementor-column-gap-default">
                <div
                  class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-b1122c7"
                  data-id="b1122c7"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-72be2a4 elementor-widget elementor-widget-rt-title"
                      data-id="72be2a4"
                      data-element_type="widget"
                      data-widget_type="rt-title.default"
                    >
                      <div class="elementor-widget-container">
                        <div class="section-title-wrapper">
                          Background Title
                          <div class="bg-title-wrap">
                            <span class="background-title solid">
                              Testimonials
                            </span>
                          </div>

                          <div class="title-inner-wrapper">
                            Top Sub Title
                            <div class="top-sub-title-wrap">
                              <span class="top-sub-title">
                                Customer Reviews
                              </span>
                            </div>

                            Main Title
                            <h2 class="main-title">What’s Our Customer Say</h2>

                            Description
                          </div>
                        </div>
                      </div>
                    </div>
                    <div
                      class="elementor-element elementor-element-cc77a61 is-dots-yes elementor-invisible elementor-widget elementor-widget-rt-testimonial-carousel"
                      data-id="cc77a61"
                      data-element_type="widget"
                      data-settings='{"_animation":"fadeInUp"}'
                      data-widget_type="rt-testimonial-carousel.default"
                    >
                      <div class="elementor-widget-container">
                        <div class="rt-el-testimonial-carousel style2">
                          <div class="slide-wrap">
                            <div
                              class="testimonial-carousel slick-carousel swiper"
                              data-slick='{"effect":"slide","loop":true,"speed":300,"autoHeight":true,"slidesPerView":1,"pagination":{"el":".swiper-pagination","clickable":true,"type":"bullets"},"navigation":{"nextEl":".elementor-swiper-button-prev","prevEl":".elementor-swiper-button-next"}}'
                            >
                              <div class="swiper-wrapper">
                                <div class="swiper-slide slider-item">
                                  <div class="row align-items-center">
                                    <div class="col-md-5">
                                      <div
                                        class="testimonial-banner"
                                        style="
                                          background-image: url(wp-content/uploads/2021/06/testimonial-1-500x457.jpg);
                                        "
                                      ></div>
                                    </div>
                                    <div class="col-md-7">
                                      <div class="testimonial-content">
                                        <div class="star-rating">
                                          <i class="fas fa-star"></i
                                          ><i class="fas fa-star"></i
                                          ><i class="fas fa-star"></i
                                          ><i class="fas fa-star"></i
                                          ><i class="fas fa-star"></i>
                                        </div>
                                        <div class="rtin-content">
                                          <span
                                            >Engage with our professional real
                                            estate agents sell Following buy or
                                            rent your home.Get emails directly
                                            to your area reach inbox and manage
                                            the lead with.</span
                                          >
                                        </div>
                                        <h3 class="item-title">
                                          Maria Zokatti
                                        </h3>
                                        <div class="item-subtitle">
                                          CEO, PSDBOSS
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="swiper-slide slider-item">
                                  <div class="row align-items-center">
                                    <div class="col-md-5">
                                      <div
                                        class="testimonial-banner"
                                        style="
                                          background-image: url(wp-content/uploads/2021/09/blog_1-500x450.jpg);
                                        "
                                      ></div>
                                    </div>
                                    <div class="col-md-7">
                                      <div class="testimonial-content">
                                        <div class="star-rating">
                                          <i class="fas fa-star"></i
                                          ><i class="fas fa-star"></i
                                          ><i class="fas fa-star"></i
                                          ><i class="fas fa-star"></i
                                          ><i class="fas fa-star"></i>
                                        </div>
                                        <div class="rtin-content">
                                          <span
                                            >Lorem, ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Aliquid expedita recusandae ipsam
                                            quas fugit aperiam nihil nemo
                                            delectus laudantium? Enim est
                                            quibusdam dicta a</span
                                          >
                                        </div>
                                        <h3 class="item-title">John Doe</h3>
                                        <div class="item-subtitle">
                                          WordPress Developer
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <div class="swiper-slide slider-item">
                                  <div class="row align-items-center">
                                    <div class="col-md-5">
                                      <div
                                        class="testimonial-banner"
                                        style="
                                          background-image: url(wp-content/uploads/2021/09/blog_4-500x450.jpg);
                                        "
                                      ></div>
                                    </div>
                                    <div class="col-md-7">
                                      <div class="testimonial-content">
                                        <div class="star-rating">
                                          <i class="fas fa-star"></i
                                          ><i class="fas fa-star"></i
                                          ><i class="fas fa-star"></i
                                          ><i class="fas fa-star"></i
                                          ><i class="fas fa-star"></i>
                                        </div>
                                        <div class="rtin-content">
                                          <span
                                            >Lorem, ipsum dolor sit amet
                                            consectetur adipisicing elit.
                                            Aliquid expedita recusandae ipsam
                                            quas fugit aperiam nihil nemo
                                            delectus laudantium? Enim est
                                            quibusdam dicta a</span
                                          >
                                        </div>
                                        <h3 class="item-title">John Doe</h3>
                                        <div class="item-subtitle">
                                          WordPress Developer
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div
                              class="elementor-swiper-button elementor-swiper-button-prev rt-prev"
                            >
                              <i
                                class="eicon-chevron-left"
                                aria-hidden="true"
                              ></i>
                              <span class="elementor-screen-only"
                                >Previous</span
                              >
                            </div>
                            <div
                              class="elementor-swiper-button elementor-swiper-button-next rt-next"
                            >
                              <i
                                class="eicon-chevron-right"
                                aria-hidden="true"
                              ></i>
                              <span class="elementor-screen-only">Next</span>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <section
              class="elementor-section elementor-top-section elementor-element elementor-element-bb41694 elementor-section-boxed elementor-section-height-default elementor-section-height-default rt-parallax-bg-no"
              data-id="bb41694"
              data-element_type="section"
            >
              <div class="elementor-container elementor-column-gap-default">
                <div
                  class="elementor-column elementor-col-100 elementor-top-column elementor-element elementor-element-0ec6c04"
                  data-id="0ec6c04"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <section
                      class="elementor-section elementor-inner-section elementor-element elementor-element-b3e48d6 elementor-section-content-middle elementor-section-boxed elementor-section-height-default elementor-section-height-default rt-parallax-bg-no"
                      data-id="b3e48d6"
                      data-element_type="section"
                    >
                      <div
                        class="elementor-container elementor-column-gap-default"
                      >
                        <div
                          class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-94a024d"
                          data-id="94a024d"
                          data-element_type="column"
                        >
                          <div
                            class="elementor-widget-wrap elementor-element-populated"
                          >
                            <div
                              class="elementor-element elementor-element-daeb512 elementor-widget elementor-widget-rt-title"
                              data-id="daeb512"
                              data-element_type="widget"
                              data-widget_type="rt-title.default"
                            >
                              <div class="elementor-widget-container">
                                <div class="section-title-wrapper">
                                  Background Title
                                  <div class="bg-title-wrap">
                                    <span class="background-title solid">
                                      Blogs
                                    </span>
                                  </div>

                                  <div class="title-inner-wrapper">
                                    Top Sub Title
                                    <div class="top-sub-title-wrap">
                                      <span class="top-sub-title">
                                        <i
                                          style="margin-right: 5px"
                                          class="fa fa-circle"
                                          aria-hidden="true"
                                        ></i
                                        >What’s New Trending
                                      </span>
                                    </div>

                                    Main Title
                                    <h2 class="main-title">
                                      Latest Blog &amp; Posts
                                    </h2>

                                    Description
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div
                          class="elementor-column elementor-col-50 elementor-inner-column elementor-element elementor-element-d82e53f"
                          data-id="d82e53f"
                          data-element_type="column"
                        >
                          <div
                            class="elementor-widget-wrap elementor-element-populated"
                          >
                            <div
                              class="elementor-element elementor-element-5239a56 elementor-align-right elementor-tablet-align-center elementor-button-animation-enable elementor-widget elementor-widget-button"
                              data-id="5239a56"
                              data-element_type="widget"
                              data-widget_type="button.default"
                            >
                              <div class="elementor-widget-container">
                                <div class="elementor-button-wrapper">
                                  <a
                                    class="elementor-button elementor-button-link elementor-size-sm"
                                    href="#"
                                  >
                                    <span
                                      class="elementor-button-content-wrapper"
                                    >
                                      <span class="elementor-button-text"
                                        >See All Blogs</span
                                      >
                                    </span>
                                  </a>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </section>
                    <div
                      class="elementor-element elementor-element-072cdb6 elementor-invisible elementor-widget elementor-widget-rt-post"
                      data-id="072cdb6"
                      data-element_type="widget"
                      data-settings='{"_animation":"fadeInUp"}'
                      data-widget_type="rt-post.default"
                    >
                      <div class="elementor-widget-container">
                        <div class="rt-el-post-wrapper blog-grid style2">
                          <div class="row">
                            <div class="col-lg-4 col-md-4 col-sm-12">
                              <div
                                class="blog-box grid-style is-date has-thumbnail"
                              >
                                <div class="post-img show-on-hover">
                                  <a
                                    href="develop-relationships-with-human-resource/index.php"
                                  >
                                    <div
                                      class="thumb-bg"
                                      style="
                                        background-image: url(wp-content/uploads/2020/11/blog-20-370x245.jpg);
                                      "
                                    >
                                      <div class="overlay"></div>
                                    </div>
                                  </a>
                                </div>

                                <div class="thumbnail-date">
                                  <div class="popup-date">
                                    <span class="day">13</span
                                    ><span class="month">Aug</span>
                                  </div>
                                </div>
                                <div class="post-content">
                                  <div class="post-meta is_dots">
                                    <ul class="list-inline">
                                      <li class="category-meta">
                                        <span class="posted-in">
                                          <a
                                            href="category/real-estate/index.php"
                                            rel="category tag"
                                            >Real-estate</a
                                          >
                                        </span>
                                      </li>

                                      <li class="reading-time">
                                        <a
                                          href="#"
                                          data-toggle="tooltip"
                                          data-original-title="Reading Time"
                                          >1 Min</a
                                        >
                                      </li>
                                    </ul>
                                  </div>

                                  <h3 class="post-title">
                                    <a
                                      href="develop-relationships-with-human-resource/index.php"
                                      >Develop Relationships With Human
                                      Resource</a
                                    >
                                  </h3>

                                  <div class="read-more-btn has-icon">
                                    <a
                                      href="develop-relationships-with-human-resource/index.php"
                                      class="item-btn"
                                    >
                                      Read More
                                      <i class="flaticon-right-arrow"></i>
                                    </a>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                              <div
                                class="blog-box grid-style is-date has-thumbnail"
                              >
                                <div class="post-img show-on-hover">
                                  <a
                                    href="connect-with-corporate-recruiters/index.php"
                                  >
                                    <div
                                      class="thumb-bg"
                                      style="
                                        background-image: url(wp-content/uploads/2020/11/6-1-370x245.jpg);
                                      "
                                    >
                                      <div class="overlay"></div>
                                    </div>
                                  </a>
                                </div>

                                <div class="thumbnail-date">
                                  <div class="popup-date">
                                    <span class="day">13</span
                                    ><span class="month">Aug</span>
                                  </div>
                                </div>
                                <div class="post-content">
                                  <div class="post-meta is_dots">
                                    <ul class="list-inline">
                                      <li class="category-meta">
                                        <span class="posted-in">
                                          <a
                                            href="category/building/index.php"
                                            rel="category tag"
                                            >Building</a
                                          >
                                        </span>
                                      </li>

                                      <li class="reading-time">
                                        <a
                                          href="#"
                                          data-toggle="tooltip"
                                          data-original-title="Reading Time"
                                          >1 Min</a
                                        >
                                      </li>
                                    </ul>
                                  </div>

                                  <h3 class="post-title">
                                    <a
                                      href="connect-with-corporate-recruiters/index.php"
                                      >Connect With Corporate Recruiters</a
                                    >
                                  </h3>

                                  <div class="read-more-btn has-icon">
                                    <a
                                      href="connect-with-corporate-recruiters/index.php"
                                      class="item-btn"
                                    >
                                      Read More
                                      <i class="flaticon-right-arrow"></i>
                                    </a>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <div class="col-lg-4 col-md-4 col-sm-12">
                              <div
                                class="blog-box grid-style is-date has-thumbnail"
                              >
                                <div class="post-img show-on-hover">
                                  <a
                                    href="unique-real-estate-marketing-have-a-tent-business-card/index.php"
                                  >
                                    <div
                                      class="thumb-bg"
                                      style="
                                        background-image: url(wp-content/uploads/2020/11/blog-18-370x245.jpg);
                                      "
                                    >
                                      <div class="overlay"></div>
                                    </div>
                                  </a>
                                </div>

                                <div class="thumbnail-date">
                                  <div class="popup-date">
                                    <span class="day">13</span
                                    ><span class="month">Aug</span>
                                  </div>
                                </div>
                                <div class="post-content">
                                  <div class="post-meta is_dots">
                                    <ul class="list-inline">
                                      <li class="category-meta">
                                        <span class="posted-in">
                                          <a
                                            href="category/entertainment/index.php"
                                            rel="category tag"
                                            >Entertainment</a
                                          >
                                        </span>
                                      </li>

                                      <li class="reading-time">
                                        <a
                                          href="#"
                                          data-toggle="tooltip"
                                          data-original-title="Reading Time"
                                          >1 Min</a
                                        >
                                      </li>
                                    </ul>
                                  </div>

                                  <h3 class="post-title">
                                    <a
                                      href="unique-real-estate-marketing-have-a-tent-business-card/index.php"
                                      >Unique Real Estate Marketing: Have A Tent
                                      Business Card</a
                                    >
                                  </h3>

                                  <div class="read-more-btn has-icon">
                                    <a
                                      href="unique-real-estate-marketing-have-a-tent-business-card/index.php"
                                      class="item-btn"
                                    >
                                      Read More
                                      <i class="flaticon-right-arrow"></i>
                                    </a>
                                  </div>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
            <section
              class="elementor-section elementor-top-section elementor-element elementor-element-aa4ab20 elementor-section-content-middle has-placeholder elementor-section-boxed elementor-section-height-default elementor-section-height-default rt-parallax-bg-no"
              data-id="aa4ab20"
              data-element_type="section"
              data-settings='{"background_background":"gradient"}'
            >
              <div class="elementor-container elementor-column-gap-no">
                <div
                  class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-105a45d"
                  data-id="105a45d"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-7defc78 rt-parallax-follow-current-element elementor-invisible elementor-widget elementor-widget-rt-parallax"
                      data-id="7defc78"
                      data-element_type="widget"
                      data-settings='{"_animation":"fadeIn"}'
                      data-widget_type="rt-parallax.default"
                    >
                      <div class="elementor-widget-container">
                        <img
                          decoding="async"
                          width="113"
                          height="113"
                          src="wp-content/uploads/2021/06/cta-parallax-3.png"
                          alt="Animated Image"
                          data-position="-80"
                          class="rt-animated-img motion-effects 1 follow-with-mouse elementor-repeater-item-45e45f6"
                        />
                        <img
                          decoding="async"
                          width="150"
                          height="150"
                          src="wp-content/uploads/2021/09/cta-parallax-2.png"
                          alt="Animated Image"
                          data-position="36"
                          class="rt-animated-img motion-effects 2 follow-with-mouse elementor-repeater-item-5e039c0"
                        />
                        <img
                          decoding="async"
                          width="102"
                          height="102"
                          src="wp-content/uploads/2021/06/cta-parallax-1.png"
                          alt="Animated Image"
                          data-position="80"
                          class="rt-animated-img motion-effects 3 follow-with-mouse elementor-repeater-item-200a465"
                        />
                      </div>
                    </div>
                    <div
                      class="elementor-element elementor-element-5cb59e6 elementor-widget elementor-widget-image"
                      data-id="5cb59e6"
                      data-element_type="widget"
                      data-widget_type="image.default"
                    >
                      <div class="elementor-widget-container">
                        <img
                          loading="lazy"
                          decoding="async"
                          width="169"
                          height="252"
                          src="wp-content/uploads/2021/06/cta-man.png"
                          class="attachment-large size-large wp-image-6257"
                          alt=""
                          title=""
                        />
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-407fa8c"
                  data-id="407fa8c"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-e478b3f elementor-widget elementor-widget-rt-title"
                      data-id="e478b3f"
                      data-element_type="widget"
                      data-widget_type="rt-title.default"
                    >
                      <div class="elementor-widget-container">
                        <div class="section-title-wrapper">
                          Background Title

                          <div class="title-inner-wrapper">
                            Top Sub Title

                            Main Title
                            <h2 class="main-title">
                              Become a Real Estate Agent
                            </h2>

                            Description
                            <div class="description">
                              <p>
                                We only work with the best companies around the
                                globe to survey
                              </p>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <div
                      class="elementor-element elementor-element-759c77a elementor-invisible elementor-widget elementor-widget-rt-image-placeholder"
                      data-id="759c77a"
                      data-element_type="widget"
                      data-settings='{"_animation":"slideInRight"}'
                      data-widget_type="rt-image-placeholder.default"
                    >
                      <div class="elementor-widget-container">
                        <img
                          loading="lazy"
                          decoding="async"
                          width="571"
                          height="371"
                          src="wp-content/uploads/2021/09/video-bg-2.svg"
                          class="rt-image-placeholder"
                          alt="Animated Image"
                          title=""
                        />
                      </div>
                    </div>
                    <div
                      class="elementor-element elementor-element-dc6c589 elementor-invisible elementor-widget elementor-widget-rt-image-placeholder"
                      data-id="dc6c589"
                      data-element_type="widget"
                      data-settings='{"_animation":"slideInLeft"}'
                      data-widget_type="rt-image-placeholder.default"
                    >
                      <div class="elementor-widget-container">
                        <img
                          loading="lazy"
                          decoding="async"
                          width="571"
                          height="371"
                          src="wp-content/uploads/2021/09/video-bg-2.svg"
                          class="rt-image-placeholder"
                          alt="Animated Image"
                          title=""
                        />
                      </div>
                    </div>
                  </div>
                </div>
                <div
                  class="elementor-column elementor-col-33 elementor-top-column elementor-element elementor-element-7d8627a"
                  data-id="7d8627a"
                  data-element_type="column"
                >
                  <div
                    class="elementor-widget-wrap elementor-element-populated"
                  >
                    <div
                      class="elementor-element elementor-element-3a08d53 elementor-align-right elementor-tablet-align-center elementor-button-animation-enable elementor-widget elementor-widget-button"
                      data-id="3a08d53"
                      data-element_type="widget"
                      data-widget_type="button.default"
                    >
                      <div class="elementor-widget-container">
                        <div class="elementor-button-wrapper">
                          <a
                            class="elementor-button elementor-button-link elementor-size-sm"
                            href="#"
                          >
                            <span class="elementor-button-content-wrapper">
                              <span class="elementor-button-text"
                                >Register Now</span
                              >
                            </span>
                          </a>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </section>
          </div>
        </div>
      </div>
       #content -->


   
   

<div class="container">
    <h1>Available Properties</h1>
<!--    <form id="searchForm" class="mb-4">
        <div class="form-row">
            <select name="cid" id="category" >
                <option value="">Select Category</option>
                <?php
                // Fetch categories for dropdown
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
            <div class="col">
                <input type="text" class="form-control" name="address" placeholder="Address">
            </div>
            <div class="col">
                <input type="number" class="form-control" name="rent" placeholder="Max Rent">
            </div>
            <div class="col">
                <input type="number" class="form-control" name="bedroom" placeholder="Bedrooms">
            </div>
            <div class="col">
                <input type="number" class="form-control" name="kitchen" placeholder="Kitchen">
            </div>
            <div class="col">
                <input type="number" class="form-control" name="floor" placeholder="Floor">
            </div>
            <div class="col">
                <select class="form-control" name="parking">
                    <option value="">Parking</option>
                    <option value="1">Yes</option>
                    <option value="0">No</option>
                </select>
            </div>
            <div class="col">
                <input type="number" class="form-control" name="size" placeholder="Size (sq ft)">
            </div>
            <div class="col">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </div>
    </form>-->
    <div id="propertyResults" class="row">
        <?php
        if (count($properties) > 0) {
            foreach ($properties as $property) {
                $details = $property['details'];
                $images = $property['images'];

                echo "<div class='col-md-4'>"; 
                echo "<div class='property'>";
                echo "<h2>" . htmlspecialchars($details['adress']) . "</h2>";
                echo "<p><strong>Rent:</strong> ₹" . number_format($details['rent'], 2) . "</p>";
//                echo "<p><strong>Bedrooms:</strong> " . htmlspecialchars($details['bedroom']) . "</p>";
//                echo "<p><strong>Bathrooms:</strong> " . htmlspecialchars($details['bathroom']) . "</p>";
//                echo "<p><strong>Kitchen:</strong> " . htmlspecialchars($details['kitchen']) . "</p>";
//                echo "<p><strong>Floor:</strong> " . htmlspecialchars($details['floor']) . "</p>";
//                echo "<p><strong>Parking:</strong> " . ($details['parking'] == 1 ? 'Yes' : 'No') . "</p>";
                echo "<p><strong>Size:</strong> " . htmlspecialchars($details['size']) . " sq ft</p>";
                echo "<p><strong>Description:</strong> " . htmlspecialchars($details['description']) . "</p>";

                echo "<div class='slideshow'>";
                echo "<div class='slideshow-images'>";
                foreach ($images as $image) {
                    echo '<img src="data:image/jpeg;base64,' . $image . '" alt="Property Image" />';
                }
                echo "</div></div>";

                echo "<div class='action-icons'>";
               // echo "<a href='#'><i class='fas fa-heart'></i> Save</a>";
                echo "<a href='/houserental-master/homlisti/property/affordable-green-villa-house-for-rent/view_property.php?property_id=".$details['pid']."'><i class='fas fa-eye'></i> View</a>";
                echo "<form action='request_rent.php' method='POST'>";
                echo "<input type='hidden' name='property_id' value='" . $details['pid'] . "' />";
                //echo "<input type='hidden' name='user_id' value='" . $uid . "' />"; 
                echo "<button type='submit' class='request-rent-button'>Request Rent</button>";
                echo "</form>";
                echo "</div>";
                echo "</div>"; 
                echo "</div>"; 
            }
        } else {
            echo "<p>No properties found.</p>";
        }
        ?>
    </div>
</div>
<div class="see-all-container" style="text-align: center; margin-top: 15px;">
    <a href="../homlisti/property/affordable-green-villa-house-for-rent/index.php" class="see-all-button">See All Properties</a>
</div>

<style>
.see-all-button {
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    color: #fff;
    background-color: #007bff;
    text-decoration: none;
    border-radius: 5px;
    transition: background-color 0.3s;
}

.see-all-button:hover {
    background-color: lightblue;
}
</style>
    

      <footer id="site-footer" class="site-footer footer-wrap footer-style-2">
        <div class="main-footer" style="">
          <div class="container">
            <div class="row">
              <div class="col-lg-3 col-sm-6 col-12">
                <div
                  id="homlisti_about-2"
                  class="footer-box widget_homlisti_about"
                >
                  <div class="footer-logo two">
                    <a href="index.php"
                      ><img
                        src="wp-content/uploads/2023/02/logo_light.svg"
                        alt="Footer light Logo"
                        width="148"
                        height="39"
                    /></a>
                  </div>
                  <p>
                    Lorem ipsum dolor sit amet, consectetur adipisicing elit,
                    sed do eiusmod tempor incididunt ut labore et dolore magna
                    aliqua. Ut enim ad minim veniam
                  </p>
                  <ul class="footer-social">
                    <li class="rtin-facebook">
                      <a href="#" target="_blank"
                        ><i class="fab fa-facebook-f"></i
                      ></a>
                    </li>
                    <li class="rtin-twitter">
                      <a href="#" target="_blank"
                        ><i class="fab fa-x-twitter"></i
                      ></a>
                    </li>
                    <li class="rtin-linkedin">
                      <a href="#" target="_blank"
                        ><i class="fab fa-linkedin-in"></i
                      ></a>
                    </li>
                    <li class="rtin-pinterest">
                      <a href="#" target="_blank"
                        ><i class="fab fa-pinterest-p"></i
                      ></a>
                    </li>
                    <li class="rtin-instagram">
                      <a href="#" target="_blank"
                        ><i class="fab fa-instagram"></i
                      ></a>
                    </li>
                  </ul>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 col-12">
                <div id="nav_menu-3" class="footer-box widget_nav_menu">
                  <h3 class="footer-title">Quick Links</h3>
                  <div class="menu-quick-links-container">
                    <ul id="menu-quick-links" class="menu">
                      <li
                        id="menu-item-8593"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8593"
                      >
                        <a href="about/index.php">About Us</a>
                      </li>
                      <li
                        id="menu-item-15814"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-15814"
                      >
                        <a href="blog/index.php">Blog &#038; Articles</a>
                      </li>
                      <li
                        id="menu-item-15823"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-15823"
                      >
                        <a href="terms-and-conditions/index.php"
                          >Terms and Conditions</a
                        >
                      </li>
                      <li
                        id="menu-item-16012"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-privacy-policy menu-item-16012"
                      >
                        <a rel="privacy-policy" href="privacy-policy/index.php"
                          >Privacy Policy</a
                        >
                      </li>
                      <li
                        id="menu-item-8594"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-8594"
                      >
                        <a href="contact/index.php">Contact Us</a>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 col-12">
                <div
                  id="mc4wp_form_widget-2"
                  class="footer-box widget_mc4wp_form_widget"
                >
                  <h3 class="footer-title">Newsletter</h3>
                  <script>
                    (function () {
                      window.mc4wp = window.mc4wp || {
                        listeners: [],
                        forms: {
                          on: function (evt, cb) {
                            window.mc4wp.listeners.push({
                              event: evt,
                              callback: cb,
                            });
                          },
                        },
                      };
                    })();
                  </script>
                  <!-- Mailchimp for WordPress v4.9.14 - https://wordpress.org/plugins/mailchimp-for-wp/ -->
                  <form
                    id="mc4wp-form-1"
                    class="mc4wp-form mc4wp-form-7934"
                    method="post"
                    data-id="7934"
                    data-name="Subscribe"
                  >
                    <div class="mc4wp-form-fields">
                      <div class="rt-mailchimp-wrap">
                        <input
                          type="email"
                          name="EMAIL"
                          placeholder="Enter e-mail addess"
                          required
                          class="form-control"
                        />
                        <div class="rt-animation-btn">
                          <input type="submit" value="Subscribe" />
                        </div>
                      </div>
                    </div>
                    <label style="display: none !important"
                      >Leave this field empty if you're human:
                      <input
                        type="text"
                        name="_mc4wp_honeypot"
                        value=""
                        tabindex="-1"
                        autocomplete="off" /></label
                    ><input
                      type="hidden"
                      name="_mc4wp_timestamp"
                      value="1721902456"
                    /><input
                      type="hidden"
                      name="_mc4wp_form_id"
                      value="7934"
                    /><input
                      type="hidden"
                      name="_mc4wp_form_element_id"
                      value="mc4wp-form-1"
                    />
                    <div class="mc4wp-response"></div>
                  </form>
                  <!-- / Mailchimp for WordPress Plugin -->
                </div>
                <div id="text-2" class="footer-box widget_text">
                  <div class="textwidget"><p>We never span you!</p></div>
                </div>
              </div>
              <div class="col-lg-3 col-sm-6 col-12">
                <div
                  id="rt_contact_widget-5"
                  class="footer-box widget_rt_contact_widget"
                >
                  <h3 class="footer-title">Contact</h3>
                  <div class="rt-contact-wrapper">
                    <ul>
                      <li>
                        <i class="fas fa-map-marker-alt"></i>
                        <p>121 King St, Melbourne den 3000, Australia</p>
                      </li>

                      <li>
                        <i class="fas fa-envelope"></i>
                        <p>
                          <a target="_blank" href="mailto:info@example.com"
                            >info@example.com</a
                          >
                        </p>
                      </li>

                      <li>
                        <i class="fas fa-phone-alt"></i>
                        <p>
                          <a target="_blank" href="tel:+123-596-000"
                            >+123-596-000</a
                          >
                        </p>
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="footer-bottom">
          <div class="container">
            <div class="row">
              <div class="col-xl-6 col-lg-8">
                <div class="footer-bottom-menu">
                  <div class="menu-footer-menu-container">
                    <ul id="menu-footer-menu" class="footer-link">
                      <li
                        id="menu-item-15964"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-15964"
                      >
                        <a href="terms-and-conditions/index.php"
                          >Terms of Use</a
                        >
                      </li>
                      <li
                        id="menu-item-8232"
                        class="menu-item menu-item-type-post_type menu-item-object-page menu-item-privacy-policy menu-item-8232"
                      >
                        <a rel="privacy-policy" href="privacy-policy/index.php"
                          >Privacy Policy</a
                        >
                      </li>
                    </ul>
                  </div>
                </div>
              </div>
              <div class="col-xl-6 col-lg-4 text-right">
                <p class="footer-copyright">
                  2022© All right reserved by RadiusTheme
                </p>
              </div>
            </div>
          </div>
        </div>
      </footer>
    </div>
    <!-- #page -->
    <a href="#" class="scrollToTop" style=""
      ><i class="fa fa-angle-double-up"></i
    ></a>
    <script>
      (function () {
        function maybePrefixUrlField() {
          const value = this.value.trim();
          if (value !== "" && value.indexOf("http") !== 0) {
            this.value = "http://" + value;
          }
        }

        const urlFields = document.querySelectorAll(
          '.mc4wp-form input[type="url"]'
        );
        for (let j = 0; j < urlFields.length; j++) {
          urlFields[j].addEventListener("blur", maybePrefixUrlField);
        }
      })();
    </script>
    <script type="text/javascript">
      const lazyloadRunObserver = () => {
        const lazyloadBackgrounds = document.querySelectorAll(
          `.e-con.e-parent:not(.e-lazyloaded)`
        );
        const lazyloadBackgroundObserver = new IntersectionObserver(
          (entries) => {
            entries.forEach((entry) => {
              if (entry.isIntersecting) {
                let lazyloadBackground = entry.target;
                if (lazyloadBackground) {
                  lazyloadBackground.classList.add("e-lazyloaded");
                }
                lazyloadBackgroundObserver.unobserve(entry.target);
              }
            });
          },
          { rootMargin: "200px 0px 200px 0px" }
        );
        lazyloadBackgrounds.forEach((lazyloadBackground) => {
          lazyloadBackgroundObserver.observe(lazyloadBackground);
        });
      };
      const events = ["DOMContentLoaded", "elementor/lazyload/observe"];
      events.forEach((event) => {
        document.addEventListener(event, lazyloadRunObserver);
      });
    </script>
    <script type="text/javascript">
      var c = document.body.className;
      c = c.replace(/rtcl-no-js/, "rtcl-js");
      document.body.className = c;
    </script>
    <link
      rel="stylesheet"
      id="wpo_min-footer-0-css"
      href="wp-content/cache/wpo-minify/1721845095/assets/wpo-minify-footer-61fc209b.min.css"
      type="text/css"
      media="all"
    />
    <script type="text/javascript" id="wpo_min-footer-0-js-extra">
      /* <![CDATA[ */
      var rtcl = {
        plugin_url:
          "https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-content\/plugins\/classified-listing",
        decimal_point: ".",
        i18n_required_rating_text: "Please select a rating",
        i18n_decimal_error:
          "Please enter in decimal (.) format without thousand separators.",
        i18n_mon_decimal_error:
          "Please enter in monetary decimal (.) format without thousand separators and currency symbols.",
        is_rtl: "",
        is_admin: "",
        ajaxurl:
          "https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-admin\/admin-ajax.php",
        confirm_text: "Are you sure?",
        re_send_confirm_text:
          "Are you sure you want to re-send verification link?",
        __rtcl_wpnonce: "0f6673356d",
        rtcl_listing_base:
          "https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/all-properties\/",
        rtcl_category: "",
        rtcl_category_base: "listing-category",
        category_text: "Category",
        go_back: "Go back",
        location_text: "Location",
        rtcl_location: "",
        rtcl_location_base: "listing-location",
        user_login_alert_message: "Sorry, you need to login first.",
        upload_limit_alert_message: "Sorry, you have only %d images pending.",
        delete_label: "Delete Permanently",
        proceed_to_payment_btn_label: "Proceed to payment",
        finish_submission_btn_label: "Finish submission",
        phone_number_placeholder: "XXX",
        popup_search_widget_auto_form_submission: "1",
        loading: "Loading ...",
        is_listing: "0",
        is_listings: "",
        listing_term: "",
        has_map: "1",
        online_status_seconds: "300",
        online_status_offline_text: "Offline Now",
        online_status_online_text: "Online Now",
      };
      var rtclAjaxFilterObj = {
        clear_all_filter: "Clear all filters",
        no_result_found: "No result found.",
        result_count: {
          all: "Showing all % results",
          part: "Showing _ of % results",
        },
        filter_scroll_offset: "50",
      };
      var rtcl_map = {
        plugin_url:
          "https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-content\/plugins\/classified-listing",
        location: "local",
        center: {
          address: "New York United States",
          lat: "43.1561681",
          lng: "-75.8449946",
        },
        zoom: { default: 17, search: 17 },
        cluster_options: {
          center: { lat: 0, lng: 0 },
          max_zoom: 18,
          zoom: 3,
          scroll_wheel: false,
          fit_bound: true,
        },
      };
      var HomListiObj = {
        ajaxUrl:
          "https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-admin\/admin-ajax.php",
        appendHtml: "",
        themeUrl:
          "https:\/\/www.radiustheme.com\/demo\/wordpress\/themes\/homlisti\/wp-content\/themes\/homlisti",
        lsSideOffset: "130",
        rtStickySidebar: "enable",
        rtMagnificPopup: "enable",
      };
      var rtcl_single_listing_localized_params = {
        slider_options: { rtl: false, autoHeight: true },
        slider_enabled: "1",
        zoom_enabled: "1",
        photoswipe_enabled: "1",
        photoswipe_options: {
          shareEl: false,
          closeOnScroll: false,
          history: false,
          hideAnimationDuration: 0,
          showAnimationDuration: 0,
        },
        zoom_options: [],
      };
      /* ]]> */
    </script>
    <script>
      var wpo_server_info_js = {
        user_agent:
          "Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/126.0.0.0 Safari\/537.36",
      };
      loadAsync(
        "wp-content/cache/wpo-minify/1721845095/assets/wpo-minify-footer-a673c275.min.js",
        null
      );
    </script>
    <script>
      var wpo_server_info_js = {
        user_agent:
          "Mozilla\/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit\/537.36 (KHTML, like Gecko) Chrome\/126.0.0.0 Safari\/537.36",
      };
      loadAsync(
        "wp-content/cache/wpo-minify/1721845095/assets/wpo-minify-footer-75cf087f.min.js",
        null
      );
    </script>
    <script type="application/ld+json">
      {
        "@context": "https://schema.org",
        "@type": "LocalBusiness"
      }
    </script>
    <script type="application/javascript">
      (function ($) {
        var emi_result = $("#mortgage-calculator .emi-text");
        var mortgage_form = $("#mortgage-calculator .mortgage-form");
        mortgage_form.on("submit", function (e) {
          e.preventDefault();
          var rt_amount = $(this).find(".rt_amount").val();
          var rt_deposit = $(this).find(".rt_deposit").val();
          var rt_year = $(this).find(".rt_year").val();
          var rt_rate = $(this).find(".rt_rate").val();

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

        $(".mortgage-calculator .form-group .reset-btn").on(
          "click",
          function (e) {
            e.preventDefault();
            $(":input", ".mortgage-form")
              .not(":button, :submit, :reset, :hidden")
              .val("")
              .removeAttr("checked")
              .removeAttr("selected");

            $(".mortgage-calculator .emi-text span").remove();
          }
        );
      })(jQuery);
    </script>
  </body>

  <!-- Mirrored from www.radiustheme.com/demo/wordpress/themes/homlisti/ by HTTrack Website Copier/3.x [XR&CO'2014], Thu, 25 Jul 2024 13:22:23 GMT -->
</html>
<!-- Cached by WP-Optimize - https://getwpo.com - Last modified: July 25, 2024 10:14 am (UTC:0) -->
