<?php
require_once __DIR__ . '/seo.php'; // site constants + helpers must load before the meta/schema block

$metatitle = 'About Us | Niruma Textile Machinery, Ahmedabad since 1980';
$title     = $metatitle;
$metadesc  = 'Niruma Textile Machinery: in-house maker of fabric sample cutting, inspection, rolling and folding machines in Odhav, Ahmedabad. Export support since 1980.';
$metakeywords = 'textile machinery manufacturer Ahmedabad, textile machinery company since 1980, Niruma Textile Machinery, fabric machinery manufacturers Gujarat, textile machinery exporter India';
$ogimage   = 'assets/img/about.webp';
$breadcrumbs = array(
    array('name' => 'Home', 'url' => '/'),
    array('name' => 'About Us'),
);

$schema = array(
    array(
        '@type' => 'AboutPage',
        '@id'   => SITE_URL . '/about-us#webpage',
        'url'   => SITE_URL . '/about-us',
        'name'  => 'About ' . SITE_NAME,
        'isPartOf' => array('@id' => SITE_URL . '/#website'),
        'inLanguage' => SITE_LANG,
    ),
    array(
        '@type' => 'LocalBusiness',
        '@id'   => SITE_URL . '/about-us#localbusiness',
        'name'  => SITE_NAME,
        'image' => DEFAULT_OG_IMAGE,
        'url'   => SITE_URL . '/',
        'telephone' => PHONE_PRIMARY_TEL,
        'email' => EMAIL_PRIMARY,
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
    ),
);

