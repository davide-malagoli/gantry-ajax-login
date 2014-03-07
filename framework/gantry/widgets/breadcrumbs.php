<?php
/**
 * @version   4.1.1 January 6, 2014
 * @author    RocketTheme http://www.rockettheme.com
 * @copyright Copyright (C) 2007 - 2014 RocketTheme, LLC
 * @license   http://www.gnu.org/licenses/gpl-2.0.html GNU/GPLv2 only
 */

defined('GANTRY_VERSION') or die();

gantry_import('core.gantrywidget');

add_action('widgets_init', array("GantryWidgetBreadcrumbs","init"));

class GantryWidgetBreadcrumbs extends GantryWidget {
    var $short_name = 'breadcrumbs';
    var $wp_name = 'gantry_breakcrumbs';
    var $long_name = 'Gantry Breadcrumbs';
    var $description = 'Gantry Breadcrumbs Widget';
    var $css_classname = 'widget_gantry_breadcrumbs';
    var $width = 200;
    var $height = 400;

    static function init() {
        register_widget("GantryWidgetBreadcrumbs");
    }

    function render($args, $instance){
        global $gantry, $post;
	    ob_start();
	    
	    ?>
	    
	    <div class="breadcrumbs">

	    	<?php if ($instance['prefix'] != '') echo '<span class="showHere">' . $instance['prefix'] . '</span>'; ?>
	    
		    <a href="<?php echo home_url(); ?>" class="pathway"><?php _re('Home'); ?></a>
		    
		    <?php if ((is_page() || is_single()) && !is_front_page() && !is_home()) : ?>
																		
				<?php
				
				echo '<img alt="" src="'.get_template_directory_uri().'/images/arrow.png" /></span>';
				
				$parent_id  = $post->post_parent;
				$breadcrumbs = array();
				while ($parent_id) {
					$page = get_page($parent_id);
					$breadcrumbs[] = '<a href="'.get_permalink($page->ID).'" class="pathway">'.get_the_title($page->ID).'</a>';
					$parent_id  = $page->post_parent;
				}
				$breadcrumbs = array_reverse($breadcrumbs);
				foreach ($breadcrumbs as $crumb) echo $crumb.'<img alt="" src="'.get_template_directory_uri().'/images/arrow.png" /></span>';
				
				if(is_single() && intval($instance['category'])===1) :
					$category = get_the_category();
					if(!empty($category)) :
						echo '<a class="pathway" href="'.get_category_link($category[0]->cat_ID).'">'.$category[0]->cat_name.'</a><img alt="" src="'.get_template_directory_uri().'/images/arrow.png" /></span>';
					endif;
				endif;
				
				?>
				
				<span class="no-link"><?php the_title(); ?></span>
			
			<?php endif; ?>
		
		</div>
		
		<?php
		
		echo ob_get_clean();
	    
	}
}