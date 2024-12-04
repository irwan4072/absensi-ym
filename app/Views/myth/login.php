<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Login - SB Admin</title>
    <link href="/css/styles.css" rel="stylesheet" />
    <script src="https://use.fontawesome.com/releases/v6.1.0/js/all.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-5">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header">
                                    <h3 class="text-center font-weight-light my-4">Login</h3>
                                </div>
                                <div class="card-body">
                                    <?php if ($message = session()->getFlashdata('msg')): ?>
                                        <div class="alert alert-<?= session('warna'); ?>">
                                            <ul>
                                                <?php if (is_array(session('msg'))) : ?>
                                                    <?php foreach (session('msg') as $error): ?>
                                                        <li><?= $error ?></li>
                                                    <?php endforeach ?>
                                                <?php else: ?>
                                                    <li><?= session('msg') ?></li>
                                                <?php endif ?>
                                            </ul>
                                        </div>
                                    <?php endif; ?>
                                    <form action="/login" method="post">
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="username" name="username" type="text" placeholder="username" value="<?= old('username'); ?>" />
                                            <label for="username">username</label>
                                        </div>
                                        <div class="form-floating mb-3">
                                            <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Password" value="<?= old('password'); ?>" />
                                            <label for="inputPassword">Password</label>
                                            <span class="password-toggle input-group-text" data-target="#inputPassword" style="position: absolute; top: 50%; right: 10px; transform: translateY(-50%); cursor: pointer;">
                                                <i class="bi bi-eye-slash"></i>
                                            </span>
                                        </div>


                                        <div class="d-flex align-items-center justify-content-between mt-4 mb-0">
                                            <a class="small" href="#"></a>
                                            <!-- <a class="btn btn-primary" href="index.html">Login</a> -->
                                            <button class="btn btn-primary" type="submit" name="submit">Login</button>
                                        </div>
                                    </form>
                                </div>
                                <!-- <div class="card-footer text-center py-3">
                                    <div class="small"><a href="register.html">Need an account? Sign up!</a></div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="py-4 bg-light mt-auto">
                <div class="container-fluid px-4">
                    <div class="d-flex align-items-center justify-content-between small">
                        <div class="text-muted">Copyright &copy; Your Website 2022</div>
                        <div>
                            <a href="#">Privacy Policy</a>
                            &middot;
                            <a href="#">Terms &amp; Conditions</a>
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
    <script src="/js/scripts.js"></script>
    <script src="/js/js.js"></script>
</body>

</html>