<div class="personal-profile text-center d-none d-lg-block">
    <img src="<?php echo $image; ?>" class="rounded-circle" width="100" height="100">
    <b class="d-block mt-2"><?php echo $name; ?></b>
    <p class="text-muted m-0"><?php echo $filliere; ?></p>
    <p class="text-muted m-0">Groupe <?php echo $groupe; ?></p>
    <div class="media-icons mt-1">
        <a href="mailto:<?php echo $email; ?>" class="ml-2 <?php echo $email ? '' : 'empty-search' ?>">
            <i class="fa fa-envelope"></i>
        </a>
        <a href="<?php echo $facebook; ?>" target="_blank" class="ml-2 <?php echo $facebook ? '' : 'empty-search' ?>">
            <i class="fa fa-facebook"></i>
        </a>
        <a href="<?php echo $whatsapp; ?>" target="_blank" class="ml-2 <?php echo $whatsapp ? '' : 'empty-search' ?>">
            <i class="fa fa-whatsapp"></i>
        </a>
        
    </div>					
</div>

<!-- Mobile Profile Info -->
<div class="personal-profile mx-auto d-flex d-lg-none align-items-center">
    <img src="<?php echo $image; ?>" class="rounded-circle" width="70" height="70">
    <div class="ml-3">
        <b class="d-block mt-2"><?php echo $name; ?></b>
        <p class="text-muted m-0"><?php echo $filliere; ?></p>
        <p class="text-muted m-0">Groupe <?php echo $groupe; ?></p>
        <div class="media-icons">
            <a href="" class="<?php echo $email ? '' : 'empty-search' ?>">
                <i class="fa fa-envelope"></i>
            </a>
            <a href="" class="ml-2 <?php echo $facebook ? '' : 'empty-search' ?>">
                <i class="fa fa-facebook"></i>
            </a>
            <a href="" class="ml-2 <?php echo $whatsapp ? '' : 'empty-search' ?>">
                <i class="fa fa-whatsapp"></i>
            </a>
            
        </div>
    </div>
</div>