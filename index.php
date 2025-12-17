<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CoachPro - Find Your Perfect Coach</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <!-- Logo now links to index.php -->
            <a href="index.php" class="text-2xl font-bold text-green-600">CoachPro</a>
            <div class="hidden md:flex gap-6">
                <a href="index.php" class="hover:text-green-600">Home</a>
                <a href="coaches.php" class="hover:text-green-600">Find Coaches</a>
                <!-- Link to login.php instead of auth.php -->
                <a href="login.php" class="hover:text-green-600">Login</a>
            </div>
            <button id="mobileMenuBtn" class="md:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
        <div id="mobileMenu" class="hidden md:hidden px-4 pb-4">
            <a href="index.php" class="block py-2 hover:text-green-600">Home</a>
            <a href="coaches.php" class="block py-2 hover:text-green-600">Find Coaches</a>
            <a href="login.php" class="block py-2 hover:text-green-600">Login</a>
        </div>
    </nav>
    
    <!-- Hero Section - green theme -->
    <section class="bg-green-600 text-white py-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-6">Find Your Perfect Coach</h1>
            <p class="text-xl mb-8">Connect with professional coaches for personalized training</p>
            <div class="flex gap-4 justify-center">
                <a href="coaches.php" class="bg-white text-green-600 px-6 py-3 rounded-lg font-medium hover:bg-gray-100">Browse Coaches</a>
                <a href="signup.php" class="bg-green-700 px-6 py-3 rounded-lg font-medium hover:bg-green-800">Sign Up</a>
            </div>
        </div>
    </section>
    
    <!-- Search Section -->
    <section class="max-w-7xl mx-auto px-4 py-12">
        <div class="bg-white p-6 rounded-lg shadow">
            <input type="text" id="searchInput" placeholder="Search by sport or coach name..." class="w-full px-4 py-3 border rounded-lg">
        </div>
    </section>
    
    <!-- Featured Coaches -->
    <section class="max-w-7xl mx-auto px-4 py-12">
        <h2 class="text-3xl font-bold mb-8">Featured Coaches</h2>
        <div id="featuredCoaches" class="grid md:grid-cols-3 gap-6">
            <!-- Mock data will be rendered here -->
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="bg-gray-800 text-white py-8 mt-20">
        <div class="max-w-7xl mx-auto px-4 text-center">
            <p>&copy; 2025 CoachPro. All rights reserved.</p>
        </div>
    </footer>
    
    <script src="app.js"></script>
    <script>
        // Mobile menu toggle
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            document.getElementById('mobileMenu').classList.toggle('hidden');
        });
        
        // Mock featured coaches data
        const mockCoaches = [
            { id: 1, name: 'John Smith', sports: ['Football', 'Basketball'], niveau: 'Pro', exp_years: 10, pic_url: '/placeholder.svg?height=200&width=200' },
            { id: 2, name: 'Sarah Johnson', sports: ['Tennis'], niveau: 'Advanced', exp_years: 7, pic_url: '/placeholder.svg?height=200&width=200' },
            { id: 3, name: 'Mike Davis', sports: ['Swimming'], niveau: 'Pro', exp_years: 12, pic_url: '/placeholder.svg?height=200&width=200' }
        ];
        
        // Render featured coaches - green theme
        const container = document.getElementById('featuredCoaches');
        mockCoaches.forEach(coach => {
            const card = document.createElement('div');
            card.className = 'bg-white p-6 rounded-lg shadow hover:shadow-lg transition';
            card.innerHTML = `
                <img src="${coach.pic_url}" alt="${coach.name}" class="w-full h-48 object-cover rounded-lg mb-4">
                <h3 class="text-xl font-bold mb-2">${coach.name}</h3>
                <div class="flex gap-2 mb-2">
                    ${coach.sports.map(s => `<span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">${s}</span>`).join('')}
                </div>
                <p class="text-gray-600 mb-2">${coach.niveau} • ${coach.exp_years} years exp</p>
                <a href="coach-profile.php?id=${coach.id}" class="block text-center bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">View Profile</a>
            `;
            container.appendChild(card);
        });
    </script>
</body>
</html>
