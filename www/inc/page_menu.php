	<header class="navbar navbar-default" style="margin: -20px;">
	   <div id="horizontal-menu-collapse" class="collapse navbar-collapse">
			<ul class="nav navbar-nav">
				<li>
					<a href="#" onclick="loadPage('home.php'); return false;">Orders</a>
				</li>
				<li>
					<a href="#" onclick="loadPage('label.php'); return false;">Labels</a>
				</li>
				<li class="dropdown">
					<a href="#" class="drop-btn">Settings</a>
						
						<ul class="dropdown-content">
							<li>
								<a href="#" onclick="loadPage('vat.php'); return false;">Vat</a>
							</li>
							<li>
								<a href="#" onclick="loadPage('company.php'); return false;">Companey Name</a>
							</li>
							<li>
								<a href="#" onclick="loadPage('product.php'); return false;">Products</a>
							</li>
							<li>
								<a href="#" onclick="loadPage('lense.php'); return false;">Lenses</a>
							</li>
							<li>
								<a href="#" onclick="loadPage('chart.php'); return false;">Report</a>
							</li>
							<li>
								<a href="<?php echo SITE_URL; ?>3A1773F06826A2D4F882E9334089E3F4.php">Change Password</a>
							</li>
						</ul>
						
				
				<li>
					<a href="" onclick="loadPage('login.php?logout=true'); return false;">Log out</a>
				</li>
			</ul>
		</div>
		<!-- END Horizontal Menu + Search -->

	</header>
