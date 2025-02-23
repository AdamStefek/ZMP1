const hamburger = document.querySelector(".hamburger");
const ul = document.querySelector("#navbarul");

hamburger.addEventListener("click", () => {
    hamburger.classList.toggle("active");
    ul.classList.toggle("active");
})