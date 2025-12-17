// Global utility functions for CoachPro

// Toast notification function
function showToast(message, type = "info") {
  const toast = document.createElement("div")
  toast.className = `fixed top-4 right-4 px-6 py-3 rounded-lg shadow-lg text-white z-50 ${
    type === "success"
      ? "bg-green-600"
      : type === "error"
        ? "bg-red-600"
        : type === "warning"
          ? "bg-yellow-600"
          : "bg-blue-600"
  }`
  toast.textContent = message

  document.body.appendChild(toast)

  setTimeout(() => {
    toast.style.opacity = "0"
    toast.style.transition = "opacity 0.3s"
    setTimeout(() => toast.remove(), 300)
  }, 3000)
}

// Email validation regex
function isValidEmail(email) {
  const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/
  return regex.test(email)
}

// Phone validation regex
function isValidPhone(phone) {
  const regex = /^[0-9]{10,}$/
  return regex.test(phone.replace(/\s/g, ""))
}

// Password validation (min 6 chars, at least 1 letter and 1 number)
function isValidPassword(password) {
  return password.length >= 6 && /[a-zA-Z]/.test(password) && /[0-9]/.test(password)
}

// Format date for display
function formatDate(dateString) {
  const date = new Date(dateString)
  return date.toLocaleDateString() + " " + date.toLocaleTimeString([], { hour: "2-digit", minute: "2-digit" })
}

// Confirm action with custom message
function confirmAction(message) {
  return confirm(message)
}

// Debug log (can be disabled in production)
function debugLog(message, data) {
  if (window.location.hostname === "localhost") {
    console.log(`[CoachPro] ${message}`, data || "")
  }
}

// Initialize app
document.addEventListener("DOMContentLoaded", () => {
  debugLog("CoachPro app initialized")
})
