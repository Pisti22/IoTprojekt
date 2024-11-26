const modal = document.querySelector("#modal");
const openModal = document.querySelector(".open-button");
const closeModal = document.querySelector(".close-button");

const modal2 = document.querySelector("#modal2");
const openModal2 = document.querySelector(".open-button2");
const closeModal2 = document.querySelector(".close-button2");
const closeModal3 = document.querySelector(".close-button3");

const openModal4 = document.querySelector(".minden-button");
const closeModal4 = document.querySelector(".close-button4");

openModal.addEventListener("click", () => {
        modal.showModal();
    });

closeModal.addEventListener("click", () => {
        modal.close();
    });

openModal2.addEventListener("click", () => {
        modal.close();    
        modal2.showModal();
    });

closeModal2.addEventListener("click", () => {
        modal2.close();
        modal.showModal();
    });

closeModal3.addEventListener("click", () => {
        modal2.close();
    });

openModal4.addEventListener("click", () => {
        modal4.showModal();
    });

closeModal4.addEventListener("click", () => {
        modal4.close();
    });