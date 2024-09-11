<?php include "headerlink.php"; ?>
<link href='https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400|Patua+One' rel='stylesheet' type='text/css'>
<style>
	.output {
		list-style: none;
		width: 100%;
		min-height: 0px;
		border-top: 0 !important;
		color: #767676;
		font-size: .75em;
		transition: min-height 0.2s;
		position: absolute;
		z-index: 5;
	}

	.output,
	#search-bar {
		background: #fff;
		border: 1px solid #767676;
	}

	.prediction-item {
		padding: .5em .75em;
		transition: color 0.2s, background 0.2s;
	}

	.output:hover .focus {
		background: #fff;
		color: #767676;
	}

	.prediction-item:hover,
	.focus,
	.output:hover .focus:hover {
		background: #ddd;
		color: #333;
	}

	.prediction-item:hover {
		cursor: pointer;
	}

	.prediction-item strong {
		color: #333;
	}

	.prediction-item:hover strong {
		color: #000;
	}
</style>
<div class="horizontal-menu">
	<nav class="navbar top-navbar">
		<div class="container">
			<div class="navbar-content">
				<a href="#" class="navbar-brand">
					<img src="assets/images/beams_logo.png" alt="error" width="50px" height="50px" />
				</a>
				<form class="search-form">
					<div class="input-group">
						<div class="input-group-prepend">
							<div class="input-group-text">
								<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
									<circle cx="11" cy="11" r="8"></circle>
									<line x1="21" y1="21" x2="16.65" y2="16.65"></line>
								</svg>
							</div>
						</div>
						<input type="text" class="form-control" id="navbarForm" placeholder="Search here..." autocomplete="off" />
						<ul class="output" style="display:none;">
						</ul>
					</div>
				</form>
				<ul class="navbar-nav">
					<!--<li class="nav-item dropdown">-->
					<!--	<a class="nav-link dropdown-toggle" href="#" id="languageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">-->
					<!--		<i class="flag-icon flag-icon-us mt-1" title="us"></i> <span class="font-weight-medium ml-1 mr-1">English</span>-->
					<!--	</a>-->
					<!--	<div class="dropdown-menu" aria-labelledby="languageDropdown">-->
					<!--		<a href="javascript:;" class="dropdown-item py-2"><i class="flag-icon flag-icon-us" title="us" id="us"></i> <span class="ml-1"> English </span></a>-->
					<!--		<a href="javascript:;" class="dropdown-item py-2"><i class="flag-icon flag-icon-fr" title="fr" id="fr"></i> <span class="ml-1"> French </span></a>-->
					<!--		<a href="javascript:;" class="dropdown-item py-2"><i class="flag-icon flag-icon-de" title="de" id="de"></i> <span class="ml-1"> German </span></a>-->
					<!--		<a href="javascript:;" class="dropdown-item py-2"><i class="flag-icon flag-icon-pt" title="pt" id="pt"></i> <span class="ml-1"> Portuguese </span></a>-->
					<!--		<a href="javascript:;" class="dropdown-item py-2"><i class="flag-icon flag-icon-es" title="es" id="es"></i> <span class="ml-1"> Spanish </span></a>-->
					<!--	</div>-->
					<!--</li>-->
					<li class="nav-item dropdown nav-apps">
						<a class="nav-link dropdown-toggle" href="#" id="appsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-grid">
								<rect x="3" y="3" width="7" height="7"></rect>
								<rect x="14" y="3" width="7" height="7"></rect>
								<rect x="14" y="14" width="7" height="7"></rect>
								<rect x="3" y="14" width="7" height="7"></rect>
							</svg>
						</a>
						<div class="dropdown-menu" aria-labelledby="appsDropdown">
							<div class="dropdown-header d-flex align-items-center justify-content-between">
								<p class="mb-0 font-weight-medium">Web Apps</p>
								<a href="javascript:;" class="text-muted">Edit</a>
							</div>
							<div class="dropdown-body">
								<div class="d-flex align-items-center apps">
									<a href="pages/apps/chat.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-message-square icon-lg">
											<path d="M21 15a2 2 0 0 1-2 2H7l-4 4V5a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2z"></path>
										</svg>
										<p>Chat</p>
									</a>
									<a href="pages/apps/calendar.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-calendar icon-lg">
											<rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
											<line x1="16" y1="2" x2="16" y2="6"></line>
											<line x1="8" y1="2" x2="8" y2="6"></line>
											<line x1="3" y1="10" x2="21" y2="10"></line>
										</svg>
										<p>Calendar</p>
									</a>
									<a href="pages/email/inbox.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail icon-lg">
											<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
											<polyline points="22,6 12,13 2,6"></polyline>
										</svg>
										<p>Email</p>
									</a>
									<a href="pages/general/profile.html"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-instagram icon-lg">
											<rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
											<path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
											<line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
										</svg>
										<p>Profile</p>
									</a>
								</div>
							</div>
							<div class="dropdown-footer d-flex align-items-center justify-content-center">
								<a href="javascript:;">View all</a>
							</div>
						</div>
					</li>
					<li class="nav-item dropdown nav-messages">
						<a class="nav-link dropdown-toggle" href="#" id="messageDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail">
								<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
								<polyline points="22,6 12,13 2,6"></polyline>
							</svg>
						</a>
						<div class="dropdown-menu" aria-labelledby="messageDropdown">
							<div class="dropdown-header d-flex align-items-center justify-content-between">
								<p class="mb-0 font-weight-medium">9 New Messages</p>
								<a href="javascript:;" class="text-muted">Clear all</a>
							</div>
							<div class="dropdown-body">
								<a href="javascript:;" class="dropdown-item">
									<div class="figure">
										<img src="https://via.placeholder.com/30x30" alt="userr">
									</div>
									<div class="content">
										<div class="d-flex justify-content-between align-items-center">
											<p>Leonardo Payne</p>
											<p class="sub-text text-muted">2 min ago</p>
										</div>
										<p class="sub-text text-muted">Project status</p>
									</div>
								</a>
								<a href="javascript:;" class="dropdown-item">
									<div class="figure">
										<img src="https://via.placeholder.com/30x30" alt="userr">
									</div>
									<div class="content">
										<div class="d-flex justify-content-between align-items-center">
											<p>Carl Henson</p>
											<p class="sub-text text-muted">30 min ago</p>
										</div>
										<p class="sub-text text-muted">Client meeting</p>
									</div>
								</a>
								<a href="javascript:;" class="dropdown-item">
									<div class="figure">
										<img src="https://via.placeholder.com/30x30" alt="userr">
									</div>
									<div class="content">
										<div class="d-flex justify-content-between align-items-center">
											<p>Jensen Combs</p>
											<p class="sub-text text-muted">1 hrs ago</p>
										</div>
										<p class="sub-text text-muted">Project updates</p>
									</div>
								</a>
								<a href="javascript:;" class="dropdown-item">
									<div class="figure">
										<img src="https://via.placeholder.com/30x30" alt="userr">
									</div>
									<div class="content">
										<div class="d-flex justify-content-between align-items-center">
											<p><?php echo $_SESSION['name']; ?></p>
											<p class="sub-text text-muted">2 hrs ago</p>
										</div>
										<p class="sub-text text-muted">Project deadline</p>
									</div>
								</a>
								<a href="javascript:;" class="dropdown-item">
									<div class="figure">
										<img src="https://via.placeholder.com/30x30" alt="userr">
									</div>
									<div class="content">
										<div class="d-flex justify-content-between align-items-center">
											<p>Yaretzi Mayo</p>
											<p class="sub-text text-muted">5 hr ago</p>
										</div>
										<p class="sub-text text-muted">New record</p>
									</div>
								</a>
							</div>
							<div class="dropdown-footer d-flex align-items-center justify-content-center">
								<a href="javascript:;">View all</a>
							</div>
						</div>
					</li>
					<li class="nav-item dropdown nav-notifications">
						<a class="nav-link dropdown-toggle" href="#" id="notificationDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
								<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
								<path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
							</svg>
							<div class="indicator">
								<div class="circle"></div>
							</div>
						</a>
						<div class="dropdown-menu" aria-labelledby="notificationDropdown">
							<div class="dropdown-header d-flex align-items-center justify-content-between">
								<p class="mb-0 font-weight-medium">6 New Notifications</p>
								<a href="javascript:;" class="text-muted">Clear all</a>
							</div>
							<div class="dropdown-body">
								<a href="javascript:;" class="dropdown-item">
									<div class="icon">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus">
											<path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
											<circle cx="8.5" cy="7" r="4"></circle>
											<line x1="20" y1="8" x2="20" y2="14"></line>
											<line x1="23" y1="11" x2="17" y2="11"></line>
										</svg>
									</div>
									<div class="content">
										<p>New customer registered</p>
										<p class="sub-text text-muted">2 sec ago</p>
									</div>
								</a>
								<a href="javascript:;" class="dropdown-item">
									<div class="icon">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-gift">
											<polyline points="20 12 20 22 4 22 4 12"></polyline>
											<rect x="2" y="7" width="20" height="5"></rect>
											<line x1="12" y1="22" x2="12" y2="7"></line>
											<path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path>
											<path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path>
										</svg>
									</div>
									<div class="content">
										<p>New Order Recieved</p>
										<p class="sub-text text-muted">30 min ago</p>
									</div>
								</a>
								<a href="javascript:;" class="dropdown-item">
									<div class="icon">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-alert-circle">
											<circle cx="12" cy="12" r="10"></circle>
											<line x1="12" y1="8" x2="12" y2="12"></line>
											<line x1="12" y1="16" x2="12.01" y2="16"></line>
										</svg>
									</div>
									<div class="content">
										<p>Server Limit Reached!</p>
										<p class="sub-text text-muted">1 hrs ago</p>
									</div>
								</a>
								<a href="javascript:;" class="dropdown-item">
									<div class="icon">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-layers">
											<polygon points="12 2 2 7 12 12 22 7 12 2"></polygon>
											<polyline points="2 17 12 22 22 17"></polyline>
											<polyline points="2 12 12 17 22 12"></polyline>
										</svg>
									</div>
									<div class="content">
										<p>Apps are ready for update</p>
										<p class="sub-text text-muted">5 hrs ago</p>
									</div>
								</a>
								<a href="javascript:;" class="dropdown-item">
									<div class="icon">
										<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-download">
											<path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path>
											<polyline points="7 10 12 15 17 10"></polyline>
											<line x1="12" y1="15" x2="12" y2="3"></line>
										</svg>
									</div>
									<div class="content">
										<p>Download completed</p>
										<p class="sub-text text-muted">6 hrs ago</p>
									</div>
								</a>
							</div>
							<div class="dropdown-footer d-flex align-items-center justify-content-center">
								<a href="javascript:;">View all</a>
							</div>
						</div>
					</li>
					<li class="nav-item dropdown nav-profile">
						<a class="nav-link dropdown-toggle" href="#" id="profileDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
							<img src="https://via.placeholder.com/30x30" alt="profile">
						</a>
						<div class="dropdown-menu" aria-labelledby="profileDropdown">
							<div class="dropdown-header d-flex flex-column align-items-center">
								<div class="figure mb-3">
									<img src="https://via.placeholder.com/80x80" alt="">
								</div>
								<div class="info text-center">
									<p class="name font-weight-bold mb-0"><?php echo $_SESSION['name']; ?></p>
									<p class="email text-muted mb-3">amiahburton@gmail.com</p>
								</div>
							</div>
							<div class="dropdown-body">
								<ul class="profile-nav p-0 pt-3">
									<li class="nav-item">
										<a href="pages/general/profile.html" class="nav-link">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user">
												<path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path>
												<circle cx="12" cy="7" r="4"></circle>
											</svg>
											<span>Profile</span>
										</a>
									</li>
									<li class="nav-item">
										<a href="javascript:;" class="nav-link">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
												<path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
												<path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
											</svg>
											<span>Edit Profile</span>
										</a>
									</li>
									<li class="nav-item">
										<a href="javascript:;" class="nav-link">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-repeat">
												<polyline points="17 1 21 5 17 9"></polyline>
												<path d="M3 11V9a4 4 0 0 1 4-4h14"></path>
												<polyline points="7 23 3 19 7 15"></polyline>
												<path d="M21 13v2a4 4 0 0 1-4 4H3"></path>
											</svg>
											<span>Switch User</span>
										</a>
									</li>
									<li class="nav-item">
										<a href="javascript:;" class="nav-link">
											<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out">
												<path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
												<polyline points="16 17 21 12 16 7"></polyline>
												<line x1="21" y1="12" x2="9" y2="12"></line>
											</svg>
											<span>Log Out</span>
										</a>
									</li>
								</ul>
							</div>
						</div>
					</li>
				</ul>
				<button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="horizontal-menu-toggle">
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-menu">
						<line x1="3" y1="12" x2="21" y2="12"></line>
						<line x1="3" y1="6" x2="21" y2="6"></line>
						<line x1="3" y1="18" x2="21" y2="18"></line>
					</svg>
				</button>
			</div>
		</div>
	</nav>
	<nav class="bottom-navbar">
		<div class="container">
			<ul class="nav page-navigation">
				<li class="nav-item ">

					<a class="nav-link" href="Project.php">


						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-box link-icon">
							<path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path>
							<polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline>
							<line x1="12" y1="22.08" x2="12" y2="12"></line>
						</svg>
						<span class="menu-title">Project</span>
					</a>
				</li>

				<li class="nav-item">
					<a href="Receiving.php" class="nav-link">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-wallet link-icon">
							<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
							<rect x="1" y="7" width="22" height="10" rx="2" ry="2"></rect>
						</svg>
						</svg>

						<span class="menu-title">Receivings</span>

					</a>
				</li>

				<!-- 
				<li class="nav-item mega-menu">

					<a href="Group.php" class="nav-link">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-feather link-icon">
						  <path d="M3 19H1V18C1 16.1362 2.27477 14.57 4 14.126M6 10.8293C4.83481 10.4175 4 9.30623 4 8.00001C4 6.69379 4.83481 5.58255 6 5.17072M21 19H23V18C23 16.1362 21.7252 14.57 20 14.126M18 5.17072C19.1652 5.58255 20 6.69379 20 8.00001C20 9.30623 19.1652 10.4175 18 10.8293M10 14H14C16.2091 14 18 15.7909 18 18V19H6V18C6 15.7909 7.79086 14 10 14ZM15 8C15 9.65685 13.6569 11 12 11C10.3431 11 9 9.65685 9 8C9 6.34315 10.3431 5 12 5C13.6569 5 15 6.34315 15 8Z" stroke-linejoin="round"></path>
						</svg>
						<span class="menu-title">Group</span>
					</a>
				</li> -->
				<!-- <li class="nav-item">
					<a href="Category.php" class="nav-link">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail link-icon">
							<path d="M20 12V6C20 4.89543 19.1046 4 18 4H12M20 12V18C20 19.1046 19.1046 20 18 20H12M20 12H12M4 12V18C4 19.1046 4.89543 20 6 20H12M4 12V6C4 4.89543 4.89543 4 6 4H12M4 12H12M12 12V4M12 12V20"></path>
						
						</svg>
						<span class="menu-title">Category</span>
						
					</a>
				</li> -->
				<li class="nav-item">
					<a href="Service.php" class="nav-link">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 16 16" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail link-icon">

							<path d="M6.834.33a2.25 2.25 0 012.332 0l5.25 3.182A2.25 2.25 0 0115.5 5.436V6A.75.75 0 0114 6v-.564a.75.75 0 00-.361-.642l-5.25-3.181a.75.75 0 00-.778 0l-5.25 3.181A.75.75 0 002 5.436v5.128a.75.75 0 00.361.642l4.028 2.44a.75.75 0 11-.778 1.283l-4.027-2.44A2.25 2.25 0 01.5 10.563V5.436a2.25 2.25 0 011.084-1.924L6.834.33zM11.749 7.325l.001-.042v-.286a.75.75 0 00-1.5 0v.286l.001.042a3.73 3.73 0 00-1.318.546.76.76 0 00-.03-.03l-.201-.203a.75.75 0 00-1.06 1.06l.201.203.03.028c-.26.394-.45.84-.547 1.319a.878.878 0 00-.04-.001H7a.75.75 0 000 1.5h.286l.038-.001c.097.48.286.926.547 1.32a.71.71 0 00-.028.027l-.202.202a.75.75 0 001.06 1.06l.203-.202a.695.695 0 00.025-.026c.395.261.842.45 1.322.548l-.001.036v.286a.75.75 0 001.5 0v-.286-.036c.48-.097.926-.287 1.32-.548l.026.026.202.203a.75.75 0 001.06-1.061l-.201-.202a.667.667 0 00-.028-.026c.261-.395.45-.842.547-1.321H15a.75.75 0 000-1.5h-.286l-.04.002a3.734 3.734 0 00-.547-1.319l.03-.028.202-.202a.75.75 0 00-1.06-1.061l-.203.202-.029.03a3.73 3.73 0 00-1.318-.545zM11 8.75A2.247 2.247 0 008.75 11 2.247 2.247 0 0011 13.25 2.247 2.247 0 0013.25 11 2.247 2.247 0 0011 8.75z"> </path>



							<!-- <polyline points="22,6 12,13 2,6"></polyline> -->
						</svg>
						<span class="menu-title">Service</span>
						<!-- <i class="link-arrow"></i> -->
					</a>
				</li>
				<li class="nav-item">
					<a href="Expense.php" class="nav-link">
						<!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail link-icon">
							<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
							<polyline points="22,6 12,13 2,6"></polyline>
						</svg> -->
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail link-icon">
							<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
							<line x1="8" y1="12" x2="16" y2="12"></line>
						</svg>
						<span class="menu-title">Expense</span>
						<!-- <i class="link-arrow"></i> -->
					</a>
				</li>
				<!-- <li class="nav-item">
					<a href="Expense_Type.php" class="nav-link">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail link-icon">
							<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
							<line x1="8" y1="12" x2="16" y2="12"></line>
						</svg>
						<span class="menu-title">Expense Type</span>
						
					</a>
				</li> -->
				<li class="nav-item">
					<a href="General_Expense.php" class="nav-link">
						<!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail link-icon">
							<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
							<polyline points="22,6 12,13 2,6"></polyline>
						</svg> -->
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail link-icon">
							<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
							<line x1="8" y1="12" x2="16" y2="12"></line>
						</svg>
						<span class="menu-title">General Expense</span>
						<!-- <i class="link-arrow"></i> -->
					</a>
				</li>
				<!-- <li class="nav-item">
					<a href="Office.php" class="nav-link">
						
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail link-icon">
							<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
							<line x1="8" y1="12" x2="16" y2="12"></line>
						</svg>
						<span class="menu-title">Office</span>
						
					</a>
				</li> -->



				<li class="nav-item mega-menu">

					<a href="#" class="nav-link">
						<svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
							<path d="M10.4 5.6C10.4 4.84575 10.4 4.46863 10.6343 4.23431C10.8686 4 11.2458 4 12 4C12.7542 4 13.1314 4 13.3657 4.23431C13.6 4.46863 13.6 4.84575 13.6 5.6V6.6319C13.9725 6.74275 14.3287 6.8913 14.6642 7.07314L15.3942 6.34315C15.9275 5.80982 16.1942 5.54315 16.5256 5.54315C16.8569 5.54315 17.1236 5.80982 17.6569 6.34315C18.1903 6.87649 18.4569 7.14315 18.4569 7.47452C18.4569 7.80589 18.1903 8.07256 17.6569 8.60589L16.9269 9.33591C17.1087 9.67142 17.2573 10.0276 17.3681 10.4H18.4C19.1542 10.4 19.5314 10.4 19.7657 10.6343C20 10.8686 20 11.2458 20 12C20 12.7542 20 13.1314 19.7657 13.3657C19.5314 13.6 19.1542 13.6 18.4 13.6H17.3681C17.2573 13.9724 17.1087 14.3286 16.9269 14.6641L17.6569 15.3941C18.1902 15.9275 18.4569 16.1941 18.4569 16.5255C18.4569 16.8569 18.1902 17.1235 17.6569 17.6569C17.1236 18.1902 16.8569 18.4569 16.5255 18.4569C16.1942 18.4569 15.9275 18.1902 15.3942 17.6569L14.6642 16.9269C14.3286 17.1087 13.9724 17.2573 13.6 17.3681V18.4C13.6 19.1542 13.6 19.5314 13.3657 19.7657C13.1314 20 12.7542 20 12 20C11.2458 20 10.8686 20 10.6343 19.7657C10.4 19.5314 10.4 19.1542 10.4 18.4V17.3681C10.0276 17.2573 9.67142 17.1087 9.33591 16.9269L8.60598 17.6569C8.07265 18.1902 7.80598 18.4569 7.47461 18.4569C7.14324 18.4569 6.87657 18.1902 6.34324 17.6569C5.80991 17.1235 5.54324 16.8569 5.54324 16.5255C5.54324 16.1941 5.80991 15.9275 6.34324 15.3941L7.07314 14.6642C6.8913 14.3287 6.74275 13.9725 6.6319 13.6H5.6C4.84575 13.6 4.46863 13.6 4.23431 13.3657C4 13.1314 4 12.7542 4 12C4 11.2458 4 10.8686 4.23431 10.6343C4.46863 10.4 4.84575 10.4 5.6 10.4H6.6319C6.74275 10.0276 6.8913 9.67135 7.07312 9.33581L6.3432 8.60589C5.80987 8.07256 5.5432 7.80589 5.5432 7.47452C5.5432 7.14315 5.80987 6.87648 6.3432 6.34315C6.87654 5.80982 7.1432 5.54315 7.47457 5.54315C7.80594 5.54315 8.07261 5.80982 8.60594 6.34315L9.33588 7.07308C9.6714 6.89128 10.0276 6.74274 10.4 6.6319V5.6Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail link-icon" />
							<path d="M14.4 12C14.4 13.3255 13.3255 14.4 12 14.4C10.6745 14.4 9.6 13.3255 9.6 12C9.6 10.6745 10.6745 9.6 12 9.6C13.3255 9.6 14.4 10.6745 14.4 12Z" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail link-icon" />
						</svg>



						<span class="menu-title">Setting</span>


						<i class="link-arrow"></i>
					</a>
					<div class="submenu">
						<div class="col-group-wrapper row">
							<div class="col-group col-md-12">
								<div class="row">
									<div class="col-12">

										<div class="submenu-item">
											<div class="row">
												<div class="col-md-3">
													<ul>
														<li class="nav-item"><a class="nav-link" href="Expense_Type.php">Expense Type</a></li>
													</ul>
												</div>
												<div class="col-md-3">
													<ul>
														<li class="nav-item"><a class="nav-link" href="Office.php">Office</a></li>
													</ul>
												</div>
												<div class="col-md-3">
													<ul>
														<li class="nav-item"><a class="nav-link" href="Category.php">Category</a></li>
													</ul>
												</div>
												<div class="col-md-3">
													<ul>
														<li class="nav-item"><a class="nav-link" href="Group.php">Group</a></li>
													</ul>
												</div>


											</div>
											<div class="row">
												<div class="col-md-3">
													<ul>
														<li class="nav-item"><a class="nav-link" href="bank.php">Bank</a></li>
													</ul>
												</div>
											</div>

										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</li>



				<li class="nav-item mega-menu">

					<a href="#" class="nav-link">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-feather link-icon">
							<path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z"></path>
							<line x1="16" y1="8" x2="2" y2="22"></line>
							<line x1="17.5" y1="15" x2="9" y2="15"></line>
						</svg>

						<span class="menu-title">Employee</span>


						<i class="link-arrow"></i>
					</a>
					<div class="submenu">
						<div class="col-group-wrapper row">
							<div class="col-group col-md-12">
								<div class="row">
									<div class="col-12">
										<!-- <p class="category-heading">Basic</p> -->
										<div class="submenu-item">
											<div class="row">
												<div class="col-md-4">
													<ul>
														<li class="nav-item"><a class="nav-link" href="pages/ui-components/alerts.html">Employee</a></li>
														<li class="nav-item"><a class="nav-link" href="pages/ui-components/badges.html">Designation</a></li>

													</ul>
												</div>
												<div class="col-md-4">
													<ul>
														<li class="nav-item"><a class="nav-link" href="pages/ui-components/breadcrumbs.html">Department</a></li>
														<li class="nav-item"><a class="nav-link" href="pages/ui-components/buttons.html">Task</a></li>

													</ul>
												</div>
												<div class="col-md-4">
													<ul>
														<li class="nav-item"><a class="nav-link" href="pages/ui-components/button-group.html">Attendance</a></li>
														<li class="nav-item"><a class="nav-link" href="pages/ui-components/cards.html">Salary</a></li>
													</ul>
												</div>


											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</li>
				
				<li class="nav-item">
					<a href="Summary.php" class="nav-link">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail link-icon">
							<path d="M16.6472 4.2755C18.3543 3.89891 19.8891 3.97968 20.8292 4.10203C20.8592 4.10592 20.8911 4.11927 20.9256 4.16303C20.9637 4.21127 21 4.29459 21 4.40561V17.5662C21 17.8531 20.7538 18.0756 20.4978 18.0671C19.2792 18.027 17.4886 18.0635 15.7992 18.4717C14.6384 18.7522 13.7101 19.2206 13 19.7021V6.46564C13 6.22541 13.0548 6.10361 13.0945 6.05233C13.2183 5.89268 13.5973 5.55172 14.2498 5.18356C14.8798 4.82813 15.7 4.48446 16.6472 4.2755ZM21.0873 2.11876C19.9976 1.97693 18.2169 1.88113 16.2164 2.32246C15.0613 2.57728 14.0561 2.99648 13.2671 3.44169C12.5005 3.87417 11.8669 4.37162 11.514 4.82683C11.1078 5.35069 11 5.96564 11 6.46564V22C11 22.4411 11.289 22.83 11.7112 22.9574C12.1314 23.0841 12.5849 22.922 12.8297 22.5583L12.8315 22.5555L12.8304 22.5572L12.8297 22.5583C12.8297 22.5583 12.831 22.5564 12.8322 22.5546C12.8365 22.5485 12.8455 22.536 12.8591 22.5178C12.8864 22.4814 12.9324 22.4224 12.9974 22.3467C13.1277 22.195 13.3329 21.9779 13.6163 21.7398C14.1824 21.2641 15.0549 20.7091 16.269 20.4158C17.7048 20.0688 19.2899 20.0284 20.4319 20.066C21.8117 20.1115 23 18.9895 23 17.5662V4.40561C23 3.34931 22.2946 2.27587 21.0873 2.11876Z" />
							<path fill-rule="evenodd" clip-rule="evenodd" d="M7.35275 4.2755C5.64572 3.89891 4.11089 3.97968 3.17076 4.10203C3.14084 4.10592 3.10885 4.11927 3.07437 4.16303C3.03635 4.21127 3 4.29459 3 4.40561V17.5662C3 17.8531 3.24619 18.0756 3.50221 18.0671C4.72076 18.027 6.51143 18.0635 8.20077 18.4717C9.36161 18.7522 10.2899 19.2206 11 19.7021V6.46564C11 6.22541 10.9452 6.10361 10.9055 6.05233C10.7817 5.89268 10.4027 5.55172 9.75015 5.18356C9.12019 4.82813 8.29995 4.48446 7.35275 4.2755ZM2.91265 2.11876C4.00241 1.97693 5.78311 1.88113 7.78361 2.32246C8.9387 2.57728 9.94388 2.99648 10.7329 3.44169C11.4995 3.87417 12.1331 4.37162 12.486 4.82683C12.8922 5.35069 13 5.96564 13 6.46564V22C13 22.4411 12.711 22.83 12.2888 22.9574C11.8686 23.0841 11.4151 22.922 11.1703 22.5583L11.1685 22.5555L11.1696 22.5572L11.1703 22.5583C11.1703 22.5583 11.169 22.5564 11.1678 22.5546C11.1635 22.5485 11.1545 22.536 11.1409 22.5178C11.1136 22.4814 11.0676 22.4224 11.0026 22.3467C10.8723 22.195 10.6671 21.9779 10.3837 21.7398C9.81759 21.2641 8.94511 20.7091 7.73105 20.4158C6.2952 20.0688 4.71011 20.0284 3.56807 20.066C2.18834 20.1115 1 18.9895 1 17.5662V4.40561C1 3.34931 1.70543 2.27587 2.91265 2.11876Z"></path>
							<!-- <polyline points="22,6 12,13 2,6"></polyline> -->
						</svg>

						<span class="menu-title">Summary</span>
						<!-- <i class="link-arrow"></i> -->
					</a>
				</li>
				<li class="nav-item">
					<a href="Outstanding.php" class="nav-link">
						<!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail link-icon">
							<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
							<polyline points="22,6 12,13 2,6"></polyline>
						</svg> -->
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail link-icon">
							<path d="M18.04 13.55C17.62 13.96 17.38 14.55 17.44 15.18C17.53 16.26 18.52 17.05 19.6 17.05H21.5V18.24C21.5 20.31 19.81 22 17.74 22H7.63C7.94 21.74 8.21 21.42 8.42 21.06C8.79 20.46 9 19.75 9 19C9 16.79 7.21 15 5 15C4.06 15 3.19 15.33 2.5 15.88V11.51C2.5 9.44 4.19 7.75 6.26 7.75H17.74C19.81 7.75 21.5 9.44 21.5 11.51V12.95H19.48C18.92 12.95 18.41 13.17 18.04 13.55Z"></path>
							<path d="M2.5 12.41V7.84C2.5 6.65 3.23 5.59 4.34 5.17L12.28 2.17C13.52 1.7 14.85 2.62 14.85 3.95V7.75"></path>
							<path d="M22.56 13.97V16.03C22.56 16.58 22.12 17.03 21.56 17.05H19.6C18.52 17.05 17.53 16.26 17.44 15.18C17.38 14.55 17.62 13.96 18.04 13.55C18.41 13.17 18.92 12.95 19.48 12.95H21.56C22.12 12.97 22.56 13.42 22.56 13.97Z"></path>
							<path d="M7 12H14"></path>
							<path d="M9 19C9 19.75 8.79 20.46 8.42 21.06C8.21 21.42 7.94 21.74 7.63 22C6.93 22.63 6.01 23 5 23C3.54 23 2.27 22.22 1.58 21.06C1.21 20.46 1 19.75 1 19C1 17.74 1.58 16.61 2.5 15.88C3.19 15.33 4.06 15 5 15C7.21 15 9 16.79 9 19Z"></path>
							<path d="M6.49 18.98H3.51"></path>
							<path d="M5 17.52V20.51"></path>
						</svg>
						<span class="menu-title">Outstanding</span>
						<!-- <i class="link-arrow"></i> -->
					</a>
				</li >
				<li class="nav-item">
				 <a href="chartOfAccount.php" class="nav-link">
					<!-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail link-icon">
							<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
							<polyline points="22,6 12,13 2,6"></polyline>
						</svg> -->
					<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail link-icon">
						<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
						<line x1="8" y1="12" x2="16" y2="12"></line>
					</svg>
					<span class="menu-title">Chart Of Account</span>
					<!-- <i class="link-arrow"></i> -->
				 </a>
				</li>
				<li class="nav-item mega-menu">

					<a href="#" class="nav-link">
						<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-feather link-icon">
							<path d="M20.24 12.24a6 6 0 0 0-8.49-8.49L5 10.5V19h8.5z"></path>
							<line x1="16" y1="8" x2="2" y2="22"></line>
							<line x1="17.5" y1="15" x2="9" y2="15"></line>
						</svg>

						<span class="menu-title">Voucher</span>


						<i class="link-arrow"></i>
					</a>
					<div class="submenu">
						<div class="col-group-wrapper row">
							<div class="col-group col-md-12">
								<div class="row">
									<div class="col-12">
										<!-- <p class="category-heading">Basic</p> -->
										<div class="submenu-item">
											<div class="row">
												<div class="col-md-4">
													<ul>
														<li class="nav-item"><a class="nav-link" href="Vouchers.php">Voucher</a></li>
													</ul>
												</div>
												<div class="col-md-4">
													<ul>
													<li class="nav-item"><a class="nav-link" href="voucheraudit.php">Voucher Audit</a></li>
													</ul>
												</div>
											</div>
										</div>
									</div>
								</div>
							</div>

						</div>
					</div>
				</li>
				<li class="nav-item">
					<a href="Logout.php" class="nav-link">
						<svg xmlns="http://www.w3.org/2000/svg" style="color:red;border-left:1px solid red;padding-left: 3px;font-weight:600" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-mail link-icon">
							<path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
							<polyline points="22,6 12,13 2,6"></polyline>
						</svg>
						<span class="menu-title " style="color:red;font-weight:600">Logout</span>
						<!-- <i class="link-arrow"></i> -->
					</a>
				</li>

			</ul>
		</div>
	</nav>
</div>
<div class="page-wrapper">