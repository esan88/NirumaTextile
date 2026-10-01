<?php
/**
 * Shared product page template.
 *
 * Every product .php file only needs to define $P and include this file.
 *
 * $P keys:
 *   slug, name, h1, meta_title, meta_desc, keywords, image (og),
 *   gallery[]      - array of image paths (first is used in Product schema)
 *   intro[]        - array of HTML paragraphs (1-3 paragraphs, keyword rich)
 *   features[]     - array of plain-text feature strings
 *   why[]          - array of ['t' => bold lead-in, 'd' => description]
 *   specs          - array of ['Model' => 'Value', ...] or [['h'=>..,'r'=>[['k'=>..,'v'=>..]]]]
 *   applications[] - array of plain-text strings
 *   notes          - HTML paragraph(s) on operation / selection
 *   faqs[]         - array of ['q' => .., 'a' => ..]
 *   related[]      - array of product slugs
 *   enquiry_hints[]- array of strings shown beside the form
 *   cta_head, cta_sub - optional CTA overrides
 */

if (!isset($P)) {
    http_response_code(500);
    exit('Product configuration ($P) missing.');
}

$slug = $P['slug'];

$metatitle = $P['meta_title'];
$title     = $metatitle;
$metadesc  = $P['meta_desc'];
$metakeywords = isset($P['keywords']) ? $P['keywords'] : '';
$ogimage   = $P['image'];
$ogtype    = 'product';

$breadcrumbs = array(
    array('name' => 'Home', 'url' => '/'),
    array('name' => 'Products', 'url' => '/products'),
    array('name' => $P['name']),
);

$related_products = array();
if (!empty($P['related'])) {
    foreach ($P['related'] as $rs) {
        foreach (niruma_products() as $cp) {
            if ($cp['slug'] === $rs) { $related_products[] = $cp; break; }
        }
    }
}

$schema = array(
    array(
        '@type' => 'WebPage',
        '@id'   => SITE_URL . '/' . $slug . '#webpage',
        'url'   => SITE_URL . '/' . $slug,
        'name'  => $metatitle,
        'isPartOf'   => array('@id' => SITE_URL . '/#website'),
        'breadcrumb' => array('@id' => SITE_URL . '/' . $slug . '#breadcrumb'),
        'inLanguage' => SITE_LANG,
        'description' => $metadesc,
    ),
    niruma_product_schema(array(
        'name'        => $P['name'],
        'description' => strip_tags($metadesc),
        'image'       => $P['image'],
        'sku'         => 'NIR-TM-' . strtoupper(substr(str_replace('-', '', $slug), 0, 10)),
        'category'    => isset($P['category']) ? $P['category'] : 'Textile Machinery',
        // Only emit an Offer when a real price is configured. Quotation-only
        // products deliberately have no Offer so no invalid price is marked up.
        'offers'      => !empty($P['offers']) ? $P['offers'] : null,
    )),
);
if (!empty($P['faqs'])) {
    $fs = niruma_faq_schema($P['faqs']);
    if ($fs) $schema[] = $fs;
}

include __DIR__ . '/header.php';

/* ------------------------------------------------------------------
 * Gallery helpers
 * ------------------------------------------------------------------ */

/** Flatten $P['specs'] into a label => value list for the hero summary. */
if (!function_exists('ntm_spec_pairs')) {
function ntm_spec_pairs($specs)
{
    $out = array();
    if (empty($specs)) return $out;
    // The catalogue has two spec shapes in the wild: a flat label => value
    // map, and grouped sections keyed either 'title'/'rows' or the older
    // 'h'/'r'. Normalise both so no section is silently dropped.
    if (isset($specs[0]) && is_array($specs[0])) {
        foreach ($specs as $sec) {
            $rows = isset($sec['rows']) ? $sec['rows'] : (isset($sec['r']) ? $sec['r'] : null);
            if (!is_array($rows)) continue;
            foreach ($rows as $r) {
                if (is_array($r) && isset($r['k'])) $out[$r['k']] = $r['v'];
            }
        }
    } else {
        foreach ($specs as $k => $v) $out[$k] = $v;
    }
    return $out;
}
}

$hero_specs = ntm_spec_pairs(isset($P['specs']) ? $P['specs'] : array());
$hero_spec_list = array_slice($hero_specs, 0, 5, true);
$gallery = !empty($P['gallery']) ? $P['gallery'] : array($P['image']);
/* Fall back to the meta description when a product file has no short_desc. */
$hero_summary = !empty($P['short_desc']) ? $P['short_desc'] : strip_tags($P['meta_desc']);
?>

  <!-- ======= Product hero: image first, key facts and CTA beside it ======= -->
  <main id="main"><section id="hero" class="ntm-product-hero">
    <div class="container">
      <div class="row align-items-center g-4">

        <div class="col-lg-7">
          <div class="portfolio-details-slider swiper ntm-gallery">
            <div class="swiper-wrapper">
