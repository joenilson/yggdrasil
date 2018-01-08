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
        <a href="#" class="card-footer-item">Save</a>
        <a href="#" class="card-footer-item">Edit</a>
        <a href="#" class="card-footer-item">Delete</a>
      </footer>
    </div>
  </div>
</div>
</template>
<script>
import * as Datamap from './../../vendors/datamaps/datamaps.dom'
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
      var map_div = document.getElementById('map-content');
      if(map_div.firstChild){
        map_div.removeChild(map_div.firstChild);
      }
      this.map = new Datamap({
        scope: 'dom',
        element: document.getElementById('map-content'),
        responsive: true,
        fills: {
          defaultFill: 'rgba(23,48,210,0.9)'
        },
        setProjection: function(element, options) {
          var projection, path;
          projection = d3.geo.equirectangular()
            .center([-70.41667, 18.93333])
            .scale(element.offsetWidth * 10)
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
