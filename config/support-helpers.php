<?php

declare(strict_types=1);

return [

    /*
    |--------------------------------------------------------------------------
    | Image / storage helpers
    |--------------------------------------------------------------------------
    */

    'image' => [
        'disk' => env('SUPPORT_HELPERS_IMAGE_DISK', 'public'),

        /*
        | Base URL for defaultPlaceholder() and AssetImage() when no file exists.
        | Must end before the encoded label (same behaviour as placehold.co paths).
        */
        'placeholder_base' => env(
            'SUPPORT_HELPERS_PLACEHOLDER_BASE',
            'https://placehold.co/800x600/733E0A/FDC700?text=',
        ),

        /*
        | ui-avatars.com (or any URL prefix) + urlencode(name) when avatar file missing.
        */
        'avatar_placeholder_base' => env(
            'SUPPORT_HELPERS_AVATAR_PLACEHOLDER_BASE',
            'https://ui-avatars.com/api/?background=FDC700&color=733E0A&bold=true&name=',
        ),
    ],

    /*
    |--------------------------------------------------------------------------
    | CacheData() — extra seconds after “fresh” window for flexible stale TTL
    |--------------------------------------------------------------------------
    */

    'cache' => [
        'flexible_stale_extra_seconds' => (int) env('SUPPORT_HELPERS_CACHE_STALE_EXTRA', 300),
    ],

];
