<div id="fb-root"></div>
<script>(function(d, s, id) {
var js, fjs = d.getElementsByTagName(s)[0];
if (d.getElementById(id)) return;
js = d.createElement(s); js.id = id;
js.src = 'https://connect.facebook.net/fr_FR/sdk.js#xfbml=1&version=v3.0';
fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<script src="//platform.linkedin.com/in.js" type="text/javascript"> lang: fr_FR</script>
<div>
    <article class="article col-sm-8">
      <div class="header">
        <h1><?php echo $article->getTitre(); ?></h1>
      </div>
      <div class="u-pd--m relative">
        <?php foreach(getNotifs('valid') as $notif) : ?>
            <div class="notif valid">
                <span class="notif-icone"></span>
                <div class="notif-titre">Réussi:</div>
                <?php echo $notif; ?>
            </div>
        <?php endforeach; ?>
        <?php foreach(getNotifs('error') as $notif) : ?>
            <div class="notif error">
                <span class="notif-icone"></span>
                <div class="notif-titre">Erreur:</div>
                <?php echo $notif; ?>
            </div>
        <?php endforeach; ?>
        
        <div class="action-article">
            <?php if(isGranted(ROLE_UTILISATEUR)): ?>
                <span class="relative display-ib">
                    <i class="fas fa-thumbs-up <?php echo ($rel && $rel->getVote() == "like" ? 'active' : "" ); ?>" data-article="<?php echo $idarticle; ?>" title="J'aime"></i>
                    <b class="round-badge"><?php echo $like; ?></b>
                </span>
                <span class="relative display-ib">
                    <i class="fas fa-thumbs-down <?php echo ($rel && $rel->getVote() == "dislike" ? 'active' : "" ); ?>" data-article="<?php echo $idarticle; ?>" title="Je n'aime pas"></i>
                    <b class="round-badge"><?php echo $dislike; ?></b>
                </span>
            <?php endif; ?>            
            <div class="fb-share-button" 
                data-href="<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REDIRECT_URL']; ?>" 
                data-layout="button_count">
            </div>
            <script type="IN/Share" data-url="<?php echo $_SERVER['SERVER_NAME'].$_SERVER['REDIRECT_URL']; ?>"></script>
        </div>
        <?php if($article->getAuteur()) echo "<i class='author'>Oeuvre de ".$article->getAuteur()."</i>"; ?>
        <?php if($article->getDescription()) echo "<p>".$article->getDescription()."</p>"; ?>
      </div>
      <?php if(count($article->getImages()) > 0): ?>
        <div class="text-center spacing">
            <?php $imgs = $article->getImages();
                sortObjects($imgs, 'getPosition'); ?>
            <?php foreach($imgs as $img): ?>
                <div class="img-container">
                    <?php echo renderImg($img); ?>
                    <?php if ($img->getPosition()): ?>
                        <div class="badge-position">
                            <?php echo $img->getPosition(); ?>                  
                        </div>
                    <?php endif; ?>
                </div>                
            <?php endforeach; ?>
        </div>
      <?php endif; ?>
      <?php if( sizeof($commentaires) > 0): ?>
        <div class="spacing spacing-v">
        <?php foreach($commentaires as $comm) : ?>
            <div class="comm">
                <?php 
                    $img = IMG."user.png";
                    $class="noimg";
					if($imgUser = $comm->getUser()->getImage()) {
                        $img = UPLOAD.$imgUser->getSrc();
                        $class="";
                    }
				?>
                <div class="info-comm author">
                    <span class='badge-photo <?php echo $class; ?>' style="background-image: url(<?php echo $img; ?>)"></span>
                    <?php echo date_publication($comm->getPublication()) ?> par <?php echo $comm->getUser()->getPrenom() . " " . $comm->getUser()->getNom()[0]."."; ?></div>
                <?php echo $comm->getCommentaire(); ?>
            </div>
        <?php endforeach; ?>
        </div>
      <?php endif; ?>
      <div class="post-comm">
        <?php if(isGranted(ROLE_UTILISATEUR)): ?>
            <div class="spacing spacing-v">
                <?php $form->form_head(); ?>
                    <div><?php echo $form->label('commentaire'); ?></div>
                    <?php echo $form->input('commentaire', ['class' => 'select full comm-field']); ?>
                    <?php echo $form->input('submit', ['class' => 'button btn-validate full']); ?>
                <?php $form->form_bottom(); ?>
            </div>
        <?php else: ?>
            <div class="spacing spacing-v">
                <div class="notif information full">
                    <span class="notif-icone"></span>
                    <div class="notif-titre">Info:</div>
                    <div>Si vous souhaitez commenter ou réagir à cette oeuvre, il est nécessaire d'être <a href="<?php echo path('connexion'); ?>">connecté</a>.</div>
                    <div>Vous pouvez vous inscrire en cliquant <a href="<?php echo path('inscription'); ?>">ici</a></div>
                </div>
            </div>
        <?php endif; ?>
      </div>
      <div class="spacing text-right spacing-v">
        <a href="<?php echo path("oeuvre"); ?>" class="button inv">Retour à la liste</a>
      </div>
    </article>
</div>