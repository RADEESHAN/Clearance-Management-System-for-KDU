<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Import Users</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #e9ecef;
            margin: 0;
            padding: 0;
        }

        .container {
            background-color: #ffffff;
            padding: 40px;
            border-radius: 15px;
            box-shadow: 0 15px 30px rgba(0, 0, 0, 0.2);
            width: 100%;
            max-width: 450px;
            text-align: center;
            margin: 100px auto 0;
        }

        h1 {
            color: #495057;
            margin-bottom: 30px;
            font-size: 32px;
            letter-spacing: 1px;
            text-transform: uppercase;
            font-weight: 700;
        }

        input[type="file"] {
            margin-bottom: 20px;
            padding: 12px;
            font-size: 16px;
            border: 2px solid #ced4da;
            border-radius: 8px;
            width: 100%;
            cursor: pointer;
            box-sizing: border-box;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        input[type="file"]:focus {
            border-color: #007bff;
            box-shadow: 0 0 8px rgba(0, 123, 255, 0.25);
        }

        button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 15px 30px;
            border-radius: 30px;
            cursor: pointer;
            font-size: 18px;
            font-weight: 600;
            transition: background-color 0.3s ease, transform 0.2s ease;
            width: 100%;
            max-width: 220px;
            box-sizing: border-box;
            margin-top: 20px;
        }

        button:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        #notification {
            display: none;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 10px;
            font-size: 16px;
            text-align: left;
            width: 100%;
            box-sizing: border-box;
            transition: opacity 0.3s ease;
        }

        #notification.success {
            background-color: #d1e7dd;
            color: #0f5132;
        }

        #notification.error {
            background-color: #f8d7da;
            color: #842029;
        }
    </style>
</head>
<body>
@include('partials.nav-management')
    <br><br><br>
    <div class="container">
        <h1>Import Users</h1>

        <div id="notification"></div>

        <form action="{{ route('users.import') }}" method="POST" enctype="multipart/form-data" onsubmit="return showNotification('success', 'Users imported successfully!')">
            @csrf
            <input type="file" name="file" required>
            <button type="submit">Import Users</button>
        </form>

        <br>

        <!-- Uncomment this form if you want to use it in the future
        <form action="{{ route('users.send-activation-emails') }}" method="POST" onsubmit="return showNotification('success', 'Activation emails sent!')">
            @csrf
            <button type="submit">Send Activation Emails</button>
        </form>
        -->
    </div>

    <script>
        function showNotification(type, message) {
            var notification = document.getElementById('notification');
            notification.style.display = 'block';
            notification.className = type;
            notification.innerHTML = message;
            setTimeout(function() {
                notification.style.display = 'none';
            }, 3000);
            return true;
        }
    </script>
</body>
</html>