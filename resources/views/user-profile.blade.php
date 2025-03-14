@extends('layouts.app')

@section('content')
<style>
    .profile-container {
        max-width: 800px;
        margin: 40px auto;
        background-color: #f8f9fa;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .profile-header {
        background: linear-gradient(135deg, #3366cc, #6699ff);
        color: white;
        padding: 30px;
        text-align: center;
        position: relative;
    }

    .profile-header h2 {
        font-size: 32px;
        margin: 0;
        font-weight: 600;
    }

    .profile-content {
        padding: 40px;
    }

    .info-group {
        margin-bottom: 25px;
        background-color: white;
        padding: 20px;
        border-radius: 10px;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.05);
        transition: all 0.3s ease;
        position: relative;
    }

    .info-group:hover {
        transform: translateY(-5px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
    }

    .info-group label {
        display: block;
        font-weight: 600;
        margin-bottom: 8px;
        color: #3366cc;
        font-size: 14px;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-text {
        font-size: 18px;
        color: #333;
        margin: 0;
        padding: 5px 0;
    }

    .row {
        display: flex;
        flex-wrap: wrap;
        margin-right: -15px;
        margin-left: -15px;
    }

    .col-md-6 {
        flex: 0 0 50%;
        max-width: 50%;
        padding-right: 15px;
        padding-left: 15px;
    }

    @media (max-width: 768px) {
        .col-md-6 {
            flex: 0 0 100%;
            max-width: 100%;
        }
    }

    .role-badge {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 14px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .role-super-admin { background-color: #ffd700; color: #333; }
    .role-management { background-color: #20b2aa; color: white; }
    .role-student { background-color: #ff6347; color: white; }
    .role-user { background-color: #778899; color: white; }

    .edit-icon {
        position: absolute;
        top: 10px;
        right: 10px;
        cursor: pointer;
        color: #3366cc;
        transition: color 0.3s ease;
        width: 24px;
        height: 24px;
    }

    .edit-icon:hover {
        color: #254e9e;
    }

    .edit-form {
        display: none;
        margin-top: 10px;
    }

    .edit-input {
        width: 100%;
        padding: 8px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 16px;
    }

    .edit-submit {
        background-color: #3366cc;
        color: white;
        border: none;
        padding: 8px 15px;
        border-radius: 4px;
        cursor: pointer;
        margin-top: 10px;
        transition: background-color 0.3s ease;
    }

    .edit-submit:hover {
        background-color: #254e9e;
    }

    .notification {
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        background-color: #4CAF50;
        color: white;
        border-radius: 5px;
        box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        transition: opacity 0.6s;
        z-index: 1000;
    }

    .notification.show {
        opacity: 1;
    }

    .logout-button {
        position: absolute;
        top: 20px;
        right: 20px;
        background-color: #dc3545;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 5px;
        cursor: pointer;
        transition: background-color 0.3s ease;
    }

    .logout-button:hover {
        background-color: #c82333;
    }
</style>

@include('partials.nav-management')

<div class="profile-container">
    <div class="profile-header">
        <h2>User Profile</h2>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
        <button onclick="confirmLogout()" class="logout-button">
            Logout
        </button>
    </div>
    <div class="profile-content">
        <div class="row">
            <div class="col-md-6">
                <div class="info-group">
                    <label>Name</label>
                    <p class="info-text">{{ $user->user_name ?? 'N/A' }}</p>
                    <!-- Remove the edit icon for the name field -->
                    <form class="edit-form" id="edit-name-form" onsubmit="updateProfile(event, 'user_name')">
                        @csrf
                        @method('PUT')
                        <input type="text" name="user_name" class="edit-input" value="{{ $user->user_name }}">
                        <button type="submit" class="edit-submit">Update</button>
                    </form>
                </div>
                <div class="info-group">
                    <label>Email</label>
                    <p class="info-text">{{ $user->email ?? 'N/A' }}</p>
                    <svg class="edit-icon" onclick="toggleEdit('email')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    <form class="edit-form" id="edit-email-form" onsubmit="updateProfile(event, 'email')">
                        @csrf
                        @method('PUT')
                        <input type="email" name="email" class="edit-input" value="{{ $user->email }}">
                        <button type="submit" class="edit-submit">Update</button>
                    </form>
                </div>
            </div>
            <div class="col-md-6">
                <div class="info-group">
                    <label>Register Number</label>
                    <p class="info-text">{{ $user->reg_no ?? 'N/A' }}</p>
                    <svg class="edit-icon" onclick="toggleEdit('reg_no')" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                    </svg>
                    <form class="edit-form" id="edit-reg_no-form" onsubmit="updateProfile(event, 'reg_no')">
                        @csrf
                        @method('PUT')
                        <input type="text" name="reg_no" class="edit-input" value="{{ $user->reg_no }}">
                        <button type="submit" class="edit-submit">Update</button>
                    </form>
                </div>
                <div class="info-group">
                    <label>Role</label>
                    <p class="info-text">
                        @if($user->is_super_admin)
                            <span class="role-badge role-super-admin">Super Admin</span>
                        @elseif($user->is_management)
                            <span class="role-badge role-management">Management</span>
                        @elseif($user->is_student)
                            <span class="role-badge role-student">Student</span>
                        @else
                            <span class="role-badge role-user">User</span>
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="notification" class="notification" style="display: none;"></div>

<script>
function toggleEdit(field) {
    var form = document.getElementById('edit-' + field + '-form');
    if (form.style.display === 'none' || form.style.display === '') {
        form.style.display = 'block';
    } else {
        form.style.display = 'none';
    }
}

function showNotification(message) {
    var notification = document.getElementById('notification');
    notification.textContent = message;
    notification.style.display = 'block';
    notification.classList.add('show');
    setTimeout(function() {
        notification.classList.remove('show');
        setTimeout(function() {
            notification.style.display = 'none';
        }, 600);
    }, 3000);
}

function updateProfile(event, field) {
    event.preventDefault();
    var form = event.target;
    var formData = new FormData(form);
    
    // Set the dynamic URL in a JavaScript variable using Blade
    const url = "{{ route('user.update', $user->id) }}"; // Blade outputs a URL-safe string


    // Make the fetch request
    fetch(url, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
            // 'Content-Type': 'application/x-www-form-urlencoded' // Uncomment if needed for form data
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            showNotification(data.success);
            // Use backticks for template literals and ensure proper query selector syntax
            document.querySelector(`#edit-${field}-form`).style.display = 'none';
            document.querySelector(`#edit-${field}-form`).previousElementSibling.previousElementSibling.textContent = formData.get(field);
        }
    })
    .catch(error => {
        console.error('Error:', error);
    });
}

function confirmLogout() {
    if (confirm('Are you sure you want to logout?')) {
        document.getElementById('logout-form').submit();
    }
}

// Check for success message in session and show notification

then(data => {
    if (data.success) {
        showNotification(data.success);
        // Correct use of template literals and query selectors
        const formElement = document.querySelector(`#edit-${field}-form`);
        formElement.style.display = 'none';
        formElement.previousElementSibling.previousElementSibling.textContent = formData.get(field);
    }
})
</script>
@endsection