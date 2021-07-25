<?php

class BestPagination
{
  public function __construct()
  {
    add_shortcode('do_pagination', [$this, 'view']);
    add_action('wp_ajax_do_pagination', [$this, 'ajax']);
    add_action('wp_ajax_outer_pagination', [$this, 'ajax']);
  }

  public function view()
  {
    $current_page = !empty($_GET['shortcode_page']) ? absint($_GET['shortcode_page']) : 0;
    $current_page = max(1, $current_page);

    return '<div>' . $this->content($current_page) . '</div>';
  }

  private function content($page)
  {

    $query = new WP_Query([
      'post_type' => 'mentor',
      'tax_query' => [
        'relation' => 'AND',
        [
          'taxonomy' => 'wordpress',
          'term' => 'skill'
        ],
        [
          'taxonomy' => 'wpforms',
          'term' => 'company'
        ],
      ],
      'meta_query' => [
        [
          'key' => 'micro',
          'value' => 'new',
        ]
      ],
      'orderby' => 'title',
      'order' => 'ASC',
      'posts_per_page' => 1,
      'paged' => $page,
    ]);

    ob_start();

    if ($query->have_posts()) {
      while ($query->have_posts()) {
        $query->the_post();
      }
      wp_reset_postdata();
    }
    echo $query->posts[0]->post_title;
    echo '<br><br>';
    echo paginate_links(
      [
        'current' => $page,
        'total' => $query->max_num_pages,
        'format' => '?shortcode_page=%#%',
      ]
    );

    return ob_get_clean();
  }

  public function ajax()
  {
    check_ajax_referer('text-nonce-text');
    $page = filter_input(INPUT_POST, 'page', FILTER_VALIDATE_INT);
    $page = max(1, $page);

    wp_send_json_success(
      $this->content($page)
    );
  }
}

new BestPagination();
