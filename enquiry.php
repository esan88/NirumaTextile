<?php
/**
 * Enquiry form handler.
 *
 * The four .php-email-form forms on the site post here (extensionless
 * URL, because .htaccess 301-strips .php and a redirect would turn the
 * POST into a GET). The front-end JS expects a response body of exactly
 * "OK" on success and any other 200 body as the error text to show the
 * visitor, so failures must never come back as a blank page or a 500.
 */
require_once __DIR__ . '/seo.php';

header('X-Robots-Tag: noindex, nofollow');

$isAjax = isset($_SERVER['HTTP_X_REQUESTED_WITH'])
    && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

/** Terminate with either the JS contract ("OK") or a small human page. */
function ntm_enquiry_respond($ok, $heading, $body)
{
    global $isAjax;

    if ($isAjax) {
        http_response_code(200);
        header('Content-Type: text/plain; charset=UTF-8');
        echo $ok ? 'OK' : $body;
        exit;
    }

    http_response_code($ok ? 200 : 400);
    header('Content-Type: text/html; charset=UTF-8');
    $home = niruma_url('');
    $css  = niruma_asset('vendor/bootstrap/css/bootstrap.min.css');
    $font = "'Open Sans', 'Helvetica Neue', Arial, sans-serif";
    echo '<!DOCTYPE html><html lang="' . SITE_LANG . '"><head>'
        . '<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">'
        . '<meta name="robots" content="noindex,nofollow">'
        . '<title>' . htmlspecialchars($heading, ENT_QUOTES) . ' | ' . SITE_NAME . '</title>'
        . '<link href="' . $css . '" rel="stylesheet">'
        . '<style>body{background:#f6f9fb;font-family:' . $font . ';color:#072a35}'
        . '.card{max-width:640px;margin:64px auto;padding:0 16px}'
        . '.panel{background:#fff;border:1px solid #e3ecf1;border-radius:10px;padding:36px 32px;'
        . 'box-shadow:0 10px 30px rgba(0,40,55,.08)}'
        . 'h1{font-size:26px;margin:0 0 12px;color:#005e72}'
        . 'p{font-size:16px;line-height:1.65;margin:0 0 18px}'
        . 'a.btn{display:inline-block;background:#005e72;color:#fff;text-decoration:none;'
        . 'padding:12px 24px;border-radius:6px;font-weight:600}'
        . 'a.btn:hover{background:#004455}</style></head><body><main class="card">'
        . '<div class="panel"><h1>' . htmlspecialchars($heading, ENT_QUOTES) . '</h1>'
        . '<p>' . $body . '</p>'
        . '<a class="btn" href="' . $home . '">Back to ' . SITE_NAME . '</a>'
        . '</div></main></body></html>';
    exit;
}

/* --------------------------------------------------------------
 * Only accept POST; a stray GET /enquiry lands on the contact page.
 * ----------------------------------------------------------- */
if (($_SERVER['REQUEST_METHOD'] ?? 'GET') !== 'POST') {
    header('Location: ' . niruma_url('contact-us'), true, 303);
    exit;
}

/* --------------------------------------------------------------
 * Collect + normalise.
 * ----------------------------------------------------------- */
$post = array();
foreach (array('name', 'email', 'phone', 'subject', 'message', 'product') as $key) {
    $value = isset($_POST[$key]) ? $_POST[$key] : '';
    if (is_array($value)) $value = '';
    // Strip control characters (keeps \n) so nothing odd reaches the mail().
    $value = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/u', '', (string) $value);
    $post[$key] = trim($value);
}

/* Honeypot: the field is visually hidden in every form. Humans never
   see it, bots fill it in - answer with a normal success so they learn
   nothing and the address is not mailed. */
if (!empty($_POST['ntm_website'])) {
    ntm_enquiry_respond(true, 'Thank you for your enquiry', '');
}

$name    = $post['name'];
$email   = $post['email'];
$phone   = $post['phone'];
$subject = $post['subject'];
$message = $post['message'];
$product = $post['product'];

/* --------------------------------------------------------------
 * Validate.
 * ----------------------------------------------------------- */
if ($name === '') {
    ntm_enquiry_respond(false, 'Name required', 'Please tell us your name so we know who to reply to.');
}
if (strlen($name) > 120) {
    ntm_enquiry_respond(false, 'Name too long', 'Please keep your name under 120 characters.');
}
if ($email === '' || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    ntm_enquiry_respond(false, 'Email address required', 'Please enter a valid email address - that is where we send the quotation.');
}
if (strlen($email) > 190) {
    ntm_enquiry_respond(false, 'Email address too long', 'Please keep the email address under 190 characters.');
}
if ($message === '') {
    ntm_enquiry_respond(false, 'Message required', 'Please describe your requirement - fabric type, layer thickness in mm, sample size and quantity.');
}
if (strlen($message) > 4000) {
    ntm_enquiry_respond(false, 'Message too long', 'Please keep your requirement under 4000 characters.');
}

/* --------------------------------------------------------------
 * Assemble the mail. Newlines in the header fields are removed so a
 * submitted value can never inject extra headers.
 * ----------------------------------------------------------- */
$mailSubject = 'Website enquiry: ' . ($subject !== '' ? $subject : ($product !== '' ? $product : 'General'));
$mailSubject = str_replace(array("\r", "\n", '%'), array(' ', ' ', ' '), $mailSubject);
$mailSubject = '=?UTF-8?B?' . base64_encode($mailSubject) . '?=';

$fromAddress = EMAIL_PRIMARY;
$fromName    = str_replace(array("\r", "\n"), ' ', SITE_NAME);

$body  = "New enquiry from the website\n";
$body .= "================================\n\n";
$body .= "Name:    " . $name . "\n";
$body .= "Email:   " . $email . "\n";
$body .= "Phone:   " . ($phone !== '' ? $phone : '(not given)') . "\n";
$body .= "Subject: " . ($subject !== '' ? $subject : '(not given)') . "\n";
if ($product !== '') $body .= "Product: " . $product . "\n";
$body .= "\nRequirement\n--------------------------------\n" . $message . "\n";
$body .= "\n--------------------------------\n";
$body .= "Sent: " . date('d M Y, H:i:s T') . "\n";
$body .= "IP:   " . (isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : 'unknown') . "\n";
$body .= "Page: " . (isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'direct') . "\n";

$headers  = 'From: ' . $fromName . ' <' . $fromAddress . '>' . "\r\n";
$headers .= 'Reply-To: ' . $name . ' <' . $email . '>' . "\r\n";
$headers .= 'Return-Path: ' . $fromAddress . "\r\n";
$headers .= 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-Type: text/plain; charset=UTF-8' . "\r\n";
$headers .= 'X-Mailer: PHP/' . phpversion();

$sent = @mail(EMAIL_PRIMARY, $mailSubject, $body, $headers);

if (!$sent) {
    // Never surface a 5xx or a blank body: JS turns any non-"OK" 200
    // payload into readable text in the form.
    ntm_enquiry_respond(
        false,
        'Message not sent',
        'Sorry, your message could not be sent right now. Please email '
        . '<a href="mailto:' . EMAIL_PRIMARY . '">' . EMAIL_PRIMARY . '</a> or call '
        . PHONE_PRIMARY . '.'
    );
}

ntm_enquiry_respond(true, 'Thank you for your enquiry', '');