include("header.php");
?>

  <!-- ======= Page Hero ======= -->
  <main id="main"><section id="hero" class="d-flex align-items-center ntm-page-hero">
    <div class="container" data-aos="zoom-out" data-aos-delay="100">
      <h1><b>About <span>Niruma Textile Machinery</span></b></h1>
      <h3 class="mt-3">Textile machinery manufacturers and exporters from Odhav, Ahmedabad, Gujarat &mdash; since <?php echo FOUNDED_YEAR; ?></h3>
    </div>
  </section>

  <!-- ======= Our Story ======= -->
  <section id="story" class="about section-bg">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Our Story</h2>
        <h3>Four Decades of <span>Machine Building</span></h3>
      </div>

      <div class="row">
        <div class="col-lg-6" data-aos="fade-right" data-aos-delay="100">
          <img src="<?php echo niruma_asset('img/about.webp'); ?>" class="img-fluid" loading="lazy" alt="Niruma Textile Machinery manufacturing facility in Odhav, Ahmedabad, Gujarat, India">
        </div>
        <div class="col-lg-6 pt-4 pt-lg-0 content d-flex flex-column justify-content-center" data-aos="fade-up" data-aos-delay="100">
          <p><b>Niruma Textile Machinery</b> began in <?php echo FOUNDED_YEAR; ?> with a simple objective &mdash; build textile machinery that survives a real textile shop floor. From a single <b>fabric sample cutting machine</b> order, the company grew into a full range of machines covering the complete fabric handling workflow.</p>
          <ul>
            <li>
              <i class="bx bx-store-alt"></i>
              <div>
                <h5>What we manufacture</h5>
                <p><b>Fabric sample cutting machines</b> (fully automatic PLC, automatic worm-gear, semi-automatic, lever press and manual), <b>fabric inspection cum rolling machines</b>, <b>fabric rolling machines</b>, <b>fabric folding and taka folding machines</b>, <b>fabric roll stretch wrapping machines</b> and <b>weavers batching motions</b> for automatic looms.</p>
              </div>
            </li>
            <li>
              <i class="bx bx-images"></i>
              <div>
                <h5>How we build</h5>
                <p>Design, fabrication, welding, assembly and trial testing all happen in our own workshop. We use mild steel frames, imported gear boxes, worm gear box drives, AC inverter VFD controls and CNC-aligned rollers &mdash; chosen for durability rather than for a low purchase price.</p>
              </div>
            </li>
            <li>
              <i class="bx bx-globe"></i>
              <div>
                <h5>Who we supply</h5>
                <p>Fabric manufacturers, denim and garment units, weavers, composite mills, quality control departments, fabric trading houses and export houses in India, Bangladesh, Pakistan, UAE, Saudi Arabia, Egypt, Turkey, Vietnam, Italy, Spain and Mexico.</p>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>

  <!-- ======= Why Us ======= -->
  <section id="why-us" class="services">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Our Strengths</h2>
        <h3>Why Buyers <span>Choose Niruma</span></h3>
        <p>A manufacturer since <?php echo FOUNDED_YEAR; ?> &mdash; not a trading company reselling someone else's machine</p>
      </div>

      <div class="row">
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="icon-box"><div class="icon"><i class="bx bx-factory"></i></div><h4><a href="<?php echo niruma_url('fully-automatic-sample-cutting-machine'); ?>">In-House Manufacturing</a></h4><p>Every machine is fabricated, assembled and trial-tested at our Odhav plant. We control steel grade, welding quality and final testing in-house.</p></div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="icon-box"><div class="icon"><i class="bx bx-ruler"></i></div><h4><a href="<?php echo niruma_url('automatic-sample-cutting-machine'); ?>">Precision-Focused Design</a></h4><p>Calibrated scale bars, red laser zero-mark references, graduated guide plates, bow pipes, selvage guiders and CNC-aligned rollers for repeatable accuracy.</p></div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="icon-box"><div class="icon"><i class="bx bx-wrench"></i></div><h4><a href="<?php echo niruma_url('contact-us'); ?>">Shop-Floor Practicality</a></h4><p>Machines designed around real operating problems &mdash; daily cleaning, voltage fluctuation, varying operator skill and long duty cycles.</p></div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="icon-box"><div class="icon"><i class="bx bx-globe"></i></div><h4><a href="<?php echo niruma_url('contact-us'); ?>">Export Expertise</a></h4><p>Documentation, packing and clear machine videos with every export order, plus commissioning support for overseas buyers.</p></div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="icon-box"><div class="icon"><i class="bx bx-sliders"></i></div><h4><a href="<?php echo niruma_url('fabric-inspection-machine'); ?>">Customisation</a></h4><p>Blade sizes from 13" to 60", layer capacity to 60 mm, loom batching widths from 1150 mm to 4000 mm, and motor, drive and table options on request.</p></div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="icon-box"><div class="icon"><i class="bx bx-headset"></i></div><h4><a href="<?php echo niruma_url('contact-us'); ?>">After-Sales Service</a></h4><p>Installation, commissioning, operator training and spare parts support for every machine &mdash; within India and overseas.</p></div>
        </div>
      </div>
    </div>
  </section>

  <!-- ======= Industries ======= -->
  <section id="industries" class="services section-bg">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Industries</h2>
        <h3>Industries We <span>Serve</span></h3>
        <p>One supplier covering the entire fabric sample, inspection, handling and packing workflow</p>
      </div>

      <div class="row">
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="icon-box"><div class="icon"><i class="bx bx-store"></i></div><h4>Fabric &amp; Textile Manufacturers</h4><p>Composite mills and fabric manufacturers use our sample cutting machines in buyer swatch rooms, design studios and development departments.</p></div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="icon-box"><div class="icon"><i class="bx bx-badge"></i></div><h4>Denim &amp; Garment Units</h4><p>Denim, canvas and heavy fabric processors rely on 60 mm capacity machines with wide blades for thick, multi-layer sample cutting.</p></div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="icon-box"><div class="icon"><i class="bx bx-grid"></i></div><h4>Weavers &amp; Loom Units</h4><p>Batching motions for Sulzer, Picanol, Omni, Toyota and Tsudokoma Ruti-C looms give even-tension fabric rolling with a single operator.</p></div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="icon-box"><div class="icon"><i class="bx bx-check-shield"></i></div><h4>Quality Control &amp; Lab Departments</h4><p>Inspection machines with inclined tables, CNC-aligned rollers and selvage guiders are used for fabric defect detection and length measurement.</p></div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="icon-box"><div class="icon"><i class="bx bx-package"></i></div><h4>Exporters &amp; Logistics Warehouses</h4><p>Stretch wrapping machines dust-proof and moisture-proof denim, curtain, carpet and upholstery rolls before container loading.</p></div>
        </div>
        <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="icon-box"><div class="icon"><i class="bx bx-buildings"></i></div><h4>Retail &amp; Fabric Trading Houses</h4><p>Folding and rolling machines let traders convert loose fabric into neat, measured plaited or rolled stock for retail display and dispatch.</p></div>
        </div>
      </div>
    </div>
  </section>

  <!-- ======= Milestones ======= -->
  <section id="milestones" class="process">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Milestones</h2>
        <h3>How We <span>Grew</span></h3>
      </div>
      <div class="row">
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="100">
          <div class="process-step"><span class="step-no"><?php echo FOUNDED_YEAR; ?></span><h4>Company Founded</h4><p>Niruma Textile Machinery starts manufacturing fabric sample cutting machines in Odhav, Ahmedabad.</p></div>
        </div>
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="200">
          <div class="process-step"><span class="step-no">2000s</span><h4>Product Range Expansion</h4><p>Addition of fabric inspection, rolling, folding and stretch wrapping machines to build a complete workflow.</p></div>
        </div>
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="300">
          <div class="process-step"><span class="step-no">PLC</span><h4>Fully Automatic Models</h4><p>Launch of PLC-controlled, touch-screen fully automatic fabric sample cutting machines with laser marking.</p></div>
        </div>
        <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="400">
          <div class="process-step"><span class="step-no">10+</span><h4>Export Markets</h4><p>Regular shipments to buyers across South Asia, the Middle East and Europe, with full export documentation.</p></div>
        </div>
      </div>
    </div>
  </section>

  <!-- ======= Products Overview ======= -->
  <section id="products" class="portfolio section-bg">
    <div class="container" data-aos="fade-up">
      <div class="section-title">
        <h2>Product Range</h2>
        <h3>Explore Our <span>Textile Machines</span></h3>
        <p>Eleven machine models for fabric sample cutting, inspection, rolling, folding and roll packing</p>
      </div>
      <div class="row portfolio-container" data-aos="fade-up" data-aos-delay="200">
