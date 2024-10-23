<?php include(APPDIR.'views/layouts/header.php');?>
   <div class='bg-light d-flex justify-content-center align-items-center vh-100'>
    <div class="card p-4" style="width: 100%; max-width: 360px;">
        <h4 class="text-center mb-4"> <i class='fa fa-boxes-stacked'></i>&nbsp;  Smart Stock </h4>
        <form method='POST'>
        <div class="mb-3">
            <label for="username" class="form-label">Username</label>
            <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" value='<?=(isset($_POST['username']) ? $_POST['username'] : '');?>'> 
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Password" value='<?=(isset($_POST['password']) ? $_POST['password'] : '');?>'>
        </div>
    
        <div class="d-grid">
            <button type="submit" name="submit" class="btn btn-primary">Login</button>
        </div>
        
        <div class="wrapper-error mt-3">
            <?php include(APPDIR.'views/layouts/errors.php');?>
        </div>
        </form>
    </div>
   </div>
</div>

<?php include(APPDIR.'views/layouts/footer.php');?>