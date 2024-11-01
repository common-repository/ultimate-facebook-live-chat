<?php

/**

 * @package ultimate-facebook-live-chat

*/

/*
Plugin Name: Ultimate Facebook Live Chat
Plugin URI: http://www.sparxstudios.com
Description: Ultimate Facebook Live Chat - Facebook Chat Messenger.
Version: 1.0
Author: Sparx Studios
Author URI: http://www.sparxstudios.com
*/

class UltimatFacebookChat{

    public $options;

    public function __construct() {

        $this->options = get_option('ultimate_fb_chat_plugin_options');

        $this->sw_twitter_slider_register_settings_and_fields();

    }

    public static function add_twitter_slider_tools_options_page(){

        add_menu_page('Ultimate Facebook Live Chat', 'Ultimate Facebook Live Chat ', 'administrator', __FILE__, array('UltimatFacebookChat','ultimate_fb_chat'),'dashicons-facebook');

    }

    public static function ultimate_fb_chat(){

?>

<div class="wrap">

    <?php screen_icon(); ?>

    <h2>Ultimate Faacebook Live Chat Configuration</h2>

    <form method="post" action="options.php" enctype="multipart/form-data">

        <?php settings_fields('ultimate_fb_chat_plugin_options'); ?>

        <?php do_settings_sections(__FILE__); ?>

        <p class="submit">

            <input name="submit" id="submit" type="submit" class="button-primary" value="Save Changes"/>

        </p>

    </form>

</div>

<?php



}



    public function sw_twitter_slider_register_settings_and_fields(){

        register_setting('ultimate_fb_chat_plugin_options', 'ultimate_fb_chat_plugin_options',array($this,'ultimat_fb_validate_settings'));

        add_settings_section('ultimate_fb_main_section', 'Settings', array($this,'ultimate_fb_main_section_cb'), __FILE__);



        //Start Creating Fields and Options

        //pageURL

        add_settings_field('pageURL', 'Facebook Profile Name', array($this,'pageURL_settings'), __FILE__,'ultimate_fb_main_section');

        //chatTitle

        add_settings_field('chatTitle', 'Chat Box Title', array($this,'chatTitle_settings'), __FILE__,'ultimate_fb_main_section');

         //boxbg

        add_settings_field('boxbg', 'Chat Box Background ', array($this,'boxbg_settings'), __FILE__,'ultimate_fb_main_section');

        //bottom_postion 

        add_settings_field('bottom_position', 'Bottom Position', array($this,'bottom_position_settings'),__FILE__,'ultimate_fb_main_section');

        //hide_cover options

        add_settings_field('hide_cover', 'Hide Cover Photo', array($this,'hide_cover_settings'),__FILE__,'ultimate_fb_main_section');

        //small_header options

        add_settings_field('small_header', 'Small Header', array($this,'small_header_settings'),__FILE__,'ultimate_fb_main_section');



    }

    public function ultimat_fb_validate_settings($plugin_options){

        return($plugin_options);

    }



    public function ultimate_fb_main_section_cb(){

        //optional

    }



     //pageURL_settings

    public function pageURL_settings() {

        if(empty($this->options['pageURL'])) $this->options['pageURL'] = "clownfishweb";

        echo "<input name='ultimate_fb_chat_plugin_options[pageURL]' type='text' value='{$this->options['pageURL']}' />";

    }



    //chatTitle_settings

    public function chatTitle_settings() {

        if(empty($this->options['chatTitle'])) $this->options['chatTitle'] = "Facebook Chat Box";

        echo "<input name='ultimate_fb_chat_plugin_options[chatTitle]' type='text' value='{$this->options['chatTitle']}' />";

    }



    //boxbg_settings

    public function boxbg_settings() {

        if(empty($this->options['boxbg'])) $this->options['boxbg'] = "#2196f3";

        echo "<input name='ultimate_fb_chat_plugin_options[boxbg]' type='color' value='{$this->options['boxbg']}' />";

    }



    //bottom_position

    public function bottom_position_settings() {

        if(empty($this->options['bottom_position'])) $this->options['bottom_position'] = "20";

        echo "<input name='ultimate_fb_chat_plugin_options[bottom_position]' type='text' value='{$this->options['bottom_position']}' />";

    }

    

    //hide_cover

    public function hide_cover_settings(){

        if(empty($this->options['hide_cover'])) $this->options['hide_cover'] = "false";

        $items = array('false'=>'No','true'=>'Yes',);

        echo "<select name='ultimate_fb_chat_plugin_options[hide_cover]'>";

        foreach($items as $key => $item){

            $selected = ($this->options['hide_cover'] === $item) ? 'selected = "selected"' : '';

            echo "<option value='$item' $selected>$item</option>";

        }

        echo "</select>";

    }



    //small_header

