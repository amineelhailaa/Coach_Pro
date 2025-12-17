<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coach Dashboard - CoachPro</title>
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
                <a href="coach-dashboard.php" class="font-medium text-green-600">Dashboard</a>
            </div>
        </div>
    </nav>
    
    <div class="max-w-7xl mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Coach Dashboard</h1>
        
        <!-- Tab Navigation - green active tab -->
        <div class="bg-white rounded-lg shadow mb-6">
            <div class="flex border-b overflow-x-auto">
                <button onclick="showTab('overview')" class="tab-btn px-6 py-3 font-medium border-b-2 border-green-600 text-green-600">Overview</button>
                <button onclick="showTab('reservations')" class="tab-btn px-6 py-3 font-medium hover:bg-gray-50">Reservations</button>
                <button onclick="showTab('availability')" class="tab-btn px-6 py-3 font-medium hover:bg-gray-50">Availability</button>
                <button onclick="showTab('profile')" class="tab-btn px-6 py-3 font-medium hover:bg-gray-50">Profile</button>
                <button onclick="showTab('reviews')" class="tab-btn px-6 py-3 font-medium hover:bg-gray-50">Reviews</button>
            </div>
        </div>
        
        <!-- Overview Tab -->
        <div id="overviewTab" class="tab-content">
            <div class="grid md:grid-cols-4 gap-6 mb-6">
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-gray-600 mb-2">Pending Requests</div>
                    <div class="text-3xl font-bold text-yellow-600">5</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-gray-600 mb-2">Confirmed Today</div>
                    <div class="text-3xl font-bold text-green-600">2</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-gray-600 mb-2">Confirmed Tomorrow</div>
                    <div class="text-3xl font-bold text-green-600">3</div>
                </div>
                <div class="bg-white p-6 rounded-lg shadow">
                    <div class="text-gray-600 mb-2">Total Sessions</div>
                    <div class="text-3xl font-bold">47</div>
                </div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold mb-4">Next Session</h2>
                <div class="flex items-center gap-4">
                    <img src="/placeholder.svg?height=60&width=60" alt="Client" class="w-16 h-16 rounded-full">
                    <div>
                        <div class="font-medium">Alice Brown</div>
                        <div class="text-gray-600">Tomorrow at 10:00 AM</div>
                        <div class="text-sm text-gray-500">Duration: 60 minutes</div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Reservations Tab -->
        <div id="reservationsTab" class="tab-content hidden">
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h2 class="text-xl font-bold mb-4">Pending Requests</h2>
                <div id="pendingReservations" class="space-y-4"></div>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold mb-4">Confirmed Sessions</h2>
                <div id="confirmedReservations" class="space-y-4"></div>
            </div>
        </div>
        
        <!-- Availability Tab -->
        <div id="availabilityTab" class="tab-content hidden">
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h2 class="text-xl font-bold mb-4">Add Availability</h2>
                <form id="addAvailabilityForm" method="POST" action="/coach/availability/create.php">
                    <div class="grid md:grid-cols-3 gap-4">
                        <div>
                            <label class="block font-medium mb-2">Day of Week</label>
                            <select name="week_day" required class="w-full px-3 py-2 border rounded-lg">
                                <option value="">Select day</option>
                                <option value="Mon">Monday</option>
                                <option value="Tue">Tuesday</option>
                                <option value="Wed">Wednesday</option>
                                <option value="Thu">Thursday</option>
                                <option value="Fri">Friday</option>
                                <option value="Sat">Saturday</option>
                                <option value="Sun">Sunday</option>
                            </select>
                        </div>
                        <div>
                            <label class="block font-medium mb-2">Start Time</label>
                            <input type="time" name="start_time" required class="w-full px-3 py-2 border rounded-lg">
                        </div>
                        <div>
                            <label class="block font-medium mb-2">End Time</label>
                            <input type="time" name="end_time" required class="w-full px-3 py-2 border rounded-lg">
                        </div>
                    </div>
                    <!-- green button -->
                    <button type="submit" class="mt-4 bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Add Availability</button>
                </form>
            </div>
            
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold mb-4">Current Availability</h2>
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-4 py-3 text-left">Day</th>
                                <th class="px-4 py-3 text-left">Start Time</th>
                                <th class="px-4 py-3 text-left">End Time</th>
                                <th class="px-4 py-3 text-left">Actions</th>
                            </tr>
                        </thead>
                        <tbody id="availabilityTable"></tbody>
                    </table>
                </div>
            </div>
        </div>
        
        <!-- Profile Tab -->
        <div id="profileTab" class="tab-content hidden">
            <div class="bg-white p-6 rounded-lg shadow mb-6">
                <h2 class="text-xl font-bold mb-4">Edit Profile</h2>
                <form method="POST" action="/coach/update-profile.php">
                    <div class="space-y-4">
                        <div>
                            <label class="block font-medium mb-2">Bio</label>
                            <textarea name="bio" rows="4" maxlength="500" class="w-full px-3 py-2 border rounded-lg">Professional coach with international experience</textarea>
                        </div>
                        
                        <div>
                            <label class="block font-medium mb-2">Level</label>
                            <select name="niveau" class="w-full px-3 py-2 border rounded-lg">
                                <option value="Beginner">Beginner</option>
                                <option value="Intermediate">Intermediate</option>
                                <option value="Advanced">Advanced</option>
                                <option value="Pro" selected>Pro</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block font-medium mb-2">Profile Picture URL</label>
                            <input type="text" name="pic_url" class="w-full px-3 py-2 border rounded-lg">
                        </div>
                        
                        <div>
                            <label class="block font-medium mb-2">Years of Experience</label>
                            <input type="number" name="exp_years" value="10" min="0" class="w-full px-3 py-2 border rounded-lg">
                        </div>
                        
                        <div>
                            <label class="block font-medium mb-2">Sports</label>
                            <div class="space-y-2">
                                <label class="flex items-center"><input type="checkbox" name="sports[]" value="1" checked class="mr-2"> Football</label>
                                <label class="flex items-center"><input type="checkbox" name="sports[]" value="2" checked class="mr-2"> Basketball</label>
                                <label class="flex items-center"><input type="checkbox" name="sports[]" value="3" class="mr-2"> Tennis</label>
                                <label class="flex items-center"><input type="checkbox" name="sports[]" value="4" class="mr-2"> Swimming</label>
                            </div>
                        </div>
                        
                        <!-- Certifications -->
                        <div>
                            <label class="block font-medium mb-2">Certifications</label>
                            <div id="certificationsContainer" class="space-y-2 mb-2">
                                <div class="flex gap-2 certification-row">
                                    <input type="text" name="certifications_title[]" placeholder="Intitulé" value="UEFA Pro License" class="flex-1 px-3 py-2 border rounded-lg">
                                    <input type="text" name="certifications_powered_by[]" placeholder="Organisme" value="UEFA" class="flex-1 px-3 py-2 border rounded-lg">
                                    <button type="button" onclick="removeCertificationRow(this)" class="px-3 py-2 bg-red-500 text-white rounded-lg">Remove</button>
                                </div>
                                <div class="flex gap-2 certification-row">
                                    <input type="text" name="certifications_title[]" placeholder="Intitulé" value="Sports Science Diploma" class="flex-1 px-3 py-2 border rounded-lg">
                                    <input type="text" name="certifications_powered_by[]" placeholder="Organisme" value="University of Sports" class="flex-1 px-3 py-2 border rounded-lg">
                                    <button type="button" onclick="removeCertificationRow(this)" class="px-3 py-2 bg-red-500 text-white rounded-lg">Remove</button>
                                </div>
                            </div>
                            <button type="button" onclick="addCertificationRow()" class="px-4 py-2 bg-green-500 text-white rounded-lg">Add Certification</button>
                        </div>
                        
                        <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700">Update Profile</button>
                    </div>
                </form>
            </div>
        </div>
        
        <!-- Reviews Tab -->
        <div id="reviewsTab" class="tab-content hidden">
            <div class="bg-white p-6 rounded-lg shadow">
                <h2 class="text-xl font-bold mb-4">Client Reviews</h2>
                <div id="reviewsList" class="space-y-4"></div>
            </div>
        </div>
    </div>
    
    <!-- Edit Availability Modal -->
    <div id="editAvailabilityModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center p-4">
        <div class="bg-white rounded-lg p-8 max-w-md w-full">
            <h3 class="text-2xl font-bold mb-4">Edit Availability</h3>
            <form method="POST" action="/coach/availability/update.php">
                <input type="hidden" name="availability_id" id="editAvailabilityId">
                
                <div class="mb-4">
                    <label class="block font-medium mb-2">Day of Week</label>
                    <select name="week_day" id="editWeekDay" required class="w-full px-3 py-2 border rounded-lg">
                        <option value="Mon">Monday</option>
                        <option value="Tue">Tuesday</option>
                        <option value="Wed">Wednesday</option>
                        <option value="Thu">Thursday</option>
                        <option value="Fri">Friday</option>
                        <option value="Sat">Saturday</option>
                        <option value="Sun">Sunday</option>
                    </select>
                </div>
                
                <div class="mb-4">
                    <label class="block font-medium mb-2">Start Time</label>
                    <input type="time" name="start_time" id="editStartTime" required class="w-full px-3 py-2 border rounded-lg">
                </div>
                
                <div class="mb-4">
                    <label class="block font-medium mb-2">End Time</label>
                    <input type="time" name="end_time" id="editEndTime" required class="w-full px-3 py-2 border rounded-lg">
                </div>
                
                <div class="flex gap-4">
                    <button type="submit" class="flex-1 bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">Update</button>
                    <button type="button" onclick="closeEditAvailabilityModal()" class="flex-1 bg-gray-300 py-2 rounded-lg hover:bg-gray-400">Cancel</button>
                </div>
            </form>
        </div>
    </div>
    
    <script src="app.js"></script>
    <script>
        // Mock data
        const pendingReservations = [
            { id: 1, client: 'Alice Brown', client_photo: '/placeholder.svg?height=40&width=40', start_date: '2024-02-15 10:00', duree: 60 },
            { id: 2, client: 'Bob Wilson', client_photo: '/placeholder.svg?height=40&width=40', start_date: '2024-02-16 14:00', duree: 90 }
        ];
        
        const confirmedReservations = [
            { id: 3, client: 'Carol Davis', client_photo: '/placeholder.svg?height=40&width=40', start_date: '2024-02-20 09:00', duree: 60 }
        ];
        
        const availabilitySlots = [
            { id: 1, day: 'Mon', start: '09:00', end: '17:00' },
            { id: 2, day: 'Wed', start: '10:00', end: '18:00' },
            { id: 3, day: 'Fri', start: '09:00', end: '15:00' }
        ];
        
        const reviews = [
            { client: 'Alice Brown', date: '2024-01-15', text: 'Excellent coach! Very professional and knowledgeable.' },
            { client: 'Bob Wilson', date: '2024-01-10', text: 'Great experience, highly recommend!' }
        ];
        
        // Tab navigation - green active state
        function showTab(tabName) {
            document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));
            document.querySelectorAll('.tab-btn').forEach(btn => {
                btn.classList.remove('border-green-600', 'text-green-600');
                btn.classList.add('hover:bg-gray-50');
            });
            
            document.getElementById(tabName + 'Tab').classList.remove('hidden');
            event.target.classList.add('border-green-600', 'text-green-600');
            event.target.classList.remove('hover:bg-gray-50');
        }
        
        // Render pending reservations - green button
        const pendingContainer = document.getElementById('pendingReservations');
        pendingReservations.forEach(res => {
            const div = document.createElement('div');
            div.className = 'flex items-center justify-between p-4 border rounded-lg';
            div.innerHTML = `
                <div class="flex items-center gap-4">
                    <img src="${res.client_photo}" alt="${res.client}" class="w-12 h-12 rounded-full">
                    <div>
                        <div class="font-medium">${res.client}</div>
                        <div class="text-sm text-gray-600">${res.start_date} • ${res.duree} min</div>
                    </div>
                </div>
                <div class="flex gap-2">
                    <button onclick="acceptReservation(${res.id})" class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700">Accept</button>
                    <button onclick="refuseReservation(${res.id})" class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700">Refuse</button>
                </div>
            `;
            pendingContainer.appendChild(div);
        });
        
        // Render confirmed reservations
        const confirmedContainer = document.getElementById('confirmedReservations');
        confirmedReservations.forEach(res => {
            const div = document.createElement('div');
            div.className = 'flex items-center gap-4 p-4 border rounded-lg';
            div.innerHTML = `
                <img src="${res.client_photo}" alt="${res.client}" class="w-12 h-12 rounded-full">
                <div>
                    <div class="font-medium">${res.client}</div>
                    <div class="text-sm text-gray-600">${res.start_date} • ${res.duree} min</div>
                </div>
            `;
            confirmedContainer.appendChild(div);
        });
        
        // Render availability table - green links
        const availabilityTable = document.getElementById('availabilityTable');
        availabilitySlots.forEach(slot => {
            const tr = document.createElement('tr');
            tr.className = 'border-b hover:bg-gray-50';
            tr.innerHTML = `
                <td class="px-4 py-3">${slot.day}</td>
                <td class="px-4 py-3">${slot.start}</td>
                <td class="px-4 py-3">${slot.end}</td>
                <td class="px-4 py-3">
                    <button onclick="editAvailability(${slot.id}, '${slot.day}', '${slot.start}', '${slot.end}')" class="text-green-600 hover:underline mr-3">Edit</button>
                    <button onclick="deleteAvailability(${slot.id})" class="text-red-600 hover:underline">Delete</button>
                </td>
            `;
            availabilityTable.appendChild(tr);
        });
        
        // Render reviews
        const reviewsList = document.getElementById('reviewsList');
        reviews.forEach(review => {
            const div = document.createElement('div');
            div.className = 'border-b pb-4';
            div.innerHTML = `
                <div class="font-medium">${review.client}</div>
                <div class="text-sm text-gray-600 mb-2">${review.date}</div>
                <div class="text-gray-700">${review.text}</div>
            `;
            reviewsList.appendChild(div);
        });
        
        // Reservation actions
        function acceptReservation(id) {
            if (confirm('Accept this reservation?')) {
                showToast('Reservation accepted', 'success');
            }
        }
        
        function refuseReservation(id) {
            if (confirm('Refuse this reservation?')) {
                showToast('Reservation refused', 'success');
            }
        }
        
        // Availability actions
        function editAvailability(id, day, start, end) {
            document.getElementById('editAvailabilityId').value = id;
            document.getElementById('editWeekDay').value = day;
            document.getElementById('editStartTime').value = start;
            document.getElementById('editEndTime').value = end;
            document.getElementById('editAvailabilityModal').classList.remove('hidden');
        }
        
        function closeEditAvailabilityModal() {
            document.getElementById('editAvailabilityModal').classList.add('hidden');
        }
        
        function deleteAvailability(id) {
            if (confirm('Delete this availability slot?')) {
                showToast('Availability deleted', 'success');
            }
        }
        
        // Certification management
        function addCertificationRow() {
            const container = document.getElementById('certificationsContainer');
            const row = document.createElement('div');
            row.className = 'flex gap-2 certification-row';
            row.innerHTML = `
                <input type="text" name="certifications_title[]" placeholder="Intitulé" class="flex-1 px-3 py-2 border rounded-lg">
                <input type="text" name="certifications_powered_by[]" placeholder="Organisme" class="flex-1 px-3 py-2 border rounded-lg">
                <button type="button" onclick="removeCertificationRow(this)" class="px-3 py-2 bg-red-500 text-white rounded-lg">Remove</button>
            `;
            container.appendChild(row);
        }
        
        function removeCertificationRow(btn) {
            const container = document.getElementById('certificationsContainer');
            if (container.children.length > 1) {
                btn.closest('.certification-row').remove();
            } else {
                showToast('At least one certification is required', 'error');
            }
        }
    </script>
</body>
</html>
