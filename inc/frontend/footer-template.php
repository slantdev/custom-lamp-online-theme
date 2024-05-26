<?php

remove_action('genesis_footer', 'genesis_do_footer');
add_filter('genesis_attr_site-header', 'slant_add_footer_class');

function slant_add_footer_class($attributes)
{
  //$attributes['class'] .= '';
  return $attributes;
}

add_action('genesis_footer', 'slant_do_footer');

function slant_do_footer()
{ ?>

  <!-- widget area -->
  <div class="footer-widget-area container py-5">
    <div class="footer-content row">
      <div class="footer-widget col-md-3">
        <?php genesis_widget_area('footer-content-01', array());  ?>
      </div>
      <div class="footer-widget col-md-4 pr-md-4">
        <?php genesis_widget_area('footer-content-02', array());  ?>
      </div>
      <div class="footer-widget col-md-5 pl-md-4">
        <div class="footer-menu-section row">
          <div class="footer-menu-section-widget col-4">
            <?php genesis_widget_area('footer-menu-01', array());  ?>
          </div>
          <div class="footer-menu-section-widget col-4">
            <?php genesis_widget_area('footer-menu-02', array());  ?>
          </div>
          <div class="footer-menu-section-widget col-4">
            <?php genesis_widget_area('footer-menu-03', array());  ?>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- copyright section -->
  <div class="footer-copyright-area py-3">
    <div class="footer-copyright-content container" style="text-align: center;">
      Copyright © <?php echo date("Y"); ?> NSW Nurses and Midwives’ Association. Authorised by S.Candish, General Secretary, NSW Nurses and Midwives’ Association, 50 O’Dea Avenue Waterloo NSW 2017 Australia.<br />Design and Development by <a href="https://slantagency.com.au/" target="_blank" style="color: white">Slant Agency</a>
    </div>
  </div>


<?php }

?>