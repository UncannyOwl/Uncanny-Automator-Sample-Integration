<?php

/**
 * Sample Integration Settings
 */

?>

<div class="uap-settings-panel">
	<div class="uap-settings-panel-top">

		<div class="uap-settings-panel-title">
			<?php esc_html_e( 'Sample integration settings', 'uncanny-automator' ); ?>
		</div>

		<div class="uap-settings-panel-content">

			<?php 

			// Check if the account is connected
			if ( $is_connected ) {

				?>

				Output (account connected)

				<?php

			}

			// Check if the account is NOT connected
			if ( !  $is_connected ) {

				?>

				Output (account not connected)

				<?php

			}

			?>

		</div>

	</div>

	<div class="uap-settings-panel-bottom">

		<?php

		if ( $is_connected ) {

			?>

			<div class="uap-settings-panel-bottom-left">

				<div class="uap-settings-panel-user">

					<div class="uap-settings-panel-user__avatar">
						<?php echo esc_html( strtoupper( $user_data->username[0] ) ); ?>
					</div>

					<div class="uap-settings-panel-user-info">
						<div class="uap-settings-panel-user-info__main">
							<?php echo esc_html( $user_data->name ); ?>
						</div>
						<div class="uap-settings-panel-user-info__additional">
							<?php echo esc_html( $user_data->email_address ); ?>
						</div>
					</div>
				</div>

			</div>

			<div class="uap-settings-panel-bottom-right">
				<uo-button
					href="<?php echo esc_url( $oauth_urls->disconnect ); ?>"
					color="danger"
				>
					<uo-icon id="sign-out"></uo-icon>

					<?php esc_html_e( 'Disconnect', 'uncanny-automator' ); ?>
				</uo-button>
			</div>

			<?php

		} 

		if ( ! $is_connected ) {

			?>

			<uo-button
				href="<?php echo esc_url( $oauth_urls->connect ); ?>"
			>
				<?php esc_html_e( 'Connect Sample Integration', 'uncanny-automator' ); ?>
			</uo-button>

			<?php

		}

		?>

	</div>

</div>