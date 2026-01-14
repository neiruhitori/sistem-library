<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Welcome</title>

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Animate.css -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>

  <!-- Particles.js -->
  <script src="https://cdn.jsdelivr.net/npm/tsparticles@2.11.1/tsparticles.bundle.min.js"></script>

  <style>
    #particles-bg {
      position: absolute;
      width: 100%;
      height: 100%;
      z-index: -1;
    }
  </style>
</head>
<body class="h-screen w-screen flex items-center justify-center bg-gray-900 relative overflow-hidden">

  <!-- Particles Background -->
  <div id="particles-bg"></div>

  <div class="text-center text-white animate__animated animate__fadeIn">
    <h1 class="text-5xl md:text-6xl font-bold mb-6">Welcome to Our Library System</h1>
    <h1 class="text-5xl md:text-6xl font-bold mb-6">SMPN 02 KLAKAH</h1>
    <p class="mb-8 text-lg md:text-xl text-gray-300">Your gateway to a smarter solution.</p>

    <div class="flex justify-center space-x-6">
      <?php if(auth()->guard()->guest()): ?>
        <a href="<?php echo e(route('login')); ?>" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 transition rounded-lg text-white font-semibold shadow-lg">Login</a>
        <a href="<?php echo e(route('register')); ?>" class="px-6 py-3 bg-green-600 hover:bg-green-700 transition rounded-lg text-white font-semibold shadow-lg">Register</a>
      <?php else: ?>
        <a href="<?php echo e(route('dashboard')); ?>" class="px-6 py-3 bg-indigo-600 hover:bg-indigo-700 transition rounded-lg text-white font-semibold shadow-lg">Dashboard</a>
      <?php endif; ?>
    </div>
  </div>

  <script>
    tsParticles.load("particles-bg", {
      fpsLimit: 60,
      background: { color: "#111827" },
      particles: {
        number: { value: 80, density: { enable: true, area: 800 }},
        color: { value: "#ffffff" },
        shape: { type: "circle" },
        opacity: { value: 0.3, random: true },
        size: { value: 3, random: true },
        move: { enable: true, speed: 1, direction: "none", outMode: "out" }
      },
      interactivity: {
        events: {
          onHover: { enable: true, mode: "repulse" },
          onClick: { enable: true, mode: "push" }
        },
        modes: {
          repulse: { distance: 100 },
          push: { quantity: 4 }
        }
      }
    });
  </script>
</body>
</html>
<?php /**PATH C:\laragon\www\sistem-library\resources\views/welcome.blade.php ENDPATH**/ ?>