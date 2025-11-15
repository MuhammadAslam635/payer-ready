<?php $attributes ??= new \Illuminate\View\ComponentAttributeBag;

$__newAttributes = [];
$__propNames = \Illuminate\View\ComponentAttributeBag::extractPropNames((['url']));

foreach ($attributes->all() as $__key => $__value) {
    if (in_array($__key, $__propNames)) {
        $$__key = $$__key ?? $__value;
    } else {
        $__newAttributes[$__key] = $__value;
    }
}

$attributes = new \Illuminate\View\ComponentAttributeBag($__newAttributes);

unset($__propNames);
unset($__newAttributes);

foreach (array_filter((['url']), 'is_string', ARRAY_FILTER_USE_KEY) as $__key => $__value) {
    $$__key = $$__key ?? $__value;
}

$__defined_vars = get_defined_vars();

foreach ($attributes->all() as $__key => $__value) {
    if (array_key_exists($__key, $__defined_vars)) unset($$__key);
}

unset($__defined_vars, $__key, $__value); ?>
<tr>
<td class="header" style="background-color: #ffffff; padding: 30px 0 20px 0; text-align: center;">
<a href="<?php echo new \Illuminate\Support\EncodedHtmlString($url); ?>" style="display: inline-block; text-decoration: none;">
<?php if(trim($slot) === 'Laravel' || trim($slot) === config('app.name')): ?>

<svg width="200" height="50" viewBox="0 0 485 100" xmlns="http://www.w3.org/2000/svg" style="display: block; margin: 0 auto;" aria-label="PayerReady Logo">
    <style>
        .logo-text { font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif; font-size: 50px; font-weight: 800; fill: #0d9488; dominant-baseline: central; letter-spacing: 0.02em; }
        .sub-text { font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, 'Noto Sans', sans-serif; font-size: 16px; font-weight: 600; fill: white; text-anchor: middle; dominant-baseline: central; letter-spacing: 0.05em; }
    </style>

    <!-- Main Text & Shield -->
    <g>
        <text x="0" y="45" class="logo-text">PAYER</text>

        <!-- Shield for 'O' -->
        <g transform="translate(175, 22)">
             <path d="M25 0 L50 12 V28 C50 43 37.5 50 25 50 C12.5 50 0 43 0 28 V 12 Z" fill="#0d9488"/>
             <path d="M25 4 L46 14 V28 C46 40 35 46 25 46 C15 46 4 40 4 28 V 14 Z" fill="none" stroke="white" stroke-width="2.5"/>
        </g>

        <text x="240" y="45" class="logo-text">READY</text>
    </g>

    <!-- Sub-line -->
    <g>
         <rect x="0" y="75" width="465" height="22" rx="11" fill="#14b8a6" />
         <text x="232.5" y="86" class="sub-text">
             CREDENTIALING &amp; COMPLIANCE
         </text>
    </g>
</svg>
<?php else: ?>
<?php echo $slot; ?>

<?php endif; ?>
</a>
</td>
</tr>
<?php /**PATH C:\Users\Ammar\Desktop\Doctor project\payer-ready\resources\views/vendor/mail/html/header.blade.php ENDPATH**/ ?>