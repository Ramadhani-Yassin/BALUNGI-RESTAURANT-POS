<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - Chwaka Inventory</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #333;
        }

        .error-container {
            background: white;
            border-radius: 20px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
            padding: 60px 40px;
            text-align: center;
            max-width: 500px;
            width: 90%;
            position: relative;
            overflow: hidden;
        }

        .error-container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 5px;
            background: linear-gradient(90deg, #ff6b6b, #4ecdc4, #45b7d1);
        }

        .error-icon {
            font-size: 80px;
            margin-bottom: 20px;
            color: #ff6b6b;
        }

        .error-code {
            font-size: 48px;
            font-weight: bold;
            color: #333;
            margin-bottom: 10px;
        }

        .error-title {
            font-size: 24px;
            color: #555;
            margin-bottom: 20px;
            font-weight: 600;
        }

        .error-message {
            font-size: 16px;
            color: #777;
            line-height: 1.6;
            margin-bottom: 40px;
        }

        .error-details {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 30px;
            text-align: left;
            font-family: 'Courier New', monospace;
            font-size: 14px;
            color: #666;
            border-left: 4px solid #ff6b6b;
        }

        .button-group {
            display: flex;
            gap: 15px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 30px;
            border: none;
            border-radius: 25px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            min-width: 140px;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 20px rgba(102, 126, 234, 0.3);
        }

        .btn-secondary {
            background: #f8f9fa;
            color: #666;
            border: 2px solid #e9ecef;
        }

        .btn-secondary:hover {
            background: #e9ecef;
            transform: translateY(-2px);
        }

        .home-link {
            margin-top: 30px;
            font-size: 14px;
            color: #999;
        }

        .home-link a {
            color: #667eea;
            text-decoration: none;
            font-weight: 600;
        }

        .home-link a:hover {
            text-decoration: underline;
        }

        @media (max-width: 480px) {
            .error-container {
                padding: 40px 20px;
            }
            
            .error-code {
                font-size: 36px;
            }
            
            .error-title {
                font-size: 20px;
            }
            
            .button-group {
                flex-direction: column;
                align-items: center;
            }
            
            .btn {
                width: 100%;
                max-width: 200px;
            }
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-icon">
            <?php
            $error_code = $_GET['code'] ?? '500';
            if ($error_code == '403') {
                echo '🔒';
            } elseif ($error_code == '404') {
                echo '🔍';
            } else {
                echo '⚠️';
            }
            ?>
        </div>
        
        <div class="error-code"><?php echo htmlspecialchars($error_code); ?></div>
        
        <div class="error-title">
            <?php
            if ($error_code == '403') {
                echo 'Access Forbidden';
            } elseif ($error_code == '404') {
                echo 'Page Not Found';
            } else {
                echo 'Server Error';
            }
            ?>
        </div>
        
        <div class="error-message">
            <?php
            if ($error_code == '403') {
                echo 'Sorry, you don\'t have permission to access this page. Please contact your administrator if you believe this is an error.';
            } elseif ($error_code == '404') {
                echo 'The page you\'re looking for doesn\'t exist. It might have been moved, deleted, or you entered the wrong URL.';
            } else {
                echo 'Something went wrong on our end. Our team has been notified and is working to fix the issue. Please try again later.';
            }
            ?>
        </div>

        <?php if (isset($_GET['details']) && $_GET['details']): ?>
        <div class="error-details">
            <strong>Error Details:</strong><br>
            <?php echo htmlspecialchars($_GET['details']); ?>
        </div>
        <?php endif; ?>

        <div class="button-group">
            <button class="btn btn-primary" onclick="goBack()">
                ← Go Back
            </button>
            
            <a href="/chwaka-inventory/adminSide/panel/" class="btn btn-secondary">
                Dashboard
            </a>
        </div>

        <div class="home-link">
            <a href="/chwaka-inventory/">← Back to Home</a>
        </div>
    </div>

    <script>
        function goBack() {
            if (document.referrer) {
                window.history.back();
            } else {
                window.location.href = '/chwaka-inventory/adminSide/panel/';
            }
        }

        // Auto-redirect after 10 seconds if user doesn't take action
        setTimeout(function() {
            if (confirm('Would you like to return to the dashboard?')) {
                window.location.href = '/chwaka-inventory/adminSide/panel/';
            }
        }, 10000);
    </script>
</body>
</html> 