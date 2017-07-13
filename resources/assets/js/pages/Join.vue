<template>
    <div id="page-join" class="content-wrapper">
        <region-map @click="addRegion"></region-map>
    </div>
</template>

<script>
    import RegionMap from "../components/RegionMap.vue";

    export default {
        components: {
            RegionMap
        },
        data () {
            return {}
        },
        methods: {
            addRegion (event) {
                console.log(event.feature.getProperty("name"));
            }
        }
    }
</script>
