<?php
/*
Plugin Name: Uncanny Automator Sample Integration
Plugin URI: https://automatorplugin.com/article-categories/developers/
Description: This is a basic example of how to add an integration, trigger, and action to Automator.
Author: Uncanny Automator
Version: 1.0
Author URI: https://www.automatorplugin.com
*/

/*
 * Notes:
 * =====
 *
 * Integration development consists of one or more sections.
 *
 * Section 1: Adding an integration
 *
 * - You need two hooks:
 *   1. add_action -> uncanny_automator_add_integration
 *      - @see SECTION 1 - PART A
 *   2. add_filter -> uncanny_automator_maybe_add_integration
 *      - @see SECTION 1 - PART B
 *
 * - If you are adding a trigger or action for an integration that already exists in Uncanny Automator Lite,
 *   you can reference the integration code inside the trigger or action and skip "Section 1"
 *
 * - If an integration already exists  with the same integration code you are trying to add, then your integration
 *   will be skipped. The Uncanny Automator Lite plugin has 1st priority to add integrations.
 *
 * - To view a list of integrations that have been registered, visit a recipe creation page in /wp-admin/, open the browser
 *   developer console (press F12), type in "UncannyAutomator.integrations" and press Enter.
 *
 * @see   Section 1 below for step by step instructions
 *
 * Section 2: Adding a trigger
 *
 * You need one hook:
 * - add_action -> uncanny_automator_add_integration_triggers_actions_tokens
 * @see   Section 2 below for step by step instructions
 *
 * Section 3: Adding an action
 *
 * You need one hook:
 * - add_action -> uncanny_automator_add_integration_triggers_actions_tokens
 * @see   Section 3 below for step by step instructions
 */

/*
 * SECTION 1 - Adding an integration
 * =========
 *
 * Let's add an integration for WooCommerce!
 */

/* SECTION 1 - PART A */
// Register the integration's name, icons, and code
add_action( 'uncanny_automator_add_integration', 'my_unique_add_integration_func' ); // Function names need to be unique

/**
 * Add integration data to Automator
 */
function my_unique_add_integration_func() {

	// Let’s grab the Automator global object which stores all integrations, triggers, actions, recipe data and internal functions.
	global $uncanny_automator;

	$uncanny_automator->register_integration(
		'WCX', // This is the integration code that uniquely identifies the plugin; the value should include uppercase letters only, be unique, and have a logical association with the plugin.
		array(
			// Official name of the plugin. Max 14 characters. Any character after the 14th will not display.
			// Ex. WooCommerce Sample will display as WooCommerce Sa...
			'name'        => 'WooCommerce Sample',
			/*
			 * View this article if you need help creating icons and logos in Photoshop
			 * @see  https://automatorplugin.com/knowledge-base/creating-icons-and-logos/
			 */
			// 16px by 16 px png with transparent background
			'icon_16'     => plugins_url( 'integration-woocommerce-icon-16.png', __FILE__ ),
			// 32px by 32 px png with transparent background
			'icon_32'     => plugins_url( 'integration-woocommerce-icon-32.png', __FILE__ ),
			// 64px by 64 px png with transparent background
			'icon_64'     => plugins_url( 'integration-woocommerce-icon-64.png', __FILE__ ),
			// 150px(max) by 62px(max) png with transparent background. Styling will try to compensate for smaller images.
			'logo'        => plugins_url( 'integration-woocommerce.png', __FILE__ ),
			// 300px(max) by 125px(max) png with transparent background. Styling will try to compensate for smaller images.
			'logo_retina' => plugins_url( 'integration-woocommerce@2x.png', __FILE__ ),
		)
	);
}

/* SECTION 1 - PART B */
// This filter adds your integration to Automator
add_filter( 'uncanny_automator_maybe_add_integration', 'maybe_add_integration', 11, 2 );

/**
 * Check if the plugin we are adding an integration for is active based on integration code
 *
 * @param bool   $status If the integration is already active or not
 * @param string $code   The integration code
 *
 * @return bool $status
 */
function maybe_add_integration( $status, $code ) {

	if ( 'WCX' === $code ) {
		if ( class_exists( 'WooCommerce' ) ) {
			$status = true;
		} else {
			$status = false;
		}
	}

	return $status;
}

