<div class="container">
    <div class="row my-2">
        <div class="col-md-12 mx-auto">
            <h1 class="mt-4 text-center">
                <a href="/">SimpleBlogPHP</a>
            </h1>
        </div>
        <div
            class="col-md-8 mx-auto">

            <?php if ($isLoggedIn): ?>
                <div class="d-flex align-items-center justify-content-between">
                    <span class="mr-2">Hi,
                        <?php echo htmlspecialchars($_SESSION["name"]); ?>
                        !</span>
                    <div>
                        <?php
                        if ($requestUri !== '/dashboard') {
                            echo '<a class="btn btn-outline-secondary btn-sm" href="/dashboard">Dashboard</a>';
                        }
                        ?>
                        <a class="btn btn-outline-danger btn-sm" href="/logout">Logout</a>
                    </div>
                </div>
            <?php else: ?>
                <small class="text-right d-block">
                    <a class="btn btn-outline-secondary btn-sm" href="/login">Login</a>
                </small>
            <?php endif; ?>
        </div>
    </div>
</div>
<hr>

