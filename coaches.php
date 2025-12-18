<?php
session_start();
if(!isset($_SESSION['user_id'])){
    header("location: login.php");
}
if($_SESSION['role']!='client'){
    header("location: coach-dashboard.php");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Find Coaches - CoachPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <!-- Logo links to index.php, green theme -->
            <a href="index.php" class="text-2xl font-bold text-green-600">CoachPro</a>
            <div class="hidden md:flex gap-6">
                <a href="index.php" class="hover:text-green-600">Home</a>
                <a href="coaches.php" class="hover:text-green-600">Find Coaches</a>
                <!-- Link to login.php -->
                <a href="login.php" class="hover:text-green-600">Login</a>
            </div>
            <button id="mobileMenuBtn" class="md:hidden">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                </svg>
            </button>
        </div>
    </nav>
    
    <div class="max-w-7xl mx-auto px-4 py-8">
        <div class="flex flex-col md:flex-row gap-6">
            
            <!-- Filters Sidebar -->
            <aside class="md:w-64">
                <div class="bg-white p-6 rounded-lg shadow">
                    <h3 class="font-bold mb-4">Filters</h3>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Sports</label>
                        <div class="space-y-2">
                            <label class="flex items-center"><input type="checkbox" value="Football" class="mr-2 sport-filter"> Football</label>
                            <label class="flex items-center"><input type="checkbox" value="Basketball" class="mr-2 sport-filter"> Basketball</label>
                            <label class="flex items-center"><input type="checkbox" value="Tennis" class="mr-2 sport-filter"> Tennis</label>
                            <label class="flex items-center"><input type="checkbox" value="Swimming" class="mr-2 sport-filter"> Swimming</label>
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Level</label>
                        <select id="niveauFilter" class="w-full px-3 py-2 border rounded-lg">
                            <option value="">All Levels</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Advanced">Advanced</option>
                            <option value="Pro">Pro</option>
                        </select>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Experience (years)</label>
                        <div class="flex gap-2 items-center">
                            <input type="number" id="minExpFilter" min="0" placeholder="Min" class="w-full px-3 py-2 border rounded-lg">
                            <span>-</span>
                            <input type="number" id="maxExpFilter" min="0" placeholder="Max" class="w-full px-3 py-2 border rounded-lg">
                        </div>
                    </div>
                    
                    <div class="mb-4">
                        <label class="block text-sm font-medium mb-2">Minimum Rating</label>
                        <select id="ratingFilter" class="w-full px-3 py-2 border rounded-lg">
                            <option value="">Any Rating</option>
                            <option value="4">4+ Stars</option>
                            <option value="4.5">4.5+ Stars</option>
                            <option value="5">5 Stars</option>
                        </select>
                    </div>
                    
                    <!-- green buttons -->
                    <button onclick="applyFilters()" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">Apply Filters</button>
                    <button onclick="resetFilters()" class="w-full mt-2 bg-gray-200 text-gray-700 py-2 rounded-lg hover:bg-gray-300">Reset</button>
                </div>
            </aside>
            
            <!-- Coaches List -->
            <main class="flex-1">
                <div id="coachesList" class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
                    <!-- Coaches will be rendered here -->
                </div>
            </main>
            
        </div>
    </div>
    
    <script src="app.js"></script>
    <script>
        // Mock coaches data with rating

        async  function fetchFromPHPCoachs(){
            const json = await fetch("api/coaches.php");
            return json.json();
        }

        // const allCoaches = [
        //     { id: 1, name: 'John Smith', sports: ['Football', 'Basketball'], niveau: 'Pro', exp_years: 10, rating: 4.8, pic_url: '/placeholder.svg?height=200&width=200', bio: 'Professional coach with international experience' },
        //     { id: 2, name: 'Sarah Johnson', sports: ['Tennis'], niveau: 'Advanced', exp_years: 7, rating: 4.9, pic_url: '/placeholder.svg?height=200&width=200', bio: 'Former professional tennis player' },
        //     { id: 3, name: 'Mike Davis', sports: ['Swimming'], niveau: 'Pro', exp_years: 12, rating: 5.0, pic_url: '/placeholder.svg?height=200&width=200', bio: 'Olympic swimming coach' },
        //     { id: 4, name: 'Emma Wilson', sports: ['Football'], niveau: 'Intermediate', exp_years: 5, rating: 4.5, pic_url: '/placeholder.svg?height=200&width=200', bio: 'Youth development specialist' },
        //     { id: 5, name: 'David Lee', sports: ['Basketball', 'Tennis'], niveau: 'Advanced', exp_years: 8, rating: 4.7, pic_url: '/placeholder.svg?height=200&width=200', bio: 'Multi-sport coach' }
        // ];
        let allCoaches = []
        fetchFromPHPCoachs().then(data=> allCoaches = data
        console.log(allCoaches))
        
        function renderCoaches(coaches) {
            const container = document.getElementById('coachesList');
            container.innerHTML = '';
            
            if (coaches.length === 0) {
                container.innerHTML = '<div class="col-span-full text-center text-gray-500 py-8">No coaches found matching your filters</div>';
                return;
            }
            
            coaches.forEach(coach => {
                const card = document.createElement('div');
                card.className = 'bg-white p-6 rounded-lg shadow hover:shadow-lg transition';
                card.innerHTML = `
                    <img src="${coach.pic_url}" alt="${coach.name}" class="w-full h-48 object-cover rounded-lg mb-4">
                    <h3 class="text-xl font-bold mb-2">${coach.name}</h3>
                    <div class="flex flex-wrap gap-2 mb-2">
                        ${coach.sports.map(s => `<span class="bg-green-100 text-green-800 px-2 py-1 rounded text-sm">${s}</span>`).join('')}
                    </div>
                    <p class="text-gray-600 mb-2">${coach.niveau} • ${coach.exp_years} years • ⭐ ${coach.rating}</p>
                    <p class="text-gray-500 text-sm mb-4">${coach.bio}</p>
                    <a href="coach-profile.php?id=${coach.id}" class="block text-center bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">View Profile</a>
                `;
                container.appendChild(card);
            });
        }
        
        function applyFilters() {
            const selectedSports = Array.from(document.querySelectorAll('.sport-filter:checked')).map(cb => cb.value);
            const niveau = document.getElementById('niveauFilter').value;
            const minExp = parseInt(document.getElementById('minExpFilter').value) || 0;
            const maxExp = parseInt(document.getElementById('maxExpFilter').value) || Infinity;
            const minRating = parseFloat(document.getElementById('ratingFilter').value) || 0;
            
            const filtered = allCoaches.filter(coach => {
                if (selectedSports.length > 0 && !coach.sports.some(s => selectedSports.includes(s))) return false;
                if (niveau && coach.niveau !== niveau) return false;
                if (coach.exp_years < minExp || coach.exp_years > maxExp) return false;
                if (coach.rating < minRating) return false;
                return true;
            });
            
            renderCoaches(filtered);
        }
        
        function resetFilters() {
            document.querySelectorAll('.sport-filter').forEach(cb => cb.checked = false);
            document.getElementById('niveauFilter').value = '';
            document.getElementById('minExpFilter').value = '';
            document.getElementById('maxExpFilter').value = '';
            document.getElementById('ratingFilter').value = '';
            renderCoaches(allCoaches);
        }
        
        // Initial render
        renderCoaches(allCoaches);
        
        // Mobile menu
        document.getElementById('mobileMenuBtn').addEventListener('click', function() {
            const nav = this.closest('nav');
            let menu = nav.querySelector('#mobileMenu');
            if (!menu) {
                menu = document.createElement('div');
                menu.id = 'mobileMenu';
                menu.className = 'md:hidden px-4 pb-4';
                menu.innerHTML = `
                    <a href="index.php" class="block py-2 hover:text-green-600">Home</a>
                    <a href="coaches.php" class="block py-2 hover:text-green-600">Find Coaches</a>
                    <a href="login.php" class="block py-2 hover:text-green-600">Login</a>
                `;
                nav.appendChild(menu);
            } else {
                menu.classList.toggle('hidden');
            }
        });
    </script>
</body>
</html>
