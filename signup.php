<?php
require_once 'config/db.php';
$whatiwant = null;
if($_SERVER['REQUEST_METHOD']=="POST"){
    $nom = $_POST['nom'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'],PASSWORD_DEFAULT) ;
    $phone = $_POST['phone'];
    $role = $_POST['role'];

    $whatiwant=['nom','email','password','phone','role'];
    if(!empty($role) && $role==='coach'){
        $exp_years = $_POST['exp_years'];
        $bio = $_POST['bio'];
        $pic_url = $_POST['pic_url'];
        $niveau = $_POST['niveau'];
        array_push($whatiwant,'exp_years','bio','pic_url','niveau');
    }
}
if($dt = checkMe($whatiwant)){
    $dt['password']=password_hash($dt['password'],PASSWORD_DEFAULT);
}
    if ($dt['role']==='client'){
        $query = "insert into user(nom,email,password,phone,role) VALUES ('$dt['nom']')
    }
}
function checkMe(array $what){
    $data=[];
    foreach ($what as $key ){
        if (!isset($_POST[$key]) || trim($_POST[$key]) === '') {
            return false;
        }
        $data[$key] = trim($_POST[$key]);
    }

    return $data;
}


?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - CoachPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-2xl bg-white p-8 rounded-lg shadow">
            <!-- Logo linking to index.html -->
            <a href="index.php" class="block text-2xl font-bold text-green-600 text-center mb-6">CoachPro</a>
            <h2 class="text-2xl font-bold mb-6">Inscription</h2>
            <form id="signupForm" method="POST" action="login.php">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Nom</label>
                        <!-- green focus ring -->
                        <input type="text" name="nom" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500">
                        <span class="text-red-500 text-sm hidden error-nom"></span>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-1">Email</label>
                        <input type="email" name="email" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500">
                        <span class="text-red-500 text-sm hidden error-email"></span>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-1">Mot de passe</label>
                        <input type="password" name="password" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500">
                        <span class="text-red-500 text-sm hidden error-password"></span>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-1">Téléphone</label>
                        <input type="tel" name="phone" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500">
                        <span class="text-red-500 text-sm hidden error-phone"></span>
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-1">Je suis un</label>
                        <select name="role" id="roleSelect" class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500">
                            <option value="client">Client/Sportif</option>
                            <option value="coach">Coach</option>
                        </select>
                    </div>
                    
                    <!-- Coach-only fields - green background -->
                    <div id="coachFields" class="hidden space-y-4 p-4 bg-green-50 rounded-lg">
                        <h3 class="font-medium">Informations Coach</h3>
                        
                        <div>
                            <label class="block text-sm font-medium mb-1">Années d'expérience</label>
                            <input type="number" name="exp_years" min="0" class="w-full px-3 py-2 border rounded-lg">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-1">Bio (max 500 caractères)</label>
                            <textarea name="bio" maxlength="500" rows="3" class="w-full px-3 py-2 border rounded-lg"></textarea>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-1">URL Photo de profil</label>
                            <input type="text" name="pic_url" class="w-full px-3 py-2 border rounded-lg">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-1">Niveau</label>
                            <select name="niveau" class="w-full px-3 py-2 border rounded-lg">
                                <option value="">Sélectionner un niveau</option>
                                <option value="Beginner">Débutant</option>
                                <option value="Intermediate">Intermédiaire</option>
                                <option value="Advanced">Avancé</option>
                                <option value="Pro">Pro</option>
                            </select>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-1">Sports (sélectionner au moins un)</label>
                            <div class="space-y-2">
                                <label class="flex items-center"><input type="checkbox" name="sports[]" value="1" class="mr-2"> Football</label>
                                <label class="flex items-center"><input type="checkbox" name="sports[]" value="2" class="mr-2"> Basketball</label>
                                <label class="flex items-center"><input type="checkbox" name="sports[]" value="3" class="mr-2"> Tennis</label>
                                <label class="flex items-center"><input type="checkbox" name="sports[]" value="4" class="mr-2"> Natation</label>
                            </div>
                            <span class="text-red-500 text-sm hidden error-sports"></span>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium mb-1">Certifications</label>
                            <div id="certificationsContainer" class="space-y-2">
                                <div class="flex gap-2 certification-row">
                                    <input type="text" name="certifications_title[]" placeholder="Intitulé" class="flex-1 px-3 py-2 border rounded-lg">
                                    <input type="text" name="certifications_powered_by[]" placeholder="Organisme" class="flex-1 px-3 py-2 border rounded-lg">
                                    <button type="button" onclick="removeCertification(this)" class="px-3 py-2 bg-red-500 text-white rounded-lg">Supprimer</button>
                                </div>
                            </div>
                            <button type="button" onclick="addCertification()" class="mt-2 px-4 py-2 bg-green-500 text-white rounded-lg">Ajouter une certification</button>
                        </div>
                    </div>
                    
                    <!-- green button -->
                    <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">S'inscrire</button>
                    
                    <div class="text-center mt-4 text-sm text-gray-600">
                        Déjà inscrit? <a href="login.php" class="text-green-600 hover:underline font-medium">Connectez-vous</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <script src="app.js"></script>
    <script>
        // Role toggle logic
        document.getElementById('roleSelect').addEventListener('change', function() {
            const coachFields = document.getElementById('coachFields');
            if (this.value === 'coach') {
                coachFields.classList.remove('hidden');
            } else {
                coachFields.classList.add('hidden');
                coachFields.querySelectorAll('input, select, textarea').forEach(input => {
                    if (input.type === 'checkbox') input.checked = false;
                    else input.value = '';
                });
            }
        });
        
        // Certification management
        function addCertification() {
            const container = document.getElementById('certificationsContainer');
            const row = document.createElement('div');
            row.className = 'flex gap-2 certification-row';
            row.innerHTML = `
                <input type="text" name="certifications_title[]" placeholder="Intitulé" class="flex-1 px-3 py-2 border rounded-lg">
                <input type="text" name="certifications_powered_by[]" placeholder="Organisme" class="flex-1 px-3 py-2 border rounded-lg">
                <button type="button" onclick="removeCertification(this)" class="px-3 py-2 bg-red-500 text-white rounded-lg">Supprimer</button>
            `;
            container.appendChild(row);
        }
        
        function removeCertification(btn) {
            const container = document.getElementById('certificationsContainer');
            if (container.children.length > 1) {
                btn.closest('.certification-row').remove();
            } else {
                showToast('Au moins une certification est requise', 'error');
            }
        }
        
        // Signup validation
        document.getElementById('signupForm').addEventListener('submit', function(e) {
            e.preventDefault();
            let valid = true;
            
            // Hide all errors
            document.querySelectorAll('[class^="error-"]').forEach(el => el.classList.add('hidden'));
            
            // Validate email
            const email = this.email.value;
            if (!isValidEmail(email)) {
                showError('error-email', 'Format email invalide');
                valid = false;
            }
            
            // Validate password
            const password = this.password.value;
            if (!isValidPassword(password)) {
                showError('error-password', 'Le mot de passe doit contenir au moins 6 caractères avec lettres et chiffres');
                valid = false;
            }
            
            // Validate phone
            const phone = this.phone.value;
            if (!isValidPhone(phone)) {
                showError('error-phone', 'Numéro de téléphone invalide');
                valid = false;
            }
            
            // Coach-specific validation
            if (this.role.value === 'coach') {
                const sports = this.querySelectorAll('input[name="sports[]"]:checked');
                if (sports.length === 0) {
                    showError('error-sports', 'Sélectionnez au moins un sport');
                    valid = false;
                }
            }
            
            if (valid) {
                showToast('Inscription réussie!', 'success');
                // this.submit(); // Uncomment when backend is ready
            }
        });
        
        function showError(className, message) {
            const el = document.querySelector('.' + className);
            el.textContent = message;
            el.classList.remove('hidden');
        }
    </script>
</body>
</html>
