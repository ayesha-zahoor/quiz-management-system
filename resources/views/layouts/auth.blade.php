
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Quiz Management System')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">

    <style>
        :root {
            --navy: #0B1120;
            --lime: #84CC16;
            --lime-dark: #65A30D;
            --white: #FFFFFF;
            --off-white: #F8FAFC;
            --slate: #64748B;
            --dark-text: #111827;
            --border: #E2E8F0;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            min-height: 100vh;
            background: var(--off-white);
            color: var(--dark-text);
            font-family: Inter, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
        }

        .auth-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: stretch;
        }

        .auth-brand-panel {
            width: 48%;
            min-height: 100vh;
            background: var(--lime);
            position: relative;
            overflow: hidden;
            display: flex;
            align-items: center;
            padding: 70px;
        }

        .auth-brand-panel::before {
            content: "";
            position: absolute;
            width: 420px;
            height: 420px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.12);
            top: -180px;
            right: -150px;
        }

        .auth-brand-panel::after {
            content: "";
            position: absolute;
            width: 320px;
            height: 320px;
            border-radius: 50%;
            background: rgba(11, 17, 32, 0.08);
            bottom: -130px;
            left: -120px;
        }

        .brand-content {
            position: relative;
            z-index: 2;
            max-width: 560px;
        }

        .brand-mark {
            width: 58px;
            height: 58px;
            border-radius: 16px;
            background: var(--navy);
            color: var(--lime);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 27px;
            margin-bottom: 30px;
        }

        .brand-eyebrow {
            color: rgba(11, 17, 32, 0.68);
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 12px;
        }

        .brand-title {
            color: var(--navy);
            font-size: clamp(38px, 4vw, 58px);
            line-height: 1.05;
            font-weight: 800;
            letter-spacing: -2px;
            margin-bottom: 22px;
        }

        .brand-description {
            color: rgba(11, 17, 32, 0.78);
            font-size: 17px;
            line-height: 1.7;
            max-width: 480px;
            margin-bottom: 42px;
        }

        .quiz-visual {
            width: 100%;
            max-width: 470px;
            padding: 24px;
            background: rgba(255, 255, 255, 0.88);
            border: 1px solid rgba(255, 255, 255, 0.8);
            border-radius: 20px;
            box-shadow: 0 20px 45px rgba(11, 17, 32, 0.10);
        }

        .quiz-visual-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
        }

        .quiz-visual-title {
            font-size: 14px;
            font-weight: 700;
            color: var(--navy);
        }

        .quiz-progress {
            height: 7px;
            background: #E2E8F0;
            border-radius: 20px;
            overflow: hidden;
            margin-bottom: 20px;
        }

        .quiz-progress span {
            display: block;
            width: 68%;
            height: 100%;
            background: var(--lime);
        }

        .quiz-question {
            font-size: 16px;
            font-weight: 700;
            line-height: 1.5;
            color: var(--dark-text);
            margin-bottom: 16px;
        }

        .quiz-option {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 14px;
            border: 1px solid var(--border);
            border-radius: 10px;
            margin-bottom: 9px;
            font-size: 13px;
            color: var(--slate);
        }

        .quiz-option.active {
            border-color: var(--lime);
            background: rgba(132, 204, 22, 0.10);
            color: var(--dark-text);
        }

        .quiz-option-icon {
            width: 22px;
            height: 22px;
            border: 1px solid #CBD5E1;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
        }

        .quiz-option.active .quiz-option-icon {
            background: var(--lime);
            border-color: var(--lime);
            color: var(--navy);
        }

        .auth-form-panel {
            width: 52%;
            min-height: 100vh;
            background: var(--white);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px;
        }

        .auth-form-container {
            width: 100%;
            max-width: 450px;
        }

        .mobile-brand {
            display: none;
        }

        @media (max-width: 992px) {
            .auth-brand-panel {
                width: 42%;
                padding: 40px;
            }

            .auth-form-panel {
                width: 58%;
                padding: 35px;
            }

            .brand-title {
                font-size: 40px;
            }

            .quiz-visual {
                display: none;
            }
        }

        @media (max-width: 768px) {
            .auth-wrapper {
                display: block;
            }

            .auth-brand-panel {
                display: none;
            }

            .auth-form-panel {
                width: 100%;
                min-height: 100vh;
                padding: 30px 20px;
            }

            .mobile-brand {
                display: flex;
                align-items: center;
                gap: 12px;
                margin-bottom: 35px;
            }

            .mobile-brand-mark {
                width: 42px;
                height: 42px;
                border-radius: 11px;
                background: var(--lime);
                color: var(--navy);
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 19px;
            }

            .mobile-brand-name {
                font-weight: 800;
                color: var(--navy);
            }
        }
    </style>

    @stack('styles')
</head>

<body>

    <div class="auth-wrapper">

        <section class="auth-brand-panel">
            <div class="brand-content">

                <div class="brand-mark">
                    <i class="bi bi-patch-question-fill"></i>
                </div>

                <div class="brand-eyebrow">
                    Multi-Tenant Learning Platform
                </div>

                <h1 class="brand-title">
                    Quiz Management System
                </h1>

                <p class="brand-description">
                    A voice-enabled quiz platform designed for interactive learning
                    and quizzes across Classes 1–12.
                </p>

                <div class="quiz-visual">

                    <div class="quiz-visual-header">
                        <span class="quiz-visual-title">
                            Science Quiz
                        </span>

                        <span class="small text-secondary">
                            7 / 10
                        </span>
                    </div>

                    <div class="quiz-progress">
                        <span></span>
                    </div>

                    <div class="quiz-question">
                        Which planet is known as the Red Planet?
                    </div>

                    <div class="quiz-option">
                        <span class="quiz-option-icon"></span>
                        Earth
                    </div>

                    <div class="quiz-option active">
                        <span class="quiz-option-icon">
                            <i class="bi bi-check"></i>
                        </span>
                        Mars
                    </div>

                    <div class="quiz-option">
                        <span class="quiz-option-icon"></span>
                        Jupiter
                    </div>

                    <div class="quiz-option">
                        <span class="quiz-option-icon"></span>
                        Venus
                    </div>

                </div>

            </div>
        </section>

        <section class="auth-form-panel">

            <div class="auth-form-container">

                <div class="mobile-brand">
                    <div class="mobile-brand-mark">
                        <i class="bi bi-patch-question-fill"></i>
                    </div>

                    <div class="mobile-brand-name">
                        Quiz Management System
                    </div>
                </div>

                @yield('content')

            </div>

        </section>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>

    @stack('scripts')

</body>
</html>

