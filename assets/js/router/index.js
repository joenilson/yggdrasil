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
import Router from 'vue-router';
Vue.use(Router);

// components
import Home from '../components/Home';
import Hello from '../components/Hello';
import Notfound from '../components/Notfound';
import Demo from '../components/Demo';

export default new Router({
  mode: 'history',
  routes: [
    {
      path: '/',
      name: 'homepage',
      component: Home
    },
    {
      path: '*',
      name: 'notfound',
      component: Notfound
    },
    {
      path: '/hello',
      name: 'Hello',
      component: Hello
    },
    {
      path: '/demo',
      name: 'demo',
      component: Demo
    }
  ]
});
