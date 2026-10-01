<?php
require_once __DIR__ . '/seo.php'; // site constants + helpers must load before the meta/schema block

$metatitle = 'Contact Us | Textile Machinery Manufacturer, Ahmedabad, India';
$title     = $metatitle;
$metadesc  = 'Contact Niruma Textile Machinery, Odhav, Ahmedabad. Call +91 9662660377 or +91 9327084627 for a quote on fabric sample cutting, inspection and rolling machines.';
$metakeywords = 'contact textile machinery manufacturer Ahmedabad, textile machinery supplier Odhav, fabric sample cutting machine quotation, Niruma Textile Machinery contact, textile machinery exporter India contact';
$ogimage   = 'assets/img/about.webp';
$breadcrumbs = array(
    array('name' => 'Home', 'url' => '/'),
    array('name' => 'Contact Us'),
);

$schema = array(
    array(
        '@type' => 'ContactPage',
        '@id'   => SITE_URL . '/contact-us#webpage',
        'url'   => SITE_URL . '/contact-us',
        'name'  => 'Contact ' . SITE_NAME,
        'isPartOf' => array('@id' => SITE_URL . '/#website'),
        'inLanguage' => SITE_LANG,
    ),
    array(
        '@type' => 'LocalBusiness',
        '@id'   => SITE_URL . '/contact-us#localbusiness',
        'name'  => SITE_NAME,
        'image' => DEFAULT_OG_IMAGE,
        'url'   => SITE_URL . '/',
        'telephone' => PHONE_PRIMARY_TEL,
        'email' => EMAIL_PRIMARY,
        'priceRange' => '$$',
        'foundingDate' => (string) FOUNDED_YEAR,
        'address' => array(
            '@type' => 'PostalAddress',
            'streetAddress'   => NAP_STREET,
            'addressLocality' => NAP_CITY,
            'addressRegion'   => NAP_REGION,
            'postalCode'      => NAP_POSTCODE,
            'addressCountry'  => 'IN',
        ),
        'geo' => array('@type' => 'GeoCoordinates', 'latitude' => SITE_GEO_LAT, 'longitude' => SITE_GEO_LNG),
        'openingHoursSpecification' => array(
            array(
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'),
                'opens'     => '09:30',
                'closes'    => '19:00',
            ),
        ),
        'areaServed' => array('@type' => 'Country', 'name' => 'India'),
    ),
);

include("header.php");
?>

  <!-- ======= Page Hero ======= -->
  <main id="main"><section id="hero" class="d-flex align-items-center ntm-page-hero">
    <div class="container" data-aos="zoom-out" data-aos-delay="100">
      <h1><b>Contact <span>Niruma Textile Machinery</span></b></h1>
      <h3 class="mt-3">Textile machinery manufacturers &amp; exporters &mdash; Bileshwar Industrial Estate, Odhav, Ahmedabad 382415, Gujarat, India</h3>
    </div>
  </section>

  <!-- ======= Contact Section ======= -->
  <section id="inquiry" class="contact">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>Contact</h2>
        <h3>Get a <span>Quotation</span></h3>
        <p>Send us your fabric type, maximum layer thickness, required blade width and quantity &mdash; we reply within 24 hours</p>
      </div>

      <div class="row" data-aos="fade-up" data-aos-delay="100">
        <div class="col-lg-6">
          <div class="info-box mb-4">
            <i class="bx bx-map"></i>
            <h3>Our Address</h3>
            <p><?php echo NAP_STREET; ?><br>
