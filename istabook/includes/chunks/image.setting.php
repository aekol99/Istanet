<form action="actions/setting.php" method="POST" enctype="multipart/form-data">
    <div class="form-group">
        <label for="exampleFormControlFile1">Image :</label>
        <input type="file" class="form-control-file" id="exampleFormControlFile1" name="image">
    </div>
    <div class="form-group">
        <label for="exampleFormControlInput1">Password :</label>
        <input type="password" class="form-control" id="exampleFormControlInput1" name="password">
    </div>
    <input type="hidden" name="opType" value="cimage">
    <button type="submit" class="btn publish">Submit</button>
</form>