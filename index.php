<?php
require_once __DIR__ . '/seo.php'; // site constants + helpers must load before the meta/schema block

$metatitle = 'Textile Machinery Manufacturer India | Niruma Textile Machinery';
$title     = $metatitle;
$metadesc  = 'Leading textile machinery manufacturer in Ahmedabad, India. Fabric sample cutting, inspection, rolling, folding and batching machines since 1980. Export worldwide.';
$metakeywords = 'textile machinery manufacturer India, textile machinery manufacturer Ahmedabad, fabric sample cutting machine manufacturer, textile machinery exporter, sample cutting machine supplier, fabric inspection machine, fabric rolling machine, fabric folding machine, textile machinery since 1980, Niruma Textile Machinery';
$ogimage   = 'assets/img/portfolio/Fully-Automatic-Sample-Cutting-Machine-Niruma.webp';
$ogtype    = 'website';
$breadcrumbs = array();

$products = niruma_products();

$home_faqs = array(
    array(
        'q' => 'What is a textile machinery manufacturer?',
        'a' => 'A textile machinery manufacturer designs, fabricates and supplies machines used in textile processing. ' . SITE_NAME . ' has manufactured, sold and exported fabric sample cutting machines, fabric inspection machines, fabric rolling machines, fabric folding machines, stretch wrapping machines and loom batching motions from its plant in Odhav, Ahmedabad since ' . FOUNDED_YEAR . '.'
    ),
    array(
        'q' => 'How much does a fabric sample cutting machine cost?',
        'a' => 'Price depends on automation level and blade width. Manual sample cutting machines start at the most economical end, semi-automatic and lever press models sit in the middle, and PLC-controlled fully automatic machines with a 60" blade are the highest investment. Contact us with your fabric type, maximum layer thickness in mm and required sample width for a written quotation.'
    ),
    array(
        'q' => 'Which sample cutting machine should I buy for denim or heavy fabric?',
        'a' => 'For denim, heavy canvas or multi-layer cutting, choose a machine with a worm gear box drive and at least 60 mm layer capacity. Our Fully Automatic and Automatic Sample Cutting Machines use a worm gear box system, cut up to 60 mm in a single stroke and are available with blades up to 60" wide, which makes them the right choice for denim and technical fabrics.'
    ),
    array(
        'q' => 'Do you export textile machinery outside India?',
        'a' => 'Yes. We export sample cutting, inspection, rolling, folding, wrapping and batching machines to buyers in Bangladesh, Pakistan, UAE, Saudi Arabia, Egypt, Turkey, Vietnam, Italy, Spain and Mexico. Export documentation, machine documentation and video support for installation are provided with every export order.'
    ),
    array(
        'q' => 'Do you provide machine installation and operator training?',
        'a' => 'Yes. Every machine supplied by ' . SITE_NAME . ' comes with an installation and commissioning visit within Gujarat, video-based training for buyers outside India, and a spare parts list. Our engineers can also visit your plant on request for commissioning and operator training.'
    ),
    array(
        'q' => 'Can machines be customised to our factory requirements?',
        'a' => 'Yes. Batching motions are custom built for working widths from 1150 mm to 4000 mm, inspection and rolling machines are supplied with variable widths, blade sizes and drive options, and sample cutting machines can be configured with different blade sizes from 13" to 60". Share your layout and requirements and we will suggest a suitable configuration.'
    ),
    array(
        'q' => 'How long has Niruma Textile Machinery been in business?',
        'a' => 'Since ' . FOUNDED_YEAR . '. More than four decades of continuous manufacturing experience in textile machinery gives us the field knowledge to build machines around real day-to-day operating problems in a textile unit.'
    ),
    array(
        'q' => 'What is the difference between automatic and semi-automatic sample cutting?',
        'a' => 'An Automatic Sample Cutting Machine uses a worm gear box and a sliding table moved by a hand wheel, so the operator sets the size and pulls the lever. A Semi Automatic Sample Cutting Machine adds an automatic stop after each cut and is better suited to frequent small batches. A Fully Automatic machine adds PLC programming and a colour touch screen where the sample size is entered directly.'
    ),
);