    public function small_header_settings(){

        if(empty($this->options['small_header'])) $this->options['small_header'] = "false";

        $items = array('false'=>'No','true'=>'Yes');

        echo "<select name='ultimate_fb_chat_plugin_options[small_header]'>";

        foreach($items as $key => $item){

            $selected = ($this->options['small_header'] === $item) ? 'selected = "selected"' : '';

            echo "<option value='$item' $selected>$item</option>";

        }

        echo "</select>";

    }

    

    //display_image

    public function display_image_settings(){

        if(empty($this->options['display_image'])) $this->options['display_image'] = "no";

        $items = array('no'=>'No','yes'=>'Yes');

        echo "<select name='ultimate_fb_chat_plugin_options[display_image]'>";

        foreach($items as $key => $item){

            $selected = ($this->options['display_image'] === $item) ? 'selected = "selected"' : '';

            echo "<option value='$item' $selected>$item</option>";

        }

        echo "</select>";

    }







   public function image_uploads_settings(){

    if(empty($this->options['image_uploads'])) $this->options['image_uploads'] = "";

       echo "<input id='image_btn_new'  type='file' />";

       echo '<input type="text" value="" name="ultimate_fb_chat_plugin_options[image_uploads]" id="hide"/>';

       ?>

       <script type="text/javascript">

jQuery(document).ready(function($){

    $('#image_btn_new').click(function(e) {

        e.preventDefault();

        var image = wp.media({ 

            title: 'Upload Image',

            // mutiple: true if you want to upload multiple files at once

            multiple: false

        }).open()

        .on('select', function(e){


            var uploaded_image = image.state().get('selection').first();

            console.log(uploaded_image);

            var image_url = uploaded_image.toJSON().url;

            $('#hide').val(image_url);

        });

    });

});

</script>

   <?php  }


}



add_action('admin_menu', 'ultimate_fb_chat_trigger_options_function');



function ultimate_fb_chat_trigger_options_function(){

    UltimatFacebookChat::add_twitter_slider_tools_options_page();

}



add_action('admin_init','ultimate_fb_chat_trigger_create_object');

function ultimate_fb_chat_trigger_create_object(){

    new UltimatFacebookChat();

}



add_action('wp_footer','ultimate_fb_chat_add_content_in_footer');

function ultimate_fb_chat_add_content_in_footer(){

    $o = get_option('ultimate_fb_chat_plugin_options');

    extract($o);

$print_twitter = '';

$print_twitter .= '';


?>


<script type="text/javascript">
   jQuery(document).ready(function(){
      jQuery(".box-chat").hide();
      jQuery("#chat-box").click(function(){
        jQuery(".box-chat").fadeIn("slow");
      });

      jQuery(".cross").click(function(){
        jQuery(".box-chat").hide("slow");
        jQuery("#chat-box").show();
      });
    });

</script>



<div id="fb-root"></div>

<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.8&appId=262562957268319";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>



<div class="fb-message">
    <div class="box-chat">
        <div class="cross">
        <img src="<?php echo esc_url( plugins_url( 'assets/close-blue.png', __FILE__ ) );?>"/>
        </div>
       <div class="fb-page" data-href="https://www.facebook.com/<?php echo $pageURL;?>/" 
        data-tabs="messages" data-width="280" data-height="400" data-small-header="<?php echo $small_header;?>" 
        data-adapt-container-width="true" data-hide-cover="<?php echo $hide_cover;?>" data-show-facepile="true">
      </div>
	  <div class="support" style="font-size: 9px;text-align: right;"><a href="http://hayesroofing.com/" target="_blank" style="color: #808080;" title="click here">Edmonds Roofer</a></div>
    </div>
    <div id="chat-box"><?php echo $chatTitle;?></div>
</div>

<style type="text/css">
   div#chat-box {
    bottom: <?php echo $bottom_position;?>px;
     z-index: 99;
    background: <?php echo $boxbg;?>
}

div#chat-box-img {
   bottom: <?php echo $bottom_position;?>px;
}
</style>

<?php

}

add_action( 'wp_enqueue_scripts', 'register_ultimate_fb_chat_styles' );
 function register_ultimate_fb_chat_styles() {
    wp_register_style( 'register_ultimate_fb_chat_styles', plugins_url( 'assets/style.css' , __FILE__ ) );
    wp_enqueue_style( 'register_ultimate_fb_chat_styles' );
 }

// UPLOAD ENGINE

function load_wp_media_files() {
    wp_enqueue_media();

}

add_action( 'admin_enqueue_scripts', 'load_wp_media_files' );

 $ultimate_fb_chat_default_values = array(


     'pageURL' => 'facebook',

     'chatTitle' => 'Live Chat With us Now',

     'boxbg' => '#2196F3',

     'bottom_position' => 7,

     'hide_cover'=>'false',

     'small_header'=>'false',

     'display_image'=>'no'

 );
 add_option('ultimate_fb_chat_plugin_options', $ultimate_fb_chat_default_values);