<?php
/*
   Plugin Name: Dialogfeed
   Plugin URI: 
   Description: Allow to take the flow from your widget dialogfeed.
   Author: Dialog Solutions
   Version: 1.0
   Author URI: http://www.dialogfeed.com/en/
 */
//add_action('wp_loaded',	'df_load_css');
//add_action('init', 'dialogfeed_widget_multi_register');
function dialogfeed_widget_multi_register() {
	
	$prefix = 'name-dialog'; // $id prefix
	$name = __('dialogfeed');
	$widget_ops = array('classname' => 'dialogfeed_widget_multi', 'description' => __('This is an example of widget,which you can add many times'));
	$control_ops = array('width' => 200, 'height' => 200, 'id_base' => $prefix);
	
	$options = get_option('dialogfeed_widget_multi');
	
	if(isset($options[0])) unset($options[0]);
	
	if(!empty($options)){
		foreach(array_keys($options) as $widget_number){
			wp_register_sidebar_widget($prefix.'-'.$widget_number, $name, 'dialogfeed_widget_multi', $widget_ops, array( 'number' => $widget_number ));
			wp_register_widget_control($prefix.'-'.$widget_number, $name, 'dialogfeed_widget_multi_control', $control_ops, array( 'number' => $widget_number ));
		}
	} else{
		$options = array();
		$widget_number = 1;
		wp_register_sidebar_widget($prefix.'-'.$widget_number, $name, 'dialogfeed_widget_multi', $widget_ops, array( 'number' => $widget_number ));
		wp_register_widget_control($prefix.'-'.$widget_number, $name, 'dialogfeed_widget_multi_control', $control_ops, array( 'number' => $widget_number ));
	}
}

function dialogfeed_widget_multi($args, $vars = array()) {
	extract($args);
	$widget_number = (int)str_replace('name-dialogfeed-', '', @$widget_id);
	$options = get_option('dialogfeed_widget_multi');
	if(!empty($options[$widget_number])){
		$vars = $options[$widget_number];
	}
	// widget open tags
	echo $before_widget;

	// print title from admin 
	if(!empty($vars['title'])){
		echo $before_title . $vars['title'] . $after_title;
	} 

	// print content and widget end tags
	echo '<center>You can add this widget as many times as you want</center>';
	echo $after_widget;
}

function dialogfeed_widget_multi_control($args) {

	$prefix = 'name-dialog'; // $id prefix

	$options = get_option('dialogfeed_widget_multi');
	if(empty($options)) $options = array();
	if(isset($options[0])) unset($options[0]);

	// update options array
	if(!empty($_POST[$prefix]) && is_array($_POST)){
		foreach($_POST[$prefix] as $widget_number => $values){
			if(empty($values) && isset($options[$widget_number])) // user clicked cancel
				continue;

			if(!isset($options[$widget_number]) && $args['number'] == -1){
				$args['number'] = $widget_number;
				$options['last_number'] = $widget_number;
			}
			$options[$widget_number] = $values;
		}

		// update number
		if($args['number'] == -1 && !empty($options['last_number'])){
			$args['number'] = $options['last_number'];
		}

		// clear unused options and update options in DB. return actual options array
		$options = bf_smart_multiwidget_update($prefix, $options, $_POST[$prefix], $_POST['sidebar'], 'dialogfeed_widget_multi');
	}

	// $number - is dynamic number for multi widget, gived by WP
	// by default $number = -1 (if no widgets activated). In this case we should use %i% for inputs
	//   to allow WP generate number automatically
	$number = ($args['number'] == -1)? '%i%' : $args['number'];

	// now we can output control
	$opts = @$options[$number];

	$title = @$opts['title'];
	?>

		Title<br />
		<input type="text" name="<?php echo $prefix; ?>[<?php echo $number; ?>][title]" value="<?php echo $title; ?>" />
		<?php
}

// helper function can be defined in another plugin
if(!function_exists('bf_smart_multiwidget_update')){
	function bf_smart_multiwidget_update($id_prefix, $options, $post, $sidebar, $option_name = ''){
		global $wp_registered_widgets;
		static $updated = false;

		// get active sidebar
		$sidebars_widgets = wp_get_sidebars_widgets();
		if ( isset($sidebars_widgets[$sidebar]) )
			$this_sidebar =& $sidebars_widgets[$sidebar];
		else
			$this_sidebar = array();

		// search unused options
		foreach ( $this_sidebar as $_widget_id ) {
			if(preg_match('/'.$id_prefix.'-([0-9]+)/i', $_widget_id, $match)){
				$widget_number = $match[1];

				// $_POST['widget-id'] contain current widgets set for current sidebar
				// $this_sidebar is not updated yet, so we can determine which was deleted
				if(!in_array($match[0], $_POST['widget-id'])){
					unset($options[$widget_number]);
				}
			}
		}

		// update database
		if(!empty($option_name)){
			update_option($option_name, $options);
			$updated = true;
		}

		// return updated array
		return $options;
	}
}


