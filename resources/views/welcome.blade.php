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

  <!-- Hero Section (Full Screen) with IT Background -->
  <section class="h-screen bg-cover bg-center text-white flex flex-col items-center justify-center text-center" style="background-image: url('https://t4.ftcdn.net/jpg/04/78/95/73/360_F_478957385_zCuEGTXNJKPygVCxmxkY01oV7JFVUFDv.jpg');">
    <div class="bg-black bg-opacity-50 w-full h-full absolute top-0 left-0 z-0"></div> <!-- Overlay to make text stand out -->
    <h1 class="text-5xl font-bold mb-4 z-10">Welcome to Häfele Application Portal</h1>
    <p class="text-xl text-gray-300 mb-6 z-10">All your internal tools, in one place.</p>
    <a href="#apps" class="bg-blue-600 text-white py-2 px-6 rounded-full text-lg hover:bg-blue-700 transition z-10">Explore Apps</a>
  </section>

  <!-- App Cards Section -->
  <section id="apps" class="p-8 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 max-w-7xl mx-auto">

    <!-- App Card 1 -->
    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl p-6 transition-all">
      <h3 class="text-xl font-semibold text-gray-800 mb-2">CRM System</h3>
      <p class="text-sm text-gray-500 mb-4">Customer Relationship Management</p>
      <a href="https://rsa-crm.hafele.com/index.php?module=Home&action=index" class="text-blue-600 hover:underline font-medium">Launch</a>
    </div>

    <!-- App Card 2 -->
    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl p-6 transition-all">
      <h3 class="text-xl font-semibold text-gray-800 mb-2">HR System</h3>
      <p class="text-sm text-gray-500 mb-4">Manage employee information and leave requests</p>
      <a href="https://hafele.peopleplushcm.com/login/home" class="text-blue-600 hover:underline font-medium">Launch</a>
    </div>

    <!-- App Card 3 -->
    <div class="bg-white rounded-2xl shadow-md hover:shadow-xl p-6 transition-all">
      <h3 class="text-xl font-semibold text-gray-800 mb-2">In-house System</h3>
      <p class="text-sm text-gray-500 mb-4">Internal tools and automations developed by IT</p>
      <a href="/login" class="text-blue-600 hover:underline font-medium">Launch</a>
    </div>

    <!-- เพิ่มการ์ดเพิ่มเติมได้ที่นี่ -->
  </section>

  <!-- Footer -->
  <footer class="bg-gray-900 text-gray-400 text-center p-4 text-sm mt-8">
    © 2025 Häfele Thailand IT Department. All rights reserved.
  </footer>

</body>
</html>
