const bar = document.getElementById('bar');
const close = document.getElementById('close');
const nav = document.getElementById('navbar');

if (bar) {
    bar.addEventListener('click', () => {
        nav.classList.add('active'); // active class

    })
}

if (close) {
    close.addEventListener('click', () => {
        nav.classList.remove('active'); // active class

    })
}

function handleDropdownChange() {
    var dropdown = document.getElementById('userDropdown');
    var selectedValue = dropdown.value;

    if (selectedValue === 'login') {
        window.location.href = 'register.php'; // Redirect to login page
    } else if (selectedValue === 'logout') {
        window.location.href = 'logout.php'; // Redirect to logout page
    }
}


// function handleDropdownChange() {
//     var dropdown = document.getElementById('userDropdown');
//     var selectedValue = dropdown.value;

//     if (selectedValue === 'login') {
//         window.location.href = 'login.php'; // Redirect to login page
//     } else if (selectedValue === 'logout') {
//         window.location.href = 'logout.php'; // Redirect to logout page
//     }
// }
// back here



// console.log('Script loaded and running');

// Rest of your JavaScript code


// function toggleActive(element) {
//     var navbarItems = document.querySelectorAll('#navbar li');
//     navbarItems.forEach(function (item) {
//         item.classList.remove('active');
//     });

//     element.classList.add('active');
// }

// function handleDropdownChange() {
//     // Implement your logic for dropdown change here
//     console.log('Dropdown changed');
// }

console.log(' running');


