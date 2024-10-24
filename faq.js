// faq.js

document.addEventListener("DOMContentLoaded", function() {
    const faqItems = document.querySelectorAll(".faq-item");

    faqItems.forEach(item => {
        item.querySelector(".faq-question").addEventListener("click", () => {
            const answer = item.querySelector(".faq-answer");
            const toggle = item.querySelector(".faq-toggle");

            if (answer.style.display === "block") {
                answer.style.display = "none";
                toggle.textContent = "+";
            } else {
                answer.style.display = "block";
                toggle.textContent = "-";
            }
        });
    });
});