$schema = array(
    array(
        '@type' => 'WebPage',
        '@id'   => SITE_URL . '/#webpage',
        'url'   => SITE_URL . '/',
        'name'  => $metatitle,
        'isPartOf' => array('@id' => SITE_URL . '/#website'),
        'about' => array('@id' => SITE_URL . '/#organization'),
        'inLanguage' => SITE_LANG,
        'description' => $metadesc,
    ),
    array(
        '@type' => 'LocalBusiness',
        '@id'   => SITE_URL . '/#localbusiness',
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
        'geo' => array(
            '@type' => 'GeoCoordinates',
            'latitude'  => SITE_GEO_LAT,
            'longitude' => SITE_GEO_LNG,
        ),
        'openingHoursSpecification' => array(
            array(
                '@type'     => 'OpeningHoursSpecification',
                'dayOfWeek' => array('Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'),
                'opens'     => '09:30',
                'closes'    => '19:00',
            ),
        ),
        'areaServed' => array(
            '@type' => 'Country', 'name' => 'India',
        ),
        'hasOfferCatalog' => array(
            '@type' => 'OfferCatalog',
            'name' => 'Textile Machinery',
            'itemListElement' => array_map(function ($p) {
                return array(
                    '@type' => 'Offer',
                    'itemOffered' => array(
                        '@type'       => 'Product',
                        'name'        => $p['name'],
                        'url'         => niruma_url($p['slug']),
                        'image'       => niruma_media_url($p['img']),
                        'description' => $p['desc'],
                        'brand'       => array('@type' => 'Brand', 'name' => SITE_NAME),
                    ),
                );
            }, $products),
        ),
    ),
    niruma_faq_schema($home_faqs),
);

include("header.php");
?>

  <!-- ======= Hero Section ======= -->
  <main id="main"><section id="hero" class="d-flex align-items-center">
    <div class="container" data-aos="zoom-out" data-aos-delay="100">
      <h1><b>Textile Machinery Manufacturer <span>&amp; Exporter Since 1980</span></b></h1>
      <h3 class="mt-3">Fabric Sample Cutting &middot; Inspection &middot; Rolling &middot; Folding &middot; Roll Wrapping Machinery from Ahmedabad, Gujarat, India</h3>
      <p class="mt-3 hero-lead">Niruma Textile Machinery designs and manufactures automatic, semi-automatic and manual fabric sample cutting machines, fabric inspection and rolling machines, folding machines, stretch wrapping machines and loom batching motions &mdash; engineered for accuracy, low maintenance and export-grade reliability.</p>
      <div class="d-flex flex-wrap mt-4">
        <a href="#products" class="btn-get-started scrollto">Explore Products</a>
        <a href="https://www.youtube.com/watch?v=9C7n_orMhGw" class="btn-watch-video glightbox"><i class="bi bi-play-circle"></i><span>Watch Video</span></a>
      </div>
      <ul class="hero-badges">
        <li><i class="bi bi-check-circle-fill"></i> 45+ Years of Experience</li>
        <li><i class="bi bi-check-circle-fill"></i> Export to 10+ Countries</li>
        <li><i class="bi bi-check-circle-fill"></i> Manufacturer, Not a Trader</li>
        <li><i class="bi bi-check-circle-fill"></i> Installation &amp; Training</li>
      </ul>
    </div>
  </section><!-- End Hero -->

  <!-- ======= Stats Strip ======= -->
  <section id="stats" class="stats" aria-label="Company statistics">
    <div class="container">
      <div class="row text-center">
        <div class="col-lg-3 col-md-6" data-aos="zoom-in">
          <div class="stats-item"><span class="purecounter" data-purecounter-start="0" data-purecounter-end="1980" data-purecounter-suffix="">1980</span><p>Year Established</p></div>
        </div>
        <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="100">
          <div class="stats-item"><span class="purecounter" data-purecounter-start="0" data-purecounter-end="11">11</span><p>Machine Models</p></div>
        </div>
        <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="200">
          <div class="stats-item"><span class="purecounter" data-purecounter-start="0" data-purecounter-end="10">10</span><p>Countries Served</p></div>
        </div>
        <div class="col-lg-3 col-md-6" data-aos="zoom-in" data-aos-delay="300">
          <div class="stats-item"><span class="purecounter" data-purecounter-start="0" data-purecounter-end="500">500</span><p>Machines Delivered</p></div>
        </div>
      </div>
    </div>
  </section>

  <!-- ======= Products Section ======= -->
  <section id="products" class="portfolio">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>Our Textile Machinery</h2>
        <h3>Check our <span>Product Range</span></h3>
        <p>Eleven machine models covering the complete fabric sample cutting, inspection, handling and finishing process</p>
      </div>

      <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
