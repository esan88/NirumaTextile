<?php
/**
 * Site-wide SEO configuration + helpers.
 * Included by header.php. Every page may override the $seo* variables
 * BEFORE including header.php.
 */

if (!defined('SITE_NAME')) {

    /* ---------- Identity ----------
     * SITE_URL is the canonical production origin and is what gets emitted
     * in canonical tags, hreflang, JSON-LD @id and sitemap entries.
     *
     * When previewing on a local Apache/XAMPP host we serve the same files
     * from that host instead, so CSS/JS/images actually load while testing.
     * The guard is deliberately narrow: plain http on localhost/127.0.0.1
     * only. Any real request - including production over https - keeps the
     * canonical production origin.
     */
    $__ntmHost = isset($_SERVER['HTTP_HOST']) ? strtolower($_SERVER['HTTP_HOST']) : '';
    $__ntmLocalPreview = in_array($__ntmHost, array('localhost', 'localhost:80', '127.0.0.1', '127.0.0.1:80', '[::1]'), true)
        && empty($_SERVER['HTTPS']);
    unset($__ntmHost);

    define('SITE_NAME',    'Niruma Textile Machinery');
    define('SITE_URL',     $__ntmLocalPreview ? 'http://localhost/niruma' : 'https://nirumatextilemachinery.in');
    define('SITE_LOCALE',  'en_IN');
    define('SITE_LANG',    'en-IN');
    define('FOUNDED_YEAR', 1980);
    define('SITE_LOGO',    SITE_URL . '/assets/img/logo.png');

    /* ---------- NAP (Name / Address / Phone) - keep identical everywhere ---------- */
    define('NAP_STREET',   'A/161, Bileshwar Industrial Estate, Opp. GVMM, Near S. P. Ring Road');
    define('NAP_CITY',     'Odhav');
    define('NAP_REGION',   'Gujarat');
    define('NAP_POSTCODE', '382415');
    define('NAP_COUNTRY',  'IN');
    define('SITE_GEO_LAT', '22.8033');
    define('SITE_GEO_LNG', '72.7911');

    define('PHONE_PRIMARY',    '+91 9662660377');
    define('PHONE_SECONDARY',  '+91 9327084627');
    define('PHONE_PRIMARY_TEL','+919662660377');
    define('PHONE_SECONDARY_TEL','+919327084627');
    define('EMAIL_PRIMARY',    'info@nirumatextilemachinery.in');

    define('SOCIAL_YOUTUBE',   'https://www.youtube.com/@nirumatextilemachinery');

    define('DEFAULT_OG_IMAGE', SITE_URL . '/assets/img/portfolio/Fully-Automatic-Sample-Cutting-Machine-Niruma.webp');

    /* ---------- Safe fallbacks for every page-level variable ---------- */
    if (!isset($metatitle)) $metatitle = SITE_NAME . ' | Textile Machinery Manufacturer & Exporter in Ahmedabad, India';
    if (!isset($title))    $title    = $metatitle;
    if (!isset($metadesc)) $metadesc = 'Niruma Textile Machinery is a leading manufacturer and exporter of fabric sample cutting machines, fabric inspection machines, rolling machines and folding machines since 1980. Based in Ahmedabad, Gujarat, India.';
    if (!isset($metakeywords)) $metakeywords = '';
    if (!isset($ogimage))  $ogimage  = DEFAULT_OG_IMAGE;
    if (!isset($ogtype))   $ogtype   = 'website';
    if (!isset($schema))   $schema   = array();
    if (!isset($breadcrumbs)) $breadcrumbs = array();
    if (!isset($nofollow)) $nofollow = false;
}

/* =====================================================================
 * URL helpers
 * ================================================================== */

/** Full absolute URL for a root-relative path. */
function niruma_url($path = '/')
{
    if ($path === '' || $path === null) return SITE_URL . '/';
    if (preg_match('#^https?://#i', $path)) return $path;
    return SITE_URL . '/' . ltrim($path, '/');
}

/** Full absolute URL for a file inside /assets. */
function niruma_asset($path)
{
    if (preg_match('#^https?://#i', $path)) return $path;
    return SITE_URL . '/assets/' . ltrim($path, '/');
}

/**
 * Absolute URL for an OG/social image. Accepts an already-absolute
 * URL, a root-relative path, or an /assets-relative path.
 */
