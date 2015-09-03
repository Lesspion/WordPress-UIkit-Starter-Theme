<?php

/**
 * Provides some helpers to use within the views.
 */
class ThemeHelpers
{

    /**
     * Display an optional post thumbnail.
     *
     * Wraps the post thumbnail in an anchor element on index
     * views, or a div element when on single views.
     */
    public function postThumbnail()
    {
        if (post_password_required() || is_attachment() || !has_post_thumbnail()) {
            return;
        }

        if (is_singular()) {
            the_post_thumbnail();
        } else {
            echo '<a href="<?php the_permalink(); ?>">';
            the_post_thumbnail();
            echo '</a>';
        }
    }

    /**
     * Gets the first image attached to the post.
     */
    public function getFirstPostImage($post_id)
    {
        $args = array(
            'post_type'      => 'attachment',
            'post_mime_type' => 'image/jpeg',
            'post_parent'    => $post_id,
            'numberposts'    => 1,
            'orderby'        => 'menu_order'
        );
        $attachments = get_posts($args);

        if ($attachments && is_array($attachments) && !empty($attachments)) {
            return $attachments[0];
        }
        else {
            return false;
        }
    }

    /**
     * Displays the pagination for the posts overview page (and search and archive)
     */
    public function getPostsPagination()
    {
        $pagination = paginate_links(array('type' => 'array', 'mid_size' => 3, 'prev_next' => false));

        if ($pagination == null) return;

        $returner = array();
        $returner[] = '<ul class="uk-pagination">';
        $returner[] = '<li class="uk-pagination-previous">' . get_previous_posts_link() . '</li>';

        for ($i = 0; $i < sizeof($pagination); $i++) {
            $returner[] = '<li class="uk-hidden-small">' . $pagination[$i] . '</li>';
        }

        $returner[] = '<li class="uk-pagination-next">' . get_next_posts_link() . '</li>';
        $returner[] = '</ul>';

        return implode('', $returner);
    }

} 