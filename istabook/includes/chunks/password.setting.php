<form action="actions/setting.php" method="POST">
    <div class="form-group">
        <label for="exampleFormControlInput1">New Password :</label>
        <input type="password" class="form-control" id="exampleFormControlInput1" name="newPassword">
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Old Password :</label>
        <input type="password" class="form-control" id="exampleFormControlInput1" name="oldPassword">
    </div>
    <input type="hidden" name="opType" value="changePassword">
    <button type="submit" class="btn publish">Submit</button>
</form>