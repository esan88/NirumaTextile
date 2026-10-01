<?php
/**
 * Products hub page - served at /products
 *
 * A dedicated, indexable category page. Previously every "view all machines"
 * link pointed at /#products on the homepage, which produced duplicate home
 * links on each product page and left the whole range reachable only through
 * JavaScript-free anchors on a single URL.
 */
require_once __DIR__ . '/seo.php';

$metatitle = 'Textile Machinery Products | Sample Cutting, Inspection & Folding | Niruma';
$title     = $metatitle;
$metadesc  = 'Complete range of textile machinery from Niruma: automatic, semi-automatic, lever press and manual fabric sample cutting machines, fabric inspection, rolling, folding, roll wrapping machines and loom batching motions.';
$metakeywords = 'textile machinery products, fabric sample cutting machines, fabric inspection machine, fabric rolling machine, fabric folding machine, fabric roll wrapping machine, loom batching motion, textile machinery range';
$ogimage   = 'assets/img/portfolio/Fully-Automatic-Sample-Cutting-Machine-Niruma.webp';
$ogtype    = 'website';

$breadcrumbs = array(
    array('name' => 'Home', 'url' => '/'),
    array('name' => 'Products'),
);

$products = niruma_products();

/**
 * Product groups, ordered as they should appear on the page.
 * Keyed by label, each entry lists the product slugs belonging to it.
 */
$groups = array(
    'Fabric Sample Cutting Machines' => array(
        'fully-automatic-sample-cutting-machine',
        'automatic-sample-cutting-machine',
        'semi-automatic-sample-cutting-machine',
        'lever-press-zig-zag-cutting-machine',
        'manual-sample-cutting-machine',
    ),
    'Fabric Inspection, Rolling & Folding' => array(
        'fabric-inspection-machine',
        'fabric-rolling-machine',
        'fabric-folding-machine',
        'taka-folding-machine',
    ),
    'Packing & Batching' => array(
        'fabric-roll-wrapping-machine',
        'batching-motion-for-looms',
    ),
);

// Re-index the catalogue by slug so groups can be resolved in order.
$by_slug = array();
foreach ($products as $p) {
    $by_slug[$p['slug']] = $p;
}

// Flat ordered list for the ItemList structured data.
$ordered = array();
foreach ($groups as $slugs) {
    foreach ($slugs as $s) {
        if (isset($by_slug[$s])) {
            $ordered[] = $by_slug[$s];
        }
    }
}

$schema = array(
    array(
        '@type'       => 'CollectionPage',
        '@id'         => SITE_URL . '/products#webpage',
        'url'         => SITE_URL . '/products',
        'name'        => $metatitle,
        'description' => $metadesc,
        'isPartOf'    => array('@id' => SITE_URL . '/#website'),
        'inLanguage'  => SITE_LANG,
    ),
    array(
        '@type'        => 'ItemList',
        '@id'          => SITE_URL . '/products#itemlist',
        'name'         => 'Textile Machinery Products',
        'itemListOrder' => 'https://schema.org/ItemListOrderAscending',
        'numberOfItems' => count($ordered),
        'itemListElement' => array(),
    ),
);
foreach ($ordered as $n => $p) {
    $schema[1]['itemListElement'][] = array(
        '@type'    => 'ListItem',
        'position' => $n + 1,
        'url'      => SITE_URL . '/' . $p['slug'],
        'name'     => $p['name'],
    );
}

include __DIR__ . '/header.php';
?>

  <!-- ======= Page hero ======= -->
  <main id="main"><section id="hero" class="ntm-page-hero">
    <div class="container">
      <h1>Textile Machinery <span>Products</span></h1>
      <p class="hero-lead">Eleven machines covering the fabric sample cutting, inspection, rolling, folding, packing and batching stages of a textile unit &mdash; manufactured and exported by <?php echo SITE_NAME; ?> since <?php echo FOUNDED_YEAR; ?>.</p>
      <div class="d-flex flex-wrap ntm-hero-actions">
        <a href="#inquiry" class="btn-get-started scrollto">Request a Quotation</a>
        <a href="<?php echo niruma_url('Niruma-TM-Catalogue.pdf'); ?>" class="ntm-hero-secondary" download>Download Catalogue (PDF)</a>
      </div>
    </div>
  </section>

  <!-- ======= Product groups ======= -->
  <section id="product-range" class="portfolio section-bg">
    <div class="container">

      <nav class="ntm-jumpnav" aria-label="Product categories">
        <span class="ntm-jumpnav__label">Jump to</span>
        <ul>
<?php $gi = 0; foreach ($groups as $label => $slugs) : $gi++; ?>
          <li><a href="#group-<?php echo $gi; ?>"><?php echo htmlspecialchars($label, ENT_QUOTES); ?></a></li>
<?php endforeach; ?>
        </ul>
      </nav>