<?php foreach ($gallery as $gi => $img) :
    list($gw, $gh) = niruma_image_size($img, 1288, 600);
?>
              <div class="swiper-slide">
                <img src="<?php echo niruma_media_url($img); ?>"
                     width="<?php echo $gw; ?>" height="<?php echo $gh; ?>"
                     alt="<?php echo htmlspecialchars($P['name'] . ($gi ? ' – view ' . ($gi + 1) : ''), ENT_QUOTES); ?> by <?php echo SITE_NAME; ?>"
                     <?php echo $gi ? 'loading="lazy" decoding="async"' : 'fetchpriority="high" decoding="sync"'; ?>>
              </div>
<?php endforeach; ?>
            </div>
<?php if (count($gallery) > 1) : ?>
            <div class="swiper-pagination"></div>
<?php endif; ?>
          </div>
        </div>

        <div class="col-lg-5">
          <p class="ntm-eyebrow"><?php echo SITE_NAME; ?> &middot; Since <?php echo FOUNDED_YEAR; ?></p>
          <h1><?php echo htmlspecialchars($P['h1'], ENT_QUOTES); ?></h1>

          <p class="ntm-hero-summary"><?php echo htmlspecialchars($hero_summary, ENT_QUOTES); ?></p>

<?php if ($hero_spec_list) : ?>
          <dl class="ntm-quick-specs">
<?php foreach ($hero_spec_list as $k => $v) : ?>
            <div><dt><?php echo htmlspecialchars($k, ENT_QUOTES); ?></dt><dd><?php echo $v; ?></dd></div>
<?php endforeach; ?>
          </dl>
<?php endif; ?>

          <div class="ntm-hero-actions">
            <a href="#inquiry" class="btn-get-started scrollto">Request a Quotation</a>
            <a href="tel:<?php echo PHONE_PRIMARY_TEL; ?>" class="ntm-hero-secondary"><i class="bi bi-telephone-fill" aria-hidden="true"></i> <?php echo PHONE_PRIMARY; ?></a>
          </div>

          <ul class="ntm-hero-points">
<?php foreach (array_slice($P['features'], 0, 4) as $f) : ?>
            <li><i class="bi bi-check2-circle" aria-hidden="true"></i> <?php echo htmlspecialchars($f, ENT_QUOTES); ?></li>
<?php endforeach; ?>
          </ul>
        </div>

      </div>
    </div>
  </section>

  <!-- ======= In-page section navigation ======= -->
  <nav class="ntm-subnav" aria-label="On this page">
    <div class="container">
      <ul>
        <li><a href="#overview">Overview</a></li>
        <li><a href="#features">Features</a></li>
        <li><a href="#specifications">Specifications</a></li>
        <li><a href="#applications">Applications</a></li>
        <li><a href="#operation">Operation</a></li>
        <li><a href="#faq">FAQ</a></li>
        <li><a href="#inquiry" class="ntm-subnav__cta">Enquire</a></li>
      </ul>
    </div>
  </nav>

  <!-- ======= Product details ======= -->
  <section id="portfolio-details" class="portfolio-details">
    <div class="container">

      <!-- Intro -->
      <div class="row" id="overview">
        <div class="col-lg-12 product-intro">
<?php foreach ($P['intro'] as $para) : ?>
          <p><?php echo $para; ?></p>
<?php endforeach; ?>
        </div>
      </div>

      <!-- Features -->
      <div class="row mt-5" id="features">
        <div class="col-lg-12 ntm-content-block ntm-content-block--flush">
          <h2>Salient Features</h2>
          <div class="row">
<?php $fi = 0; foreach ($P['features'] as $f) : $fi++; ?>
            <div class="col-md-6">
              <p class="ntm-feature"><i class="bi bi-check2" aria-hidden="true"></i> <?php echo htmlspecialchars($f, ENT_QUOTES); ?></p>
            </div>
<?php endforeach; ?>
          </div>
          <p class="ntm-actions">
            <a href="#inquiry" class="btn-get-started scrollto">Get a Price</a>
            <a href="<?php echo niruma_url('Niruma-TM-Catalogue.pdf'); ?>" class="details-link" download><i class="bx bx-download" aria-hidden="true"></i> Download Catalogue</a>
          </p>
        </div>
      </div>

      <!-- Why choose -->
<?php if (!empty($P['why'])) : ?>
      <div class="row mt-5">
        <div class="col-lg-12 ntm-content-block ntm-content-block--flush">
          <h2>Why Choose This Machine</h2>
          <div class="row">
