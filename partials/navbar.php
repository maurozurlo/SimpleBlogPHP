<div class="container">
    <div class="row my-2">
        <div class="col-md-12 mx-auto">
            <h1 class="mt-4 text-center">
                <a href="/">SimpleBlogPHP</a>
            </h1>
        </div>
        <div class="col-md-12 mx-auto">


            <div
                class="d-flex align-items-center justify-content-between">
                <?php if ($isLoggedIn): ?>
                    <span class="mr-2">Hi,
                        <?php echo htmlspecialchars($_SESSION["name"]); ?>
                        !</span>
                <?php else: ?>
                    <span></span>
                <?php endif; ?>
                <div>
                    <a class="btn btn-outline-secondary btn-sm" href="/">Home</a>
                    <a class="btn btn-outline-secondary btn-sm" href="/blog">Blog</a>
                    <?php if ($isLoggedIn): ?>
                        <a class="btn btn-outline-secondary btn-sm" href="/backoffice">Dashboard</a>
                        <a class="btn btn-outline-danger btn-sm" href="/logout">Logout</a>
                    <?php else: ?>
                        <a class="btn btn-outline-secondary btn-sm" href="/login">Login</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<hr>

