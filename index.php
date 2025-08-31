<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Kawakawa Corporation</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Orbitron:wght@400;700&display=swap');

    body {
      margin: 0;
      height: 100vh;
      background: radial-gradient(circle at center, #0a0f1c, #000);
      color: #cce0ff;
      font-family: 'Orbitron', sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      overflow: hidden;
    }

    h1 {
      font-size: 3rem;
      letter-spacing: 0.2em;
      text-transform: uppercase;
      color: #00e5ff;
      text-shadow: 0 0 10px #00e5ff, 0 0 30px #0099cc;
      margin: 0;
      animation: glow 3s infinite alternate;
    }

    p {
      font-size: 1.2rem;
      letter-spacing: 0.1em;
      margin-top: 15px;
      opacity: 0.8;
    }

    .scanline {
      position: absolute;
      top: 0;
      left: 0;
      width: 100%;
      height: 2px;
      background: rgba(0, 255, 255, 0.2);
      animation: scan 6s linear infinite;
    }

    @keyframes glow {
      from { text-shadow: 0 0 10px #00e5ff, 0 0 20px #0099cc; }
      to { text-shadow: 0 0 20px #00e5ff, 0 0 40px #00ccff; }
    }

    @keyframes scan {
      0% { top: 0; }
      100% { top: 100%; }
    }

    footer {
      position: absolute;
      bottom: 15px;
      font-size: 0.8rem;
      opacity: 0.5;
      text-align: center;
    }
  </style>
</head>
<body>
  <div class="scanline"></div>
  <h1>Kawakawa Corporation</h1>
  <p>Initializing systems... Coming Soon</p>
  <footer>
  © 2025<span id="year"></span> RedNeckSnailSpit. 
  Licensed under <a href="https://www.gnu.org/licenses/gpl-3.0.html" target="_blank" rel="noopener">GPL v3</a>. 
  Source on <a href="https://github.com/RedNeckSnailSpit/kawakawa_web" target="_blank" rel="noopener">GitHub</a>.
</footer>

<script>
  const startYear = 2025;
  const currentYear = new Date().getFullYear();
  if (currentYear > startYear) {
    document.getElementById("year").textContent = " - " + currentYear;
  }
</script>

</body>
</html>
