<?php

use App\Models\Admin;

return [
    Admin::ADMIN_ROLE => [
        'admin_login', 'login', 'logout', 'dashboard', 'statistical', 'shipping.update_fee', 'order.confirm_order', 'apply_feeship_admin',

        'admin_order_search_modal', 'add_product_order', 'remove_product_admin_cart', 'update_quantity_order', 'category_product',

        'brand', 'product', 'post',

        'category_product.index', 'category_product.create', 'category_product.store', 'category_product.edit', 'category_product.show', 'category_product.update', 'category_product.destroy',
        'brand.index', 'brand.create', 'brand.store', 'brand.edit', 'brand.show', 'brand.update', 'brand.destroy',
        'product.index', 'product.create', 'product.store', 'product.edit', 'product.show', 'product.update', 'product.destroy',
        'post.index', 'post.create', 'post.store', 'post.edit', 'post.show', 'post.update', 'post.destroy',
        'category_post.index', 'category_post.create', 'category_post.store', 'category_post.edit', 'category_post.show', 'category_post.update', 'category_post.destroy',
        'user.index', 'user.create', 'user.store', 'user.edit', 'user.show', 'user.update', 'user.destroy',
        'coupon.index', 'coupon.create', 'coupon.store', 'coupon.edit', 'coupon.show', 'coupon.update', 'coupon.destroy',
        'admin.index', 'admin.create', 'admin.store', 'admin.edit', 'admin.show', 'admin.update', 'admin.destroy',
        'order.index', 'order.create', 'order.store', 'order.edit', 'order.show', 'order.update', 'order.destroy',
        'comment.index', 'comment.create', 'comment.store', 'comment.edit', 'comment.show', 'comment.update', 'comment.destroy',
        'tag.index', 'tag.create', 'tag.store', 'tag.edit', 'tag.show', 'tag.update', 'tag.destroy',
        'shipping.index', 'shipping.create', 'shipping.store', 'shipping.edit', 'shipping.show', 'shipping.update', 'shipping.destroy',
        'slide.index', 'slide.create', 'slide.store', 'slide.edit', 'slide.show', 'slide.update', 'slide.destroy',

        'ckeditor.upload', 'select_gallery', 'insert_gallery', 'update_name', 'delete_image', 'update_gallery'
    ],

    Admin::STAFF_ROLE => [
        'admin_login', 'login', 'logout',  'order.confirm_order', 'apply_feeship_admin',

        'admin_order_search_modal', 'add_product_order', 'remove_product_admin_cart', 'update_quantity_order',

        'comment.index', 'comment.create', 'comment.store', 'comment.edit', 'comment.show', 'comment.update', 'comment.destroy',

        'order.index', 'order.create', 'order.store', 'order.edit', 'order.show', 'order.update', 'order.destroy',

        'post.index', 'post.create', 'post.store', 'post.edit', 'post.show', 'post.update', 'post.destroy',
    ],
];