<?php
// First five models are sample cutters; the rest are fabric handling / packing machines.
$class_for = array(0 => 'filter-cutting', 1 => 'filter-cutting', 2 => 'filter-cutting', 3 => 'filter-cutting', 4 => 'filter-cutting',
                   5 => 'filter-handling', 6 => 'filter-handling', 7 => 'filter-handling', 8 => 'filter-handling', 9 => 'filter-handling', 10 => 'filter-handling');

foreach ($products as $i => $p) :
    $slug = $p['slug'];
    $imgsize = niruma_image_size($p['img'], 1288, 600);
?>
        <div class="col-lg-4 col-md-6 portfolio-item <?php echo $class_for[$i]; ?>">
          <img src="<?php echo niruma_media_url($p['img']); ?>" class="img-fluid" loading="lazy" width="<?php echo $imgsize[0]; ?>" height="<?php echo $imgsize[1]; ?>" alt="<?php echo htmlspecialchars($p['name'], ENT_QUOTES); ?> by Niruma Textile Machinery">
          <div class="portfolio-info">
            <h4><?php echo htmlspecialchars($p['short'], ENT_QUOTES); ?></h4>
            <p><?php echo htmlspecialchars($p['desc'], ENT_QUOTES); ?></p>
            <div class="ntm-card-actions">
              <a href="<?php echo niruma_media_url($p['img']); ?>" data-gallery="portfolioGallery" class="portfolio-lightbox preview-link" title="<?php echo htmlspecialchars($p['name'], ENT_QUOTES); ?>"><i class="bx bx-images" aria-hidden="true"></i> View photo</a>
              <a href="<?php echo niruma_url($slug); ?>" class="details-link" title="Read more about <?php echo htmlspecialchars($p['name'], ENT_QUOTES); ?>">View details <i class="bx bx-right-arrow-alt" aria-hidden="true"></i></a>
            </div>
          </div>
        </div>
