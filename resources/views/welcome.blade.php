<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Zuno PHP Framework</title>
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/themes/prism-tomorrow.min.css" rel="stylesheet" />
        <style>
            * {
                margin: 0;
                padding: 0;
                box-sizing: border-box;
            }

            body {
                font-family: 'Poppins', sans-serif;
                background-color: #1e1e1e;
                color: #ffffff;
                line-height: 1.6;
            }

            .container {
                max-width: 1200px;
                margin: 0 auto;
                padding: 20px;
            }

            .navbar {
                display: flex;
                justify-content: space-between;
                align-items: center;
                padding: 20px 0;
            }

            .logo {
                font-size: 2rem;
                font-weight: bold;
                color: #4CAF50;
                /* Green color */
            }

            .github-button {
                background: #4CAF50;
                color: white;
                padding: 10px 16px;
                font-size: 1rem;
                border-radius: 4px;
                text-decoration: none;
                transition: 0.3s;
            }

            .github-button:hover {
                background: #45a049;
                /* Darker green on hover */
            }

            header {
                text-align: center;
                padding: 60px 0;
            }

            header h1 {
                font-size: 3rem;
                color: #4CAF50;
                margin-bottom: 10px;
            }

            header p {
                font-size: 1.2rem;
                color: #ccc;
            }

            .features {
                display: flex;
                flex-wrap: wrap;
                gap: 20px;
                margin: 40px 0;
            }

            .feature {
                background-color: #2d2d2d;
                padding: 20px;
                border-radius: 8px;
                flex: 1 1 calc(33.333% - 40px);
                text-align: center;
            }

            .feature h2 {
                font-size: 1.5rem;
                color: #4CAF50;
                margin-bottom: 10px;
            }

            .feature p {
                color: #ccc;
            }

            .installation {
                background-color: #2d2d2d;
                padding: 20px;
                border-radius: 8px;
                margin: 40px 0;
            }

            .installation h2 {
                font-size: 2rem;
                color: #4CAF50;
                margin-bottom: 20px;
            }

            /* Code Block Styling */
            .code-block {
                background-color: #1e1e1e;
                padding: 15px;
                border-radius: 8px;
                position: relative;
            }

            .code-block pre {
                margin: 0;
            }

            .code-block code {
                display: block;
                white-space: pre-wrap;
                word-wrap: break-word;
            }

            /* Copy Button Styling */
            .copy-button {
                position: absolute;
                top: 10px;
                right: 10px;
                background-color: #4CAF50;
                color: white;
                border: none;
                padding: 8px 12px;
                border-radius: 4px;
                cursor: pointer;
                font-size: 0.9rem;
            }

            .copy-button:hover {
                background-color: #45a049;
            }

            .cta {
                text-align: center;
                padding: 60px 0;
            }

            .cta h2 {
                font-size: 2.5rem;
                color: #4CAF50;
                margin-bottom: 20px;
            }

            .cta a {
                background-color: #4CAF50;
                color: white;
                padding: 12px 24px;
                border-radius: 4px;
                text-decoration: none;
                font-size: 1.2rem;
            }

            .cta a:hover {
                background-color: #45a049;
            }

            footer {
                text-align: center;
                padding: 20px 0;
                border-top: 1px solid #444;
                margin-top: 40px;
            }

            footer p {
                color: #ccc;
            }
        </style>
    </head>

    <body>
        <div class="container">
            <div class="navbar">
                <div class="logo">Zuno</div>
                <a href="https://github.com/techmahedy/zunoo" target="_blank" class="github-button">View on GitHub</a>
            </div>
            <section class="features">
                <div class="feature">
                    <h2>Routing</h2>
                    <p>Routing with middleware, naming route.</p>
                </div>
                <div class="feature">
                    <h2>Pool Console</h2>
                    <p>Pool console to quickly create model, controller, mail etc</p>
                </div>
                <div class="feature">
                    <h2>Authentication</h2>
                    <p>Session and cookie based secured authentication</p>
                </div>
                <div class="feature">
                    <h2>Service Container</h2>
                    <p>Powerful service container to resolve class based dependency</p>
                </div>
                <div class="feature">
                    <h2>Database Migration</h2>
                    <p>Create migration seeder using pool console command</p>
                </div>
                <div class="feature">
                    <h2>Mail</h2>
                    <p>Seamlessly send emails with built-in support for SMTP</p>
                </div>
            </section>
            <section class="installation">
                <h2>Authentication</h2>
                <div class="code-block">
                    <button class="copy-button" onclick="copyCode()">Copy Code</button>
                    <pre><code class="language-bash">php pool make:auth</code></pre>
                </div>
            </section>
        </div>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/prism.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/prism/1.29.0/components/prism-bash.min.js"></script>
        <script>
            function copyCode() {
                const code = document.querySelector('.code-block code').innerText;
                navigator.clipboard.writeText(code)
                    .then(() => {
                        alert('Code copied to clipboard!');
                    })
                    .catch((err) => {
                        console.error('Failed to copy code: ', err);
                    });
            }
        </script>
    </body>

</html>
