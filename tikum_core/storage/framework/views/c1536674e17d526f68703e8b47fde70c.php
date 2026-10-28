<?php $__env->startSection('title', 'Masuk'); ?>

<?php $__env->startSection('content'); ?>
<div class="w-full max-w-[500px] mx-auto my-6 px-4">
    <div class="bg-white rounded-3xl border border-[#C8BFB0]/70 p-7 sm:p-9 text-left space-y-6 shadow-[0_16px_40px_rgba(45,107,34,0.12)]">
        
        <!-- Header -->
        <div class="space-y-1">
            <h1 class="text-[24px] font-bold text-[#15241C] leading-tight" data-i18n="auth.login_title">
                Masuk ke akun
            </h1>
            <p class="text-[14px] text-[#3E5445]" data-i18n="auth.login_subtitle">
                Gunakan kredensial akun Titik UMKM Anda untuk melanjutkan.
            </p>
        </div>

        <!-- Alert Messages -->
        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('success')): ?>
            <div class="p-4 rounded-xl bg-[#F2F8ED] border border-[#2D6B22]/30 text-[#1E4A1A] text-[14px]">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if(session('error')): ?>
            <div class="p-4 rounded-xl bg-[#fee2e2] border border-[#fca5a5] text-[#991b1b] text-[14px]">
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>

        <!-- 1. Tombol Sign In With Google -->
        <a href="<?php echo e(route('google.redirect')); ?>" 
           class="w-full flex items-center justify-center gap-3 px-5 py-3.5 border border-[#C8BFB0]/80 hover:border-[#2D6B22] rounded-xl text-[14.5px] font-medium text-[#15241C] bg-white hover:bg-[#F2F8ED]/30 transition duration-150 shadow-xs hover:shadow-sm">
            <svg class="w-4.5 h-4.5 shrink-0" viewBox="0 0 24 24" aria-hidden="true">
                <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
            </svg>
            <span data-i18n="auth.google_login">Masuk dengan Google</span>
        </a>

        <!-- Divider -->
        <div class="relative text-center my-1">
            <div class="absolute inset-0 flex items-center">
                <div class="w-full border-t border-[#C8BFB0]/60"></div>
            </div>
            <div class="relative inline-block bg-white px-3.5 text-[13px] text-[#3E5445] rounded-full">
                <span data-i18n="auth.or_email">atau masuk dengan email</span>
            </div>
        </div>

        <!-- 2. Form Login Email -->
        <form action="<?php echo e(route('login.post')); ?>" method="POST" class="space-y-5">
            <?php echo csrf_field(); ?>

            <!-- Input Email -->
            <div>
                <label for="email" class="block text-[14px] font-semibold text-[#15241C] mb-2" data-i18n="auth.email_label">
                    Alamat email
                </label>
                <input type="email" 
                       name="email" 
                       id="email" 
                       value="<?php echo e(old('email')); ?>" 
                       required 
                       placeholder="nama@email.com"
                       data-i18n-placeholder="auth.email_placeholder"
                       class="w-full px-4 py-3 bg-white border <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php else: ?> border-[#C8BFB0] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> rounded-xl text-[14.5px] text-[#15241C] focus:outline-none focus:border-[#2D6B22] focus:ring-2 focus:ring-[#2D6B22]/20 transition shadow-2xs">
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1.5 text-[12px] text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Input Password -->
            <div>
                <div class="flex items-center justify-between mb-2">
                    <label for="password" class="block text-[14px] font-semibold text-[#15241C]" data-i18n="auth.password_label">
                        Kata sandi
                    </label>
                    <a href="<?php echo e(route('password.request')); ?>" class="text-[13px] text-[#2D6B22] hover:text-[#1E4A1A] hover:underline font-medium" data-i18n="auth.forgot_password">
                        Lupa sandi?
                    </a>
                </div>
                <div class="relative">
                    <input type="password" 
                           name="password" 
                           id="password" 
                           required 
                           placeholder="••••••••"
                           data-i18n-placeholder="auth.password_placeholder"
                           class="w-full px-4 pr-12 py-3 bg-white border <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> border-red-500 <?php else: ?> border-[#C8BFB0] <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?> rounded-xl text-[14.5px] text-[#15241C] focus:outline-none focus:border-[#2D6B22] focus:ring-2 focus:ring-[#2D6B22]/20 transition shadow-2xs">
                    <button type="button" 
                            onclick="togglePasswordVisibility('password', 'eye-icon-login')" 
                            class="absolute inset-y-0 right-0 pr-4 flex items-center text-[#3E5445] hover:text-[#2D6B22] transition"
                            aria-label="Lihat kata sandi">
                        <svg id="eye-icon-login" class="w-4.5 h-4.5" fill="none" stroke="currentColor" stroke-width="1.6" viewBox="0 0 24 24" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </button>
                </div>
                <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                    <p class="mt-1.5 text-[12px] text-red-600"><?php echo e($message); ?></p>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
            </div>

            <!-- Remember Me -->
            <div class="flex items-center pt-1">
                <input id="remember" 
                       name="remember" 
                       type="checkbox" 
                       class="w-4.5 h-4.5 text-[#2D6B22] border-[#C8BFB0] rounded focus:ring-[#2D6B22] cursor-pointer">
                <label for="remember" class="ml-2.5 block text-[13.5px] text-[#3E5445] cursor-pointer" data-i18n="auth.remember_me">
                    Ingat sesi saya
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full py-3.5 px-5 bg-[#2D6B22] hover:bg-[#1E4A1A] text-white font-semibold text-[15.5px] rounded-xl shadow-[0_4px_14px_rgba(45,107,34,0.3)] hover:shadow-lg hover:-translate-y-0.5 transition-all duration-150 cursor-pointer" data-i18n="auth.login_btn">
                Masuk ke akun
            </button>
        </form>

        <!-- Bottom Link -->
        <div class="text-center text-[14.5px] text-[#3E5445] pt-1">
            <span data-i18n="auth.no_account">Belum memiliki akun?</span>
            <a href="<?php echo e(route('register')); ?>" class="font-semibold text-[#2D6B22] hover:text-[#1E4A1A] hover:underline ml-1.5" data-i18n="auth.register_now">
                Daftar sekarang
            </a>
        </div>

    </div>
</div>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.auth', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\laragon\www\tikum_core\tikum_core\resources\views/auth/login.blade.php ENDPATH**/ ?>