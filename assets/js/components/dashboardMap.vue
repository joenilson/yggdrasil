<template>
    <div class="tile is-parent is-12">
        <div class="tile is-child box">
            <div class="card">
                <header class="card-header">
                    <p class="card-header-title">
                        Component
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
</div>
</template>
<script>
    import d3 from 'd3';
    import * as Datamaps from 'Datamaps';
    export default {
        name: 'dashboard-map',
        props: {
            map: String
        },
        computed: {
            showMap() {
                let map = new Datamap({
                    element: document.getElementById('map-container'),
                    geographyConfig: {
                        dataUrl: './../../datamaps/dom.topo.json'
                    },
                    scope: 'dom',
                    setProjection: function (element, options) {
                        var projection, path;
                        projection = d3.geo.albersUsa()
                                .center([long, lat])
                                .scale(element.offsetWidth)
                                .translate([element.offsetWidth / 2, element.offsetHeight / 2]);
                        path = d3.geo.path()
                                .projection(projection);

                        return {path: path, projection: projection};
                    }
                });
                return map;
            }
        }
    }
</script>