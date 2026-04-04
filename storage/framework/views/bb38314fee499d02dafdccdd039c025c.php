

<?php $__env->startSection('title', 'Change Password - NepSole'); ?>

<?php $__env->startSection('content'); ?>
<div class="cp-page">
    <div class="cp-container">

        <!-- Back link -->
        <a href="<?php echo e(url()->previous()); ?>" class="cp-back">
            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
            </svg>
            Back
        </a>

        <div class="cp-card">
            <!-- Header -->
            <div class="cp-header">
                <div class="cp-icon">
                    <svg width="28" height="28" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="cp-title">Change Password</h1>
                    <p class="cp-subtitle">Keep your account secure with a strong password</p>
                </div>
            </div>

            <!-- Alerts -->
            <?php if(session('success')): ?>
                <div class="cp-alert cp-alert-success">
                    <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
                    </svg>
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <!-- Form -->
            <form method="POST" action="<?php echo e(route('settings.update-password')); ?>" id="changePasswordForm">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>

                <!-- Current Password -->
                <div class="cp-field">
                    <label class="cp-label">
                        Current Password
                        <span class="cp-required">*</span>
                    </label>
                    <div class="cp-input-wrap">
                        <input type="password"
                               name="current_password"
                               id="currentPassword"
                               class="cp-input <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> cp-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Enter your current password"
                               autocomplete="current-password"
                               required>
                        <button type="button" class="cp-eye" onclick="togglePwd('currentPassword', this)">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" class="eye-open">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    <?php $__errorArgs = ['current_password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="cp-error"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- New Password -->
                <div class="cp-field">
                    <label class="cp-label">
                        New Password
                        <span class="cp-required">*</span>
                    </label>
                    <div class="cp-input-wrap">
                        <input type="password"
                               name="password"
                               id="newPassword"
                               class="cp-input <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> cp-input-error <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                               placeholder="Minimum 8 characters"
                               autocomplete="new-password"
                               required
                               oninput="checkStrength(this.value); checkMatch()">
                        <button type="button" class="cp-eye" onclick="togglePwd('newPassword', this)">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    <!-- Strength bar -->
                    <div class="cp-strength-track">
                        <div class="cp-strength-bar" id="strengthBar"></div>
                    </div>
                    <div class="cp-strength-label" id="strengthLabel"></div>
                    <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="cp-error"><?php echo e($message); ?></div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <!-- Confirm Password -->
                <div class="cp-field">
                    <label class="cp-label">
                        Confirm New Password
                        <span class="cp-required">*</span>
                    </label>
                    <div class="cp-input-wrap">
                        <input type="password"
                               name="password_confirmation"
                               id="confirmPassword"
                               class="cp-input"
                               placeholder="Re-enter new password"
                               autocomplete="new-password"
                               required
                               oninput="checkMatch()">
                        <button type="button" class="cp-eye" onclick="togglePwd('confirmPassword', this)">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                            </svg>
                        </button>
                    </div>
                    <div class="cp-match-label" id="matchLabel"></div>
                </div>

                <!-- Requirements -->
                <div class="cp-requirements">
                    <div class="cp-req-title">Password must:</div>
                    <div class="cp-req" id="req-length">
                        <span class="req-dot"></span> Be at least 8 characters
                    </div>
                    <div class="cp-req" id="req-upper">
                        <span class="req-dot"></span> Contain an uppercase letter
                    </div>
                    <div class="cp-req" id="req-number">
                        <span class="req-dot"></span> Contain a number
                    </div>
                </div>

                <!-- Actions -->
                <div class="cp-actions">
                    <button type="submit" class="cp-btn-primary">
                        <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
                        </svg>
                        Update Password
                    </button>
                    <a href="<?php echo e(route('settings.profile')); ?>" class="cp-btn-secondary">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>

<style>
.cp-page {
    background: #f3f4f6;
    min-height: calc(100vh - 130px);
    padding: 2.5rem 1.5rem;
}

.cp-container {
    max-width: 520px;
    margin: 0 auto;
}

.cp-back {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    color: #6b7280;
    text-decoration: none;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 1.5rem;
    transition: color 0.2s;
}

.cp-back:hover { color: #6366f1; }

.cp-card {
    background: white;
    border-radius: 16px;
    padding: 2.25rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08), 0 4px 16px rgba(0,0,0,0.04);
}

.cp-header {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 2rem;
    padding-bottom: 1.5rem;
    border-bottom: 1px solid #f3f4f6;
}

.cp-icon {
    width: 52px;
    height: 52px;
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    flex-shrink: 0;
}

.cp-title {
    font-size: 1.375rem;
    font-weight: 700;
    color: #111827;
    margin: 0 0 0.25rem;
}

.cp-subtitle {
    font-size: 13px;
    color: #9ca3af;
    margin: 0;
}

/* Alert */
.cp-alert {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 0.875rem 1.125rem;
    border-radius: 10px;
    font-size: 14px;
    font-weight: 500;
    margin-bottom: 1.5rem;
}

