<?php
namespace PCHC\ListPages;
use Gantry;
use Timber;

function query_pages( $a = array(
    'orderby' =>  'menu_order',
    'order' =>    'DESC'
  )
) {
  global $post;
  $gantry = Gantry\Framework\Gantry::instance();
  $theme = $gantry['theme'];

  $context = Timber::get_context();

  $args = array (
    'post_parent'            => $post->ID,
    'post_type'              => array( 'page' ),
    'post_status'            => array( 'publish' ),
    'order'                  => $a['order'],
    'orderby'                => $a['orderby'],
  );

  $context['childpages'] = Timber::get_posts($args);

  return $context;
}

function shortcode__list_child_pages( $atts ) {
  $a = shortcode_atts(array(
    'orderby' => 'menu_order',
    'order' => 'DESC'
  ), $atts );

  global $post;

  if( is_page() && $post->post_parent ){
    //
  } else {
    $context = query_pages( $a );

    $templates = ['listpages-shortcode.html.twig'];

    Timber::render($templates, $context);
  }

}
add_shortcode('pchc_childpages', __NAMESPACE__ . '\\shortcode__list_child_pages');


add_action( 'widgets_init', function(){
  register_widget( __NAMESPACE__ . '\\List_Child_Pages_Widget' );
});
class List_Child_Pages_Widget extends \WP_Widget {

  /**
   * Sets up the widgets name etc
   */
  public function __construct() {
    $widget_ops = array(
      'classname' => 'list_child_pages_widget',
      'description' => '',
    );

    parent::__construct( 'list_child_pages_widget', 'List Child Pages Widget', $widget_ops );
  }


  /**
   * Outputs the content of the widget
   *
   * @param array $args
   * @param array $instance
   */
  public function widget( $args, $instance ) {
    // outputs the content of the widget
    $context = query_pages();
    $context['widget']['args'] = $args;
    $context['widget']['instance'] = $instance;
    $templates = ['listpages-widget.html.twig'];
    Timber::render($templates, $context);
  }


  /**
   * Outputs the options form on admin
   *
   * @param array $instance The widget options
   */
  public function form( $instance ) {
    // outputs the options form on admin
    $title = ! empty( $instance['title'] ) ? $instance['title'] : __( 'New title', 'text_domain' );
    ?>
      <p>
      <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>
      <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>">
      </p>
    <?php
  }


  /**
   * Processing widget options on save
   *
   * @param array $new_instance The new options
   * @param array $old_instance The previous options
   */
  public function update( $new_instance, $old_instance ) {
    // processes widget options to be saved
    foreach( $new_instance as $key => $value )
    {
      $updated_instance[$key] = sanitize_text_field($value);
    }

    return $updated_instance;
  }
}
