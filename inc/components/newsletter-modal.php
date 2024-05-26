<?php

	function add_newsletter_modal() {
		?>
			<!-- modal -->
			<div class="modal fade" id="newsletter_signup_modal" tabindex="-1" role="dialog" aria-labelledby="newsletter_signup_modal" aria-hidden="true">
				<div class="modal-dialog modal-md modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header px-5">
							<div class = "logo-box">
								<a href = "<?php echo home_url(); ?>"><img src = "<?php echo get_stylesheet_directory_uri() ?>/images/logo-r.png" /></a>
							</div>
							<!--<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>-->
						</div>
						<div class="modal-body p-5">
							<div class = "modal-textbox">
								<h4>Newsletter Signup</h4>
								<p>Fill in the form below to sign up to our newsletter</p>
							</div>
							<iframe src="https://go.pardot.com/l/286652/2019-12-01/7xfv1j" width="100%" height="350" type="text/html" frameborder="0" allowTransparency="true" style="border: 0"></iframe>
						</div>
					</div>
				</div>
			</div>

		<?php
	}

?>