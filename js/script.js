const cardSlider = document.getElementById("cardSlider");
const cards = cardSlider.querySelectorAll(".card");
const cardWidth = cards[0].offsetWidth;
const interval = 3000;
let currentIndex = 1;

function slideCards() {
  currentIndex++;
  if (currentIndex === cards.length) {
    currentIndex = 1;
  }
  const translateX = -currentIndex * cardWidth;
  cardSlider.style.transform = `translateX(${translateX}px)`;
}

setInterval(slideCards, interval);

// Dapatkan elemen-elemen yang diperlukan
const pilihan = document.getElementById("pilihan");
const deskripsi = document.getElementById("deskripsi");

// Fungsi untuk menampilkan deskripsi saat opsi dipilih
pilihan.addEventListener("change", function () {
  const selectedOption = pilihan.options[pilihan.selectedIndex];
  deskripsi.textContent = `Deskripsi untuk ${selectedOption.text}`;
});

// Ambil elemen-elemen yang diperlukan
const editableText = document.getElementById("editableText");
const editButton = document.getElementById("editButton");
const editPopup = document.getElementById("editPopup");

// Ketika tombol "Edit" diklik, tampilkan pop-up
editButton.addEventListener("click", () => {
  editPopup.style.display = "block";
});

// Ketika teks yang dapat diedit diklik, tampilkan input untuk mengedit teks
editableText.addEventListener("click", () => {
  const currentText = editableText.innerText;
  const editTextarea = document.createElement("textarea");
  editTextarea.value = currentText;
  editableText.replaceWith(editTextarea);

  const saveButton = document.createElement("button");
  saveButton.innerText = "Simpan";
  saveButton.addEventListener("click", () => {
    const newText = editTextarea.value;
    const newH6 = document.createElement("h6");
    newH6.innerText = newText;
    editTextarea.replaceWith(newH6);
    editPopup.style.display = "none";
  });

  editPopup.innerHTML = "";
  editPopup.appendChild(editTextarea);
  editPopup.appendChild(saveButton);
});

// Ketika pop-up di luar diklik, sembunyikan pop-up
window.addEventListener("click", (event) => {
  if (event.target === editPopup) {
    editPopup.style.display = "none";
  }
});

