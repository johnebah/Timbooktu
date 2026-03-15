const carousel = document.getElementById("carousel");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");

let scrollAmount = 0;

const getScrollStep = (element) => {
    if (!element || !element.children.length) return 300;
    const item = element.children[0];
    const style = window.getComputedStyle(element);
    let gap = parseInt(style.gap);
    if (isNaN(gap)) gap = 0;
    return (item.offsetWidth || 300) + gap;
};

if (carousel && prevBtn && nextBtn) {
    prevBtn.addEventListener("click", () => {
        const step = getScrollStep(carousel);
        carousel.scrollBy({
            left: -step,
            behavior: "smooth",
        });
    });

    nextBtn.addEventListener("click", () => {
        const step = getScrollStep(carousel);
        carousel.scrollBy({
            left: step,
            behavior: "smooth",
        });
    });

    let thoughtLinkPointerStartX = 0;
    let thoughtLinkPointerStartY = 0;
    let thoughtLinkPointerTarget = null;
    let thoughtLinkDidDrag = false;

    carousel.addEventListener("pointerdown", (e) => {
        const link = e.target.closest("a.carousel-item[href]");
        if (!link) return;
        thoughtLinkPointerStartX = e.clientX;
        thoughtLinkPointerStartY = e.clientY;
        thoughtLinkPointerTarget = link;
        thoughtLinkDidDrag = false;
    });

    carousel.addEventListener("pointermove", (e) => {
        if (!thoughtLinkPointerTarget) return;
        const dx = Math.abs(e.clientX - thoughtLinkPointerStartX);
        const dy = Math.abs(e.clientY - thoughtLinkPointerStartY);
        if (dx > 10 || dy > 10) {
            thoughtLinkDidDrag = true;
        }
    });

    carousel.addEventListener("pointercancel", () => {
        thoughtLinkPointerTarget = null;
        thoughtLinkDidDrag = false;
    });

    carousel.addEventListener("click", (e) => {
        const link = e.target.closest("a.carousel-item[href]");
        if (!link) return;
        if (thoughtLinkDidDrag) {
            e.preventDefault();
            thoughtLinkDidDrag = false;
        }
    });

    carousel.addEventListener("scroll", () => {
        const maxScroll = carousel.scrollWidth - carousel.clientWidth;

        if (carousel.scrollLeft <= 0) {
            prevBtn.style.opacity = "0.3";
            prevBtn.style.cursor = "default";
        } else {
            prevBtn.style.opacity = "1";
            prevBtn.style.cursor = "pointer";
        }

        if (carousel.scrollLeft >= maxScroll - 1) {
            nextBtn.style.opacity = "0.3";
            nextBtn.style.cursor = "default";
        } else {
            nextBtn.style.opacity = "1";
            nextBtn.style.cursor = "pointer";
        }
    });
}

const photoCarousel = document.getElementById("photoCarousel");
const photoPrevBtn = document.getElementById("photoPrevBtn");
const photoNextBtn = document.getElementById("photoNextBtn");

if (photoCarousel && photoPrevBtn && photoNextBtn) {
    // Ensure buttons are visible/enabled initially
    photoPrevBtn.style.pointerEvents = "auto";
    photoNextBtn.style.pointerEvents = "auto";

    photoPrevBtn.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
        const itemWidth = photoCarousel.clientWidth; // Scroll by container width
        photoCarousel.scrollBy({
            left: -itemWidth,
            behavior: "smooth",
        });
    });

    photoNextBtn.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
        const itemWidth = photoCarousel.clientWidth; // Scroll by container width
        photoCarousel.scrollBy({
            left: itemWidth,
            behavior: "smooth",
        });
    });

    // Add scroll event listener to update arrow opacity for photo carousel
    photoCarousel.addEventListener("scroll", () => {
        const maxScroll = photoCarousel.scrollWidth - photoCarousel.clientWidth;

        if (photoCarousel.scrollLeft <= 0) {
            photoPrevBtn.style.opacity = "0.3";
            photoPrevBtn.style.cursor = "default";
        } else {
            photoPrevBtn.style.opacity = "1";
            photoPrevBtn.style.cursor = "pointer";
        }

        if (photoCarousel.scrollLeft >= maxScroll - 5) {
            // -5 buffer for rounding errors
            photoNextBtn.style.opacity = "0.3";
            photoNextBtn.style.cursor = "default";
        } else {
            photoNextBtn.style.opacity = "1";
            photoNextBtn.style.cursor = "pointer";
        }
    });

    // Initial check
    const maxScroll = photoCarousel.scrollWidth - photoCarousel.clientWidth;
    if (photoCarousel.scrollLeft <= 0) photoPrevBtn.style.opacity = "0.3";
    if (photoCarousel.scrollLeft >= maxScroll - 5)
        photoNextBtn.style.opacity = "0.3";
}

