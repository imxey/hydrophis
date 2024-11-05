<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Speed Meter</title>
  
</head>
<body>
    <center>
  <div class="speedometer">
    <div class="speedometer-arrow"></div>
    <div class="speedometer-center"></div>
    <div class="speedometer-labels">

    </div>
  </div>
  
  <p id="speedValue">0 km/h</p>

  <script src="script.js"></script>
</center>
</body>
</html>
<style>
  .speedometer {
  width: 200px;
  height: 200px;
  border: 10px solid #ccc;
  border-radius: 50%;
  position: relative;
}

.speedometer-arrow {
  width: 2px;
  height: 90px;
  background-color: red;
  position: absolute;
  top: 55px;
  left: 50%;
  transform-origin: bottom center;
  transform: translateX(-50%) rotate(0deg);
  transition: transform 0.5s ease;
}

.speedometer-center {
  width: 10px;
  height: 10px;
  background-color: #000;
  border-radius: 50%;
  position: absolute;
  top: 95px;
  left: 50%;
  transform: translateX(-50%);
}

.speedometer-labels {
  position: absolute;
  top: 10px;
  left: 50%;
  transform: translateX(-50%);
  display: flex;
  justify-content: space-between;
  width: 80%;
  font-size: 12px;
}

input[type="range"] {
  margin-top: 20px;
  width: 200px;
}

#speedValue {
  text-align: center;
}
</style>
<script>
  var phValue = localStorage.getItem('phValue');
  document.addEventListener("DOMContentLoaded", function() {
  const arrow = document.querySelector(".speedometer-arrow");
  const speedInput = document.getElementById("speedInput");
  const speedValue = document.getElementById("speedValue");
  const speed = phValue;
    const angle = (speed / 100) * 180 - 90;
    arrow.style.transform = `translateX(-50%) rotate(${angle}deg)`;
    speedValue.textContent = `${speed}`;
    
});
</script>