.cp-alert-success { background: #d1fae5; color: #065f46; }

/* Fields */
.cp-field { margin-bottom: 1.375rem; }

.cp-label {
    display: block;
    font-size: 13px;
    font-weight: 600;
    color: #374151;
    margin-bottom: 0.5rem;
}

.cp-required { color: #ef4444; margin-left: 2px; }

.cp-input-wrap { position: relative; }

.cp-input {
    width: 100%;
    padding: 0.8rem 3rem 0.8rem 1rem;
    border: 1.5px solid #e5e7eb;
    border-radius: 9px;
    font-size: 14px;
    color: #111827;
    background: #f9fafb;
    transition: all 0.2s;
    font-family: inherit;
}

.cp-input:focus {
    outline: none;
    border-color: #6366f1;
    background: white;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
}

.cp-input-error { border-color: #ef4444 !important; }
.cp-input-error:focus { box-shadow: 0 0 0 3px rgba(239,68,68,0.1) !important; }

.cp-eye {
    position: absolute;
    right: 0.875rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    cursor: pointer;
    color: #9ca3af;
    padding: 0;
    display: flex;
    align-items: center;
    transition: color 0.2s;
}

.cp-eye:hover { color: #6366f1; }

.cp-error { color: #ef4444; font-size: 12px; margin-top: 5px; }

/* Strength */
.cp-strength-track {
    height: 4px;
    background: #e5e7eb;
    border-radius: 2px;
    margin-top: 8px;
    overflow: hidden;
}

.cp-strength-bar {
    height: 100%;
    border-radius: 2px;
    width: 0%;
    transition: all 0.35s;
}

.cp-strength-label {
    font-size: 11px;
    margin-top: 4px;
    font-weight: 600;
    min-height: 16px;
}

.cp-match-label {
    font-size: 11px;
    margin-top: 5px;
    font-weight: 600;
    min-height: 16px;
}

/* Requirements */
.cp-requirements {
    background: #f9fafb;
    border: 1px solid #e5e7eb;
    border-radius: 10px;
    padding: 1rem 1.25rem;
    margin-bottom: 1.75rem;
}

.cp-req-title {
    font-size: 12px;
    font-weight: 600;
    color: #6b7280;
    margin-bottom: 0.5rem;
    text-transform: uppercase;
    letter-spacing: 0.4px;
}

.cp-req {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 13px;
    color: #9ca3af;
    margin-bottom: 0.3rem;
    transition: color 0.2s;
}

.cp-req.met { color: #10b981; }

.req-dot {
    width: 7px;
    height: 7px;
    border-radius: 50%;
    background: #d1d5db;
    flex-shrink: 0;
    transition: background 0.2s;
}

.cp-req.met .req-dot { background: #10b981; }

/* Actions */
.cp-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.cp-btn-primary {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    padding: 0.8rem 1.75rem;
    background: #6366f1;
    color: white;
    border: none;
    border-radius: 9px;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.2s;
    font-family: inherit;
}

.cp-btn-primary:hover {
    background: #4f46e5;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(99,102,241,0.35);
}

.cp-btn-secondary {
    padding: 0.8rem 1.5rem;
    background: white;
    color: #6b7280;
    border: 1.5px solid #e5e7eb;
    border-radius: 9px;
    font-size: 14px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.2s;
}

.cp-btn-secondary:hover {
    border-color: #6366f1;
    color: #6366f1;
}
</style>

<script>
function togglePwd(id, btn) {
    const input = document.getElementById(id);
    const isText = input.type === 'text';
    input.type = isText ? 'password' : 'text';
    btn.style.color = isText ? '#9ca3af' : '#6366f1';
}

function checkStrength(val) {
    const bar   = document.getElementById('strengthBar');
    const label = document.getElementById('strengthLabel');

    const hasLen    = val.length >= 8;
    const hasUpper  = /[A-Z]/.test(val);
    const hasNum    = /[0-9]/.test(val);
    const hasSpec   = /[^A-Za-z0-9]/.test(val);

    // Update requirement indicators
    document.getElementById('req-length').className = 'cp-req' + (hasLen ? ' met' : '');
    document.getElementById('req-upper').className  = 'cp-req' + (hasUpper ? ' met' : '');
    document.getElementById('req-number').className = 'cp-req' + (hasNum ? ' met' : '');

    const score = [hasLen, hasUpper, hasNum, hasSpec].filter(Boolean).length;

    const levels = [
        { w: '0%',   c: '#e5e7eb', t: '' },
        { w: '25%',  c: '#ef4444', t: 'Weak' },
        { w: '50%',  c: '#f59e0b', t: 'Fair' },
        { w: '75%',  c: '#3b82f6', t: 'Good' },
        { w: '100%', c: '#10b981', t: 'Strong ✓' },
    ];

    bar.style.width      = levels[score].w;
    bar.style.background = levels[score].c;
    label.textContent    = levels[score].t;
    label.style.color    = levels[score].c;
}

function checkMatch() {
    const np = document.getElementById('newPassword').value;
    const cp = document.getElementById('confirmPassword').value;
    const el = document.getElementById('matchLabel');

    if (!cp) { el.textContent = ''; return; }

    if (np === cp) {
        el.textContent  = '✓ Passwords match';
        el.style.color  = '#10b981';
    } else {
        el.textContent  = '✗ Passwords do not match';
        el.style.color  = '#ef4444';
    }
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp\htdocs\Nepsole\resources\views/settings/change-password.blade.php ENDPATH**/ ?>