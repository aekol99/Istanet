<div class="row justify-content-center">
    <div class="col-12 d-flex justify-content-center align-items-center">
        <img src="<?php echo 'storage/images/' . $profileImage ?>" width="70" height="70" class="rounded-circle">
        <div class="d-flex flex-column ml-3">
            <span class="text-capitalize"><b><?php echo $userName ?></b></span>
            <span>Filiere : <?php echo $filliere ?></span>
            <span>Groupe : <?php echo $groupe ?></span>
        </div>
    </div>
    <div class="col-12 d-flex flex-column mt-4 mt-lg-3 px-4">
        <span><b>Facebook</b> : <br><?php echo $facebook ? $facebook : 'n/a'; ?></span>
        <span class="mt-2"><b>Whatsapp</b> : <br><?php echo $whatsapp ? $whatsapp : 'n/a'; ?></span>
        <span class="mt-2"><b>Email</b> : <br><?php echo $email ?  $email : 'n/a'; ?></span>
    </div>
</div>
