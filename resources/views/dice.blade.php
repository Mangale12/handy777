<style>
    /* Functions on mobile devices but looks best at or bigger than dimensions 1035x665 */

*,
*::before,
*::after {
  box-sizing: border-box;
  transform-style: preserve-3d;
  font-family: sans-serif;
}

body {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
  min-height: 100vh;
  overflow: hidden;
  background: #222;
  margin: 0;
  animation: colors 12s linear infinite;
}

@keyframes colors {
  from {
    filter: hue-rotate(0deg) saturate(150%);
  }
  to {
    filter: hue-rotate(360deg) saturate(150%);
  }
}

.scene {
  position: absolute;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  width: auto;
  height: auto;
  background: gray;
  perspective: 9999px;
}

@keyframes display {
  0% {
    transform: rotateX(45deg) rotateZ(45deg);
  }
  100% {
    transform: rotateX(45deg) rotateZ(405deg);
  }
}

.plane-starter {
  background: transparent;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: center;
  position: absolute;
  width: 600px;
  height: 600px;
  transform: rotateX(45deg) rotateZ(45deg);
  animation: display 25s linear infinite;
}

.plane-starter > figure {
  position: absolute;
  background-color: Cyan;
  background-image: linear-gradient(blue 3px, transparent 3px),
    linear-gradient(to right, blue 3px, rgba(0, 0, 0, 0.5) 3px);
  background-size: 75px 75px;
  width: 100%;
  height: 100%;
  display: block;
  transform-origin: 50% 50%;
  border: 40px solid mediumspringgreen;
  animation: slide 10s linear infinite;
}

@keyframes slide {
  0% {
    background-position: -100%;
  }
  100% {
    background-position: 102%;
  }
}

.plane-starter > figure::after,
.plane-starter > figure::before {
  position: absolute;
  top: 0;
  left: 0;
  width: 100%;
  height: 100%;
  content: "";
  background: radial-gradient(
    circle,
    rgba(0, 0, 0, 1) 0%,
    rgba(0, 0, 0, 0) 100%
  );
  opacity: 0.7;
}

.plane-drop-back-left {
  transform: rotateY(90deg) translateZ(-300px) translateX(300px);
}

.plane-drop-back-left-back {
  transform: rotateY(90deg) translateZ(-350px) translateX(300px);
  height: 117% !important;
  opacity: 0.6;
  background-image: unset !important;
}

.plane-drop-back-left-back-cover,
.plane-drop-back-right-back-cover {
  transform: translateX(-325px);
  height: 116.5% !important;
  width: 8.5% !important;
  border: unset !important;
  background-image: unset !important;
}

.plane-drop-back-right-back-cover p {
  position: absolute;
  color: white;
  transform: translateZ(30px);
  font-size: 20pt;
  right: 0;
  top: -30px;
  line-height: 0;
  margin: 0;
}

.plane-drop-back-right {
  transform: rotateY(90deg) rotateX(90deg) translateZ(300px) translateX(300px);
}

.plane-drop-back-right-back {
  transform: rotateY(90deg) rotateX(90deg) translateZ(350px) translateX(300px);
  height: 117% !important;
  opacity: 0.6;
  background-image: unset !important;
}

.plane-drop-back-right-back-cover {
  transform: translateX(325px);
}

.plane-drop-front-left {
  transform: rotateY(90deg) rotateX(90deg) translateZ(-300px) translateX(300px);
}

.plane-drop-front-left-back {
  transform: rotateY(90deg) rotateX(90deg) translateZ(-350px) translateX(300px);
  height: 117% !important;
  opacity: 0.6;
  background-image: unset !important;
}

.plane-drop-front-left-back-cover,
.plane-drop-front-right-back-cover {
  transform: rotateZ(90deg) translateX(325px);
  height: 116.5% !important;
  width: 8.5% !important;
  border: unset !important;
  background-image: unset !important;
}

.plane-drop-front-back {
  transform: rotateY(90deg) rotateX(90deg) translateZ(-350px) translateX(300px);
}

.plane-drop-front-right {
  transform: rotateY(90deg) translateZ(300px) translateX(300px);
}

.plane-drop-front-right-back {
  transform: rotateY(90deg) translateZ(350px) translateX(300px);
  height: 117% !important;
  opacity: 0.6;
  background-image: unset !important;
}

