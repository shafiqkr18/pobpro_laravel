<ul class="links list-unstyled p-0 d-flex flex-nowrap justify-content-center h-100">
	<li>
		<a href="dashboard.php" class="<?= basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : '' ?>">Dashboard</a>
	</li>

	<li>
		<a href="javascript:void(0)" 
			class="<?= basename($_SERVER['PHP_SELF']) == 'timesheet.php' 
							|| basename($_SERVER['PHP_SELF']) == 'handover.php' ? 'active' : '' ?>">Timesheet</a>

		<ul class="sub-menu list-unstyled">
			<li>
				<a href="timesheet.php" class="<?= basename($_SERVER['PHP_SELF']) == 'timesheet.php' ? 'active' : '' ?>">Timesheet</a>
				<a href="handover.php" class="<?= basename($_SERVER['PHP_SELF']) == 'handover.php' ? 'active' : '' ?>">Handover</a>
			</li>
		</ul>
	</li>

	<li>
		<a href="training.php" class="<?= basename($_SERVER['PHP_SELF']) == 'training.php' ? 'active' : '' ?>">Training Center</a>
	</li>

	<li>
		<a href="javascript:void(0)" 
			class="<?= basename($_SERVER['PHP_SELF']) == 'my-visa.php' 
							|| basename($_SERVER['PHP_SELF']) == 'my-travel.php' 
							|| basename($_SERVER['PHP_SELF']) == 'visa-request.php' ? 'active' : '' ?>">Administration</a>

		<ul class="sub-menu list-unstyled">
			<li>
				<a href="my-travel.php" class="<?= basename($_SERVER['PHP_SELF']) == 'my-travel.php' ? 'active' : '' ?>">My Travel</a>
				<a href="my-visa.php" class="<?= basename($_SERVER['PHP_SELF']) == 'my-visa.php' ? 'active' : '' ?>">My Visa</a>
				<a href="visa-request.php" class="<?= basename($_SERVER['PHP_SELF']) == 'visa-request.php' ? 'active' : '' ?>">Request New Visa</a>
			</li>
		</ul>
	</li>

	<li>
		<a href="javascript:void(0)" 
			class="<?= basename($_SERVER['PHP_SELF']) == 'my-accommodation.php' 
							|| basename($_SERVER['PHP_SELF']) == 'dining-card-request-form.php' ? 'active' : '' ?>">Camp</a>

		<ul class="sub-menu list-unstyled">
			<li>
				<a href="my-accommodation.php" class="<?= basename($_SERVER['PHP_SELF']) == 'my-accommodation.php' ? 'active' : '' ?>">My Accommodation</a>
				<a href="dining-card-request-form.php">Dining Card Request</a>
			</li>
		</ul>
	</li>

	<li>
		<a href="javascript:void(0)" 
			class="<?= basename($_SERVER['PHP_SELF']) == 'ppe-management.php' 
							|| basename($_SERVER['PHP_SELF']) == 'certification-and-training.php' ? 'active' : '' ?>">HSE</a>

		<ul class="sub-menu list-unstyled">
			<li>
				<a href="ppe-management.php" class="<?= basename($_SERVER['PHP_SELF']) == 'ppe-management.php' ? 'active' : '' ?>">PPE Management</a>
				<a href="certification-and-training.php" class="<?= basename($_SERVER['PHP_SELF']) == 'certification-and-training.php' ? 'active' : '' ?>">Certification &amp; Training</a>
			</li>
		</ul>
	</li>

	<li>
		<a href="javascript:void(0)" 
			class="<?= basename($_SERVER['PHP_SELF']) == 'security-form.php' 
							|| basename($_SERVER['PHP_SELF']) == 'access-application.php' ? 'active' : '' ?>">Security</a>

		<ul class="sub-menu list-unstyled">
			<li>
				<a href="security-form.php" class="<?= basename($_SERVER['PHP_SELF']) == 'security-form.php' ? 'active' : '' ?>">Daily POB Submit</a>
				<a href="access-application.php" class="<?= basename($_SERVER['PHP_SELF']) == 'access-application.php' ? 'active' : '' ?>">Access Application</a>
			</li>
		</ul>
	</li>

	<li>
		<a href="it-systems.php" class="<?= basename($_SERVER['PHP_SELF']) == 'it-systems.php' ? 'active' : '' ?>">IT Systems</a>
	</li>

	<li>
		<a href="javascript:void(0)" 
			class="<?= basename($_SERVER['PHP_SELF']) == 'cash-advance-management.php' 
							|| basename($_SERVER['PHP_SELF']) == 'reimbursement-management.php' ? 'active' : '' ?>">Finances</a>

		<ul class="sub-menu list-unstyled">
			<li>
				<a href="cash-advance-management.php" class="<?= basename($_SERVER['PHP_SELF']) == 'cash-advance-management.php' ? 'active' : '' ?>">Cash Advance</a>
				<a href="reimbursement-management.php" class="<?= basename($_SERVER['PHP_SELF']) == 'reimbursement-management.php' ? 'active' : '' ?>">Reimbursement</a>
			</li>
		</ul>
	</li>

	<li>
		<a href="javascript:void(0)" 
			class="<?= basename($_SERVER['PHP_SELF']) == 'my-profile.php' 
							|| basename($_SERVER['PHP_SELF']) == 'my-jobs.php' 
							|| basename($_SERVER['PHP_SELF']) == 'my-offers.php' 
							|| basename($_SERVER['PHP_SELF']) == 'faq.php' ? 'active' : '' ?>">HR</a>

		<ul class="sub-menu list-unstyled">
			<li>
				<a href="my-profile.php" class="<?= basename($_SERVER['PHP_SELF']) == 'my-profile.php' ? 'active' : '' ?>">My Profile</a>
				<a href="my-jobs.php" class="<?= basename($_SERVER['PHP_SELF']) == 'my-jobs.php' ? 'active' : '' ?>">My Jobs</a>
				<a href="faq.php" class="<?= basename($_SERVER['PHP_SELF']) == 'faq.php' ? 'active' : '' ?>">Q &amp; A</a>
				<a href="my-offers.php" class="<?= basename($_SERVER['PHP_SELF']) == 'my-offers.php' ? 'active' : '' ?>">My Offers</a>
			</li>
		</ul>
	</li>
</ul>