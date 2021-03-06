<!DOCTYPE html>
<html>
	<head lang="fr">
		<base href="<?php echo DIRECTORY; ?>/">
        <link rel="stylesheet" href="<?php echo DIRNAME ;?>/assets/css/dist/style.css">
		<meta charset="UTF-8">
		<?php
			if(!$settings = Module\Entity\Parametre::findOneBy(['id' => 1])) {
				$settings = new Module\Entity\Parametre();
			}
		?>
		<title><?php echo $settings->getTitre() ? $settings->getTitre() : "No title"; ?></title>
		
		<?php if($settings->getDescription()): 
			echo '<meta name="description" content="'.html_entity_decode(strip_tags( $settings->getDescription() )).'"/>';
		endif; ?>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
	</head>
	<body>	
	<div id="site" class="flex-wrapper h-auto">
		<header class="header">
				<div class="banner">
					<div class="banner-content">
						<?php 
						if($settings->getImage()): ?>
							<a href="<?php echo path('site'); ?>"><?php echo renderImg($settings->getImage(), 'logo'); ?></a>
						<?php endif; ?>
						<h1 class='banner-title'><?php echo $settings->getTitre(); ?></h1>
						<?php if($settings->getSoustitre()) echo "<h2 class='banner-subtitle'>".$settings->getSoustitre()."</h2>"; ?>						
						<div class='banner-social'>
							<?php
								if($settings->getFacebook()) echo '<a href="'.$settings->getFacebook().'" target="_blank" rel="nofollow"><i class="fab fa-facebook-square"></i></a>';
								if($settings->getLinkedin()) echo '<a href="'.$settings->getLinkedin().'" target="_blank" rel="nofollow"><i class="fab fa-linkedin"></i></a>';
								if($settings->getTwitter()) echo '<a href="'.$settings->getTwitter().'" target="_blank" rel="nofollow"><i class="fab fa-twitter-square"></i></a>';
								if($settings->getInstagram()) echo '<a href="'.$settings->getInstagram().'" target="_blank" rel="nofollow"><i class="fab fa-instagram"></i></a>';
								if(file_exists('rss-article.xml')) echo '<a href="rss-article.xml" target="_blank" rel="nofollow"><i class="fas fa-rss-square"></i></a>'
							?>
						</div>
					</div>
				</div>
				<nav class="navbar">
					<div class="left">
						<?php
							if($pageZero = Module\Entity\Page::find(['active' => 1, 'inmenu' => 1, 'id_parent' => null])) {
								$pages= [];
								foreach ($pageZero as $page) {
									$pages[$page->getId()]['page'] = $page;
									if($childs = Module\Entity\Page::find(['active' => 1, 'inmenu' => 1, 'id_parent' => $page->getId()])) {
										$pages[$page->getId()]['childs'] = $childs;
									}
								}
								if(sizeof($pages) > 0): 
									echo "<ul class='main-menu'>";
									foreach ($pages as $page) :
										$url = path($page['page']->getType(), ['url' => $page['page']->getUrl()]);
										if($page['page']->getProtected()) $url = path($page['page']->getType());
										echo '<li>';
										echo '<a href="'.$url.'" '.($_SERVER['CURRENT_ROUTE']['name'] === $page['page']->getType() ? 'class="selected"' : '').' >'.$page['page']->getTitre().'</a>';
										if(isset($page['childs'])) {
											echo '<ul>';
											foreach ($page['childs'] as $child) {
												$urlChild = path($child->getType(), ['url' => $child->getUrl()]);
												echo '<li>';
													echo '<a href="'.$urlChild.'" '.($_SERVER['CURRENT_ROUTE']['name'] === $child->getType() ? 'class="selected"' : '').' >'.$child->getTitre().'</a>';
												echo '</li>';
											}
											echo '</ul>';
										}
										echo '</li>';
									endforeach;
									echo "<ul>";
								endif; 
							}
					?>
					</div>
					<div class="right">
						<?php if( isset($_SESSION[PREFIX."user"])) : ?>
							<span>Bonjour <?php echo $_SESSION[PREFIX."user"]['prenom']; ?></span>
							<?php if(isGranted(ROLE_ADMINISTRATEUR) || isGranted(ROLE_MODERATEUR)): ?>
								<a href="<?php echo path('dashboard'); ?>">Administration</a>
							<?php endif; ?>
							<a href="<?php echo path('deconnexion'); ?>" class="selected">Déconnexion</a>
						<?php else : ?>
							<a href="<?php echo path('inscription'); ?>">Inscription</a>
							<a href="<?php echo path('connexion'); ?>" class="selected">Connexion</a>
						<?php endif; ?>
					</div>
				</nav>
		</header>
		<div class="content">
			<div class="container-grid">
				<?php include(TPL.$tpl); ?>
			</div>
		</div>
	</div>
	<footer>
		<div class="container-grid text-right">
			<?php if($mention = Module\Entity\Page::findOneBy(['url' => 'mentions-legales'])) : 
				$url = path($mention->getType(), ['url' => $mention->getUrl()]);
				?>
				<a href="<?php echo $url; ?>">Mentions légales</a> | 
			<?php endif; ?>
			<?php if(file_exists('sitemap.xml')): ?>
				<a href="sitemap.xml" target="_blank">Plan du site</a> | 
			<?php endif; ?>
			<a>Powered by Creative Drawer©</a>
		</div>
	</footer>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="js/index-site.js"></script>	
	</body>
</html>