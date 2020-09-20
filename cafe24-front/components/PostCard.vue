<template>
  <v-card
    class="mx-auto my-12"
    max-width="1000"
  >
    <v-card-title>title</v-card-title>

    <v-card-text>
      <div class="my-4 subtitle-1">
        $ • Italian, Cafe
      </div>

      <div>Small plates, salads & sandwiches - an intimate setting with 12 indoor seats plus patio seating.</div>
    </v-card-text>

    <v-divider class="mx-4"></v-divider>

    <v-card-title>Tonight's availability</v-card-title>

    <v-card-text>
      <v-chip-group
        v-model="selection"
        active-class="deep-purple accent-4 white--text"
        column
      >
        <v-chip>5:30PM</v-chip>

        <v-chip>7:30PM</v-chip>

        <v-chip>8:00PM</v-chip>

        <v-chip>9:00PM</v-chip>
      </v-chip-group>
    </v-card-text>

    <v-card-actions>
      <v-btn
        color="deep-purple lighten-2"
        text
        @click="reserve"
      >
        Reserve
      </v-btn>
    </v-card-actions>
  </v-card>
</template>

<script>
// import axios from 'axios'
//
// export default {
//   data: () => ({
//     post:[],
//   }),
//
//   created() {
//     axios.get("/api/post/1")
//     .then(response => this.post = response.data)
//     .catch()
//   },
//
//   methods: {
//     reserve () {
//       this.loading = true
//       setTimeout(() => (this.loading = false), 2000)
//     },
//   },
// }
</script>
