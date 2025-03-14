<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Departments</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        h1 {
            color: #333;
        }

        form {
            background-color: #fff;
            padding: 50px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            width: 300px;
        }

        input[type="text"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        button {
            width: 100%;
            padding: 10px;
            background-color:#007bff;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: lightblue;
        }

        @media (max-width: 480px) {
            body {
                padding: 10px;
            }

            form {
                width: 100%;
            }
        }
    </style>
</head>
<body>
@include('partials.nav-management')
    @if(session('success'))
        <script>alert("{{ session('success') }}");</script>
    @endif

    <h1>Add Department</h1>
    <form action="{{ route('departments.store') }}" method="POST" onsubmit="setParentDepartment()">
        @csrf
        <input type="text" name="dep_name" id="dep_name" placeholder="Department Name" required>
        <input type="hidden" name="parent_department" id="parent_department">
        <input type="text" id="parent_dep_name" placeholder="Parent Department (Optional)">
        <button type="submit">Add Department</button>
    </form>

    <h1>Delete Department</h1>
    <form action="{{ route('departments.destroy') }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this department?');">
        @csrf
        <input type="text" name="dep_name" id="delete_dep_name" placeholder="Department Name" required>
        <button type="submit">Delete Department</button>
    </form>

    <script>
        function setParentDepartment() {
            const parentDepName = document.getElementById('parent_dep_name').value;
            document.getElementById('parent_department').value = parentDepName;
        }
    </script>
</body>
</html>