import './bootstrap';
import { createApp } from 'vue';
import TextBox from './components/TextBox/index.vue';
import MessageBubble from './components/MessageBubble/index.vue';

// Create Vue app
const app = createApp({});

// Register components globally
app.component('TextBox', TextBox);
app.component('MessageBubble', MessageBubble);

// Mount the app to elements with the class 'vue-app'
document.addEventListener('DOMContentLoaded', function() {
    const vueElements = document.querySelectorAll('.vue-app');
    
    vueElements.forEach(element => {
        const vueApp = createApp({
            components: {
                TextBox,
                MessageBubble
            }
        });
        vueApp.mount(element);
    });

    // Also mount a global app for the textbox if element exists
    const textboxElement = document.getElementById('textbox-app');
    if (textboxElement) {
        const textboxApp = createApp({
            components: {
                TextBox,
                MessageBubble
            },
            mounted() {
                // Set up global variables for the TextBox component
                window.Laravel = window.Laravel || {};
                
                // Set current user info for messaging
                const userElement = document.querySelector('meta[name="current-user"]');
                const studentElement = document.querySelector('meta[name="current-student"]');
                
                if (studentElement) {
                    window.Laravel.currentStudentIc = studentElement.getAttribute('content');
                    window.Laravel.sessionUserId = 'STUDENT';
                } else if (userElement) {
                    window.Laravel.currentUserIc = userElement.getAttribute('content');
                    const userTypeElement = document.querySelector('meta[name="user-type"]');
                    window.Laravel.sessionUserId = userTypeElement ? userTypeElement.getAttribute('content') : 'USER';
                }
            }
        });
        textboxApp.mount(textboxElement);
    }
});
