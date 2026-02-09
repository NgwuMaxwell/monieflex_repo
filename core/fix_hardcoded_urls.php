<?php

// Script to fix hard-coded URLs in Blade templates
// This script will replace CDN URLs with asset() helpers

$files = [
    'core/resources/views/templates/basic/user/withdraw/methods.blade.php',
    'core/resources/views/templates/basic/user/withdraw/log.blade.php',
    'core/resources/views/templates/basic/user/twofactor.blade.php',
    'core/resources/views/templates/basic/user/support/index.blade.php',
    'core/resources/views/templates/basic/user/referred.blade.php',
    'core/resources/views/templates/basic/user/ptc/index.blade.php',
    'core/resources/views/templates/basic/user/ptc/create.blade.php',
    'core/resources/views/templates/basic/user/profile_setting.blade.php',
    'core/resources/views/templates/basic/user/profile_complete.blade.php',
    'core/resources/views/templates/basic/user/plan_progress.blade.php',
    'core/resources/views/templates/basic/user/payment/StripeV3.blade.php',
    'core/resources/views/templates/basic/user/payment/StripeJs.blade.php',
    'core/resources/views/templates/basic/user/payment/Flutterwave.blade.php',
    'core/resources/views/templates/basic/user/payment/deposit.blade.php',
    'core/resources/views/templates/basic/user/my_plans.blade.php',
    'core/resources/views/templates/basic/user/deposit_history.blade.php',
    'core/resources/views/templates/basic/user/dashboard.blade.php',
    'core/resources/views/templates/basic/user/auth/register.blade.php',
    'core/resources/views/templates/basic/user/auth/login.blade.php',
    'core/resources/views/templates/basic/user/blog/detail.blade.php',
    'core/resources/views/templates/basic/plans.blade.php',
    'core/resources/views/templates/basic/home.blade.php',
    'core/resources/views/templates/basic/user/blog/index.blade.php',
    'core/resources/views/templates/basic/layouts/app.blade.php',
    'core/resources/views/templates/basic/partials/headers.blade.php',
    'core/resources/views/templates/basic/partials/footers.blade.php',
    'core/resources/views/templates/basic/blog/details.blade.php',
    'core/resources/views/admin/layouts/master.blade.php',
    'core/resources/views/admin/reports/logins.blade.php',
    'core/resources/views/admin/ptc/create.blade.php',
    'core/resources/views/admin/reports.blade.php',
    'core/resources/views/admin/system/support.blade.php',
    'core/resources/views/admin/dashboard_links/index.blade.php',
];

