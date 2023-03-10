<form action="actions/setting.php" method="POST">
    <div class="form-group">
        <label for="exampleFormControlInput0">Email  :</label>
        <input class="form-control" id="exampleFormControlInput0" type="email" name="email" value="<?php echo $email; ?>">
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Facebook  :</label>
        <input class="form-control" id="exampleFormControlInput1" type="text" name="facebook" value="<?php echo $facebook; ?>">
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput2">Whatsapp  :</label>
        <input class="form-control" id="exampleFormControlInput2" type="text" name="whatsapp" value="<?php echo $whatsapp; ?>">
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Password :</label>
        <input type="password" class="form-control" id="exampleFormControlInput1" name="password">
    </div>
    <input type="hidden" name="opType" value="smedia">
    <button type="submit" class="btn publish">Submit</button>
</form>