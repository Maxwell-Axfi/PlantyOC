<?php

$titleHTML = '';

/**
 * @var \WP_Post $result
 */

if ( $showTitle ) {
    $ebpg_title = wp_kses($result->post_title, 'post');
    if (!empty($titleLength)) {
        $ebpg_title = $block_object->truncate($ebpg_title, $titleLength);
    }

    $title_link_classes = $block_object->get_name() == 'post-grid' ? 'ebpg-grid-post-link' : 'ebpg-carousel-post-link';

    $titleHTML .= sprintf(
        '<header class="ebpg-entry-header">
            <class="ebpg-entry-title">
                %1$s
            </>
        </header>',
        $ebpg_title
    );
}

return $titleHTML;
