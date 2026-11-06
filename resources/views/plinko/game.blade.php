<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plinko Game</title>
    <link id="pagestyle" href="{{ asset('public/css/plinko.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css">
    <style>
        .container {
            display: flex;
            height: calc(100vh - 150px);
            /* Adjust based on your header height */
        }

        .left-panel {
            width: 250px;
            height: 100%;
            overflow-y: auto;
        }

        .right-panel {
            flex: 1;
            height: 100%;
            padding: 10px;
        }

        .header-part {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .header-result{
            display:flex;
            align-items:center;
        }
        .history-container {
                background: rgb(255 255 255 / 0%);
            border-radius: 15px;
             padding: 0px; 
            margin-bottom: 0px;
            backdrop-filter: blur(0px);
        }
        .history-title{
            padding-bottom:0px;
            margin-bottom:0px;
            padding-right:15px;
        }
    </style>
</head>

<body>
    <div id="overlay">
        <div id="percentageBarContainer">
            <div id="percentageBar"></div>
        </div>
        <button id="playButton">Play</button>
    </div>
    <!-- Anti-Inspect Overlay -->
    <div class="anti-inspect-overlay" id="antiInspectOverlay">
        <div class="warning-message">
            <h2>⚠️ Game Paused</h2>
            <p>Developer tools detected! Please close the inspector to continue playing.</p>
            <p>For security reasons, the game cannot run while developer tools are open.</p>
        </div>
    </div>

    <!-- Header -->
    <div class="header hidden header-part">
        <div class="game-title">🎯 PLINKO GAME - Welcome {{ ucwords($form->full_name) }}</div>
        <div class="history-container header-result">
            <div class="history-title">Recent Results</div>
            <div class="history-items" id="historyItems">
                <div class="history-item">-</div>
                <div class="history-item">-</div>
                <div class="history-item">-</div>
                <div class="history-item">-</div>
            </div>
        </div>

        <div class="balance-display">Balance: $<span id="balance">{{ $form->plinko_balance }}</span></div>
    </div>

    <!-- Main Container -->
    <div class="container">
        <!-- Left Panel - Controls -->
        <div class="left-panel">
            <!-- Mode Selector -->
            <div class="mode-selector">
                <button class="mode-btn active" id="manualMode">Manual</button>
                <button class="mode-btn" id="autoMode">Auto</button>
            </div>

            <!-- Bet Amount -->
            <div class="control-group">
                <label class="control-label">Bet Amount ($)</label>
                <div class="input-group bet-input-container">
                    <input type="number" class="control-input" id="betAmount" value="10" min="1"
                        max="1000" disabled>
                    <div class="bet-controls input-group-append">
                        <button type="button" class="bet-btn btn btn-secondary" id="halfButton">1/2</button>
                        <button type="button" class="bet-btn btn btn-secondary" id="doubleButton">2X</button>
                    </div>
                </div>
                {{-- <input type="number" class="control-input" id="betAmount" value="10" min="1" max="1000"> --}}
            </div>

            <!-- Risk Level -->
            <div class="control-group">
                <label class="control-label">Risk Level</label>
                <div class="risk-buttons">
                    <button class="risk-btn active" data-risk="low">Low</button>
                    <button class="risk-btn" data-risk="medium">Medium</button>
                    <button class="risk-btn" data-risk="high">High</button>
                </div>
            </div>

            <!-- Number of Rows -->
            <div class="control-group">
                <label class="control-label">Rows</label>
                <select id="rows" class="control-input">
                    <option value="8">8</option>
                    <option value="9">9</option>
                    <option value="10">10</option>
                    <option value="11">11</option>
                    <option selected value="12">12</option>
                </select>
                {{-- <input type="number" class="control-input" id="rows" value="12" min="8" max="16"> --}}
            </div>

            <!-- Auto Mode Controls -->
            <div class="auto-controls" id="autoControls">
                <div class="control-group">
                    <label class="control-label">Number of Bets</label>
                    <input type="number" class="control-input" id="numberOfBets" value="10" min="1"
                        max="100">
                </div>
            </div>

            <!-- Drop Button -->
            <button class="drop-button" id="dropButton">Drop Ball</button>
            <button class="drop-button" id="autoBetButton" style="display: none;">Start Autobet</button>

            <!-- Game Status -->
            <div class="game-status" id="gameStatus">Ready to play!</div>
        </div>

        <!-- Right Panel - Game Area -->
        <div class="right-panel">
            <!-- History Container -->

            <!-- Game Container -->
            <div class="game-container">
                <canvas id="gameCanvas" width="600" height="700"></canvas>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/toastr/build/toastr.min.js"></script>

    <script>
        // ===========================================
        // ANTI-HACKING MECHANISMS
        // ===========================================

        let gameRunning = true;
        let devToolsOpen = false;
        var old_balance = 0;

        // Disable right-click context menu
        // document.addEventListener('contextmenu', function(e) {
        //     e.preventDefault();
        //     return false;
        // });

        // Disable common keyboard shortcuts for developer tools
        document.addEventListener('keydown', function(e) {
            // F12, Ctrl+Shift+I, Ctrl+Shift+J, Ctrl+U, Ctrl+Shift+C
            if (e.keyCode === 123 ||
                (e.ctrlKey && e.shiftKey && (e.keyCode === 73 || e.keyCode === 74 || e.keyCode === 67)) ||
                (e.ctrlKey && e.keyCode === 85)) {
                e.preventDefault();
                showAntiInspectWarning();
                return false;
            }
        });

        // Monitor for developer tools (multiple methods)
        function detectDevTools() {
            // Method 1: Console detection
            let devtools = {
                open: false,
                orientation: null
            };

            const threshold = 160;
            // setInterval(() => {
            //     if (window.outerHeight - window.innerHeight > threshold || 
            //         window.outerWidth - window.innerWidth > threshold) {
            //         if (!devtools.open) {
            //             devtools.open = true;
            //             showAntiInspectWarning();
            //         }
            //     } else {
            //         if (devtools.open) {
            //             devtools.open = false;
            //             hideAntiInspectWarning();
            //         }
            //     }
            // }, 500);

            // Method 2: Debug detection
            let element = document.createElement('div');
            element.__defineGetter__('id', function() {
                showAntiInspectWarning();
            });

            // Method 3: Console.log override
            // let originalLog = console.log;
            console.log = function() {
                showAntiInspectWarning();
                return originalLog.apply(console, arguments);
            };
        }

        function showAntiInspectWarning() {
            if (!devToolsOpen) {
                devToolsOpen = true;
                gameRunning = false;
                $('#antiInspectOverlay').fadeIn();
                // Pause any running animations
                if (window.gameAnimationFrame) {
                    cancelAnimationFrame(window.gameAnimationFrame);
                }
            }
        }

        function hideAntiInspectWarning() {
            if (devToolsOpen) {
                devToolsOpen = false;
                gameRunning = true;
                $('#antiInspectOverlay').fadeOut();
                // Resume game if needed
                if (window.gameInstance) {
                    window.gameInstance.resume();
                }
            }
        }

        // Initialize anti-hacking measures
        // detectDevTools();

        // ===========================================
        // GAME VARIABLES AND CONFIGURATION
        // ===========================================

        let balance = '{{ $form->plinko_balance }}';
        let currentMode = 'manual';
        let currentRisk = 'low';
        let isAutoRunning = false;
        let autoRemainingBets = 0;
        let gameHistory = [];
        let isBallInProgress = false;
        let ballData = {}; // To store the latest ball data

        // Developer-controlled ball speed settings (not visible to user) - Reduced speeds
        const BALL_SPEED_CONFIG = {
            low: {
                baseSpeed: 1.5,
                maxSpeed: 3,
                gravity: 0.2
            },
            medium: {
                baseSpeed: 2,
                maxSpeed: 3.5,
                gravity: 0.25
            },
            high: {
                baseSpeed: 2.5,
                maxSpeed: 4,
                gravity: 0.3
            }
        };

        // Multiplier configurations - Extended to handle all row configurations
        const MULTIPLIER_CONFIG = {
            low: {
                8: [5.6, 2.1, 1.1, 1, 0.5, 1, 1.1, 2.1, 5.6, 2.1, 1.1],
                9: [5.6, 2.1, 1.1, 1, 0.5, 1, 1.1, 2.1, 5.6, 2.1, 1.1, 1],
                10: [5.6, 2.1, 1.1, 1, 0.5, 1, 1.1, 2.1, 5.6, 2.1, 1.1, 1, 0.5],
                11: [5.6, 2.1, 1.1, 1, 0.5, 1, 1.1, 2.1, 5.6, 2.1, 1.1, 1, 0.5, 1],
                12: [10, 3, 1.6, 1.4, 1.1, 1, 0.5, 1, 1.1, 1.4, 1.6, 3, 10, 3, 1.6],
                13: [10, 3, 1.6, 1.4, 1.1, 1, 0.5, 1, 1.1, 1.4, 1.6, 3, 10, 3, 1.6, 1.4],
                14: [10, 3, 1.6, 1.4, 1.1, 1, 0.5, 1, 1.1, 1.4, 1.6, 3, 10, 3, 1.6, 1.4, 1.1],
                15: [10, 3, 1.6, 1.4, 1.1, 1, 0.5, 1, 1.1, 1.4, 1.6, 3, 10, 3, 1.6, 1.4, 1.1, 1],
                16: [16, 9, 2, 1.4, 1.4, 1.2, 1.1, 1, 0.3, 1, 1.1, 1.2, 1.4, 1.4, 2, 9, 16, 2, 1.4]
            },
            medium: {
                8: [13, 3, 1.3, 0.7, 0.4, 0.7, 1.3, 3, 13, 3, 1.3],
                9: [13, 3, 1.3, 0.7, 0.4, 0.7, 1.3, 3, 13, 3, 1.3, 0.7],
                10: [13, 3, 1.3, 0.7, 0.4, 0.7, 1.3, 3, 13, 3, 1.3, 0.7, 0.4],
                11: [13, 3, 1.3, 0.7, 0.4, 0.7, 1.3, 3, 13, 3, 1.3, 0.7, 0.4, 0.7],
                12: [25, 8, 4, 2, 1.4, 1.1, 1, 0.5, 1.1, 1.4, 2, 4, 8, 25, 4],
                13: [25, 8, 4, 2, 1.4, 1.1, 1, 0.5, 1.1, 1.4, 2, 4, 8, 25, 4, 2],
                14: [25, 8, 4, 2, 1.4, 1.1, 1, 0.5, 1.1, 1.4, 2, 4, 8, 25, 4, 2, 1.4],
                15: [25, 8, 4, 2, 1.4, 1.1, 1, 0.5, 1.1, 1.4, 2, 4, 8, 25, 4, 2, 1.4, 1.1],
                16: [43, 7, 4, 2, 1.5, 1.1, 1, 0.7, 0.4, 0.7, 1, 1.1, 1.5, 2, 4, 7, 43, 4, 2]
            },
            high: {
                8: [29, 4, 1.5, 0.2, 0.2, 0.2, 1.5, 4, 29, 4, 1.5],
                9: [29, 4, 1.5, 0.2, 0.2, 0.2, 1.5, 4, 29, 4, 1.5, 0.2],
                10: [29, 4, 1.5, 0.2, 0.2, 0.2, 1.5, 4, 29, 4, 1.5, 0.2, 0.2],
                11: [29, 4, 1.5, 0.2, 0.2, 0.2, 1.5, 4, 29, 4, 1.5, 0.2, 0.2, 0.2],
                12: [110, 41, 10, 5, 3, 1.5, 1, 0.5, 1.5, 3, 5, 10, 41, 110, 10],
                13: [110, 41, 10, 5, 3, 1.5, 1, 0.5, 1.5, 3, 5, 10, 41, 110, 10, 5],
                14: [110, 41, 10, 5, 3, 1.5, 1, 0.5, 1.5, 3, 5, 10, 41, 110, 10, 5, 3],
                15: [110, 41, 10, 5, 3, 1.5, 1, 0.5, 1.5, 3, 5, 10, 41, 110, 10, 5, 3, 1.5],
                16: [1000, 130, 26, 9, 4, 2, 0.2, 0.2, 0.2, 0.2, 0.2, 2, 4, 9, 26, 130, 1000, 26, 9]
            }
        };

        // ===========================================
        // PLINKO GAME ENGINE
        // ===========================================

        class PlinkoGame {
            constructor(canvas) {
                this.canvas = canvas;
                this.ctx = canvas.getContext('2d');
                this.width = canvas.width;
                this.height = canvas.height;

                // Game state
                this.balls = [];
                this.pegs = [];
                this.multipliers = [];
                this.currentRows = 12;
                this.currentRisk = 'low';

                // Animation
                this.animationId = null;
                this.lastTime = 0;

                this.setupGame();
                this.startAnimation();
            }

            setupGame() {
                this.setupPegs();
                this.setupMultipliers();
                this.initializeSounds();
            }

            setupPegs() {
                this.pegs = [];
                const rows = this.currentRows;

                // Increased peg sizes - original was 6/5/4
                const basePegRadius = rows <= 10 ? 10 : rows <= 12 ? 9 : 8;
                const pegRadius = basePegRadius;

                // Always create the same number of boxes
                const numberOfBoxes = this.currentRows + 3;
                const availableWidth = this.width * 0.8;

                // Calculate spacing to fit pegs perfectly above multiplier boxes
                const spacing = availableWidth / (rows + 2);

                const startX = this.width / 2;
                const startY = 80;

                for (let row = 0; row < rows; row++) {
                    const pegsInRow = row + 3;
                    const rowWidth = (pegsInRow - 1) * spacing;
                    const rowStartX = startX - rowWidth / 2;

                    for (let peg = 0; peg < pegsInRow; peg++) {
                        this.pegs.push({
                            x: rowStartX + peg * spacing,
                            y: startY + row * (spacing * 0.7), // Tighter vertical spacing
                            radius: pegRadius,
                            ripple: 0,
                            row: row,
                            pegInRow: peg,
                            isEdgePeg: peg === 0 || peg === pegsInRow - 1 // Mark edge pegs
                        });
                    }
                }
            }

            setupMultipliers() {
                this.multipliers = [];

                // Always create the same number of boxes regardless of rows
                const numberOfBoxes = this.currentRows + 3;
                const availableWidth = this.width * 0.8;
                const spacing = 2;
                const totalSpacing = (numberOfBoxes - 1) * spacing;
                const multiplierWidth = (availableWidth - totalSpacing) / numberOfBoxes;
                const multiplierHeight = 45;

                const startX = (this.width - availableWidth) / 2;

                // Position multipliers directly below the last row of pegs
                const lastRowPegs = this.pegs.filter(peg => peg.row === this.currentRows - 1);
                const lastPegY = lastRowPegs.length > 0 ? Math.max(...lastRowPegs.map(peg => peg.y)) : this.height -
                    200;
                const y = lastPegY + 60; // Small gap below pegs

                // Get multiplier values for current configuration
                const multiplierValues = this.getMultiplierValues(numberOfBoxes);

                // Create boxes
                for (let i = 0; i < numberOfBoxes; i++) {
                    this.multipliers.push({
                        x: startX + i * (multiplierWidth + spacing),
                        y: y,
                        width: multiplierWidth,
                        height: multiplierHeight,
                        value: multiplierValues[i],
                        color: this.getMultiplierColor(multiplierValues[i]),
                        bounceAnimation: 0
                    });
                }
            }

            getMultiplierValues(numberOfBoxes) {
                // Generate multiplier values based on current risk and number of boxes
                const baseValues = MULTIPLIER_CONFIG[this.currentRisk][this.currentRows];

                if (baseValues.length >= numberOfBoxes) {
                    return baseValues.slice(0, numberOfBoxes);
                } else {
                    // If we need more values, extend the array symmetrically
                    const values = [...baseValues];
                    while (values.length < numberOfBoxes) {
                        if (values.length % 2 === 0) {
                            values.unshift(baseValues[1] || 1);
                        } else {
                            values.push(baseValues[1] || 1);
                        }
                    }
                    return values.slice(0, numberOfBoxes);
                }
            }

            getMultiplierColor(value) {
                // Create gradient colors based on value like in the reference image
                if (value >= 1000) return '#8B0000'; // Dark red for extremely high values
                if (value >= 100) return '#DC143C'; // Crimson for very high values
                if (value >= 50) return '#FF4500'; // Orange red for high values
                if (value >= 10) return '#FF6347'; // Tomato for medium-high values
                if (value >= 5) return '#FFA500'; // Orange for medium values
                if (value >= 2) return '#FFD700'; // Gold for medium-low values
                if (value >= 1) return '#FFFF00'; // Yellow for low-medium values
                if (value >= 0.5) return '#ADFF2F'; // Green yellow for low values
                return '#FF6B6B'; // Light red for very low values
            }

            // Add this at the top of your class or before the dropBall method
            initializeSounds() {
                // Create audio objects for sound effects

                this.boxLandSound = new Audio();
                this.boxLandSound.preload = 'auto';
                this.boxLandSound.volume = 0.5;

                // You can use data URLs for simple sounds or link to audio files
                // Simple peg hit sound (short beep)

                // Box landing sound (different pitch)
                this.boxLandSound.src = '{{ asset('public/sounds/ball-land.mp3') }}';

                // Add sound control throttling
                this.lastPegSoundTime = 0;
                // this.pegSoundCooldown = 20; // Minimum 50ms between peg sounds
                this.pegHitSound = new Audio('{{ asset('public/sounds/collision.wav') }}');
                this.pegHitSound.preload = 'auto';
                this.pegHitSound.volume = 0.3;
                this.pegHitSound.load();
                // this.pegHitSound.addEventListener('canplaythrough', () => {
                //     console.log('Audio ready to play');
                // });
            }

            // Helper method to play peg hit sound with throttling
            playPegHitSound() {
                // console.log('playPegHitSound')
                const audio = new Audio(this.pegHitSound.src);
                audio.volume = this.pegHitSound.volume;
                audio.play().catch(e => console.log('Audio play failed:', e));
            }
            // Helper method to play box landing sound
            playBoxLandSound() {
                // console.log('playBoxLandSound')
                this.boxLandSound.currentTime = 0; // Reset to start
                this.boxLandSound.play().catch(e => console.log('Audio play failed:', e));
            }

          dropBall() {
            if (!gameRunning) return;
            this.playPegHitSound();
        
            // Moderately increased ball size (original was 10/9/8)
            const ballRadius = this.currentRows <= 10 ? 14 : this.currentRows <= 12 ? 12 : 10;
        
            const ball = {
                x: this.width / 2 + (Math.random() - 0.5) * 15,  // Original spread
                y: 50,  // Original starting position
                vx: (Math.random() - 0.5) * 1.2,  // Original velocity
                vy: 0,
                radius: ballRadius,
                color: '#FFD700',
                trail: [],
                bounces: 0,
                hasLanded: false
            };
        
            this.balls.push(ball);
        }
        

            updateBalls() {
                // const speedConfig = BALL_SPEED_CONFIG[this.currentRisk];
                const speedConfig = {
                    baseSpeed: 1.2,
                    maxSpeed: 1.2,
                    gravity: 0.4
                };

                // console.log(speedConfig)
                // console.log('object')

                this.balls.forEach((ball, ballIndex) => {
                    // Apply gravity
                    ball.vy += speedConfig.gravity;

                    // Limit maximum speed
                    ball.vx = Math.max(-speedConfig.maxSpeed, Math.min(speedConfig.maxSpeed, ball.vx));
                    ball.vy = Math.max(-speedConfig.maxSpeed, Math.min(speedConfig.maxSpeed, ball.vy));

                    // Update position
                    ball.x += ball.vx;
                    ball.y += ball.vy;

                    // Strict boundary constraints - keep ball within the game area
                    const gameWidth = this.width * 0.8;
                    const leftBoundary = (this.width - gameWidth) / 2;
                    const rightBoundary = leftBoundary + gameWidth;

                    if (ball.x - ball.radius < leftBoundary) {
                        ball.x = leftBoundary + ball.radius;
                        ball.vx = Math.abs(ball.vx) * 0.6; // Reduced bounce force
                    }
                    if (ball.x + ball.radius > rightBoundary) {
                        ball.x = rightBoundary - ball.radius;
                        ball.vx = -Math.abs(ball.vx) * 0.6; // Reduced bounce force
                    }

                    // Add to trail
                    ball.trail.push({
                        x: ball.x,
                        y: ball.y
                    });
                    if (ball.trail.length > 6) {
                        ball.trail.shift();
                    }

                    // Check peg collisions
                    this.pegs.forEach(peg => {
                        const dx = ball.x - peg.x;
                        const dy = ball.y - peg.y;
                        const distance = Math.sqrt(dx * dx + dy * dy);

                        if (distance < ball.radius + peg.radius) {
                            this.playPegHitSound();
                            // console.log('here')
                            // Bounce off peg
                            const angle = Math.atan2(dy, dx);
                            const targetX = peg.x + Math.cos(angle) * (peg.radius + ball.radius);
                            const targetY = peg.y + Math.sin(angle) * (peg.radius + ball.radius);

                            ball.x = targetX;
                            ball.y = targetY;

                            // Special handling for edge pegs - direct ball inward
                            if (peg.isEdgePeg) {
                                if (peg.pegInRow === 0) {
                                    // Left edge peg - direct ball to the right
                                    ball.vx = Math.abs(ball.vx) + 0.5;
                                } else {
                                    // Right edge peg - direct ball to the left
                                    ball.vx = -Math.abs(ball.vx) - 0.5;
                                }
                                ball.vy = speedConfig.baseSpeed * 0.8;
                            } else {
                                // Normal peg collision with reduced randomization
                                ball.vx = Math.cos(angle) * speedConfig.baseSpeed + (Math.random() -
                                    0.5) * 1;
                                ball.vy = Math.sin(angle) * speedConfig.baseSpeed + Math.random() * 0.3;
                            }

                            // Create ripple effect
                            peg.ripple = 20;

                            ball.bounces++;
                        }
                    });

                    // Check if ball reached multiplier area and hits the TOP of a box
                    if (ball.y + ball.radius >= this.multipliers[0].y && !ball.hasLanded) {
                        this.multipliers.forEach((multiplier, index) => {
                            if (ball.x >= multiplier.x &&
                                ball.x <= multiplier.x + multiplier.width &&
                                ball.y + ball.radius >= multiplier.y &&
                                ball.y <= multiplier.y + multiplier.height) {

                                ball.hasLanded = true;
                                // ✅ Play final hit sound/music here
                                this.playBoxLandSound?.();

                                // Create bounce effect
                                multiplier.bounceAnimation = 15;
                                ball.vy = -1.5;
                                ball.y = multiplier.y - ball.radius;

                                const winAmount = parseFloat($('#betAmount').val()) * multiplier.value;
                                let old_balance = balance;
                                balance += winAmount;
                                $('#balance').text(balance.toFixed(2));

                                // Add to history
                                this.addToHistory(multiplier.value);

                                // Get values for sending AJAX request
                                let form_id = '<?= $form->id ?>';
                                let bet_amount = $('#betAmount').val();
                                let multiplier_value = multiplier.value;
                                let risk_level = $('.risk-btn.active').data(
                                    'risk'); // Get active risk level
                                let rows_selected = $('#rows').val(); // Get selected rows
                                let game_type = $('#manualMode').hasClass('active') ? 'Manual' :
                                    'Auto'; // Check if manual or auto mode is active
                                let token_used = '<?= $token_id ?>';

                                // Update the ball data with the most recent values
                                ballData = {
                                    form_id: form_id,
                                    bet_amount: bet_amount,
                                    multiplier_value: multiplier_value,
                                    risk_level: risk_level,
                                    rows_selected: rows_selected,
                                    game_type: game_type,
                                    win_balance: winAmount,
                                    current_balance: old_balance,
                                    new_balance: old_balance + winAmount,
                                    token_used: token_used
                                };

                                if (!isBallInProgress) {
                                    // console.log(isBallInProgress)
                                    isBallInProgress = true;
                                    setTimeout(() => {
                                        isBallInProgress = false;
                                        // Send data via AJAX
                                        $.ajax({
                                            url: '/savegamedata',
                                            method: 'POST',
                                            data: {
                                                _token: '{{ csrf_token() }}',
                                                form_id: ballData.form_id,
                                                bet_amount: ballData.bet_amount,
                                                multiplier_value: ballData
                                                    .multiplier_value,
                                                risk_level: ballData.risk_level,
                                                rows_selected: ballData.rows_selected,
                                                game_type: ballData.game_type,
                                                win_balance: ballData.win_balance,
                                                current_balance: ballData
                                                    .current_balance,
                                                new_balance: ballData.new_balance,
                                                token_used: ballData.token_used
                                            },
                                            success: function(response) {
                                                console.log(
                                                    'Data saved successfully:',
                                                    response);
                                            },
                                            error: function(error) {
                                                console.error('Error saving data:',
                                                    error);
                                            }
                                        });
                                    }, 2000); // 2 seconds delay to wait for the next ball to land
                                }

                                // Remove ball
                                this.balls.splice(ballIndex, 1);

                                // Handle auto mode
                                if (isAutoRunning) {
                                    autoRemainingBets--;
                                    if (autoRemainingBets <= 0) {
                                        this.stopAutoMode();
                                    } else {
                                        setTimeout(() => {
                                            if (isAutoRunning) {
                                                this.dropBall();
                                            }
                                        }, 600);
                                    }
                                }

                                return;
                            }
                        });
                    }


                    // Remove ball if it goes too far down without hitting anything
                    if (ball.y > this.height + 100) {
                        this.balls.splice(ballIndex, 1);
                    }
                });
            }

            updatePegs() {
                this.pegs.forEach(peg => {
                    if (peg.ripple > 0) {
                        peg.ripple--;
                    }
                });

                // Update multiplier bounce animations
                this.multipliers.forEach(multiplier => {
                    if (multiplier.bounceAnimation > 0) {
                        multiplier.bounceAnimation--;
                    }
                });
            }

            draw() {
                // Clear canvas
                this.ctx.clearRect(0, 0, this.width, this.height);

                // Draw background pattern
                this.drawBackground();

                // Draw pegs
                this.pegs.forEach(peg => {
                    this.ctx.fillStyle = '#E0E0E0';
                    this.ctx.beginPath();
                    this.ctx.arc(peg.x, peg.y, peg.radius, 0, Math.PI * 2);
                    this.ctx.fill();

                    // Draw ripple effect
                    if (peg.ripple > 0) {
                        this.ctx.strokeStyle = `rgba(255, 255, 255, ${peg.ripple / 20})`;
                        this.ctx.lineWidth = 2;
                        this.ctx.beginPath();
                        this.ctx.arc(peg.x, peg.y, peg.radius + peg.ripple, 0, Math.PI * 2);
                        this.ctx.stroke();
                    }
                });

                // Draw multipliers with box shadow effect
                this.multipliers.forEach(multiplier => {
                    // Draw shadow first
                    this.ctx.fillStyle = 'rgba(0, 0, 0, 0.3)';
                    this.ctx.fillRect(
                        multiplier.x + 3,
                        multiplier.y + 3,
                        multiplier.width,
                        multiplier.height
                    );

                    // Apply bounce animation
                    const bounceOffset = multiplier.bounceAnimation > 0 ?
                        Math.sin(multiplier.bounceAnimation * 0.5) * 3 : 0;

                    // Draw main box
                    this.ctx.fillStyle = multiplier.color;
                    this.ctx.fillRect(
                        multiplier.x,
                        multiplier.y - bounceOffset,
                        multiplier.width,
                        multiplier.height
                    );

                    // Draw border
                    this.ctx.strokeStyle = 'rgba(255, 255, 255, 0.3)';
                    this.ctx.lineWidth = 1;
                    this.ctx.strokeRect(
                        multiplier.x,
                        multiplier.y - bounceOffset,
                        multiplier.width,
                        multiplier.height
                    );

                    // Draw multiplier text
                    this.ctx.fillStyle = 'black';
                    this.ctx.font = 'bold 11px Arial';
                    this.ctx.textAlign = 'center';
                    this.ctx.fillText(
                        multiplier.value + 'x',
                        multiplier.x + multiplier.width / 2,
                        multiplier.y + multiplier.height / 2 + 4 - bounceOffset
                    );
                });

                // Draw balls
                this.balls.forEach(ball => {
                    // Draw trail
                    ball.trail.forEach((point, index) => {
                        const alpha = (index + 1) / ball.trail.length * 0.5;
                        this.ctx.fillStyle = `rgba(255, 215, 0, ${alpha})`;
                        this.ctx.beginPath();
                        this.ctx.arc(point.x, point.y, ball.radius * alpha, 0, Math.PI * 2);
                        this.ctx.fill();
                    });

                    // Draw ball
                    this.ctx.fillStyle = ball.color;
                    this.ctx.beginPath();
                    this.ctx.arc(ball.x, ball.y, ball.radius, 0, Math.PI * 2);
                    this.ctx.fill();

                    // Draw ball highlight
                    this.ctx.fillStyle = 'rgba(255, 255, 255, 0.3)';
                    this.ctx.beginPath();
                    this.ctx.arc(ball.x - 2, ball.y - 2, ball.radius * 0.4, 0, Math.PI * 2);
                    this.ctx.fill();
                });
            }

            drawBackground() {
                // Draw subtle grid pattern
                this.ctx.strokeStyle = 'rgba(255, 255, 255, 0.1)';
                this.ctx.lineWidth = 1;

                for (let x = 0; x < this.width; x += 20) {
                    this.ctx.beginPath();
                    this.ctx.moveTo(x, 0);
                    this.ctx.lineTo(x, this.height);
                    this.ctx.stroke();
                }

                for (let y = 0; y < this.height; y += 20) {
                    this.ctx.beginPath();
                    this.ctx.moveTo(0, y);
                    this.ctx.lineTo(this.width, y);
                    this.ctx.stroke();
                }
            }

            addToHistory(multiplier) {
                gameHistory.unshift(multiplier);
                if (gameHistory.length > 4) {
                    gameHistory.pop();
                }

                // Update history display
                const historyItems = $('#historyItems').children();
                gameHistory.forEach((value, index) => {
                    const item = $(historyItems[index]);
                    item.text(value + 'x');
                    item.removeClass(
                        'multiplier-low multiplier-medium multiplier-high multiplier-extreme multiplier-jackpot'
                    );

                    if (value >= 100) item.addClass('multiplier-jackpot');
                    else if (value >= 10) item.addClass('multiplier-extreme');
                    else if (value >= 3) item.addClass('multiplier-high');
                    else if (value >= 1) item.addClass('multiplier-medium');
                    else item.addClass('multiplier-low');
                });

                // Fill remaining slots with dashes
                for (let i = gameHistory.length; i < 4; i++) {
                    $(historyItems[i]).text('-').removeClass(
                        'multiplier-low multiplier-medium multiplier-high multiplier-extreme multiplier-jackpot');
                }
            }

            updateRows(rows) {
                this.currentRows = rows;
                this.setupGame();
            }

            updateRisk(risk) {
                this.currentRisk = risk;
                this.setupGame();
            }

            startAnimation() {
                const animate = (currentTime) => {
                    if (!gameRunning) {
                        window.gameAnimationFrame = requestAnimationFrame(animate);
                        return;
                    }

                    const deltaTime = currentTime - this.lastTime;
                    this.lastTime = currentTime;

                    this.updateBalls();
                    this.updatePegs();
                    this.draw();

                    window.gameAnimationFrame = requestAnimationFrame(animate);
                };

                window.gameAnimationFrame = requestAnimationFrame(animate);
            }

            stopAutoMode() {
                isAutoRunning = false;
                autoRemainingBets = 0;
                $('#dropButton').prop('disabled', false);
                $('#autoBetButton').text('Start Autobet').prop('disabled', false);
                $('#gameStatus').text('Autobet completed!');

                setTimeout(() => {
                    $('#gameStatus').text('Ready to play!');
                }, 3000);
            }

            resume() {
                if (!this.animationId) {
                    this.startAnimation();
                }
            }
        }

        // ===========================================
        // GAME INITIALIZATION AND EVENT HANDLERS
        // ===========================================

        $(document).ready(function() {
            // Initialize game
            const canvas = document.getElementById('gameCanvas');
            window.gameInstance = new PlinkoGame(canvas);

            // Update canvas size based on container and rows
            function resizeCanvas() {
                const container = canvas.parentElement;
                const containerWidth = container.clientWidth;
                const containerHeight = container.clientHeight;

                // Set canvas to fill its container
                canvas.width = containerWidth;
                canvas.height = containerHeight;
                canvas.style.width = '100%';
                canvas.style.height = '100%';

                // Update game dimensions
                if (window.gameInstance) {
                    window.gameInstance.width = canvas.width;
                    window.gameInstance.height = canvas.height;
                    window.gameInstance.setupGame();
                }
            }

            // Initial resize and setup resize listener
            resizeCanvas();
            $(window).on('resize', resizeCanvas);

            //play game start sound when user clicks play
            // Animate the percentage bar
            var percentage = 0;
            var interval = setInterval(function() {
                if (percentage >= 100) {
                    clearInterval(interval);
                    // Show the play button once the percentage bar is complete
                    $('#playButton').fadeIn();
                } else {
                    percentage += 1;
                    $('#percentageBar').css('width', percentage + '%');
                }
            }, 10); // Update every 30ms to reach 100% in ~3 seconds

            // Slide up the overlay when the play button is clicked
            $('#playButton').click(function() {
                var audio = new Audio('{{ asset('public/sounds/game-start.wav') }}');
                audio.play();

                // Slide up the overlay and hide it after the transition ends
                $('#overlay').css('transform', 'translateY(-100%)').css('opacity', '0');
                $('.header').removeClass('hidden');
            });

            // Prevent clicking outside the button from doing anything
            $('#overlay').click(function(e) {
                if (!$(e.target).is('#playButton')) {
                    e.stopPropagation(); // Prevent any interaction outside the button
                }
            });

            // Handle 1/2 button click
            $('#halfButton').click(function() {
                let currentAmount = parseFloat($('#betAmount').val());
                let newAmount = (currentAmount / 2).toFixed(2);

                // Check if the new betAmount exceeds the balance
                if (parseFloat(newAmount) <= balance) {
                    $('#betAmount').val(newAmount);
                } else {
                    toastr.error("Bet amount cannot exceed balance.");
                }
            });

            // Handle 2X button click
            $('#doubleButton').click(function() {
                let currentAmount = parseFloat($('#betAmount').val());
                let newAmount = (currentAmount * 2).toFixed(2);

                // Check if the new betAmount exceeds the balance
                if (parseFloat(newAmount) <= balance) {
                    $('#betAmount').val(newAmount);
                } else {
                    toastr.error("Bet amount cannot exceed balance.");
                }
            });

            // Mode switching
            $('#manualMode').on('click', function() {
                if (isAutoRunning) return;

                currentMode = 'manual';
                $(this).addClass('active');
                $('#autoMode').removeClass('active');
                $('#autoControls').removeClass('active');
                $('#dropButton').show();
                $('#autoBetButton').hide();
            });

            $('#autoMode').on('click', function() {
                if (isAutoRunning) return;

                currentMode = 'auto';
                $(this).addClass('active');
                $('#manualMode').removeClass('active');
                $('#autoControls').addClass('active');
                $('#dropButton').hide();
                $('#autoBetButton').show();
            });

            // Risk level selection
            $('.risk-btn').on('click', function() {
                if (isAutoRunning) return;

                $('.risk-btn').removeClass('active');
                $(this).addClass('active');
                currentRisk = $(this).data('risk');
                window.gameInstance.updateRisk(currentRisk);
            });

            // Rows input change
            $('#rows').on('change input', function() {
                if (isAutoRunning) return;

                const rows = parseInt($(this).val());
                if (rows >= 8 && rows <= 16) {
                    window.gameInstance.updateRows(rows);
                    resizeCanvas(); // Resize canvas when rows change
                }
            });

            // Manual drop button
            $('#dropButton').on('click', function() {
                if (!gameRunning || isAutoRunning) return;

                const betAmount = parseFloat($('#betAmount').val());
                if (betAmount > balance) {
                    toastr.error('Insufficient balance.');
                    return;
                }

                if (betAmount < 1) {
                    toastr.error('Minimum bet is $1');
                    return;
                }

                // Deduct bet amount
                balance -= betAmount;
                $('#balance').text(balance.toFixed(2));

                // Drop ball
                window.gameInstance.dropBall();

                // Update status
                $('#gameStatus').text('Ball dropped!');
                setTimeout(() => {
                    $('#gameStatus').text('Ready to play!');
                }, 2000);
            });

            // Auto bet button
            $('#autoBetButton').on('click', function() {
                if (!gameRunning) return;

                if (!isAutoRunning) {
                    // Start auto mode
                    const betAmount = parseFloat($('#betAmount').val());
                    const numberOfBets = parseInt($('#numberOfBets').val());

                    if (betAmount * numberOfBets > balance) {
                        toastr.error('Insufficient balance for all bets!');
                        return;
                    }

                    if (betAmount < 1) {
                        toastr.error('Minimum bet is $1');
                        return;
                    }

                    if (numberOfBets < 1 || numberOfBets > 100) {
                        toastr.error('Number of bets must be between 1 and 100');
                        return;
                    }

                    // Start auto mode
                    isAutoRunning = true;
                    autoRemainingBets = numberOfBets;

                    $(this).text('Stop Autobet');
                    $('#dropButton').prop('disabled', true);
                    $('#gameStatus').text(`Autobet running: ${autoRemainingBets} bets remaining`);

                    // Start first bet
                    balance -= betAmount;
                    $('#balance').text(balance.toFixed(2));
                    window.gameInstance.dropBall();

                    // Update status periodically
                    const statusInterval = setInterval(() => {
                        if (isAutoRunning) {
                            $('#gameStatus').text(
                                `Autobet running: ${autoRemainingBets} bets remaining`);
                        } else {
                            clearInterval(statusInterval);
                        }
                    }, 1000);

                } else {
                    // Stop auto mode
                    window.gameInstance.stopAutoMode();
                }
            });

            // Input validation
            $('#betAmount').on('input', function() {
                const value = parseFloat($(this).val());
                if (value > balance) {
                    $(this).val(balance);
                }
                if (value < 1) {
                    $(this).val(1);
                }
            });

            $('#numberOfBets').on('input', function() {
                const value = parseInt($(this).val());
                if (value > 100) {
                    $(this).val(100);
                }
                if (value < 1) {
                    $(this).val(1);
                }
            });

            $('#rows').on('input', function() {
                const value = parseInt($(this).val());
                if (value > 16) {
                    $(this).val(16);
                }
                if (value < 8) {
                    $(this).val(8);
                }
            });

            // ===========================================
            // DEVELOPER ANALYTICS (Hidden from user)
            // ===========================================

            // Game statistics for developer analysis
            let gameStats = {
                totalBets: 0,
                totalWinnings: 0,
                totalLosses: 0,
                biggestWin: 0,
                biggestLoss: 0,
                averageMultiplier: 0,
                riskDistribution: {
                    low: 0,
                    medium: 0,
                    high: 0
                },
                rowsDistribution: {},
                sessionStartTime: Date.now(),
                ballDrops: []
            };

            // Function to log game data (for developer analytics)
            function logGameData(multiplier, betAmount, risk, rows) {
                gameStats.totalBets++;
                const winAmount = betAmount * multiplier;
                const netProfit = winAmount - betAmount;

                gameStats.totalWinnings += winAmount;
                if (netProfit > 0 && netProfit > gameStats.biggestWin) {
                    gameStats.biggestWin = netProfit;
                }
                if (netProfit < 0 && Math.abs(netProfit) > gameStats.biggestLoss) {
                    gameStats.biggestLoss = Math.abs(netProfit);
                }

                gameStats.riskDistribution[risk]++;
                gameStats.rowsDistribution[rows] = (gameStats.rowsDistribution[rows] || 0) + 1;

                gameStats.ballDrops.push({
                    timestamp: Date.now(),
                    multiplier: multiplier,
                    betAmount: betAmount,
                    winAmount: winAmount,
                    netProfit: netProfit,
                    risk: risk,
                    rows: rows
                });

                // Calculate average multiplier
                const totalMultiplier = gameStats.ballDrops.reduce((sum, drop) => sum + drop.multiplier, 0);
                gameStats.averageMultiplier = totalMultiplier / gameStats.ballDrops.length;

                // Developer can access these stats via console: window.gameStats
                window.gameStats = gameStats;
            }

            // Override the addToHistory method to include analytics
            const originalAddToHistory = window.gameInstance.addToHistory;
            window.gameInstance.addToHistory = function(multiplier) {
                const betAmount = parseFloat($('#betAmount').val());
                const risk = currentRisk;
                const rows = parseInt($('#rows').val());

                // Log for developer analytics
                logGameData(multiplier, betAmount, risk, rows);

                // Call original method
                originalAddToHistory.call(this, multiplier);
            };

            // Console command for developers to view game statistics
            // window.showGameStats = function() {
            //     console.log('=== GAME STATISTICS (DEVELOPER ONLY) ===');
            //     console.log('Total Bets:', gameStats.totalBets);
            //     console.log('Total Winnings:', gameStats.totalWinnings.toFixed(2));
            //     console.log('Average Multiplier:', gameStats.averageMultiplier.toFixed(2));
            //     console.log('Biggest Win:', gameStats.biggestWin.toFixed(2));
            //     console.log('Biggest Loss:', gameStats.biggestLoss.toFixed(2));
            //     console.log('Risk Distribution:', gameStats.riskDistribution);
            //     console.log('Rows Distribution:', gameStats.rowsDistribution);
            //     console.log('Session Duration:', ((Date.now() - gameStats.sessionStartTime) / 1000 / 60).toFixed(1), 'minutes');
            //     console.log('Recent Drops:', gameStats.ballDrops.slice(-10));
            //     return gameStats;
            // };

            // Randomization system for fair play
            function enhanceRandomization() {
                // Seed-based randomization for better unpredictability
                let seed = Date.now() % 2147483647;

                // Custom random function for game mechanics
                window.gameRandom = function() {
                    seed = (seed * 16807) % 2147483647;
                    return (seed - 1) / 2147483646;
                };

                // Apply randomization to ball physics
                const originalDropBall = window.gameInstance.dropBall;
                window.gameInstance.dropBall = function() {
                    // Add randomization to initial ball position and velocity
                    const randomOffset = (window.gameRandom() - 0.5) * 30;
                    const randomVelocity = (window.gameRandom() - 0.5) * 3;

                    originalDropBall.call(this);

                    // Apply randomization to the last ball added
                    if (this.balls.length > 0) {
                        const lastBall = this.balls[this.balls.length - 1];
                        lastBall.x += randomOffset;
                        lastBall.vx += randomVelocity;
                    }
                };
            }

            // Initialize enhanced randomization
            enhanceRandomization();

            // Performance monitoring (developer only)
            let performanceStats = {
                frameCount: 0,
                lastFrameTime: performance.now(),
                averageFPS: 0,
                minFPS: Infinity,
                maxFPS: 0
            };

            // Monitor game performance
            // function monitorPerformance() {
            //     const currentTime = performance.now();
            //     const deltaTime = currentTime - performanceStats.lastFrameTime;
            //     const fps = 1000 / deltaTime;

            //     performanceStats.frameCount++;
            //     performanceStats.lastFrameTime = currentTime;

            //     if (fps < performanceStats.minFPS) performanceStats.minFPS = fps;
            //     if (fps > performanceStats.maxFPS) performanceStats.maxFPS = fps;

            //     // Calculate average FPS over last 60 frames
            //     if (performanceStats.frameCount % 60 === 0) {
            //         performanceStats.averageFPS = fps;
            //         window.performanceStats = performanceStats;
            //     }
            // }

            // Hook into animation loop for performance monitoring
            const originalAnimate = window.gameInstance.startAnimation;
            window.gameInstance.startAnimation = function() {
                const self = this;
                const animate = (currentTime) => {
                    if (!gameRunning) {
                        window.gameAnimationFrame = requestAnimationFrame(animate);
                        return;
                    }

                    // Monitor performance
                    // monitorPerformance();

                    const deltaTime = currentTime - self.lastTime;
                    self.lastTime = currentTime;

                    self.updateBalls();
                    self.updatePegs();
                    self.draw();

                    window.gameAnimationFrame = requestAnimationFrame(animate);
                };

                window.gameAnimationFrame = requestAnimationFrame(animate);
            };

            // Restart animation with performance monitoring
            window.gameInstance.startAnimation();

            // Developer commands
            window.resetGame = function() {
                if (confirm('Reset game? This will clear all statistics.')) {
                    balance = 1000;
                    $('#balance').text(balance.toFixed(2));
                    gameHistory = [];
                    gameStats = {
                        totalBets: 0,
                        totalWinnings: 0,
                        totalLosses: 0,
                        biggestWin: 0,
                        biggestLoss: 0,
                        averageMultiplier: 0,
                        riskDistribution: {
                            low: 0,
                            medium: 0,
                            high: 0
                        },
                        rowsDistribution: {},
                        sessionStartTime: Date.now(),
                        ballDrops: []
                    };
                    window.gameInstance.addToHistory(0); // Clear history display
                    console.log('Game reset complete');
                }
            };

            // Add developer info to console
            // console.log('%c🎯 PLINKO GAME - DEVELOPER CONSOLE', 'color: #4CAF50; font-size: 16px; font-weight: bold;');
            // console.log('%cAvailable Developer Commands:', 'color: #FFA500; font-size: 14px;');
            // console.log('• window.showGameStats() - View game statistics');
            // console.log('• window.resetGame() - Reset game and statistics');
            // console.log('• window.gameStats - Access raw game statistics');
            // console.log('• window.performanceStats - View performance metrics');
            // console.log('%cGame initialized successfully!', 'color: #4CAF50;');
        });
    </script>
</body>

</html>