function niruma_media_url($path)
{
    if (preg_match('#^https?://#i', $path)) return $path;
    if (strpos($path, 'assets/') === 0) return SITE_URL . '/' . ltrim($path, '/');
    if (strpos($path, '/') === 0)    return SITE_URL . $path;
    return niruma_asset($path);
}

/**
 * Intrinsic pixel size of a local image, so width/height attributes and
 * og:image:width/height describe the file that is actually served.
 *
 * Every product image on this site is 1288x600, not the 1200x630 that was
 * previously hardcoded into the Open Graph tags. Results are cached per path
 * and a static fallback is returned if the file is missing or unreadable, so
 * a broken path can never emit an empty or zero dimension.
 */
function niruma_image_size($path, $defaultW = 1200, $defaultH = 630)
{
    static $cache = array();
    if (!is_string($path) || $path === '') return array($defaultW, $defaultH);
    if (isset($cache[$path])) return $cache[$path];

    $w = $defaultW; $h = $defaultH;

    // Only probe local files; remote URLs are left at the fallback size.
    if (!preg_match('#^https?://#i', $path)) {
        $rel = strpos($path, 'assets/') === 0 ? $path : ltrim($path, '/');
        $file = __DIR__ . '/' . $rel;
        if (is_file($file) && is_readable($file)) {
            $info = @getimagesize($file);
            if (is_array($info) && !empty($info[0]) && !empty($info[1])) {
                $w = (int) $info[0];
                $h = (int) $info[1];
            }
        }
    }

    $cache[$path] = array($w, $h);
    return $cache[$path];
}

/** Canonical URL for the current request, derived from $_SERVER. */
function niruma_current_url()
{
    $scheme = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host   = isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : 'nirumatextilemachinery.in';
    $uri    = isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '/';

    // strip query string and index.php
    $uri = preg_replace('/\?.*$/', '', $uri);
    $uri = preg_replace('#/index(\.php)?$#', '/', $uri);
    if ($uri === '') $uri = '/';

    return $scheme . '://' . $host . $uri;
}

/** JSON-LD safe output. */
function niruma_json($data)
{
    return json_encode(
        $data,
        JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT
    );
}

/* =====================================================================
 * Organization / LocalBusiness schema  (emitted on every page)
 * ================================================================== */
function niruma_organization_schema()
{
    $sameAs = array(SOCIAL_YOUTUBE);

    return array(
        '@type' => 'Organization',
        '@id'   => SITE_URL . '/#organization',
        'name'  => SITE_NAME,
        'alternateName' => 'Niruma Textile Machinery',
        'legalName' => SITE_NAME,
        'url'   => SITE_URL . '/',
        'logo'  => SITE_LOGO,
        'image' => DEFAULT_OG_IMAGE,
        'description' => 'Manufacturer and exporter of fabric sample cutting machines, fabric inspection machines, fabric rolling machines, folding machines and loom batching motions since 1980.',
        'foundingDate' => (string) FOUNDED_YEAR,
        'sameAs' => $sameAs,
        'address' => array(
            '@type'           => 'PostalAddress',
            'streetAddress'   => NAP_STREET,
            'addressLocality' => NAP_CITY,
            'addressRegion'   => NAP_REGION,
            'postalCode'      => NAP_POSTCODE,
            'addressCountry'  => NAP_COUNTRY,
        ),
        'contactPoint' => array(
            array(
                '@type'             => 'ContactPoint',
                'telephone'         => PHONE_PRIMARY_TEL,
                'contactType'       => 'sales',
                'areaServed'        => array('IN', 'AE', 'BD', 'CN', 'EG', 'ES', 'IT', 'KR', 'MA', 'MX', 'NG', 'PK', 'SA', 'TR', 'US', 'VN'),
                'availableLanguage' => array('English', 'Hindi', 'Gujarati'),
            ),
        ),
    );
}

/* =====================================================================
 * WebSite schema
 * ================================================================== */
function niruma_website_schema()
{
    return array(
        '@type'           => 'WebSite',
        '@id'             => SITE_URL . '/#website',
        'url'             => SITE_URL . '/',
        'name'            => SITE_NAME,
        'inLanguage'      => SITE_LANG,
        'publisher'       => array('@id' => SITE_URL . '/#organization'),
    );
}

