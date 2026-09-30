<!DOCTYPE html>
<html lang="en-IN" class="no-js">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script>document.documentElement.className = document.documentElement.className.replace('no-js','js');</script>

<?php require_once __DIR__ . '/seo.php';

/* A page may omit any of these; fall back to sane values rather than
   emitting "Undefined variable" notices into the <head> (this happened in
   production - see error_log). */
$metatitle    = isset($metatitle) && trim($metatitle) !== '' ? $metatitle : SITE_NAME;
$metadesc     = isset($metadesc)  && trim($metadesc)  !== '' ? $metadesc
                  : SITE_NAME . ' - textile machinery manufacturer and exporter in Ahmedabad, India.';
$metakeywords = isset($metakeywords) ? $metakeywords : '';
$nofollow     = !empty($nofollow);
$canonical    = niruma_current_url();
?>

  <!-- ===== Primary SEO ===== -->
  <title><?php echo htmlspecialchars($metatitle, ENT_QUOTES); ?></title>
  <meta name="description" content="<?php echo htmlspecialchars($metadesc, ENT_QUOTES); ?>">
<?php if ($metakeywords !== ''): ?>
  <meta name="keywords" content="<?php echo htmlspecialchars($metakeywords, ENT_QUOTES); ?>">
<?php endif; ?>
  <meta name="author" content="<?php echo SITE_NAME; ?>">
  <meta name="publisher" content="<?php echo SITE_NAME; ?>">
  <meta name="robots" content="<?php echo $nofollow ? 'noindex, nofollow' : 'index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1'; ?>">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta name="language" content="English">
  <meta name="rating" content="general">
  <link rel="canonical" href="<?php echo $canonical; ?>">
  <link rel="alternate" media="only screen and (max-width: 640px)" href="<?php echo $canonical; ?>">

  <!-- ===== Geo / Local signals ===== -->
  <meta name="geo.region" content="IN-GJ">
  <meta name="geo.placename" content="<?php echo NAP_CITY . ', ' . NAP_REGION; ?>">
  <meta name="geo.position" content="<?php echo SITE_GEO_LAT . ';' . SITE_GEO_LNG; ?>">
  <meta name="ICBM" content="<?php echo SITE_GEO_LAT . ', ' . SITE_GEO_LNG; ?>">
  <meta name="DC.creator" content="<?php echo SITE_NAME; ?>">
  <meta name="DC.subject" content="<?php echo htmlspecialchars($metadesc, ENT_QUOTES); ?>">

  <!-- ===== Open Graph ===== -->
  <meta property="og:type" content="<?php echo $ogtype; ?>">
  <meta property="og:site_name" content="<?php echo SITE_NAME; ?>">
  <meta property="og:locale" content="<?php echo SITE_LOCALE; ?>">
  <meta property="og:title" content="<?php echo htmlspecialchars($metatitle, ENT_QUOTES); ?>">
  <meta property="og:description" content="<?php echo htmlspecialchars($metadesc, ENT_QUOTES); ?>">
  <meta property="og:url" content="<?php echo $canonical; ?>">
  <meta property="og:image" content="<?php echo niruma_media_url($ogimage); ?>">
  <meta property="og:image:alt" content="<?php echo htmlspecialchars($metatitle, ENT_QUOTES); ?>">
<?php
/* Declare the real pixel size of the OG image. These were hardcoded to
   1200x630 while every product image is 1288x600, so scrapers were told
   the wrong dimensions. */
list($_ogW, $_ogH) = niruma_image_size($ogimage, 1200, 630);
?>
  <meta property="og:image:width" content="<?php echo $_ogW; ?>">
  <meta property="og:image:height" content="<?php echo $_ogH; ?>">
  <meta property="og:image:type" content="image/webp">

  <!-- ===== Twitter Card ===== -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:site" content="@nirumatextilemachinery">
  <meta name="twitter:creator" content="@nirumatextilemachinery">
  <meta name="twitter:title" content="<?php echo htmlspecialchars($metatitle, ENT_QUOTES); ?>">
  <meta name="twitter:description" content="<?php echo htmlspecialchars($metadesc, ENT_QUOTES); ?>">
  <meta name="twitter:image" content="<?php echo niruma_media_url($ogimage); ?>">

  <!-- ===== Favicons ===== -->
  <link href="<?php echo niruma_asset('img/favicon-32x32.png'); ?>" rel="icon" type="image/png" sizes="32x32">
  <link href="<?php echo niruma_asset('img/favicon-32x32.png'); ?>" rel="icon" type="image/png" sizes="16x16">
  <link href="<?php echo niruma_asset('img/apple-touch-icon.png'); ?>" rel="apple-touch-icon" sizes="180x180">
  <link href="<?php echo niruma_asset('img/android-chrome-192x192.png'); ?>" rel="icon" type="image/png" sizes="192x192">
  <link href="<?php echo niruma_asset('img/android-chrome-512x512.png'); ?>" rel="icon" type="image/png" sizes="512x512">
  <link href="<?php echo niruma_url('sitemap.xml'); ?>" rel="sitemap" type="application/xml">
  <meta name="theme-color" content="#005e72">

  <!-- Google tag (gtag.js) -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-HW31MCBDEZ"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-HW31MCBDEZ');
</script>

  <!-- ===== Structured data ===== -->
  <script type="application/ld+json">
<?php
$graph = array(
    '@context' => 'https://schema.org',
    '@graph'   => array(
        niruma_organization_schema(),
        niruma_website_schema(),
    ),
);

