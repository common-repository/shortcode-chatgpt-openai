<?php
/*******************************
 * Plugin Name:  Embed ChatGPT OpenAI
 * Description:  Chat with AI
 * Version:      1.1
 * Author:       slidessale001
 * License:      GPL2 or later
 *******************************/
 
function eco_display_chat(){
    require("token.php");
    
    if(isset($_POST['question']) && !empty($_POST['question'])){
        $ask = sanitize_text_field($_POST['question']);
    }
    else{
        $ask = "how are you?";
    }

    $postfields = "{\"prompt\":\"$ask\",\"max_tokens\":1024,\"n\":1,\"stop\":null,\"temperature\":0.5}";    
    
    $args = array(
    	'returntransfer'  => true,
    	'encoding' => '',
    	'maxredirs' => '100',
    	'timeout' => '600',
    	'followlocation'    => true,
        'body' => $postfields,
        'headers' => array(
            'Content-Type' => 'application/json; charset=utf-8',
            'Authorization' => 'Bearer ' . $token,
          ),
    );
    
    //$response = wp_remote_post( 'https://api.openai.com/v1/engines/text-davinci-003/completions', $args ); //deprecated
    $response = wp_remote_post( 'https://api.openai.com/v1/engines/gpt-3.5-turbo-instruct/completions', $args );

    $array =  (array) $response;
    $data = $array['http_response']->get_response_object()->body;
    $data = json_decode($data);
    $data = (array) $data;
    
    if(isset($data['error']) && !empty($data['error'])){
        echo "<br><br><center><b>";
        json_decode(json_encode($data['error']), true);
        foreach ($data['error'] as $value) {
            echo $value;
        }
        echo '</b></center><br>';
    } else {
    
        $data = $data['choices'][0];
        $data = (array) $data;
        $data = $data['text'];
        //or get data here
        $response = json_decode($response['body'], true);
        $data = $response["choices"][0]["text"];
    
        return '<div id="chat_box">
            <form action="" method="POST">
                Ask me anything:    <input type="text" name="question"> <br>
                <input type="submit" value="Ask">
            </form></br></br>
            Question: '.$ask.'</br></br>Answer: '.$data.'</div>';
    }
}
add_shortcode('shortcode-chatgpt-openai', 'eco_display_chat');


// व्यवस्थापक मेनू जोड़ने के लिए हुक
add_action('admin_menu', 'eco_openai_admin_menu');

// ऊपर हुक के लिए कार्रवाई समारोह
if ( !function_exists( 'eco_openai_admin_menu' ) ) {
	function eco_openai_admin_menu() {
		// सेटिंग्स के तहत एक नया मेनू जोड़ें
		add_menu_page(__('eco_openai_chat', 'chatgpt-openai'), __('ChatGPT OpenAI', 'chatgpt-openai'), 'manage_options', 'eco_openai', 'eco_openai');
	}
}

// प्लगइन डैश बोर्ड पृष्ठ
function eco_openai() {
	?>
	
    <form method="post">
        <?php
        settings_fields("header_section");
        do_settings_sections("manage_options"); 
        wp_nonce_field('eco_openai_action', 'eco_openai_field');
        submit_button();
        
        if(isset($_POST['feedback']) && !empty($_POST['feedback'])){
            $feedback = sanitize_text_field($_POST['feedback']);
            $headers = '';
            wp_mail("slidessale001@gmail.com","ChatGTP OpenAI plugin feedback",$feedback, $headers);
        }
		?>
		<h2>Help us improve:<br/>
		<form action="" method="post">
		<textarea rows="5" cols="70" name="feedback" placeholder="If you want us to contact back, also mention your email.."></textarea><br/><br/><input type="submit"value="Submit Feedback"></h2>
		</form>
        <br/>
        <br/><br/><br/>
    </form>
    
    <?php

	//सबमिट प्रपत्र प्रारंभ 
    if (!isset($_POST['eco_openai_field']) || !wp_verify_nonce($_POST['eco_openai_field'], 'eco_openai_action')) {
        echo "<div style='float:left';></div>";
	exit;
    } else {
        $number = sanitize_text_field($_POST['number']);
        update_option('eco_openai_db', $number);
        echo "<div style='float:left; font-weight:bold;';>Values submitted successfully!!!</div>";
    }
}

//फ़िल्टर
add_filter('upload_size_limit', 'eco_openai_api_upload');
function eco_openai_api_upload() {
    return get_option('eco_openai_db');
}

//अनुभाग का नाम, प्रदर्शन नाम, खंड का वर्णन मुद्रित करने के लिए कॉलबैक, पृष्ठ किस अनुभाग में अनुलग्न है ।
function eco_chat_max_display_options() {
    add_settings_section("header_section", "ChatGPT OpenAI Settings", "eco_chat_max_display_header_options_content", "manage_options");
    add_settings_field("header_logo", "ChatGPT OpenAI Secret key:", "eco_chat_max_display_logo_form_element", "manage_options", "header_section");
    register_setting("header_section", "number");
}

function eco_chat_max_display_header_options_content() {
    echo 'Get your ChatGTP OpenAI Secret key here: <a href="https://platform.openai.com/account/api-keys" target="_blank">API KEYS</a><br/>Read ChatGTP limitations: <a href="https://help.openai.com/en/articles/4936830-what-happens-after-i-use-my-free-tokens-or-the-3-months-is-up-in-the-free-trial" target="_blank">HERE</a>
        <br/>Shortcode: [shortcode-chatgpt-openai]';
}

function eco_chat_max_display_logo_form_element() {
     printf(
            '<input type="text" id="number" name="number" value="%s" />',
            (null!==get_option('eco_openai_db') ) ? esc_attr( get_option('eco_openai_db')) : ''
        );
}

add_action("admin_init", "eco_chat_max_display_options");

?>