<template>
    <div id="region-map"></div>
</template>

<script>
    export default {
        props: ["zoom", "lat", "lng"],
        mounted () {
            let map = new google.maps.Map(document.getElementById("region-map"), {
                center: new google.maps.LatLng(this.lat || 23, this.lng || 113.5),
                zoom: this.zoom || 9,
                mapTypeId: "roadmap"
            });

            map.data.loadGeoJson("/region.geojson");

            map.data.setStyle(feature => {
                let color = feature.getProperty('color');
                return {
                    fillColor: color,
                    strokeColor: color,
                    strokeWeight: 2
                };
            });

            map.data.addListener("mouseover", event => {
                map.data.revertStyle();
                map.data.overrideStyle(event.feature, {
                    strokeColor: "white",
                    strokeWeight: 3,
                    zIndex: google.maps.Marker.MAX_ZINDEX
                });
            });
            map.data.addListener("mouseout", event => {
                map.data.revertStyle();
            });

            map.data.addListener("click", event => {
                this.$emit('click', event);
            });
        }
    }
</script>

<style lang="scss">
    #region-map {
        min-height: 600px;
    }
</style>
