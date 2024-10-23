<?php include(APPDIR.'views/layouts/header.php');?>
   <div class='bg-light d-flex justify-content-center align-items-center vh-100'>
    <div class="card p-4" style="width: 100%; max-width: 360px;">
        <h4 class="text-center mb-4">&nbsp; Reset Account </h4>
        <form method='POST'>
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Enter email" value='<?=(isset($_POST['email']) ? $_POST['email'] : '');?>'> 
        </div>
        <div class="d-grid">
            <button type="submit" name="submit" class="btn btn-primary">Send reset email</button>
        </div>
        <div class="mt-3 text-center">
            <a href="/admin/login" class="text-muted">Go to login</a>
        </div>
        
        <div class="wrapper-error mt-3">
            <?php include(APPDIR.'views/layouts/errors.php');?>
        </div>
        </form>
    </div>
   </div>
</div>

<?php include(APPDIR.'views/layouts/footer.php');?>