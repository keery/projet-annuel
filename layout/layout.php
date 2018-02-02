<!DOCTYPE html>
<html lang="fr">
	<head>
		<meta charset="UTF-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1.0">
		<base href="<?php echo DIRNAME.DS; ?>" />
		<link rel="stylesheet" href="css/dist/style.css">
		<title>Creative </title>		
	</head>
	<body>
		<header>
			<nav class="container">
				<ul>
					<li>
						<a href="<?php // path('contact') ?>">test</a>
					</li>
					<li>
						<a href="<?php // path('article', ['id' => 1]) ?>">Article numero 1</a>	
					</li>
				</ul>
			</nav>
		</header>
		<?php include(TPL.$tpl); ?>
		<footer>
			
		</footer>
	</body>
</html>