/* =====================================================================
 * Product catalogue (single source of truth for grid, sitemap & schema)
 * ================================================================== */
function niruma_products()
{
    return array(
        array(
            'slug'  => 'fully-automatic-sample-cutting-machine',
            'name'  => 'Fully Automatic Fabric Sample Cutting Machine',
            'short' => 'Fully Automatic Sample Cutting Machine',
            'img'    => 'assets/img/portfolio/Fully-Automatic-Sample-Cutting-Machine-Niruma.webp',
            'desc'  => 'PLC-controlled zigzag swatch cutter with colour touch screen and laser zero-mark reference. Cuts up to 60 mm of fabric in a single stroke.',
        ),
        array(
            'slug'  => 'automatic-sample-cutting-machine',
            'name'  => 'Automatic Fabric Sample Cutting Machine',
            'short' => 'Automatic Sample Cutting Machine',
            'img'    => 'assets/img/portfolio/Automatic-Sample-Cutting-Machine-Niruma.webp',
            'desc'  => 'Worm gear box sample cutter with calibrated scale bar and red laser guide. Cuts up to 60 mm in one stroke, blades from 13" to 60".',
        ),
        array(
            'slug'  => 'semi-automatic-sample-cutting-machine',
            'name'  => 'Semi Automatic Fabric Sample Cutting Machine',
            'short' => 'Semi Automatic Sample Cutting Machine',
            'img'    => 'assets/img/portfolio/Semi-Automatic-Sample-Cutting-Machine-Niruma.webp',
            'desc'  => 'Compact table-mount zigzag cutter that auto-stops after each cut, with graduated guide plate, safety guard and 13"/18"/24" blades.',
        ),
        array(
            'slug'  => 'lever-press-zig-zag-cutting-machine',
            'name'  => 'Lever Press Zigzag Fabric Sample Cutting Machine',
            'short' => 'Lever Press Zigzag Cutting Machine',
            'img'    => 'assets/img/portfolio/Lever-Press-Zigzag-Cutting-Machine-Niruma.webp',
            'desc'  => 'Heavy-duty lever press swatch cutter on a mild steel stand with a hardened WPS blade and inch-graduated guide plate.',
        ),
        array(
            'slug'  => 'manual-sample-cutting-machine',
            'name'  => 'Manual Fabric Sample Cutting Machine',
            'short' => 'Manual Sample Cutting Machine',
            'img'    => 'assets/img/portfolio/Manual-Sample-Cutting-Machine-Niruma.webp',
            'desc'  => 'Cost-effective flywheel and ratchet-handle zigzag cutter. Ideal for labs, sample rooms and small order books up to 35 mm.',
        ),
        array(
            'slug'  => 'fabric-inspection-machine',
            'name'  => 'Fabric Inspection and Rolling Machine',
            'short' => 'Fabric Inspection Machine',
            'img'    => 'assets/img/portfolio/Fabric-Inspection-and-Rolling-Machine-Niruma.webp',
            'desc'  => 'Inclined inspection table with imported gearbox, AC inverter VFD drive, CNC-aligned rollers, bow pipe and selvage guider.',
        ),
        array(
            'slug'  => 'fabric-rolling-machine',
            'name'  => 'Fabric Rolling Machine',
            'short' => 'Fabric Rolling Machine',
            'img'    => 'assets/img/portfolio/Fabric-Rolling-Machine-Niruma.webp',
            'desc'  => 'Mild steel fabric rolling machine with fabric length counter, variable speed, tension control and crease-free rolling.',
        ),
        array(
            'slug'  => 'fabric-folding-machine',
            'name'  => 'Fabric Folding Machine',
            'short' => 'Fabric Folding Machine',
            'img'    => 'assets/img/portfolio/Fabric-Folding-Machine-Niruma.webp',
            'desc'  => 'Plaiting machine with adjustable support, up to 1.2 m plaiting width, 85 RPM variable speed, handles wet and dry fabrics.',
        ),
        array(
            'slug'  => 'taka-folding-machine',
            'name'  => 'Taka Folding Machine',
            'short' => 'Taka Folding Machine',
            'img'    => 'assets/img/portfolio/Taka-Folding-Machine-Niruma.webp',
            'desc'  => 'Mild steel frame folding machine with digital length counter, guide rollers, variable speed and electric motor drive for all fabric types.',
        ),
        array(
            'slug'  => 'fabric-roll-wrapping-machine',
            'name'  => 'Fabric Roll Stretch Wrapping Machine',
            'short' => 'Fabric Roll Wrapping Machine',
            'img'    => 'assets/img/portfolio/Roll-Stretch-Wrapping-Machine-Niruma.webp',
            'desc'  => 'Economical roll-to-roll stretch wrapper for denim, curtains, carpets, foam and upholstery with variable stretch and overlap.',
        ),
        array(
            'slug'  => 'batching-motion-for-looms',
            'name'  => 'Batching Motion for Looms',
            'short' => 'Batching Motion for Looms',
            'img'    => 'assets/img/portfolio/Batching-Motion-for-Looms-Niruma.webp',
            'desc'  => 'Ergonomic single-operator batching motion for Sulzer, Picanol, Omni, Toyota and Tsudokoma Ruti-C looms from 1150 mm to 4000 mm width.',
        ),
    );
}

