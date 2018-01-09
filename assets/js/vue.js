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
import Vue from 'vue'

import Buefy from 'buefy'
import Cleave from 'cleave.js'
import * as Datamaps from './../vendors/datamaps/datamaps.dom'
import Bulma from './../vendors/bulmajs/src/bulma'
import DashboardArticle from './components/dashboardArticle.vue'
import DashboardMap from './components/dashboardMap.vue'
import DashboardLory from './components/dashboardLory.vue'

Vue.config.productionTip = false
Vue.use(Buefy, {
  defaultIconPack: 'fa'
})

// bootstrap the vueApp
let yggdrasil = new Vue({
  delimiters: ['${', '}'],
  el: '#vueApp',
  components: {
    DashboardArticle,
    DashboardMap,
    DashboardLory
  }
})
