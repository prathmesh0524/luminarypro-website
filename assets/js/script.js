document.addEventListener("DOMContentLoaded", () => {
  const chatbotBtn = document.getElementById("chatbot-icon");
  const chatbotContainer = document.getElementById("chatbot-container");

  chatbotBtn.addEventListener("click", () => {
    chatbotContainer.style.display =
      chatbotContainer.style.display === "block" ? "none" : "block";
  });
});
