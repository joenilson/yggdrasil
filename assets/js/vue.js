/*
 * Copyright (C) 2018 Joe Nilson <joenilson at gmail.com>
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Lesser General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program.  If not, see <http://www.gnu.org/licenses/>.
 */
import Vue from 'vue';
//import VueRouter from 'vue-router';
//import router from './router/';
import Buefy from 'buefy';
import Cleave from 'cleave.js';
/// application specific
import Bulma from './../vendors/bulmajs/dist/bulma';
import App from './App.vue';

Vue.config.productionTip = false;
Vue.use(Buefy, {
    //defaultIconPack: 'fa',
});
//Vue.use(VueRouter);

// bootstrap the vueApp
let yggdrasil = new Vue({
  el: '#vueApp',
  data: {
        tableData: [
            {"id":1,"user":{"first_name":"Jesse","last_name":"Simmons"},"date":"2016-10-15 13:43:27","gender":"Male"},
            {"id":2,"user":{"first_name":"John","last_name":"Jacobs"},"date":"2016-12-15 06:00:53","gender":"Male"},
            {"id":3,"user":{"first_name":"Tina","last_name":"Gilbert"},"date":"2016-04-26 06:26:28","gender":"Female"},
            {"id":4,"user":{"first_name":"Clarence","last_name":"Flores"},"date":"2016-04-10 10:28:46","gender":"Male"},
            {"id":5,"user":{"first_name":"Anne","last_name":"Lee"},"date":"2016-12-06 14:38:38","gender":"Female"},
            {"id":6,"user":{"first_name":"Sara","last_name":"Armstrong"},"date":"2016-09-23 18:50:04","gender":"Female"},
            {"id":7,"user":{"first_name":"Anthony","last_name":"Webb"},"date":"2016-08-30 23:49:38","gender":"Male"},
            {"id":8,"user":{"first_name":"Andrew","last_name":"Greene"},"date":"2016-11-20 14:57:47","gender":"Male"},
            {"id":9,"user":{"first_name":"Russell","last_name":"White"},"date":"2016-07-13 09:29:49","gender":"Male"},
            {"id":10,"user":{"first_name":"Lori","last_name":"Hunter"},"date":"2016-12-09 01:44:05","gender":"Female"}
        ]
    }
  //,template: '<App/>',
  //components: { App }
});