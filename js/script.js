const cardSlider = document.getElementById("cardSlider");
const cards = cardSlider.querySelectorAll(".card");
const cardWidth = cards[0].offsetWidth;
const interval = 3000;
let currentIndex = 1;

function slideCards() {
  currentIndex++;
  if (currentIndex === cards.length) {
    currentIndex = 2;
  }
  const translateX = -currentIndex * cardWidth;
  cardSlider.style.transform = `translateX(${translateX}px)`;
}

setInterval(slideCards, interval);




