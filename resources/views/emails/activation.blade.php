<html>

<style>
    .login-button {
        display: inline-block;
        padding: 10px 20px;
        background-color: #3498db; /* A nice blue color */
        color: white;
        text-decoration: none;
        font-weight: bold;
        border-radius: 5px;
        transition: background-color 0.3s ease;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
    }

    .login-button:hover {
        background-color: #2980b9; /* Darker blue on hover */
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
</style>
    <p>Dear Student,</p>

    <p>You have been successfully registered to the clearance system. Please login using the credentials below via the provided link:</p>

    <p>Username: {{ $user->email }}</p>
    <p>Password: {{ $password }}</p>

    
    <a href="{{ url('/login') }}" class="login-button">
        Visit CMS
    </a>


   

    <p>Best regards,<br>General Sir John Kotelawala Defence University</p>
</html>