<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Häfele App Portal</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    body {
      overflow-y: scroll; /* ซ่อน scrollbar แต่ยังเลื่อนลงได้ */
    }

    /* ซ่อน scrollbar สำหรับ Webkit-based browsers (เช่น Chrome, Safari) */
    ::-webkit-scrollbar {
      display: none;
    }
    #apps {
      position: relative;
      z-index: 10;
    }

    #rainCanvas {
      z-index: 1 !important;
    }
  </style>
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const exploreButton = document.querySelector('a[href="#apps"]');
      exploreButton.addEventListener('click', function(event) {
        event.preventDefault();
        document.querySelector('#apps').scrollIntoView({
          behavior: 'smooth' // เลื่อนลงอย่างนุ่มนวล
        });
      });
    });
  </script>
</head>
<body class="bg-gray-100 font-sans">

  <section class="relative h-screen text-white flex flex-col items-center justify-center text-center" style="background-image: url('/img/s30.webp'); background-size: cover; background-position: center;">
    <div class="absolute inset-0 bg-gradient-to-r from-[#0a2342] via-[#000000] to-[#000000] opacity-70 z-0"></div>
    <!-- Logo at top-left -->
    <div class="absolute top-3 left-3 z-50">
      <img src="/img/logo-ct.png" alt="Häfele Logo" class="h-6 sm:h-8">
    </div>

    <!-- Content -->
    <h1 class="text-3xl sm:text-5xl font-bold mb-4 z-10">
      Welcome to <span class="text-[#E30613] uppercase animate-pulse">HÄFELE</span> Apps Hub
    </h1>
    <p class="text-base sm:text-xl text-gray-300 mb-6 z-10">
      Your central portal for all applications
    </p>
    <a href="#apps"
       class="text-sm sm:text-lg bg-[#E30613] text-white py-2 px-6 sm:py-3 sm:px-8 rounded-full font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-transform duration-300 ease-in-out z-10">
      Explore Apps
    </a>

  </section>

  <!-- App Cards Section -->
  <section id="apps" class="p-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-7xl mx-auto">

    <!-- App Card 1 -->
    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl p-6 transition-all group ">
      <h3 class="text-2xl font-bold text-gray-800 mb-2 tracking-tight group-hover:text-[#E30613] transition-colors duration-300">
        CRM System
      </h3>
      <p class="text-sm text-gray-500 mb-4">Customer Relationship Management</p>
      <a href="https://rsa-crm.hafele.com/index.php?module=Home&action=index" target="_blank"
         class="inline-flex items-center gap-2 text-[#E30613] font-medium hover:text-red-700 transition duration-200 group">
        <span>Launch</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7m0 0v7m0-7L10 14" />
        </svg>
      </a>

    </div>

    <!-- App Card 2 -->
    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl p-6 transition-all group">
      <h3 class="text-2xl font-bold text-gray-800 mb-2 tracking-tight group-hover:text-[#E30613] transition-colors duration-300">
        HRMS System
      </h3>
      <p class="text-sm text-gray-500 mb-4">Manage employee information and leave requests</p>
      <a href="https://hafele.peopleplushcm.com/login/home" target="_blank"
         class="inline-flex items-center gap-2 text-[#E30613] font-medium hover:text-red-700 transition duration-200 group">
        <span>Launch</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7m0 0v7m0-7L10 14" />
        </svg>
      </a>
    </div>

    <!-- App Card 3 -->
    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl p-6 transition-all group">
      <h3 class="text-2xl font-bold text-gray-800 mb-2 tracking-tight group-hover:text-[#E30613] transition-colors duration-300">
        In-house System
      </h3>
      <p class="text-sm text-gray-500 mb-4">Internal tools and automations developed by IT</p>
      <a href="/login" target="_blank"
         class="inline-flex items-center gap-2 text-[#E30613] font-medium hover:text-red-700 transition duration-200 group">
        <span>Launch</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7m0 0v7m0-7L10 14" />
        </svg>
      </a>
    </div>

    <!-- App Card 4 (Qlik Sense System) -->
    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl p-6 transition-all group">
      <h3 class="text-2xl font-bold text-gray-800 mb-2 tracking-tight group-hover:text-[#E30613] transition-colors duration-300">
        Qlik Sense System
      </h3>
      <p class="text-sm text-gray-500 mb-4">Data analytics and business intelligence platform</p>
      <a href="https://qlik.hww.hafele.corp/" target="_blank"
         class="inline-flex items-center gap-2 text-[#E30613] font-medium hover:text-red-700 transition duration-200 group">
        <span>Launch</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7m0 0v7m0-7L10 14" />
        </svg>
      </a>
    </div>

    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl p-6 transition-all group">
      <h3 class="text-2xl font-bold text-gray-800 mb-2 tracking-tight group-hover:text-[#E30613] transition-colors duration-300">
        Sharepoint System
      </h3>
      <p class="text-sm text-gray-500 mb-4">Collaborate and manage documents and workflows</p>
      <a href="https://haefele-my.sharepoint.com/" target="_blank"
         class="inline-flex items-center gap-2 text-[#E30613] font-medium hover:text-red-700 transition duration-200 group">
        <span>Launch</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7m0 0v7m0-7L10 14" />
        </svg>
      </a>
    </div>

    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl p-6 transition-all group">
      <h3 class="text-2xl font-bold text-gray-800 mb-2 tracking-tight group-hover:text-[#E30613] transition-colors duration-300">
        Elearning Sosafe
      </h3>
      <p class="text-sm text-gray-500 mb-4">Online training platform for safety and security</p>
      <a href="https://elearning.sosafe.de/" target="_blank"
         class="inline-flex items-center gap-2 text-[#E30613] font-medium hover:text-red-700 transition duration-200 group">
        <span>Launch</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7m0 0v7m0-7L10 14" />
        </svg>
      </a>
    </div>

    <!-- App Card: Remote System -->
    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl p-6 transition-all group">
      <h3 class="text-2xl font-bold text-gray-800 mb-2 tracking-tight group-hover:text-[#E30613] transition-colors duration-300">
        Remote System
      </h3>
      <p class="text-sm text-gray-500 mb-4">Access internal systems remotely and securely</p>
      <a href="https://get.teamviewer.com/66bimqe" target="_blank"
         class="inline-flex items-center gap-2 text-[#E30613] font-medium hover:text-red-700 transition duration-200 group">
        <span>Launch</span>
        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 group-hover:translate-x-1 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 3h7m0 0v7m0-7L10 14" />
        </svg>
      </a>
    </div>

    <!-- เพิ่มการ์ดเพิ่มเติมได้ที่นี่ -->
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-gray-400 text-center p-4 text-sm mt-8">
    © 2025 Häfele Thailand IT Department. All rights reserved.
  </footer>

  <canvas id="rainCanvas" class="fixed top-0 left-0 w-full h-full pointer-events-none z-0"></canvas>
  <canvas id="leavesCanvas" class="fixed top-0 left-0 w-full h-full pointer-events-none z-0"></canvas>
  <canvas id="snowCanvas" class="fixed top-0 left-0 w-full h-full pointer-events-none z-0"></canvas>
  <canvas id="summerCanvas" class="fixed top-0 left-0 w-full h-full pointer-events-none z-0"></canvas>

  <script>
    const month = new Date().getMonth(); // 0 = January, 11 = December

    if ([4,5,6,7,8].includes(month)) {
      startRain(); // มิถุนายน - กันยายน: ฝนตก
    } else if ([9,10].includes(month)) {
      startLeaves(); // ตุลาคม - พฤศจิกายน: ใบไม้ร่วง
    } else if ([11,0,1,2].includes(month)) {
      startSnow(); // ธันวาคม - กุมภาพันธ์: หิมะตก
    } else {
      console.log("☀️ Summer - No animation");
    }

    function startRain() {
      const canvas = document.getElementById('rainCanvas');
      const ctx = canvas.getContext('2d');
      let drops = [];

      function resizeCanvas() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
      }
      window.addEventListener('resize', resizeCanvas);
      resizeCanvas();

      function createRaindrops(count) {
        for (let i = 0; i < count; i++) {
          drops.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            length: Math.random() * 20 + 10,
            speed: Math.random() * 4 + 2,
            opacity: Math.random() * 0.5 + 0.3
          });
        }
      }

      function drawRaindrops() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.strokeStyle = 'rgba(173,216,230,0.5)';
        ctx.lineWidth = 1;

        for (let drop of drops) {
          ctx.beginPath();
          ctx.moveTo(drop.x, drop.y);
          ctx.lineTo(drop.x, drop.y + drop.length);
          ctx.stroke();

          drop.y += drop.speed;
          if (drop.y > canvas.height) {
            drop.y = -drop.length;
            drop.x = Math.random() * canvas.width;
          }
        }

        requestAnimationFrame(drawRaindrops);
      }

      createRaindrops(150);
      drawRaindrops();
    }

    function startSnow() {
      const canvas = document.getElementById('snowCanvas');
      if (!canvas) return;

      const ctx = canvas.getContext('2d');
      let snowflakes = [];

      function resizeCanvas() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
      }
      window.addEventListener('resize', resizeCanvas);
      resizeCanvas();

      function createSnowflakes(count) {
        for (let i = 0; i < count; i++) {
          snowflakes.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            radius: Math.random() * 3 + 2,
            speedY: Math.random() * 1 + 0.5,
            speedX: Math.random() * 0.5 - 0.25,
            opacity: Math.random() * 0.5 + 0.5,
          });
        }
      }

      function drawSnowflakes() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);
        ctx.fillStyle = 'white';

        for (let flake of snowflakes) {
          ctx.beginPath();
          ctx.arc(flake.x, flake.y, flake.radius, 0, Math.PI * 2);
          ctx.fillStyle = `rgba(255, 255, 255, ${flake.opacity})`;
          ctx.fill();

          flake.y += flake.speedY;
          flake.x += flake.speedX;

          if (flake.y > canvas.height) {
            flake.y = -flake.radius;
            flake.x = Math.random() * canvas.width;
          }
        }

        requestAnimationFrame(drawSnowflakes);
      }

      createSnowflakes(100);
      drawSnowflakes();
    }

    function startLeaves() {
      const canvas = document.getElementById('leavesCanvas');
      if (!canvas) return;

      const ctx = canvas.getContext('2d');
      let sakuraLeaves = [];

      function resizeCanvas() {
        canvas.width = window.innerWidth;
        canvas.height = window.innerHeight;
      }
      window.addEventListener('resize', resizeCanvas);
      resizeCanvas();

      // สร้างใบไม้ซากุระ
      function createSakuraLeaves(count) {
        for (let i = 0; i < count; i++) {
          const leafSize = Math.random() * 15 + 10;
          sakuraLeaves.push({
            x: Math.random() * canvas.width,
            y: Math.random() * canvas.height,
            size: leafSize,
            speedY: Math.random() * 1.5 + 0.5,
            speedX: Math.random() * 0.5 - 0.25,
            rotation: Math.random() * Math.PI * 2,
            rotationSpeed: Math.random() * 0.02 - 0.01,
            opacity: Math.random() * 0.5 + 0.3,
          });
        }
      }

      // วาดใบไม้ซากุระ
      function drawSakuraLeaves() {
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        for (let leaf of sakuraLeaves) {
          // วาดใบไม้ซากุระ (เปลี่ยนเป็น SVG หรือ Font Awesome)
          ctx.save();
          ctx.translate(leaf.x, leaf.y);
          ctx.rotate(leaf.rotation);
          ctx.globalAlpha = leaf.opacity;

          // วาดใบไม้ซากุระ (ใช้ arc หรือ SVG)
          ctx.beginPath();
          ctx.moveTo(0, 0);

          // เปลี่ยนเป็นรูปใบไม้ซากุระโดยใช้ arc หรือ SVG รูปซากุระ
          ctx.arc(0, 0, leaf.size, 0, Math.PI * 2);  // หรือใช้ image หรือ SVG
          ctx.fillStyle = 'rgba(255, 182, 193, 0.8)';  // สีชมพูซากุระ
          ctx.fill();

          ctx.restore();

          // ปรับตำแหน่งของใบไม้
          leaf.y += leaf.speedY;
          leaf.x += leaf.speedX;
          leaf.rotation += leaf.rotationSpeed;

          // รีเซ็ตตำแหน่งเมื่อใบไม้ตกถึงล่างสุด
          if (leaf.y > canvas.height) {
            leaf.y = -leaf.size;
            leaf.x = Math.random() * canvas.width;
          }
        }

        requestAnimationFrame(drawSakuraLeaves);
      }

      createSakuraLeaves(100); // จำนวนใบไม้ซากุระที่ตก
      drawSakuraLeaves();
      }

  </script>

</body>
</html>