//----------------------------------------------------------------
class dialogfeed_widget extends WP_Widget {


	/** constructor -- À renommer, mais garder la forme mon_widget_widget
	 *                 Doit porter le même nom que la class.
	 */
	function dialogfeed_widget() {
		parent::WP_Widget(false, $name = 'dialogfeed');
	}

	function dialogfeed_init(){

	}

	public static function get_news_feed($instance)
	{

		$name_widget  = apply_filters('widget_url',$instance['name_widget']);
		$url='http://users.dialogfeed.com/en/snippet/'. $name_widget.'.xml';
		if(function_exists('simplexml_load_file')){
			//simplexml available
			//$xml = file_get_contents($url);//içi ok
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$xml = curl_exec($ch);
			curl_close($ch);

			if ($xml === false) {//there is an error opening the file
				throw new Exception('Sorry, no Posts were found');
			}
			$news_feed= simplexml_load_string($xml);
			return $news_feed;

		}

		throw new Exception('Simple xml not activated');
	}
	public static function array_orderby()
	{
		$args = func_get_args();
		$data = array_shift($args);
		foreach ($args as $n => $field) {
			if (is_string($field)) {
				$tmp = array();
				foreach ($data as $key => $row)
					$tmp[$key] = $row[$field];
				$args[$n] = $tmp;
			}
		}
		$args[] = &$data;
		call_user_func_array('array_multisort', $args);
		return array_pop($args);
	}
	/** @see WP_Widget::widget -- Ne pas renommer */
	function widget($args, $instance) {    
		extract( $args );
		//$title  = apply_filters('widget_title', $instance['title']);
		//$text   = apply_filters('widget_text',$instance['text']);
		?>
			<?php //echo $before_widget; ?>
			<?php if(!empty($title))
			echo $before_title . $title . $after_title; ?>
			<?php  
			$cpt=0;
		try{
			$feed=dialogfeed_widget::get_news_feed($instance);
			$posts=$feed->children();
			$global=array();//
			$priorites=array();
			foreach ($posts->children() as $p){
				$uid=(string)$p->uid;//l'identifiant unique du poste dans dialogfeed
				$date=(string)$p->updated_at;
				$objDate=new DateTime($date);
				$timestamp=$objDate->getTimestamp();//pour faciliter le tri
				$author=(string)$p->author->name;
				$content=(string)$p->content->content_body;
				$source_name=(string)$p->source->name;
				$source_url=(string)$p->source->source_url;
				$picture_url=(string)$p->author->picture_url;
				//echo $picture_url;
				$picture_sorted=trim($picture_url);
				if (empty($picture_sorted)){
					$picture_url=plugins_url('/images/no_photo.jpg', __FILE__);
				}
				$profil_url=(string)$p->author->url;//l'url du profil de l'auteur
				$highlighted=(object)$p->highlighted;
				$highlighted=($highlighted == 'true')? 1: 0;
				$priorites[]=$highlighted;
				$global[]=array('highlighted'=> $highlighted,'date'=>$timestamp,'author'=>$author,'content'=>$content,'source_name'=>$source_name,'source_url'=>$source_url,'picture_url'=>$picture_url,'uid'=>$uid,'profile_url'=> $profil_url );

			}



			$sorted=dialogfeed_widget::array_orderby($global, 'highlighted', SORT_DESC,'date',SORT_DESC);//trie selon le highlighted puis la date par décroissance

			echo '<ul >';
			$cpt=0;
			$nbpost   = apply_filters('widget_nbpost',$instance['nbpost']);
			foreach ($sorted as $post){
				if ($cpt++ == $nbpost) break;
				dialogfeed_widget::print_post($post);
			}
			echo '</ul>';
			echo '</section>';
			//--------------------------------------------------------------
		}catch(Exception $e){
			echo $e->getMessage();
		}

		?>
			<?php echo $after_widget; ?>
			<?php
	}