<?php foreach ($P['why'] as $w) : ?>
            <div class="col-lg-6">
              <p class="ntm-why"><b><?php echo htmlspecialchars($w['t'], ENT_QUOTES); ?>:</b> <?php echo $w['d']; ?></p>
            </div>
<?php endforeach; ?>
          </div>
        </div>
      </div>
<?php endif; ?>

      <!-- Technical specifications -->
<?php if (!empty($P['specs'])) : ?>
      <div class="row mt-5" id="specifications">
        <div class="col-lg-12 ntm-content-block ntm-content-block--flush">
          <h2>Technical Specifications</h2>
          <div class="table-responsive">
<?php
/* Build every specification row first, then emit one table. Keeping this
   in plain braces avoids mixing alternative syntax with raw HTML, and lets
   us accept both spec shapes used in the product configs. */
$specRows = array();
$specFlat = (empty($P['specs'][0]));

if (!$specFlat) {
    foreach ($P['specs'] as $sec) {
        $rows = isset($sec['rows']) ? $sec['rows'] : (isset($sec['r']) ? $sec['r'] : array());
        $label = isset($sec['title']) ? $sec['title'] : (isset($sec['h']) ? $sec['h'] : $P['name']);
        $group = array();
        foreach ((array) $rows as $r) {
            if (is_array($r) && isset($r['k'])) $group[] = array($r['k'], $r['v']);
        }
        if ($group) $specRows[] = array('label' => $label, 'rows' => $group);
    }
} else {
    $group = array();
    foreach ($P['specs'] as $k => $v) $group[] = array($k, $v);
    $specRows[] = array('label' => $P['name'] . ' &ndash; Specifications', 'rows' => $group);
}

foreach ($specRows as $tbl) {
    echo '<table class="ntm-spec-table"><caption>'
       . htmlspecialchars($tbl['label'], ENT_QUOTES) . '</caption><tbody>';
    foreach ($tbl['rows'] as $pair) {
        echo '<tr><th scope="row">' . htmlspecialchars($pair[0], ENT_QUOTES)
           . '</th><td>' . $pair[1] . '</td></tr>';
    }
    echo '</tbody></table>';
}
?>
          </div>
          <p class="ntm-fineprint">Specifications may be customised to your requirement. Final configuration is confirmed on the order acknowledgement.</p>
        </div>
      </div>
<?php endif; ?>

      <!-- Applications -->
<?php if (!empty($P['applications'])) : ?>
      <div class="row mt-5" id="applications">
        <div class="col-lg-12 ntm-content-block ntm-content-block--flush">
          <h2>Applications &amp; Industries Served</h2>
          <p>This <?php echo htmlspecialchars(strtolower($P['name']), ENT_QUOTES); ?> is used across the following textile processes and industries:</p>
          <ul class="ntm-tag-list">
<?php foreach ($P['applications'] as $app) : ?>
            <li><i class="bi bi-check2" aria-hidden="true"></i> <?php echo htmlspecialchars($app, ENT_QUOTES); ?></li>
<?php endforeach; ?>
          </ul>
        </div>
      </div>
<?php endif; ?>

      <!-- Operation notes -->
<?php if (!empty($P['notes'])) : ?>
      <div class="row mt-5" id="operation">
        <div class="col-lg-12 ntm-content-block ntm-content-block--flush">
          <h2>How It Works &mdash; Operator Notes</h2>
<?php foreach ((array) $P['notes'] as $note) : ?>
          <p><?php echo $note; ?></p>
<?php endforeach; ?>
        </div>
      </div>
<?php endif; ?>

    </div>
  </section><!-- End Portfolio Details Section -->

  <!-- ======= FAQ ======= -->
<?php if (!empty($P['faqs'])) echo niruma_render_faq($P['faqs']); ?>

  <!-- ======= Related products ======= -->
<?php if (!empty($related_products)) : ?>
  <section id="related" class="portfolio section-bg">
    <div class="container">
      <div class="section-title">
        <h2>Related Machinery</h2>
        <p>Other machines from the <?php echo SITE_NAME; ?> range</p>
      </div>
      <div class="row portfolio-container">
<?php foreach ($related_products as $rp) : ?>
        <div class="col-lg-4 col-md-6 portfolio-item">
          <a class="ntm-card__media" href="<?php echo niruma_url($rp['slug']); ?>" tabindex="-1" aria-hidden="true">
            <img src="<?php echo niruma_media_url($rp['img']); ?>" class="img-fluid" width="1288" height="600" loading="lazy" decoding="async" alt="">
          </a>
          <div class="portfolio-info">
            <h3><a href="<?php echo niruma_url($rp['slug']); ?>"><?php echo htmlspecialchars($rp['short'], ENT_QUOTES); ?></a></h3>
            <p><?php echo htmlspecialchars($rp['desc'], ENT_QUOTES); ?></p>
            <a href="<?php echo niruma_url($rp['slug']); ?>" class="details-link">Specifications &amp; Features <i class="bi bi-arrow-right" aria-hidden="true"></i></a>
          </div>
        </div>