<?php endforeach; ?>
      </div>
    </div>
  </section><!-- End Portfolio Section -->

  <!-- ======= Why Choose Us ======= -->
  <section id="why-us" class="services">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Why Choose Niruma</h2>
        <h3>What Makes Our <span>Textile Machinery Different</span></h3>
        <p>We are a manufacturer, not a trading company &mdash; every machine is designed, built and tested in our own workshop</p>
      </div>

      <div class="row">
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="icon-box">
            <div class="icon"><i class="bx bxs-factory"></i></div>
            <h4><a href="<?php echo niruma_url('about-us'); ?>">In-House Manufacturing</a></h4>
            <p>All machines are fabricated, assembled and tested at our Odhav, Ahmedabad plant. We control the material grade, welding quality and final testing instead of reselling someone else's machine.</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="icon-box">
            <div class="icon"><i class="bx bx-ruler"></i></div>
            <h4><a href="<?php echo niruma_url('fully-automatic-sample-cutting-machine'); ?>">Precision Engineering</a></h4>
            <p>Worm gear box drives, CNC-aligned rollers, calibrated scale bars and red laser zero-mark references deliver repeatable accuracy sample after sample.</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="icon-box">
            <div class="icon"><i class="bx bx-wrench"></i></div>
            <h4><a href="<?php echo niruma_url('contact-us'); ?>">Built for Daily Shop-Floor Use</a></h4>
            <p>Every machine is designed around the difficulties that actually arise during day-to-day textile operations &mdash; frequent cleaning, voltage variation, operator skill and long duty cycles.</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="icon-box">
            <div class="icon"><i class="bx bx-globe"></i></div>
            <h4><a href="<?php echo niruma_url('contact-us'); ?>">Export-Ready Documentation</a></h4>
            <p>Regular export shipments to Asia, the Middle East and Europe with machine documentation, electrical drawings, packing and clear commissioning support.</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="icon-box">
            <div class="icon"><i class="bx bx-slider"></i></div>
            <h4><a href="<?php echo niruma_url('fabric-inspection-machine'); ?>">Customised Configurations</a></h4>
            <p>Blade sizes from 13" to 60", layer capacity to 60 mm, batching widths from 1150 mm to 4000 mm and motor/drive options are available on order.</p>
          </div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="icon-box">
            <div class="icon"><i class="bx bx-headphone"></i></div>
            <h4><a href="<?php echo niruma_url('contact-us'); ?>">Lifetime Service Support</a></h4>
            <p>Installation, commissioning, operator training and spare parts support are available for every machine we supply, in India and overseas.</p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ======= About Section ======= -->
  <section id="about" class="about section-bg">
    <div class="container" data-aos="fade-up">

      <div class="section-title">
        <h2>About</h2>
        <h3>Find Out More <span>About Us</span></h3>
        </div>

        <div class="row">
          <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
            <img src="<?php echo niruma_asset('img/about.webp'); ?>" class="img-fluid" loading="lazy" alt="Niruma Textile Machinery manufacturing workshop in Odhav, Ahmedabad, Gujarat">
          </div>
          <div class="col-lg-6 pt-4 pt-lg-0 content d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="100">

            <p class="fst-italic">
            <b>Niruma Textile Machinery</b> &mdash; textile machinery manufacturers and exporters in Ahmedabad, Gujarat, India since <?php echo FOUNDED_YEAR; ?>

            </p>
            <ul>
              <li>
                <i class="bx bx-store-alt"></i>
                <div>
                  <h5>Leading textile machinery manufacturer since <?php echo FOUNDED_YEAR; ?></h5>
                  <p>We are one of Ahmedabad's fastest growing <b>textile machinery manufacturers</b>, building, selling and exporting <b>fabric sample cutting machines</b>, <b>zigzag cutting machines</b> (automatic, semi-automatic, lever press and manual), <b>fabric inspection cum rolling machines</b>, <b>fabric rolling machines</b>, <b>fabric roll stretch wrapping machines</b> and <b>weavers batching units</b>.</p>
                </div>
              </li>
              <li>
                <i class="bx bx-images"></i>
                <div>
                  <h5>Engineers, not copy-paste assemblers</h5>
                  <p>Our <b>textile machinery</b> is designed and developed in-house with deep technical expertise, based on the real difficulties and problems that arise during day-to-day operations in a fabric manufacturing unit.</p>
                </div>
              </li>
              <li>
                <i class="bx bx-globe"></i>
                <div>
                  <h5>Trusted by domestic and export buyers</h5>
                  <p>Fabric manufacturers, denim units, garment exporters, weavers and composite mills in India and overseas use our machines for <b>fabric sample cutting</b>, <b>fabric inspection</b>, <b>fabric rolling</b>, <b>fabric folding</b> and <b>roll packing</b>. <a href="<?php echo niruma_url('about-us'); ?>">Read our full company story &rarr;</a></p>
                </div>
              </li>
            </ul>

          </div>
        </div>

      </div>
  </section><!-- End About Section -->

  <!-- ======= Industries Served ======= -->
  <section id="industries" class="services">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Industries</h2>
        <h3>Who Uses <span>Our Machinery</span></h3>
        <p>One supplier covering the entire fabric sample, inspection, handling and packing workflow</p>
      </div>

      <div class="row">
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="icon-box"><div class="icon"><i class="bx bx-store"></i></div><h4><a href="<?php echo niruma_url('automatic-sample-cutting-machine'); ?>">Fabric &amp; Textile Manufacturers</a></h4><p>Composite mills and fabric manufacturers use our sample cutting machines for buyer swatch rooms, design studios and development departments.</p></div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="icon-box"><div class="icon"><i class="bx bx-badge"></i></div><h4><a href="<?php echo niruma_url('lever-press-zig-zag-cutting-machine'); ?>">Denim &amp; Garment Units</a></h4><p>Denim, canvas and heavy fabric processors rely on 60 mm capacity machines with wide blades for thick, multi-layer sample cutting.</p></div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="icon-box"><div class="icon"><i class="bx bx-grid"></i></div><h4><a href="<?php echo niruma_url('batching-motion-for-looms'); ?>">Weavers &amp; Loom Units</a></h4><p>Batching motions for Sulzer, Picanol, Omni, Toyota and Tsudokoma Ruti-C looms give even-tension fabric rolling with a single operator.</p></div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="icon-box"><div class="icon"><i class="bx bx-check-shield"></i></div><h4><a href="<?php echo niruma_url('fabric-inspection-machine'); ?>">Quality Control &amp; Lab Departments</a></h4><p>Inspection machines with inclined tables, CNC-aligned rollers and selvage guiders are used for fabric defect detection and length measurement.</p></div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="icon-box"><div class="icon"><i class="bx bx-package"></i></div><h4><a href="<?php echo niruma_url('fabric-roll-wrapping-machine'); ?>">Exporters &amp; Logistics Warehouses</a></h4><p>Stretch wrapping machines dust-proof and moisture-proof denim, curtain, carpet and upholstery rolls before container loading.</p></div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="icon-box"><div class="icon"><i class="bx bx-buildings"></i></div><h4><a href="<?php echo niruma_url('fabric-folding-machine'); ?>">Retail &amp; Fabric Trading Houses</a></h4><p>Folding and rolling machines let traders convert loose fabric into neat, measured plaited or rolled stock for retail display and dispatch.</p></div>
        </div>
      </div>
    </div>
  </section>

  <!-- ======= Process ======= -->
  <section id="process" class="process section-bg">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>How We Work</h2>
        <h3>From <span>Enquiry to Installation</span></h3>
        <p>A clear, four-step process for buyers across India and overseas</p>
      </div>
      <div class="row">
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="process-step"><span class="step-no">01</span><h4>Requirement Discussion</h4><p>Share your fabric type, maximum layer thickness, sample width, daily output and shop-floor constraints with our engineers.</p></div>
        </div>
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="process-step"><span class="step-no">02</span><h4>Machine Recommendation</h4><p>We recommend the right model, blade size and configuration &mdash; from a manual sample cutter to a PLC-controlled fully automatic machine.</p></div>
        </div>
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="process-step"><span class="step-no">03</span><h4>Manufacturing &amp; Testing</h4><p>Your machine is fabricated, assembled and trial-tested in our workshop. You receive photographs and a video of the running machine.</p></div>
        </div>
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
          <div class="process-step"><span class="step-no">04</span><h4>Dispatch &amp; Training</h4><p>Installation, commissioning and operator training are completed on site in India, or by video guidance for overseas buyers.</p></div>
        </div>
      </div>
    </div>
  </section>

  <!-- ======= FAQ ======= -->
