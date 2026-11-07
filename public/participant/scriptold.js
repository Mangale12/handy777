/**
 * Prize data will space out evenly on the deal wheel based on the amount of items available.
 * @param text [string] name of the prize
 * @param color [string] background color of the prize
 * @param reaction ['resting' | 'dancing' | 'laughing' | 'shocked'] Sets the reaper's animated reaction
 */
        // const prizes = participants.map(participant => ({
        //     text: participant.name,
        //     color: "hsl(197 30% 43%)",
        //     reaction: "dancing"
        // }));// Function to generate random colors
    // const getRandomColor = () => {
    //     return `hsl(${Math.floor(Math.random() * 360)} ${Math.floor(Math.random() * 60) + 40}% ${Math.floor(Math.random() * 50) + 30}%)`;
    // };

    // // Map participants to prize data
    // const prizes = participants.map(participant => ({
    //     text: participant.name,
    //     color: getRandomColor(),  // Assign a unique random color
    //     reaction: "dancing"
    // }));

    const getRandomColor = () => {
        return `hsl(${Math.floor(Math.random() * 360)} ${Math.floor(Math.random() * 60) + 40}% ${Math.floor(Math.random() * 50) + 30}%)`;
    };
    
    // Function for generating gaming colors
    const getRandomGamingColor = () => {
        const colors = [
            "hsl(120, 100%, 50%)", // Neon Green
            "hsl(330, 100%, 50%)", // Neon Pink
            "hsl(210, 100%, 50%)", // Neon Blue
            "hsl(0, 100%, 50%)",   // Bright Red
            "hsl(60, 100%, 50%)",  // Bright Yellow
            "hsl(270, 100%, 40%)", // Purple
            "hsl(180, 100%, 50%)", // Electric Cyan
            "hsl(30, 100%, 50%)"   // Bright Orange
        ];
        return colors[Math.floor(Math.random() * colors.length)];
    };
    
    // Map participants to prize data, using the getRandomGamingColor function for color assignment
    const prizes = participants.map(participant => ({
        text: participant.name,
        color: getRandomGamingColor(),  // Assign a unique random gaming color
        reaction: "dancing" // You can modify this if you want different reactions
    }));
    
  
  const wheel = document.querySelector(".deal-wheel");
  const spinner = wheel.querySelector(".spinner");
  const trigger = wheel.querySelector(".btn-spin");
  const ticker = wheel.querySelector(".ticker");
  const reaper = wheel.querySelector(".grim-reaper");
  const prizeSlice = 360 / prizes.length;
  const prizeOffset = Math.floor(180 / prizes.length);
  const spinClass = "is-spinning";
  const selectedClass = "selected";
  const spinnerStyles = window.getComputedStyle(spinner);
  let tickerAnim;
  let rotation = 0;
  let currentSlice = 0;
  let prizeNodes;
  
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
  
  const spinertia = (min, max) => {
    min = Math.ceil(min);
    max = Math.floor(max);
    return Math.floor(Math.random() * (max - min + 1)) + min;
  };
  
  const runTickerAnimation = () => {
    // https://css-tricks.com/get-value-of-css-rotation-through-javascript/
    const values = spinnerStyles.transform.split("(")[1].split(")")[0].split(",");
    const a = values[0];
    const b = values[1];  
    let rad = Math.atan2(b, a);
    
    if (rad < 0) rad += (2 * Math.PI);
    
    const angle = Math.round(rad * (180 / Math.PI));
    const slice = Math.floor(angle / prizeSlice);
  
    if (currentSlice !== slice) {
      ticker.style.animation = "none";
      setTimeout(() => ticker.style.animation = null, 10);
      currentSlice = slice;
    }
  
    tickerAnim = requestAnimationFrame(runTickerAnimation);
  };
  
//   const selectPrize = () => {
//     const selected = Math.floor(rotation / prizeSlice);
//     prizeNodes[selected].classList.add(selectedClass);
//     reaper.dataset.reaction = prizeNodes[selected].dataset.reaction;
//   };

const selectPrize = () => {
    const selected = Math.floor(rotation / prizeSlice);
    const winnerName = prizeNodes[selected].querySelector('.text').textContent;
    // ... rest of the code ...
    showWinnerPopup(winnerName); // Pass name to popup
  };
  trigger.addEventListener("click", () => {
    if (reaper.dataset.reaction !== "resting") {
      reaper.dataset.reaction = "resting";
    }
  
    trigger.disabled = true;
    rotation = Math.floor(Math.random() * 360 + spinertia(2000, 5000));
    prizeNodes.forEach((prize) => prize.classList.remove(selectedClass));
    wheel.classList.add(spinClass);
    spinner.style.setProperty("--rotate", rotation);
    ticker.style.animation = "none";
    runTickerAnimation();
  });
  
  spinner.addEventListener("transitionend", () => {
    cancelAnimationFrame(tickerAnim);
    trigger.disabled = false;
    trigger.focus();
    rotation %= 360;
    selectPrize();
    wheel.classList.remove(spinClass);
    spinner.style.setProperty("--rotate", rotation);
  });
  
  setupWheel();

//   function showWinnerPopup(winnerName) {
//     const popup = document.querySelector('.winner-popup');
//     const winnerDisplay = document.querySelector('.winner-name');
    
//     winnerDisplay.textContent = `${winnerName} wins!`;
//     popup.style.display = 'block';
    
//     // Add sparkle effect
//     const sparks = document.createElement('div');
//     sparks.className = 'sparks';
//     popup.appendChild(sparks);
//   }
function showWinnerPopup(winnerName) {
    const popup = document.querySelector('.winner-popup');
    const winnerDisplay = document.querySelector('.winner-name');
    
    winnerDisplay.textContent = `${winnerName} wins!`; // Name inserted here
    popup.style.display = 'block';
    
    // Add sparkle effect
    const sparks = document.createElement('div');
    sparks.className = 'sparks';
    popup.appendChild(sparks);
  }
  
  document.querySelector('.close-popup').addEventListener('click', () => {
    document.querySelector('.winner-popup').style.display = 'none';
  });
  
  // Modify the selectPrize function to show popup
  