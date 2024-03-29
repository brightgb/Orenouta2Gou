
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */
import Vue from 'vue'
import Croppa from 'vue-croppa'
import 'vue-croppa/dist/vue-croppa.css'

require('./bootstrap');

window.Vue = require('vue');
window.Vue.use(Croppa);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('example-component', require('./components/ExampleComponent.vue'));

const app = new Vue({
    el: '#app',
    data: {
        croppa1: null,
        imgUrl: ''
    },
    methods: {
        generateImage: function() {

            let url = this.croppa1.generateDataUrl();
            if (!url) {
                alert('no image');
                return
            }
            this.imgUrl = url
            console.log(this.imgUrl);
        },
        uploadImage: function() {
            console.log('アップロード処理');
            console.log(this.imgUrl);
        }
    }
});
