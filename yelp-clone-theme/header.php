<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
    <meta charset="<?php bloginfo('charset'); ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php wp_title('|', true, 'right'); ?><?php bloginfo('name'); ?></title>
    <?php wp_head(); ?>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body <?php body_class(); ?>>
    <?php wp_body_open(); ?>

    <!-- Top Bar -->
    <div class="bg-red-700 text-white py-2">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center text-sm">
                <div class="flex items-center space-x-4">
                    <a href="tel:1234567890" class="hover:text-gray-200">
                        <i class="fas fa-phone mr-2"></i>123-456-7890
                    </a>
                    <a href="mailto:info@example.com" class="hover:text-gray-200">
                        <i class="fas fa-envelope mr-2"></i>info@example.com
                    </a>
                </div>
                <div class="flex items-center space-x-4">
                    <?php if (is_user_logged_in()) : ?>
                        <a href="<?php echo esc_url(home_url('/my-account')); ?>" class="hover:text-gray-200">
                            <i class="fas fa-user mr-2"></i>My Account
                        </a>
                        <a href="<?php echo wp_logout_url(home_url()); ?>" class="hover:text-gray-200">
                            <i class="fas fa-sign-out-alt mr-2"></i>Logout
                        </a>
                    <?php else : ?>
                        <a href="<?php echo wp_login_url(); ?>" class="hover:text-gray-200">
                            <i class="fas fa-sign-in-alt mr-2"></i>Login
                        </a>
                        <a href="<?php echo wp_registration_url(); ?>" class="hover:text-gray-200">
                            <i class="fas fa-user-plus mr-2"></i>Register
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