<?php echo niruma_render_faq($home_faqs); ?>

  <!-- ======= CTA ======= -->
<?php echo niruma_render_cta(); ?>

     <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact">
      <div class="container" data-aos="fade-up">

        <div class="section-title">
          <h2>Contact</h2>
          <h3><span>Contact Us</span></h3>
          <p>Visit our factory at Bileshwar Industrial Estate, Odhav, Ahmedabad or call us for an immediate technical discussion</p>
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
            <div class="info-box  mb-4">
              <i class="bx bx-envelope"></i>
              <h3>Email Us</h3>
              <p><a href="mailto:info@nirumatextilemachinery.in">info@nirumatextilemachinery.in</a></p>
			  <p><a href="mailto:manojpanchal1963@gmail.com">manojpanchal1963@gmail.com</a></p>
            </div>
          </div>

          <div class="col-lg-3 col-md-6">
            <div class="info-box  mb-4">
              <i class="bx bx-phone-call"></i>
              <h3>Call Us</h3>
              <p><a href="tel:<?php echo PHONE_PRIMARY_TEL; ?>">+91 9662660377</a></p>
			  <p><a href="tel:<?php echo PHONE_SECONDARY_TEL; ?>">+91 9327084627</a></p>
            </div>
          </div>

        </div>

        <div class="row" data-aos="fade-up" data-aos-delay="100">

          <div class="col-lg-6 ">
            <iframe class="mb-4 mb-lg-0" src="https://maps.google.com/maps?q=niruma%20textile%20machinery%20gujrat&#038;t=m&#038;z=8&#038;output=embed&#038;iwloc=near" title="Map showing <?php echo SITE_NAME; ?>, <?php echo NAP_CITY; ?>, <?php echo NAP_REGION; ?>" frameborder="0" style="border:0; width: 100%; height: 384px;" loading="lazy" allowfullscreen></iframe>
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
                <textarea class="form-control" id="message" name="message" rows="5" placeholder="Fabric type, layer thickness in mm, sample size, quantity…" required></textarea>
              </div>
              <div class="my-3">
                <div class="loading">Loading</div>
                <div class="error-message"></div>
                <div class="sent-message">Thank you! Your enquiry has been received. We will respond within 24 hours.</div>
              </div>
              <div class="text-center"><button type="submit">Send Enquiry</button></div>
            </form>
          </div>

        </div>

      </div>
    </section><!-- End Contact Section -->

  <!-- End #main -->
</main>

  <?php include("footer.php"); ?>
