=== Embed ChatGPT OpenAI ===
Tags: chatgpt, chat, openai, ai, chatting
Tested up to: 6.6.2
Requires PHP: 8.1.0
Stable tag: 1.1
License: GPLv2 or later
ChatGPT OpenAI using shortcode.

== Description ==

Embed ChatGPT OpenAI plugin allows you to embed chatbot in website with Artificial Intelligence, which have answers to all the questions you have in your mind. 

Current version is based on ChatGPT OpenAI gpt-3.5-turbo-instruct. 

Major features of this plugin include:

* Chat with ChatGPT3 OpenAI. 

== Installation ==

* Upload the ChatGPT OpenAI plugin to the `/wp-content/plugins/` directory
* Activate the ChatGPT OpenAI plugin through the 'Plugins' menu in WordPress
* You can also install it directly through WordPress plugins directory
* Signup here: https://platform.openai.com/account/api-keys and get your API secret.
* Once plugin installed and activated successfully, you can enter Secret Key from WordPress menu 'ChatGPT OpenAI'. 
* After that you can use shortcode [shortcode-chatgpt-openai] to run it anywhere on your website. 

== Frequently Asked Questions ==

= What is minimum PHP version to run this plugin? =
* Minimum PHP version required is greater than or equal to 8.1.0. It can be updated in your hosting settings.
= How to get ChatGPT3 OpenAI API Secret key? = 
* You can get API secret key here: https://platform.openai.com/account/api-keys
= Is it free to use? =
* Once you create fresh API secret key, it is free to use for three months as mentioned on OpenAI website: https://help.openai.com/en/articles/4936830-what-happens-after-i-use-my-free-tokens-or-the-3-months-is-up-in-the-free-trial
= Can I run it on popup? =
* Yes you can use shortcode on a popup.
= What is shortcode to run chat bot? =
* Shortcode is [shortcode-chatgpt-openai]

== Changelog ==

= 1.0 =
* Initial release

= 1.1 =
* Fixed installation bug
* text-davinci-003 model depricated, upgraded to gpt-3.5-turbo-instruct
* Upgraded to display quota over or other error from ChatGPT AI
