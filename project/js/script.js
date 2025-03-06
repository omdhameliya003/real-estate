// ==============================navbar-toggle========================
let menu_left = document.querySelector(".menu-left");
let toggle = document.querySelector(".toggle");
let toggle_crose = document.querySelector(".toggle-crose");
let menu_hide = document.querySelector(".menu-hide");
let closebtn = document.querySelector(".close");

if (toggle) {
  toggle.addEventListener("click", () => {
    menu_hide.classList.toggle("show-menu-hide");
  });
}

if (toggle_crose) {
  toggle_crose.addEventListener("click", () => {
    menu_hide.classList.remove("show-menu-hide");
  });
}

if (closebtn) {
  closebtn.addEventListener("click", () => {
    menu_hide.classList.remove("show-menu-hide");
  });
}

// ===============================navbar-toggle-end=========================

// ===================================show-password============================
let eye_icon = document.querySelector("#eye");
let password = document.querySelector("input[type=password]");

if (eye_icon) {
  eye_icon.addEventListener("click", () => {
    if (password.type == "text") {
      password.type = "password";
    } else {
      password.type = "text";
    }
  });
}

// =======================================some-property-hide-show==============================
function togglePropertyFields() {
  var propertyType = document.getElementById("property-type").value;
  var bedroomBathroomFields = document.querySelectorAll(
    ".not-included-office-shop"
  );
  var no_required = document.querySelectorAll(".no-required");

  if (propertyType === "shop" || propertyType === "office") {
    for (let fields of bedroomBathroomFields) {
      fields.style.display = "none";
    }
    no_required.forEach(function (field) {
      field.removeAttribute("required");
    });
  } else {
    for (let fields of bedroomBathroomFields) {
      fields.style.display = "block";
    }
    no_required.forEach(function (field) {
      field.setAttribute("required", true); // Make fields required
    });
  }
}
// togglePropertyFields();
// ======================================filter-form=============================================
// let filterform = document.querySelector(".filter-form");
// let btnfilter = document.querySelector(".btnfilter");
// let filtercrose = document.querySelector(".filter-toggle-crose");

// function handleFormVisibility() {
//   if (window.innerWidth > 768) {
//     filterform.style.display = "block";
//   } else {
//     filterform.style.display = "none";
//   }
// window.addEventListener("resize", handleFormVisibility);

// if (btnfilter) {
//   btnfilter.addEventListener("click", function (e) {
//     e.preventDefault();
//     filterform.style.display = "block";
//   });
// }
// if (filtercrose) {
//   filtercrose.addEventListener("click", function () {
//     filterform.style.display = "none";
//   });
// }
// =================================================validation=================================
function funcvalidation() {
  const fname = document.getElementById("fname").value;
  const lname = document.getElementById("lname").value;
  const age = document.getElementById("age").value;
  const email = document.getElementById("email").value;
  const mobile = document.getElementById("mobile").value;
  const password = document.getElementById("password").value;
  const conpass = document.getElementById("conpass").value;
  //  -----------------for-error-messge------------
  const errfname = document.getElementById("errfname");
  const errlname = document.getElementById("errlname");
  const errage = document.getElementById("errage");
  const erremail = document.getElementById("erremail");
  const errmobile = document.getElementById("errmobile");
  const errpassword = document.getElementById("errpassword");
  const errconpass = document.getElementById("errconpass");
  var nameRegex = /^[A-Za-z]+$/;
  let isValid = true;

  //validation  for first name

  if (fname === "" || fname.length < 2) {
    errfname.innerHTML = "*first name must contain minimam 2 character.";
    return (isValid = false);
  } else if (!nameRegex.test(fname)) {
    errfname.innerHTML = "*please enter a valid first name.";
    return (isValid = false);
  } else {
    errfname.innerHTML = "";
  }
  //  validation for last name
  if (lname === "" || lname.length < 3) {
    errlname.innerHTML = "*last name must contain minimam 3 character.";
    return (isValid = false);
  } else if (!nameRegex.test(lname)) {
    errlname.innerHTML = "*please enter a valid last name.";
    return (isValid = false);
  } else {
    errlname.innerHTML = "";
  }
  //  validation for age
  if (age === "" || isNaN(age) || age <= 0) {
    errage.innerHTML = "*Please enter a valid age.";
    return (isValid = false);
  } else if (age < 18) {
    errage.innerHTML = "*age is not valid under 18 years.";
    return (isValid = false);
  } else {
    errage.innerHTML = "";
  }
  //  validation for email
  if (email === "") {
    erremail.innerHTML = "*email is not valid to empty.";
    return (isValid = false);
  } else if (email.indexOf("@") <= 0) {
    erremail.innerHTML = "*invalid position of '@'";
    return (isValid = false);
  } else if (
    email.charAt(email.length - 4) != "." &&
    email.charAt(email.length - 3) != "."
  ) {
    erremail.innerHTML = "*invalid position of '.";
    return (isValid = false);
  } else {
    erremail.innerHTML = "";
  }
  //  validation for mobile
  if (mobile === "" || isNaN(mobile) || mobile.length !== 10) {
    errmobile.innerHTML = "*Please enter a valid  10 digit mobile number.";
    return (isValid = false);
  } else {
    errmobile.innerHTML = "";
  }

  //  validation for password
  if (password === "") {
    errpassword.innerHTML = "*password is not valid to empty.";
    return (isValid = false);
  } else if (password.length < 8) {
    errpassword.innerHTML =
      "*password must contain more then 8 character or digit.";
    return (isValid = false);
  } else {
    errpassword.innerHTML = "";
  }
  //  validation for confirm password
  if (conpass === "" || conpass !== password) {
    errconpass.innerHTML = "*password or confirm password not match.";
    return (isValid = false);
  }
  return (isValid = true);
}

// =======================================slider==========================================
// --------------------------------new code for auto slider-------------------------------

let flag = 0;

setInterval(function () {
  flag++;
  slideshow(flag);
}, 2000);

function slideshow(num) {
  let slides = document.querySelectorAll(".slide");

  if (num == slides.length) {
    flag = 0;
    num = 0;
  }
  if (num < 0) {
    flag = slides.length - 1;
    num = slides.length - 1;
  }
  for (let y of slides) {
    y.style.display = "none";
  }
  slides[num].style.display = "block";
}
slideshow(flag);

// -------------------------------old code clickeble slider------------------------
// let flag = 0;

// function controller(x) {
//   flag = flag + x;
//   slideshow(flag);
// }

// slideshow(flag);
// function slideshow(num) {
//   let slides = document.querySelectorAll(".slide");

//   if (num == slides.length) {
//     flag = 0;
//     num = 0;
//   }
//   if (num < 0) {
//     flag = slides.length - 1;
//     num = slides.length - 1;
//   }
//   for (let y of slides) {
//     y.style.display = "none";
//   }
//   slides[num].style.display = "block";
// }
// =============================================slider-end=====================================
