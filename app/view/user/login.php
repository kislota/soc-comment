<div class="starter-template">
    <h1>Для входа нажмите на нужную социальную сеть</h1>
    <?php foreach ($socials as $key => $social):?>
        <a href="<?php echo $social; ?>" class="btn btn-primary btn-lg active"
           role="button"><?php echo ucfirst($key);?></a>
    <?php endforeach;?>
</div>