Near S. P. Ring Road, <?php echo NAP_CITY; ?> &ndash; <?php echo NAP_POSTCODE; ?>, <?php echo NAP_REGION; ?>, India
</p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="info-box mb-4">
            <i class="bx bx-envelope"></i>
            <h3>Email Us</h3>
            <p><a href="mailto:info@nirumatextilemachinery.in">info@nirumatextilemachinery.in</a></p>
            <p><a href="mailto:manojpanchal1963@gmail.com">manojpanchal1963@gmail.com</a></p>
          </div>
        </div>

        <div class="col-lg-3 col-md-6">
          <div class="info-box mb-4">
            <i class="bx bx-phone-call"></i>
            <h3>Call Us</h3>
            <p><a href="tel:<?php echo PHONE_PRIMARY_TEL; ?>">+91 9662660377</a></p>
            <p><a href="tel:<?php echo PHONE_SECONDARY_TEL; ?>">+91 9327084627</a></p>
          </div>
        </div>
      </div>

      <div class="row" data-aos="fade-up" data-aos-delay="100">

        <div class="col-lg-6" id="map-wrap">
          <iframe src="https://maps.google.com/maps?q=niruma%20textile%20machinery%20gujrat&#038;t=m&#038;z=8&#038;output=embed&#038;iwloc=near" title="Map showing <?php echo SITE_NAME; ?>, <?php echo NAP_CITY; ?>, <?php echo NAP_REGION; ?>, India" frameborder="0" style="border:0; width: 100%; height: 420px;" loading="lazy" allowfullscreen></iframe>
        </div>

        <div class="col-lg-6">
          <form action="<?php echo niruma_url('enquiry'); ?>" method="post" role="form" class="php-email-form">
            <div class="ntm-hp" aria-hidden="true"><label for="ntm_website">Leave this field empty</label><input type="text" id="ntm_website" name="ntm_website" value="" tabindex="-1" autocomplete="off"></div>
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
            <div class="form-group">
              <label for="phone">Phone / WhatsApp</label>
              <input type="tel" class="form-control" name="phone" id="phone" placeholder="Phone / WhatsApp">
            </div>
            <div class="form-group">
              <label for="subject">Machine / Subject</label>
              <input type="text" class="form-control" name="subject" id="subject" placeholder="Machine you are interested in" required>
            </div>
            <div class="form-group">
              <label for="message">Your Requirement</label>
              <textarea class="form-control" id="message" name="message" rows="6" placeholder="Fabric type, maximum layer thickness in mm, sample size in inches, quantity, delivery location…" required></textarea>
            </div>
            <div class="my-3">
              <div class="loading">Sending…</div>
              <div class="error-message"></div>
              <div class="sent-message">Thank you! Your enquiry has been received. We will respond within 24 hours.</div>
            </div>
            <div class="text-center"><button type="submit">Send Enquiry</button></div>
          </form>
        </div>

      </div>

    </div>
  </section><!-- End Contact Section -->

  <!-- ======= Enquiry guide ======= -->
  <section id="enquiry-guide" class="product-intro section-bg">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Enquiry Guide</h2>
        <h3>What To Tell Us For An <span>Accurate Quotation</span></h3>
      </div>

      <div class="row">
        <div class="col-lg-6">
          <div class="ntm-content-block" style="margin-top:0;">
            <h2>For Fabric Sample Cutting Machines</h2>
            <ul>
              <li>Fabric type &mdash; cotton, polyester, denim, silk, canvas, technical or non-woven</li>
              <li>Maximum number of layers to be cut at once (in mm)</li>
              <li>Required blade width &mdash; 13", 18", 24", 36", 48" or 60"</li>
              <li>Sample shapes needed &mdash; straight swatch, zigzag or both</li>
              <li>Daily sample quantity and number of operators</li>
              <li>Preference &mdash; manual, semi-automatic or fully automatic PLC</li>
            </ul>

            <h2 class="mt-4">For Inspection, Rolling, Folding &amp; Wrapping Machines</h2>
            <ul>
              <li>Maximum fabric width and roll diameter required</li>
              <li>Fabric weight (GSM) and fabric type</li>
              <li>Required rolling speed in metres per minute</li>
              <li>Whether length measurement / counter is required</li>
              <li>Number of machines required and your shop-floor layout</li>
              <li>Power supply at your location (voltage and phase)</li>
            </ul>
          </div>
        </div>

        <div class="col-lg-6">
          <div class="ntm-content-block" style="margin-top:0;">
            <h2>For Loom Batching Motions</h2>
            <ul>
              <li>Loom make and model &mdash; Sulzer, Picanol, Omni, Toyota, Tsudokoma Ruti-C or other</li>
              <li>Number of looms to be fitted</li>
              <li>Fabric type &mdash; denim, technical fabric, non-woven or low bottom weight</li>
              <li>Required working width (1150 mm to 4000 mm)</li>
              <li>Whether custom-built mounting is required</li>
            </ul>

            <h2 class="mt-4">Other Information We Need</h2>
            <ul>
              <li>Delivery location &mdash; within India or export destination</li>
              <li>Preferred delivery timeline</li>
              <li>Whether installation, commissioning and operator training are required</li>
              <li>Your company name, address and contact person</li>
            </ul>

            <h2 class="mt-4">Fast Response Channels</h2>
            <p>For the quickest reply, call us directly or email your requirement. We also publish working videos of every machine on our YouTube channel so you can inspect the build quality before visiting.</p>
            <ul class="ntm-tag-list">
              <li><a href="tel:<?php echo PHONE_PRIMARY_TEL; ?>" style="color:inherit;text-decoration:none;"><i class="bi bi-telephone-fill"></i> <?php echo PHONE_PRIMARY; ?></a></li>
              <li><a href="tel:<?php echo PHONE_SECONDARY_TEL; ?>" style="color:inherit;text-decoration:none;"><i class="bi bi-telephone-fill"></i> <?php echo PHONE_SECONDARY; ?></a></li>
              <li><a href="mailto:<?php echo EMAIL_PRIMARY; ?>" style="color:inherit;text-decoration:none;"><i class="bi bi-envelope-fill"></i> Email Us</a></li>
              <li><a href="<?php echo SOCIAL_YOUTUBE; ?>" target="_blank" rel="noopener" style="color:inherit;text-decoration:none;"><i class="bi bi-youtube"></i> YouTube</a></li>
            </ul>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ======= Product links ======= -->
  <section id="products" class="services">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Products</h2>
        <h3>Textile Machinery <span>We Manufacture</span></h3>
      </div>
      <div class="row">
