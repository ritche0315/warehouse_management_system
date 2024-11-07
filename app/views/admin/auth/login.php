<?php include(APPDIR.'views/layouts/header.php'); ?>
<style>
    /* Background with Gradient and Shapes */
    body {
        background: linear-gradient(135deg, #f0f0f0, #e0e0e0);
        position: relative;
        overflow: hidden;
    }

    /* Background Shapes */
    .background-shapes {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        pointer-events: none;
        z-index: -1;
    }

    /* Abstract Circle Shape */
    .circle {
        position: absolute;
        border-radius: 50%;
        opacity: 0.15;
    }

    .circle1 {
        width: 300px;
        height: 300px;
        background-color: #007bff;
        top: 10%;
        left: 10%;
    }

    .circle2 {
        width: 200px;
        height: 200px;
        background-color: #6c757d;
        bottom: 15%;
        right: 20%;
    }

    /* Diagonal Lines */
    .lines {
        background: repeating-linear-gradient(
            45deg,
            rgba(0, 0, 0, 0.03),
            rgba(0, 0, 0, 0.03) 1px,
            transparent 1px,
            transparent 10px
        );
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0.1;
        z-index: -2;
    }

    /* Centered Login Card */
    #bg-light {
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        background: transparent;
    }

    /* Card Styling */
    .card {
        width: 100%;
        max-width: 360px;
        padding: 40px;
        border-radius: 8px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        background-color: white;
    }

    /* Button Hover Effect */
    .btn-primary {
        background-color: #007bff;
        border: none;
        transition: background-color 0.3s;
    }

    .btn-primary:hover {
        background-color: #0056b3;
    }
</style>

<div id="bg-light">
    <div class="card p-4">
        <h4 class="text-center mb-4"> 
            <i class='fa fa-boxes-stacked'></i>&nbsp; Smart Stock 
        </h4>
        <form method="POST">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" id="username" name="username" placeholder="Enter username" value="<?= (isset($_POST['username']) ? $_POST['username'] : ''); ?>"> 
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password" value="<?= (isset($_POST['password']) ? $_POST['password'] : ''); ?>">
            </div>
        
            <div class="d-grid">
                <button type="submit" name="submit" class="btn btn-primary">Login</button>
            </div>
            
            <div class="wrapper-error mt-3">
                <?php include(APPDIR . 'views/layouts/errors.php'); ?>
            </div>
        </form>
    </div>
</div>

<!-- Background Shapes -->
<div class="background-shapes">
    <div class="circle circle1"></div>
    <div class="circle circle2"></div>
    <div class="lines"></div>
</div>

<?php include(APPDIR . 'views/layouts/footer.php'); ?>
