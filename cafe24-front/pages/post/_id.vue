<template>
  <v-card
    class="mx-auto"
    color="#26c6da"
    dark
    max-width="700"
    style="margin-bottom: 20px"
  >
    <v-card-title>
      <span class="title font-weight-light">{{ $store.state.post.title }}</span>
      <v-spacer/>
      <v-dialog v-model="dialog1" max-width="500px">
        <template v-slot:activator="{ on, attrs }">
          <v-icon v-bind="attrs" v-on="on" v-if="me.id===$store.state.post.user.id" class="mr-1">mdi-pencil</v-icon>
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
              ></v-textarea>
            </v-form>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="onSubmit">OK</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog v-model="dialog2" max-width="500px">
        <template v-slot:activator="{ on, attrs }">
          <v-icon v-bind="attrs" v-on="on" v-if="me.id===$store.state.post.user.id" class="mr-1">mdi-delete</v-icon>
        </template>
        <v-card>
          <v-card-title>
            <span class="headline">Are you sure you want to delete?</span>
          </v-card-title>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="onDelete">YES</v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
    </v-card-title>

    <v-card-text class="headline font-weight-bold">
      {{ $store.state.post.content }}
    </v-card-text>

    <v-card-actions>
      <v-list-item class="grow">
        <v-list-item-avatar color="grey darken-3">
          <v-img
            class="elevation-6"
            src="https://avataaars.io/?avatarStyle=Transparent&topType=ShortHairShortCurly&accessoriesType=Prescription02&hairColor=Black&facialHairType=Blank&clotheType=Hoodie&clotheColor=White&eyeType=Default&eyebrowType=DefaultNatural&mouthType=Default&skinColor=Light"
          ></v-img>
        </v-list-item-avatar>

        <v-list-item-content>
          <v-list-item-title>{{ $store.state.post.user.name }}</v-list-item-title>
        </v-list-item-content>

        <v-row
          align="center"
          justify="end"
        >
          <span class="subheading mr-2">{{ $store.state.post.created_at.substring(0,10) }}</span>
          <span class="subheading mr-2">{{ $store.state.post.created_at.substring(11,16) }}</span>
          <v-icon class="mr-1">mdi-share-variant</v-icon>
          <span class="subheading">{{ $store.state.post.hits }}</span>
        </v-row>
      </v-list-item>
    </v-card-actions>
  </v-card>
</template>

<script>

export default {
  name:"_id",
  data: () => ({
    valid: false,
    dialog1: false,
    dialog2: false,
    post:{},
    title:'',
    content:'',
  }),

  computed: {
    me() {
      return this.$store.state.me;
    },
    LoadPosts() {
      return this.$store.state.post;
    },
    formTitle () {
      return 'Edit Talk'
    },
    title:{
      get () {
        return this.$store.state.post.title
      },
      set (value) {
        this.$store.commit('editTitle', value)
      }
    }
  },

  watch: {
    dialog1 (val) {
      val || this.close1()
    },
    dialog2 (val) {
      val || this.close2()
    },
  },

  methods: {
    close1 () {
      this.dialog1 = false
    },
    close2 () {
      this.dialog2 = false
    },

    onClick (value) {
      console.log(value.id)
      this.$router.push(`/post/${ value.id }`)
    },

    async onSubmit() {
      await this.$store.dispatch('edit', {
        title: this.title,
        content: this.content,
        id:this.$route.params.id
      });
      await this.close1()
    },
    async onDelete() {
      await this.$store.dispatch('remove', {
        id:this.$route.params.id
      });
      await this.close2()
      await this.$router.push(`/post`)
    }
  },
}
</script>

<style scoped>

</style>
