<link rel="stylesheet" href="https://www.phptutorial.net/app/css/style.css">
    
<h1>Register</h1>

<form action="index.php?ctrl=security&action=register" method="post">
    <h1>Sign Up</h1>
    <div>
        <label for="userName">Username:</label>
        <input type="text" name="userName" id="userName">
    </div>
    <div>
        <label for="userEmail">Email:</label>
        <input type="email" name="userEmail" id="userEmail">
    </div>
    <div>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password">
    </div>
    <!-- <div>
        <label for="password2">Password Again:</label>
        <input type="password" name="password2" id="password2">
    </div> -->
    <!-- <div>
        <label for="agree">
            <input type="checkbox" name="agree" id="agree" value="yes"/> I agree
            with the
            <a href="#" title="term of services">term of services</a>
        </label>
    </div> -->
    <button type="submit">Register</button>
    <footer>
        <p>Already a member?</p>
        <a href="login.php">Login here</a>
    </footer>
</form>