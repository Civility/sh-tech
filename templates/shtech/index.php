<?php defined('_JEXEC') or die;
include_once JPATH_THEMES . '/' . $this->template . '/libs/unsets.php';
include_once JPATH_THEMES . '/' . $this->template . '/libs/logic.php';
?>
<!doctype html>

<html lang="<?=$this->language; ?>" dir="<?=$this->direction; ?>">
<head>
	<jdoc:include type="head" />
	
	<!-- <script src="http://code.jquery.com/jquery-3.3.1.min.js"></script> -->
</head>

<body class="<?=(($menu->getActive() == $menu->getDefault()) ? ('front') : ('site')).' '.$active->alias.''.$pageclass;?>">
	<!-- Body -->
	<div class="wrapper">
		<!-- Header -->
		<header id="header" class="fixed-top header">
			<div class="container">
				<div class="row no-gutters">
					<!-- logo + menu-catalog -->
					<div class="col-lg-2 col-5">
						<div class="pos-a">
							<a class="navbar-brand logo-<?=$active->alias;?>" href="<?=JURI::base(TRUE); ?>">
								<img src="<?=$tpath.'/images/logo.svg';?>" alt="SHTECH" class="img-fluid">
							</a>
							<nav class="navbar header-bottom d-none d-lg-block p-0">
								<div class="menu-catalog">
									<button class="navbar-toggler w-100 d-flex justify-content-around align-items-center" type="button" data-toggle="collapse" data-target="#catalogNavbar" aria-controls="catalogNavbar" aria-expanded="false" aria-label="Toggle navigation">
										<h3 class="navbar-text"><?=JText::_('CATALOG');?></h3><span class="check"></span>
									</button>		
									<div class="collapse navbar-collapse text-left" id="catalogNavbar">
										<jdoc:include type="modules" name="menu-catalog" style="mi5" />
									</div>	
								</div>
							</nav>
						</div>
					</div>
					<div class="col-12 col-lg-10 offset-0 offset-lg-2 py-2">
						<!-- menu-main -->
						<nav class="navbar navbar-expand-lg menu-main">
							<h1 class="slogan"><?=JText::_('SLOGAN');?></h1>
							<div id="form-popup" class="white-popup mfp-hide container">
								<div class="row">
									<div class="col-12 col-lg-10 offset-0 offset-lg-2 bg-white py-4">
										<jdoc:include type="modules" name="contactMail" style="clear" />									
									</div>
								</div>
							</div>
							<div class="collapse navbar-collapse phone-mail" id="mainNavbar">
								<?php if ($this->countModules('contact')) : ?>
										<jdoc:include type="modules" name="contact" style="clear" />
								<?php endif; ?>		
								<button type="button" class="btn btn-link" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
									<a href="#form-popup" class="popup-form">
										<svg id="envelope" width="26" height="26" data-name="Слой 1" xmlns="http://www.w3.org/2000/svg" viewbox="0 0 71.96 72.47"><defs></defs> 
										<title>Форма обратной связи</title>
										<path class="cls-1" d="M73.44,22.67l-36-21.24L1.5,22.67h0V73.9h72V22.66ZM70.65,71.1H4.29V28L37.47,48.65,70.65,28ZM37.47,44.89,4.41,24.47,37.47,5.19,70.53,24.47Z" transform="translate(-1.49 -1.43)"></path><polygon class="cls-1" points="23.49 20.45 23.49 24.12 35.98 31.5 48.47 24.12 48.47 20.45 35.98 27.73 23.49 20.45"></polygon>
										</svg>
									</a>
								</button>
							</div>
							<button class="navbar-toggler " type="button" data-toggle="collapse" data-target="#mainNavbar" aria-controls="mainNavbar" aria-expanded="false" aria-label="navigation">
								<span class="navbar-toggler-icon">
								<svg version="1.1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 25 25" xmlns:xlink="http://www.w3.org/1999/xlink" enable-background="new 0 0 25 25">
									<g>
										<path d="M24,3c0-0.6-0.4-1-1-1H1C0.4,2,0,2.4,0,3v2c0,0.6,0.4,1,1,1h22c0.6,0,1-0.4,1-1V3z"/>
										<path d="M24,11c0-0.6-0.4-1-1-1H1c-0.6,0-1,0.4-1,1v2c0,0.6,0.4,1,1,1h22c0.6,0,1-0.4,1-1V11z"/>
										<path d="M24,19c0-0.6-0.4-1-1-1H1c-0.6,0-1,0.4-1,1v2c0,0.6,0.4,1,1,1h22c0.6,0,1-0.4,1-1V19z"/>
									</g>
								</svg>	
								</span>
							</button>
							
							<div class="main-menu collapse navbar-collapse my-3 order-lg-2 order-3" id="mainNavbar">
								<jdoc:include type="modules" name="menu-main" style="mi5" />
							</div>

							<?php if ($this->countModules('search')) : ?>
								<form class="col form-inline">
									<input class="form-control" type="text" placeholder="Поиск">
									<!-- <button class="btn btn-outline-success" type="submit">Search</button> -->
									<jdoc:include type="modules" name="search" style="mi5" />
								</form>
							<?php endif; ?>


						</nav>
					</div>
				</div>
			</div>
		</header>
		<?php if ($this->countModules('show')) : ?>	
		<!-- Show -->	
		<section class="showing mb-4">
			<jdoc:include type="modules" name="show" style="mi5" />
		<?php /*if (JRequest::getInt('Itemid') == 101) : ?>
			<?php //условие ?>
		<?php endif; */?>
	</section>