<?php $gi = 0; foreach ($groups as $label => $slugs) : $gi++; ?>
      <div class="ntm-group" id="group-<?php echo $gi; ?>">
        <h2 class="ntm-group__title"><?php echo htmlspecialchars($label, ENT_QUOTES); ?></h2>
        <div class="row portfolio-container">
<?php
foreach ($slugs as $s) :
    if (!isset($by_slug[$s])) continue;
    $p = $by_slug[$s];
?>
          <div class="col-lg-4 col-md-6 portfolio-item">
            <a class="ntm-card__media" href="<?php echo niruma_url($p['slug']); ?>" tabindex="-1" aria-hidden="true">
              <img src="<?php echo niruma_media_url($p['img']); ?>" width="1288" height="600" loading="lazy" decoding="async" alt="">
            </a>
            <div class="portfolio-info">
              <h3><a href="<?php echo niruma_url($p['slug']); ?>"><?php echo htmlspecialchars($p['short'], ENT_QUOTES); ?></a></h3>
              <p><?php echo htmlspecialchars($p['desc'], ENT_QUOTES); ?></p>
              <a href="<?php echo niruma_url($p['slug']); ?>" class="details-link">Specifications &amp; Features <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
            </div>
          </div>
<?php endforeach; ?>
        </div>
      </div>
<?php endforeach; ?>

      <div class="ntm-note">
        <h2>Not sure which machine fits your line?</h2>
        <p>Send us your fabric type, maximum layer thickness in millimetres, required sample width and monthly order volume. Our engineers will recommend a configuration and send a written quotation &mdash; usually within one working day.</p>
      </div>

    </div>
  </section>

  <!-- ======= Enquiry ======= -->
  <section id="inquiry" class="contact">
    <div class="container">
      <div class="section-title">
        <h2>Enquiry</h2>
        <h3>Request a <span>Quotation</span></h3>
        <p>Tell us the machine and the fabric you work with</p>
      </div>

      <div class="row">
        <div class="col-lg-7">
          <form action="<?php echo niruma_url('enquiry'); ?>" method="post" role="form" class="php-email-form">
            <div class="ntm-hp" aria-hidden="true"><label for="ntm_website">Leave this field empty</label><input type="text" id="ntm_website" name="ntm_website" value="" tabindex="-1" autocomplete="off"></div>
            <input type="hidden" name="product" value="General enquiry &ndash; product list">
            <div class="row">
              <div class="col form-group">
                <label for="p-name">Your Name</label>
                <input type="text" name="name" class="form-control" id="p-name" placeholder="Your Name" required>
              </div>
              <div class="col form-group">
                <label for="p-email">Your Email</label>
                <input type="email" name="email" class="form-control" id="p-email" placeholder="Your Email" required>
              </div>
            </div>
            <div class="row">
              <div class="col form-group">
                <label for="p-phone">Phone / WhatsApp</label>
                <input type="tel" name="phone" class="form-control" id="p-phone" placeholder="Phone / WhatsApp">
              </div>
              <div class="col form-group">
                <label for="p-subject">Subject</label>
                <input type="text" name="subject" class="form-control" id="p-subject" value="Enquiry: product list" required>
              </div>
            </div>
            <div class="form-group">
              <label for="p-message">Requirement</label>
              <textarea class="form-control" name="message" id="p-message" rows="5" placeholder="Machine(s) of interest, fabric type, maximum layer thickness in mm, quantity, delivery location…" required></textarea>
            </div>
            <div class="my-3">
              <div class="loading">Sending&hellip;</div>
              <div class="error-message"></div>
              <div class="sent-message">Thank you! Your enquiry has been received.</div>
            </div>
            <div class="text-center"><button type="submit">Send Enquiry</button></div>
          </form>
        </div>
        <div class="col-lg-5">
          <div class="info-box mb-4">
            <i class="bx bx-map" aria-hidden="true"></i>
            <h3>Factory Address</h3>
            <p><?php echo NAP_STREET; ?><br>Near S. P. Ring Road, <?php echo NAP_CITY; ?> &ndash; <?php echo NAP_POSTCODE; ?>, <?php echo NAP_REGION; ?>, India</p>
          </div>
          <div class="info-box mb-4">
            <i class="bx bx-phone-call" aria-hidden="true"></i>
            <h3>Call / WhatsApp</h3>
            <p><a href="tel:<?php echo PHONE_PRIMARY_TEL; ?>"><?php echo PHONE_PRIMARY; ?></a></p>
            <p><a href="tel:<?php echo PHONE_SECONDARY_TEL; ?>"><?php echo PHONE_SECONDARY; ?></a></p>
          </div>
          <div class="info-box">
            <i class="bx bx-envelope" aria-hidden="true"></i>
            <h3>Email Us</h3>
            <p><a href="mailto:<?php echo EMAIL_PRIMARY; ?>"><?php echo EMAIL_PRIMARY; ?></a></p>
          </div>
        </div>
      </div>
    </div>
  </section>
</main>

  <?php include __DIR__ . '/footer.php'; ?>