.plane-drop-front-right-back-cover {
  transform: rotateZ(90deg) translateX(-325px);
}

.plane-drop-bottom {
  transform: translateZ(-600px);
  width: 117% !important;
  height: 117% !important;
  background-image: unset !important;
}

.cube-grid {
  position: absolute;
  bottom: 15px;
  display: flex;
  flex-direction: column;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  height: 100%;
}

.cube-row {
  position: absolute;
  right: 15px;
  display: flex;
  flex-direction: row;
  align-items: center;
  justify-content: space-between;
  width: 100%;
  height: 100%;
}

.cube-row:nth-child(2) {
  top: 25%;
}

.cube-row:nth-child(3) {
  top: 50%;
}

.cube-row:nth-child(4) {
  top: 75%;
}

.cube {
  position: absolute;
  top: 5%;
  right: 25%;
  animation: pump 3s ease-in-out infinite;
  animation-direction: reverse;
}

.cube:nth-child(2) {
  right: 50%;
}

.cube:nth-child(3) {
  right: 75%;
}

.cube:nth-child(4) {
  right: 100%;
}

.cube > figure {
  display: block;
  position: absolute;
  width: 100px;
  height: 100px;
  transform-origin: 50% 50%;
  background: rgba(0, 0, 0, 0.7);
  border: 7px groove blue;
  border-radius: 5px;
  transition: all 0.3s ease-in-out;
}

.cube > figure:hover {
  border-radius: 100%;
  cursor: pointer;
  border: 7px solid blue;
  background: transparent;
  transition: all 0.3s ease-in-out;
}

.front {
  transform: translateZ(50px);
}
.back {
  transform: rotateY(180deg) translateZ(50px);
}
.top {
  transform: rotateX(90deg) translateZ(50px);
}
.bottom {
  transform: rotateX(-90deg) translateZ(50px);
}
.left {
  transform: rotateY(-90deg) translateZ(50px);
}
.right {
  transform: rotateY(90deg) translateZ(50px);
}

@keyframes pump {
  0% {
    transform: translateZ(0px);
  }
  25% {
    transform: translateZ(-550px);
  }
  75% {
    transform: translateZ(70px);
  }
  100% {
    transform: translateZ(0px);
  }
}

.cube-row:nth-child(1) > .cube:nth-child(2) {
  animation-delay: 0.2s;
}

.cube-row:nth-child(1) > .cube:nth-child(3) {
  animation-delay: 0.4s;
}

.cube-row:nth-child(1) > .cube:nth-child(4) {
  animation-delay: 0.6s;
}

.cube-row:nth-child(2) > .cube:nth-child(4) {
  animation-delay: 0.8s;
}

.cube-row:nth-child(3) > .cube:nth-child(4) {
  animation-delay: 1s;
}

.cube-row:nth-child(4) > .cube:nth-child(4) {
  animation-delay: 1.2s;
}

.cube-row:nth-child(4) > .cube:nth-child(3) {
  animation-delay: 1.4s;
}

.cube-row:nth-child(4) > .cube:nth-child(2) {
  animation-delay: 1.6s;
}

.cube-row:nth-child(4) > .cube:nth-child(1) {
  animation-delay: 1.8s;
}

.cube-row:nth-child(3) > .cube:nth-child(1) {
  animation-delay: 2s;
}

.cube-row:nth-child(2) > .cube:nth-child(1) {
  animation-delay: 2.2s;
}

.cube-row:nth-child(2) > .cube:nth-child(2) {
  animation-delay: 2.4s;
}

.cube-row:nth-child(2) > .cube:nth-child(3) {
  animation-delay: 2.6s;
}

.cube-row:nth-child(3) > .cube:nth-child(3) {
  animation-delay: 2.8s;
}

.cube-row:nth-child(3) > .cube:nth-child(2) {
  animation-delay: 3s;
}
</style>

