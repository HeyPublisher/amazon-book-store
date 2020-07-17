<?php
/*
  Widget Class
  https://codex.wordpress.org/Widgets_API
*/
class SupportGreatWriters extends WP_Widget {
  var $seen = array();
  var $options = array();
  var $asins = array();
  var $asin_meta = array();
  var $logger = null;

	function __construct() {
    global $HEYPUB_LOGGER;
    $this->logger = $HEYPUB_LOGGER;
    $this->logger->debug("SupportGreatWriters");
		$control_ops = array( 'id_base' => 'sgw' );
		$widget_ops = array('description' => __('Easily sell Amazon books or other products in sidebar.','sgw'));
		$this->options = get_option(SGW_PLUGIN_OPTTIONS);
	  parent::__construct('sgw', __('Amazon Book Store','sgw'), $widget_ops,$control_ops );
	}

  // Get the amazon link for a passed-in ASIN and Associates ID
  // TODO: switch this to calling HeyPublisher.com server to get data, as the
  // secure URL for images can only be calculated using application key and secret
  function get_amazon_link($asin,$assoc,$country) {
    $url_map = array(
      'com'     => 'amazon.com',
      'co.uk'   => 'amazon.co.uk',
      'de'      => 'amazon.de',
      'fr'      => 'amazon.fr',
      'ca'      => 'amazon.ca',
      'it'      => 'amazon.it',
      'es'      => 'amazon.es'
    );

    if (!$asin) {
      // display default image
      $link = sprintf('<img src="%s" title="Product ASIN not defined">',SGW_DEFAULT_IMAGE);
    } else {
      if (isset($this->asin_meta[$asin]['image'])) {
        $image = $this->asin_meta[$asin]['image']; // secure URL image
        $title = $this->asin_meta[$asin]['title'];
      } else {
        $image = sprintf("http://ecx.images-amazon.com/images/P/%s.01._SCMZZZZZZZ_.jpg",$asin); // secure URL image
        $title = "Click for more Information";
      }

      $format = '<a title="%s" target=_blank href="https://www.%s/gp/product/%s?ie=UTF8&tag=%s&linkCode=as2&camp=1789&creative=9325&creativeASIN=%s"><img class="sgw_product_img" src="%s"></a><img src="https://www.assoc-%s/e/ir?t=%s&l=as2&o=1&a=%s" width="1" height="1" border="0" alt="" style="border:none !important; margin:0px !important;" />';
      $link = sprintf($format,$title,$url_map[$country],$asin,$assoc,$asin,$image,$url_map[$country],$assoc,$asin);
    }
    return $link;
  }

  // Split a comma-separated list of asins apart and return an array of POST or DEFAULT asins for display.
  private function shuffle_asin_list($list) {
    $this->logger->debug(sprintf("SupportGreatWriters#shuffle_asin_list()\n\t\$list = %s",print_r($list,1)));
    $asins = array();
    if ($list) {
  	  $array = explode(',',$list);
  	  shuffle($array);
      return $array;
    }
	  return $asins;
  }
  // load the ASINs into memory in way that makes it easy to pop them off later
  public function load_asins() {
	  global $post; // this is only available within the widget function, not within the constructor
    $list = '';
    $hash = array();
    if (!is_home()) {
      // look to see if we have a post id meta attribute
  	  $list = get_post_meta($post->ID,SGW_POST_META_KEY,true);
      $hash = get_post_meta($post->ID,SGW_POST_ASINDATA_KEY,false);
  	  $this->asins = array_merge($this->asins,$this->shuffle_asin_list($list));
      // $hash may not be populated or may not be an array
      if (is_array($hash)) {
        $this->asin_meta = $this->asin_meta = $hash;
        // $this->asin_meta = array_merge($this->asin_meta,$hash);
      }
      $this->logger->debug(sprintf("SupportGreatWriters#load_asins()\n\t\$asin_meta = %s",print_r($this->asin_meta,1)));
    }
    // concatenate the defaults onto the end
    $this->asins = array_merge($this->asins,$this->shuffle_asin_list($this->options['default']));
    // include the default hash of asin meta data
    // it may be that we don't have the default meta data - so test for that scenario
    $meta = $this->options['default_meta'];
    if (is_array($meta)) {
      $this->asin_meta = $this->asin_meta + $meta;
      // $this->asin_meta = array_merge($this->asin_meta,$meta);
    }
    // need to uniquify the array to prevent duplicates
    $this->asins = array_unique($this->asins);
  }
  // Get the next ASINs for display
  public function get_next_asin_set($count) {
    $asins = array();
    $diff = array_diff($this->asins,$this->seen);
    if (count($diff) >= $count) {
      for ($i = 0; $i < $count; $i++) {
        $next = array_shift($diff);
        $asins[] = $next;
        $this->seen[] = $next;
      }
    }
    return $asins;
  }

  // @see WP_Widget::widget
	function widget($args, $instance) {
	  $this->load_asins();
		// outputs the content of the widget
    extract($args);
    // widget level opts
    $title = apply_filters('widget_title', $instance['title']);
    $display_count = apply_filters('widget_display_count', $instance['display_count']);
    if (!$display_count) { $display_count = 1; }
    // system level opts
    $affiliate = $this->options['affiliate_id'];
    $country = $this->options['country_id'];
    if (!$affiliate) { $affiliate = 'sgw-1-2-2-20'; $country = 'us'; } // set a default so plugin doesn't stop working
    $asins = $this->get_next_asin_set($display_count);
    if ($asins) {
      // start the output
      echo $before_widget;
      if ( $title ) {
        echo $before_title . $title . $after_title;
      }
?>
<div class="textwidget">
<TABLE id="support_great_writers" style="margin:0px auto;">
    <tr>
<?php

    if ($display_count == 2) {
      printf('<td style="width:50%%;">%s</td><td style="width:50%%;">%s</td>',
        $this->get_amazon_link(@$asins[0],$affiliate,$country),$this->get_amazon_link(@$asins[1],$affiliate,$country));
    } else {
      printf('<td>%s</td>',$this->get_amazon_link(@$asins[0],$affiliate,$country));
    }
?>
</tr></table>
</div>
<?php
    echo $after_widget;
    } // end of test if count is greater than desired display
	}

  // @see WP_Widget::update
	function update($new_instance, $old_instance) {
	    return $new_instance;
	}

	// outputs the options form on admin
  // @see WP_Widget::form
	function form($instance) {
    // load the vars
    $title = esc_attr($instance['title']);
    $display_count = esc_attr($instance['display_count']);
    if (!$display_count) { $display_count = 1; }
?>
        <p>
          <label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?>
          <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label>
        </p>
        <p>
          <label for="<?php echo $this->get_field_id('display_count'); ?>"><?php _e('Display # of Products in Widget:'); ?>
          <select name="<?php echo $this->get_field_name('display_count'); ?>">
<?php
          for ($i=1;$i<=2;$i++) {
            $sel = '';
            if ($display_count==$i) { $sel = 'selected="selected"'; }
            printf("<option value='%s' %s>%s</option>",$i,$sel, $i);
          }
?>
          </select>
          </label>
        </p>

<?php

	}
} // end class
