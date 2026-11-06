const getRandomGamingColor = (previousColor = null) => {
    const colors = [
        "hsl(120, 100%, 50%)", // Neon Green
        "hsl(330, 100%, 50%)", // Neon Pink
        "hsl(210, 100%, 50%)", // Neon Blue
        "hsl(0, 100%, 50%)",   // Bright Red
        "hsl(60, 100%, 50%)",  // Bright Yellow
        "hsl(270, 100%, 40%)", // Purple
        "hsl(180, 100%, 50%)", // Electric Cyan
        "hsl(30, 100%, 50%)"    // Bright Orange
    ];
    let randomColor = colors[Math.floor(Math.random() * colors.length)];
    while (randomColor === previousColor) {
        randomColor = colors[Math.floor(Math.random() * colors.length)];
    }
    return randomColor;
};

// Create prize slices based on participants
let lastColor = null;
const prizes = participants.map(participant => {
    const color = getRandomGamingColor(lastColor);
    lastColor = color;
    return {
        text: participant.name,
        color: color,
        reaction: "dancing"
    };
});

const wheel = document.querySelector(".deal-wheel");
const spinner = wheel.querySelector(".spinner");
const trigger = wheel.querySelector(".btn-spiner");
const ticker = wheel.querySelector(".ticker");
const prizeSlice = 360 / prizes.length;
const prizeOffset = Math.floor(180 / prizes.length);
let rotation = 0;
let prizeNodes;

// Function to find the fixed winner's index
const getWinnerIndex = () => {
    return participants.findIndex(participant => participant.name === fixedWinnerName);
};

// Function to determine the correct angle for the pointer
const getWinnerRotation = () => {
    const winnerIndex = getWinnerIndex();
    return (winnerIndex * prizeSlice) + prizeOffset;
};

const createPrizeNodes = () => {
    prizes.forEach(({ text, color, reaction }, i) => {
        const rotation = ((prizeSlice * i) * -1) - prizeOffset;

        spinner.insertAdjacentHTML(
            "beforeend",
            `<li class="prize" data-reaction=${reaction} style="--rotate: ${rotation}deg">
              <span class="text">${text}</span>
            </li>`
        );
    });
};

const createConicGradient = () => {
    spinner.setAttribute(
        "style",
        `background: conic-gradient(
            from -90deg,
            ${prizes
                .map(({ color }, i) => `${color} 0 ${(100 / prizes.length) * (prizes.length - i)}%`)
                .reverse()
            }
        );`
    );
};

const setupWheel = () => {
    createConicGradient();
    createPrizeNodes();
    prizeNodes = wheel.querySelectorAll(".prize");
};

// Show winner popup
function createFlowers() {
    const numberOfFlowers = 40;
    const flowerEmojis = ["🌸", "🌼", "🌷", "🌺", "🌻"]; // Realistic flower emojis
    const flowerColors = ["#ff69b4", "#ffdab9", "#f0e68c", "#98fb98", "#dda0dd"]; // Pink, Peach, Khaki, PaleGreen, Plum

    for (let i = 0; i < numberOfFlowers; i++) {
        let flower = document.createElement("div");
        flower.classList.add("flower");
        flower.style.left = Math.random() * 100 + "vw";
        flower.style.animationDuration = (Math.random() * 3 + 2) + "s";
        flower.style.fontSize = (Math.random() * 2 + 2) + "rem"; // Randomize size a bit
        flower.textContent = flowerEmojis[Math.floor(Math.random() * flowerEmojis.length)];
        flower.style.color = flowerColors[Math.floor(Math.random() * flowerColors.length)]; // Random color
        document.body.appendChild(flower);
        setTimeout(() => {
            flower.remove();
        }, 5000);
    }
}

// Show winner popup
const showWinnerPopup = (winnerName) => {
    const popup = document.querySelector('.winner-popup');
    const winnerDisplay = document.querySelector('.winner-name');
    winnerDisplay.textContent = `${winnerName} wins!`;
    popup.style.display = 'block';

    createFlowers(); // Initial burst of flowers
    if (!flowerInterval) { // Only set the interval if it's not already running
        flowerInterval = setInterval(createFlowers, 500);
    }

    // Stop flowers when closed
    const claimButton = popup.querySelector('.claim-button');
    if (claimButton) {
        claimButton.addEventListener('click', () => {
            popup.style.display = 'none';
            clearInterval(flowerInterval);
            flowerInterval = null; // Reset the interval variable
            document.querySelector('.flower-container').innerHTML = '';
        });
    }
};
// Spin Button Click Event
trigger.addEventListener("click", () => {
    trigger.disabled = true;
    const winnerRotation = getWinnerRotation();
    rotation = (360 * 5) + winnerRotation;  // 5 full spins + exact winner position
    spinner.style.setProperty("--rotate", rotation);
    wheel.classList.add("is-spinning");
});

// Stop the wheel after animation
spinner.addEventListener("transitionend", () => {
    trigger.disabled = false;
    wheel.classList.remove("is-spinning");
    showWinnerPopup(fixedWinnerName);
});

// Close popup
const closeButton = document.querySelector('.close-popup');
if (closeButton) {
    closeButton.addEventListener('click', () => {
        document.querySelector('.winner-popup').style.display = 'none';
    });
}

setupWheel();