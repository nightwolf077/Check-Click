window.addEventListener("load", () => {
    const loader = document.querySelector(".loader");

    // Add the hidden class after the page has loaded
    loader.classList.add("loader-hidden");

    // Remove the loader element once the transition has finished
    loader.addEventListener("transitionend", () => {
        loader.remove();
    });
});
