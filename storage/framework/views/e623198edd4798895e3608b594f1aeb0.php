<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo new \Illuminate\Support\EncodedHtmlString(config('app.name')); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<meta name="color-scheme" content="light">
<meta name="supported-color-schemes" content="light">
<style>
/* Payer Ready Email Theme */
body {
    background-color: #f0fdfa;
    color: #1e293b;
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
}

.wrapper {
    background-color: #f0fdfa;
    padding: 20px 0;
}

.body {
    background-color: #f0fdfa;
    padding: 20px 0;
}

.inner-body {
    background-color: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 12px;
    box-shadow: 0 4px 6px -1px rgba(13, 148, 136, 0.1), 0 2px 4px -1px rgba(13, 148, 136, 0.06);
}

.content-cell {
    padding: 40px;
}

h1 {
    color: #0f766e;
    font-size: 24px;
    font-weight: 700;
}

h2 {
    color: #115e59;
    font-size: 20px;
    font-weight: 600;
}

p {
    color: #334155;
    font-size: 16px;
    line-height: 1.6;
}

a {
    color: #0d9488;
}

a:hover {
    color: #0f766e;
}

.button-primary {
    background-color: #0d9488 !important;
    border-color: #0d9488 !important;
}

.button-primary:hover {
    background-color: #0f766e !important;
    border-color: #0f766e !important;
}

@media only screen and (max-width: 600px) {
.inner-body {
width: 100% !important;
border-radius: 0 !important;
}

.footer {
width: 100% !important;
}

.content-cell {
padding: 24px !important;
}
}

@media only screen and (max-width: 500px) {
.button {
width: 100% !important;
}
}
</style>
<?php echo $head ?? ''; ?>

</head>
<body>

<table class="wrapper" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<tr>
<td align="center">
<table class="content" width="100%" cellpadding="0" cellspacing="0" role="presentation">
<?php echo $header ?? ''; ?>


<!-- Email Body -->
<tr>
<td class="body" width="100%" cellpadding="0" cellspacing="0" style="border: hidden !important;">
<table class="inner-body" align="center" width="570" cellpadding="0" cellspacing="0" role="presentation">
<!-- Body content -->
<tr>
<td class="content-cell">
<?php echo Illuminate\Mail\Markdown::parse($slot); ?>


<?php echo $subcopy ?? ''; ?>

</td>
</tr>
</table>
</td>
</tr>

<?php echo $footer ?? ''; ?>

</table>
</td>
</tr>
</table>
</body>
</html>
<?php /**PATH C:\Users\Ammar\Desktop\Doctor project\payer-ready\resources\views/vendor/mail/html/layout.blade.php ENDPATH**/ ?>