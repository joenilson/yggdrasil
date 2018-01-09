<template>
<div class="tile is-parent is-6">
  <div class="tile is-child box">
    <div class="card">
      <header class="card-header">
        <p class="card-header-title">
          Mapa
        </p>
        <a href="#" class="card-header-icon" aria-label="more options">
                    <span class="icon">
                        <i class="fa fa-angle-down" aria-hidden="true"></i>
                    </span>
                </a>
      </header>
      <div class="card-content">
        <div class="content" id="map-content">

        </div>
      </div>
      <footer class="card-footer">
        <template>
        <a v-for="map in this.mapList" class="card-footer-item" @click="showMap(map.code)">{{map.description}}</a>
      </template>
      </footer>
    </div>
  </div>
</div>
</template>
<script>
import * as DatamapDom from './../../vendors/datamaps/datamaps.dom'
import * as DatamapEsp from './../../vendors/datamaps/datamaps.esp'
import * as DatamapPer from './../../vendors/datamaps/datamaps.per'
let map;
export default {
  name: 'dashboard-map',
  data: function() {
    return {
      mapList: [{'code':'esp','description':'España'},{'code':'dom','description':'República Dominicana'},{'code':'per','description':'Perú'}],
      mapCode: 'dom'
    }
  },
  methods: {
    handleWindowResize(event) {
      this.windowWidth = event.currentTarget.innerWidth;
      this.map.resize();
    },
    showMap(mapCode) {
      this.mapCode = mapCode;
      var map_div = document.getElementById('map-content');
      if(map_div.firstChild){
        map_div.removeChild(map_div.firstChild);
        map_div.removeChild(map_div.lastChild);
      }
      var Datamap = DatamapDom;
      var map_center = [-70.41667, 18.93333];
      if(mapCode === 'esp') {
        Datamap = DatamapEsp;
        map_center = [-3.7025600,40.4165000];
      }
      if(mapCode === 'per') {
        Datamap = DatamapPer;
        map_center = [-76.0000000,-10.0000000];
      }
      this.map = new Datamap({
        scope: mapCode,
        element: document.getElementById('map-content'),
        responsive: true,
        fills: {
          defaultFill: 'rgba(23,48,210,0.9)'
        },
        setProjection: function(element, options) {
          var projection, path;
          projection = d3.geo.equirectangular()
            .center(map_center)
            .scale(element.offsetWidth * 1.5)
            .translate([element.offsetWidth / 2, element.offsetHeight / 2]);
          path = d3.geo.path()
            .projection(projection);
          return {
            path: path,
            projection: projection
          };
        }
      });
      return map;
    }
  },
  beforeDestroy: function () {
    window.removeEventListener('resize', this. handleWindowResize)
  },
  mounted() {
    window.addEventListener('resize', this.handleWindowResize);
    this.showMap(this.mapCode);
  },
  computed: {

  }
}
</script>
