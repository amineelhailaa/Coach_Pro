<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion - CoachPro</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50">
    <div class="min-h-screen flex items-center justify-center p-4">
        <div class="w-full max-w-md bg-white p-8 rounded-lg shadow">
            <!-- Logo linking to index.html -->
            <a href="index.php" class="block text-2xl font-bold text-green-600 text-center mb-6">CoachPro</a>
            <h2 class="text-2xl font-bold mb-6">Connexion</h2>
            <form id="loginForm" method="POST" action="/login.php">
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium mb-1">Email</label>
                        <!-- green focus ring -->
                        <input type="email" name="email" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500">
                    </div>
                    
                    <div>
                        <label class="block text-sm font-medium mb-1">Mot de passe</label>
                        <input type="password" name="password" required class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-green-500">
                    </div>
                    
                    <div class="flex items-center">
                        <input type="checkbox" name="remember" id="remember" class="mr-2">
                        <label for="remember" class="text-sm">Se souvenir de moi</label>
                    </div>
                    
                    <!-- green button -->
                    <button type="submit" class="w-full bg-green-600 text-white py-2 rounded-lg hover:bg-green-700">Se connecter</button>
                    
                    <a href="#" class="block text-center text-sm text-green-600">Mot de passe oublié?</a>
                    
                    <div class="text-center mt-4 text-sm text-gray-600">
                        Pas encore de compte? <a href="signup.php" class="text-green-600 hover:underline font-medium">Inscrivez-vous</a>
                    </div>
                </div>
            </form>
        </div>
    </div>
    
    <script src="app.js"></script>
</body>
</html>
