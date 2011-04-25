<?PHP

class OpenAttributeWidget extends WP_Widget {

     function OpenAttributeWidget() {
       
        $widgetSettings     = array (
                                    'classname'     => 'OpenAttribute Widget',
                                    'description'   => 'Display a a license for your blog post or entire site in a widget'
                                    );

        $this->WP_Widget('openattribute_widget', 'OpenAttribute Widget', $widgetSettings, '');
       
     }

     function widget($args, $instance){
     
     	if($instance['openattribute_link']){
       
       		global $wp_query;
	
			if(is_single()){

				if(get_option('openattribute_widgetset')==1){
		
					$disable = get_post_meta($wp_query->posts[0]->ID, 'disable_license');
				
					if($disable[0]=="off"||$disable[0]==""){
					
						$display = true;
				
						if(get_option('openattribute_blogoverride')==1){
						
							$content = $wp_query->posts[0]->post_content;
						
							$author = explode("oaauthor",$content);
							$title = explode("oatitle",$content);
							$oashorthand = explode("oashorthand",$content);	
							
							if(count($author)!=1){
							
								$display = false;
							
							}
							
							if(count($title)!=1){
							
								$display = false;
							
							}
							
							if(count($oashorthand)!=1){
							
								$display = false;
							
							}
							
						}
							
						if($display){				
												
							if(is_single()){
					    		
					    		echo "<a onclick=\"attribute_button(event)\" style=\"cursor:hand; cursor:pointer\"><img src=\"" . WP_PLUGIN_URL . "/" . str_replace(basename( __FILE__),'',plugin_basename(__FILE__)) . "attrib_button.png\" />Attribute this resource</a>";
					    	
					    	}
					    	
					   }
					}
				}
				
			}
			
		}
       
     }

     public function update($new_instance, $old_instance) {
     
     	print_r($new_instance);
     
        $instance = $old_instance;

        $instance['openattribute_link'] = strip_tags($new_instance['openattribute_link']);
        
        return $instance;
        
     }

     function form($instance) {
       	
       	?><label>Tick this box if you wish the "Attribute this resource" link to appear in this widget</label>
       	  <input type="checkbox" name="<?PHP echo $this->get_field_name('openattribute_link'); ?>"<?PHP
       	
       		if($instance['openattribute_link']==true){
       		
       			echo " checked />";
       		
       		}else{
       		
       			echo " />";
       		
       		}
       	 
       	
     }
     
}

?>