let currentImageIndex = 0;
const images = [
    "/Images/studentsInClass.png",
    "/Images/studentsBreak.png",
    "/Images/studentsStudying.png"
];

function changeImage() {
    const imageElement = document.getElementById("studentImages");
    imageElement.src = images[currentImageIndex];

    if (currentImageIndex < images.length - 1) {
        currentImageIndex++;
    }
    else {
        currentImageIndex = 0;
    }
}

setInterval(changeImage, 3000);