<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            text-align: center;
            padding-top: 50px;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #4CAF50;
        }

        p {
            color: #333;
            font-size: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Success</h1>
        <p>Submitted successfully!</p>
    </div>

    <script>
        // Redirect to the specified page after a delay
        setTimeout(function() {
            window.location.href = "?page=reports/fileReport";
        }, 1000); // Redirect after 3 seconds
    </script>
</body>
</html>
