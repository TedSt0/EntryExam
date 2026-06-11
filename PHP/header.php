<header>
    <div id="headerContainer">
        <a href="index.php"><img src="/Images/icon.png" alt="Logo" id="logo"></a> 
        <nav id="navbar">
            <ul>
                <li><a href="apply.php">Apply</a></li>
                <li><a href="examDates.php">Exam Dates</a></li>
                <!--<li><a href="about.php">About</a></li>-->
                <!-- Admin Only Navigation -->
                <?php if (isset($_SESSION["loggedIn"])): ?>
                    <li><a href="applicants.php">Applicants</a></li>
                    <li class="adminDropdown">
                        <a href="#">Reports</a>
                        <ul class="dropdown">
                            <li><a href="examReport.php">Exam Report</a></li>
                            <li><a href="majorReport.php">Major Report</a></li>
                        </ul>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>
        <!-- Login/Logout Button change -->
        <?php if (isset($_SESSION["loggedIn"])): ?>
            <button id="loginButton" onclick="window.location.href='PHP/logout.php'">Logout</button>
        <?php else: ?>
            <button id="loginButton" onclick="openLoginClicked()">Login</button>
        <?php endif; ?>
    </div>
</header>
    <div id="overlay" onclick="closeLoginClicked()"></div>
    <div id="loginWindow">
        <form id="loginForm" action="PHP/login.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>

                <!-- Wrong username/password message -->
            <?php 
            if (isset($_SESSION["login_error"])): ?>
                <div id="loginErrorTextbox" class="login-error-box">
                    <?php 
                        echo $_SESSION["login_error"]; 
                        unset($_SESSION["login_error"]);
                    ?>
                </div>
            <?php endif; ?>

            <div id="formButtons">
                <input type="submit" name="login" value="Login">
                <input type="button" value="Cancel" onclick="closeLoginClicked()">
            </div>
        </form>
    </div>