if (!empty($breadcrumbs)) {
    $graph['@graph'][] = niruma_breadcrumb_schema($breadcrumbs);
}
foreach ((array) $schema as $s) {
    if ($s) $graph['@graph'][] = $s;
}
echo niruma_json($graph);
?>
  </script>

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Roboto:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i&display=swap" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="<?php echo niruma_asset('vendor/aos/aos.css'); ?>" rel="stylesheet">
  <link href="<?php echo niruma_asset('vendor/bootstrap/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo niruma_asset('vendor/bootstrap-icons/bootstrap-icons.css'); ?>" rel="stylesheet">
  <link href="<?php echo niruma_asset('vendor/boxicons/css/boxicons.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo niruma_asset('vendor/glightbox/css/glightbox.min.css'); ?>" rel="stylesheet">
  <link href="<?php echo niruma_asset('vendor/swiper/swiper-bundle.min.css'); ?>" rel="stylesheet">

  <link href="<?php echo niruma_asset('css/style.css'); ?>" rel="stylesheet">

</head>

<body id="top">

  <a class="ntm-skip" href="#main">Skip to main content</a>

  <!-- ======= Top Bar ======= -->
  <section id="topbar" class="d-flex align-items-center">
    <div class="container d-flex justify-content-center justify-content-md-between">
      <div class="contact-info">
        <a class="topbar-link" href="mailto:<?php echo EMAIL_PRIMARY; ?>"><i class="bi bi-envelope" aria-hidden="true"></i> <?php echo EMAIL_PRIMARY; ?></a>
        <a class="topbar-link" href="tel:<?php echo PHONE_PRIMARY_TEL; ?>"><i class="bi bi-telephone" aria-hidden="true"></i> <?php echo PHONE_PRIMARY; ?></a>
        <a class="topbar-link" href="tel:<?php echo PHONE_SECONDARY_TEL; ?>"><i class="bi bi-telephone" aria-hidden="true"></i> <?php echo PHONE_SECONDARY; ?></a>
      </div>
      <div class="social-links d-none d-md-flex align-items-center">
        <span class="topbar-label">Our Social Networks</span>
        <a href="<?php echo SOCIAL_YOUTUBE; ?>" class="youtube" target="_blank" rel="noopener" aria-label="Niruma Textile Machinery on YouTube"><i class="bi bi-youtube" aria-hidden="true"></i></a>
      </div>
    </div>
  </section>

  <!-- ======= Header ======= -->
  <header id="header" class="d-flex align-items-center">
    <div class="container d-flex align-items-center justify-content-between">

      <?php /* Single home link in the header. Previously this block rendered a
                 text wordmark AND an image logo, both linking to the homepage,
                 which produced two adjacent home links per page. The image
                 logo is now the only one, and the wordmark is kept as
                 accessible text inside it rather than a second link. */ ?>
      <a href="<?php echo niruma_url(''); ?>" class="logo" aria-label="<?php echo SITE_NAME; ?> &ndash; home">
        <img src="<?php echo niruma_asset('img/logo.png'); ?>" width="145" height="96" alt="<?php echo SITE_NAME; ?>" fetchpriority="high" decoding="async">
      </a>

      <nav id="navbar" class="navbar" aria-label="Main navigation">
        <ul>
          <li><a class="nav-link scrollto" href="<?php echo niruma_url('products'); ?>">Products</a></li>
          <li><a class="nav-link scrollto" href="<?php echo niruma_url('about-us'); ?>">About Us</a></li>
          <li class="dropdown"><a href="<?php echo niruma_url('products'); ?>"><span>Machine Range</span> <i class="bi bi-chevron-down" aria-hidden="true"></i></a>
            <ul>
              <li><a href="<?php echo niruma_url('fully-automatic-sample-cutting-machine'); ?>">Fully Automatic Sample Cutting Machine</a></li>
              <li><a href="<?php echo niruma_url('automatic-sample-cutting-machine'); ?>">Automatic Sample Cutting Machine</a></li>
              <li><a href="<?php echo niruma_url('semi-automatic-sample-cutting-machine'); ?>">Semi Automatic Sample Cutting Machine</a></li>
              <li><a href="<?php echo niruma_url('lever-press-zig-zag-cutting-machine'); ?>">Lever Press Zigzag Cutting Machine</a></li>
              <li><a href="<?php echo niruma_url('fabric-roll-wrapping-machine'); ?>">Fabric Roll Wrapping Machine</a></li>
              <li><a href="<?php echo niruma_url('fabric-inspection-machine'); ?>">Fabric Inspection Machine</a></li>
              <li><a href="<?php echo niruma_url('manual-sample-cutting-machine'); ?>">Manual Sample Cutting Machine</a></li>
              <li><a href="<?php echo niruma_url('fabric-rolling-machine'); ?>">Fabric Rolling Machine</a></li>
              <li><a href="<?php echo niruma_url('fabric-folding-machine'); ?>">Fabric Folding Machine</a></li>
              <li><a href="<?php echo niruma_url('taka-folding-machine'); ?>">Taka Folding Machine</a></li>
              <li><a href="<?php echo niruma_url('batching-motion-for-looms'); ?>">Batching Motion for Looms</a></li>
            </ul>
          </li>
          <li><a class="nav-link" href="<?php echo niruma_url('Niruma-TM-Catalogue.pdf'); ?>" download>Download Brochure</a></li>
          <li><a class="nav-link scrollto" href="<?php echo niruma_url('contact-us'); ?>">Contact Us</a></li>
        </ul>
        <button class="mobile-nav-toggle" type="button" aria-label="Toggle navigation menu" aria-expanded="false" aria-controls="navbar">
          <i class="bi bi-list" aria-hidden="true"></i>
        </button>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

<?php echo niruma_render_breadcrumbs($breadcrumbs); ?>