	public static function handle_content($content,$onTwitter){
		$text=$content;
		/*
		 * Decode HTML Chars like &#039; to '
		 */
		$text = htmlspecialchars_decode( $text, ENT_QUOTES );


		if ($onTwitter){
			/*
			 * Turn Hashtags into HTML Links
			 */	
			$text = preg_replace( '/#([A-Za-z0-9\/\.]*)/', '<a style="text-decoration:none" href="http://twitter.com/search?q=$1">#$1</a>', $text );

			/*
			 * Turn Mentions into HTML Links
			 */
			$text = preg_replace( '/@([A-Za-z0-9_\/\.]*)/', '<a style="text-decoration:none" href="http://www.twitter.com/$1">@$1</a>', $text );
		}
		/*
		 * Linkify text URLs
		 */
		$text = make_clickable( $text );



		// short url if 25 caracters   <a href="..."> url  <a>

		$html=$text;
		$dom = new DOMDocument();
		$dom->loadHTML($html);
		$xpath = new DOMXpath($dom);
		//get all child url
		$path='//a';
		$links=$xpath->query($path);
		for ($i=0;$i<$links->length;$i++){
			$link=$links->item($i);
			$url=$link->nodeValue;
			if (strlen($url) >=25){
				//echo substr($url, 0, 15);
			}

		}






		/*
		 * Add target="_blank" to all links
		 */
		$text = links_add_target( $text, '_blank', array( 'a' ) );
		// $text = links_add_style( $text, 'text-decoration:none', array( 'a' ) );	
		return $text;
	}
	public static function print_post($post){//vertical-align:-100% pour la class avatar

		?> 
			<?php
			//$highlighted=($post['highlighted']== 1) ? ' *':''; 
			$highlighted='';
		$pathImage='/images/'.$post['source_name'].'_icon.png';
		$ontwitter=($post['source_name']=='twitter');
		?>
			<style type="text/css"> 
			a:link 
			{ 
				text-decoration:none; 
			} 
		</style>
			<li style="border-bottom: 1px solid rgba(0, 0, 0, 0.2);  list-style-type: none; ">
			<br/>
			<div style="float:left display: inline-block" >
			<a target="_blank" href="<?= $post['profile_url']  ?>" >
			<img width="35" height="35" style="margin: 0 6px 6px 0" class="avatar" src="<?= $post['picture_url'] ?> " alt=""/>
			</a>
			<span style="vertical-align:top">
			<a target="_blank" href="<?= $post['profile_url']  ?>" >
			<?= $post['author'].$highlighted ?> 
			</a>
			</span>
			</div>
			<div  class="post">
			<?= dialogfeed_widget::handle_content($post['content'],$ontwitter) ?>
			<br/>
			</div>

			<img  class="logo" src="<?= plugins_url($pathImage, __FILE__) ?>" alt="Picture"/> 
			<a style="text-align: right;float: right;text-decoration:none" href="<?=$post['source_url'] ?>" target="_blank"><?= date('d/m/Y G:i:s',$post['date']) ?>


			</a><br/>
			</li>

			<?php
	}
	/** @see WP_Widget::update -- Ne pas renommer */
	function update($new_instance, $old_instance) {
		$instance = $old_instance;
		$instance['nbpost'] = strip_tags($new_instance['nbpost']);
		$instance['name_widget'] = strip_tags($new_instance['name_widget']);
		// Check 'count' is numeric.
		if ( is_numeric( $instance['nbpost'] ) ) {

			// If 'nbpost' is negative reset to 10.
			if ( intval( $instance['nbpost'] )  <= 0 ) {
				$instance['nbpost'] = 10;
			}

			// Update 'count' using intval to remove decimals.
			$instance['nbpost'] = intval( $instance['nbpost'] );

		}else{
			$instance['nbpost'] = 10;
		}
		return $instance;
	}

	/** @see WP_Widget::form -- Ne pas renommer */
	function form($instance) {

		$nbPost = (!empty($instance['nbpost'])) ?  esc_attr($instance['nbpost']) : "";
		$name_widget = (!empty($instance['name_widget'])) ?  esc_attr($instance['name_widget']) : "";
		?>

			<p>
			<label for="<?php echo $this->get_field_id('nbpost'); ?>"><?php _e('Number of posts'); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('nbpost'); ?>" name="<?php echo $this->get_field_name('nbpost'); ?>" type="text" value="<?php echo $nbPost; ?>" />
			</p>

			<p>
			<label for="<?php echo $this->get_field_id('name_widget'); ?>"><?php _e('Name your widget'); ?>:</label>
			<input class="widefat" id="<?php echo $this->get_field_id('name_widget'); ?>" name="<?php echo $this->get_field_name('name_widget'); ?>" type="text" value="<?php echo $name_widget; ?>" />
			</p>



			<?php
	}

}
add_action('widgets_init', create_function('', 'return register_widget("dialogfeed_widget");'));

?>
