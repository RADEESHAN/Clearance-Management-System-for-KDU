<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Staff</title>
    <style>
        /* Add your CSS here */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 50%;
            margin: 50px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }

        h1 {
            color: #343a40;
        }

        label {
            display: block;
            margin: 10px 0 5px;
        }

        input[type="text"],
        input[type="email"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ced4da;
            border-radius: 5px;
            margin-bottom: 15px;
        }

        button {
            background-color: #007bff;
            color: #ffffff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #0056b3;
        }

        .alert {
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #d4edda;
            color: #155724;
        }
    </style>
</head>
<body>
@include('partials.nav-management')
    <div class="container">
        @if(session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h1>Add Staff</h1>
        <form action="{{ route('departments.add') }}" method="POST">
            @csrf
            <label for="reg_no">Registration Number</label>
            <input type="text" name="reg_no" id="reg_no" required>

            <label for="user_name">User Name</label>
            <input type="text" name="user_name" id="user_name" required>

            <label for="email">Email</label>
            <input type="email" name="email" id="email" required>

            <label for="dep_id">Department</label>
            <select name="dep_id" id="dep_id" required>
                @foreach($departments as $department)
                    <option value="{{ $department->id }}">{{ $department->dep_name }}</option>
                @endforeach
            </select>

            <button type="submit">Add Staff</button>
        </form>
    </div>
</body>
</html>