//those global boolean variables are used tell the other functions if the fields of login and signup are valid or not.
var signup_name = false;
var signup_email = false;
var signup_password = false;
var signup_password_confirmation = false;

var login_name = false;
var login_password = false;

function check_login_OR_signup() {
  //this function checks whether the current screen is Login(FALSE) OR Signup(true).
  if (login_box.style.display == "none") return true;
  else return false;
}

function toggle_between_login_and_signup() {
  //this function toggles between Login and Signup when clicking on 'Login' link or 'Signup' link.
  const login_box = document.getElementById("login_box");
  const signup_box = document.getElementById("signup_box");

  if (check_login_OR_signup()) {
    login_box.style.display = "block";

    signup_box.style.display = "none";
  } else {
    login_box.style.display = "none";

    signup_box.style.display = "block";
  }
}

function validate_Name(name) {
  //this function is for name format validation.
  const regularExprition = /^[a-zA-Z][a-zA-Z0-9]{2,}$/;
  if (regularExprition.test(name.value)) return true;
  else return false;
}

function validate_Password(password) {
  //this function is for password format validation.
  const regularExprition = /^(?=.*[a-zA-Z])(?=.*\d)[a-zA-Z\d]{8,}$/;

  if (regularExprition.test(password.value)) return true;
  else return false;
}

function validate_Email(email) {
  //this function is for email password format validation.
  const regularExprition = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+.[a-zA-Z]{2,}$/;
  if (regularExprition.test(email.value)) return true;
  else return false;
}

function login_name_validation() {
  //this function is validating the login name, if it's not valid.
  const name = document.getElementById("email_login");
  if (!validate_Name(name) && name.value != "") {
    name.style.borderColor = "red";
    login_name = false;
  } else {
    name.style.borderColor = "grey";
    login_name = true;
  }
}

function login_password_validation() {
  //this function is validating the login password, if it's not valid.
  const password = document.getElementById("password_login");

  if (!validate_Password(password) && password.value != "") {
    password.style.borderColor = "red";
    login_password = false;
  } else {
    password.style.borderColor = "grey";
    login_password = true;
  }
}

function login_submit_disability_toggle() {
  //this function disable login submit button if name or password are not valid, and enable it when they are valid.
  const submit_button = document.getElementById("login_submit");

  let login_Success = false;

  if (login_name && login_password) login_Success = true;
  else login_Success = false;

  if (login_Success) {
    submit_button.disabled = false;
    disabled_button_color();
  } else {
    submit_button.disabled = true;
    disabled_button_color();
  }
}
function signup_name_validation() {
  //this function is validating the signup name, if it's not valid.
  const name = document.getElementById("name_signup");

  if (!validate_Name(name) && name.value != "") {
    name.style.borderColor = "red";
    signup_name = false;
  } else {
    name.style.borderColor = "grey";
    signup_name = true;
  }
}

function signup_email_validation() {
  //this function is validating the signup email, if it's not valid.
  const email = document.getElementById("email_signup");

  if (!validate_Email(email) && email.value != "") {
    email.style.borderColor = "red";
    signup_email = false;
  } else {
    email.style.borderColor = "grey";
    signup_email = true;
  }
}

function signup_password_validation() {
  //this function is validating the signup password, if it's not valid.
  const password = document.getElementById("password_signup");

  if (!validate_Password(password) && password.value != "") {
    password.style.borderColor = "red";
    signup_password = false;
  } else {
    password.style.borderColor = "grey";
    signup_password = true;
  }
}

function signup_password_conformation_validation() {
  //this function checks if the password matches the password confirmation text.
  const password = document.getElementById("password_signup");
  const password_conf = document.getElementById("password_conf");

  if (password.value != password_conf.value && password_conf.value != "") {
    password_conf.style.borderColor = "red";

    signup_password_confirmation = false;
  } else {
    password_conf.style.borderColor = "grey";
    signup_password_confirmation = true;
  }
}

function signup_submit_disability_toggle() {
  //this function disable login submit button if name or email or password are not valid and password donsen't match password conformation textbox , and enable it when they are valid.
  const submit_button = document.getElementById("signup_submit");
  let signup_Success = false;

  if (
    signup_name &&
    signup_email &&
    signup_password &&
    signup_password_confirmation
  )
    signup_Success = true;
  else signup_Success = false;

  if (signup_Success) {
    submit_button.disabled = false;
    disabled_button_color();
  } else {
    submit_button.disabled = true;
    disabled_button_color();
  }
}

function disabled_button_color() {
  //this function changes submit button color for both login and signup depending on the state of the button (disabled or not).
  const login_submit_button = document.getElementById("login_submit");
  const signup_submit_button = document.getElementById("signup_submit");
  if (login_submit_button.disabled) {
    login_submit_button.style.backgroundColor = "#2d45438c";
  } else {
    login_submit_button.style.backgroundColor = "#210070";
  }

  if (signup_submit_button.disabled) {
    signup_submit_button.style.backgroundColor = "#2d45438c";
  } else {
    signup_submit_button.style.backgroundColor = "#210070";
  }
}

window.onload = function () {
  //this function is called when page is loaded, it checks the validity of all the fields in login and signup, and called validation functions when any textbox value is changed.
  disabled_button_color();
  const signup_name = document.getElementById("name_signup");
  const signup_email = document.getElementById("email_signup");
  const signup_password = document.getElementById("password_signup");
  const signup_password_conf = document.getElementById("password_conf");

  const login_name = document.getElementById("email_login");
  const login_password = document.getElementById("password_login");

  signup_name.addEventListener("input", function () {
    signup_name_validation();
    signup_submit_disability_toggle();
  });
  signup_email.addEventListener("input", function () {
    signup_email_validation();
    signup_submit_disability_toggle();
  });
  signup_password.addEventListener("input", function () {
    signup_password_validation();
    signup_submit_disability_toggle();
  });
  signup_password_conf.addEventListener("input", function () {
    signup_password_conformation_validation();
    signup_submit_disability_toggle();
  });

  login_name.addEventListener("input", function () {
    login_name_validation();
    login_submit_disability_toggle();
  });
  login_password.addEventListener("input", function () {
    login_password_validation();
    login_submit_disability_toggle();
  });

  signup_submit_disability_toggle();
  login_submit_disability_toggle();
};

// add event to itemDiv
// document.addEventListener("DOMContentLoaded", () => {
//   const divs = document.querySelectorAll(".itemDiv");

//   divs.forEach((div) => {
//     div.addEventListener("click", () => {
//       // Function to execute when a div is clicked
//       // You can redirect to another page using window.location.href or any other desired action.
//       window.location.href = "item_view.html"; // Replace with the desired URL
//     });
//   });
// });

