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
    <title>Client Dashboard - CoachPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white shadow">
        <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
            <!-- Logo links to index.php, green theme -->
            <a href="index.php" class="text-2xl font-bold text-green-600">CoachPro</a>
            <div class="flex gap-6">
                <a href="index.php" class="hover:text-green-600">Home</a>
                <a href="coaches.php" class="hover:text-green-600">Find Coaches</a>
                <a href="client-dashboard.php" class="font-medium text-green-600">Dashboard</a>
            </div>
        </div>
    </nav>
    
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Client Dashboard</h1>
        
        <div class="grid md:grid-cols-2 gap-6">
            
            <!-- Profile Section -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-2xl font-bold mb-4">My Profile</h2>
                <form method="POST" action="/client/update-profile.php">
                    <div class="space-y-4">
                        <div>
                            <label class="block font-medium mb-1">Name</label>
                            <input type="text" name="nom" value="John Doe" class="w-full px-3 py-2 border rounded-lg">
                        </div>
                        
                        <div>
                            <label class="block font-medium mb-1">Email</label>
                            <input type="email" name="email" value="john@example.com" disabled class="w-full px-3 py-2 border rounded-lg bg-gray-100">
                        </div>
                        
                        <div>
                            <label class="block font-medium mb-1">Phone</label>
                            <input type="tel" name="phone" value="1234567890" class="w-full px-3 py-2 border rounded-lg">
                        </div>
                        
                        <!-- green button -->
                        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Update Profile</button>
                    </div>
                </form>
            </div>
            
            <!-- Quick Stats - green accent for upcoming -->
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-2xl font-bold mb-4">Quick Stats</h2>
                <div class="space-y-4">
                    <div class="flex justify-between items-center p-4 bg-green-50 rounded-lg">
                        <span class="font-medium">Upcoming Sessions</span>
                        <span class="text-2xl font-bold text-green-600">3</span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-gray-50 rounded-lg">
                        <span class="font-medium">Completed Sessions</span>
                        <span class="text-2xl font-bold text-gray-600">12</span>
                    </div>
                    <div class="flex justify-between items-center p-4 bg-yellow-50 rounded-lg">
                        <span class="font-medium">Pending Reviews</span>
                        <span class="text-2xl font-bold text-yellow-600">2</span>
                    </div>
                </div>
            </div>
            
        </div>
        
        <!-- Reservations Section -->
        <div class="bg-white p-6 rounded-lg shadow mt-6">
            <h2 class="text-2xl font-bold mb-4">My Reservations</h2>
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-4 py-3 text-left">Coach</th>
                            <th class="px-4 py-3 text-left">Date & Time</th>
                            <th class="px-4 py-3 text-left">Duration</th>
                            <th class="px-4 py-3 text-left">Status</th>
                            <th class="px-4 py-3 text-left">Actions</th>
                        </tr>
                    </thead>
                    <tbody id="reservationsTable"></tbody>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Modify Reservation Modal -->
    <div id="modifyModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg p-8 max-w-md w-full">
            <h3 class="text-2xl font-bold mb-4">Modify Reservation</h3>
            <form method="POST" action="/reservation/update.php">
                <input type="hidden" name="reservation_id" id="modifyReservationId">
                
                <div class="mb-4">
                    <label class="block font-medium mb-2">New Date & Time</label>
                    <input type="datetime-local" name="start_date" required class="w-full px-3 py-2 border rounded-lg">
                </div>
                
                <div class="mb-4">
                    <label class="block font-medium mb-2">Duration (minutes)</label>
                    <select name="duree" class="w-full px-3 py-2 border rounded-lg">
                        <option value="30">30 minutes</option>
                        <option value="60">60 minutes</option>
                        <option value="90">90 minutes</option>
                        <option value="120">120 minutes</option>
                    </select>
                </div>
                
                <div class="flex gap-4">
                    <!-- green button -->
                    <button type="submit" class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">Update</button>
                    <button type="button" onclick="closeModifyModal()" class="flex-1 bg-gray-300 py-2 rounded-lg hover:bg-gray-400">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Review Modal -->
    <div id="reviewModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg p-8 max-w-md w-full">
            <h3 class="text-2xl font-bold mb-4">Leave a Review</h3>
            <form method="POST" action="/avis/create.php">
                <input type="hidden" name="reservation_id" id="reviewReservationId">
                
                <div class="mb-4">
                    <label class="block font-medium mb-2">Your Review (max 90 characters)</label>
                    <textarea name="avis" maxlength="90" rows="3" required class="w-full px-3 py-2 border rounded-lg"></textarea>
                    <div class="text-sm text-gray-500 mt-1">Character count: <span id="charCount">0</span>/90</div>
                </div>
                
                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">Submit Review</button>
                    <button type="button" onclick="closeReviewModal()" class="flex-1 bg-gray-300 py-2 rounded-lg hover:bg-gray-400">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="app.js"></script>
    <script>
        // Mock reservations data
        const reservations = [
            { id: 1, coach: 'John Smith', coach_photo: '/placeholder.svg?height=40&width=40', start_date: '2024-02-15 10:00', duree: 60, status: 'confirmed' },
            { id: 2, coach: 'Sarah Johnson', coach_photo: '/placeholder.svg?height=40&width=40', start_date: '2024-02-20 14:00', duree: 90, status: 'in progress' },
            { id: 3, coach: 'Mike Davis', coach_photo: '/placeholder.svg?height=40&width=40', start_date: '2024-01-10 09:00', duree: 60, status: 'confirmed' }
        ];
        
        const statusColors = {
            'in progress': 'bg-yellow-100 text-yellow-800',
            'confirmed': 'bg-green-100 text-green-800',
            'canceled': 'bg-red-100 text-red-800'
        };
        
        // Render reservations
        const tbody = document.getElementById('reservationsTable');
        reservations.forEach(res => {
            const tr = document.createElement('tr');
            tr.className = 'border-b hover:bg-gray-50';
            
            const isPast = new Date(res.start_date) < new Date();
            
            tr.innerHTML = `
                <td class="px-4 py-3">
                    <div class="flex items-center gap-2">
                        <img src="${res.coach_photo}" alt="${res.coach}" class="w-10 h-10 rounded-full">
                        <span>${res.coach}</span>
                    </div>
                </td>
                <td class="px-4 py-3">${res.start_date}</td>
                <td class="px-4 py-3">${res.duree} min</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded ${statusColors[res.status]}">${res.status}</span>
                </td>
                <td class="px-4 py-3">
                    <div class="flex gap-2">
                        ${res.status !== 'canceled' && !isPast ? `
                            <button onclick="modifyReservation(${res.id})" class="text-green-600 hover:underline">Modify</button>
                            <button onclick="cancelReservation(${res.id})" class="text-red-600 hover:underline">Cancel</button>
                        ` : ''}
                        ${res.status === 'confirmed' && isPast ? `
                            <button onclick="openReviewModal(${res.id})" class="text-green-600 hover:underline">Review</button>
                        ` : ''}
                    </div>
                </td>
            `;
            tbody.appendChild(tr);
        });
        
        function modifyReservation(id) {
            document.getElementById('modifyReservationId').value = id;
            document.getElementById('modifyModal').classList.remove('hidden');
        }
        
        function closeModifyModal() {
            document.getElementById('modifyModal').classList.add('hidden');
        }
        
        function cancelReservation(id) {
            if (confirm('Are you sure you want to cancel this reservation?')) {
                showToast('Reservation canceled', 'success');
            }
        }
        
        function openReviewModal(id) {
            document.getElementById('reviewReservationId').value = id;
            document.getElementById('reviewModal').classList.remove('hidden');
        }
        
        function closeReviewModal() {
            document.getElementById('reviewModal').classList.add('hidden');
        }
        
        const reviewTextarea = document.querySelector('#reviewModal textarea[name="avis"]');
        if (reviewTextarea) {
            reviewTextarea.addEventListener('input', function() {
                document.getElementById('charCount').textContent = this.value.length;
            });
        }
    </script>
</body>
</html>