/*
 * SECTION 2 - Adding a trigger
 * =========
 *
 * Let's add a trigger to our newly created WooCommerce Sample (WCX) integration!
 *
 * This sample trigger allows WooCommerce product views to be used as a trigger for a recipe.
 */

/* SECTION 2 - PART A */
// Add trigger during the "uncanny_automator_add_integration_triggers_actions_tokens" do_action()
add_action( 'uncanny_automator_add_integration_triggers_actions_tokens', 'uncanny_automator_triggers_sample_user_views_product' );

/**
 * Define and register the trigger by pushing it into the Automator object
 */
function uncanny_automator_triggers_sample_user_views_product() {

	// Let’s grab the Automator global object which stores all integrations, triggers, actions, recipe data and internal functions.
	global $uncanny_automator;

	$trigger = array(

		// Your name or the company that will support the trigger
		'author'              => 'Uncanny Automator',

		// The link recipe creators can go to if the trigger is not functioning properly
		'support_link'        => 'https://www.example.com/your-support-page',

		/*
		 * The integration references an integration code. This will list your trigger in the trigger integration
		 * list @see documentation-images/integration-trigger-list.png when the integration is selected @see
		 * documentation-images/trigger-integrations.png.
		 *
		 * The trigger will only be added if the the referenced integration is registered and is active @see SECTION 1 - PART B
		 *
		 * It should be uppercase, and have no special characters.
		 */
		'integration'         => 'WCX',

		/*
		 * The code must be unique and should be intuitive. It should be uppercase and have no special
		 * characters.
		 *
		 * To view list of triggers that have been registered, visit a recipe creation page in /wp-admin/, open the browser
		 * developer console (press F12) and type in "UncannyAutomator.triggers" then press enter.
		 */
		'code'                => 'VIEWWOOPRODUCTSAMPLE',

		/*
		 *  The trigger sentence with option selection(s)
		 *
		 * @see documentation-images/trigger-sentence.png to view where the sentence will be visible in the UI
		 *
		 * Understanding the option sentence token {{option placeholder text:option code}}
		 *
		 *  - The token will be displayed inside of a blue button
		 *
		 * - Before the options are saved, the sentence 'User views {{a product:%1$s}} {{a number of:%2$s}} times'
		 *   will display in the UI as: 'User views a product number of times' because it uses the placeholder values.
		 *
		 * - After the options are saved, the sentence 'User views {{a product:%1$s}} {{a number of:%2$s}} times'
		 *   will display in the UI as 'User views My Sample Woo Product 1 times' because it uses the stored values.
		 *
		 * - The option codes 'WOOPRODUCT' and 'NUMTIMES' are the meta_keys that the values are stored under. They
		 *   should be unique to the trigger; trigger codes do not need to be uniquq across triggers.
		 *   They should be alphanumeric and uppercase with no spaces or special characters.
		 *
		 * - Each option value is stored in the post_meta table individually; here's an example:
		 * +---------+------------------+---------------+----------------+
		 * | meta_id | post_id          | meta_key      | meta_value     |
		 * +---------+------------------+---------------+----------------+
		 * | int     | {action post ID} | {option code} | {option value} |
		 * +---------+------------------+---------------+----------------+
		 */
		/* Translators: 1:Products 2:Number of times*/
		'sentence'            => sprintf( __( 'User views {{a product:%1$s}} {{a number of:%2$s}} times', 'uncanny-automator' ), 'WOOPRODUCT', 'NUMTIMES' ),

		/*
		 * Option name in the trigger select drop down
		 *
		 * @see documentation-images/select-option-name.png to view where the text will be visible in the UI
		 *
		 * Understanding the option name text token {{option name text}}
		 *
		 * - The token will be displayed as blue text in the select option to create a visual marker that allows the user
		 *   to quickly understand which options will be available.
		 */
		'select_option_name'  => __( 'User views {{a product}}', 'uncanny-automator' ),

		/*
		 * The action, priority, and accepted_args values are used to automatically generate an add_action statement that will
		 * hook into the do_action that will "trigger" this trigger.
		 * The validation_function is used as a callback. The means that the defined validation function will have
		 * all the parameters of the do_action passed to it.`
		 *
		 * ex. add_action( '{action}', '{validation_function}', {priority}, {accepted_args}) will be created
		 */
		// The do_action the trigger should be hooked to.
		'action'              => 'template_redirect',
		// The priority of the add_action that will be created.
		'priority'            => 90,
		// The number of accepted arguments for the add_action.
		'accepted_args'       => 1,
		// The function that will run when the add_action is executed.
		'validation_function' => 'view_woo_product_sample',

		// The options for the trigger that are be used in the sentence and validation function
		'options'             => [

			/*
			 * Manually setting up a <select> option.
			 *
			 * Uncanny Automator includes a set of predefined functions for your convenience.  Examples: create a post select drop-down,
			 * a text field, a generic drop down, a url field, a WooCommerce product select drop down etc.
			 * - @see plugins\uncanny-automator\src\core\mu-classes\composite-classes\automator-options.php to view all options
			 */
			[
				/*
				 * The option code is the same code that we used in the token. This option will appear when the related
				 * token-generated blue button is clicked.
				*/
				'option_code' => 'WOOPRODUCT',
				// Label above the input
				'label'       => __( 'Select a Product', 'your-language-domain' ),
				// Type of input. Available inputs are int, float, text, select, url, and textarea.
				'input_type'  => 'select',
				// If the field needs to be filled for the option to be saved.
				'required'    => true,
				// The array of option values and text for the drop down.
				'options'     => woocommerce_products_options(),
			],

			/*
			 * Here we are using a predefined Automator function to set up an option.
			 * - @see plugins\uncanny-automator\src\core\mu-classes\composite-classes\automator-options.php
			 */
			$uncanny_automator->options->number_of_times(),
		],
	);

	$uncanny_automator->register_trigger( $trigger );

	return;
}

