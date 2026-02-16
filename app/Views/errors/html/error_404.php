<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 - Page Not Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f8ff;
            color: #333;
            text-align: center;
            margin: 0;
            padding: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            height: 100vh;
            position: relative; /* For rain positioning */
            overflow: hidden;
        }
        .cloud-container {
            margin-bottom: 20px;
            position: relative;
        }
        .cloud {
            font-size: 120px; /* Larger emoji for better visibility */
            filter: grayscale(100%) brightness(0.6); /* Pure gray with slightly darker tone for better stormy effect */
            animation: float 3s ease-in-out infinite;
            display: block;
            margin: 0 auto;
        }
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
        /* 8 Raindrop dots around the cloud, falling down */
        .raindrop {
            position: absolute;
            width: 6px;
            height: 6px;
            background-color: #4A90E2;
            border-radius: 50%; /* Round dots */
            top: 80px; /* Start from below emoji cloud */
            animation: fall linear infinite;
            opacity: 0;
        }
        .raindrop:nth-child(1) {
            left: calc(50% - 50px);
            animation-duration: 1.5s;
            animation-delay: 0s;
            opacity: 1;
        }
        .raindrop:nth-child(2) {
            left: calc(50% - 30px);
            animation-duration: 1.2s;
            animation-delay: 0.2s;
            opacity: 1;
        }
        .raindrop:nth-child(3) {
            left: calc(50% - 10px);
            animation-duration: 1.0s;
            animation-delay: 0.4s;
            opacity: 1;
        }
        .raindrop:nth-child(4) {
            left: calc(50% + 10px);
            animation-duration: 1.3s;
            animation-delay: 0.6s;
            opacity: 1;
        }
        .raindrop:nth-child(5) {
            left: calc(50% + 30px);
            animation-duration: 1.1s;
            animation-delay: 0.8s;
            opacity: 1;
        }
        .raindrop:nth-child(6) {
            left: calc(50% - 40px);
            animation-duration: 1.4s;
            animation-delay: 1.0s;
            opacity: 1;
        }
        .raindrop:nth-child(7) {
            left: calc(50% + 40px);
            animation-duration: 0.9s;
            animation-delay: 1.2s;
            opacity: 1;
        }
        .raindrop:nth-child(8) {
            left: calc(50%);
            animation-duration: 1.6s;
            animation-delay: 1.4s;
            opacity: 1;
        }
        @keyframes fall {
            0% {
                top: 80px; /* Start around cloud base */
                opacity: 1;
            }
            100% {
                top: 100vh;
                opacity: 0;
            }
        }
        .error-code {
            font-size: 120px;
            font-weight: bold;
            color: #ff0000; /* Red as before */
            margin: 0;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
        }
        .message {
            font-size: 24px;
            margin: 10px 0;
            color: #666;
        }
        .sub-message {
            font-size: 16px;
            color: #999;
            margin-top: 20px;
        }
        a {
            color: #87CEEB;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="cloud-container">
        <div class="cloud">☁️</div> <!-- Emoji cloud with adjusted gray filter -->
        <!-- 8 Falling raindrop dots around the cloud -->
        <div class="raindrop"></div>
        <div class="raindrop"></div>
        <div class="raindrop"></div>
        <div class="raindrop"></div>
        <div class="raindrop"></div>
        <div class="raindrop"></div>
        <div class="raindrop"></div>
        <div class="raindrop"></div>
    </div>
    <h1 class="error-code">404</h1>
    <p class="message">Hmmm.... Can't Reach This Page</p>
    <p class="sub-message">Oops! The page you're looking for doesn't exist. <a href="<?= base_url('/') ?>">Go Home</a></p>
</body>
</html>


<!-- <!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>404 - Page Not Found</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light d-flex justify-content-center align-items-center vh-100">

    <div class="text-center">
        <strong>
        <h1 class="display-1 text-danger">404</h1>
       <h2 class="mb-3">❌ Hmmm.... Can't reach this page </h2> 
        <p class="text-muted mb-4">
            The page you are looking for doesn't exist or may have been removed.
        </p></strong>
        <a href="<?= base_url('/') ?>" class="btn btn-primary">🏠 Return to Home</a>
    </div>

</body>

</html> -->