<?php endif; ?>

<?php if ($this->countModules('catalogs')) : ?>
	<section class="catalogs mb-4">
		<div class="container">
			<jdoc:include type="modules" name="catalogs" style="mi5" />
		</div>
	</section>
<?php endif; ?>
<!-- MAIN -->
<main id="main" class="main mb-4">
	<div class="container">
		<div class="row">
			<?php if ($this->countModules('breadcrumbs')) : ?>
				<jdoc:include type="modules" name="breadcrumbs" style="mi5" />
			<?php endif; ?>
				<?php //не выводить главный компонент на 1 странице
				if ($menu->getActive()->id != $menu->getDefault()->id) : ?>
					<div class="component <?php if ($menu->getActive()->id != $menu->getDefault()->id) : ?>col-12 col-lg-10 offset-0 offset-lg-2<?php endif; ?>">
						<jdoc:include type="message"/>
						<jdoc:include type="component"/>
						<?php if ($this->countModules('main')) : ?>
							<jdoc:include type="modules" name="main" style="mi5" />
						<?php endif; ?>						
					</div>
				<?php endif; ?>
				<?php if ($this->countModules('events')) : ?>
					<jdoc:include type="modules" name="events" style="mi5" />
				<?php endif; ?>	
				<?php if ($this->countModules('aside')) : ?>
					<aside class="aside col-8 d-none d-lg-flex">
						<div class="row">
							<jdoc:include type="modules" name="aside" style="mi5" />
						</div>
					</aside>
				<?php endif; ?>
			</div>				
		</div>
	</main>
	<!-- Footer -->
	<footer id="footer" class="footer">
		<div class="container py-4">
			<div class="row">
				<div class="d-none d-lg-flex col-lg-2 col flex-lg-column justify-content-lg-between">
					<a class="navbar-brand logo" href="<?=JURI::base(TRUE); ?>">
						<img src="<?=$tpath.'/images/logo.svg';?>" alt="SHTECH" class="img-fluid">
					</a>
					<div class="copy">
						&copy; <?=date('Y'); ?> <?=$sitename; ?>
					</div>
				</div>
				<div class="col">
					<div class="row no-gutters">
						<div class="d-none d-xl-block col-xl-2 col py-2">
							<h4 class="title"><?=JText::_('ONSITE');?></h4>
						</div>
						<div class="d-none d-lg-block col-lg-7 col-xl-5 offset-0 offset-xl-1 col py-2">
							<h4 class="title"><?=JText::_('PRODUCTS');?></h4>
						</div>
						<?php if ($this->countModules('contactus')) : ?>
							<div class="col-12 col-lg-5 col-xl-3 offset-0 offset-xl-1 py-2">
								<h4 class="title"><?=JText::_('CONTACTUS');?></h4>
							</div>
						<?php endif; ?>
					</div>
					<div class="row no-gutters">
						<div class="d-none d-xl-block col-xl-2 col border-top border-bottom border-white py-2">
							<jdoc:include type="modules" name="menu-main" style="clear" />
						</div>
						<div class="d-none d-lg-block col-lg-7 col-xl-5 offset-0 offset-xl-1 col border-top border-bottom border-white py-2">
							<jdoc:include type="modules" name="menu-footer-catalog" style="clear" />	
						</div>
						<?php if ($this->countModules('contactus')) : ?>	
							<div class="col-12 col-lg-5 col-xl-3 offset-0 offset-xl-1 border-top border-bottom border-white py-2">
								<div class="contactus">
									<jdoc:include type="modules" name="contactus" style="clear" />
								</div>

							</div>
						<?php endif; ?>
					</div>
				</div>	
			</div>
			<?php if ($this->countModules('mapsite') || $this->countModules('toptop')) : ?>
			<div class="row">
				<?php if ($this->countModules('mapsite')) : ?>
					<div class="col offset-2">
						<jdoc:include type="modules" name="mapsite" style="clear" />
					</div>
				<?php endif; ?>
				<?php if ($this->countModules('toptop')) : ?>
					<div class="col">
						<jdoc:include type="modules" name="toptop" style="clear" />
					</div>
				<?php endif; ?>
			</div>
		<?php endif; ?>
	</div>
</footer>
</div>
<!-- END Body-->
<?php //include_once (JPATH_ROOT.'/templates/'.$app->getTemplate().'/render.php'); ?>
<script src="/templates/<?php echo $this->template ?>/js/app.js"></script>
<script src="/templates/<?php echo $this->template ?>/js/themes.js"></script> 
<?php 
?>
<jdoc:include type="modules" name="debug" style="clear" />
</body>
</html>