<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Registrasi - PRATAMA Skill Matrix</title>

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

        .register-container {
            width: 100%;
            max-width: 460px;
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
            margin-bottom: 16px;
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

        .btn-register {
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

        .btn-register:hover {
            background: #df5713;
        }

        .login-link {
            text-align: center;
            margin-top: 22px;
            font-size: 13px;
            color: #718096;
        }

        .login-link a {
            color: #f36b21;
            font-weight: 700;
            text-decoration: none;
        }

        .alert-error {
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 16px;
            font-size: 12px;
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
            .register-container {
                padding: 25px 20px;
            }
        }
    </style>
</head>

<body>

<div class="register-container">

    <div class="logo">
        <img src="<?php echo e(asset('images/pratama-logo.png')); ?>"
             alt="Logo PRATAMA">

        <h2>Buat Akun Baru</h2>
        <p>HRM Skill Matrix System</p>
    </div>

    <?php if($errors->any()): ?>
        <div class="alert-error">
            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div><?php echo e($error); ?></div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    <?php endif; ?>

    <form action="<?php echo e(route('register.post')); ?>" method="POST">
        <?php echo csrf_field(); ?>

        <div class="form-group">
            <label>Nama Lengkap</label>
            <input
                type="text"
                name="name"
                value="<?php echo e(old('name')); ?>"
                placeholder="Masukkan nama lengkap"
                required
                autocomplete="name"
            >
        </div>

        <div class="form-group">
            <label>NIK</label>
            <input
                type="text"
                name="nik"
                value="<?php echo e(old('nik')); ?>"
                placeholder="Masukkan NIK"
                required
                autocomplete="username"
            >
        </div>

        <div class="form-group">
            <label>Password</label>
            <input
                type="password"
                name="password"
                placeholder="Minimal 8 karakter"
                minlength="8"
                required
                autocomplete="new-password"
            >
        </div>

        <div class="form-group">
            <label>Konfirmasi Password</label>
            <input
                type="password"
                name="password_confirmation"
                placeholder="Ulangi password"
                minlength="8"
                required
                autocomplete="new-password"
            >
        </div>

        <button type="submit" class="btn-register">
            DAFTAR AKUN
        </button>
    </form>

    <div class="login-link">
        Sudah memiliki akun?
        <a href="<?php echo e(route('login')); ?>">Login sekarang</a>
    </div>

    <div class="footer">
        PRATAMA · HRM Skill Matrix System
    </div>

</div>

</body>
</html><?php /**PATH C:\laragon\www\skill-matrix\resources\views/auth/register.blade.php ENDPATH**/ ?>