/**
 * Create an array of options for the select drop down
 *
 * @return array $options
 */
function woocommerce_products_options() {

	$args = [
		'post_type'      => 'product',
		'posts_per_page' => 999,
		'orderby'        => 'title',
		'order'          => 'ASC',
		'post_status'    => 'publish',
	];

	// Get all published WooCommerce product posts
	$posts = get_posts( $args );

	// Create an array to collect our options
	$options = [];
	// Create an option that allows any product to be viewed for the trigger to complete
	$options['-1'] = __( 'Any product', 'uncanny-automator' );

	foreach ( $posts as $post ) {

		$title = $post->post_title;

		// If there is no post title then we will show the ID instead
		if ( empty( $title ) ) {
			/* Translators: 1:The post ID*/
			$title = sprintf( __( 'ID: %1$s (no title)', 'uncanny-automator' ), $post->ID );
		}

		/*
		 * The array key will populate the option value and the array value will populate the option text
		 * Ex. $options[ option value ] = option text;
		 * Ex. <option value=" option value "> option text </option>
		 */
		$options[ $post->ID ] = $title;
	}

	return $options;
}

/**
 * The validation function runs during the defined add_action() that was dynamically created in our trigger
 * definition array.
 * @see $trigger['action'], $trigger['priority'], $trigger['accepted_args'], and $trigger['validation_function']
 */
function view_woo_product_sample() {

	// Let’s grab the Automator global object which stores all integrations, triggers, actions, recipe data and internal functions.
	global $uncanny_automator;

	global $post;

	// Is the page a product page
	if ( 'product' !== $post->post_type ) {
		return;
	}

	$user_id = get_current_user_id();

	/*
	 * Passing the post ID into args automatically checks if the post ID matches.
	 * You could also skip the post ID or pass 0 if you want to validate it yourself
	 */
	$args = [
		'code'    => 'VIEWWOOPRODUCTSAMPLE',
		'meta'    => 'WOOPRODUCT',
		'post_id' => $post->ID,
		'user_id' => $user_id,
	];

	/*
	 * This function is mandatory. It runs a series of validations and completes the trigger.
	 *
	 * Passing false as the second parameter will run all the mandatory validations but will not complete the trigger.
	 * It will however return a validation data array and you may use it extend validation for your specific needs.
	 *
	 */
	$uncanny_automator->maybe_add_trigger_entry( $args, true );

	return; // We are done now :)

	/*
	 * This is an example of extending trigger validations by passing false as the second argument.
	 * This is an advanced and rarely needed approach so we will not cover it fully.
	 */
	$validations = $uncanny_automator->maybe_add_trigger_entry( $args, false );

	if ( $validations ) {
		foreach ( $validations as $result ) {
			// did the validation complete successfully
			if ( true === $result['result'] ) {
				// Complete the trigger
				$uncanny_automator->maybe_trigger_complete( $result['args'] );
			}
		}
	}
}

