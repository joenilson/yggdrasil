<template>
<div class="tile is-parent is-9">
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
        <a map_country="esp" href="#" class="card-footer-item" @click="showMap">España</a>
        <a map_country="dom" href="#" class="card-footer-item" @click="showMap">República Dominicana</a>
        <a map_country="per" href="#" class="card-footer-item" @click="showMap">Perú</a>
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
  props: {
    map_country: String
  },
  methods: {
    handleWindowResize(event) {
      this.windowWidth = event.currentTarget.innerWidth;
      this.map.resize();
    },
    showMap() {
      console.log(this.map_country);
      var map_div = document.getElementById('map-content');
      if(map_div.firstChild){
        map_div.removeChild(map_div.firstChild);
        map_div.removeChild(map_div.lastChild);
      }
      var Datamap = DatamapDom;
      var map_center = [-70.41667, 18.93333];
      if(this.map_country === 'esp') {
        Datamap = DatamapEsp;
        map_center = [-3.7025600,40.4165000];
      }
      if(this.map_country === 'per') {
        Datamap = DatamapPer;
        map_center = [-76.0000000,-10.0000000];
      }
      this.map = new Datamap({
        scope: this.map_country,
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
    this.showMap();
  },
  computed: {

  }
}
</script>
