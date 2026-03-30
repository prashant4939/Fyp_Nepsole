<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Become a Vendor - NepSole</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background-color: #f9fafb;
            line-height: 1.6;
        }

        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .form-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            padding: 2rem;
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .form-header h1 {
            color: #1f2937;
            font-size: 28px;
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: #6b7280;
            font-size: 16px;
        }

        .form-section {
            margin-bottom: 2rem;
        }

        .section-title {
            color: #374151;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 1rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid #e5e7eb;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
            margin-bottom: 1rem;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        label {
            display: block;
            color: #374151;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .required {
            color: #ef4444;
        }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.2s;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #6366f1;
        }

        .file-input {
            padding: 8px;
        }

        .help-text {
            font-size: 12px;
            color: #6b7280;
            margin-top: 0.25rem;
        }

        .submit-btn {
            width: 100%;
            background: #10b981;
            color: white;
            padding: 14px;
            border: none;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.2s;
        }

        .submit-btn:hover {
            background: #059669;
        }

        .back-link {
            display: inline-block;
            color: #6366f1;
            text-decoration: none;
            margin-bottom: 1rem;
            font-weight: 500;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .error {
            color: #ef4444;
            font-size: 12px;
            margin-top: 0.25rem;
        }

        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/" class="back-link">← Back to Home</a>
        
        <div class="form-card">
            <div class="form-header">
                <h1>Become a Vendor</h1>
                <p>Join our marketplace and start selling your products</p>
            </div>

            <form method="POST" action="{{ route('vendor.register') }}" enctype="multipart/form-data">
                @csrf

                <!-- Personal Information -->
                <div class="form-section">
                    <h2 class="section-title">Personal Information</h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Full Name <span class="required">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required>
                            @error('name')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required>
                            @error('email')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="password">Password <span class="required">*</span></label>
                            <input type="password" id="password" name="password" required>
                            @error('password')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password_confirmation">Confirm Password <span class="required">*</span></label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required>
                        </div>
                    </div>
                </div>

                <!-- Business Information -->
                <div class="form-section">
                    <h2 class="section-title">Business Information</h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="business_name">Business Name <span class="required">*</span></label>
                            <input type="text" id="business_name" name="business_name" value="{{ old('business_name') }}" required>
                            @error('business_name')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="pan_number">PAN Number <span class="required">*</span></label>
                            <input type="text" id="pan_number" name="pan_number" value="{{ old('pan_number') }}" required>
                            @error('pan_number')
                                <div class="error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="business_type">Business Type <span class="required">*</span></label>
                        <select id="business_type" name="business_type" required>
                            <option value="">Select Business Type</option>
                            <option value="sole_proprietorship" {{ old('business_type') == 'sole_proprietorship' ? 'selected' : '' }}>Sole Proprietorship</option>
                            <option value="partnership" {{ old('business_type') == 'partnership' ? 'selected' : '' }}>Partnership</option>
                            <option value="private_limited" {{ old('business_type') == 'private_limited' ? 'selected' : '' }}>Private Limited</option>
                            <option value="llp" {{ old('business_type') == 'llp' ? 'selected' : '' }}>LLP</option>
                            <option value="other" {{ old('business_type') == 'other' ? 'selected' : '' }}>Other</option>
                        </select>
                        @error('business_type')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Document Upload -->
                <div class="form-section">
                    <h2 class="section-title">Required Documents</h2>
                    <div class="form-group">
                        <label for="citizenship_certificate">Citizenship Certificate <span class="required">*</span></label>
                        <input type="file" id="citizenship_certificate" name="citizenship_certificate" class="file-input" accept=".pdf,.jpg,.jpeg,.png" required>
                        <div class="help-text">Upload PDF, JPG, JPEG, or PNG (Max: 2MB)</div>
                        @error('citizenship_certificate')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="company_registration_certificate">Company Registration Certificate <span class="required">*</span></label>
                        <input type="file" id="company_registration_certificate" name="company_registration_certificate" class="file-input" accept=".pdf,.jpg,.jpeg,.png" required>
                        <div class="help-text">Upload PDF, JPG, JPEG, or PNG (Max: 2MB)</div>
                        @error('company_registration_certificate')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="form-group">
                        <label for="tax_certificate">Tax Certificate (Optional)</label>
                        <input type="file" id="tax_certificate" name="tax_certificate" class="file-input" accept=".pdf,.jpg,.jpeg,.png">
                        <div class="help-text">Upload PDF, JPG, JPEG, or PNG (Max: 2MB)</div>
                        @error('tax_certificate')
                            <div class="error">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <button type="submit" class="submit-btn">Submit Application</button>
            </form>
        </div>
    </div>
</body>
</html>