<?php foreach (niruma_products() as $i => $p) : ?>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="<?php echo 100 + ($i % 3) * 100; ?>">
          <div class="icon-box"><div class="icon"><i class="bx bx-right-arrow-circle"></i></div><h4><a href="<?php echo niruma_url($p['slug']); ?>"><?php echo htmlspecialchars($p['name'], ENT_QUOTES); ?></a></h4><p><?php echo htmlspecialchars($p['desc'], ENT_QUOTES); ?></p></div>
        </div>
<?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ======= FAQ ======= -->
<?php
echo niruma_render_faq(array(
    array(
        'q' => 'How do I get a price for a textile machine?',
        'a' => 'Call us on ' . PHONE_PRIMARY . ' or ' . PHONE_SECONDARY . ', or use the enquiry form on this page. Share your fabric type, maximum layer thickness in mm, required blade width and quantity &mdash; we reply with a written quotation within 24 hours.',
    ),
    array(
        'q' => 'Do you deliver and install outside Ahmedabad?',
        'a' => 'Yes. We deliver and commission machines across India. For buyers outside India we ship with full export documentation, packing, machine documentation and a working video, and commissioning is done through video guidance or an engineer visit.',
    ),
    array(
        'q' => 'Can I visit your factory before ordering?',
        'a' => 'Absolutely. Our factory is at A/161, Bileshwar Industrial Estate, Opp. GVMM, Near S. P. Ring Road, Odhav, Ahmedabad &ndash; 382415. Call ahead so a machine of the model you are interested in is powered up and ready for a live demonstration.',
    ),
    array(
        'q' => 'What information do you need to recommend the right machine?',
        'a' => 'For sample cutting machines: fabric type, maximum layers in mm, blade width and daily quantity. For inspection, rolling, folding and wrapping machines: maximum fabric width, fabric weight, roll diameter and required speed. For loom batching motions: loom make and model, number of looms and working width.',
    ),
    array(
        'q' => 'Do you provide spare parts and service after installation?',
        'a' => 'Yes. Spare parts, blades, belts and gear boxes are available for all Niruma machines. Service visits can be arranged in Gujarat, and remote video support is available for machines elsewhere in India and overseas.',
    ),
    array(
        'q' => 'Which countries do you export to?',
        'a' => 'We regularly export to Bangladesh, Pakistan, UAE, Saudi Arabia, Egypt, Turkey, Vietnam, Italy, Spain, Mexico and other markets. Export enquiries are handled by the same engineering team that builds the machines, so technical queries are answered directly.',
    ),
));
?>
</main>

  <?php include("footer.php"); ?>
