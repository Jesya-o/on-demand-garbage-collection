// Initialize the slideIndex variable to 1 and call the showSlides function to display the first slide.
let slideIndex = 1;
showSlides(slideIndex);

// This function takes an integer parameter n and adds it to the slideIndex variable, then calls the showSlides function.
function plusSlides(n) {
  showSlides(slideIndex += n);
}

// This function takes an integer parameter n and sets the slideIndex variable to that value, then calls the showSlides function.
function currentSlide(n) {
  showSlides(slideIndex = n);
}

// This function takes an integer parameter n and displays the slide corresponding to that index.
function showSlides(n) {
  // Initialize variables and get elements.
  let i;
  let slides = document.getElementsByClassName("slider");
  let dots = document.getElementsByClassName("dot");
  
  // If n is greater than the number of slides, set slideIndex to 1.
  if (n > slides.length) { slideIndex = 1 }
  // If n is less than 1, set slideIndex to the last slide.
  if (n < 1) { slideIndex = slides.length }
  
  // Hide all the slides.
  for (i = 0; i < slides.length; i++) {
    slides[i].style.display = "none";
  }
  
  // Remove the "active" class from all the dots.
  for (i = 0; i < dots.length; i++) {
    dots[i].className = dots[i].className.replace(" active", "");
  }
  
  // Display the current slide and add the "active" class to the corresponding dot.
  slides[slideIndex - 1].style.display = "block";
  dots[slideIndex - 1].className += " active";
}
