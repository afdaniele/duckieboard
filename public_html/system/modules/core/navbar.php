<?php

// get pages
$pages_list = \system\classes\Core::getPagesList();

// get info about the current user
$user_role = \system\classes\Core::getUserRole();

// define responsive parameters
$responsive_min_width = 700;
$responsive_width_per_button = 80;

// assign limit widths to the responsive buttons
$buttons = $pages_list['by-responsive-priority'];
$responsive_buttons = [];
$responsive_current_width = $responsive_min_width;
foreach ($buttons as &$button) {
	if( $button['menu_entry']['responsive']['priority'] >= 0 ){
		$responsive_current_width += $responsive_width_per_button;
		$responsive_buttons[ $button['id'] ] = $responsive_current_width;
	}
}
?>

<nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
	<div style="padding-right:30px">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="<?php echo \system\classes\Configuration::$BASE ?>" style="padding-right:0"><b><?php echo \system\classes\Configuration::$SHORT_SITE_NAME ?></b></a>
		</div>
		<div id="navbar" class="collapse navbar-collapse">

			<ul class="nav navbar-nav navbar-right">

				<?php
				$pages = $pages_list['by-menuorder'];
				// create buttons
				for ($i = 0; $i < count($pages); $i++) {
					$is_last = boolval( $i == count($pages)-1 );
					$elem = $pages[$i];
					if( !in_array($user_role, $elem['access']) ){
						continue;
					}
					$icon = sprintf('%s %s-%s', $elem['menu_entry']['icon']['type'], $elem['menu_entry']['icon']['type'], $elem['menu_entry']['icon']['name']);
					//
					?>
					<li class="<?php echo (isset($responsive_buttons[$elem['id']]))? 'navbar-'.$responsive_buttons[$elem['id']].'-full-button-component' : '' ?>
						<?php if(\system\classes\Configuration::$PAGE == $elem['id']) echo 'active'?>" >
						<a href="<?php echo \system\classes\Configuration::$BASE . $elem['id'] ?>">
							<span class="<?php echo $icon ?>" aria-hidden="true"></span> &nbsp;
							<?php echo $elem['name'] ?>
						</a>
					</li>
					<?php
					if( !$is_last ){
						?>
						<li style="width:2px">&nbsp;</li>
						<?php
					}
				}
				?>

				<!-- Responsive navbar -->
				<li class="dropdown navbar-<?php echo $responsive_current_width ?>-responsive-button-component">
					<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
						<span class="glyphicon glyphicon-chevron-down" aria-hidden="true" style="margin-top:2px"></span>
					</a>
					<ul class="dropdown-menu" role="menu">
						<?php
						foreach ($responsive_buttons as $id => $width) {
							$elem = $pages_list['by-id'][$id];
							$icon = sprintf('%s %s-%s', $elem['menu_entry']['icon']['type'], $elem['menu_entry']['icon']['type'], $elem['menu_entry']['icon']['name']);
							?>
							<li class="navbar-<?php echo $width ?>-responsive-button-component">
								<a href="<?php echo \system\classes\Configuration::$BASE . $id ?>">
									<span class="<?php echo $icon ?>" aria-hidden="true"></span> &nbsp;
									<?php echo $elem['name'] ?>
								</a>
							</li>
							<?php
						}
						?>
					</ul>
				</li>

				<?php
				// Add LogOut button if the user is logged in
				if( \system\classes\Core::isUserLoggedIn() ){
					?>
					<li style="width:26px; text-align:center; color:white; margin-top:15px; margin-left: 15px">
						&nbsp;&bull;&nbsp;
					</li>

					<li>
						<a class="cursor-pointer"
						   onclick="userLogOut('<?php echo \system\classes\Configuration::$BASE ?>', '<?php echo \system\classes\Configuration::$BASE_URL ?>', '<?php echo \system\classes\Configuration::$WEBAPI_VERSION ?>', '<?php echo $_SESSION['TOKEN'] ?>');"
						   style="color:#ffc864; padding-right:0">
							<span class="glyphicon glyphicon-log-out" aria-hidden="true"></span> &nbsp;Log out
						</a>
					</li>
				<?php
				}
				?>

			</ul>
		</div><!--/.nav-collapse -->
	</div>
</nav>


<script type="text/javascript">
	$(window).resize(function () {
		_resize_navbar();
	});

	$(document).ready(function () {
		_resize_navbar();
	});

	function _resize_navbar(){
		<?php
		foreach ($responsive_buttons as $id => $width) {
			?>
			if( window.innerWidth < <?php echo $width ?> ){
				$('#navbar').find('.navbar-<?php echo $width ?>-full-button-component').each(function(){
					$(this).css('display', 'none');
				});
				//
				$('#navbar').find('.navbar-<?php echo $width ?>-responsive-button-component').each(function(){
					$(this).css('display', '');
				});
			}else{
				$('#navbar').find('.navbar-<?php echo $width ?>-full-button-component').each(function(){
					$(this).css('display', '');
				});
				//
				$('#navbar').find('.navbar-<?php echo $width ?>-responsive-button-component').each(function(){
					$(this).css('display', 'none');
				});
			}
			<?php
		}
		?>
	}//_resize_navbar

</script>