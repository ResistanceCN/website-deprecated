<template>
    <div id="region-map-container">
        <div id="region-map"></div>
        <div id="region-map-hint" v-show="hint" :style="{ left: hintLeft }">{{ hint }}</div>
    </div>
</template>

<script>
    import _ from "lodash";

    export default {
        props: ["zoom", "lat", "lng", "geojson"],
        data () {
            return {
                hint: "",
                hintLeft: "120px"
            }
        },
        mounted () {
            if (!window.google) {
                console.error("Google Maps SDK not loaded");
                return
            }

            let map = new google.maps.Map(document.getElementById("region-map"), {
                center: new google.maps.LatLng(this.lat || 23, this.lng || 113.5),
                zoom: this.zoom || 9,
                mapTypeId: "roadmap"
            });

            map.data.addGeoJson(this.geojson || {});

            map.data.setStyle(feature => {
                let color = feature.getProperty("color");
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

                this.setHint(event.feature.getProperty("name"));
            });
            map.data.addListener("mouseout", event => {
                map.data.revertStyle();

                this.hint = "";
            });

            map.data.addListener("click", event => {
                this.$emit("select", event);
            });
        },
        methods: {
            setHint (hint) {
                this.hint = hint;

                let print = document.querySelector(".gmnoprint");

                if (_.isElement(print))
                    this.hintLeft = print.offsetWidth;
            }
        }
    }
</script>

<style lang="scss">
    #region-map-container {
        position: relative;

        #region-map {
            min-height: 80vh;
        }

        #region-map-hint {
            background: #ffffff;
            padding: 8px;
            font-size: 11px;
            line-height: 14px;
            position: absolute;
            top: 10px;
            border-radius: 2px;
            box-shadow: rgba(0, 0, 0, 0.3) 0 1px 4px -1px;
        }
    }
</style>
