<?php
namespace AMZNBS;

// ASIN API Wrapper
//
// This class enables fetching ASIN info from the API when not cached locally

if (!class_exists("\HeyPublisher\Base\API")) {
  require_once(SGW_PLUGIN_FULLPATH . '/include/classes/HeyPublisher/Base/API.class.php');
}

class ASIN extends \HeyPublisher\Base\API {

  public function __construct() {
    parent::__construct();
    $this->logger->debug("ASIN#__construct()");
    // TODO: to make this generic, the uoid and poid need to be dynamic
    // If HeyPublisher submission manager is installed, use those, else use plugin defaults
    // global $HEYPUB_LOGGER;
    // $this->logger = $HEYPUB_LOGGER;
    // $this->logger->debug("HeyPublisher::API loaded");
    // $this->initialize_api_url();
    // $this->initialize_oids();
  }

  public function fetch_asin($asin) {
    $path = sprintf('asins/%s',$asin);
    $result = $this->get($path);
    if ($result && key_exists('object',$result) && $result['object'] == 'asin' ) {
      $obj = array(
        'title' => $result['title'],
        'image' => $result['image']
      );
      return $obj;
    }
    return;
  }

}

// This class sets a global accessor
if (!isset($SGW_API)) {
  $SGW_API  = new \AMZNBS\ASIN();
}
?>
