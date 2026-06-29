<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin Login - Glow Beauty</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        /* ============================================
           ADMIN LOGIN PAGE - MATCHING USER STYLE
           ============================================ */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .admin-login-page {
            position: fixed;
            top: 0;
            left: 0;
            width: 100vw;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: 
                linear-gradient(135deg, rgba(255, 182, 193, 0.08) 0%, rgba(255, 105, 180, 0.05) 50%, rgba(255, 182, 193, 0.08) 100%),
                url('https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=1920&q=80');
            background-size: cover;
            background-position: center;
            overflow: hidden;
            z-index: 9999;
            font-family: 'Inter', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        /* Background Overlay */
        .bg-overlay {
            position: absolute;
            inset: 0;
            background: 
                radial-gradient(ellipse at 20% 50%, rgba(255, 182, 193, 0.06) 0%, transparent 60%),
                radial-gradient(ellipse at 80% 50%, rgba(255, 105, 180, 0.04) 0%, transparent 60%);
            pointer-events: none;
        }

        /* Animated Background Elements */
        .bg-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .bg-element {
            position: absolute;
            font-size: 3rem;
            animation: floatBg 15s ease-in-out infinite;
            opacity: 0.08;
        }

        .bg-element:nth-child(1) { top: 5%; left: 5%; animation-delay: 0s; }
        .bg-element:nth-child(2) { top: 15%; right: 10%; animation-delay: 2s; font-size: 3.5rem; }
        .bg-element:nth-child(3) { bottom: 20%; left: 8%; animation-delay: 4s; }
        .bg-element:nth-child(4) { bottom: 10%; right: 5%; animation-delay: 6s; font-size: 4rem; }
        .bg-element:nth-child(5) { top: 45%; left: 2%; animation-delay: 1s; font-size: 2.5rem; }
        .bg-element:nth-child(6) { top: 40%; right: 2%; animation-delay: 3s; font-size: 3.2rem; }
        .bg-element:nth-child(7) { top: 70%; left: 3%; animation-delay: 5s; font-size: 2.8rem; }
        .bg-element:nth-child(8) { top: 25%; right: 3%; animation-delay: 7s; }

        @keyframes floatBg {
            0%, 100% { transform: translateY(0px) rotate(0deg) scale(1); }
            25% { transform: translateY(-40px) rotate(5deg) scale(1.1); }
            75% { transform: translateY(40px) rotate(-5deg) scale(0.9); }
        }

        /* ============================================
           LOGIN CONTAINER
           ============================================ */
        .login-container {
            width: 100vw;
            height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1.2fr;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(20px);
            position: relative;
            z-index: 1;
            border: none;
            border-radius: 0;
            box-shadow: none;
        }

        /* ============================================
           LEFT BRAND SECTION
           ============================================ */
        .login-brand {
            background: linear-gradient(160deg, #0f172a 0%, #1a1a2e 40%, #2d1b3d 70%, #1a1a2e 100%);
            padding: 3.5rem 2.5rem;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            overflow: hidden;
            height: 100vh;
        }

        .login-brand::before {
            content: '';
            position: absolute;
            top: -30%;
            right: -30%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 182, 193, 0.06) 0%, transparent 70%);
            border-radius: 50%;
            animation: pulseGlow 8s ease-in-out infinite;
        }

        .login-brand::after {
            content: '';
            position: absolute;
            bottom: -20%;
            left: -20%;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(240, 147, 251, 0.04) 0%, transparent 70%);
            border-radius: 50%;
            animation: pulseGlow 10s ease-in-out infinite reverse;
        }

        @keyframes pulseGlow {
            0%, 100% { transform: scale(1); opacity: 0.5; }
            50% { transform: scale(1.2); opacity: 1; }
        }

        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            z-index: 1;
            overflow: hidden;
        }

        .float-element {
            position: absolute;
            font-size: 2rem;
            animation: floatBeauty 8s ease-in-out infinite;
            opacity: 0.2;
        }

        .float-element:nth-child(1) { top: 10%; left: 8%; animation-delay: 0s; font-size: 2.5rem; }
        .float-element:nth-child(2) { top: 70%; left: 85%; animation-delay: 1.5s; font-size: 2rem; }
        .float-element:nth-child(3) { top: 85%; left: 10%; animation-delay: 3s; font-size: 2.8rem; }
        .float-element:nth-child(4) { top: 20%; left: 80%; animation-delay: 4.5s; font-size: 2.2rem; }
        .float-element:nth-child(5) { top: 50%; left: 5%; animation-delay: 6s; font-size: 1.8rem; }
        .float-element:nth-child(6) { top: 40%; left: 92%; animation-delay: 2s; font-size: 2rem; }

        @keyframes floatBeauty {
            0%, 100% { transform: translateY(0px) rotate(0deg); }
            25% { transform: translateY(-25px) rotate(5deg); }
            75% { transform: translateY(25px) rotate(-5deg); }
        }

        .brand-content {
            position: relative;
            z-index: 2;
            text-align: center;
            width: 100%;
            max-width: 500px;
        }

        .brand-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            margin-bottom: 2.5rem;
        }

        .logo-icon {
            width: 56px;
            height: 56px;
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .logo-icon:hover {
            transform: rotate(-5deg) scale(1.05);
        }

        .logo-icon svg {
            width: 100%;
            height: 100%;
        }

        .brand-name {
            font-size: 2.4rem;
            font-weight: 700;
            color: white;
            letter-spacing: -0.5px;
        }

        .brand-highlight {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-tagline {
            text-align: center;
        }

        .signup-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 182, 193, 0.12);
            color: #f093fb;
            padding: 0.35rem 1.4rem;
            border-radius: 50px;
            font-size: 0.85rem;
            font-weight: 600;
            letter-spacing: 0.5px;
            margin-bottom: 1rem;
            border: 1px solid rgba(255, 182, 193, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .signup-badge:hover {
            background: rgba(255, 182, 193, 0.2);
            transform: translateY(-2px);
        }

        .brand-tagline h2 {
            font-size: 3.2rem;
            font-weight: 700;
            color: white;
            margin-bottom: 0.5rem;
            line-height: 1.1;
            background: linear-gradient(135deg, #fff, #f093fb);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .brand-tagline p {
            font-size: 1.1rem;
            color: #94a3b8;
            font-weight: 400;
            letter-spacing: 0.5px;
        }

        .brand-stats {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2rem;
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 182, 193, 0.06);
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .stat-number {
            font-size: 1.4rem;
            font-weight: 700;
            color: white;
        }

        .stat-label {
            font-size: 0.75rem;
            color: #94a3b8;
            font-weight: 500;
            margin-top: 2px;
        }

        .stat-divider {
            width: 1px;
            height: 30px;
            background: rgba(255, 182, 193, 0.06);
        }

        .brand-testimonial {
            margin-top: 2rem;
            padding: 1rem 1.5rem;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 16px;
            border: 1px solid rgba(255, 182, 193, 0.04);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .brand-testimonial:hover {
            background: rgba(255, 255, 255, 0.05);
            transform: translateY(-2px);
        }

        .testimonial-stars {
            color: #f5b042;
            font-size: 0.8rem;
            letter-spacing: 3px;
            margin-bottom: 0.2rem;
        }

        .brand-testimonial p {
            color: #e2e8f0;
            font-size: 0.95rem;
            font-style: italic;
            margin-bottom: 0.1rem;
        }

        .brand-testimonial span {
            color: #94a3b8;
            font-size: 0.75rem;
        }

        /* ============================================
           RIGHT - LOGIN FORM (Admin Version)
           ============================================ */
        .login-form-wrapper {
            padding: 2rem 2.5rem;
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
            overflow-y: auto;
        }

        .login-form-wrapper::-webkit-scrollbar {
            width: 4px;
        }

        .login-form-wrapper::-webkit-scrollbar-track {
            background: transparent;
        }

        .login-form-wrapper::-webkit-scrollbar-thumb {
            background: #f093fb;
            border-radius: 10px;
        }

        .login-form {
            width: 100%;
            max-width: 420px;
        }

        .form-decoration {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin-bottom: 0.75rem;
            justify-content: center;
        }

        .deco-line {
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, transparent, #f093fb, transparent);
            max-width: 80px;
        }

        .deco-icon {
            font-size: 1.4rem;
            animation: pulse 2s ease-in-out infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.2); }
        }

        .language-selector {
            display: flex;
            justify-content: flex-end;
            margin-bottom: 0.5rem;
        }

        .lang-btn {
            display: flex;
            align-items: center;
            gap: 6px;
            padding: 0.25rem 1rem;
            border: 1px solid rgba(226, 232, 240, 0.3);
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.5);
            color: #64748b;
            font-size: 0.8rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .lang-btn:hover {
            border-color: #f093fb;
            color: #f093fb;
            transform: translateY(-1px);
        }

        .form-header {
            margin-bottom: 1.2rem;
            text-align: center;
        }

        .header-icon {
            width: 54px;
            height: 54px;
            background: linear-gradient(135deg, #f093fb, #f5576c);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 0.6rem;
            font-size: 1.6rem;
            color: white;
            box-shadow: 0 8px 30px rgba(245, 87, 108, 0.2);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .header-icon:hover {
            transform: scale(1.05) rotate(-5deg);
        }

        .form-header h2 {
            font-size: 1.6rem;
            font-weight: 700;
            color: #1a1a2e;
            letter-spacing: -0.5px;
        }

        .form-header p {
            color: #94a3b8;
            font-size: 0.85rem;
            margin-top: 0.1rem;
        }

        .login-form-fields {
            display: flex;
            flex-direction: column;
            gap: 0.8rem;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 0.3rem;
            transition: all 0.3s ease;
        }

        .form-group.has-error .form-input {
            border-color: #f5576c;
            box-shadow: 0 0 0 3px rgba(245, 87, 108, 0.1);
        }

        .form-group label {
            font-weight: 500;
            color: #1a1a2e;
            font-size: 0.8rem;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .form-group label i {
            color: #f5576c;
            font-size: 0.75rem;
        }

        .input-wrapper {
            position: relative;
        }

        .form-input {
            width: 100%;
            padding: 0.65rem 1rem;
            border: 2px solid rgba(226, 232, 240, 0.6);
            border-radius: 10px;
            font-size: 0.9rem;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            background: rgba(255, 255, 255, 0.5);
            color: #1a1a2e;
            position: relative;
            z-index: 1;
        }

        .form-input:focus {
            outline: none;
            border-color: #f093fb;
            background: white;
            box-shadow: 0 0 0 4px rgba(240, 147, 251, 0.06);
            transform: translateY(-1px);
        }

        .form-input:focus + .input-focus {
            transform: scaleX(1);
        }

        .form-input::placeholder {
            color: #94a3b8;
            font-size: 0.85rem;
        }

        .input-focus {
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, #f093fb, #f5576c);
            transform: scaleX(0);
            transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            border-radius: 0 0 10px 10px;
            z-index: 2;
        }

        .password-toggle {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: #94a3b8;
            cursor: pointer;
            padding: 4px 6px;
            transition: color 0.3s ease;
            z-index: 3;
            font-size: 0.85rem;
        }

        .password-toggle:hover {
            color: #f5576c;
        }

        .error-message {
            font-size: 0.65rem;
            color: #f5576c;
            margin-top: 0.05rem;
            animation: shake 0.4s ease;
        }

        @keyframes shake {
            0%, 100% { transform: translateX(0); }
            25% { transform: translateX(-5px); }
            75% { transform: translateX(5px); }
        }

        .form-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: -0.1rem;
        }

        .remember-me {
            display: flex;
            align-items: center;
            gap: 0.4rem;
            font-size: 0.8rem;
            color: #64748b;
            cursor: pointer;
        }

        .remember-me input[type="checkbox"] {
            display: none;
        }

        .checkmark {
            width: 16px;
            height: 16px;
            border: 2px solid #cbd5e1;
            border-radius: 5px;
            display: inline-block;
            position: relative;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            flex-shrink: 0;
        }

        .remember-me input:checked + .checkmark {
            background: linear-gradient(135deg, #f093fb, #f5576c);
            border-color: #f093fb;
            box-shadow: 0 2px 8px rgba(240, 147, 251, 0.15);
        }

        .remember-me input:checked + .checkmark::after {
            content: '✓';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            color: white;
            font-size: 10px;
        }

        .forgot-link {
            color: #f5576c;
            text-decoration: none;
            font-size: 0.8rem;
            font-weight: 500;
            transition: color 0.3s ease;
            cursor: pointer;
        }

        .forgot-link:hover {
            color: #f093fb;
            text-decoration: underline;
        }

        .login-btn {
            width: 100%;
            padding: 0.75rem;
            border: none;
            border-radius: 10px;
            background: linear-gradient(135deg, #f093fb, #f5576c);
            color: white;
            font-size: 0.9rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            letter-spacing: 0.3px;
            position: relative;
            overflow: hidden;
        }

        .login-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.15), transparent);
            transition: left 0.5s ease;
        }

        .login-btn:hover:not(:disabled)::before {
            left: 100%;
        }

        .login-btn:hover:not(:disabled) {
            transform: translateY(-3px);
            box-shadow: 0 8px 30px rgba(245, 87, 108, 0.35);
        }

        .login-btn:active:not(:disabled) {
            transform: scale(0.98);
        }

        .login-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
        }

        .divider {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            margin: 0.1rem 0;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(226, 232, 240, 0.5);
        }

        .divider span {
            color: #94a3b8;
            font-size: 0.75rem;
            white-space: nowrap;
        }

        .google-btn {
            width: 100%;
            padding: 0.6rem;
            border: 2px solid rgba(226, 232, 240, 0.5);
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.5);
            color: #1a1a2e;
            font-size: 0.85rem;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .google-btn:hover {
            border-color: #f093fb;
            background: rgba(255, 255, 255, 0.8);
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        }

        .google-btn svg {
            flex-shrink: 0;
        }

        .spinner {
            width: 18px;
            height: 18px;
            border: 2px solid rgba(255, 255, 255, 0.3);
            border-top-color: white;
            border-radius: 50%;
            animation: spin 0.8s linear infinite;
            display: inline-block;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        .form-footer {
            margin-top: 1rem;
            text-align: center;
        }

        .form-footer p {
            color: #64748b;
            font-size: 0.8rem;
        }

        .signup-link {
            color: #f5576c;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 3px;
            font-size: 0.8rem;
        }

        .signup-link:hover {
            color: #f093fb;
        }

        .signup-link i {
            transition: transform 0.3s ease;
            font-size: 0.7rem;
        }

        .signup-link:hover i {
            transform: translateX(3px);
        }

        .brand-credit {
            margin-top: 0.8rem;
            padding-top: 0.6rem;
            border-top: 1px solid rgba(241, 245, 249, 0.3);
            text-align: center;
        }

        .brand-credit span {
            font-size: 0.7rem;
            color: #94a3b8;
        }

        /* ============================================
           RESPONSIVE
           ============================================ */
        @media (max-width: 992px) {
            .login-container {
                grid-template-columns: 1fr 1fr;
            }
            
            .login-brand {
                padding: 2.5rem 2rem;
            }
            
            .brand-tagline h2 {
                font-size: 2.5rem;
            }
            
            .login-form-wrapper {
                padding: 1.5rem 2rem;
            }
        }

        @media (max-width: 768px) {
            .login-container {
                grid-template-columns: 1fr;
                height: 100vh;
                overflow-y: auto;
            }
            
            .login-brand {
                height: auto;
                padding: 2rem 1.5rem;
                min-height: 40vh;
            }
            
            .login-form-wrapper {
                height: auto;
                padding: 1.5rem 1.5rem;
                min-height: 60vh;
            }
            
            .brand-tagline h2 {
                font-size: 2rem;
            }
            
            .brand-stats {
                gap: 1rem;
            }
            
            .stat-divider {
                display: none;
            }
            
            .brand-testimonial {
                display: none;
            }
            
            .bg-elements {
                display: none;
            }
            
            .floating-elements {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .login-brand {
                padding: 1.5rem 1rem;
                min-height: 30vh;
            }
            
            .login-form-wrapper {
                padding: 1rem 1rem;
                min-height: 70vh;
            }
            
            .brand-logo {
                margin-bottom: 1.5rem;
            }
            
            .brand-name {
                font-size: 1.6rem;
            }
            
            .logo-icon {
                width: 44px;
                height: 44px;
            }
            
            .brand-tagline h2 {
                font-size: 1.6rem;
            }
            
            .brand-tagline p {
                font-size: 0.9rem;
            }
            
            .brand-stats {
                gap: 0.5rem;
                margin-top: 1.5rem;
                padding-top: 1rem;
            }
            
            .stat-number {
                font-size: 1.1rem;
            }
            
            .stat-label {
                font-size: 0.6rem;
            }
            
            .form-header h2 {
                font-size: 1.3rem;
            }
            
            .form-header p {
                font-size: 0.75rem;
            }
            
            .header-icon {
                width: 44px;
                height: 44px;
                font-size: 1.2rem;
            }
            
            .form-input {
                padding: 0.55rem 0.8rem;
                font-size: 0.8rem;
            }
            
            .login-btn {
                padding: 0.6rem;
                font-size: 0.8rem;
            }
            
            .google-btn {
                padding: 0.5rem;
                font-size: 0.8rem;
            }
            
            .form-decoration {
                margin-bottom: 0.5rem;
            }
            
            .deco-icon {
                font-size: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="admin-login-page">
        <!-- Background Overlay -->
        <div class="bg-overlay"></div>
        
        <!-- Animated Background Elements -->
        <div class="bg-elements">
            <span class="bg-element">🌸</span>
            <span class="bg-element">💄</span>
            <span class="bg-element">✨</span>
            <span class="bg-element">🌺</span>
            <span class="bg-element">💫</span>
            <span class="bg-element">🦋</span>
            <span class="bg-element">🌹</span>
            <span class="bg-element">💖</span>
        </div>

        <div class="login-container">
            <!-- Left Side - Brand Section -->
            <div class="login-brand">
                <div class="brand-content">
                    <div class="floating-elements">
                        <span class="float-element">🌸</span>
                        <span class="float-element">💄</span>
                        <span class="float-element">✨</span>
                        <span class="float-element">🌺</span>
                        <span class="float-element">💫</span>
                        <span class="float-element">🦋</span>
                    </div>

                    <div class="brand-logo">
                        <div class="logo-icon">
                            <svg viewBox="0 0 40 40" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <rect width="40" height="40" rx="12" fill="url(#logoGrad)"/>
                                <path d="M12 20L18 14L24 20L18 26L12 20Z" fill="white"/>
                                <path d="M18 14L24 20L30 14L24 8L18 14Z" fill="rgba(255,255,255,0.7)"/>
                                <path d="M12 20L18 26L24 20L18 14L12 20Z" fill="rgba(255,255,255,0.4)"/>
                                <defs>
                                    <linearGradient id="logoGrad" x1="0" y1="0" x2="40" y2="40">
                                        <stop offset="0%" stop-color="#f093fb"/>
                                        <stop offset="50%" stop-color="#f5576c"/>
                                        <stop offset="100%" stop-color="#ffecd2"/>
                                    </linearGradient>
                                </defs>
                            </svg>
                        </div>
                        <span class="brand-name">Chhouk<span class="brand-highlight">Shop</span></span>
                    </div>

                    <div class="brand-tagline">
                        <span class="signup-badge">
                            <i class="fas fa-shield-alt"></i> Admin Access
                        </span>
                        <h2>Admin Panel</h2>
                        <p>Manage your beauty store</p>
                    </div>

                    <div class="brand-stats">
                        <div class="stat-item">
                            <span class="stat-number">50K+</span>
                            <span class="stat-label">Happy Girls</span>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <span class="stat-number">4.9★</span>
                            <span class="stat-label">Love Rating</span>
                        </div>
                        <div class="stat-divider"></div>
                        <div class="stat-item">
                            <span class="stat-number">500+</span>
                            <span class="stat-label">Products</span>
                        </div>
                    </div>

                    <div class="brand-testimonial">
                        <div class="testimonial-stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                        <p>"Absolutely love this shop! ✨"</p>
                        <span>- Sarah, Verified Buyer</span>
                    </div>
                </div>
            </div>

            <!-- Right Side - Login Form -->
            <div class="login-form-wrapper">
                <div class="login-form">
                    <div class="form-decoration">
                        <span class="deco-line"></span>
                        <span class="deco-icon">💖</span>
                        <span class="deco-line"></span>
                    </div>

                    <div class="language-selector">
                        <button class="lang-btn">
                            <i class="fas fa-globe"></i>
                            EN
                            <i class="fas fa-chevron-down"></i>
                        </button>
                    </div>

                    <div class="form-header">
                        <div class="header-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <h2>Admin Login</h2>
                        <p>Enter your admin credentials</p>
                    </div>

                    <form method="POST" action="{{ route('admin.login.submit') }}" class="login-form-fields">
                        @csrf

                        <div class="form-group">
                            <label>
                                <i class="fas fa-envelope"></i>
                                Email Address
                            </label>
                            <div class="input-wrapper">
                                <input 
                                    type="email" 
                                    name="email"
                                    class="form-input" 
                                    placeholder="admin@glowbeauty.com"
                                    value="{{ old('email') }}"
                                    required
                                >
                                <div class="input-focus"></div>
                            </div>
                            @error('email')
                                <span class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-group">
                            <label>
                                <i class="fas fa-lock"></i>
                                Password
                            </label>
                            <div class="input-wrapper">
                                <input 
                                    :type="showPassword ? 'text' : 'password'" 
                                    name="password"
                                    class="form-input" 
                                    placeholder="••••••••"
                                    required
                                >
                                <button 
                                    type="button" 
                                    class="password-toggle"
                                    onclick="togglePassword()"
                                >
                                    <i class="fas fa-eye" id="toggleIcon"></i>
                                </button>
                                <div class="input-focus"></div>
                            </div>
                            @error('password')
                                <span class="error-message"><i class="fas fa-exclamation-circle"></i> {{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-options">
                            <label class="remember-me">
                                <input type="checkbox" name="remember">
                                <span class="checkmark"></span>
                                Remember me
                            </label>
                            <a href="#" class="forgot-link" onclick="event.preventDefault(); alert('Contact admin to reset password.')">Forgot Password?</a>
                        </div>

                        <button type="submit" class="login-btn" id="loginBtn">
                            <i class="fas fa-sign-in-alt"></i>
                            <span>Login as Admin</span>
                        </button>

                        <div class="divider">
                            <span>Secure access</span>
                        </div>

                        <a href="/" class="google-btn">
                            <i class="fas fa-arrow-left"></i>
                            Back to Store
                        </a>
                    </form>

                    <div class="form-footer">
                        <p>
                            <i class="fas fa-shield-alt"></i> 
                            This area is restricted to authorized administrators only.
                        </p>
                    </div>

                    <div class="brand-credit">
                        <span>Made with 💖 for beautiful souls</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const password = document.getElementById('password');
            const icon = document.getElementById('toggleIcon');
            if (password.type === 'password') {
                password.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                password.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }

        // Show loading state on submit
        document.querySelector('form').addEventListener('submit', function() {
            const btn = document.getElementById('loginBtn');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner"></span> Logging in...';
        });
    </script>
</body>
</html>