/*
 * SECTION 3 - Adding an action
 * =========
 *
 * Let's add an action to the existing WordPress (WP) integration!
 *
 * This sample action allow WP to send a email to the user that completed all triggers in a recipe.
 */

// Add action during the "uncanny_automator_add_integration_triggers_actions_tokens" do_action()
add_action( 'uncanny_automator_add_integration_triggers_actions_tokens', 'uncanny_automator_actions_send_email' );

/**
 * Define and register the action by pushing it into the Automator object
 */
function uncanny_automator_actions_send_email() {

	// Let’s grab the Automator global object which stores all integrations, triggers, actions, recipe data and internal functions.
	global $uncanny_automator;

	$action = array(

		// Your name or the company that will support the action
		'author'             => 'Uncanny Automator',

		// The link recipe creators can go to if the action is not functioning properly
		'support_link'       => 'https://www.example.com/your-support-page',

		/*
		 * The integration references an integration code. This will list your action in the action integration
		 * list @see documentation-images/integration-action-list.png when the integration is selected @see
		 * documentation-images/action-integrations.png.
		 *
		 * The action will only be added if the the referenced integration is registered and is active @see SECTION 1 - PART B
		 *
		 * It should be uppercase, and have no special characters.
		 */
		'integration'        => 'WP',

		/*
		 * The code must be unique and should be intuitive. It should be uppercase and have no special
		 * characters.
		 *
		 * To view list of actions that have been registered, visit a recipe creation page in wp admin, open the browser
		 * developer console (press F12) and type in "UncannyAutomator.actions" then press enter.
		 */
		'code'               => 'SENDEMAILX',

		/*
		 *  The action sentence with option selection(s)
		 *
		 * @see documentation-images/action-sentence.png where the sentence will be visible in the UI
		 *
		 * Understanding the option tokens {{option placeholder:option code}}
		 *
		 *  - The token will be displayed inside of a blue button.
		 *
		 * - Before the options are saved, the sentence 'Send an email to {{email address:%1$s}} X'
		 *   will display in the UI as: Send an email to email address X' because it uses the placeholder values.
		 *
		 * - After the options are saved, the sentence 'Send an email to {{email address:%1$s}} X'
		 *   will display in the UI as 'Send an email to example@emailaddress.com X' because it uses the stored values.
		 *
		 * - The option code 'EMAILTO' is the meta_key that the values are stored under.  It should be unique to this action.
		 *   They should be alphanumeric and uppercase with no spaces or special characters.
		 *
		 * - Each option value is stored in the post_meta table individually ex.
		 * +---------+------------------+---------------+----------------+
		 * | meta_id | post_id          | meta_key      | meta_value     |
		 * +---------+------------------+---------------+----------------+
		 * | int     | {action post ID} | {option code} | {option value} |
		 * +---------+------------------+---------------+----------------+
		 */
		/* Translators: 1:Email Address*/
		'sentence'           => sprintf( __( 'Send an email to {{email address:%1$s}} X', 'uncanny-automator' ), 'EMAILTO' ),

		/*
		 * Option name in the actions select drop down
		 *
		 * @see documentation-images/select-option-name.png where the text will be visible in the UI
		 *
		 * Understand the text token {{some text}}
		 *
		 * - The token will be displayed as blue text in the select option to create a visual marker that allows the user
		 *   to quickly understand which options are available.
		 */
		'select_option_name' => __( 'Send an {{email}} X', 'uncanny-automator' ),

		// Currently not implemented. Reserved for future release. Set as 10.
		'priority'           => 10,
		// The function that runs once all triggers in the recipe are completed.
		'execution_function' => 'send_email',

		/*
		 * This is an example of grouped option fields. When you click the blue button inside of an action sentence, a
		 * group of fields will appear instead of a single field.
		 *
		 * Please note that grouped option fields can be used in triggers too.
		 */
		'options_group'      => [
			'EMAILTO' => [ // The option code of the blue button inside the action sentence

				// Setting up a text field option
				$uncanny_automator->options->text_field(
					'EMAILFROM', // The field's option code
					__( 'From:', 'uncanny-automator' ), // The field's label
					true, // If tokens are allowed or not.
					'email', // Validation type
					'{{admin_email}}', // Default value of the text field. In this case we are passing a token.
					true, // Is the field required
					__( 'The email address that the email is sent from.', 'uncanny-automator' ), // A light description of what the field is.
					'example@example.com' // The placeholder of the field
				),

				$uncanny_automator->options->text_field( 'EMAILTO', __( 'To:', 'uncanny-automator' ), true, 'email', '{{user_email}}', true, __( 'Separate multiple email addresses with a comma', 'uncanny-automator' ) ),
				$uncanny_automator->options->text_field( 'EMAILCC', __( 'CC:', 'uncanny-automator' ), true, 'email', '', false ),
				$uncanny_automator->options->text_field( 'EMAILBCC', __( 'BCC:', 'uncanny-automator' ), true, 'email', '', false ),
				$uncanny_automator->options->text_field( 'EMAILSUBJECT', __( 'Subject:', 'uncanny-automator' ), true ),
				$uncanny_automator->options->text_field( 'EMAILBODY', __( 'Body:', 'uncanny-automator' ), true, 'textarea' ),
			],
		],
	);

	$uncanny_automator->register_action( $action );
}