$replacements = [
    // CDN URLs to replace with asset() helpers
    'https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css' => '{{ asset(\'assets/pub/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css\') }}',
    'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css' => '{{ asset(\'assets/pub/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css\') }}',
    'https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css' => '{{ asset(\'assets/pub/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css\') }}',
    'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css' => '{{ asset(\'assets/pub/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css\') }}',
    'https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css' => '{{ asset(\'assets/pub/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css\') }}',
    'https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap' => '{{ asset(\'assets/pub/css2?family=Roboto:ital,wght@0,300;0,400;0,500;0,700;1,300;1,400;1,500;1,700&display=swap\') }}',
    'https://code.jquery.com/jquery-3.5.1.slim.min.js' => '{{ asset(\'assets/pub/ajax/libs/jquery/3.5.1.slim.min.js\') }}',
    'https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js' => '{{ asset(\'assets/pub/npm/popper.js@1.16.1/dist/umd/popper.min.js\') }}',
    'https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js' => '{{ asset(\'assets/pub/npm/bootstrap@4.5.3/dist/js/bootstrap.min.js\') }}',
    'https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js' => '{{ asset(\'assets/pub/ajax/libs/jquery/3.6.3/jquery.min.js\') }}',
    'https://code.jquery.com/jquery-3.6.0.min.js' => '{{ asset(\'assets/pub/ajax/libs/jquery/3.6.0.min.js\') }}',
    'https://js.stripe.com/v3/' => '{{ asset(\'assets/pub/js.stripe.com/v3/\') }}',
    'https://api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js' => '{{ asset(\'assets/pub/api.ravepay.co/flwv3-pug/getpaidx/api/flwpbf-inline.js\') }}',
    'https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap' => '{{ asset(\'assets/pub/css2?family=Poppins:wght@300;400;500;600;700&display=swap\') }}',
    
    // Image URLs to replace with asset() helpers
    'https://perview.freelancerawais.online/malltask/t/assets/img/withdraw-record-banner-bg.png' => '{{ asset(\'assets/img/withdraw-record-banner-bg.png\') }}',
    'https://perview.freelancerawais.online/malltask/t/assets/img/home-modal-head-bg.png' => '{{ asset(\'assets/img/home-modal-head-bg.png\') }}',
    'https://perview.freelancerawais.online/malltask/assets/pub/ajax/libs/jquery/3.6.3/jquery.min.js' => '{{ asset(\'assets/pub/ajax/libs/jquery/3.6.3/jquery.min.js\') }}',
    'https://rethink.terrawatt.co.in/img/loading.gif' => '{{ asset(\'assets/img/loading.gif\') }}',
    'https://rethink.terrawatt.co.in/img/icon-usdt.png' => '{{ asset(\'assets/img/icon-usdt.png\') }}',
    'https://rethink.terrawatt.co.in/img/home-modal-head-bg.png' => '{{ asset(\'assets/img/home-modal-head-bg.png\') }}',
    'https://rethink.terrawatt.co.in/img/left-arrow.png' => '{{ asset(\'assets/img/left-arrow.png\') }}',
    'https://rethink.terrawatt.co.in/img/icon-telegram.png' => '{{ asset(\'assets/img/icon-telegram.png\') }}',
    'https://rethink.terrawatt.co.in/img/icon-notice.png' => '{{ asset(\'assets/img/icon-notice.png\') }}',
    'https://rethink.terrawatt.co.in/img/icon-about.png' => '{{ asset(\'assets/img/icon-about.png\') }}',
    'https://rethink.terrawatt.co.in/img/icon-crowdfund.png' => '{{ asset(\'assets/img/icon-crowdfund.png\') }}',
    'https://rethink.terrawatt.co.in/img/icon-bankaccount.png' => '{{ asset(\'assets/img/icon-bankaccount.png\') }}',
    'https://rethink.terrawatt.co.in/img/icon-bill.png' => '{{ asset(\'assets/img/icon-bill.png\') }}',
    'https://rethink.terrawatt.co.in/img/icon-coupon.png' => '{{ asset(\'assets/img/icon-coupon.png\') }}',
    'https://rethink.terrawatt.co.in/img/icon-download.png' => '{{ asset(\'assets/img/icon-download.png\') }}',
    'https://rethink.terrawatt.co.in/img/icon-download2.png' => '{{ asset(\'assets/img/icon-download2.png\') }}',
    'https://rethink.terrawatt.co.in/img/icon-home.png' => '{{ asset(\'assets/img/icon-home.png\') }}',
    'https://rethink.terrawatt.co.in/img/icon-income.png' => '{{ asset(\'assets/img/icon-income.png\') }}',
    'https://rethink.terrawatt.co.in/img/icon-invite.png' => '{{ asset(\'assets/img/icon-invite.png\') }}',
    'https://rethink.terrawatt.co.in/img/icon-logout.png' => '{{ asset(\'assets/img/icon-logout.png\') }}',
    'https://rethink.terrawatt.co.in/img/icon-recharge.png' => '{{ asset(\'assets/img/icon-recharge.png\') }}',
    'https://rethink.terrawatt.co.in/img/icon-recharge2.png' => '{{ asset(\'assets/img/icon-recharge2.png\') }}',
    'https://rethink.terrawatt.co.in/img/icon-rent.png' => '{{ asset(\'assets/img/icon-rent.png\') }}',
    'https://rethink.terrawatt.co.in/img/icon-service.png' => '{{ asset(\'assets/img/icon-service.png\') }}',
    'https://rethink.terrawatt.co.in/img/icon-setting.png' => '{{ asset(\'assets/img/icon-setting.png\') }}',
    'https://rethink.terrawatt.co.in/img/icon-share.png' => '{{ asset(\'assets/img/icon-share.png\') }}',
    'https://rethink.terrawatt.co.in/img/icon-task.png' => '{{ asset(\'assets/img/icon-task.png\') }}',
    'https://rethink.terrawatt.co.in/img/icon-user.png' => '{{ asset(\'assets/img/icon-user.png\') }}',
    'https://rethink.terrawatt.co.in/img/icon-withdraw.png' => '{{ asset(\'assets/img/icon-withdraw.png\') }}',
    'https://rethink.terrawatt.co.in/img/icon-withdraw2.png' => '{{ asset(\'assets/img/icon-withdraw2.png\') }}',
    'https://rethink.terrawatt.co.in/img/logo-icon2.png' => '{{ asset(\'assets/img/logo-icon2.png\') }}',
    'https://rethink.terrawatt.co.in/img/wallet-animation.gif' => '{{ asset(\'assets/img/wallet-animation.gif\') }}',
    
    // External links to replace with route() helpers
    'https://play.google.com/store/apps/details?id=com.google.android.apps.authenticator2&hl=en' => '{{ route(\'user.support\') }}',
    'https://t.me/webdeveloper_sun' => '{{ route(\'user.support\') }}',
    'https://www.facebook.com/sharer/sharer.php?u=' => '{{ route(\'blog.details\', $blog->id) }}',
    'https://twitter.com/intent/tweet?text=my share text&url=' => '{{ route(\'blog.details\', $blog->id) }}',
    'https://pinterest.com/pin/create/bookmarklet/?media=' => '{{ route(\'blog.details\', $blog->id) }}',
    'http://www.linkedin.com/shareArticle?mini=true&url=' => '{{ route(\'blog.details\', $blog->id) }}',
    'https://www.ip2location.com/' => '{{ route(\'admin.report.login.history\') }}',
    'https://www.youtube.com/embed/' => '{{ asset(\'assets/pub/www.youtube.com/embed/\') }}',
    'https://viserlab.com/support' => '{{ route(\'admin.system.support\') }}',
];

foreach ($files as $file) {
    if (file_exists($file)) {
        $content = file_get_contents($file);
        $originalContent = $content;
        
        foreach ($replacements as $search => $replace) {
            $content = str_replace($search, $replace, $content);
        }
        
        if ($content !== $originalContent) {
            file_put_contents($file, $content);
            echo "Updated: $file\n";
        }
    } else {
        echo "File not found: $file\n";
    }
}

echo "URL fixing complete!\n";