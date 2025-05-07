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


  <section class="relative h-screen text-white flex flex-col items-center justify-center text-center" style="background: radial-gradient(circle at right, #0a2342, #000000);">

    <!-- Logo at top-left -->
    <div class="absolute top-4 left-4 z-20">
      <img src="/img/logo-ct.png" alt="Häfele Logo"
           class="h-8">
    </div>

    <!-- Content -->
    <h1 class="text-5xl font-bold mb-4 z-10">
      Welcome to <span class="text-[#E30613] uppercase">HÄFELE</span> Apps Hub
    </h1>
    <p class="text-xl text-gray-300 mb-6 z-10">Your central portal for all applications</p>
    <a href="#apps"
       class="bg-[#E30613] text-white py-3 px-8 rounded-full text-lg font-semibold shadow-md hover:shadow-lg hover:scale-105 transition-transform duration-300 ease-in-out z-10">
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

    <!-- เพิ่มการ์ดเพิ่มเติมได้ที่นี่ -->
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-gray-400 text-center p-4 text-sm mt-8">
    © 2025 Häfele Thailand IT Department. All rights reserved.
  </footer>

</body>
</html>
