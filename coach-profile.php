<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coach Profile - CoachPro</title>
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
        </div>
    </nav>
    
    <div class="max-w-5xl mx-auto px-4 py-8">
        <!-- Coach Header -->
        <div class="bg-white p-8 rounded-lg shadow mb-6">
            <div class="flex flex-col md:flex-row gap-6">
                <img id="coachPhoto" src="/placeholder.svg?height=200&width=200" alt="Coach" class="w-48 h-48 rounded-lg object-cover">
                <div class="flex-1">
                    <h1 id="coachName" class="text-3xl font-bold mb-2">Coach Name</h1>
                    <div id="coachSports" class="flex flex-wrap gap-2 mb-4"></div>
                    <p id="coachLevel" class="text-gray-600 mb-2"></p>
                    <p id="coachBio" class="text-gray-700"></p>
                </div>
            </div>
        </div>
        
        <!-- Certifications -->
        <div class="bg-white p-8 rounded-lg shadow mb-6">
            <h2 class="text-2xl font-bold mb-4">Certifications</h2>
            <div id="certificationsList" class="space-y-3"></div>
        </div>
        
        <!-- Availability & Booking -->
        <div class="bg-white p-8 rounded-lg shadow mb-6">
            <h2 class="text-2xl font-bold mb-4">Book a Session</h2>
            
            <div class="mb-6">
                <label class="block font-medium mb-2">Select Day of Week</label>
                <div id="dayButtons" class="flex flex-wrap gap-2"></div>
            </div>
            
            <div id="timeSlotsContainer" class="hidden mb-6">
                <label class="block font-medium mb-2">Available Time Slots</label>
                <div id="timeSlots" class="grid grid-cols-3 md:grid-cols-4 gap-2"></div>
            </div>
            
            <!-- green button -->
            <button onclick="openBookingModal()" class="bg-green-600 text-white px-6 py-3 rounded-lg hover:bg-green-700">Book Session</button>
        </div>
        
        <!-- Reviews -->
        <div class="bg-white p-8 rounded-lg shadow">
            <h2 class="text-2xl font-bold mb-4">Reviews</h2>
            <div id="reviewsList" class="space-y-4"></div>
            
            <button onclick="openReviewSubmitModal()" class="mt-4 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Leave a Review</button>
        </div>
    </div>
    
    <!-- Booking Modal -->
    <div id="bookingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg p-8 max-w-md w-full">
            <h3 class="text-2xl font-bold mb-4">Confirm Booking</h3>
            <form method="POST" action="/reserve.php">
                <input type="hidden" name="coach_id" id="modalCoachId">
                
                <div class="mb-4">
                    <label class="block font-medium mb-2">Date & Time</label>
                    <input type="datetime-local" name="start_date" required class="w-full px-3 py-2 border rounded-lg">
                </div>
                
                <div class="mb-4">
                    <label class="block font-medium mb-2">Duration (minutes)</label>
                    <select name="duree" class="w-full px-3 py-2 border rounded-lg">
                        <option value="30">30 minutes</option>
                        <option value="60" selected>60 minutes</option>
                        <option value="90">90 minutes</option>
                        <option value="120">120 minutes</option>
                    </select>
                </div>
                
                <div class="flex gap-4">
                    <!-- green button -->
                    <button type="submit" class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">Confirm</button>
                    <button type="button" onclick="closeBookingModal()" class="flex-1 bg-gray-300 py-2 rounded-lg hover:bg-gray-400">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <!-- Review submission modal -->
    <div id="reviewSubmitModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg p-8 max-w-md w-full">
            <h3 class="text-2xl font-bold mb-4">Leave a Review</h3>
            <form method="POST" action="/avis/create.php">
                <input type="hidden" name="coach_id" id="reviewCoachId">
                <input type="hidden" name="reservation_id" value="">
                
                <div class="mb-4">
                    <label class="block font-medium mb-2">Your Review (max 90 characters)</label>
                    <textarea name="avis" maxlength="90" rows="3" required class="w-full px-3 py-2 border rounded-lg"></textarea>
                    <div class="text-sm text-gray-500 mt-1">Character count: <span id="reviewCharCount">0</span>/90</div>
                </div>
                
                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">Submit Review</button>
                    <button type="button" onclick="closeReviewSubmitModal()" class="flex-1 bg-gray-300 py-2 rounded-lg hover:bg-gray-400">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="app.js"></script>
    <script>
        // Mock coach data
        const coach = {
            id: 1,
            name: 'John Smith',
            sports: ['Football', 'Basketball'],
            niveau: 'Pro',
            exp_years: 10,
            pic_url: '/placeholder.svg?height=200&width=200',
            bio: 'Professional coach with 10 years of experience. Worked with national teams and helped athletes achieve their goals.',
            certifications: [
                { title: 'UEFA Pro License', provider: 'UEFA' },
                { title: 'Sports Science Diploma', provider: 'University of Sports' }
            ],
            availability: [
                { day: 'Mon', start: '09:00', end: '17:00' },
                { day: 'Wed', start: '10:00', end: '18:00' },
                { day: 'Fri', start: '09:00', end: '15:00' }
            ],
            reviews: [
                { client: 'Alice Brown', date: '2024-01-15', text: 'Excellent coach! Very professional and knowledgeable.' },
                { client: 'Bob Wilson', date: '2024-01-10', text: 'Great experience, highly recommend!' }
            ]
        };
        
        // Render coach info
        document.getElementById('coachPhoto').src = coach.pic_url;
        document.getElementById('coachName').textContent = coach.name;
        document.getElementById('coachLevel').textContent = `${coach.niveau} • ${coach.exp_years} years experience`;
        document.getElementById('coachBio').textContent = coach.bio;
        
        const sportsContainer = document.getElementById('coachSports');
        coach.sports.forEach(sport => {
            const badge = document.createElement('span');
            badge.className = 'bg-green-100 text-green-800 px-3 py-1 rounded-full';
            badge.textContent = sport;
            sportsContainer.appendChild(badge);
        });
        
        // Render certifications - green border
        const certsList = document.getElementById('certificationsList');
        coach.certifications.forEach(cert => {
            const div = document.createElement('div');
            div.className = 'border-l-4 border-green-600 pl-4';
            div.innerHTML = `<div class="font-medium">${cert.title}</div><div class="text-sm text-gray-600">${cert.provider}</div>`;
            certsList.appendChild(div);
        });
        
        // Render availability day buttons
        const days = ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'];
        const dayButtons = document.getElementById('dayButtons');
        days.forEach(day => {
            const btn = document.createElement('button');
            btn.className = 'px-4 py-2 border rounded-lg hover:bg-green-100';
            btn.textContent = day;
            btn.onclick = () => selectDay(day);
            dayButtons.appendChild(btn);
        });
        
        function selectDay(day) {
            const availability = coach.availability.find(a => a.day === day);
            const timeSlotsContainer = document.getElementById('timeSlotsContainer');
            const timeSlots = document.getElementById('timeSlots');
            
            if (availability) {
                timeSlotsContainer.classList.remove('hidden');
                timeSlots.innerHTML = '';
                
                const start = parseInt(availability.start.split(':')[0]);
                const end = parseInt(availability.end.split(':')[0]);
                
                for (let hour = start; hour < end; hour++) {
                    const btn = document.createElement('button');
                    btn.className = 'px-3 py-2 border rounded-lg hover:bg-green-100';
                    btn.textContent = `${hour.toString().padStart(2, '0')}:00`;
                    timeSlots.appendChild(btn);
                }
            } else {
                timeSlotsContainer.classList.add('hidden');
                showToast('No availability on this day', 'error');
            }
        }
        
        // Render reviews
        const reviewsList = document.getElementById('reviewsList');
        coach.reviews.forEach(review => {
            const div = document.createElement('div');
            div.className = 'border-b pb-4';
            div.innerHTML = `
                <div class="font-medium">${review.client}</div>
                <div class="text-sm text-gray-600 mb-2">${review.date}</div>
                <div class="text-gray-700">${review.text}</div>
            `;
            reviewsList.appendChild(div);
        });
        
        function openBookingModal() {
            document.getElementById('modalCoachId').value = coach.id;
            document.getElementById('bookingModal').classList.remove('hidden');
        }
        
        function closeBookingModal() {
            document.getElementById('bookingModal').classList.add('hidden');
        }
        
        function openReviewSubmitModal() {
            document.getElementById('reviewCoachId').value = coach.id;
            document.getElementById('reviewSubmitModal').classList.remove('hidden');
        }
        
        function closeReviewSubmitModal() {
            document.getElementById('reviewSubmitModal').classList.add('hidden');
        }
        
        const reviewTextarea = document.querySelector('#reviewSubmitModal textarea[name="avis"]');
        if (reviewTextarea) {
            reviewTextarea.addEventListener('input', function() {
                document.getElementById('reviewCharCount').textContent = this.value.length;
            });
        }
    </script>
</body>
</html>