/* =====================================================================
 * BreadcrumbList schema + visible breadcrumb navigation
 * ================================================================== */

/**
 * @param array $items  [ ['name'=>'Home','url'=>'/'], ['name'=>'Products'], ... ]
 *                      The last item is the current page (url optional).
 */
function niruma_breadcrumb_schema($items)
{
    $list = array();
    $i = 1;
    foreach ($items as $it) {
        $node = array(
            '@type'    => 'ListItem',
            'position' => $i,
            'name'     => $it['name'],
        );
        if (!empty($it['url'])) {
            $node['item'] = niruma_url($it['url']);
        }
        $list[] = $node;
        $i++;
    }
    return array(
        '@type'           => 'BreadcrumbList',
        '@id'             => niruma_current_url() . '#breadcrumb',
        'itemListElement' => $list,
    );
}

/**
 * Render the visible breadcrumb trail.
 *
 * $items MUST already contain the "Home" entry as its first element, so the
 * markup and the BreadcrumbList schema are built from exactly the same data.
 * (This function used to prepend its own "Home" on top of the caller's, which
 * rendered two "Home" links and made the visible trail disagree with the
 * structured data.)
 */
function niruma_render_breadcrumbs($items)
{
    if (empty($items)) return '';
    $html  = '<nav class="ntm-breadcrumb" aria-label="Breadcrumb"><div class="container"><ol>';
    $last  = count($items) - 1;
    foreach ($items as $i => $it) {
        $html .= '<li>';
        if ($i === $last || empty($it['url'])) {
            $html .= '<span aria-current="page">' . htmlspecialchars($it['name'], ENT_QUOTES) . '</span>';
        } else {
            $html .= '<a href="' . niruma_url($it['url']) . '">' . htmlspecialchars($it['name'], ENT_QUOTES) . '</a>';
        }
        $html .= '</li>';
    }
    $html .= '</ol></div></nav>';
    return $html;
}

/* =====================================================================
 * FAQ helpers
 * ================================================================== */

/**
 * @param array $faqs array of ['q' => question, 'a' => answer]
 */
function niruma_faq_schema($faqs)
{
    $entities = array();
    foreach ($faqs as $f) {
        if (empty($f['q']) || empty($f['a'])) continue;
        $entities[] = array(
            '@type'          => 'Question',
            'name'           => $f['q'],
            'acceptedAnswer' => array(
                '@type' => 'Answer',
                'text'  => $f['a'],
            ),
        );
    }
    if (empty($entities)) return null;
    return array(
        '@type'      => 'FAQPage',
        '@id'        => niruma_current_url() . '#faq',
        'mainEntity' => $entities,
    );
}

/**
 * Visible FAQ accordion.
 *
 * Built on native <details>/<summary> so the answers are openable with no
 * JavaScript at all. The previous version used Bootstrap's .collapse, which
 * hid every answer behind JS: if bootstrap.bundle.min.js failed to load the
 * questions stayed on screen with no way to reveal the replies.
 */
