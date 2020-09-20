<template>

        <v-container fluid>
          <v-row>
            <v-col
              v-for="item in items"
              :key="item"
              class="d-flex child-flex"
              cols="6"
            >
              <ImageCard/>
            </v-col>
          </v-row>
        </v-container>

</template>

<script>
import ImageCard from "@/components/ImageCard";
export default {
  components: {ImageCard},
  data() {
    return {
      items:[
        1,2,3,4
      ]
    }
  }
}
</script>