<?php foreach (niruma_products() as $p) : ?>
        <div class="col-lg-4 col-md-6 portfolio-item">
          <img src="<?php echo niruma_media_url($p['img']); ?>" class="img-fluid" loading="lazy" width="364" height="402" alt="<?php echo htmlspecialchars($p['name'], ENT_QUOTES); ?> by Niruma Textile Machinery">
          <div class="portfolio-info">
            <h4><?php echo htmlspecialchars($p['short'], ENT_QUOTES); ?></h4>
            <p><?php echo htmlspecialchars($p['desc'], ENT_QUOTES); ?></p>
            <a href="<?php echo niruma_url($p['slug']); ?>" class="details-link" title="More details about <?php echo htmlspecialchars($p['name'], ENT_QUOTES); ?>"><i class="bx bx-link"></i><span class="visually-hidden">Details</span></a>
          </div>
        </div>
<?php endforeach; ?>
      </div>
    </div>
  </section>

  <!-- ======= CTA ======= -->
<?php echo niruma_render_cta('Visit Our Factory in Ahmedabad', 'Bileshwar Industrial Estate, Odhav &mdash; 10 minutes from S. P. Ring Road. See our sample cutting, inspection and rolling machines running before you buy.'); ?>
</main>

  <?php include("footer.php"); ?>
