// Initialize AOS animation library
AOS.init();

// Toggle chatbot visibility
function toggleChatbot() {
  const chatbot = document.getElementById("chatbot-container");
  chatbot.style.display = chatbot.style.display === "block" ? "none" : "block";
}
