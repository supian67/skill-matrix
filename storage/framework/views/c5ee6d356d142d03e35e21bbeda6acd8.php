<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login - PRATAMA Skill Matrix</title>

    <link rel="icon" type="image/png" href="<?php echo e(asset('images/favicon.png')); ?>">
    <link rel="shortcut icon" href="<?php echo e(asset('images/favicon.png')); ?>">


    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #172337, #294968);
        }

        .login-container {
            width: 100%;
            max-width: 430px;
            background: #fff;
            padding: 35px;
            border-radius: 16px;
            box-shadow: 0 15px 45px #0003;
        }

        .logo {
            text-align: center;
            margin-bottom: 25px;
        }

        .logo img {
            max-width: 175px;
            max-height: 65px;
            object-fit: contain;
        }

        .logo h2 {
            color: #1e2b3e;
            margin: 12px 0 5px;
            font-size: 21px;
        }

        .logo p {
            color: #718096;
            font-size: 12px;
            margin: 0;
        }

        .form-group {
            margin-bottom: 17px;
        }

        label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 7px;
            color: #344054;
        }

        input {
            width: 100%;
            padding: 13px;
            border: 1px solid #dce3ec;
            border-radius: 8px;
            outline: none;
            font-size: 14px;
        }

        input:focus {
            border-color: #f36b21;
            box-shadow: 0 0 0 3px #f36b2120;
        }

        .remember {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 20px;
            font-size: 12px;
            color: #667085;
        }

        .remember input {
            width: auto;
        }

        .btn-login {
            width: 100%;
            padding: 13px;
            background: #f36b21;
            color: #fff;
            border: none;
            border-radius: 8px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
        }

        .btn-login:hover {
            background: #df5713;
        }

        .register-link {
            text-align: center;
            margin-top: 22px;
            font-size: 13px;
            color: #718096;
        }

        .register-link a {
            color: #f36b21;
            font-weight: 700;
            text-decoration: none;
        }

        .alert {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 12px;
        }

        .alert-success {
            background: #eaf8f2;
            color: #116a4d;
        }

        .alert-error {
            background: #ffebee;
            color: #a52435;
        }

        .footer {
            text-align: center;
            margin-top: 25px;
            color: #98a2b3;
            font-size: 11px;
        }

        @media(max-width: 480px) {
            .login-container {
                padding: 25px 20px;
            }
        }
    </style>
</head>

<body>

<div class="login-container">

    <div class="logo">
        <img src="<?php echo e(asset('images/pratama-logo.png')); ?>"
             alt="Logo PRATAMA">

        <h2>HRM Skill Matrix</h2>
        <p>Human Resources Development System</p>
    </div>

    <?php if(session('success')): ?>
        <div class="alert alert-success">
            <?php echo e(session('success')); ?>

        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-error">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div><?php echo e($error); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('login.post')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="form-group">
            <label>NIK</label>
            <input
                type="text"
                name="nik"
                value="<?php echo e(old('nik')); ?>"
                placeholder="Masukkan NIK"
                required
                autofocus
                autocomplete="username"
            >
        </div>

        <div class="form-group">
            <label>Password</label>
            <input
                type="password"
                name="password"
                placeholder="Masukkan password"
                required
                autocomplete="current-password"
            >
        </div>

        <label class="remember">
            <input type="checkbox" name="remember" value="1">
            Ingat saya
        </label>

        <button type="submit" class="btn-login">
            LOGIN
        </button>
    </form>

    <div class="register-link">
        Belum memiliki akun?
        <a href="<?php echo e(route('register')); ?>">Daftar sekarang</a>
    </div>

    <div class="footer">
        PRATAMA · HRM Skill Matrix System
    </div>

</div>

</body>
</html><?php /**PATH C:\laragon\www\skill-matrix\resources\views/auth/login.blade.php ENDPATH**/ ?>