function niruma_render_faq($faqs, $id = 'faq')
{
    if (empty($faqs)) return '';

    $html  = '<section id="faq" class="faq section-bg" itemscope itemtype="https://schema.org/FAQPage">';
    $html .= '<div class="container">';
    $html .= '<div class="section-title">';
    $html .= '<h2>Frequently Asked Questions</h2>';
    $html .= '<p>Answers to the questions buyers ask most often about this machine.</p>';
    $html .= '</div>';
    $html .= '<div class="ntm-faq">';

    $i = 0;
    foreach ($faqs as $f) {
        if (empty($f['q'])) continue;
        $i++;
        $html .= '<details class="ntm-faq__item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question"'
               . ($i === 1 ? ' open' : '') . '>';
        $html .= '<summary class="ntm-faq__q" itemprop="name">';
        $html .= '<span>' . htmlspecialchars($f['q'], ENT_QUOTES) . '</span>';
        $html .= '<i class="bi bi-plus-lg ntm-faq__sign" aria-hidden="true"></i>';
        $html .= '</summary>';
        $html .= '<div class="ntm-faq__a" itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">';
        $html .= '<div itemprop="text">' . $f['a'] . '</div>';
        $html .= '</div>';
        $html .= '</details>';
    }

    $html .= '</div></div></section>';
    return $html;
}

/* =====================================================================
 * Product schema
 * ================================================================== */
function niruma_product_schema($p)
{
    $img = isset($p['image']) && $p['image'] !== ''
        ? niruma_media_url($p['image'])
        : DEFAULT_OG_IMAGE;

    $schema = array(
        '@type'       => 'Product',
        '@id'         => niruma_current_url() . '#product',
        'name'        => $p['name'],
        'image'       => array($img),
        'description' => $p['description'],
        'sku'         => isset($p['sku']) ? $p['sku'] : '',
        'mpn'         => isset($p['mpn']) ? $p['mpn'] : '',
        'brand'       => array(
            '@type' => 'Brand',
            'name'  => SITE_NAME,
        ),
        'manufacturer' => array(
            '@type' => 'Organization',
            'name'  => SITE_NAME,
            'url'   => SITE_URL . '/',
        ),
        'category' => isset($p['category']) ? $p['category'] : 'Textile Machinery',
        'url'      => niruma_current_url(),
    );
    if (!empty($p['offers'])) {
        $schema['offers'] = array(
            '@type'         => 'Offer',
            'url'           => niruma_current_url(),
            'availability'  => 'https://schema.org/InStock',
            'priceCurrency' => 'INR',
            'price'         => $p['offers'],
            'priceValidUntil' => date('Y-m-d', strtotime('+1 year')),
            'seller'        => array('@id' => SITE_URL . '/#organization'),
            'businessFunction' => 'https://schema.org/Sell',
            'areaServed'    => array('IN', 'AE', 'BD', 'CN', 'EG', 'ES', 'IT', 'KR', 'MA', 'MX', 'NG', 'PK', 'SA', 'TR', 'US', 'VN'),
        );
    }
    return $schema;
}

/* =====================================================================
 * Reusable inquiry CTA band
 * ================================================================== */
function niruma_render_cta($heading = 'Request a Quotation', $sub = 'Tell us your fabric type, sample size and daily output — our engineers will recommend the right machine within 24 hours.')
{
    $html  = '<section class="ntm-cta" aria-labelledby="cta-heading">';
    $html .= '<div class="container text-center" data-aos="fade-up">';
    $html .= '<h2 id="cta-heading">' . htmlspecialchars($heading, ENT_QUOTES) . '</h2>';
    $html .= '<p>' . htmlspecialchars($sub, ENT_QUOTES) . '</p>';
    $html .= '<div class="d-flex justify-content-center flex-wrap gap-3">';
    $html .= '<a href="' . niruma_url('contact-us') . '#inquiry" class="btn-get-started scrollto">Request a Quote</a>';
    $html .= '<a href="tel:' . PHONE_PRIMARY_TEL . '" class="ntm-btn-outline"><i class="bi bi-telephone-fill"></i> ' . PHONE_PRIMARY . '</a>';
    $html .= '<a href="' . niruma_url('Niruma-TM-Catalogue.pdf') . '" class="ntm-btn-outline" download><i class="bi bi-file-earmark-arrow-down"></i> Download Catalogue</a>';
    $html .= '</div>';
    $html .= '</div></section>';
    return $html;
}