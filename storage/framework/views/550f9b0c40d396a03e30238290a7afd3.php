<style>
.settings-page {
    background: #f3f4f6;
    min-height: calc(100vh - 130px);
    padding: 2rem 0;
}

.settings-container {
    max-width: 1100px;
    margin: 0 auto;
    padding: 0 1.5rem;
    display: grid;
    grid-template-columns: 260px 1fr;
    gap: 2rem;
    align-items: start;
}

.settings-sidebar {
    background: white;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
    position: sticky;
    top: 1.5rem;
}

.sidebar-user {
    background: linear-gradient(135deg, #6366f1, #8b5cf6);
    padding: 1.75rem 1.5rem;
    display: flex;
    align-items: center;
    gap: 1rem;
}

.sidebar-avatar {
    width: 52px; height: 52px;
    border-radius: 50%;
    object-fit: cover;
    border: 3px solid rgba(255,255,255,0.4);
    flex-shrink: 0;
}

.sidebar-avatar-placeholder {
    width: 52px; height: 52px;
    border-radius: 50%;
    background: rgba(255,255,255,0.25);
    border: 3px solid rgba(255,255,255,0.4);
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; font-weight: 700; color: white;
    flex-shrink: 0;
}

.sidebar-name { font-weight: 700; color: white; font-size: 15px; }
.sidebar-role { font-size: 12px; color: rgba(255,255,255,0.75); margin-top: 2px; text-transform: capitalize; }

.sidebar-nav { padding: 0.75rem 0; }

.sidebar-link {
    display: flex; align-items: center; gap: 0.75rem;
    padding: 0.875rem 1.5rem;
    color: #4b5563; text-decoration: none;
    font-size: 14px; font-weight: 500;
    transition: all 0.2s;
}

.sidebar-link:hover { background: #f3f4f6; color: #6366f1; }
.sidebar-link.active { background: #eef2ff; color: #6366f1; border-right: 3px solid #6366f1; font-weight: 600; }
.sidebar-divider { height: 1px; background: #e5e7eb; margin: 0.5rem 1.5rem; }

.settings-main { display: flex; flex-direction: column; gap: 1.5rem; }

.settings-card {
    background: white; border-radius: 14px;
    padding: 2rem;
    box-shadow: 0 1px 3px rgba(0,0,0,0.08);
}

.settings-card-title {
    font-size: 1.25rem; font-weight: 700; color: #111827;
    margin-bottom: 1.75rem; padding-bottom: 1rem;
    border-bottom: 1px solid #f3f4f6;
    display: flex; align-items: center; gap: 0.75rem;
}

.settings-card-title svg { color: #6366f1; }

.form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }
.form-group { margin-bottom: 1.25rem; }
.form-group.full-width { grid-column: 1 / -1; }

.form-label { display: block; font-size: 13px; font-weight: 600; color: #374151; margin-bottom: 0.5rem; }

.form-input, .form-textarea {
    width: 100%; padding: 0.75rem 1rem;
    border: 1.5px solid #e5e7eb; border-radius: 8px;
    font-size: 14px; color: #111827; background: #f9fafb;
    transition: all 0.2s; font-family: inherit;
}

.form-input:focus, .form-textarea:focus {
    outline: none; border-color: #6366f1; background: white;
    box-shadow: 0 0 0 3px rgba(99,102,241,0.1);
}

.form-input[readonly] { background: #f3f4f6; color: #6b7280; cursor: not-allowed; }
.form-textarea { resize: vertical; min-height: 90px; }
.form-error { color: #ef4444; font-size: 12px; margin-top: 4px; }

.btn-primary {
    padding: 0.75rem 2rem; background: #6366f1; color: white;
    border: none; border-radius: 8px; font-size: 14px; font-weight: 600;
    cursor: pointer; transition: all 0.2s;
}

.btn-primary:hover { background: #4f46e5; transform: translateY(-1px); }

.btn-secondary {
    padding: 0.75rem 1.5rem; background: white; color: #374151;
    border: 1.5px solid #e5e7eb; border-radius: 8px;
    font-size: 14px; font-weight: 600; cursor: pointer;
    text-decoration: none; display: inline-block; transition: all 0.2s;
}

.btn-secondary:hover { border-color: #6366f1; color: #6366f1; }
.btn-group { display: flex; gap: 1rem; margin-top: 1.5rem; }

.alert { padding: 1rem 1.25rem; border-radius: 10px; display: flex; align-items: center; gap: 0.75rem; font-size: 14px; font-weight: 500; }
.alert-success { background: #d1fae5; color: #065f46; }

.profile-info-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 1.25rem; }

.info-item { padding: 1rem 1.25rem; background: #f9fafb; border-radius: 10px; border: 1px solid #e5e7eb; }
.info-item.full-width { grid-column: 1 / -1; }
.info-label { font-size: 11px; font-weight: 600; color: #9ca3af; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.35rem; }
.info-value { font-size: 15px; font-weight: 500; color: #111827; }
.info-value.empty { color: #9ca3af; font-style: italic; font-weight: 400; }

.avatar-upload {
    display: flex; align-items: center; gap: 1.5rem;
    margin-bottom: 1.5rem; padding: 1.25rem;
    background: #f9fafb; border-radius: 10px; border: 1.5px dashed #d1d5db;
}

.avatar-preview { width: 80px; height: 80px; border-radius: 50%; object-fit: cover; border: 3px solid #e5e7eb; flex-shrink: 0; }
.avatar-placeholder { width: 80px; height: 80px; border-radius: 50%; background: linear-gradient(135deg, #6366f1, #8b5cf6); display: flex; align-items: center; justify-content: center; font-size: 28px; font-weight: 700; color: white; flex-shrink: 0; }
.avatar-upload-info h4 { font-size: 14px; font-weight: 600; color: #374151; margin-bottom: 0.25rem; }
.avatar-upload-info p { font-size: 12px; color: #9ca3af; margin-bottom: 0.75rem; }
.avatar-upload-btn { display: inline-block; padding: 0.5rem 1rem; background: white; border: 1.5px solid #6366f1; color: #6366f1; border-radius: 6px; font-size: 13px; font-weight: 600; cursor: pointer; transition: all 0.2s; }
.avatar-upload-btn:hover { background: #6366f1; color: white; }

.password-strength { margin-top: 6px; height: 4px; border-radius: 2px; background: #e5e7eb; overflow: hidden; }
.password-strength-bar { height: 100%; border-radius: 2px; transition: all 0.3s; width: 0%; }

@media (max-width: 768px) {
    .settings-container { grid-template-columns: 1fr; }
    .settings-sidebar { position: static; }
    .form-row, .profile-info-grid { grid-template-columns: 1fr; }
}
</style>
<?php /**PATH C:\xampp\htdocs\Nepsole\resources\views/settings/partials/styles.blade.php ENDPATH**/ ?>