<?php endforeach; ?>
      </div>
      <p class="text-center ntm-actions ntm-actions--center">
        <a href="<?php echo niruma_url('products'); ?>" class="btn-get-started">View All <?php echo count(niruma_products()); ?> Machines</a>
      </p>
    </div>
  </section>
<?php endif; ?>

  <!-- ======= Enquiry ======= -->
  <section id="inquiry" class="contact">
    <div class="container">
      <div class="section-title">
        <h2>Enquiry</h2>
        <h3>Request a <span>Quotation</span></h3>
        <p>Share your fabric type, layer thickness and sample size &mdash; our engineers reply within 24 hours</p>
      </div>

      <div class="row">
        <div class="col-lg-7">
          <form action="<?php echo niruma_url('enquiry'); ?>" method="post" role="form" class="php-email-form">
            <div class="ntm-hp" aria-hidden="true"><label for="ntm_website">Leave this field empty</label><input type="text" id="ntm_website" name="ntm_website" value="" tabindex="-1" autocomplete="off"></div>
            <input type="hidden" name="product" value="<?php echo htmlspecialchars($P['name'], ENT_QUOTES); ?>">
            <div class="row">
              <div class="col form-group">
                <label for="name">Your Name</label>
                <input type="text" name="name" class="form-control" id="name" placeholder="Your Name" required>
              </div>
              <div class="col form-group">
                <label for="email">Your Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Your Email" required>
              </div>
            </div>
            <div class="row">
              <div class="col form-group">
                <label for="phone">Phone / WhatsApp</label>
                <input type="tel" name="phone" class="form-control" id="phone" placeholder="Phone / WhatsApp">
              </div>
              <div class="col form-group">
                <label for="subject">Subject</label>
                <input type="text" name="subject" class="form-control" id="subject" value="Enquiry: <?php echo htmlspecialchars($P['name'], ENT_QUOTES); ?>" required>
              </div>
            </div>
            <div class="form-group">
              <label for="message">Requirement</label>
              <textarea class="form-control" name="message" id="message" rows="5" placeholder="Fabric type, maximum layer thickness in mm, required blade width, quantity, delivery location…" required></textarea>
            </div>
            <div class="my-3">
              <div class="loading">Sending&hellip;</div>
              <div class="error-message"></div>
              <div class="sent-message">Thank you! Your enquiry for the <?php echo htmlspecialchars($P['name'], ENT_QUOTES); ?> has been received.</div>
            </div>
            <div class="text-center"><button type="submit">Send Enquiry</button></div>
          </form>
        </div>
        <div class="col-lg-5">
          <div class="info-box mb-4">
            <i class="bx bx-map" aria-hidden="true"></i>
            <h3>Factory Address</h3>
            <p><?php echo NAP_STREET; ?><br>
            Near S. P. Ring Road, <?php echo NAP_CITY; ?> &ndash; <?php echo NAP_POSTCODE; ?>, <?php echo NAP_REGION; ?>, India</p>
          </div>
          <div class="info-box mb-4">
            <i class="bx bx-envelope" aria-hidden="true"></i>
            <h3>Email Us</h3>
            <p><a href="mailto:<?php echo EMAIL_PRIMARY; ?>"><?php echo EMAIL_PRIMARY; ?></a></p>
          </div>
          <div class="info-box">
            <i class="bx bx-phone-call" aria-hidden="true"></i>
            <h3>Call / WhatsApp</h3>
            <p><a href="tel:<?php echo PHONE_PRIMARY_TEL; ?>"><?php echo PHONE_PRIMARY; ?></a></p>
            <p><a href="tel:<?php echo PHONE_SECONDARY_TEL; ?>"><?php echo PHONE_SECONDARY; ?></a></p>
          </div>
<?php if (!empty($P['enquiry_hints'])) : ?>
          <div class="ntm-content-block ntm-content-block--flush ntm-mt">
            <h2 class="ntm-h3">Useful Information To Include</h2>
            <ul>
<?php foreach ($P['enquiry_hints'] as $hint) : ?>
              <li><?php echo htmlspecialchars($hint, ENT_QUOTES); ?></li>
<?php endforeach; ?>
            </ul>
            <a href="<?php echo niruma_url('Niruma-TM-Catalogue.pdf'); ?>" download class="details-link"><i class="bx bx-download" aria-hidden="true"></i> Download full catalogue (PDF)</a>
          </div>
<?php endif; ?>
        </div>
      </div>
    </div>
  </section>
</main>

  <?php include __DIR__ . '/footer.php'; ?>