<div class="scene">

  <div class="plane-starter">

    <figure class="plane-drop-back-left">
    </figure>

    <figure class="plane-drop-back-left-back">
    </figure>

    <figure class="plane-drop-back-left-back-cover">
    </figure>

    <figure class="plane-drop-back-right">
    </figure>

    <figure class="plane-drop-back-right-back">
    </figure>

    <figure class="plane-drop-back-right-back-cover">
      <p>CloudGame</p>
    </figure>

    <figure class="plane-drop-front-left">
    </figure>

    <figure class="plane-drop-front-left-back">
    </figure>

    <figure class="plane-drop-front-left-back-cover">
    </figure>

    <figure class="plane-drop-front-right">
    </figure>

    <figure class="plane-drop-front-right-back">
    </figure>

    <figure class="plane-drop-front-right-back-cover">
    </figure>

    <figure class="plane-drop-bottom">
    </figure>

    <div class="cube-grid">

      <div class="cube-row">

        <div class="cube">
          <figure class="back"></figure>
          <figure class="top"></figure>
          <figure class="bottom"></figure>
          <figure class="left"></figure>
          <figure class="right"></figure>
          <figure class="front"></figure>
        </div>

        <div class="cube">
          <figure class="back"></figure>
          <figure class="top"></figure>
          <figure class="bottom"></figure>
          <figure class="left"></figure>
          <figure class="right"></figure>
          <figure class="front"></figure>
        </div>

        <div class="cube">
          <figure class="back"></figure>
          <figure class="top"></figure>
          <figure class="bottom"></figure>
          <figure class="left"></figure>
          <figure class="right"></figure>
          <figure class="front"></figure>
        </div>

        <div class="cube">
          <figure class="back"></figure>
          <figure class="top"></figure>
          <figure class="bottom"></figure>
          <figure class="left"></figure>
          <figure class="right"></figure>
          <figure class="front"></figure>
        </div>

      </div>

      <div class="cube-row">

        <div class="cube">
          <figure class="back"></figure>
          <figure class="top"></figure>
          <figure class="bottom"></figure>
          <figure class="left"></figure>
          <figure class="right"></figure>
          <figure class="front"></figure>
        </div>

        <div class="cube">
          <figure class="back"></figure>
          <figure class="top"></figure>
          <figure class="bottom"></figure>
          <figure class="left"></figure>
          <figure class="right"></figure>
          <figure class="front"></figure>
        </div>

        <div class="cube">
          <figure class="back"></figure>
          <figure class="top"></figure>
          <figure class="bottom"></figure>
          <figure class="left"></figure>
          <figure class="right"></figure>
          <figure class="front"></figure>
        </div>

        <div class="cube">
          <figure class="back"></figure>
          <figure class="top"></figure>
          <figure class="bottom"></figure>
          <figure class="left"></figure>
          <figure class="right"></figure>
          <figure class="front"></figure>
        </div>

      </div>

      <div class="cube-row">

        <div class="cube">
          <figure class="back"></figure>
          <figure class="top"></figure>
          <figure class="bottom"></figure>
          <figure class="left"></figure>
          <figure class="right"></figure>
          <figure class="front"></figure>
        </div>

        <div class="cube">
          <figure class="back"></figure>
          <figure class="top"></figure>
          <figure class="bottom"></figure>
          <figure class="left"></figure>
          <figure class="right"></figure>
          <figure class="front"></figure>
        </div>

        <div class="cube">
          <figure class="back"></figure>
          <figure class="top"></figure>
          <figure class="bottom"></figure>
          <figure class="left"></figure>
          <figure class="right"></figure>
          <figure class="front"></figure>
        </div>

        <div class="cube">
          <figure class="back"></figure>
          <figure class="top"></figure>
          <figure class="bottom"></figure>
          <figure class="left"></figure>
          <figure class="right"></figure>
          <figure class="front"></figure>
        </div>

      </div>

      <div class="cube-row">

        <div class="cube">
          <figure class="back"></figure>
          <figure class="top"></figure>
          <figure class="bottom"></figure>
          <figure class="left"></figure>
          <figure class="right"></figure>
          <figure class="front"></figure>
        </div>

        <div class="cube">
          <figure class="back"></figure>
          <figure class="top"></figure>
          <figure class="bottom"></figure>
          <figure class="left"></figure>
          <figure class="right"></figure>
          <figure class="front"></figure>
        </div>

        <div class="cube">
          <figure class="back"></figure>
          <figure class="top"></figure>
          <figure class="bottom"></figure>
          <figure class="left"></figure>
          <figure class="right"></figure>
          <figure class="front"></figure>
        </div>

        <div class="cube">
          <figure class="back"></figure>
          <figure class="top"></figure>
          <figure class="bottom"></figure>
          <figure class="left"></figure>
          <figure class="right"></figure>
          <figure class="front"></figure>
        </div>

      </div>

    </div>

  </div>

</div>