const ourThingCarousel = document.getElementById("ourThingCarousel");
const ourThingPrevBtn = document.getElementById("ourThingPrevBtn");
const ourThingNextBtn = document.getElementById("ourThingNextBtn");

if (ourThingCarousel && ourThingPrevBtn && ourThingNextBtn) {
    // Ensure buttons are visible/enabled initially
    ourThingPrevBtn.style.pointerEvents = "auto";
    ourThingNextBtn.style.pointerEvents = "auto";

    ourThingPrevBtn.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
        const itemWidth = ourThingCarousel.clientWidth; // Scroll by container width
        ourThingCarousel.scrollBy({
            left: -itemWidth,
            behavior: "smooth",
        });
    });

    ourThingNextBtn.addEventListener("click", (e) => {
        e.preventDefault();
        e.stopPropagation();
        const itemWidth = ourThingCarousel.clientWidth; // Scroll by container width
        ourThingCarousel.scrollBy({
            left: itemWidth,
            behavior: "smooth",
        });
    });

    // Add scroll event listener to update arrow opacity
    ourThingCarousel.addEventListener("scroll", () => {
        const maxScroll =
            ourThingCarousel.scrollWidth - ourThingCarousel.clientWidth;

        if (ourThingCarousel.scrollLeft <= 0) {
            ourThingPrevBtn.style.opacity = "0.3";
            ourThingPrevBtn.style.cursor = "default";
        } else {
            ourThingPrevBtn.style.opacity = "1";
            ourThingPrevBtn.style.cursor = "pointer";
        }

        if (ourThingCarousel.scrollLeft >= maxScroll - 5) {
            ourThingNextBtn.style.opacity = "0.3";
            ourThingNextBtn.style.cursor = "default";
        } else {
            ourThingNextBtn.style.opacity = "1";
            ourThingNextBtn.style.cursor = "pointer";
        }
    });

    // Initial check
    const maxScroll =
        ourThingCarousel.scrollWidth - ourThingCarousel.clientWidth;
    if (ourThingCarousel.scrollLeft <= 0) ourThingPrevBtn.style.opacity = "0.3";
    if (ourThingCarousel.scrollLeft >= maxScroll - 5)
        ourThingNextBtn.style.opacity = "0.3";
}

const subscribeForm = document.querySelector(".subscribe-form");
if (subscribeForm) {
    subscribeForm.addEventListener("submit", (e) => {
        e.preventDefault();
        const email = subscribeForm.querySelector("input").value;
        alert(`Thank you for subscribing with ${email}!`);
        subscribeForm.reset();
    });
}

document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
    anchor.addEventListener("click", function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute("href"));
        if (target) {
            target.scrollIntoView({
                behavior: "smooth",
                block: "start",
            });
        }
    });
});

const searchInput = document.querySelector(".search-bar input");
if (searchInput) {
    searchInput.addEventListener("keypress", (e) => {
        if (e.key === "Enter") {
            const searchQuery = searchInput.value;
            if (searchQuery.trim()) {
                alert(`Searching for: ${searchQuery}`);
                searchInput.value = "";
            }
        }
    });
}
