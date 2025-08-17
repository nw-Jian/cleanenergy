const revealSections = () => {
    const sections = document.querySelectorAll("section");
    const triggerBottom = window.innerHeight * 0.8;
  
    sections.forEach((section) => {
      const sectionTop = section.getBoundingClientRect().top;
      if (sectionTop < triggerBottom) {
        section.classList.add("visible");
      }
    });
  };
  
  window.addEventListener("scroll", revealSections);
  window.addEventListener("load", revealSections);
  
  document.getElementById("feedbackForm").addEventListener("submit", (e) => {
    e.preventDefault();
    const name = document.getElementById("name").value;
    const feedback = document.getElementById("feedback").value;
    alert(`Thank you, ${name}, for your feedback: "${feedback}"`);
  });