/**
 * The function that performs the action
 *
 * @param int   $user_id     The user ID that is completing the action
 * @param array $action_data The action's option data
 * @param int   $recipe_id   ID of the recipe associated with the action
 */
function send_email( $user_id, $action_data, $recipe_id ) {

	// Let’s grab the Automator global object which stores all integrations, triggers, actions, recipe data and internal functions.
	global $uncanny_automator;

	$to      = $uncanny_automator->parse->text( $action_data['meta']['EMAILTO'], $recipe_id, $user_id );
	$from    = $uncanny_automator->parse->text( $action_data['meta']['EMAILFROM'], $recipe_id, $user_id );
	$cc      = $uncanny_automator->parse->text( $action_data['meta']['EMAILCC'], $recipe_id, $user_id );
	$bcc     = $uncanny_automator->parse->text( $action_data['meta']['EMAILBCC'], $recipe_id, $user_id );
	$subject = $uncanny_automator->parse->text( $action_data['meta']['EMAILSUBJECT'], $recipe_id, $user_id );
	$body    = $uncanny_automator->parse->text( $action_data['meta']['EMAILBODY'], $recipe_id, $user_id );

	$headers[] = 'From: <' . $from . '>';

	if ( ! empty( $cc ) ) {
		$headers[] = 'Cc: ' . $cc;
	}

	if ( ! empty( $bcc ) ) {
		$headers[] = 'Bcc: ' . $bcc;
	}

	$headers[] = 'Content-Type: text/html; charset=UTF-8';

	$mailed = wp_mail( $to, $subject, $body, $headers );

	if ( ! $mailed ) {

		/*
		 * A set of defined messages can be found in \src\core\mu-classes\composite-classes\automator-error-messages.php.
		 * You can also pass any string as the error message.
		 */
		$error_message = $uncanny_automator->error_message->get( 'email-failed' );

		/*
		 * When we pass an error message to the complete action function the action is marked as completed. In the
		 * recipe log(/wp-admin/admin.php?page=uncanny-activities&tab=recipe-log) the status column value is "Completed with errors".
		 * In the action log(/wp-admin/admin.php?page=uncanny-activities&tab=action-log) the status column value is
		 * "Completed with errors" and the Notes column value will be the $error_message passed.
		 */
		$uncanny_automator->complete_action( $user_id, $action_data, $recipe_id, $error_message );

		return;
	}

	// Complete the action! All done :)
	$uncanny_automator->complete_action( $user_id, $action_data, $recipe_id );
}
