<script>
import axios from "axios";

export default {
    data() {
        return {
            messages: [], // Xabarlar ro'yxati
            newMessage: "", // Yangi xabar matni
        };
    },
    methods: {
        // Yangi xabarni serverga yuborish
        async postMessage(text) {
            try {
                const response = await axios.post("/message", { text });
                console.log("Message sent successfully:", response.data);
                this.getMessages(); // Yangi xabarni qo'shish uchun qayta yuklash
            } catch (err) {
                console.error("Error while sending message:", err.response || err.message);
            }
        },
        // Xabarlarni serverdan olish
        async getMessages() {
            try {
                const response = await axios.get("/messages");
                this.messages = response.data;
                console.log("Messages loaded:", this.messages);
                this.scrollToBottom(); // Xabarlarni pastga o'tkazish
            } catch (err) {
                console.error("Error while loading messages:", err.response || err.message);
            }
        },
        // Yangi xabarni yuborish
        sendMessage() {
            if (this.newMessage.trim() !== "") {
                console.log("Sending message:", this.newMessage.trim());
                this.postMessage(this.newMessage.trim());
                this.newMessage = ""; // Maydonni tozalash
            } else {
                console.log("Message is empty");
            }
        },
        // Xabarlar qutisini avtomatik pastga o'tkazish
        scrollToBottom() {
            this.$nextTick(() => {
                const messageList = document.getElementById("messagelist");
                if (messageList) {
                    messageList.scrollTop = messageList.scrollHeight;
                }
            });
        },
    },
    created() {
        // Xabarlarni yuklash
        this.getMessages();

        // Real-time hodisalarni tinglash
        window.Echo.private("channel_for_everyone").listen("GotMessage", (e) => {
            console.log("Real-time event received:", e);
            this.getMessages(); // Hodisadan keyin xabarlarni yangilash
        });
    },
};
</script>

<template>
    <div class="container chat-container">
        <div class="chat-box" id="messagelist">
            <div v-for="(message, index) in messages" :key="index" class="message">
                <div class="message-header">
                    <strong>{{ message.user.name }}</strong>
                    <small class="text-muted">{{ message.time }}</small>
                </div>
                <p class="message-text">{{ message.text }}</p>
            </div>
        </div>
        <div class="input-area">
            <input
                v-model="newMessage"
                @keyup.enter="sendMessage"
                type="text"
                placeholder="Type your message here..."
                class="message-input"
            />
            <button @click="sendMessage" class="send-button">Send</button>
        </div>
    </div>
</template>

<style scoped>
.container {
    display: flex;
    flex-direction: column;
    max-width: 600px;
    margin: 0 auto;
    border: 1px solid #ddd;
    border-radius: 8px;
    background: #f9f9f9;
    overflow: hidden;
}

.chat-box {
    flex: 1;
    padding: 10px;
    max-height: 400px;
    overflow-y: auto;
    background: #fff;
}

.message {
    padding: 8px;
    border-bottom: 1px solid #eee;
}

.message:last-child {
    border-bottom: none;
}

.message-header {
    display: flex;
    justify-content: space-between;
    font-size: 0.9rem;
    color: #555;
}

.message-text {
    margin: 5px 0 0;
    font-size: 1rem;
    color: #333;
}

.input-area {
    display: flex;
    padding: 10px;
    border-top: 1px solid #ddd;
    background: #fafafa;    
}

.message-input {
    flex: 1;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    font-size: 1rem;
}

.message-input:focus {
    outline: none;
    border-color: #007bff;
}

.send-button {
    margin-left: 10px;
    padding: 10px 20px;
    font-size: 1rem;
    background: #007bff;
    color: #fff;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.send-button:hover {
    background: #0056b3;
}
</style>
