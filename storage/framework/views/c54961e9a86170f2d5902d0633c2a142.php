<?php $__env->startComponent('mail::message'); ?>
# Verify Your Email Address

Hello <?php echo new \Illuminate\Support\EncodedHtmlString($user->name); ?>,

Your account has been created successfully. Before you can login and access your account, please verify your email address by clicking the button below.

<?php $__env->startComponent('mail::button', ['url' => $verificationUrl]); ?>
Verify Email Address
<?php echo $__env->renderComponent(); ?>

This verification link will expire in 7 days.

If you did not create an account, no further action is required.

If you're having trouble clicking the "Verify Email Address" button, copy and paste the URL below into your web browser:

<?php echo new \Illuminate\Support\EncodedHtmlString($verificationUrl); ?>


Thanks,<br>
<?php echo new \Illuminate\Support\EncodedHtmlString(config('app.name')); ?>

<?php echo $__env->renderComponent(); ?>

<?php /**PATH C:\Users\Ammar\Desktop\Doctor project\payer-ready\resources\views/mail/verify-email.blade.php ENDPATH**/ ?>