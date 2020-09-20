<template>
  <v-data-table
    :headers="headers"
    :items="$store.state.posts"
    class="elevation-1"
    @click:row="onClick"
    cl
  >
    <template v-slot:top>
      <v-toolbar flat color="white">
        <v-toolbar-title>TALK</v-toolbar-title>
        <v-divider
          class="mx-4"
          inset
          vertical
        ></v-divider>
        <v-spacer></v-spacer>
        <v-dialog v-model="dialog" max-width="500px">
          <template v-slot:activator="{ on, attrs }">
            <v-btn
              color="primary"
              dark
              class="mb-2"
              v-bind="attrs"
              v-on="on"
            >NEW TALK
            </v-btn>
          </template>
          <v-card>
            <v-card-title>
              <span class="headline">{{ formTitle }}</span>
            </v-card-title>

            <v-card-text>
              <v-form v-model="valid" style="margin: 10px">
                <v-text-field
                  v-model="title"
                  label="Title"
                  required
                />
                <v-textarea
                  v-model="content"
                  outlined
                  name="input-7-4"
                  label="Content"
                  value=""
                ></v-textarea>
              </v-form>
            </v-card-text>
            <v-card-actions>
              <v-spacer></v-spacer>
              <v-btn color="blue darken-1" text @click="onSubmit">OK</v-btn>
            </v-card-actions>
          </v-card>
        </v-dialog>
      </v-toolbar>
    </template>
  </v-data-table>
</template>

<script>
export default {
  data: () => ({
    valid: false,
    dialog: false,
    headers: [
      { text: 'No', value: 'id',align: 'start', sortable: false },
      { text: 'Title', value: 'title',align: 'start', sortable: false },
      { sortable: false },
      { text: 'Author', value: 'user.name',align: 'start', sortable: false },
      { text: 'Date', value: 'created_at',align: 'start', sortable: false },
      { text: 'Hit', value: 'hits', sortable: false },
    ],
    title:'',
    content:'',
  }),

  computed: {
    me() {
      return this.$store.state.me;
    },
    LoadPosts() {
      return this.$store.state.posts;
    },
    formTitle () {
      return 'New Talk'
    },
  },

  fetch({ store }) {
    store.dispatch('loadPosts');
  },

  watch: {
    dialog (val) {
      val || this.close()
    },
  },

  methods: {
    close () {
      this.dialog = false
      this.$nextTick(() => {
        this.$store.dispatch('loadPosts');
      })
      console.log('hi')
    },

    onClick (value) {
      console.log(value.id)
      this.$store.dispatch('loadPost', {
        id: value.id,
      });
      this.$router.push(`/post/${ value.id }`)
    },

    async onSubmit() {
      await this.$store.dispatch('add', {
        title: this.title,
        content: this.content,
      });
      await this.close()
    }
  },
}
</script>
