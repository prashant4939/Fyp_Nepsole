<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Become a Vendor - NepSole</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
            background: linear-gradient(135deg, #6366f1 0%, #8b5cf6 100%);
            line-height: 1.6;
            min-height: 100vh;
        }

        .container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .back-link {
            display: inline-block;
            color: #fff;
            text-decoration: none;
            margin-bottom: 1rem;
            font-weight: 500;
        }
        .back-link:hover { text-decoration: underline; color: #e0e7ff; }

        .form-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            padding: 2rem;
        }

        .form-header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .form-header h1 { color: #1f2937; font-size: 28px; margin-bottom: 0.5rem; }
        .form-header p  { color: #6b7280; font-size: 16px; }

        .form-section { margin-bottom: 2rem; }

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

        .form-group { margin-bottom: 1rem; }

        label {
            display: block;
            color: #374151;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .required { color: #ef4444; }

        input, select, textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e5e7eb;
            border-radius: 8px;
            font-size: 14px;
            transition: border-color 0.2s;
            font-family: inherit;
        }

        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #6366f1;
        }

        textarea { resize: vertical; min-height: 90px; }

        .file-input { padding: 8px; cursor: pointer; }

        .help-text { font-size: 12px; color: #6b7280; margin-top: 0.25rem; }

        .error { color: #ef4444; font-size: 12px; margin-top: 0.25rem; }

        .alert-success {
            background: #d1fae5;
            color: #065f46;
            padding: 0.875rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 14px;
            font-weight: 500;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
            padding: 0.875rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 14px;
        }
        .alert-error ul { margin: 0; padding-left: 1.2rem; }

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
        .submit-btn:hover { background: #059669; }

        .login-link-wrap {
            text-align: center;
            margin-top: 1.25rem;
            font-size: 14px;
            color: #6b7280;
        }
        .login-link-wrap a {
            color: #6366f1;
            font-weight: 600;
            text-decoration: none;
        }
        .login-link-wrap a:hover { text-decoration: underline; }

        @media (max-width: 768px) {
            .form-row { grid-template-columns: 1fr; }
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

            @if(session('success'))
                <div class="alert-success">✅ {{ session('success') }}</div>
            @endif

            @if($errors->any())
                <div class="alert-error">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('vendor-request.store') }}" enctype="multipart/form-data">
                @csrf

                {{-- Personal Information --}}
                <div class="form-section">
                    <h2 class="section-title">Personal Information</h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="name">Full Name <span class="required">*</span></label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Your full name" required>
                            @error('name')<div class="error">{{ $message }}</div>@enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address <span class="required">*</span></label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="you@example.com" required>
                            @error('email')<div class="error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="phone">Phone Number <span class="required">*</span></label>
                            <input type="text" id="phone" name="phone" value="{{ old('phone') }}" placeholder="98XXXXXXXX" required>
                            @error('phone')<div class="error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                </div>

                {{-- Business Information --}}
                <div class="form-section">
                    <h2 class="section-title">Business Information</h2>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="shop_name">Shop / Business Name <span class="required">*</span></label>
                            <input type="text" id="shop_name" name="shop_name" value="{{ old('shop_name') }}" placeholder="Your shop name" required>
                            @error('shop_name')<div class="error">{{ $message }}</div>@enderror
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="address">Business Address <span class="required">*</span></label>
                        <textarea id="address" name="address" placeholder="Street, City, District" required>{{ old('address') }}</textarea>
                        @error('address')<div class="error">{{ $message }}</div>@enderror
                    </div>
                </div>

                {{-- Required Documents --}}
                <div class="form-section">
                    <h2 class="section-title">Required Documents</h2>
                    <div class="form-group">
                        <label for="citizenship_photo">Citizenship Photo <span class="required">*</span></label>
                        <input type="file" id="citizenship_photo" name="citizenship_photo" class="file-input" accept=".pdf,.jpg,.jpeg,.png" required>
                        <div class="help-text">Upload PDF, JPG, JPEG, or PNG (Max: 2MB)</div>
                        @error('citizenship_photo')<div class="error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="business_document">Business Registration Document <span class="required">*</span></label>
                        <input type="file" id="business_document" name="business_document" class="file-input" accept=".pdf,.jpg,.jpeg,.png" required>
                        <div class="help-text">Upload PDF, JPG, JPEG, or PNG (Max: 2MB)</div>
                        @error('business_document')<div class="error">{{ $message }}</div>@enderror
                    </div>
                    <div class="form-group">
                        <label for="tax_clearance">Tax Clearance Certificate <span class="required" style="color:#6b7280;font-weight:400;">(Optional)</span></label>
                        <input type="file" id="tax_clearance" name="tax_clearance" class="file-input" accept=".pdf,.jpg,.jpeg,.png">
                        <div class="help-text">Upload PDF, JPG, JPEG, or PNG (Max: 2MB)</div>
                        @error('tax_clearance')<div class="error">{{ $message }}</div>@enderror
                    </div>
                </div>

                <button type="submit" class="submit-btn">Submit Application</button>
            </form>

            <div class="login-link-wrap">
                Already a vendor? <a href="{{ route('vendor.login') }}">Login to your dashboard →</a>
            </div>
        </div>
    </div>
</body>
</html>
